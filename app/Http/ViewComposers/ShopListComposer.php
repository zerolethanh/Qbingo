<?php

namespace App\Http\ViewComposers;

use App\Master;
use Illuminate\View\View;

class ShopListComposer
{
    protected $shops;

    /**
     * ProfileComposer constructor.
     */
    public function __construct()
    {
        $this->shops = Master::user()->shops()->latest()->get();
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with('shops', Master::user()->shops()->latest()->get());
    }
}