<?php

namespace App\Repository\Condominio;

interface CondominioRepositoryInterface
{
    public function getAllCondominios($paginate, $order);
    public function CreateCondominio($request);
}