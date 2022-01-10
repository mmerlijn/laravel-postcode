<?php

namespace mmerlijn\laravelPostcode\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostcodeResource extends JsonResource
{

    public function toArray($request)
    {
        return array_merge($this->building_nr($request->nr), [
            'postcode' => $this->postcode ?? $request->postcode,

            'street' => $this->street ?? null,
            'city' => $this->city ?? null,
            'province' => $this->province ?? null,
            'lat' => $this->lat ?? null,
            'long' => $this->lon ?? null,
            'success' => ($this->street ?? false) ? true : false,
            'error' => ($this->street ?? false) ? null : 'Postcode not found',
        ]);
    }

    private function building_nr($nr)
    {
        $building_nr = preg_replace('/^(\d+)(.*)/', '$1', $nr);
        $building_addition = trim(preg_replace('/^(\d+)(.*)/', '$2', $nr));
        $building = trim($building_nr . " " . $building_addition);
        return [
            'nr' => $building,
            'building_nr' => $building_nr,
            'building_addition' => $building_addition,
        ];
    }

}