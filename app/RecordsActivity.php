<?php

namespace App;

trait RecordsActivity
{
    // every class that use this trait will call 'boot'
    protected static function bootRecordsActivity()
    {
        if (auth()->guest()) {
            return;
        }

        foreach (static::getActivitiesToRecord() as $event) {
            static::$event(function ($model) use($event) {
                $model->recordActivity($event);
            });
        }

        //static::deleting(function ($model) {
        //    $model->activity()->delete();
        //});
    }

    protected static function getActivitiesToRecord()
    {
        // events are listed in fireModelEvent
        return ['created', 'updating', 'deleted'];
    }

    protected function recordActivity($event)
    {
        if ($event == 'updating') {
            $diff = $this->getUpdatingDiffFields();

            return $this->activity()->create([
                'uuid' => uuid(),
                'user_id' => auth()->id(),
                'type' => $this->getActivityType($event),
                'before' => $diff['before'],
                'after' => $diff['after'],
            ]);
        }

        return $this->activity()->create([
            'uuid' => uuid(),
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType($event)
    {
        $class_name = str_plural(strtolower((new \ReflectionClass($this))->getShortName()));

        // to records diff fields, the event must be 'updating'
        if ($event == 'updating') {
            return "{$class_name}.updated";
        }

        return "{$class_name}.{$event}";
    }

    public function getUpdatingDiffFields()
    {
        $changed = $this->getDirty();

        $before = json_encode(array_intersect_key($this->fresh()->toArray(), $changed));

        $after = json_encode($changed);

        return compact('before', 'after');
    }
}
