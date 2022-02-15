<?php

namespace App\Services;

use App\Http\Resources\CounterReadingCollection;
use App\Models\CounterReading;
use App\Models\PVInstallation;
use App\Http\Resources\CounterReadingResource;
use Carbon\Carbon;


class CounterReadingService{

    public function getAll(PVInstallation $pVInstallation){
        $counterReadings = CounterReading::where('p_v_installation_id', $pVInstallation->id)->orderBy('date')->get();
        for($i = 0; $i < count($counterReadings); $i++){
            $monthName = Carbon::createFromFormat('Y-m-d', $counterReadings[$i]['date'])->format('F');
            $counterReadings[$i]['month'] = $monthName;
        }
        // return $counterReadings;
        return new CounterReadingCollection($counterReadings);
        // return CounterReadingResource::collection($counterReadings);
    }

    public function latest(PVInstallation $pVInstallation){
        $counterReadings = CounterReading::where('p_v_installation_id', $pVInstallation->id)->orderByDesc('date')->get();
        for($i = 0; $i < count($counterReadings); $i++){
            $monthName = Carbon::createFromFormat('Y-m-d', $counterReadings[$i]['date'])->format('F');
            $counterReadings[$i]['month'] = $monthName;
        }
        // return $counterReadings;
        return new CounterReadingCollection($counterReadings);
    }
}
?>