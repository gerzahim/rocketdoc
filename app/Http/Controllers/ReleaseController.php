<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Release;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ReleaseStoreRequest;
use App\Http\Requests\ReleaseUpdateRequest;
use Illuminate\Support\Str;

class ReleaseController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Release::class);

        $search = $request->get('search', '');

        $releases = Release::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.releases.index', compact('releases', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Release::class);

        $projects = Project::pluck('name', 'id');

        $tickets = Ticket::get();

        return view('app.releases.create', compact('projects', 'tickets'));
    }

    /**
     * @param \App\Http\Requests\ReleaseStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReleaseStoreRequest $request)
    {
        $this->authorize('create', Release::class);

        $validated = $request->validated();

        $release = Release::create($validated);

        $release->tickets()->attach($request->tickets);

        return redirect()
            ->route('releases.edit', $release)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Release $release)
    {
        $this->authorize('view', $release);

        return view('app.releases.show', compact('release'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Release $release)
    {
        $this->authorize('update', $release);

        $projects = Project::pluck('name', 'id');

        $tickets = Ticket::get();

        $document_parsed = Str::of($release->document)->markdown();
//        $document_parsed = Str::of($release->document)->markdown([
//            'html_input' => 'strip',
//        ]);

        return view(
            'app.releases.edit',
            compact('release', 'projects', 'tickets', 'document_parsed')
        );
    }

    /**
     * @param \App\Http\Requests\ReleaseUpdateRequest $request
     * @param \App\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function update(ReleaseUpdateRequest $request, Release $release)
    {
        $this->authorize('update', $release);

        $validated = $request->validated();
        $release->tickets()->sync($request->tickets);

        $release->update($validated);

        return redirect()
            ->route('releases.edit', $release)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Release $release)
    {
        $this->authorize('delete', $release);

        $release->delete();

        return redirect()
            ->route('releases.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
