<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ticket as Ticket;

class TicketController 
{
    public function all() {
        $alltickets = Ticket::all();
        return response()->json(['error' => false, 'message' => '', 'data' => $alltickets], 200);
    }

    public function ticketById($id) {
        $ticket = Ticket::find($id);
        return response()->json(['error' => false, 'message' => '', 'data' => $ticket], 200);
    }

    public function save(Request $req) {
        $ticket = Ticket::find($req->no);
        if (!$ticket) {
          $ticket = new Ticket();
        }        
        $ticket->{'Title'} = $req->data['title'];
        $ticket->save();
        return response()->json(['error' => false, 'message' => 'Données enregistrées', 'data' => $ticket], 200);
    }
}