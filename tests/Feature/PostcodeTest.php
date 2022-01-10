<?php

namespace mmerlijn\laravelPostcode\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use mmerlijn\laravelPostcode\Models\PostcodeNotFound;

class PostcodeTest extends \mmerlijn\laravelPostcode\tests\TestCase
{
    use RefreshDatabase;

    function test_api_postcode_valid_request()
    {
        $response = $this->postJson(route('postcode.getAddress'), [
            'postcode' => '1187LS',
            'nr' => "3a",
        ]);
        $response->assertStatus(200);
        $response->assertJson(fn(AssertableJson $json) => $json->has('data.postcode')
            ->has('data.street')
            ->has('data.nr')
            ->has('data.building_nr')
            ->has('data.building_addition')
            ->has('data.province')
            ->has('data.lat')
            ->has('data.long')
            ->has('data.success')
        );
        $response->assertJsonPath('data.postcode', '1187LS');
        $response->assertJsonPath('data.nr', '3 a');
        $response->assertJsonPath('data.building_addition', 'a');
        $response->assertJsonPath('data.building_nr', '3');
        $response->assertJsonPath('data.street', 'Westwijkplein');
        $response->assertJsonPath('data.city', 'Amstelveen');
        $response->assertJsonPath('data.lat', '52.281458330925');
        $response->assertJsonPath('data.long', '4.8261185828603');
        $response->assertJsonPath('data.success', true);
    }

    public function test_api_postcode_invalid_request()
    {
        $response = $this->postJson(route('postcode.getAddress'), [
            'postcode' => '1080AA',
            'building' => 20,
        ]);
        $response->assertStatus(200);
        $response->assertJsonPath('data.postcode', '1080AA');
        $response->assertJsonPath('data.error', 'Postcode not found');
        $response->assertJsonPath('data.success', false);
        $p = PostcodeNotFound::all()->pluck('postcode')->toArray();
        $this->assertTrue(in_array('1080AA', $p));
    }

    public function test_validation_fail()
    {
        $response = $this->postJson(route('postcode.getAddress'), [
            'postcode' => '1080AA',
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('errors.building.0', "building is een verplicht veld");
        $response = $this->postJson(route('postcode.getAddress'), [
        ]);
        $response->assertStatus(422);
        $response->assertJsonPath('errors.postcode.0', "postcode is een verplicht veld");
        $response->assertJsonPath('errors.building.0', "building is een verplicht veld");

        $response = $this->postJson(route('postcode.getAddress'), [
            'postcode' => '1080',
        ]);
        $response->assertJsonPath('errors.postcode.0', "postcode formaat is niet geldig");
    }

}