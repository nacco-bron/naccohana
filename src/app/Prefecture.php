<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    /**
     * 市区町村を取得
     */
    public function cities()
    {
        return $this->hasMany('App\City');
    }
}
