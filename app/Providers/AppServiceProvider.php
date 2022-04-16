<?php

namespace App\Providers;

use App\Repositories\Eloquents\EloquentTaskRepository;
use App\Repositories\Eloquents\EloquentUserRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        App::bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        App::bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
    }
}
