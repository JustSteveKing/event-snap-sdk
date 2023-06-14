<?php

declare(strict_types=1);

namespace EventSnap\Http\Payloads;

use EventSnap\Http\EventSnap;
use Illuminate\Foundation\Application;

final readonly class Event
{
    public function __construct(
        private string $name,
        private string $description,
        private string $icon,
        private string $channel,
        private string $project,
        private array  $tags,
        private bool   $notify,
    ) {}

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'icon' => $this->icon,
            'channel' => $this->channel,
            'project' => $this->project,
            'tags' => $this->tags,
            'notify' => $this->notify,
            'meta' => [
                'php' => \PHP_VERSION,
                'laravel' => Application::VERSION,
                'sdk' => EventSnap::VERSION,
            ]
        ];
    }
}
