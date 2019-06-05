<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Cache;


class DatasetResponse implements Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function toResponse($request)
    {
        return response()
            ->view('dataset', ['data' => $this->transform()])
            ->header('Content-Type', 'application/javascript');
    }

    /**
     * A object transformer.
     *
     * @return array
     */
    protected function transform() : array
    {
        if (Cache::has('global_data')) {
            return Cache::get('global_data');
        }

        $response = [
            'config'            => $this->config(),
        ];

        Cache::put('global_data', $response, 60);

        return $response;
    }

    /**
     * Include config
     *
     * @return array
     */
    private function config()
    {
        $default = [
            'url'           => config('app.url'),
            'env'           => config('app.env'),
            'debug'         => config('app.debug'),
            'api' => [
                'pusher' => [
                    'key'       => config('broadcasting.connections.pusher.key'),
                    'cluster'   => config('broadcasting.connections.pusher.options.cluster'),
                    'auth_url'  => 'api/v1/broadcasting/auth',
                ],
                'sentry' => [
                    'dns'       => env('SENTRY_FRONTEND_DSN', '')
                ]
            ]
        ];

        return $default;
    }
}