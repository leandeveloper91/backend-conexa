<?php

namespace App\Services;

use App\Interfaces\StarWarsApiRestClient;
use Exception;
use GuzzleHttp;

class StarWarsApiService implements StarWarsApiRestClient{

      public function peopleAll($request){
       
       try{ 
            $request_data = $request->all();
            $results = [];
            
            $client    = new GuzzleHttp\Client(['base_uri' => env('URL_API')]);

             $response = $client->get("people");
             $data = json_decode($response->getBody());

             $pages = $data->count / 10;
              
             if(is_float($pages))
             {
               $pages = intval($pages);
               $pages = $pages + 1;

             }

             (isset($request_data['limit']))? $limit = $request_data['limit'] : $limit=10;

             if(isset($request_data['offset'])&& $request_data['offset']%10 != 0)
             {
               throw new Exception('El offset debe ser multiplo de 10');
             }elseif(isset($request_data['offset']))
             {
               $page = $request_data['offset']/10 + 1;
             }else{
               $page = 1;
            }
             
                  $response = $client->get("people?page=" . $page);
                  $data = json_decode($response->getBody());
                 
                  
                  foreach($data->results as $result)
                  {
                  array_push($results,$result);
                  }
                 
               return array_slice($results,false,$limit);
      }catch(Exception $e){
         return response()->json( [
            'error'=> $e->getMessage()
            

         ],500);
      }
     }

     public function peopleById($id){
 
         try{
               $client    = new GuzzleHttp\Client(['base_uri' => env('URL_API')]);

               $response = $client->get("people/" . $id);

               $data = json_decode($response->getBody());
               
               return $data;
         }catch(Exception $e)
         {
            return response()->json( [
               'error'=> 'Api not found',
   
            ],500);
         }
     }

     public function planetsAll($request){
      
      try{
      $request_data = $request->all();
      $results = [];
      $page = 1;
      
      (isset($request_data['limit'])) ? $limit = $request_data['limit'] : $limit=0;
      (isset($request_data['offset'])) ? $offset = $request_data['offset'] : $offset=false;
       
       $client    = new GuzzleHttp\Client(['base_uri' => env('URL_API')]);

       while($page != null)
       {
          $response = $client->get("planets?page=" . $page);

          $data = json_decode($response->getBody());
          if (!isset($request_data['limit']) && isset($data->count))
          { 
           $limit = $data->count;
        
        }
          foreach($data->results as $result)
          {
           array_push($results,$result);
          }
          ($data->next==null) ? $page = null : $page +=1;

       }

       return array_slice($results,$offset,$limit);
      }catch(Exception $e){
         return response()->json( [
            'error'=> $e->getMessage()

         ],500);
      }
   }

   public function planetById($id){

      try{
       $client    = new GuzzleHttp\Client(['base_uri' => env('URL_API')]);

       $response = $client->get("planets/" . $id);

       $data = json_decode($response->getBody());
       
       return $data;
      }catch(Exception $e){
         return response()->json( [
            'error'=> 'Api not found',

         ],500);
      }
   }


   public function vehiclesAll($request){
      
      try{
         $request_data = $request->all();
      $results = [];
      $page = 1;

      (isset($request_data['limit'])) ? $limit = $request_data['limit'] : $limit=false;
      (isset($request_data['offset'])) ? $offset = $request_data['offset'] : $offset=false;

       $client    = new GuzzleHttp\Client(['base_uri' => env('URL_API')]);

       while($page != null)
       {
          $response = $client->get("vehicles?page=" . $page);

          $data = json_decode($response->getBody());
          if (!isset($request_data['limit']) && isset($data->count))
           { 
            $limit = $data->count;
         
         }
          foreach($data->results as $result)
          {
           array_push($results,$result);
          }
          ($data->next==null) ? $page = null : $page +=1;

       }
       

       return array_slice($results,$offset,$limit);
      }catch(Exception $e){
         return response()->json( [
            'error'=> $e->getMessage(),
         ],500);
      }
   }

   public function vehicleById($id){

      try{
       $client    = new GuzzleHttp\Client(['base_uri' => env('URL_API')]);

       $response = $client->get("vehicles/" . $id);

       $data = json_decode($response->getBody());
       

       return $data;
      }catch(Exception $e){
        return response()->json( [
            'error'=> 'Api not found',

         ],500);
      }
   }
}