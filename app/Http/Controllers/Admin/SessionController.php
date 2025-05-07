<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class SessionController extends Controller
{
    public function put_project(Request $request, Project $project)
    {
        $request->session()->put('project_id', $project->id);
        // dd($project->id);
        return back();
    }

    public function delete_project(Request $request)
    {
        $request->session()->forget('project_id');

        return back();
    }
}
