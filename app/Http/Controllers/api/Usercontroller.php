<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usercontroller extends Controller
{
    public function register(UserRequest $request)
    {
        // $validateData = Validator::make($request->all(), [
        //     'name' => ['required'],
        //     'email' => ['required', 'email'],
        //     'password' => ['min:8', 'required', 'confirmed'],
        //     'password_confirmation' => ['required'],

        // ]);

        // if ($validateData->fails()) {
        //     return response()->json($validateData->messages(), 400);
        // } else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
          
            DB::beginTransaction();
            try {

                $user = User::create($data);
                $token = $user->createToken("auth_token")->accessToken;
                $user['token']=$token;
                DB::commit();

                return response()->json(
                    [
                        'user' => $user,
                        'message' => 'user created succsesfully',
                        'statues' => 1,
                    ],
                    200
                );
            } catch (\Exception $error) {
                DB::rollBack(); 
            }
        // }
    }

    public function login(Request $request)
    {   
        $validateData = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
            
        ]);
        
        $user = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('auth token')->accessToken;
            };

        return response()->json(
            [
                'token' => $token,
                'user' => $user,
                'message' => 'user login succsesfully',
                'statues' => 1,
            ]
            );
    }

    public function index()
    {
       $users = User::all();
       if (is_null($users)) {
        return response()->json(
            [
                'user' => null,
                'message' => 'user not found ',
                'statues' => 0,
            ]
            );
    }else{
        return response()->json(
            [
                'user' => $users,
                'message' => 'user found succsesfully',
                'statues' => 1,
            ]
            );
    }

    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        // if (is_null($user)) {
        //     return response()->json(
        //         [
        //             'user' => null,
        //             'message' => 'user not found ',
        //             'statues' => 0,
        //         ]
        //         );
        // }else{
            if($user){
                return $this->sendResponse($user,'user retrieve');
            }
            
        // }

    }

    public function delete($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json(
                [
                    'message' => 'user not found',
                    'statues' => 0,
                ],
                500
            );
        } else{
          
            DB::beginTransaction();
            try {
                $user->delete();
                DB::commit();

                return response()->json(
                    [
                        'message' => 'user deleted succsesfully',
                        'statues' => 1,
                    ],
                    200
                );
            } catch (\Exception $error) {
                DB::rollBack(); 

                return response()->json(
                    [
                        'message' => 'user not found',
                        'statues' => 0,
                    ],
                    500
                );
            }
        }

    }

    public function update($id ,Request $request)
    {
        $user = User::find($id);

        if (is_null($user)) 
        {
            return response()->json(
                [
                    'message' => 'user not found',
                    'statues' => 0,
                ],
                500
            );
        }else
        {
            DB::beginTransaction();
            try {
                $user->name = $request['name'];
                $user->email = $request['email'];
                $user->save();                
                DB::commit();

                return response()->json(
                    [   
                        'user' => $user,
                        'message' => 'user updated succsesfully',
                        'statues' => 1,
                    ],
                    200
                );
            } catch (\Exception $error) {
                DB::rollBack(); 

                return response()->json(
                    [
                        'message' => 'user not found',
                        'statues' => 0,
                    ],
                    500
                );
            }
        }

    }
}
