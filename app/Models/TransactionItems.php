<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItems extends Model
{
    //
    protected $fillable = [
        'transaction_id',
        'menus_id',
        'note',
        'quantity',
        'price',
        'subtotal',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function Menu()
    {
        return $this->belongsTo(Menu::class, 'menus_id');
    }
}
