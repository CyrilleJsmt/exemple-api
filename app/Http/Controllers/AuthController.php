<?php
/*
|-------------------------------------------------------------------------------
| Controller Auth
|-------------------------------------------------------------------------------
|
|  Contrôleur de gestion des connexions utilisateurs.
|
| * Login . : Connexion de l'utilisateur
| * Logout  : Déconnexion de l'utilisateur
| * Profile : Renvoie le profil utilisateur
|
*/

namespace App\Http\Controllers;

#region Use directives
use Illuminate\Http\Request;
use App\Models\UserSetup;
use Illuminate\Support\Facades\Schema;
use JWTAuth;
use Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
#endregion

class AuthController extends Controller
{
  //public function __construct()
  //{
  //  $this->middleware('jwt.refresh')->only('refresh');
  //}

  public function refresh()
  {
    $token = JWTAuth::getToken();
    Log::info($token);
    if (!$token) {
      throw new BadRequestHttpException('Token not provided');
    }

    try {
      $token = JWTAuth::refresh($token);
    } catch (TokenInvalidException $e) {
      throw new AccessDeniedHttpException('The token is invalid');
    }
    return response()->json(['error'=> false, 'message' => '', 'data' => [ 'token' => $token ]], 200);
  }

  //----------------------------------------------------------------------------
  #region Login() - Connexion
  public function login(Request $request) {
    $query = $request->only(['username', 'password']);
    $credentials = ['ID' => $query['username'], 'Password' => $query['password']];

    try {
      if (! $token = JWTAuth::attempt($credentials)) {
        return response()->json(['error' => true, 'data' =>  __('auth.invalid_credentials')], 401);
      }
    } catch (JWTException $e) {
      return response()->json(['error' => true, 'message' => 'could_not_create_token'], 500);
    }

    $user = JWTAuth::authenticate($token);

    $user = $this->excludeFields($user, UserSetup::getFields(), FALSE);
    return response()->json(['error' => false, 'data' => [ 'user' => $user, 'token' => $token] ], 200);
  }
  #endregion

  //----------------------------------------------------------------------------
  #region Logout() - Déconnexion
  public function logout() {
    return response()->json(['error'=> false, 'message' => 'auth.logout'], 200);
  }
  #endregion

  //----------------------------------------------------------------------------
  #region Profile() - On renvoie le profil utilisateur
  public function profile() {
    $user = JWTAuth::parseToken()->authenticate();
    //$user->load('resource'); #TODO

    $user = $this->excludeFields($user, UserSetup::getFields(), FALSE);
    return response()->json(['error'=> false, 'message' => '', 'data' => [ 'user' => $user ]], 200);
  }
  #endregion
}
