<?php
namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    public function index()
    {
        return response()->json(Character::with('movies')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string',
            'picture'     => 'required|string',
            'description' => 'required|string',
            'movie_ids'   => 'nullable|array',
            'movie_ids.*' => 'exists:movies,id',
        ]);

        $character = Character::create($validated);

        if (!empty($validated['movie_ids'])) {
            $character->movies()->sync($validated['movie_ids']);
        }

        return response()->json($character->load('movies'), 201);
    }

    public function show(Character $character)
    {
        return response()->json($character->load('movies'));
    }

    public function update(Request $request, Character $character)
    {
        $validated = $request->validate([
            'name'        => 'sometimes|string',
            'picture'     => 'sometimes|string',
            'description' => 'sometimes|string',
            'movie_ids'   => 'nullable|array',
            'movie_ids.*' => 'exists:movies,id',
        ]);

        $character->update($validated);

        if (isset($validated['movie_ids'])) {
            $character->movies()->sync($validated['movie_ids']);
        }

        return response()->json($character->load('movies'));
    }

    public function destroy(Character $character)
    {
        $character->delete();
        return response()->json(['message' => 'Character deleted']);
    }
}