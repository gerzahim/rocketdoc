<?php

namespace App\Http\Controllers;

use App\Models\Issue;
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

        //        $dt = new Carbon($release->released_at);
        //        $release_released_at = $dt->toFormattedDateString();

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

        //$tickets = Ticket::get();
        //$issues = Issue::get();

        return view('app.releases.create', compact('projects'));
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

        //$release->tickets()->attach($request->tickets);

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
        $issues = Issue::get();

        if($release->document == null){
            $release->document = $this->createDocumentFromTemplate($release);
        }
        dd($release->document);
        
        return view(
            'app.releases.edit',
            compact('release', 'projects', 'issues')
        );
    }

    /**
     * @param \App\Http\Requests\ReleaseUpdateRequest $request
     * @param \App\Models\Release $release
     * @return \Illuminate\Http\Response
     */
    public function update(ReleaseUpdateRequest $request, Release $release)
    {
        dd($release->document);
        $this->authorize('update', $release);

        $validated = $request->validated();

        //$release->issues()->sync($request->issues);
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

    /**
     * Get Template
     */
    public function createDocumentFromTemplate($release): array|string
    {
        // Get template
        $template = Template::first();


        // Get Date release in human Readable Format  => Dec 25, 1975
        $dt = new Carbon($release->released_at);
        $release_released_at = $dt->toFormattedDateString();

        // Array contains search terms to replace on the Doc Text
        $searchVal = ["replaceTerm1", "replaceTerm2", "<p>replaceTerm3</p>", "replaceTerm4", "replaceTerm5", "replaceTerm6"];

        // Array contains the new values to be substituted
        $replaceVal = [$release->name, $release_released_at, $this->getIssuesAssociated($release), $release->name, $this->getIssuesPreCodeTagFormat($release), $this->getIssuesMarkdownFormat($release)];

        // return Doc template with custom values replaced.
        return str_replace($searchVal, $replaceVal, $template->document);

    }

    /**
     * return list of issues as (bulleted) list.
     * @param $release
     * @return string
     */
    public function getIssuesAssociated($release): string
    {

        $listIssues = "<ul>";
        foreach($release->issues as $issue){
            $listIssues.= "<li> <a href='{$issue->url}'>{$issue->key}</a> {$issue->summary}</li>";
        }
        $listIssues.="</ul>";

        return $listIssues;
    }

    /**
     * return list of issues on in <code> format for Markdown
     * @param $release
     * @return string
     */
    public function getIssuesPreCodeTagFormat($release): string
    {
        $listIssues = '<pre data-language="Plain text" spellcheck="false"><code class="language-plaintext">';
        $firsTime = true;
        foreach($release->issues as $issue){
            if($firsTime){
                $listIssues.= "{$issue->key} {$issue->summary}";
            }else{
                $listIssues.= "<br>{$issue->key} {$issue->summary}";
            }
            $firsTime = false;
        }
        $listIssues.="</code></pre>";

        return $listIssues;
    }



    /**
     * return list of issues on in <code> format for Markdown
     * @param $release
     * @return string
     */
    public function getIssuesMarkdownFormat($release): string
    {
        $listIssues = '<pre data-language="Plain text" spellcheck="false"><code class="language-plaintext">';
        $firsTime = true;
        foreach($release->issues as $issue){
            if($firsTime){
                $listIssues.= trim("{$issue->key} {$issue->summary}  \ ");
            }else{
                $listIssues.= trim("<br>{$issue->key} {$issue->summary}  \ ");
            }
            $firsTime = false;
        }
        $listIssues.="</code></pre>";

        return $listIssues;
    }
}
