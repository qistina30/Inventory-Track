<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'user_id', 'asset_id', 'transaction_type', 'quantity', 'transaction_date', 'remark',
    ];

    protected $dates = [
        'transaction_date',
        'created_at',
        'updated_at',
    ];

    // Ensure correct casting for 'transaction_date'
    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
