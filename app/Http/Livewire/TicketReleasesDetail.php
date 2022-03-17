<?php

namespace App\Http\Livewire;

use App\Models\Ticket;
use Livewire\Component;
use App\Models\Release;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TicketReleasesDetail extends Component
{
    use AuthorizesRequests;

    public Ticket $ticket;
    public Release $release;
    public $releasesForSelect = [];
    public $release_id = null;

    public $showingModal = false;
    public $modalTitle = 'New Release';

    protected $rules = [
        'release_id' => ['required', 'exists:releases,id'],
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->releasesForSelect = Release::pluck('name', 'id');
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
        $this->modalTitle = trans('crud.ticket_releases.new_title');
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

        $this->ticket->releases()->attach($this->release_id, []);

        $this->hideModal();
    }

    public function detach($release)
    {
        $this->authorize('delete-any', Release::class);

        $this->ticket->releases()->detach($release);

        $this->resetReleaseData();
    }

    public function render()
    {
        return view('livewire.ticket-releases-detail', [
            'ticketReleases' => $this->ticket
                ->releases()
                ->withPivot([])
                ->paginate(20),
        ]);
    }
}
