<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Condominio extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        return [ 
            'user'       => $request->user_id,
            'name'       => $request->name,
            'description'=> $request->description,
            'amount'     => $request->amount,
            'dues'       => $request->dues,
            'status'     => $request->status,
            'location'   => $request->location,
        ];
    }
}
