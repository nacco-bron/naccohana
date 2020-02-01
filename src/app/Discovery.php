<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discovery extends Model
{
    /**
     * この発見情報に紐づく花を取得
     */
    public function flower()
    {
        return $this->belongsTo('App\Flower');
    }

}
