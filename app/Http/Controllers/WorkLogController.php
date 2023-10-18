<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWorkLogRequest;
use App\Http\Requests\UpdateWorkLogRequest;
use App\Http\Resources\DeveloperCollection;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\WorkLogCollection;
use App\Http\Resources\WorkLogResource;
use App\Models\Developer;
use App\Models\Project;
use App\Models\WorkLog;

class WorkLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workLogs = new WorkLogCollection(WorkLog::with('developer', 'project')->get());

        return inertia('WorkLogs', compact('workLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $developers = new DeveloperCollection(Developer::all());
        $projects = new ProjectCollection(Project::with('client')->get());

        return inertia('AddWorkLog', compact('developers', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkLogRequest $request)
    {
        WorkLog::create($request->all());

        return redirect('/work-logs');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkLog $workLog)
    {
        $workLog = new WorkLogResource($workLog);

        $developers = new DeveloperCollection(Developer::all());
        $projects = new ProjectCollection(Project::with('client')->get());

        return inertia('EditWorkLog', ['defaultWorkLog' => $workLog, 'developers' => $developers, 'projects' => $projects]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkLogRequest $request, WorkLog $workLog)
    {
        $workLog->update($request->all());

        return redirect('/work-logs');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLog $workLog)
    {
        $workLog->delete();
    }
}
