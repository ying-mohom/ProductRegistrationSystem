<?php

namespace App\Providers;

use App\Interfaces\ItemInterface;
use App\Repositories\ItemRepository;
use App\Interfaces\CategoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public $bindings = [
        
        CategoryInterface::class => CategoryRepository::class,
        ItemInterface::class => ItemRepository::class,         
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ItemInterface::class, ItemRepository::class);


    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
