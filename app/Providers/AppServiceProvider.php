<?php

namespace App\Providers;

use App\Models\Storage;
use App\Observers\StorageObserver;
use App\Repositories\Interfaces\BatchRepositoryInterface;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Interfaces\ProviderRepositoryInterface;
use App\Repositories\Interfaces\StorageRepositoryInterface;
use App\Repositories\Interfaces\ClientRepositoryInterface;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\BatchRepository;
use App\Repositories\BuyRepository;
use App\Repositories\ProviderRepository;
use App\Repositories\StorageRepository;
use App\Repositories\ClientRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\BuyRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(BuyRepositoryInterface::class, BuyRepository::class);
        $this->app->bind(BatchRepositoryInterface::class, BatchRepository::class);
        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
        $this->app->bind(StorageRepositoryInterface::class, StorageRepository::class);
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Storage::observe(StorageObserver::class);
    }
}
