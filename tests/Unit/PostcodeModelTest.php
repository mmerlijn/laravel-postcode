<?php

namespace mmerlijn\laravelPostcode\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use mmerlijn\laravelPostcode\Models\Postcode;

class PostcodeModelTest extends \mmerlijn\laravelPostcode\tests\TestCase
{
    use RefreshDatabase;

    public function test_get_coordinates()
    {
        $this->assertEquals(['lat' => 52.3702157, 'long' => 4.8951679], Postcode::getCityCoordinates('Amsterdam'));
        $this->assertEquals(['lat' => 52.0329703974149, 'long' => 5.66174995276925], Postcode::getCityCoordinates('Ede'));
        $this->assertEquals(['lat' => 0, 'long' => 0], Postcode::getCityCoordinates('Paris')); //not in DB
        $this->assertEquals(['lat' => 52.281458330925, 'long' => 4.8261185828603], Postcode::getPostcodeCoordinates('1187LS'));
        $this->assertEquals(['lat' => 52.281458330925, 'long' => 4.8261185828603], Postcode::getCoordinates('1187LS'));
        $this->assertEquals(['lat' => 52.3031178, 'long' => 4.8611997], Postcode::getCoordinates('Amstelveen'));

    }

    public function test_with_building_nr_addition()
    {
        $building_nrs = [3, "3", "3a", "3 a", "3-a", "3 etage 2"];
        foreach ($building_nrs as $building) {
            $p = Postcode::getAddress('1187LS', $building)->first();
            $this->assertEquals('Westwijkplein', $p->street);
        }
    }
}