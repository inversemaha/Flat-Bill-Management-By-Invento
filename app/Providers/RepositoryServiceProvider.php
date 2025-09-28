<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\BuildingRepositoryInterface;
use App\Contracts\FlatRepositoryInterface;
use App\Contracts\TenantRepositoryInterface;
use App\Contracts\BillCategoryRepositoryInterface;
use App\Contracts\BillRepositoryInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\BuildingRepository;
use App\Repositories\FlatRepository;
use App\Repositories\TenantRepository;
use App\Repositories\BillCategoryRepository;
use App\Repositories\BillRepository;
use App\Repositories\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BuildingRepositoryInterface::class, BuildingRepository::class);
        $this->app->bind(FlatRepositoryInterface::class, FlatRepository::class);
        $this->app->bind(TenantRepositoryInterface::class, TenantRepository::class);
        $this->app->bind(BillCategoryRepositoryInterface::class, BillCategoryRepository::class);
        $this->app->bind(BillRepositoryInterface::class, BillRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
