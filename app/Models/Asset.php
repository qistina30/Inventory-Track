<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Asset extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'location_id',
        'category_id',
        'name',
        'quantity',
        'status',
        'description',
    ];

    public static function boot()
    {
        parent::boot();

        // Listen for the `saving` event to update status based on quantity
        static::saving(function ($asset) {
            if ($asset->quantity == 0) {
                $asset->status = 'unavailable';
            } elseif ($asset->status == 'unavailable' && $asset->quantity > 0) {
                $asset->status = 'available'; // Or set it to another appropriate status
            }
        });
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function asset_requests()
    {
        return $this->hasMany(AssetRequest::class);
    }
}
