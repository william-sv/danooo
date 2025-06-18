<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json(["version" => "1.0", "author" => "songlin1221@icloud.com"], 200);
    }
}
