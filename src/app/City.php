<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * 市区町村が属する都道府県を取得
     */
    public function prefecture()
    {
        return $this->belongsTo('App\Prefecture');
    }
}
