<?php
/**
 * @OA\Info(
 *     title="Impressora API",
 *     version="1.0.0"
 * )
 * @OA\PathItem(path="/register")
 * @OA\PathItem(path="/login")
 * @OA\PathItem(path="/logout")
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Registro de usuário
        /**
         * @OA\Post(
         *     path="/register",
         *     summary="Registrar novo usuário",
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"name","email","password"},
         *             @OA\Property(property="name", type="string"),
         *             @OA\Property(property="email", type="string"),
         *             @OA\Property(property="password", type="string")
         *         )
         *     ),
         *     @OA\Response(response=201, description="Usuário criado"),
         *     @OA\Response(response=422, description="Dados inválidos")
         * )
         */
        public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    // Login
        /**
         * @OA\Post(
         *     path="/login",
         *     summary="Login do usuário",
         *     @OA\RequestBody(
         *         required=true,
         *         @OA\JsonContent(
         *             required={"email","password"},
         *             @OA\Property(property="email", type="string"),
         *             @OA\Property(property="password", type="string")
         *         )
         *     ),
         *     @OA\Response(response=200, description="Token de autenticação"),
         *     @OA\Response(response=422, description="Dados inválidos")
         * )
         */
        public function login(Request $request)
        {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            $user = User::where('email', $request->email)->first();
            
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['As credenciais estão incorretas.'],
                ]);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token,
            ]);
        }

    // Logout
        /**
         * @OA\Post(
         *     path="/logout",
         *     summary="Logout do usuário",
         *     security={{"bearerAuth":{}}},
         *     @OA\Response(response=200, description="Logout realizado"),
         *     @OA\Response(response=401, description="Não autorizado")
         * )
         */
        public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout realizado com sucesso.']);
    }
}
