<?php

namespace App\Http\Resources\Purchase;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->resource->id,
            "warehouse_id" => $this->resource->warehouse_id,
            "warehouse" => [
                "name" => $this->resource->warehouse->name,
            ],
            "user_id" => $this->resource->user_id,
            "user" => [
                "full_name" => $this->resource->user->name.' '.$this->resource->user->surname,
            ],
            "sucursale_id" => $this->resource->sucursale_id,
            "sucursale" => [
                "name" => $this->resource->sucursale->name,
            ],
            "date_emision" => Carbon::parse($this->resource->date_emision)->format("Y-m-d"),
            "state" => $this->resource->state,
            "type_comprobant" => $this->resource->type_comprobant,
            "n_comprobant" => $this->resource->n_comprobant,
            "provider_id" => $this->resource->provider_id,
            "provider" => [
                "full_name" => $this->resource->provider->full_name,
            ],
            "total" => $this->resource->total,
            "importe" => $this->resource->importe,
            "igv" => $this->resource->igv,
            "description" => $this->resource->description,
            "created_at" => $this->resource->created_at->format("Y-m-d h:i A"),
            "details" => $this->resource->purchase_details->map(function($purchase_detail) {
                return [
                    "id" => $purchase_detail->id,
                    "product_id"  => $purchase_detail->product_id,
                    "product" => [
                        "title" => $purchase_detail->product->title,
                        "sku" => $purchase_detail->product->sku,
                    ],
                    "unit_id"  => $purchase_detail->unit_id,
                    "unit" => [
                        "name" => $purchase_detail->unit->name,
                    ],
                    "price_unit"  => $purchase_detail->price_unit,
                    "total"  => $purchase_detail->total,
                    "quantity"  => $purchase_detail->quantity,
                    "state"  => $purchase_detail->state,
                    "user_entrega"  => $purchase_detail->user_entrega ? [
                        "id" => $purchase_detail->user->id,
                        "full_name" => $purchase_detail->user->name.' '.$purchase_detail->user->surname,
                    ]: NULL,
                    "date_entrega"  => $purchase_detail->date_entrega ? Carbon::parse($purchase_detail->date_entrega)->format("Y-m-d") : null,
                    "description" => $purchase_detail->description,
                ];
            })
        ];
    }
}
