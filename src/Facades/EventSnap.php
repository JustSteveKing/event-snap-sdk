<?php

declare(strict_types=1);

namespace EventSnap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void send(string $name, string $icon, string $description, string $channel, string $project, array $tags = [], bool $notify = false)
 * @see \EventSnap\Http\EventSnap
 */
final class EventSnap extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \EventSnap\Http\EventSnap::class;
    }
}
