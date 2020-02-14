<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Discovery extends Model
{
    /**
     * この発見情報に紐づく花を取得
     */
    public function flower()
    {
        return $this->belongsTo('App\Flower');
    }

    /**
     * この発見情報に紐づく都道府県を取得
     */
    public function prefecture()
    {
        return $this->belongsTo('App\Prefecture');
    }
    
    /**
     * この発見情報に紐づく市区町村を取得
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }


    /**
     * 発見日時アクセサ
     */
    function getDiscoveredAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y年m月d日') : null;
    }

    /**
     * 緯度経度アクセサ、ミューテタ
     */
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
