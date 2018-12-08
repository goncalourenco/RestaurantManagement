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

    public function myProfile(Request $request)
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
        //
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
