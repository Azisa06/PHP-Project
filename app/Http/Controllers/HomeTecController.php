<?php

namespace App\Http\Controllers;

use App\Models\Orcamento;
use Illuminate\Http\Request;

class HomeTecController extends Controller
{
    public function index(){
        $orcamentosAprovados = Orcamento::where('status_id', 4)->orderBy('created_at', 'asc')->get();

        $orcamentosEmConserto = Orcamento::where('status_id', 5)->orderBy('created_at', 'asc')->get();

        return view('home-tec', compact('orcamentosAprovados', 'orcamentosEmConserto'));
    }
}
