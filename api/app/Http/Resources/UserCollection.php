<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            // 'paginate' => [
            //         'total' => $this->total(),
            //         'current_page' => $this->currentPage(),
            //         'per_page' => $this->perPage(),
            //         'last_page' => $this->lastPage(),
            //         'from' => $this->firstItem(),
            //         'to' => $this->lastPage(),
            //     ],
                'data' => $this->collection,
        ];
    }
}
