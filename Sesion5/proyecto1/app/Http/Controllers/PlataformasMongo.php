<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Conectores;
use MongoDB\Driver\Query;
use MongoDB\Driver\Manager;
use MongoDB\Driver\BulkWrite;
use MongoDB\BSON\ObjectID;

class PlataformasMongo extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $conector;
    protected $bbdd = 'videojuegos_db.plataformas';

    public function __construct()
    {
        $manager = new Conectores();
        $this->conector = $manager->getMongo();
    }

    public function index()
    {
        $manager = $this->conector->executeQuery($this->bbdd, new Query([], []));
        $datos = $manager->toArray();
        return $datos;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $bulk = new BulkWrite();
        $bulk->insert([
            'nombre' => $request->input('nombre','NEOGEO'), // Si no se proporciona un nombre, se usará 'NEOGEO' por defecto
            'juegos' => $request->input('juegos', []) // Si no se proporciona una lista de juegos, se usará un array vacío por defecto
        ]);
        $this->conector->executeBulkWrite('videojuegos_db.plataformas', $bulk);
        return response()->json($request->all(), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $bulk = new BulkWrite();
        $bulk->update(
            ['_id' => new ObjectID($id)],
            ['$set' => [
                'nombre' => $request->input('nombre'),
                'juegos' => $request->input('juegos')
            ]]
        );
        $this->conector->executeBulkWrite('videojuegos_db.plataformas', $bulk);
        return response()->json($request->all(), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $bulk = new BulkWrite();
        $bulk->delete(['_id' => new ObjectID($id)], ['limit' => true]);
        $this->conector->executeBulkWrite('videojuegos_db.plataformas', $bulk);
        return response()->json(['mensaje' => 'Plataforma eliminada exitosamente'], 200);
    }
}
