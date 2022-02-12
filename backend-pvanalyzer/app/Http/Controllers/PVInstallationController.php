<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePVInstallation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PVInstallation;
use App\Http\Resources\PVInstallationResource;

class PVInstallationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return PVInstallationResource::collection(PVInstallation::where('user_id', $request->user()->id)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePVInstallation $request)
    {
        $data = $request->only([
            'start',
            'power'
        ]);

        $user = User::find($request->user()->id);

        $message = [
            'status' => true,
            'message' => 'PV Installation created successfully'
        ];
        return (new PVInstallationResource($user->pVInstallation()->create($data)))->additional($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(PVInstallation $pVInstallation)
    {
        if ($pVInstallation->user_id != auth()->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        return new PVInstallationResource($pVInstallation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePVInstallation $request, PVInstallation $pVInstallation)
    {
        $data = $request->only([
            'start',
            'power'
        ]);
        if ($pVInstallation->user_id != auth()->user()->id) {
            return abort(403, 'Unauthorized action.');
        }

        $pVInstallation->update($data);

        $message = [
            'status' => true,
            'message' => 'PV Installation updated successfully'
        ];
        return (new PVInstallationResource($pVInstallation))->additional($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(PVInstallation $pVInstallation)
    {
        if ($pVInstallation->user_id != auth()->user()->id) {
            return abort(403, 'Unauthorized action.');
        }
        $pVInstallation->delete();
        return response([
            'message' => 'PV Installation deleted successfully'
        ], 200);
    }
}
