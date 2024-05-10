<?php

namespace App\Http\Controllers;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Http\Requests\Tickets\CreateTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Ticket::with('user')
            ->when(request('status') && !empty(request('status')), function ($query) {
                return $query->where('status', request('status'));
            })
            ->when(request('priority') && !empty(request('priority')), function ($query) {
                return $query->where('priority', request('priority'));
            })
            ->when(request('from_date') && !empty(request('from_date')), function ($query) {
                return $query->whereDate('created_at', '>=', request('from_date'));
            })
            ->when(request('to_date') && !empty(request('to_date')), function ($query) {
                return $query->whereDate('created_at', '<=', request('to_date'));
            })
            ->when(request('search') && !empty(request('search')), function ($query) {
                return $query->where(function ($innerQuery) {
                    $innerQuery->where('title', 'like', '%' . request('search') . '%')
                               ->orWhereHas('user', function ($userQuery) {
                                   $userQuery->where('name', 'like', '%' . request('search') . '%')
                                             ->orWhere('email', 'like', '%' . request('search') . '%');
                               });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(config('table.default_per_page'));

        $statuses = TicketStatus::toSelectArray();
        $priorities = TicketPriority::toSelectArray();

        return inertia('Tickets/Index', [
            'tickets' => $tickets,
            'statuses' => $statuses,
            'priorities' => $priorities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = TicketStatus::toSelectArray();
        $priorities = TicketPriority::toSelectArray();

        return inertia('Tickets/CreateTicket', [
            'statuses' => $statuses,
            'priorities' => $priorities
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(CreateTicketRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->id();

        Ticket::create($data);

        return redirect()->route('tickets.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ticket = Ticket::with('user', 'responses')->findOrFail($id);
        return inertia('Tickets/Show', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
