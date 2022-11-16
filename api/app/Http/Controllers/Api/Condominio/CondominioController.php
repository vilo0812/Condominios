<?php

namespace App\Http\Controllers\Api\Condominio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\Condominio\CondominioRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Condominio;
use App\Http\Resources\Condominio as CondominioResource;

class CondominioController extends Controller
{
    private $repository;
    private $user;
    private $model;

    public function __construct()
    {
        $this->user       = Auth::guard('api')->user();
        $this->model      = new Condominio();
    }

    public function index(Request $request)
    {      
        $perPage  = $request->get('perPage');
        $order    = $request->get('order');

        is_null($perPage)  ? $perPage = 100     : $perPage  = (int)$perPage;
        is_null($order)    ? $order    = 'desc' : $order    = $order;
        $data =  $this->model->orderBy('id', $order)->paginate($perPage);
        return response()->json(
            [
                'condominios'     => $data->items() ,
                'paginate' =>  [
                    'current_page'=> $data->currentPage(),
                    'totalPage'   => $data->total(),
                    'last_page'   => $data->lastPage(),
                    'perPage'     => $data->perPage()
                ]
            ],
            200
        );
    }

    public function store(Request $request)
    {  
        $rules = [
            'name'         => 'required',
            'user_id'      => 'required|int',
            'description'  => 'required',
            'amount'       => 'required|numeric',
            'dues'         => 'required|int',
            'status'       => 'required',
            'location'     => 'required',
        ];
       
        $messages = [
            'name.required'        => 'El campo es requerido.',
            'user_id.required'     => 'El campo debe ser int.',
            'user_id.int'          => 'El campo debe ser int.',
            'description.required' => 'El campo es requerido.',
            'amount.required'      => 'El campo es requerido.',
            'amount.numeric'        => 'El campo debe ser numeric',
            'dues.required'        => 'El campo es requerido.',
            'dues.int'             => 'El campo debe ser int.',
            'status.required'      => 'El campo es requerido.',
            'location.required'    => 'El campo es requerido.',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );
        }

        $condominio = $this->model->create([
            'user_id'    => $request->user_id,
            'name'       => $request->name,
            'description'=> $request->description,
            'amount'     => $request->amount,
            'dues'       => $request->dues,
            'status'     => $request->status,
            'location'   => $request->location,
        ]);
      
        return response()->json(
            [
                'message'   => 'Condominio registrado exitosamente',
                'data'      => $condominio 
            ],
             200 // state HTTP
         );
    }

    public function update(Request $request, int $id)
    {
        $condominio = $this->model->find($id);
        if ( is_null($condominio) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }
        
        $condominio->update($request->all());
        return response()->json(
            [
                'message'   => 'se actualizo el condominio correctamente',
                'data'      => $condominio 
            ],
            200 // state HTTP
        );
    }

    public function show(int $id)
    {
        $condominio = $this->model->find($id);
        if ( is_null($condominio) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }

        return response()->json(
             $condominio ,
            200 // state HTTP
        );

    }

    public function destroy(int $id)
    {
        $condominio = $this->model->find($id);
        if ( is_null($condominio) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }

        $condominio->delete();

        return response()->json(
            [
                'message' => 'Condominio eliminado'
            ],
            200
        );

    }

}
