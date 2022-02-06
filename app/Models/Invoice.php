<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'invoice_number', 'client_name', 'client_vat_number', 'project_name', 'project_number', 'notes'];

    protected $appends = ['total_amount_before_vat', 'vat', 'total_amount_after_vat'];

    public function items()
    {
        return $this->hasMany(InvoiceItems::class);
    }

    public function getTotalAmountBeforeVatAttribute()
    {
        $total_before_vat = 0;
        foreach ($this->items as $key => $item) {
            $total_before_vat += $item->unit_price * $item->quantity;
        }
        return $total_before_vat;
    }

    public function getVatAttribute()
    {
        return $this->getTotalAmountBeforeVatAttribute() * 0.15;
    }

    public function getTotalAmountAfterVatAttribute()
    {
        return $this->getTotalAmountBeforeVatAttribute() + $this->getVatAttribute();
    }
}
