<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function create()
    {
        return view("users.create");
    }

    public function store(Request $request)
    {
        try{
            $dados = $request->all();
            $dados['password'] = Hash::make($dados['password']);
            User::create($dados);
            return redirect('/login');
        } catch(Exception $e){
            Log::error("Erro ao criar o usuário:" . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return redirect('/cadastro')->with('erro', 'Erro ao cadastrar!');
        }
    }

    public function edit(string $id)
    {
        return view("users.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()
                ->with('erro', 'A senha atual não confere!');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|min:8|confirmed', 
        ]);

        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            return redirect()->back()
                   ->with('sucesso', 'Dados alterados com sucesso!');

        } catch(Exception $e) {
            Log::error("Erro ao editar o usuário:" . $e->getMessage(), [
                'stack' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return redirect()->back()->with('erro', 'Erro ao editar!');
        }
    }
}
