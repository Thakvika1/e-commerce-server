<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderHistory;

class Order extends Model
{
    protected $fillable = ['user_id', 'total_price'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderHistories()
    {
        $this->hasMany(OrderHistory::class);
    }
}
