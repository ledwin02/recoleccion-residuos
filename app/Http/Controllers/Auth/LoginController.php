<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión para web.
     */
    public function showLoginForm(): Response
    {
        return response()->view('auth.login');
    }

    /**
     * Maneja el inicio de sesión tanto para web como para API.
     */
    public function login(Request $request): JsonResponse|RedirectResponse
    {
        // Validación de entradas
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar
        if (! Auth::attempt($credentials)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Credenciales inválidas.'], 401);
            }

            return back()
                ->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.'])
                ->withInput();
        }

        $user = Auth::user();

        // Comprobar verificación de email antes de continuar
        if (method_exists($this, 'authenticated')) {
            $result = $this->authenticated($request, $user);
            if ($result instanceof Response) {
                return $result;
            }
        }

        // API: generar token
        if ($request->expectsJson()) {
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'access_token' => $token,
                'token_type' => 'Bearer',
            ]);
        }

        // Web: regenerar sesión y redirigir según rol
        $request->session()->regenerate();

        // Redirección según el rol del usuario
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isCollector()) {
            return redirect()->route('collector.dashboard'); // Asegúrate de tener esta ruta configurada
        }

        return redirect()->intended(route('home'));
    }

    /**
     * Hook tras autenticación para web: obliga a verificar email.
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice'); // Flujo directo
        }

        // Redirige según la ruta configurada para usuarios verificados
        return redirect()->intended(RouteServiceProvider::VERIFIED_HOME);
    }

    /**
     * Maneja el cierre de sesión para web y API.
     */
    public function logout(Request $request): JsonResponse|RedirectResponse
    {
        if ($request->expectsJson()) {
            $request->user()?->tokens()->delete();
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
