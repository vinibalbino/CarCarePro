<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
    //

    public function home(){

        $owners = Owner::all();

        return Inertia::render('Owner/Owners',[
            'owners' => $owners,
        ]);

    }

    public function info() {
        return Inertia::render('Owner/Owner',[
            'owner' => Owner::with('address')->find(request('id')),
        ]);
    }

    public function form(){

        return Inertia::render('Owner/Form', [
            'owner' => Owner::with('address')->find(request('id')),
        ]);
    }

    public function create(Request $request){

        $request->validate([
            'full_name' => 'max:255 | required',
            'cpf' => 'max:255 | required',
            'sex' => 'max:10 | required',
        ]);


        $ownerAddres = (new AddresController)->create($request);

        $dados=[];
        $dados = array_merge($dados, [
             'addres_id' => $ownerAddres->id,
             'full_name' => $request->get('full_name'),
             'cpf' => $request->get('cpf'),
             'sex' => $request->get('sex'),
         ]);


        Owner::create($dados);

        return redirect()->route('clientes');
    }

    public function destroy()
    {
        $owner = Owner::findOrFail(request('id'));
        $owner->delete();

        return redirect()->route('clientes')->with('success', 'Owner and their address have been deleted.');
    }

    public function edit(Request $request){

        $request->validate([
            'full_name' => 'max:255 | required',
            'cpf' => 'max:255 | required',
            'sex' => 'max:10 | required',
        ]);

        $owner = Owner::findOrFail(request('id'));

        $owner->update([
            'full_name' => $request->full_name,
            'cpf' => $request->cpf,
            'sex' => $request->sex,
        ]);

        (new AddresController)->edit($request, $owner->addres_id);

        return redirect()->route('clientes')->with('success', 'Cliente atualizado com sucesso!');

    }

}
