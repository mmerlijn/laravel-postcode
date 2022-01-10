<?php

namespace mmerlijn\laravelPostcode\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mmerlijn\laravelHelpers\Facades\Distance;

class Postcode extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function getConnection()
    {
        $this->connection = config('postcode.database_connection_name');
        return parent::getConnection();
    }

    public function getTable()
    {
        return config('postcode.postcode_table_name');
    }

    public function scopeGetAddress($query, string $postcode, string|float $nr): Builder
    {
        $building_nr = $this->getBuildingNr($nr);

        if ($building_nr % 2) {//odd nummber
            return $query->where('postcode', '=', $postcode)
                ->where('minnumber', '<=', $building_nr)
                ->where('maxnumber', '>=', $building_nr)
                ->where(function ($q) {
                    $q->where('numbertype', '=', 'odd')->orWhere('numbertype', '=', 'mixed');
                });
        } else {
            return $query->where('postcode', '=', $postcode)
                ->where('minnumber', '<=', $building_nr)
                ->where('maxnumber', '>=', $building_nr)
                ->where(function ($q) {
                    $q->where('numbertype', '=', 'even')->orWhere('numbertype', '=', 'mixed');
                });
        }
    }

    public static function getCity(string $postcode): string
    {
        $postcode = str_replace(" ", "", $postcode);
        $p = self::wherePostcode($postcode)->first();
        if ($p) {
            return $p->city;
        }
        return "";
    }

    public static function getCoordinates(string $seachable): array
    {
        if (preg_match('/^\d{4}/', $seachable)) {
            return static::getPostcodeCoordinates($seachable);
        }
        return static::getCityCoordinates($seachable);
    }

    public static function getCityCoordinates(string $city): array
    {
        $coor = Distance::cityCoordinates($city);
        if (!$coor[0]) {
            $postcode = Postcode::select(DB::raw('AVG(lon) as lon'), DB::raw('AVG(lat) as lat'))->whereCity($city)->first();
            return ['lat' => $postcode->lat ?: 0, 'long' => $postcode->lon ?: 0];
        }
        return ['lat' => $coor[0], 'long' => $coor[1]];
    }

    public static function getPostcodeCoordinates(string $postcode): array
    {
        try {
            $postcode = self::wherePostcode($postcode)->firstOrFail();
            return ['lat' => $postcode->lat, 'long' => $postcode->lon];
        } catch (\Exception $e) {
            $coor = ['lat' => 0, 'long' => 0];
        }
        if (!$coor['lat']) {
            $pnum = substr($postcode, 0, 4);
            if (strlen($pnum) == 4) {
                $postcode_to = Postcode::select(DB::raw('AVG(lon) as lon'), DB::raw('AVG(lat) as lat'))->wherePnum($pnum)->first();
                if ($postcode_to) {
                    return ['lat' => $postcode_to->lat, 'long' => $postcode_to->lon];
                }
            }
        }
        return ['lat' => 0, 'long' => 0];
    }

    private function getBuildingNr(string $nr): int
    {
        return (int)preg_replace('/^(\d+)(.*)/', '$1', $nr);
    }

}