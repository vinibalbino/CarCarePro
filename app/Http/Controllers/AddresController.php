<?php

namespace App\Http\Controllers;

use App\Models\Addres;
use Illuminate\Http\Request;

class AddresController extends Controller
{
    //
    public function create(Request $request){

        $request->validate([
            'street' => 'max:255 | required',
            'house_number' => 'max:255 | required',
            'zipcode' => 'max:255 | required',
            'city' => 'max:255 | required',
            'neighborhood' => 'max:255 | required',
        ]);


        $newAddress=[];
        $newAddress = array_merge($newAddress, [
            'street' => $request->get('street'),
            'house_number' => $request->get('house_number'),
            'zipcode' => $request->get('zipcode'),
            'city' => $request->get('city'),
            'neighborhood' => $request->get('neighborhood'),
        ]);

        $address = Addres::create($newAddress);

        return $address;
    }

    public function destroy(){

        $address = Addres::find(request('id'));
        $address->delete();

        return 200;
    }

    public function edit(Request $request, $addres_id){

        $request->validate([
            'street' => 'max:255 | required',
            'house_number' => 'max:255 | required',
            'zipcode' => 'max:255 | required',
            'city' => 'max:255 | required',
            'neighborhood' => 'max:255 | required',
        ]);


        Addres::where('id', $addres_id)->update([
            'street' => request('street'),
            'house_number' => request('house_number'),
            'zipcode' => request('zipcode'),
            'city' => request('city'),
            'neighborhood' => request('neighborhood'),
        ]);

    }
}
