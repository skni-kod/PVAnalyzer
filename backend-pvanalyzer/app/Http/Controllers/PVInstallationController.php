<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePVInstallation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PVInstallation;

class PVInstallationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $userId = auth()->user()->id;
        $user = User::find($userId);
        $pVInstallation = $user->pVInstallation->create($data);
        return $pVInstallation;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return PVInstallation::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePVInstallation $request, $id)
    {
        $data = $request->only([
            'start',
            'power'
        ]);
        $pVInstallation = PVInstallation::find($id);
        $pVInstallation->update($data);
        
        return $pVInstallation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
