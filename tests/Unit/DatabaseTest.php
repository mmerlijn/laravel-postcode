<?php

namespace mmerlijn\laravelPostcode\tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use mmerlijn\laravelPostcode\Models\Postcode;
use mmerlijn\laravelPostcode\tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_postcode_table_has_rows()
    {
        $this->assertEquals(5, Postcode::count());
    }

    public function test_find_postcode()
    {

        $this->assertEquals(0, Postcode::getAddress('1080AA', 24)->count()); //not in database
        $this->assertEquals(1, Postcode::getAddress('1187DJ', 24)->count()); //mixed between 1-50
        $this->assertEquals(0, Postcode::getAddress('1187DJ', 75)->count());
        $this->assertEquals(1, Postcode::getAddress('1187KA', 24)->count());//even between 2-46
        $this->assertEquals(0, Postcode::getAddress('1187KA', 23)->count());
        $this->assertEquals(1, Postcode::getAddress('1187LS', 1)->count()); //odd between 1-7
        $this->assertEquals(0, Postcode::getAddress('1187LS', 8)->count()); //

        $this->assertEquals('1187KA', Postcode::getPostcode('Amstelveen', 'Gaasterland', '18a'));
        $this->assertEquals('1187LS', Postcode::getPostcode('Amstelveen', 'Westwijkplein', '5'));
        $this->assertEquals('', Postcode::getPostcode('Amstelveen', 'Duivenvoorde', '75')); //postcode not present in DB (out of range)
        $this->assertEquals('', Postcode::getPostcode('Amstelveen', 'Westwijkplein', '6')); //postcode not present in DB (must be odd)


    }
}