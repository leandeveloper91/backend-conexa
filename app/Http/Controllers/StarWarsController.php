<?php

namespace App\Http\Controllers;

use App\Services\StarWarsApiService;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp;

class StarWarsController extends Controller
{
    public function getPeople(Request $request){
    try{
       $starWars = new StarWarsApiService();
       $data = $starWars->peopleAll($request);
      
       return response()->json(
        [
            'data' => $data
        ]);
    }catch(Exception $e){
        return response()->json(
            [
                'error'=> 'Sin resultados',
                'messenge' => $e->getMessage()

            ]
            );
    }
    }

    public function getPeopleById($id)
    {
      try{
        $starWars = new StarWarsApiService();

        $data = $starWars->peopleById($id);
        return response()->json(
            [
                'data' => $data
            ]);
        }catch(Exception $e){
                return response()->json(
                    [
                        'error'=> 'Sin resultados',
                        'messenge' => $e->getMessage()
        
                    ]
                    );
            }
    }

    public function getPlanets(Request $request){
        try{
        $starWars = new StarWarsApiService();
        $data = $starWars->planetsAll($request);
       
        return response()->json(
         [
             'data' => $data
         ]);
        }catch(Exception $e){
            return response()->json(
                [
                    'error'=> 'Sin resultados',
                    'messenge' => $e->getMessage()
    
                ]
                );
        }
     }
 
     public function getPlanetById($id)
     {
       try{
         $starWars = new StarWarsApiService();
 
         $data = $starWars->planetById($id);
         return response()->json(
             [
                 'data' => $data
             ]);
        }catch(Exception $e){
            return response()->json(
                [
                    'error'=> 'Sin resultados',
                    'messenge' => $e->getMessage()
    
                ]
                );
        }
     }

     public function getVehicles(Request $request){
      try{
        $starWars = new StarWarsApiService();
        $data = $starWars->vehiclesAll($request);
       
        return response()->json(
         [
             'data' => $data
         ]
        );
    }catch(Exception $e){
        return response()->json(
            [
                'error'=> 'Sin resultados',
                'messenge' => $e->getMessage()

            ]
            );
    }
    }
 
     public function getVehicleById($id)
     {
       try{
         $starWars = new StarWarsApiService();
 
         $data = $starWars->vehicleById($id);
         return response()->json(
             [
                 'data' => $data
             ]);
     }catch(Exception $e){
        return response()->json(
            [
                'error'=> 'Sin resultados',
                'messenge' => $e->getMessage()

            ]
            );
         }
    }
}
