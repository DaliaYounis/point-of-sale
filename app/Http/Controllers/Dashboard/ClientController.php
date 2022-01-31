<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;

class ClientController extends Controller
{
    public function index(Request $request)
    {

        $clients = Client::when($request->search,function ($q) use ($request){
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);
        return view('dashboard.clients.index', compact('clients'));
    }

    public function create()
    {
        return view('dashboard.clients.create');

    }


    public function store(ClientRequest $request)
    {

        Client::create($request->all());
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }


    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));

    }


    public function update(ClientRequest $request, Client $client)
    {
        $client->update($request->all());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');
    }


    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');
    }
}

