<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    /**
     * 科名の花を取得
     */
    public function flowers()
    {
        return $this->hasMany('App\Flower');
    }

}
