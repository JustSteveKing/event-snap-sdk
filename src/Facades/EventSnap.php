<?php

declare(strict_types=1);

namespace EventSnap\Facades;

use Illuminate\Support\Facades\Facade;

final class EventSnap extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \EventSnap\Http\EventSnap::class;
    }
}
