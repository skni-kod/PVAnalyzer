<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PVInstallation extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'power',
    ];

    /**
     * Get the user that owns the installation
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the counter readings for the PV Installation.
     */
    public function counterReadings()
    {
        return $this->hasMany(CounterReading::class);
    }

    public function getMultiplier()
    {
        return $this->power <= 10 ? 0.8 : 0.7;
    }
}
