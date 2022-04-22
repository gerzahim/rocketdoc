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
        $releases = Release::where('status', 'completed')
            ->latest()
            ->paginate(100);

        foreach ($releases as $release){
            // get Doc info until the first Horizontal line is found
            $docElements = explode("<hr>", $release->document);
            $release->document = $docElements[0];
        }

        return view('app.releases.home', compact('releases'));
    }


    /**
     * @param $releaseID
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($releaseID)
    {
        $release = Release::find($releaseID);

        return view('app.releases.show', compact('release'));
    }

    /**
     * @param $releaseName
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function searchByName($releaseName)
    {
        $release = Release::where('name', $releaseName)->first();

        return view('app.releases.show', compact('release'));
    }
}
