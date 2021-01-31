<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StarshipControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getAllVehicleTest()
    {
        $response = $this->get('/api/inventory/vehicles/search');

        $response->assertStatus(200);
        $response->assertJson ([
            'data'=>[[
                "name"=>$response['data'][0]['name'],
                "model"=>$response['data'][0]['model'],
                "manufacturer"=> $response['data'][0]['count'],
                "cost_in_credits" =>$response['data'][0]['cost_in_credits'],
                "length"=>$response['data'][0]['length'],
                "max_atmosphering_speed"=> $response['data'][0]['max_atmosphering_speed'],
                "crew"=> $response['data'][0]['crew'],
                "passengers"=>$response['data'][0]['passengers'],
                "cargo_capacity"=>$response['data'][0]['cargo_capacity'],
                "consumables"=> $response['data'][0]['consumables'],
               "vehicle_class"=>$response['data'][0]['vehicle_class'],
                "pilots"=>$response['data'][0]['pilots'],
                "films"=>$response['data'][0]['films'],
                "created"=> $response['data'][0]['created'],
                "edited"=> $response['data'][0]['edited'],
                "url"=> $response['data'][0]['url'],
                "count"=> $response['data'][0]['count']
                ]]



        ]);
    }

    public function test_getAllStarships(){
        $response = $this->get('/api/inventory/starships/search');

        $response->assertStatus(200);
        $response->assertJson ([
            'data'=>[[
                "name"=>$response['data'][0]['name'],
                "model"=>$response['data'][0]['model'],
                "manufacturer"=> $response['data'][0]['manufacturer'],
                "cost_in_credits" =>$response['data'][0]['cost_in_credits'],
                "length"=>$response['data'][0]['length'],
                "max_atmosphering_speed"=> $response['data'][0]['max_atmosphering_speed'],
                "crew"=> $response['data'][0]['crew'],
                "passengers"=>$response['data'][0]['passengers'],
                "cargo_capacity"=>$response['data'][0]['cargo_capacity'],
                "consumables"=> $response['data'][0]['consumables'],
                "hyperdrive_rating"=>$response['data'][0]['hyperdrive_rating'],
                "MGLT"=>$response['data'][0]['MGLT'],
                "starship_class"=>$response['data'][0]['starship_class'],
                "pilots"=>$response['data'][0]['pilots'],
                "films"=>$response['data'][0]['films'],
                "created"=> $response['data'][0]['created'],
                "edited"=> $response['data'][0]['edited'],
                "url"=> $response['data'][0]['url'],
                "count"=> $response['data'][0]['count']
                ]]
        ]);
    }

    public function test_getCount(){
        $response = $this->get('/api/inventory/starships/search?value=J-type%20star%20skiff');
        $response->assertStatus(200);
        $response->assertJson ([
            'data'=>[
                "name"=>$response['data']['name'],
                "model"=>$response['data']['model'],
                "manufacturer"=> $response['data']['manufacturer'],
                "cost_in_credits" =>$response['data']['cost_in_credits'],
                "length"=>$response['data']['length'],
                "max_atmosphering_speed"=> $response['data']['max_atmosphering_speed'],
                "crew"=> $response['data']['crew'],
                "passengers"=>$response['data']['passengers'],
                "cargo_capacity"=>$response['data']['cargo_capacity'],
                "consumables"=> $response['data']['consumables'],
                "hyperdrive_rating"=>$response['data']['hyperdrive_rating'],
                "MGLT"=>$response['data']['MGLT'],
                "starship_class"=>$response['data']['starship_class'],
                "pilots"=>$response['data']['pilots'],
                "films"=>$response['data']['films'],
                "created"=> $response['data']['created'],
                "edited"=> $response['data']['edited'],
                "url"=> $response['data']['url'],
                "count"=> $response['data']['count']
                ]
        ]);
    }

    public function test_addQuantity(){

        $response = $this->post('/api/inventory/vehicles/modify-quantity',["model"=>"Bantha-II", "quantity"=> 100,"action"=> "add"]);
        $response->assertStatus(200);
        $response->assertJson ([
            'data'=>[
                "name"=>$response['data']['name'],
                "model"=>$response['data']['model'],
                "manufacturer"=> $response['data']['manufacturer'],
                "cost_in_credits" =>$response['data']['cost_in_credits'],
                "length"=>$response['data']['length'],
                "max_atmosphering_speed"=> $response['data']['max_atmosphering_speed'],
                "crew"=> $response['data']['crew'],
                "passengers"=>$response['data']['passengers'],
                "cargo_capacity"=>$response['data']['cargo_capacity'],
                "consumables"=> $response['data']['consumables'],
               "vehicle_class"=>$response['data']['vehicle_class'],
                "pilots"=>$response['data']['pilots'],
                "films"=>$response['data']['films'],
                "created"=> $response['data']['created'],
                "edited"=> $response['data']['edited'],
                "url"=> $response['data']['url'],
                "count"=> $response['data']['count']
                ]
        ]);

    }
}
