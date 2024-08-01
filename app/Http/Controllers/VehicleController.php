<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VehicleController extends Controller
{
    //

    public function home(){

        $vehicles = Vehicle::all();

        return Inertia::render('Vehicle/Vehicles',[
            'vehicles' => $vehicles,
        ]);

    }

    public function info() {
        return Inertia::render('Vehicle/Vehicle',[
            'vehicle' => Vehicle::with('owner')->and()->with('brand')->find(request('id')),
        ]);
    }

    public function form(){

        return Inertia::render('Vehicle/Form', [
            'owner' => Vehicle::with('address')->find(request('id')),
        ]);
    }

}
