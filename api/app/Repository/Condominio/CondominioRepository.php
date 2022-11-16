<?php

namespace App\Repository\Condominio;

use App\Repository\BaseRepository;
use App\Models\Condominio;
use App\Repository\Condominio\CondominioRepositoryInterface;

class CondominioRepository extends BaseRepository implements CondominioRepositoryInterface
{
    protected $model = Condominio::class;

    public function getAllCondominios( $perPage, $order )
    {   
        is_null($perPage)  ? $perPage = 100     : $perPage  = (int)$perPage;
        is_null($order)    ? $order    = 'desc' : $order    = $order;
        return $this->model->orderBy('id', $order)->paginate($perPage);
    }

    public function CreateCondominio ($request) 
    {
        return  $this->model->create([
            'user_id'    => $request->user_id,
            'name'       => $request->name,
            'description'=> $request->description,
            'amount'     => $request->amount,
            'dues'       => $request->dues,
            'status'     => $request->status,
            'location'   => $request->location,
        ]);
    }

}
