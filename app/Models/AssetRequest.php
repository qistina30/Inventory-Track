<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssetRequest extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'asset_id',
        'status',
        'quantity',
    ];

    /**
     * Get the user who made the requests.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the asset that was requested.
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
