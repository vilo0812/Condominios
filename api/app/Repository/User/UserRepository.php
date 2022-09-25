<?php

namespace App\Repository\User;

use App\Models\Medical_consultation;
use App\Models\User;
use App\Repository\BaseRepository;
use App\Repository\User\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model = User::class;


}
