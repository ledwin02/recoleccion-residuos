namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        // Si no se especifican guards, usar el guard por defecto
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                // Si el usuario no ha verificado su email, redirigir a la página de verificación
                if ($request->expectsJson() === false && ! $user->hasVerifiedEmail()) {
                    Auth::logout();
                    return redirect()->route('verification.notice');
                }

                // Respuesta JSON si el usuario ya está autenticado
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Ya autenticado.',
                        'user_type' => $user->role,  // Se ajusta a 'role' en lugar de 'is_admin'
                    ], 200);
                }

                // Redirigir a la ruta correspondiente según el tipo de usuario (admin, collector, user)
                if ($user->is_admin) {
                    return redirect()->route('admin.dashboard');  // Ruta para administradores
                }

                // Verificar si el usuario es un recolector y redirigir a su dashboard
                if ($user->isCollector()) {
                    return redirect()->route('collector.dashboard');  // Ruta para recolectores
                }

                // Redirigir a la página principal de colecciones para usuarios regulares
                return redirect()->route('collections.index');  // Ruta para usuarios normales
            }
        }

        // Si no está autenticado, pasar al siguiente middleware
        return $next($request);
    }
}
