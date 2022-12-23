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
        $rules = [
            'name'          => 'required',
            'email'         => 'required',
            'categories'     => 'required',
            'priority'      => 'required',
            'user_id'       => 'required|int',
            'issue'         => 'required',
            'status'        => 'required',
        ];

        $messages = [
            'name.required'        => 'El campo es requerido.',
            'user_id.required'     => 'El campo debe ser int.',
            'user_id.int'          => 'El campo debe ser int.',
            'issue.required' => 'El campo es requerido.',
            'status.required'      => 'El campo es requerido.',
            'priority.required'    => 'El campo es requerido.',
            'email.required'    => 'El campo es requerido.',
            'categories.required'    => 'El campo es requerido.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );
        }

        $ticket = $this->model->create([
            'user_id'    => $request->user_id,
            'name'       => $request->name,
            'issue'      => $request->issue,
            'priority'   => $request->priority,
            'status'     => $request->status,
            'email'      => $request->email,
            'categories' => $request->categories,
        ]);

        return response()->json(
            [
                'message'   => 'ticket registrado exitosamente',
                'data'      => $ticket
            ],
             200 // state HTTP
         );
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

    public function delete(int $id)
    {
        $ticket = $this->model->find($id);
        if ( is_null($ticket) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }

        $ticket->delete();

        return response()->json(
            [
                'message' => 'ticket eliminado'
            ],
            200
        );

    }
}
