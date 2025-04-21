namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Redirigir al login si no está autenticado
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar si el usuario tiene el rol adecuado
        // Si el rol es una cadena simple, se compara directamente con el rol del usuario
        if ($this->hasRole($user, $role)) {
            return $next($request);
        }

        // Si no tiene el rol adecuado, redirigir con mensaje de error
        return redirect('/')->with('error', 'No tienes permisos para acceder a esta sección.');
    }

    /**
     * Verifica si el usuario tiene el rol adecuado.
     *
     * @param  \App\Models\User  $user
     * @param  string  $role
     * @return bool
     */
    private function hasRole($user, $role): bool
    {
        // Verificar si el rol es único o múltiple
        if (strpos($role, ',') !== false) {
            $roles = explode(',', $role);
            return in_array($user->role, $roles);
        }

        // Verificar el rol único
        return $user->role == $role;
    }
}
