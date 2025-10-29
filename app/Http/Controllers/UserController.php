<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Funcionario; // 1. IMPORTAR O MODEL FUNCIONARIO
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException; // Importar para tratar erros de validação
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
       // 2. ADICIONAR VALIDAÇÃO
       $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|email|max:255|unique:users,email', // Garante que o email não exista na tabela users
           'password' => 'required|string|min:8', // Senha com no mínimo 8 caracteres
       ]);
       try{
           $dados = $request->all();
           $email = $dados['email'];
           // 3. BUSCAR FUNCIONÁRIO PELO EMAIL
           // Carrega o funcionário e sua categoria relacionada
           $funcionario = Funcionario::with('categoria')->where('email', $email)->first();
           // 4. VERIFICAR SE O FUNCIONÁRIO EXISTE
           if (!$funcionario) {
               // Se não existir, retorna para a tela de cadastro com um erro
               return redirect('/cadastro')
                      ->with('erro', 'Email não encontrado no cadastro de funcionários.')
                      ->withInput(); // Mantém o email/nome preenchido no formulário
           }
           // 5. DETERMINAR A ROLE COM BASE NA CATEGORIA DO FUNCIONÁRIO
           $categoriaNome = $funcionario->categoria->nome;
           $role = 'user'; // Define 'user' como padrão
           // Mapeia o nome da categoria (do Seeder) para a role (do sistema)
           switch (strtolower($categoriaNome)) {
               case 'administrador':
                   $role = 'ADM';
                   break;
               case 'atendente':
                   $role = 'ATD';
                   break;
               case 'técnico': // O seeder está com 't' minúsculo
                   $role = 'TEC';
                   break;
               // Se for 'Geral' ou outra, a role continuará 'user'
           }
           // Opcional: Impedir que 'Geral' (user) se cadastre por aqui
           if ($role == 'user') {
                return redirect('/cadastro')
                      ->with('erro', 'Funcionários da categoria "Geral" não possuem acesso ao sistema.')
                      ->withInput();
           }
           // 6. PREPARAR DADOS PARA CRIAR O USUÁRIO
           $dadosUsuario = [
               'name' => $dados['name'], // Pega o nome do formulário
               'email' => $dados['email'],
               'password' => Hash::make($dados['password']),
               'role' => $role, // ATRIBUI A ROLE CORRETA
           ];
           // 7. CRIAR O USUÁRIO
           User::create($dadosUsuario);
           // Redireciona para o login com mensagem de sucesso
           return redirect('/login')->with('sucesso', 'Cadastro realizado com sucesso! Faça o login.');
       } catch(ValidationException $e) {
           // Se a validação falhar (ex: email duplicado), retorna com os erros
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
       // Corrigido: Passar o usuário para a view
       $user = Auth::user();
       return view("users.edit", compact('user'));
   }
   /**
    * Update the specified resource in storage.
    */
   public function update(Request $request, string $id)
   {
       // O $id não é necessário se estamos sempre editando o usuário logado
       $user = Auth::user();
       // Validar senha atual
       if (!Hash::check($request->input('current_password'), $user->password)) {
           return redirect()->back()
               ->with('erro', 'A senha atual não confere!');
       }
       // Validar dados de entrada
       $request->validate([
           'name' => 'required|string|max:255',
           'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
           'password' => 'nullable|min:8|confirmed', // 'confirmed' verifica se password == password_confirmation
       ]);
       try {
           $user->name = $request->input('name');
           $user->email = $request->input('email');
           // Atualiza a senha apenas se uma nova foi fornecida
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