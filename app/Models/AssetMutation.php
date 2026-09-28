<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetMutation extends Model
{
    protected $fillable = [
        'asset_id', 'from_location_id', 'to_location_id',
        'from_user_id', 'to_user_id', 'mutation_date', 'reason',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function fromLocation()
    {
        return $this->belongsTo(Location::class, 'from_location_id');
    }

    public function toLocation()
    {
        return $this->belongsTo(Location::class, 'to_location_id');
    }

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }
}