<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Release;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ReleaseStoreRequest;
use App\Http\Requests\ReleaseUpdateRequest;
use App\Models\Template;
use Carbon\Carbon;

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

        if($release->document == null){
            $release->document = $this->createDocumentFromTemplate($release);
        }

        return view(
            'app.releases.edit',
            compact('release', 'projects', 'tickets')
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

    /*
     * Get Template
     */
    public function createDocumentFromTemplate($release)
    {
        // Get template
        $template = Template::first();

        // Array containing search term to replace on the Doc
        $searchVal = ["replaceTerm1", "replaceTerm2", "<p>replaceTerm3</p>", "replaceTerm4", "replaceTerm5"];

        // Get Date release in human Readable Format  => Dec 25, 1975
        $dt = new Carbon($release->released_at);
        $release_released_at = $dt->toFormattedDateString();

        // Array containing values to replace
        $replaceVal = [$release->name, $release_released_at, $this->getTicketsAssociated($release), $release->name, $this->getTags($release)];

        // return Doc template with custom values replaced.
        return str_replace($searchVal, $replaceVal, $template->document);

    }

    public function getTicketsAssociated($release){

        $listTickets = "<ul>";
        foreach($release->tickets as $ticket){
            $listTickets.="<li> {$ticket->reference} {$ticket->name}</li>";
        }
        $listTickets.="</ul>";

        return $listTickets;

    }


    public function getTags($release)
    {
        $listTags = '<pre data-language="Plain text" spellcheck="false"><code class="language-plaintext">';
        $firsTime = true;
        foreach($release->tickets as $ticket){
            if($firsTime){
                $listTags.= "{$ticket->reference} {$ticket->name}";
            }else{
                $listTags.= "<br>{$ticket->reference} {$ticket->name}";
            }
            $firsTime = false;
        }
        $listTags.="</code></pre>";

        return $listTags;
    }
}
