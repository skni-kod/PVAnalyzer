<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCounterReading;
use App\Http\Resources\CounterReadingResource;
use App\Http\Resources\CounterReadingCollection;
use App\Services\CounterReadingService;

use App\Models\CounterReading;
use App\Models\PVInstallation;
use Carbon\Carbon as Carbon;
use Illuminate\Http\Request;

class PVInstallationCounterReadingController extends Controller
{
    protected $counterReadingService;

    public function __construct(CounterReadingService $counterReadingService)
    {
        $this->counterReadingService = $counterReadingService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PVInstallation $pVInstallation)
    {
        $result = $this->counterReadingService->getAll($pVInstallation);
        
        return $result;
    }

    public function monthly(PVInstallation $pVInstallation){
        $result = $this->counterReadingService->monthly($pVInstallation);
        return new CounterReadingCollection($result);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCounterReading $request, PVInstallation $pVInstallation)
    {
        $data = $request->only([
            'date',
            'active_energy_consumed',
            'reactive_energy_consumed',
        ]);

        $result =  $this->counterReadingService->saveCounterReadingData($data, $pVInstallation);

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PVInstallation $pVInstallation, CounterReading $counterReading)
    {
        if ($pVInstallation->user_id != auth()->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        return new CounterReadingResource($counterReading);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCounterReading $request, PVInstallation $pVInstallation, CounterReading $counterReading)
    {
        $data = $request->only([
            'date',
            'active_energy_consumed',
            'reactive_energy_consumed',
            'energy_to_recover' //TODO: this value must be calc!!!
        ]);

        if ($pVInstallation->user_id != auth()->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $counterReading->update($data);
        $message = [
            'status' => true,
            'message' => 'Counter Reading updated successfully'
        ];
        return (new CounterReadingResource($counterReading))->additional($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PVInstallation $pVInstallation, CounterReading $counterReading)
    {
        if ($pVInstallation->user_id != auth()->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        $counterReading->delete();

        return response([
            'message' => 'Counter reading deleted successfully'
        ], 200);
    }
}
