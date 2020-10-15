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
            'email' => 'required|email',
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
}
