<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaiVietResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
     
        return [
            'bai_viet_id' => $this->id,
            'tieude' => $this->tieu_de,
            'noidung' => $this->noi_dung,
             'created_atss' => $this->created_at->format('d-m-Y'),
           
        ];

    }
}
