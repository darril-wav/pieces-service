<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    public function index(): JsonResponse
    {
        $projects = Project::where('active', true)->get();
        return response()->json($projects);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'active'      => 'boolean',
        ]);

        $project = Project::create($data);
        return response()->json($project, 201);
    }

    public function show(Project $project): JsonResponse
    {
        return response()->json($project->load('blocks'));
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'active'      => 'boolean',
        ]);

        $project->update($data);
        return response()->json($project);
    }

    public function destroy(Project $project): JsonResponse
    {
        $project->delete();
        return response()->json(['message' => 'Proyecto eliminado.']);
    }
}