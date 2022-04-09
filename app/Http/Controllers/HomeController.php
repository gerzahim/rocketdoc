<?php

namespace App\Http\Controllers;

use App\Models\Release;
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
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $releases = Release::latest()
            ->paginate(100);


        foreach ($releases as $release){
            $arrA = explode("<hr>", $release->document);
            $release->document = $arrA[0]."<br>";
        }

        return view('app.releases.home', compact('releases'));
    }
}
