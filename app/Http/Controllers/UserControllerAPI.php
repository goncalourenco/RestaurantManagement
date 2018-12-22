<?php

namespace App\Http\Controllers;
use App\Http\Resources\User as UserResource;
use App\User;
use Illuminate\Http\Request;
use Response;
use App\Rules\OldPassword;
use App\Rules\DifferentUsername;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'old_password' => ['required', new OldPassword],
            'password' => 'required|min:3|different:old_password|confirmed',
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
            'username' => ['required','regex:/(^([a-zA-Z]+)(\d+)?$)/u', new DifferentUsername],
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);
//TODO rule
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

    public function endShift(Request $request, $id){
        $user = User::findOrFail($id);
        if (Auth::guard('api')->user()->id != $user->id){        
            return Response::json([
                'unauthorized' => 'Unauthorized access'
            ], 401);
        }
        $user->shift_active=0;

        $user->last_shift_end=$request->end_shift_date;

        $user->save();

        return new UserResource($user);
    }

    public function startShift(Request $request, $id){
        $user = User::findOrFail($id);
        if (Auth::guard('api')->user()->id != $user->id){        
            return Response::json([
                'unauthorized' => 'Unauthorized access'
            ], 401);
        }
        $user->shift_active=1;

        $user->last_shift_start=$request->start_shift_date;

        $user->save();

        return new UserResource($user);
    }
}
