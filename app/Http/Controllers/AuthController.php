<?php

namespace App\Http\Controllers;

use App\ApiCode;
use App\Http\Requests\RegisterRequest;
use App\User;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Password;

class AuthController extends Controller
{
    use SendsPasswordResetEmails , ResetsPasswords{
        ResetsPasswords::broker insteadof SendsPasswordResetEmails;
        ResetsPasswords::credentials insteadof SendsPasswordResetEmails;
    }

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['login' , 'register' , 'forget' , 'doReset']);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login()
    {
        $credentials= request()->validate(['email' =>'required|email' , 'password' =>'required']);
        if (!$token  = auth()->attempt($credentials)){
           return $this->respondUnAuthorizedRequest(ApiCode::INVALID_CREDENTIALS);
        }
        return $this->respondWithToken($token);
    }

    /**
     * @param $token
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function respondWithToken($token){
        return $this->respond([
            'token' => $token ,
            'token_type'=>'bearer',
            'expires'=> auth()->factory()->getTTL() * 60

        ] , 'Login Successful'  );

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout()
    {
        auth()->logout();
        return $this->respondWithMessage('user successfully logout');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function refresh()
    {
        $token =auth()->refresh();
        return $this->respondWithToken($token);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function me()
    {
       return $this->respond(auth()->user());
    }


    /**
     *
     */
    public function register(RegisterRequest $request){
        try {
            $validParams = $request->getAttributes();
            User::create($validParams);
            return $this->respondWithToken(auth()->attempt([
                'email' =>$validParams['email'],
                'password'=>$validParams['password']
            ]));
        }catch (\Exception $e){
            report($e);
           return $this->respondWithUnexpectedError('An Error Occured While Register User');
        }
    }

    public function broker()
    {
        return Password::broker();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function forget(Request $request){
        return $this->sendResetLinkEmail($request);
    }

    /**
     * @param Request $request
     * @param $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return $this->respondWithMessage(['reset link send successfully']);
    }

    /**
     * @param Request $request
     * @param $response
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return $this->respondWithErrorMessage(trans($response));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function doReset(Request $request){
       return $this->reset($request);
    }



    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);
        $user->save();
        event(new PasswordReset($user));
    }

    protected function sendResetResponse(Request $request, $response)
    {
        return $this->respondWithMessage(trans($response));
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return $this->respondWithErrorMessage(trans($response));
    }


}
