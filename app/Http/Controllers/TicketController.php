<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Release;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\TicketUpdateRequest;
use Session;


class TicketController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $this->authorize('view-any', Ticket::class);

        $search = $request->get('search', '');

        $tickets = Ticket::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.tickets.index', compact('tickets', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Ticket::class);

        return view('app.tickets.create');
    }

    /**
     * @param \App\Http\Requests\TicketStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(TicketStoreRequest $request)
    {
        $this->authorize('create', Ticket::class);

        $validated = $request->validated();

        $key = $request->get('key');

        $client = new Client([
            'timeout'  => 5.0,
        ]);

        try
        {
            $response = $client->request(
                'GET',
                'https://paperstreet.atlassian.net/rest/api/3/issue/' . $key,
                [
                    'auth' => [
                        'gerza@paperstreetmedia.com',
                        'p7rU4EUiuwxExu392qew6FA6'
                    ]
                    //'json' => $payload_data,
                ]);

            // 'response_body' => (string) $response->getBody(),
            if ( $response->getStatusCode() === 200 )
            {
                $manage = json_decode($response->getBody(), true);

                $ticket_info = [
                    'summary' => $manage['fields']['summary'],
                    'url'     => 'https://paperstreet.atlassian.net/browse/' . $manage['key'],
                ];

                $result = $validated + $ticket_info;
                $ticket = Ticket::create($result);

                return redirect()
                    ->route('tickets.edit', $ticket)
                    ->withSuccess(__('crud.common.created'));
            }

        } catch (\GuzzleHttp\Exception\RequestException $e) {

            Session::flash('error', 'Not key-Issue Found in Atlassian API');

            return redirect()->route('tickets.index');

        }

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        return view('app.tickets.show', compact('ticket'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $releases = Release::get();

        return view('app.tickets.edit', compact('ticket', 'releases'));
    }

    /**
     * @param \App\Http\Requests\TicketUpdateRequest $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(TicketUpdateRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $validated = $request->validated();
        $ticket->releases()->sync($request->releases);

        $ticket->update($validated);

        return redirect()
            ->route('tickets.edit', $ticket)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
