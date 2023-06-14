<?php

declare(strict_types=1);

namespace EventSnap\Providers;

use EventSnap\Http\EventSnap;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

final class PackageServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function provides(): array
    {
        return [
            EventSnap::class,
        ];
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/services.php',
            'services',
        );

        EventSnap::register(
            app: $this->app,
        );
    }

}
