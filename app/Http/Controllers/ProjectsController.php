<?php

namespace App\Http\Controllers;

use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        //created by the user and also shared
        $projects = auth()->user()->accessibleProjects();

        return view('projects.index', compact('projects'));

    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);
        //the sam as the policy above
        // if(auth()->user()->isNot($project->owner)){
        //     abort(403);
        // }

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        if ($tasks = request('tasks')) {
            $project->addTasks($tasks);
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));

    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);
        //the sam as the policy above
        // if(auth()->user()->isNot($project->owner)){
        //     abort(403);
        // }

        $project->update($this->validateRequest());

        return redirect($project->path());

    }

    public function destroy(Project $project)
    {
        //authorizes delete as well
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }

    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'

        ]);
    }

}
