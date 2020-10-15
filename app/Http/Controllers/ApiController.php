<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{

    private $user;

    /**
     * ApiController constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /*
     * Created by Kade Price
     * Purpose: register a new user. Accept and validate rest input. If validation fails return error message in JSON.
     * If validation passes has password and generate new user. Generate Token and return success message.
     *
     */

    public function register(Request $request)
    {
        /**Validate the data using validation rules*/
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        /**Check the validation becomes fails or not */
        if ($validator->fails()) {
            /**Return error message */
            return response()->json([ 'error'=> $validator->errors() ]);
        }

        /**Store all values of the fields*/
        $newuser = $request->all();

        /**Create an encrypted password using the hash */
        $newuser['password'] = Hash::make($newuser['password']);

        /**Insert a new user in the table */
        $this->user->create($newuser);

        /**Create an access token for the user*/
        $success['token'] = $this->user->createToken('AppName')->accessToken;
        /**Return success message with token value*/
        return response()->json(['success'=>$success], 200);
    }

    /*
     * Created by: Kade Price
     * Purpose: Log user in. Accept Rest Post request with email and password. Attempt creds. If passed a valid token will be returned.
     * If attempt fails, return unauthorized message.
     */
    public function login(Request $request)
    {
        /**Validate the data using validation rules*/
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        /**Check the validation becomes fails or not */
        if ($validator->fails()) {
            /**Return error message */
            return response()->json([ 'error'=> $validator->errors() ]);
        }


        /**Read the credentials passed by the user */
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        /**Check the credentials are valid or not */
        if( auth()->attempt($credentials) ){
            /**Store the information of authenticated user */
            $this->user = \Auth::user();
            /**Create token for the authenticated user*/
            $success['token'] = $this->user->createToken('AppName')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            /**Return error message*/
            return response()->json(['error'=>'Unauthorized'], 401);
        }
    }


    /*
     * Created By: Kade Price
     * Purpose: Accept REST Post request. Get authenticated user info and return it in a success message.
     * Authentication requires token that is returned from the login method.
     */
    public function user_info()
    {
        /**Retrieve the information of the authenticated user*/
        $this->user = \Auth::user();
        /** Return user's details*/
        return response()->json(['success' => $this->user], 200);
    }
}
