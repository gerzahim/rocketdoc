<?php

namespace App\Http\Livewire;

use App\Models\Issue;
use Livewire\Component;
use App\Models\Release;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReleaseIssuesDetail extends Component
{
    use AuthorizesRequests;

    public Release $release;
    public Issue $issue;
    public $issuesForSelect = [];
    public $issue_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Issue';

    protected $rules = [
        'issue_id' => ['required', 'exists:issues,id'],
    ];

    public function mount(Release $release)
    {
        $this->release = $release;
        $issues = Issue::orderBy('key', 'desc')->get();

        foreach($issues as $issue) {
            $this->issuesForSelect[] = [
                'id'      => $issue->id,
                'key'     => $issue->key,
                'summary' => $issue->summary,
                'name'    => "{$issue->key} {$issue->summary}",
            ];
        }

        //$this->issuesForSelect = Issue::pluck('key', 'id');
        $this->resetIssueData();
    }

    public function resetIssueData()
    {
        $this->issue = new Issue();

        $this->issue_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newIssue()
    {
        $this->modalTitle = trans('crud.issue_releases.new_title');
        $this->resetIssueData();

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        $this->authorize('create', Issue::class);

        $this->release->issues()->attach($this->issue_id, []);

        $this->hideModal();
    }

    public function detach($issue)
    {
        $this->authorize('delete-any', Issue::class);

        $this->release->issues()->detach($issue);

        $this->resetIssueData();
    }

    public function render()
    {
        return view('livewire.release-issues-detail', [
            'releaseIssues' => $this->release
                ->issues()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
