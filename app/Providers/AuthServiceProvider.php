<?php

namespace App\Providers;

use App\Models\Feedback;
use App\Models\Performance;
use App\Models\User;
use App\Policies\FeedbackPolicy;
use App\Policies\PerformancePolicy;  // Menambahkan policy PerformancePolicy
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Feedback::class => FeedbackPolicy::class,  // Daftarkan kebijakan untuk model Feedback
        Performance::class => PerformancePolicy::class,  // Daftarkan kebijakan untuk model Performance
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate untuk memeriksa apakah pengguna adalah admin
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin'; // role admin
        });

        // Daftarkan PerformancePolicy
        Gate::policy(Performance::class, PerformancePolicy::class);

        // Gate tambahan bisa ditambahkan di sini jika diperlukan
    }
}
