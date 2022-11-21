<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Repository\User\UserRepository;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $repository;
    private $user;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->user = Auth::guard('api')->user();
    }

    public function index(Request $request)
    {   
        $data = $this->repository->getAllByRol( $request->get('rol'), $request->get('perPage'),  $request->get('order') );
        return response()->json(
            [
                'users'    =>  $data->items(),
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
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required',
            'rol'       => 'required'
        ];

        $messages = [
            'name.required'     =>  'El nombre es requerido.',
            'email.required'    =>  'El Email es requerido.',
            'email.email'       =>  'Email invalido.',
            'email.unique'       =>  'El email ya se encuentra registrado',
            'password.required' =>  'La contraseña es requerida',
            'name.max'          =>  'Muchos caracteres en el campo name.',
            'rol.required'      =>  'El rol es requerido.'

        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ( $validator->fails() ) {
            return response()->json( $validator->errors(), 400 );
        }
   
        return response()->json(
            [
                'message' => 'user registrada exitosamente',
                'data' => new UserResource( $this->repository->CreateUser($request) )
            ],
             200 // state HTTP
         );
    }

    public function update(Request $request, int $id)
    {

        $user = $this->repository->createOrUpdateFromRequest($id);
        return response()->json(
            [
                'message' => 'se actualizo el usuario correctamente',
                'data' => new UserResource($user)
            ],
            200 // state HTTP
        );
    }

    public function show(int $id)
    {
        return response()->json(
            new UserResource($this->repository->findOneByPrimary($id)),
            200 // state HTTP
        );
    }

    public function destroy(int $id)
    {
        $user = $this->repository->deleteByPrimary($id);
        return response()->json(
            [
                'message' => 'Usuario eliminado'
            ],
            200
        );
    }

}
