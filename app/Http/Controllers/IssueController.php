<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Release;
use App\Services\JiraService;
use Illuminate\Http\Request;
use App\Http\Requests\IssueStoreRequest;
use App\Http\Requests\IssueUpdateRequest;
use Session;

class IssueController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Issue::class);

        $search = $request->get('search', '');

        $issues = Issue::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.issues.index', compact('issues', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Issue::class);

        return view('app.issues.create');
    }

    /**
     * @param \App\Http\Requests\IssueStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(IssueStoreRequest $request, JiraService $jiraService)
    {
        $this->authorize('create', Issue::class);

        $request->validated();

        $key = $request->get('key');
        $summary = $request->get('summary');
        $url = $request->get('url');

        $issueInfo = [
            'key'     => $key,
            'summary' => $summary,
            'url'     => $url,
        ];


        // If only get Issue-Key from form , fetch all Info from Jira API
        if( empty($summary) || empty($url)) {
            $issueInfo = $jiraService->getIssueInfo($key);
        }

        if (empty($issueInfo)){
            Session::flash('error', 'Issue not Found,  Atlassian JIRA API');

            return redirect()->route('issues.index');
        }

        $issue = Issue::create($issueInfo);
        return redirect()
            ->route('issues.edit', $issue)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Issue $issue)
    {
        $this->authorize('view', $issue);

        return view('app.issues.show', compact('issue'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Issue $issue)
    {
        $this->authorize('update', $issue);

        $releases = Release::get();

        return view('app.issues.edit', compact('issue', 'releases'));
    }

    /**
     * @param \App\Http\Requests\IssueUpdateRequest $request
     * @param \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function update(IssueUpdateRequest $request, Issue $issue)
    {
        $this->authorize('update', $issue);

        $request->validated();
        //$issue->releases()->sync($request->releases);

        $issueInfo = [
            'key'     => $request->key,
            'summary' => $request->summary,
            'url'     => $request->url,
        ];

        $issue->update($issueInfo);

        return redirect()
            ->route('issues.edit', $issue)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Issue $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Issue $issue)
    {
        $this->authorize('delete', $issue);

        $issue->delete();

        return redirect()
            ->route('issues.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
