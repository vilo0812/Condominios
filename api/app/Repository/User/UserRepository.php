<?php

namespace App\Repository\User;

use App\Models\User;
use App\Repository\BaseRepository;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model = User::class;

    public function getAllByRol($rol, $perPage, $order)
    {   
        is_null($rol)      ? $rol      = 2      : $rol      = (int)$rol;
        is_null($perPage)  ? $perPage = 100     : $perPage  = (int)$perPage;
        is_null($order)    ? $order    = 'desc' : $order    = $order;
        return $this->model->where('rol_id',$rol)->orderBy('id', $order)->paginate($perPage);
    }

    public function CreateUser ($request) 
    {
        return  $this->model->create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'rol_id'    => (int)$request->rol
        ]);
    }

}
