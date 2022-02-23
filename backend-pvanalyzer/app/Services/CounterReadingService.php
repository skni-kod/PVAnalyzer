<?php

namespace App\Services;

use App\Http\Resources\CounterReadingCollection;
use App\Models\CounterReading;
use App\Models\PVInstallation;
use App\Http\Resources\CounterReadingResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class CounterReadingService{

    public function getAll(PVInstallation $pVInstallation){
        $counterReadings = CounterReading::where('p_v_installation_id', $pVInstallation->id)->orderBy('date')->get();
        for($i = 0; $i < count($counterReadings); $i++){
            $monthName = Carbon::createFromFormat('Y-m-d', $counterReadings[$i]['date'])->format('F Y');
            $counterReadings[$i]['month'] = $monthName;
        }
        
        return new CounterReadingCollection($counterReadings);
    }

    public function monthly(PVInstallation $pVInstallation){
        $counterReadings = CounterReading::where('p_v_installation_id', $pVInstallation->id)
        ->whereIn('date', function($query){
            $query->select(DB::raw(' MAX(date) FROM counter_readings GROUP BY MONTH(date), YEAR(date)'));
        })->orderBy('date')->get();

        for($i = 0; $i < count($counterReadings); $i++){
            $monthName = Carbon::createFromFormat('Y-m-d', $counterReadings[$i]['date'])->format('F Y');
            $counterReadings[$i]['month'] = $monthName;
        }

        return $counterReadings;
    }

    public function saveCounterReadingData($data, PVInstallation $pVInstallation){
        $requestData = $data;
        $requestData['energy_to_recover'] = round($requestData['reactive_energy_consumed'] * $pVInstallation->getMultiplier(), 2);
        $requestData['balance'] = round($requestData['energy_to_recover'] - $requestData['active_energy_consumed'], 2);
        
        return new CounterReadingResource($pVInstallation->counterReadings()->create($requestData));
    }
}
?>