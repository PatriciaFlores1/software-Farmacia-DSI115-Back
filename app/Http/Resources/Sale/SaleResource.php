<?php

namespace App\Http\Resources\Sale;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            "user_id"  => $this->resource->user_id,
            "user" => [
                "full_name" => $this->resource->user->name.' '.$this->resource->user->surname,
            ],
            "client_id"  => $this->resource->client_id,
            "client" => [
                "id" => $this->resource->client->id,
                "full_name" => $this->resource->client->full_name,
                "n_document" => $this->resource->client->n_document,
            ],
            "type_client"  => $this->resource->type_client,
            "sucursale_id"  => $this->resource->sucursale_id,
            "sucursale" => [
                "name" => $this->resource->sucursale->name,
            ],
            "subtotal"  => $this->resource->subtotal,
            "discount"  => $this->resource->discount,
            "total"  => $this->resource->total,
            "igv"  => $this->resource->igv,
            "state_sale"  => $this->resource->state_sale,
            "state_payment"  => $this->resource->state_payment,
            "state_entrega" => $this->resource->state_entrega,
            "debt"  => $this->resource->debt,
            "paid_out"  => $this->resource->paid_out,
            "date_validation"  => $this->resource->date_validation,
            "date_pay_complete"  => $this->resource->date_pay_complete,
            "description"  => $this->resource->description,
            "created_at" => $this->resource->created_at->format("Y-m-d h:i A"),
            "created_at_format" => $this->resource->created_at->format("Y-m-d"),
            "sale_details" => $this->resource->sale_details->map(function($sale_detail) {
                return SaleDetailResource::make($sale_detail);
            }),
            "payments" => $this->resource->payments->map(function($sale_payment) {
                return [
                    "id" => $sale_payment->id,
                    "method_payment"  => $sale_payment->method_payment,
                    "banco"  => $sale_payment->banco,
                    "amount"  => $sale_payment->amount,
                    "n_transaction"  => $sale_payment->n_transaction,
                ];
            }),
        ];
    }
}
