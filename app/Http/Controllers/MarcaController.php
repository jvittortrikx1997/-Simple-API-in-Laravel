<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    private $marca;

    public function __construct(Marca $marca){
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$marcas = Marca::all();
        $marca = $this->marca->all();
        return response()->json($marca, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        //$marca = Marca::create($request->all());

        $request->validate($this->marca->rules(), $this->marca->feedback());
        
        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens', 'public');
        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        return response()->json($marca, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'A marca solicitada não existe'], 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /*print_r($request->all());
        echo '<pre>';
        print_r($marca->getAttributes());*/
        //$marca->update($request->all());

        $marca = $this->marca->find($id);

        if($marca === null){
            return response()->json(['erro' => 'A marca solicitada não existe'], 404);
        }

        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();
            //$teste = '';
            foreach($marca->rules() as $input => $regra){
                //$teste .= 'Inpute: '.$pintes.'| Regra: '.$regra.'</pre>';
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
        }else{
            $request->validate($marca->rules(), $marca->feedback());
        }
        $marca->update($request->all());
        return response()->json($marca, 201);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $marca = $this->marca->find($id);
        if($marca === null){
            return response()->json(['erro' => 'A marca solicitada não existe'], 404);
        }else{
            $marca->delete();
            return ['msg:' => 'A marca foi removida com sucesso'];
        }
    }
}
