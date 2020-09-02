<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        try {
            //Access token from the request        
            $token = JWTAuth::parseToken();
            //Try authenticating user       
            $user = $token->authenticate();

            $roleUsuarioLogado = $user->roles()->get()->pluck('role')->toArray();

            // $result = !count(array_intersect($roleUsuarioLogado, $roles));

        } catch (TokenExpiredException $e) {
            //Thrown if token has expired        
            return $this->unauthorized('Seu token esta expirado, faça login novamente');
        } catch (TokenInvalidException $e) {
            //Thrown if token invalid
            return $this->unauthorized('Seu token esta invalido. Please, faça login novamente');
        } catch (JWTException $e) {
            //Thrown if token was not found in the request.
            return $this->unauthorized('Por favor, informe o token de autenticação');
        }
        //Verifica se usuario esta logado e se um array contem valor no outro array
        if ($user && !count(array_intersect($roleUsuarioLogado, $roles))) {
            return $next($request);
        }

        return $this->unauthorized();
    }

    private function unauthorized($message = null)
    {
        return response()->json([
            'message' => $message ? $message : 'Desculpe, você não possui permissao para acessar essa area',
            'success' => false
        ], 403);
    }
}
