<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRecord extends Model
{
    protected $fillable = [
        'asset_id', 'damage_description', 'action_taken', 'cost', 'maintenance_date', 'status',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
