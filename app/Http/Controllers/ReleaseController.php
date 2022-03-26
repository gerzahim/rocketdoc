<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Release;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ReleaseStoreRequest;
use App\Http\Requests\ReleaseUpdateRequest;
use App\Models\Template;

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

    public function createDocumentFromTemplate($release)
    {
        $template = Template::first();

        //return $template->document;

        // Array containing search string
        $searchVal = array("replace1", "replace2", "replace3", "replace4", "replace5");

        // Array containing replace string from  search string
        $replaceVal = array($release->name, $release->created_at, 'list_tickets', $release->name, 'list_tags');

        return str_replace($searchVal, $replaceVal, $template->document);

    }

    public function getTicketsAssociated(){
        /*
         <ul><li>TSV4-5112 &nbsp;Custom carousel shows Locked on the Homepage</li><li>TSV4-5107 &nbsp;sentry Exception Admin\ModelController@getDelete</li><li>TSV4-5111 &nbsp; sentry Exception on AccessTokenGuard</li><li>TSV4-5109 &nbsp;Double Insertion on likes/dislikes interaction</li><li>TSV4-5120 &nbsp;Delete name field from “ts_movies” &nbsp;index ES</li></ul>
         */
    }


    public function getTags()
    {
        /*<pre data-language="Plain text" spellcheck="false"><code class="language-plaintext">TSV4-5112  Custom carousel shows Locked on the Homepage<br>TSV4-5107  sentry Exception Admin\ModelController@getDelete<br>TSV4-5111  sentry Exception on AccessTokenGuard<br>TSV4-5109  Double Insertion on likes/dislikes interaction <br>TSV4-5120  Delete name field from “ts_movies”  index ES</code></pre>*/
    }
}
