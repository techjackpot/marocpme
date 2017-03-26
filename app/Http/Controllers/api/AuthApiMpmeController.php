<?php
/**
 * Created by.
 * User: anass.nadir@gmail.com
 * Date: 3/19/17
 * Time: 3:05 PM
 */

namespace App\Http\Controllers\api;


use Illuminate\Http\Request;
use Dingo\Api\Exception\ValidationHttpException;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;

class AuthApiMpmeController extends BaseController
{
    protected function throwValidationException(\Illuminate\Http\Request $request, $validator) {
        throw new ValidationHttpException($validator->errors());}


    /**
     * @param Request $request
     * @return mixed
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials=$request->only('email', 'password');

        try{

            if(!$token=JWTAuth::attempt($credentials)){
                return response()->json(['error' => 'invalid_credentials'], 401);
            }


        }
        catch (JWTException $e){
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response(compact('token'),200)->withHeaders([
            'Content-Type' => 'application/json',
            'Action-State' => 'Authenticated Successfully',
        ]);
    }




//password reset send link
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return response(['status', trans($response)],200)->withHeaders([
            'Content-Type' => 'application/json',
        ]);

    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse($response)
    {

        return response(['email' => trans($response)],422)->withHeaders([
            'Content-Type' => 'application/json',
        ]);

    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    //password reset get link


    public function reset(Request $request)
    {
        $this->validate($request, array(
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ));


        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($response);
    }

    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();
    }

}