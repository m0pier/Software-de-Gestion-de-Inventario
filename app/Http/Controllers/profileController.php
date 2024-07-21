<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class profileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function profile()
    {
        return view("profile");
    }

}
