<?php

namespace App\Http\Controllers;

use App\Models\Cellier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CellierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $celliers = Cellier::withCount('bouteillesCelliers')
                            ->with('bouteillesCelliers.bouteille')
                            ->where('user_id', Auth::id())
                            ->get(); 

        $celliers->each(function ($cellier) {
            $cellier->prixTotal = 0; 
            foreach($cellier->bouteillesCelliers as $bouteilleCellier) {
                $cellier->prixTotal += $bouteilleCellier->bouteille->prix; 
            }
        }); 
        
        return view('cellier.index', ['celliers' => $celliers]); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexJSON()
    {
        $celliers = Cellier::withCount('bouteillesCelliers')
                            ->with('bouteillesCelliers.bouteille')
                            ->where('user_id', Auth::id())
                            ->get(); 

        $celliers->each(function ($cellier) {
            $cellier->prixTotal = 0; 
            foreach($cellier->bouteillesCelliers as $bouteilleCellier) {
                $cellier->prixTotal += $bouteilleCellier->bouteille->prix; 
            }
        }); 
        
        return response()->json($celliers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cellier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            ['nom' => 'required|max:255'],
            [
                'nom.required' => 'Le nom du cellier est obligatoire.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        $newCellier = Cellier::create([
            'nom' => $request->nom, 
            'user_id' => Auth::id()
        ]);

        $newCellier->save(); 

        return redirect(route('cellier.index')); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cellier  $cellier
     * @return \Illuminate\Http\Response
     */
    public function show(Cellier $cellier_id, Request $request)
    {
        $cellier = $cellier_id;

        $sort = $request->input('sort');
    
        if ($sort == 'name-asc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortBy('bouteille.nom');
        } elseif ($sort == 'name-desc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortByDesc('bouteille.nom');
        } elseif ($sort == 'price-asc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortBy('bouteille.prix');
        } elseif ($sort == 'price-desc') {
            $cellier->bouteillesCelliers = $cellier->bouteillesCelliers->sortByDesc('bouteille.prix');
        }
    
        return view('cellier.show', ['cellier' => $cellier]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cellier  $cellier
     * @return \Illuminate\Http\Response
     */
    public function edit($cellier_id)
    {
        $cellier = Cellier::findOrFail($cellier_id); 

        return view('cellier.edit', ['cellier' => $cellier]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cellier  $cellier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $cellier_id)
    {
        $request->validate(
            ['nom' => 'required|max:255'],
            [
                'nom.required' => 'Le nom du cellier est obligatoire.', 
                'nom.max' => 'Le nom ne doit pas dépasser 255 caractères.'
            ]
        ); 

        Cellier::findOrFail($cellier_id)->update([
            'nom' => $request->nom
        ]);

        return redirect(route('cellier.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cellier  $cellier
     * @return \Illuminate\Http\Response
     */
    public function destroy($cellier_id)
    {
        try {
            $cellier = Cellier::findOrFail($cellier_id); 
            $cellier->bouteillesCelliers()->delete(); 
            $cellier->delete(); 
            return redirect(route('cellier.index')); 
        }
        catch (\Exception $e) {
            return redirect(route('cellier.index'))->with('error', 'Le cellier n\'existe pas'); 
        }
    }
}
