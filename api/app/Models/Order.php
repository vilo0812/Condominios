<?php

namespace App\Models;

use Hexters\CoinPayment\Entities\CoinpaymentTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'fee',
        'status',
        'type',
        'voucher',
        'hash',
        'type_wallet'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function status()
    {
        if ($this->status == '0'){
            return "Esperando";
        }elseif($this->status == '1'){
            return "Aprobado";
        }elseif($this->status >= '2'){
            return "Rechazada";
        }
    }
}
