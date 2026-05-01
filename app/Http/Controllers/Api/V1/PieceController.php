<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Piece;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PieceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Piece::with('block.project');

        if ($request->has('block_id')) {
            $query->where('block_id', $request->block_id);
        }

        if ($request->has('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->has('project_id')) {
            $query->whereHas('block', function ($q) use ($request) {
                $q->where('project_id', $request->project_id);
            });
        }

        return response()->json($query->paginate(15));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'block_id'     => 'required|exists:blocks,id',
            'name'         => 'required|string|max:255',
            'peso_teorico' => 'required|numeric|min:0',
            'peso_real'    => 'nullable|numeric|min:0',
            'estado'       => 'in:pendiente,fabricada',
        ]);

        $piece = Piece::create($data);
        return response()->json($piece, 201);
    }

    public function show(Piece $piece): JsonResponse
    {
        return response()->json($piece->load('block.project'));
    }

    public function update(Request $request, Piece $piece): JsonResponse
    {
        $data = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'peso_teorico' => 'sometimes|numeric|min:0',
            'peso_real'    => 'nullable|numeric|min:0',
            'estado'       => 'in:pendiente,fabricada',
        ]);

        $piece->update($data);
        return response()->json($piece);
    }

    public function destroy(Piece $piece): JsonResponse
    {
        $piece->delete();
        return response()->json(['message' => 'Pieza eliminada.']);
    }
}