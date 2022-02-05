<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {

    }

    public function create(Client $client)
    {
        $categories = Category::with('products')->get();
        return view('dashboard.orders.create',['categories'=>$categories,'client'=>$client]);

    }

    public function store(Request $request)
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
