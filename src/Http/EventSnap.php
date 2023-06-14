<?php

declare(strict_types=1);

namespace EventSnap\Http;

use EventSnap\Exceptions\EventSnapApiException;
use EventSnap\Http\Payloads\Event;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Throwable;

final readonly class EventSnap
{
    public const VERSION = '0.0.1';

    /**
     * @param PendingRequest $request
     */
    public function __construct(
        private PendingRequest $request,
    ) {}

    public function send(string $name, string $icon, string $description, string $channel, string $project, array $tags = [], bool $notify = false): void
    {
        // build the request
        $payload = new Event(
            name: $name,
            description: $description,
            icon: $icon,
            channel: $channel,
            project: $project,
            tags: $tags,
            notify: $notify,
        );

        try {
            $this->post(
                uri: '/api/v1/ingress/events',
                data: $payload->toArray(),
            );
        } catch (Throwable $exception) {
            throw new EventSnapApiException(
                message: 'Something went wrong sending your request.',
                code: $exception->getCode(),
                previous: $exception,
            );
        }
    }

    /**
     * @param string $uri
     * @param array $data
     * @return Response
     * @throws RequestException
     */
    public function post(string $uri, array $data = []): Response
    {
        return $this->request->post(
            url: $uri,
            data: $data,
        )->throw();
    }

    /**
     * @param Application $app
     * @return void
     */
    public static function register(Application $app): void
    {
        $app->bind(
            abstract: EventSnap::class,
            concrete: fn () => new EventSnap(
                request: Http::baseUrl(
                    url: config('services.event-snap.url'),
                )->timeout(
                    seconds: 60
                )->asJson()->acceptJson()->withToken(
                    token: config('services.event-snap.token'),
                ),
            ),
        );
    }
}
