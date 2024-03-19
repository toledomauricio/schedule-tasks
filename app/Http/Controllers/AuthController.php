<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Autentica um usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validação das credenciais do usuário
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Busca pelo usuário com o email fornecido
        $user = User::where('email', $credentials['email'])->first();

        // Verifica se o usuário existe e a senha está correta
        if ($user && Hash::check($credentials['password'], $user->password)) {

            // Autentica o usuário (opcional, dependendo da lógica de autenticação do aplicativo)
            // Auth::login($user);
            
            // Cria um token de acesso para o usuário
            $token = $user->createToken('auth-token')->plainTextToken;

            // Retorna os dados do usuário e o token de acesso
            return response()->json(['user' => $user, 'token' => $token], 200);
        }

        // Retorna uma mensagem de erro se as credenciais forem inválidas
        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    /**
     * Registra um novo usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $credentials = $request->validate([
                'name' => 'required|string',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
            ]);

            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
            ]);

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json(['user' => $user, 'token' => $token], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Encerra a sessão do usuário autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sessão encerrada com sucesso'], 200);
    }
}
