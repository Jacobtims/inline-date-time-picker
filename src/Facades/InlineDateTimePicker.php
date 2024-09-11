<?php

namespace Jacobtims\InlineDateTimePicker\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jacobtims\InlineDateTimePicker\InlineDateTimePicker
 */
class InlineDateTimePicker extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Jacobtims\InlineDateTimePicker\InlineDateTimePicker::class;
    }
}
