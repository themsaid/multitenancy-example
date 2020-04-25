<?php

namespace App\Providers;

use App\Tenant;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\ServiceProvider;

class TenancyProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureQueue();

        $this->configureRequests();
    }

    /**
     *
     */
    public function configureQueue()
    {
        $this->app['queue']->createPayloadUsing(function () {
            return $this->app['tenant'] ? ['tenant_id' => $this->app['tenant']->id] : [];
        });

        $this->app['events']->listen(JobProcessing::class, function ($event) {
            if (isset($event->job->payload()['tenant_id'])) {
                Tenant::find($event->job->payload()['tenant_id'])->configure()->use();
            }
        });
    }

    /**
     *
     */
    public function configureRequests()
    {
        if (! $this->app->runningInConsole()) {
            $host = $this->app['request']->getHost();

            Tenant::whereDomain($host)->firstOrFail()->configure()->use();
        }
    }
}
