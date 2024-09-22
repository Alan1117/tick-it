<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Models\TicketStatus;
use App\Models\TicketType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tickets.index')->with([
            'tickets' => auth()->user()->tickets()->with('ticketType', 'ticketStatus')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create')->with([
            'ticketTypes' => TicketType::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request)
    {
        $ticketTypeId = $request->get('ticket_type_id');
        $description = $request->get('description');
        $title = $request->get('title');

        try {
            DB::beginTransaction();
            $ticket = Ticket::create([
                'title' => $title,
                'description' => $description,
                'ticket_status_id' => TicketStatus::submitted()->id,
                'created_by_user_id' => auth()->user()->id,
                'ticket_type_id' => $ticketTypeId
            ]);
            $ticket->histories()->create([
                'current_ticket_status_id' => TicketStatus::submitted()->id,
                'user_id' => auth()->user()->id,
                'reason' => 'Ticket Created By Customer'
            ]);
            DB::commit();
            return redirect()->action([TicketController::class, 'show'],['ticket' => $ticket->id])->with('success', "Your Case Number is " . $ticket->id);
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('danger', $exception->getMessage());
        }
    }

    public function search(Request $request)
    {
        $id = $request->get('case_number');
        $ticket = Ticket::where('id', $id)->where('created_by_user_id', auth()->user()->id)->first();
        if (! $ticket) {
            return back()->with('danger', "Ticket Not Found");
        }
        return redirect()->action([TicketController::class, 'show'],['ticket' => $ticket->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        return view('tickets.view')->with([
            'ticket' => $ticket
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function reopen(Ticket $ticket)
    {
        try {
            DB::beginTransaction();
            $prev = $ticket->ticket_status_id;
            $ticket->update([
                'is_resolved' => false,
                'ticket_status_id' => TicketStatus::reopened()->id,
            ]);
            $ticket->histories()->create([
                'previous_ticket_status_id' => $prev,
                'current_ticket_status_id' => $ticket->ticket_status_id,
                'user_id' => $ticket->resolved_by_user_id,
                'reason' => "Ticket Reopened By Customer"
            ]);
            DB::commit();
            return back()->with('success', "Your Ticket Has Been Reopened");
        } catch (\Exception $exception) {
            DB::rollBack();
            return back()->with('danger', $exception->getMessage());
        }
    }
}
