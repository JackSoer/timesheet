<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeveloperRequest;
use App\Http\Requests\UpdateDeveloperRequest;
use App\Http\Resources\DeveloperCollection;
use App\Http\Resources\DeveloperResource;
use App\Models\Developer;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $developers = new DeveloperCollection(Developer::all());

        return inertia('Developers', compact('developers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prevUrl = url()->previous();

        return inertia('AddDeveloper', compact('prevUrl'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeveloperRequest $request)
    {
        Developer::create($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $developer = Developer::find($id);

        $developer = new DeveloperResource($developer);

        return inertia('EditDeveloper', ['defaultDeveloper' => $developer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeveloperRequest $request, string $id)
    {
        $developer = Developer::find($id);

        $developer->update($request->all());

        return redirect('/volunteers');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $developer = Developer::find($id);

        $developer->delete();
    }
}
