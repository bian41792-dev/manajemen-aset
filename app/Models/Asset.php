<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'code', 'name', 'category_id', 'location_id', 'user_id',
        'condition', 'purchase_date', 'price', 'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mutations()
    {
        return $this->hasMany(AssetMutation::class);
    }

    public function loans()
    {
        return $this->hasMany(AssetLoan::class);
    }

    public function maintenanceRecords()
    {
        return $this->hasMany(MaintenanceRecord::class);
    }
}
