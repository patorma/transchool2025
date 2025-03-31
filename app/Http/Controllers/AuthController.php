<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
     /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(),[
            'name'=>'required|string|min:4|max:300',
            'last_name'=>'required|string|min:4|max:300',
            'role'=>'required|string|in:admin,apoderado,transportista',
            'comuna' => 'required|string|min:4|max:20',
            'telefono' =>'required|string|min:6|max:30',
            'email'=>'required|string|email|min:10|max:90|unique:users',
            'password'=>'required|string|min:10|confirmed',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        $user = User::create([
            'name' => $request->get('name'),
            'last_name' => $request->get('last_name'),
            'role' => $request->get('role'),
            'comuna' => $request->get('comuna'),
            'telefono' => $request->get('telefono'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);

        return (new AuthResource($user))->additional([
            'message' => 'User created succesfully'
        ]);
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'=>'required|string|email|min:10|max:90|',
            'password'=>'required|string|min:10',
        ]);
        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }//con only se le indica que solo se le pasa email y password
        $credentials = $request->only(['email','password']);
        try {
            if(!$token =JWTAuth::attempt($credentials)){
                return response()->json(['error'=> 'Invalid credentials']);
            }

            return response()->json(['token'=> $token],200);
        } catch (JWTException $e) {
            return response()->json(['error'=>'Cold not create token',$e],500);
        }
    }

    public function getUser(){
        $user = Auth::user();
       // return response()->json($user,200);
       return new AuthResource($user);
    }
    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out successfully'],200);
    }

    public function getUserById($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'],404);
        }

        return (new AuthResource($user));
    }
    public function updateUserById(Request $request,$id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message' => 'User not found'],404);
        }

        $validator = Validator::make($request->all(),[
            'name'=>'sometimes|string|min:3|max:300',
            'last_name'=>'sometimes|string|min:3|max:300',
            'role'=>'sometimes|string|in:admin,apoderado,transportista',
            'comuna' => 'sometimes|string|min:4|max:20',
            'telefono' =>'sometimes|string|min:6|max:15',
            'email'=>'sometimes|string|email|min:10|max:90',
            'password'=>'sometimes|string|min:10|confirmed',
        ]);

        if($validator->fails()){
            return response()->json(['error'=> $validator->errors()],422);
        }

        if($request->has('name')){
            $user->name = $request->name;
        }
        if($request->has('last_name')){
            $user->last_name = $request->last_name;
        }
        if($request->has('role')){
            $user->role = $request->role;
        }
        if($request->has('comuna')){
            $user->comuna = $request->comuna;
        }
        if($request->has('telefono')){
            $user->telefono = $request->telefono;
        }
        if($request->has('email')){
            $user->email = $request->email;
        }
        if($request->has('password')){
            $user->password = $request->password;
        }
        $user->update();
        return (new AuthResource($user))->additional([
            'message' => 'User updated successfully'
        ]);
    }

    public function getUsers(Request $request){
        //se obtierne el id del usuario que se logueo
        $userId = $request->user()->id;
        //luego se busca la lista de usuarios pero no incluye el id del usuario que inicio sesion
        $users= User::where('id', '!=', $userId)->paginate(5);
        if($users->isEmpty()){
            return response()->json(['message'=> 'No users found']);
        }

        return AuthResource::collection($users);
    }

    public function deleteUserById($id){
        $user = User::find($id);
        if(!$user){
            return response()->json(['message'=>'User not found'.' '.'con el id:'.' '.$id],404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'.' ' .'con el id:'.' '.$id],200);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // protected function respondWithToken($token)
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer',
    //         'expires_in' => auth()->factory()->getTTL() * 60
    //     ]);
    // }
}
