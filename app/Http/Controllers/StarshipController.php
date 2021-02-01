<?php

namespace App\Http\Controllers;

use App\Helpers\Swapi;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use App\Models\InventoryTransport;
use App\Models\TypeVehicle;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Starship;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
* @OA\Info(title="API SWAPI INVENTORY", version="1.0")
*
* @OA\Server(url="http://localhost:8000/api/inventory")
*/

class StarshipController extends Controller
{
    /**
    * @OA\Get(
    *
    *     path="/{type}/search",
    *     summary="Search starship or vehicles",
    *     @OA\Parameter(
    *     required = true,
    *     description = "Type to search in the inventory",
    *     name="type",
    *     in="path",
    *     example="vehicles"
    * ),
    *  @OA\Parameter(
    *      name="value",
    *      in="query",
    *      required=false,
    *      @OA\Schema(
    *           type="string"
    *      )
    *   ),
    *     @OA\Response(
    *         response=200,
    *         description="Show details from models of starships or vehicles, for everithing or for only one"
    *     ),
    *     @OA\Response(
    *         response="500",
    *         description="Internal Server Error"
    *     ),
    * @OA\Response(
    *         response="404",
    *         description="Not data found"
    *        )
    * )
    *
    *
    */


    public function get_count_starships(Request $request){

        $model = $request->input('value');
        $type = $request->route('type');

        try{
            $data =Swapi::getData($type);

            if($data!=null and $model!=null){
                $starship_search = $data->firstWhere('model',strtolower($model));
                if($starship_search!=null){
                    $inventory = InventoryTransport::SearchByModel($starship_search->model)->first();
                    $starship_search->count=$inventory->quantity;
                    return response()->json(['data'=>  $starship_search],HttpResponse::HTTP_OK);
                }else{

                    return response()->json(["message"=>"This model of ".$type." not exists"],HttpResponse::HTTP_NOT_FOUND);

                }

            }else{
                $fleet_of_transport = new Collection();
                foreach($data as $starship){
                    $inventory= InventoryTransport::SearchByModel(strtolower($starship->model))->first();
                    $starship->count=$inventory->quantity;
                    $fleet_of_transport[] = $starship;
                }
                return response()->json(['data'=>  $fleet_of_transport],HttpResponse::HTTP_OK);


            }
        }
        catch(Exception $e){
            Log::error($e->getMessage());
            return response()->json(['Error'=> $e->getMessage()],HttpResponse::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

/**
 * @OA\Post(
 * path="/{type}/modify-quantity",
 * summary="Add or substract quantity to inventory for specific model",
 * @OA\Parameter(
 * required = true,
 * description = "Type to search in the inventory",
 * name="type",
 * in="path",
 * example="vehicles"
 * ),
 * @OA\RequestBody(
 *    required=true,
 *    description="Model and quantity",
 *    @OA\JsonContent(
 *       required={"model","quantity","action"},
 *       @OA\Property(property="model", type="string", example="Bantha-II"),
 *       @OA\Property(property="quantity", type="integer",  example="100"),
 *       @OA\Property(property="action", type="string",  example="add"),
 *    ),
 * ),
 *  @OA\Response(
 *         response=200,
 *         description="Add or sbustract quantity of inventory for a vehicle or starship"
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal Server Error"),
*  @OA\Response(
*         response="404",
*         description="Not data found",
*
*     )
 * )
 */

    public function addToInventory(Request $request){
        $this->validate($request,[
            'model'=>'required|string',
            'quantity'=>'required|numeric',
            'action' => 'required|in:add,substract'
        ]);
        try{
            DB::beginTransaction();
            $type_vehicle = TypeVehicle::SearchByDescription($request->route('type'))->first();

            if($type_vehicle ==null){
                return response()->json(["message"=>"Data not found"],HttpResponse::HTTP_NOT_FOUND);
            }

            $request = $request->all();
            $data = Swapi::getData($type_vehicle->description);

            if($data!=null){
                $starship_search = $data->firstWhere('model',strtolower($request['model']));
                if ($starship_search == null){

                    return response()->json(["message"=>"This model of ".$type_vehicle->description." not exists"],HttpResponse::HTTP_NOT_FOUND);

                        }else{
                            $inventory = InventoryTransport::SearchByModel(strtolower($starship_search->model))->first();
                            switch ($request['action']) {
                                case 'add':
                                    $inventory->quantity = $request['quantity']+$inventory->quantity;
                                    $inventory->save();
                                    break;
                                case 'substract':

                                    if($inventory->quantity>0){
                                        $inventory->quantity = -$request['quantity']+$inventory->quantity;
                                        $inventory->save();
                                    }else{
                                        return response()->json(["message"=>"The stock for this model it's in 0"],HttpResponse::HTTP_NOT_FOUND);
                                    }

                                    break;
                            }

                        }

                DB::commit();

                $starship_search->count=$inventory->quantity;
                return  response()->json(['data'=> $starship_search],HttpResponse::HTTP_OK);
            }

        }catch(Exception $e){
            DB::rollback();
            Log::error($e->getMessage());
            return response()->json(['Error'=> $e->getMessage()],HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
