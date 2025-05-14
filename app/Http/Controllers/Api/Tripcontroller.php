<?php

namespace App\Http\Controllers\Api;

use App\Models\Trip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Tripcontroller extends Controller
{
    //
    public function index()
    {
        $trips = Trip::with(['bus', 'company'])->get();

        return response()->json($trips);
    }
}
