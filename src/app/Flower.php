<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flower extends Model
{
    /**
     * この花が所属する科を取得
     */
    public function family()
    {
        return $this->belongsTo('App\Family');
    }

}
