<?php

namespace App\Http\Controllers;

use App\Models\Saga;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SagaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sagas = Saga::withCount('games')->get();

         return Inertia::render('Sagas/Index', [
            'sagas' => $sagas,
            'successMessage' => session('success'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return Inertia::render('Sagas/Create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Saga::create($validated);

        return redirect()->route('sagas.index')->with('message', 'Created Saga successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Saga $saga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Saga $saga){
        return Inertia::render('Sagas/Edit', [
            'saga' => $saga,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Saga $saga){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $saga->update($validated);

        return redirect()->route('sagas.index')->with('message', 'Updated Saga successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Saga $saga) {
        $saga->delete();
        return redirect()->route('sagas.index')->with('message', 'Saga deleted successfully.');
    }
}
