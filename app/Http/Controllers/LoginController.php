<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Lcobucci\JWT\Parser;
use DB;
use League\OAuth2\Server\Exception\OAuthServerException;
use Throwable;
use App\User;

class LoginController extends Controller
{
    /**
     * Method for login oauth2 passport custom
     * @param LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $client = new Client;
        try {
            $response = $client->post(
                env('APP_URL') . '/oauth/token',
                [
                    'form_params' => [
                        'grant_type' => 'password',
                        'client_id' => env('CLIENT_ID'),
                        'client_secret' => env('CLIENT_SECRET'),
                        'username' => $request->email,
                        'password' => $request->password
                    ],
                    'headers' => [
                        'Accept' => 'application/json',
                        'Content-type' => 'application/x-www-form-urlencoded'
                    ]
                ]
            );
            $token = json_decode((string)$response->getBody(), true);
        } catch (\Throwable $ex) {
            $json = json_decode((string)$ex->getResponse()->getBody()->getContents(), true);

            return Build_response(
                $ex->getCode(),
                'Error de autenticación',
                $json,
                true
            );
        }
        return SuccessResponse($token);
    }

    public function logout(Request $request)
    {
        $bearerToken = $request->bearerToken();
        if ($bearerToken) {
            $id = (new Parser())->parse($bearerToken)->getClaim('jti');
            $revoked = DB::table('oauth_access_tokens')
                            ->where('id', $id)
                            ->update([
                                'revoked' => true
                            ]);
        }
        return SuccessResponse([], 'Se cerró la sesión correctamente');
    }

    /**
     * Funcion para regresar informacion del usuario logueado
     *
     * @param Request $request
     * @return void
     */
    public function userLogged(Request $request){
        $bearerToken = $request->bearerToken();
        try {
            if(!empty($bearerToken)){
                $id = (new Parser())->parse($bearerToken)->getClaim('jti');
                
                $oauth = DB::table('oauth_access_tokens')
                            ->where('id', $id)
                            ->first();

                $user = User::where('id',$oauth->user_id)->first();

                return SuccessResponse($user, 'Información del usuario logueado');
            }else {
                return SuccessResponse('El token no existe');
            }

        } catch (\Throwable $th) {
            return BadResponse('Error de base de datos');
        }
    }
}
