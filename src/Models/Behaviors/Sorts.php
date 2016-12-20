<?php

namespace A17\CmsToolkit\Models\Behaviors;

trait Sorts
{

    protected static function bootSorts()
    {
        static::creating(function ($model) {
            $model->setToLastPosition();
        });
    }

    protected function setToLastPosition()
    {
        $this->position = $this->getCurrentLastPosition() + 1;
    }

    protected function getCurrentLastPosition()
    {
        return ((int) static::max('position'));
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('position');
    }

    public static function setNewOrder($ids, $startOrder = 1)
    {
        if (!is_array($ids)) {
            throw new \Exception('You must pass an array to setNewOrder');
        }

        foreach ($ids as $id) {
            $model = static::find($id);
            $model->position = $startOrder++;
            $model->save();
        }
    }
}