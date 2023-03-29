<?php
namespace App\Interfaces;

use Illuminate\Http\Request;

interface StarWarsApiRestClient{
    public function peopleAll(Request $request);
    public function peopleById($id);
    public function planetsAll(Request $request);
    public function planetById($id);
    public function vehiclesAll(Request $request);
    public function vehicleById($id);
}
