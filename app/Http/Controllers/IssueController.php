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
            ->paginate(10)
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
        ///////////////////////////////////////////
        /// Adding issues options
        /// option1 = LR,5743,5744,5745,5746,5747 , Bulk and attach to latest release
        /// option2 = 5744,5745,5746,5747 , bulk
        /// option3 = TSV4-5743 , one by one
        //////////////////////////////////////////



        $this->authorize('create', Issue::class);

        $request->validated();

        $key = $request->get('key');
        $summary = $request->get('summary');
        $url = $request->get('url');

        ///////////////////////////////////////////
        /// Adding issues in bulk
        /// option1 = LR,5743,5744,5745,5746,5747
        /// option2 = 5744,5745,5746,5747
        //////////////////////////////////////////

        $attachToLastRelease = false;
        // If only provided Issue-Key, build Issue Info from Jira API
        if ( empty($summary) || empty($url) ) {

            // if key provided contains comma character in the string, means multiple issues provided
            if ( str_contains($key, ',') ) {

                $keys = explode(',', $key);

                // flag to attach to last release
                if (str_contains($key, 'LR') ) {
                    $attachToLastRelease = true;
                }

                // loop through each key and add to issues table
                foreach ($keys as $key) {
                    $issueInfo = $jiraService->getIssueInfo($key);

                    if (empty($issueInfo)) {
                        Session::flash('error', $key.' Issue was not Found,  Atlassian JIRA API');
                        continue;
                    }

                    $issue = Issue::create($issueInfo);

                    if ($attachToLastRelease) {
                        $lastRelease = Release::latest()->first();
                        $lastRelease->issues()->attach($issue->id);
                    }
                }
            }
        }

//        $issueInfo = [
//            'key'     => $key,
//            'summary' => $summary,
//            'url'     => $url,
//        ];
//

//        $issue = Issue::create($issueInfo);

        if (empty($issue)){
            Session::flash('error', 'Issue not Found,  Atlassian JIRA API');
            return redirect()->route('issues.index');
        }

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
