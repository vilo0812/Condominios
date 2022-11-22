<?php

namespace App\Http\Controllers\Api\Support;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{

    private $model;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->model      = new Support();
    }
    //listo LISTO
    public function listAdmin()
    {
        $ticket = Support::OrderBy('id', 'asc')->get();
       /* foreach ($ticket as $ticke) {

            $message = MessageTicket::where('id_ticket', '=', $ticke->id)
                ->where('type', 0)
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


    // Permite ver el ticket LISTO
    public function showAdmin($id)
    {
        $ticket = Support::find($id);
        //$message = MessageTicket::all()->where('id_ticket', $id);
        //$email = User::find(1);
        //$admin = $email->email;

        return response()->json($ticket, 200);
    }

    // permite editar el ticket


    // permite actualizar el ticket LISTO

    public function updateAdmin(Request $request)
    {

        $ticket = Support::find($request->ticket_id);

        $$ticket = $this->model->find($request->ticket_id);
        if ( is_null($ticket) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }
        $ticket->update($request->all());

        return response()->json(
            [
                'message'   => 'se actualizo el ticket correctamente',
                'data'      => $ticket
            ],
            200 // state HTTP
        );
    }



    /**
     * Permite obtener la cantidad de Tickets que tiene un usuario
     *
     * @param integer $user_id
     * @return integer
     */

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
        Support::create([
            'user_id' => Auth::id(),
            'issue' => request('issue'),
            'categories' => request('categories'),
            'priority' => request('priority')
        ]);

        $ticket_create = Support::where('user_id', Auth::id())->orderby('created_at', 'DESC')->take(1)->get();
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


    // permite actualizar el ticket LISTO
    public function updateUser(Request $request)
    {

        $ticket = Support::find($request->ticket_id);

       $ticket = $this->model->find($request->ticket_id);
        if ( is_null($ticket) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }
        $ticket->update($request->all());

        return response()->json(
            [
                'message'   => 'se actualizo el ticket correctamente',
                'data'      => $ticket
            ],
            200 // state HTTP
        );
    }

    // permite ver la lista de tickets LISTO
    public function listUser(Request $request)
    {
        $ticket = Support::where('user_id', Auth::id())->get();
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
        $ticket =  Support::find($id);
       /* $message = MessageTicket::all()->where('id_ticket', $id);
        $email = User::find(1);
        $admin = $email->email;*/
        return response()->json($ticket, 200);
    }
}
