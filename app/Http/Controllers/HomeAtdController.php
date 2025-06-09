<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Orcamento;

class HomeAtdController extends Controller
{
    public function index(){
        $ultimosClientes = Cliente::orderBy('created_at', 'desc')->take(5)->get();

        $orcamentosPendentes = Orcamento::where('status_id', 3)->orderBy('created_at')->get();

        return view('home-atd', compact('ultimosClientes', 'orcamentosPendentes'));
    }

    public function updateStatus(Request $request, $id) {
        $orcamento = Orcamento::findOrFail($id);
        $orcamento->status_id = $request->input('status_id');
        $orcamento->save();
        return back()->with('sucesso', 'Status atualizado com sucesso!');
    }
}
