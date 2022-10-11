<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\MessageTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use App\Models\User;


class TicketsController extends Controller
{

    //Tickets Del Admin

    // permite ver la lista de tickets

    public function listAdmin()
    {
        $ticket = Ticket::all();
        foreach ($ticket as $ticke) {

            $message = MessageTicket::where('id_ticket', '=', $ticke->id)
                ->where('type', 0)
                ->select('created_at')
                ->orderBy('id', 'desc')
                ->first();
            $ticke->send = '';
            if ($message != null) {
                $ticke->send = $message->created_at->diffForHumans();
            }
        }
        return response()->json($ticket, 200);
    }


    // Permite ver el ticket
    public function showAdmin($id)
    {
        $ticket = Ticket::find($id);
        //$message = MessageTicket::all()->where('id_ticket', $id);
        //$email = User::find(1);
        //$admin = $email->email;

        return response()->json($ticket, 200);
    }

    // permite editar el ticket

    public function editAdmin($id)
    {
        $ticket = Ticket::find($id);
       // $message = MessageTicket::where('id_ticket', $id)->orderby('created_at', 'ASC')->get();
        //$email = User::all()->where('id');

        //$admin = $email[0]->email;

        return response()->json($ticket, 200);
    }
    // permite actualizar el ticket

    public function updateAdmin(Request $request, $id)
    {
        $ticket = Ticket::find($id);

        $ticket->update($request->all());
        $ticket->save();

        $validate = $request->validate([
            'image' => 'image|max:2048',
           // 'message' => 'min:2'
        ]);

        if ($validate && $request->hasFile('image')) {
            $imagen = $request->file('image');
            $nombre = time() . '.' . $imagen->getClientOriginalName();
            $destino = public_path('storage');
            $request->image->move($destino, $nombre);

        /*MessageTicket::create([
            'user_id' => $ticket->user_id,
            'id_admin' => Auth::id(),
            'id_ticket' => $ticket->id,
            'type' => '1',
            'message' => request('message'),
            'image' => $nombre
        ]);*/
    }else{
       /* MessageTicket::create([
            'user_id' => $ticket->user_id,
            'id_admin' => Auth::id(),
            'id_ticket' => $ticket->id,
            'type' => '1',
            'message' => request('message'),
        ]);*/
    }


    return response()->json('ticket update succesfully', 201);
    }



    /**
     * Permite obtener la cantidad de Tickets que tiene un usuario
     *
     * @param integer $user_id
     * @return integer
     */
    public function getTotalTickets($user_id): int
    {
        try {
            $Tickets = Ticket::where('user_id', $user_id)->get()->count('id');
            if ($user_id == 1) {
                $Tickets = Ticket::all()->count('id');
            }
            return $Tickets;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Permite obtener el total de Tickets por meses
     *
     * @param integer $user_id
     * @return array
     */
    public function getDataGraphiTickets($user_id): array
    {
        try {
            $totalTickets = [];
            if (Auth::user()->admin == 1) {
                $Tickets = Ticket::select(DB::raw('COUNT(id) as Tickets'))->where([['status', '>=', 0]])
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                    ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                    ->take(6)
                    ->get();
            } else {
                $Tickets = Ticket::select(DB::raw('COUNT(id) as Tickets'))
                    ->where([
                        ['user_id', '=',  $user_id],
                        ['status', '>=', 0]
                    ])
                    ->groupBy(DB::raw('YEAR(created_at)'), DB::raw('MONTH(created_at)'))
                    ->orderBy(DB::raw('YEAR(created_at)'), 'ASC')
                    ->orderBy(DB::raw('MONTH(created_at)'), 'ASC')
                    ->take(6)
                    ->get();
            }
            foreach ($Tickets as $ticket) {
                $totalTickets[] = $ticket->Tickets;
            }
            return $totalTickets;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    // permite ver la vista de creacion del ticket
    public function create()
    {
       // $email = User::find(1);
       // $admin = $email->email;
        //return view('tickets.create')->with('admin', $admin);
    }

    // permite la creacion del ticket
    public function store(Request $request)
    {
        Ticket::create([
            'user_id' => Auth::id(),
            'issue' => request('issue'),
            'categories' => request('categories'),
            'priority' => request('priority')
        ]);

        $ticket_create = Ticket::where('user_id', Auth::id())->orderby('created_at', 'DESC')->take(1)->get();
        $id_ticket = $ticket_create[0]->id;


        $validate = $request->validate([
            'image' => 'image|max:2048',
            'message' => 'min:2'

        ]);

        if ($validate && $request->hasFile('image')) {
            $imagen = $request->file('image');
            $nombre = time() . '.' . $imagen->getClientOriginalName();
            $destino = public_path('storage');
            $request->image->move($destino, $nombre);


           /* MessageTicket::create([
                'user_id' => Auth::id(),
                'id_admin' => '1',
                'id_ticket' => $id_ticket,
                'type' => '0',
                'message' => request('message'),
                'image' => $nombre

            ]);*/
        } else {
           /* MessageTicket::create([
                'user_id' => Auth::id(),
                'id_admin' => '1',
                'id_ticket' => $id_ticket,
                'type' => '0',
                'message' => request('message'),
            ]);*/
        }

        return response()->json('ticket created succesfully', 201);
    }

    // permite editar el ticket
    public function editUser($id)
    {
        $ticket = Ticket::find($id);
        //$message = MessageTicket::where('id_ticket', $id)->orderby('created_at', 'ASC')->get();
        //$imagenes = MessageTicket::all('image');
       // $email = User::all()->where('id');
        //$admin = $email[0]->email;

        return response()->json($ticket, 200);

    }

    // permite actualizar el ticket
    public function updateUser(Request $request, $id)
    {

        $ticket = Ticket::find($id);
        $ticket->update($request->all());

        $validate = $request->validate([
            'image' => 'image|max:2048',
            'message' => 'min:2'
        ]);

        if ($validate && $request->hasFile('image')) {
            $imagen = $request->file('image');
            $nombre = time() . '.' . $imagen->getClientOriginalName();
            $destino = public_path('storage');
            $request->image->move($destino, $nombre);


            /*MessageTicket::create([
                'user_id' => Auth::id(),
                'id_admin' => '1',
                'id_ticket' => $ticket->id,
                'type' => '0',
                'message' => request('message'),
                'image' => $nombre
            ]);*/
        } else {
           /* MessageTicket::create([
                'user_id' => Auth::id(),
                'id_admin' => '1',
                'id_ticket' => $ticket->id,
                'type' => '0',
                'message' => request('message'),
            ]);*/
        }

        $ticket->save();

        return response()->json('ticket update succesfully', 201);
    }

    // permite ver la lista de tickets
    public function listUser(Request $request)
    {

        $ticket = Ticket::where('user_id', Auth::id())->get();
       /* foreach ($ticket as $ticke) {
            $message = MessageTicket::where('id_ticket', '=', $ticke->id)
                ->where('type', 1)
                ->select('created_at')
                ->orderBy('id', 'desc')
                ->first();
            $ticke->send = '';
            if ($message != null) {
                $ticke->send = $message->created_at->diffForHumans();
            }
        }*/
        return response()->json($ticket, 200);
    }

    // permite ver el ticket
    public function showUser($id)
    {
        $ticket = Ticket::find($id);
       /* $message = MessageTicket::all()->where('id_ticket', $id);
        $email = User::find(1);
        $admin = $email->email;*/
        return response()->json($ticket, 200);
    }
}
