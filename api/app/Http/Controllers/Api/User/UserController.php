<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\UserCollection;
use App\Repository\User\UserRepository;
use App\Repository\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $repository;
    private $user;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->user = Auth::guard('api')->user();
    }

    public function index()
    {

        return response()->json(
            new UserCollection($this->repository->getAll()),
            200
        );
    }

    public function store(Request $request)
    {

        $user = $this->repository->createOrUpdateFromRequest();
        return response()->json(
            [
                'message' => 'user registrada exitosamente',
                'data' => new UserResource($user)
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
