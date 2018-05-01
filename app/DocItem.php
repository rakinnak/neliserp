<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Filters\DocItemFilter;

class DocItem extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'doc_id',
        'item_id',
        'ref_id',
        'line_number',
        'item_uuid',
        'item_code',
        'item_name',
        'quantity',
        'pending_quantity',
        'unit_price',
    ];

    protected $table = 'doc_item';

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->uuid = uuid();
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function doc()
    {
        return $this->belongsTo(Doc::class);
    }

    public function scopeFilter($builder, DocItemFilter $filter)
    {
        return $filter->apply($builder);
    }
}
