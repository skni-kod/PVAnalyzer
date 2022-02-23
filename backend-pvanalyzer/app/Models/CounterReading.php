<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CounterReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'active_energy_consumed',
        'reactive_energy_consumed',
        'energy_to_recover',
        'balance'
    ];
    
    /**
     * Get the PV Installation that owns the counter reading.
     */
    public function pVInstallation()
    {
        return $this->belongsTo(PVInstallation::class);
    }
}
