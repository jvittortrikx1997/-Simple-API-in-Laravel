<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules(){
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png'
        ];
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute precisa ser informado',
            'nome.unique' => 'A marca informada já existe',
            'nome.min' => 'O campo nome precisa ter no mínimo três caracteres',
            'imagem.mimes' => 'A imagem enviada precisa estar no formato png'
        ];
    }
}
