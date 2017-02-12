<?php

namespace App\Providers;

use App\Http\ViewComposers\ShopListComposer;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
//        $this->listenCreating();
//        $this->shops_table_composer();
    }

    function listenCreating()
    {
        Event::listen('creating:*', function (\Illuminate\View\View $view) {
            $view->with('view_' . $view->getName(), $view->getName());
        });
    }

    function shops_table_composer()
    {
        View::composer(
            ['master.shops_table'],
            ShopListComposer::class
        );

        Event::listen('composing:*', function (\Illuminate\View\View $view) {
            $view_name = $view->name();
//            $html_id = $this->UPDATE_VIEW_HTML_ID($view_name);
//            Log::debug(compact('view_name', 'html_id'), [__CLASS__ . '@' . __FUNCTION__]);
            $view->with('view_name', $view_name);
        });

    }

    function UPDATE_VIEW_HTML_ID($view_name)
    {
        $view_parts = explode('.', $view_name);
        foreach (array_reverse($view_parts) as $html_id) {
            if (!in_array($html_id, ['html', 'blade', 'php'])) {
                return $html_id;
            }
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
