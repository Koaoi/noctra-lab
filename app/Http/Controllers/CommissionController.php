<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        return view('commission.index');
    }

    public function create()
    {
        return view('commission.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($commission)
    {
        return view('commission.show');
    }
}