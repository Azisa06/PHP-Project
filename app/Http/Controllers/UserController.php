<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Funcionario;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email', //garante que o email não exista na tabela users
            'password' => 'required|string|min:6', //senha com no mínimo 6 caracteres
        ]);

        try{
            $dados = $request->all();
            $email = $dados['email'];
            $funcionario = Funcionario::with('categoria')->where('email', $email)->first();

            if (!$funcionario) {
                return redirect('/cadastro')
                       ->with('erro', 'Email não encontrado no cadastro de funcionários.')
                       ->withInput();
            }

            $categoriaNome = $funcionario->categoria->nome;
            $role = 'user';

            switch (strtolower($categoriaNome)) {
                case 'administrador':
                    $role = 'ADM';
                    break;
                case 'atendente':
                    $role = 'ATD';
                    break;
                case 'técnico':
                    $role = 'TEC';
                    break;
            }

            if ($role == 'user') {
                 return redirect('/cadastro')
                       ->with('erro', 'Funcionários da categoria "Geral" não possuem acesso ao sistema.')
                       ->withInput();
            }

            $dadosUsuario = [
                'name' => $dados['name'],
                'email' => $dados['email'],
                'password' => Hash::make($dados['password']),
                'role' => $role,
            ];
            
            User::create($dadosUsuario);

            return redirect('/login')->with('sucesso', 'Cadastro realizado com sucesso! Faça o login.');

        } catch(ValidationException $e) {
             return redirect('/cadastro')->withErrors($e->errors())->withInput();
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
        $user = Auth::user();
        return view("users.edit", compact('user'));
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
            'password' => 'nullable|min:6|confirmed',
        ]);

        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');

            //atualiza a senha apenas se uma nova foi fornecida
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