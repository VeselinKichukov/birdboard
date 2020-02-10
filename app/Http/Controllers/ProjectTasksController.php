<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('update', $project);
            //the sam as the policy above
            // if(auth()->user()->isNot($project->owner)){
            //     abort(403);
            // }

        request()->validate(['body' => 'required']);

        $project->addTask(request('body'));

        return redirect($project->path());

    }

    public function update(Project $project, Task $task)
    {
        $this->authorize('update',$task->project);
            //the sam as the policy above
            // if(auth()->user()->isNot($project->owner)){
            //     abort(403);
            // }

        $task->update(request()->validate(['body' => 'required']));

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect($project->path());

    }
}
