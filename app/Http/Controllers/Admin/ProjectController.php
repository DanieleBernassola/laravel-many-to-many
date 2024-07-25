<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Support\Str;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = Str::of($data['title'])->slug('-');
        // $project->slug = Str::of($project->title)->slug('-');


        $project = new Project();
        $project->title = $data['title'];
        $project->content = $data['content'];
        $project->slug = $data['slug'];
        $project->type_id = $data['type_id'];
        $project->save();
        // SE ESISTONO TECNOLOGIE NELLA RICHIESTA CREA LA RELAZIONE NELLA TABELLA PIVOT
        if ($request->has('technologies')) {
            $project->technologies()->attach($request->technologies);
        }

        return redirect()->route('admin.projects.index')->with('message', 'Progetto creato correttamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // $project = Project::where('slug', $slug)->first();
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();

        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();

        $data['slug'] = Str::of($data['title'])->slug('-');

        // $project->title = $data['title'];
        // $project->content = $data['content'];
        // $project->slug = $data['slug'];
        // $project->save();

        $project->update($data);

        if ($request->has('technologies')) {
            $project->technologies()->sync($request->technologies());
        } else {
            // SE NON VENGONO SCELTE TECNOLOGIE LE SCOLLEGA DALLA TABELLA
            $project->technologies()->detach();
        }

        return redirect()->route('admin.projects.index')->with('message', 'Progetto modificato correttamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->technologies()->detach();
        // $project->technologies()->sync([]);

        // SALVO PROJECT ID ALTRIMENTI CANCELLANDO IL RECORD NON è SICURO RIUSCIRà AD ACCEDERE ALL'ID
        // $project_id = $project->id();
        $project_id = $project->id;

        $project->delete();

        return redirect()->route('admin.projects.index')->with('message', $project_id . ' Progetto cancellato correttamente');
    }
}
