<?php
namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index()
    {
        return response()->json(Movie::with('characters')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string',
            'classification' => 'required|string',
            'release_date'   => 'required|date',
            'review'         => 'required|string',
            'season'         => 'nullable|integer',
        ]);
        $movie = Movie::create($validated);
        return response()->json($movie, 201);
    }

    public function show(Movie $movie)
    {
        return response()->json($movie->load('characters'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'name'           => 'sometimes|string',
            'classification' => 'sometimes|string',
            'release_date'   => 'sometimes|date',
            'review'         => 'sometimes|string',
            'season'         => 'nullable|integer',
        ]);
        $movie->update($validated);
        return response()->json($movie);
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['message' => 'Movie deleted']);
    }
}