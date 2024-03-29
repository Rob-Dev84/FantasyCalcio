<?php

namespace App\Providers;

use App\Models\Team;
use App\Models\League;
use App\Models\Invitation;
// use App\Models\Lineup\Lineup;
use App\Models\Market\Market;
use App\Policies\LeaguePolicy;
use App\Policies\MarketPolicy;
use App\Policies\InvitationPolicy;
use Illuminate\Support\Facades\Gate;
// use App\Policies\Lineup\LineupPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        League::class => LeaguePolicy::class,
        Invitation::class => InvitationPolicy::class,
        Market::class => MarketPolicy::class,
        // Lineup::class => LineupPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
