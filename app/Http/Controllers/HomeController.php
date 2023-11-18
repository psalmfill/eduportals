<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\VendorCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $schools = School::all();
        return view('index', compact('schools'));
    }

    public function getStarted()
    {
        $vendorCategories = VendorCategory::all();
        return view('get_started', compact('vendorCategories'));
    }
}
