<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BlockController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Block::query();

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        return response()->json($query->with('project')->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'project_id'  => 'required|exists:projects,id',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $block = Block::create($data);
        return response()->json($block, 201);
    }

    public function show(Block $block): JsonResponse
    {
        return response()->json($block->load('pieces'));
    }

    public function update(Request $request, Block $block): JsonResponse
    {
        $data = $request->validate([
            'name'        => 'sometimes|string|max:255',
            'description' => 'nullable|string',
        ]);

        $block->update($data);
        return response()->json($block);
    }

    public function destroy(Block $block): JsonResponse
    {
        $block->delete();
        return response()->json(['message' => 'Bloque eliminado.']);
    }
}