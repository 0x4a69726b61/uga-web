<?php

namespace App\Http\Controllers;

use App\University;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdministrationController extends Controller
{
    public function index(): Response
    {
        return response()->view("administration.index", [
            "universities" => University::count()
        ]);
    }
}
