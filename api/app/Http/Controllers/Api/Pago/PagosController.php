<?php

namespace App\Http\Controllers\Api\Pago;

use App\Http\Controllers\Controller;
use App\Models\Condominio;
use App\Models\Factura;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Pago;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Storage;
use PDF;


class PagosController extends Controller
{
    

    private $repository;
    private $user;
    private $model;

    public function __construct()
    {
        $this->user       = Auth::guard('api')->user();
        $this->model      = new Pago();
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
                'pagos'     => $data->items() ,
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
            'condominio_id'  => 'required|int',
            'reference'      => 'required',
            'amount'         => 'required|numeric',
            'status'         => 'required'
        ];
       
        $messages = [
            'condominio_id.required' => 'El campo es requerido.',
            'reference.required'     => 'El campo es requerido.',
            'amount.required'        => 'El campo es requerido.',
            'amount.numeric'         => 'El campo debe ser numeric',
            'status.required'        => 'El campo es requerido.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );
        }

        if ($request->hasFile('reference')) {
            $condominio = Condominio::find($request->condominio_id);
            $image = $request->file('reference');
            $name =  str_replace( " ", "_", $image->getClientOriginalName() );
            $filename = url('/').'/storage/reference/' . $condominio->user_id .'/'. $condominio->id .'/'.$name;
            if ( $image->move( public_path( 'storage/reference/' . $condominio->user_id .'/'. $condominio->id .'/' ), $filename ) ) {
            }
        }else{
            return response()->json(
                [
                    'message'   => 'Debe enviar un archvio file correcto.'
                ],
                 400 // state HTTP
            );
        }

        $pago = $this->model->create([
            'condominio_id'  => $request->condominio_id,
            'reference'      => $filename,
            'amount'         => $request->amount,
            'status'         => $request->status
        ]);
      
        return response()->json(
            [
                'message'   => 'Pago registrado exitosamente',
                'data'      => $pago 
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
        return response()->json(
            [
                'message'   => 'No se pueden editar los pagos.'
           
            ],
            200 // state HTTP
        );
        $condominio->update($request->all());
        return response()->json(
            [
                'message'   => 'se actualizo el pago correctamente',
                'data'      => $condominio 
            ],
            200 // state HTTP
        );
    }

    public function show(int $id)
    {
        $pago = $this->model->find($id);
        if ( is_null($pago) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }

        return response()->json(
             $pago ,
            200 // state HTTP
        );

    }

    public function destroy(int $id)
    {
        $pago = $this->model->find($id);
        if ( is_null($pago) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }

        $pago->delete();

        return response()->json(
            [
                'message' => 'Pago eliminado'
            ],
            200
        );

    }

    public function statusPagos (Request $request)
    {

        $rules = [
            'pago_id' => 'required',
            'status'  => 'required'
        ];
       
        $messages = [
            'pago_id.required' => 'El campo es requerido.',
            'status.required'  => 'El campo es requerido.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        
        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );
        }

        $pago = $this->model->find($request->pago_id);
        if ( is_null($pago) ) {
            return response()->json( [ 'message'   => 'no se encontro datos.' ], 404 );
        }
    
        if ( $request->status === 'aprovado' ) {

            $user_id = $pago->condominio->user->id;
            $condominio_id = $pago->condominio->id;
            $pdf = PDF::loadView( 'pdf.factura', [ 'pago' => $pago ] );
            $nameFile = url('/')."/storage/facturas/$user_id/$condominio_id/$pago->id-factura.pdf";
            
            if ( Storage::disk()->put("public/facturas/$user_id/$condominio_id/$pago->id-factura.pdf", $pdf->output() ) ) {
                $factura = Factura::create([
                    'pago_id'   => $pago->id,
                    'reference' => $nameFile,
                    'status'    => 'generada'
                ]);
                return response()->json(
                    [
                        'message' => 'Factura generada con exito.',
                        'factura' => $factura
                    ],
                    200
                );
            }

        }


        return response()->json('hubo un problema al almacenar la factura.');
    }

}
