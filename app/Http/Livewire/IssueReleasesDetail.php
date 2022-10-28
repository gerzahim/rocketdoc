<?php

namespace App\Http\Livewire;

use App\Models\Issue;
use Livewire\Component;
use App\Models\Release;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class IssueReleasesDetail extends Component
{
    use AuthorizesRequests;

    public Issue $issue;
    public Release $release;
    public $releasesForSelect = [];
    public $release_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Release';

    protected $rules = [
        'release_id' => ['required', 'exists:releases,id'],
    ];

    public function mount(Issue $issue)
    {
        $this->issue = $issue;
        //$this->releasesForSelect = Release::pluck('name', 'id');
        $this->releasesForSelect = Release::orderBy('released_at')->pluck('name', 'id')->take(2);
        $this->resetReleaseData();
    }

    public function resetReleaseData()
    {
        $this->release = new Release();

        $this->release_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newRelease()
    {
        $this->modalTitle = trans('crud.issue_releases.new_title');
        $this->resetReleaseData();

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

        $this->authorize('create', Release::class);

        $this->issue->releases()->attach($this->release_id, []);

        $this->hideModal();
    }

    public function detach($release)
    {
        $this->authorize('delete-any', Release::class);

        $this->issue->releases()->detach($release);

        $this->resetReleaseData();
    }

    public function render()
    {
        return view('livewire.issue-releases-detail', [
            'issueReleases' => $this->issue
                ->releases()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
