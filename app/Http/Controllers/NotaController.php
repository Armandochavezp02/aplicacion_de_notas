<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Auth;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$notas = Nota::get();

        $notas = Nota::where('users_id', Auth::id())->get();

        return Inertia::render('Notas/Index', [
        'notas' => $notas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Notas/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
        ]);
      
        // Nota::create($request->all());

         $nota = new Nota;
         $nota->titulo = $request->titulo;
         $nota->contenido = $request->contenido;
         $nota->users_id = Auth::id(); //id del usuario que esta conectado
         $nota->save();
  
         return redirect()->route('noticias.index')->with('status', 'Se ha creado una noticia...creo yo.');;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {                                                    
        //$nota =  Nota::findOrFail($id);
        //select * from notas where id = $id and users_id = Auth::id()
        $nota = Nota::where('id',$id)->where('users_id',Auth::id())->first(); //Esta linea la pasamos a edit pero no se en donde
        
        return Inertia::render('Notas/Show', [
            'nota' => $nota
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$nota = Nota::findOrFail($id);
        $nota = Nota::where('id',$id)->where('users_id',Auth::id())->first();

        return Inertia::render('Notas/Edit', [
            'nota' => $nota
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
        ]);

       // $nota =  Nota::findOrFail($id);
        $nota =  Nota::where('id',$id)->where('users_id',Auth::id())->first();

        $nota-> update($request->all());
        return redirect()->route('noticias.index')->with('status', 'Este es un mensaje que se esta enviando...creo yo.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $nota = Nota::findOrFail($id);
        $nota =  Nota::where('id',$id)->where('users_id',Auth::id())->first();

        $nota->delete();
        return redirect()->route('noticias.index')->with('status', 'Este es un mensaje ha sido eliminado...creo yo.');;
        
    }
}
