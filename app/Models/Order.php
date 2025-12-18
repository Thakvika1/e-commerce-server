<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItem()
    {
        $this->hasMany(OrderItem::class);
    }
}
