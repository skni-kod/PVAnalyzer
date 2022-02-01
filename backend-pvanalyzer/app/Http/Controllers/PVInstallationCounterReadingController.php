<?php

namespace App\Http\Controllers;

use App\Http\Resources\CounterReadingResource;
use App\Models\CounterReading;
use App\Models\PVInstallation;
use Illuminate\Http\Request;

class PVInstallationCounterReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PVInstallation $pVInstallation)
    {
        return CounterReadingResource::collection(CounterReading::where('p_v_installation_id', $pVInstallation->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, PVInstallation $pVInstallation)
    {
        $data = $request->only([
            'date',
            'active_energy_consumed',
            'reactive_energy_consumed',
            'energy_to_recover' //TODO: this value must be calc!!!
        ]);
        $message = [
            'status' => true,
            'message' => 'Counter Reading created successfully'
        ];
        return (new CounterReadingResource($pVInstallation->counterReadings()->create($data)))->additional($message);
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
    public function update(Request $request, PVInstallation $pVInstallation, CounterReading $counterReading)
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
