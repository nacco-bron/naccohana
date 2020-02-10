<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Discovery extends Model
{
    /**
     * この発見情報に紐づく花を取得
     */
    public function flower()
    {
        return $this->belongsTo('App\Flower');
    }


    protected $geofields = array('latlng');

    public function setLatlngAttribute(array $value)
    {
        $this->attributes['latlng'] = DB::raw("(GeomFromText('POINT(" . $value['lat'] . " " . $value['lng'] . ")'))");
    }

    public function getLatlngAttribute(string $value)
    {
        $value = substr($value, strlen('POINT('), strlen($value) - (strlen('POINT(') + 1));
        $value = explode(" ", $value);
        $ret = [];
        $ret['lat'] = $value[0];
        $ret['lng'] = $value[1];
        return $ret;
    }

    public function newQuery($excludeDeleted = true)
    {
        $raw='';
        foreach ($this->geofields as $column) {
            $raw .= ' ST_AsText('.$column.') as '.$column.' ';
        }

        return parent::newQuery($excludeDeleted)->addSelect('*', DB::raw($raw));
    }
}
