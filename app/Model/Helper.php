<?php
/**
 * User: ZE
 * Date: 2016/12/15
 * Time: 0:02
 */

namespace App\Model;


use Illuminate\Support\Facades\Schema;

trait Helper
{
    public static function getColumnListing()
    {
        $static = new static();
        $columns = Schema::getColumnListing($static->getTable());

        $unsetColumns = [$static::CREATED_AT, $static::UPDATED_AT, $static->primaryKey];
        foreach ($unsetColumns as $col) {
            if (($key = array_search($col, $columns)) !== false) {
                unset($columns[$key]);
            }
        }

        return $columns;
    }

    public function safeUpdate($data)
    {
        $cllist = self::getColumnListing();
        $updateData = array_only($data, $cllist);
        return $this->update($updateData);
    }

}