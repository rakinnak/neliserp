<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Person;
use App\Partner;
use App\Filters\PartnerFilter;
use App\Http\Requests\PartnerRequest;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\PartnerCollection;

class PartnerApi extends ApiController
{
    public function index(PartnerFilter $filter, $role)
    {
        $this->authorize('index', Partner::class);

        // TODO: per_page handling
        $per_page = request('per_page');

        if (! $per_page) {
            $per_page = 10;
        }

        $partners = Partner::filter($filter)
            ->where("is_{$role}", true)
            ->paginate($per_page); // TODO: per page configuration

        return PartnerResource::collection($partners);
    }

    public function show($role, Partner $partner)
    {
        $this->authorize('show', $partner);

        return new PartnerResource($partner);
    }

    public function store($role, PartnerRequest $request)
    {
        $this->authorize('create', Partner::class);

        switch ($request['subject']) {
            case 'company':
                $subject = Company::create([
                    'code' => $request['code'],
                    'name' => $request['name'],
                ]);

                $subject_type = 'App\Company';
                $subject_name = $subject->name;
                break;

            case 'person':
                $subject = Person::create([
                    'code' => $request['code'],
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                ]);

                $subject_type = 'App\Person';
                $subject_name = "{$subject->first_name} {$subject->last_name}";
                break;

            default:
                abort(422);
        }

        $created = Partner::create([
            'subject_type' => $subject_type,
            'subject_id' => $subject->id,
            'subject_uuid' => $subject->uuid,
            'code' => $request['code'],
            'name' => $subject_name,
            'is_customer' => ($role == 'customer'),
            'is_supplier' => ($role == 'supplier'),
        ]);

        return $created;
    }

    public function update(PartnerRequest $request, $type, Partner $partner)
    {
        $this->authorize('update', $partner);

        switch ($request['subject']) {
            case 'company':
                //$subject_type = 'App\Company';
                $subject_name = $request['name'];
                break;

            case 'person':
                //$subject_type = 'App\Person';
                $subject_name = $request['first_name'] . ' ' . $request['last_name'];
                break;

            default:
                abort(422);
        }

        $partner->code = request('code');
        $partner->name = $subject_name;
        $partner->save();

        // update back to subject
        switch ($partner->subject_type) {
         case 'App\Company':
            $company = $partner->subject;
            $company->name = $request['name'];
            $company->save();
            break;

         case 'App\Person':
            $person = $partner->subject;
            $person->first_name = $request['first_name'];
            $person->last_name = $request['last_name'];
            $person->save();
            break;
        }

        return $partner;
    }

    public function destroy($type, Partner $partner)
    {
        $this->authorize('delete', $partner);

        $partner->delete();
    }
}
