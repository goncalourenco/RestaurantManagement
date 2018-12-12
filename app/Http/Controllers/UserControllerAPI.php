<?php

namespace App\Http\Controllers;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Http\Request;
use Response;
use App\Rules\OldPassoword as OldPasswordRule;


class UserControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return UserResource::collection(User::pa)
    }

    public function changePassword(Request $request, $id){
        $request->validate([
            'old_password' => ['required', new OldPasswordRule],
            'password' => 'required|min:3|diffrrent:old_password|confirmed',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = User::findOrFail($id);
        
        if($request->user() && $request->user()->id != $user->id){
            return Response::json([
                'unauthorized' => 'Unauthorized access'
            ], 401);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return new UserResource($user);
    }

    public function myUserDetails(Request $request)
    {
        return new UserResource($request->user());
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3|regex:/^[A-z][A-z\s\.\']+$/',
            'username' => 'required|unique:users,username|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $user = User::findOrFail($id);

        if (Auth::guard('api')->user()->id != $user->id){        
            return Response::json([
                'unauthorized' => 'Unauthorized access'
            ], 401);
        }

        //Verificar se existe foto
        if($request->photo != null){
            $photo = $request->file('photo');
            $path = basename($photo->store('profiles', 'public'));
            $user->photo_url = basename($path);
        }

        $user->username = $request->username;
        $user->name = $request->name;
        //guardar na bd
        $user->save();
        
        //Devolver user em json para o cliente
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
