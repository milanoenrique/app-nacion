<?php
namespace App\Helpers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use App\Models\{InventoryTransport, TypeVehicle};
use phpDocumentor\Reflection\DocBlock\Tags\Throws;
use Throwable;


use function PHPUnit\Framework\throwException;

class Swapi {
    public static function getData($type){


        try{

            $client = new Client();

            $type_vehicle = TypeVehicle::SearchByDescription($type)->first();

            if($type_vehicle == null){
                return null;
            }


            $url = env('API_ENDPOINT').$type;

            $response = $client->request('GET',$url);

            $response = json_decode($response->getBody());
            $total = $response->count;

            $result = $response->results;
            $stop=false;
            $cont =0;
            $collectTransport =  array();
            while(!$stop){
                $url = $response->next;
                foreach($response->results as $result){

                    $id = explode($type.'/',$result->url);
                    DB::beginTransaction();
                        $inventory = InventoryTransport::firstOrCreate(['vehicle_id'=>str_replace('/','',$id[1]),'type_vehicle_id'=>$type_vehicle->id,'model'=> strtolower($result->model)]);
                    DB::commit();
                    $result->model = strtolower($result->model);
                    $collectTransport[]= $result;

                    $cont++;
                }

                if($url!=null){
                    $response = $client->request('GET',$url);
                    $response = json_decode($response->getBody());
                }

                if($cont==$total){
                    $stop =true;
                }
            }

           $collectTransport = new Collection($collectTransport);

           return $collectTransport;


        }catch(Exception $e){
            DB::rollback();
            Log::error($e->getmessage());
            return response()->json(['data'=>null]);
        }
    }
}
