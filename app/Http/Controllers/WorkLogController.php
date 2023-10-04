<?php

namespace App\Http\Controllers;

use App\Models\WorkLog;
use App\Http\Requests\StoreWorkLogRequest;
use App\Http\Requests\UpdateWorkLogRequest;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkLogRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkLog $workLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkLog $workLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkLogRequest $request, WorkLog $workLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLog $workLog)
    {
        //
    }
}
