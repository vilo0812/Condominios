<?php

namespace App\Repository\User;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getAllByRol($rol, $paginate, $order);
    public function CreateUser($request);
}