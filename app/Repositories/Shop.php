<?php
/**
 * User: ZE
 * Date: 2017/02/03
 * Time: 23:23
 */

namespace App\Repositories;


use App\Master;

class Shop
{
    public $shops;

    function __construct()
    {
        $this->shops = Master::user()->shops()->get();
    }
}