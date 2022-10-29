<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
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
        /// Adding issues in bulk, alternatives
        /// key = LR,TSV4-5743,OPS-5744,TSV4-5745,OPS-5746,TSV4-5747 , Bulk and attach to latest release
        /// key = LR,5744,5745,5746,5747, Bulk and attach to latest release
        /// key = 5744,5745,5746,5747
        /// key = 5744
        //////////////////////////////////////////

        $attachToLastRelease = false;
        // If only provided Issue-Key, get Issue Info from Jira API
        if ( empty($summary) || empty($url) ) {

            // comma character in the string, means multiple issues provided
            $keys = explode(',', $key);

            // flag to attach to last release
            if (str_contains($key, 'LR') ) {
                $attachToLastRelease = true;
                $lastRelease = Release::latest()->first();
            }

            // loop through each key and add to issues table, BULK
            foreach ($keys as $key) {

                // Verify if Issue exists already in issues table
                $issueKey = $jiraService->formatKey($key);
                $issue = Issue::where('key', $issueKey)->first();

                // If the Issue does not exist, get the Data from Jira API
                if (!$issue) {
                    $issueInfo = $jiraService->getIssueInfo($key);

                    if (empty($issueInfo)) {
                        Session::flash('error', $key.' Issue was not Found,  Atlassian JIRA API');
                        continue;
                    }

                    // Insert Issue into issues table
                    $issue = Issue::create($issueInfo);
                }

                // Attach to last release
                if ($attachToLastRelease) {
                    $lastRelease->issues()->attach($issue->id);
                }
            }
            // redirect to releases page
            if($attachToLastRelease) {
                return redirect()
                    ->route('releases.edit', $lastRelease)
                    ->withSuccess(__('crud.common.saved'));
            }

            // redirect to List of Issues
            return redirect()->route('issues.index')->withSuccess(__('crud.common.created'));


        }else {

            // Manually add Issue without Jira API
            $issueInfo = [
                'key'     => $key,
                'summary' => $summary,
                'url'     => $url,
            ];
            $issue = Issue::create($issueInfo);
        }

        if (empty($issue)){
            Session::flash('error', 'Failed to Create Issue');
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
