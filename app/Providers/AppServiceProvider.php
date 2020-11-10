<?php

namespace App\Providers;

use App\Repositories\Article\ArticleRepository;
use App\Repositories\Article\EloquentArticleRepository;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\EloquentCategoryRepository;
use App\Service\DataProvider\DataProvider;
use App\Service\DataProvider\GoogleDriveDataProvider;
use App\Service\DataReader\DataSource;
use App\Service\DataReader\GoogleDriveDataSource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        DataProvider::class       => GoogleDriveDataProvider::class,
        DataSource::class         => GoogleDriveDataSource::class,
        ArticleRepository::class  => EloquentArticleRepository::class,
        CategoryRepository::class => EloquentCategoryRepository::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
