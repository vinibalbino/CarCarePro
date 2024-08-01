<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Brand;


class BrandController extends Controller
{
    public function home(){

        $user = Auth::user();

        $brands = Brand::where('user_id', $user->id)->get();;

        return Inertia::render('Brand/Brands',[
            'brands' => $brands,
        ]);

    }

    public function form(){

        return Inertia::render('Brand/Form', [
            'brand' => Brand::find(request('id')),
        ]);
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required|max:255|unique:brands,name',
        ]);

        $user_id = auth()->id();
        $dados = $request->all();
        $dados['user_id'] = $user_id;

        Brand::create($dados);

        return redirect()->route('marcas');
    }

    public function destroy(){

        $brand = Brand::find(request('id'));
        $brand->delete();

        return redirect()->route('marcas');
    }

    public function edit(Request $request){

        $request->validate([
            'name' => 'max:255 | required',
        ]);

        $brand = Brand::find(request('id'));

        $brand->name = request('name');

        $brand->save();

        return redirect()->route('marcas');


    }

}
