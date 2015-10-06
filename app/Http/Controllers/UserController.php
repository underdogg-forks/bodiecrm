<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;

use App\Http\Requests\User\ShowRequest,
    App\Http\Requests\User\UpdateRequest,
    App\Http\Requests\User\UploadRequest,
    App\Http\Requests\User\UpdatePasswordRequest;

class UserController extends Controller
{

    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('user/index')
            ->with('user', $this->user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        return 'User ID: ' . $id;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  ShowRequest $request
     * @param  int  $id
     * @return Response
     */
    public function edit(ShowRequest $request, $id)
    {
        return view('user/edit')
            ->with('user', $this->user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateRequest  $request
     * @param  int  $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id) 
    {
        $this->user->first_name  = $request->get('first_name', $this->user->first_name);
        $this->user->last_name   = $request->get('last_name', $this->user->last_name);
        $this->user->company     = $request->get('company', $this->user->company);
        $this->user->email       = $request->get('email', $this->user->email);
        $this->user->timezone    = $request->get('timezone', $this->user->timezone);

        $this->user->save();

        return redirect('user')
            ->with('status', \Lang::get('user.updated_user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Upload user avatar
     * 
     * @param  UploadRequest $request
     * @param  Integer $id
     * @return String
     */
    public function postAvatar(UploadRequest $request, $id)
    {
        // If uploading a new avatar
        if ( $request->hasFile('file') && $request->file('file')->isValid() ) {
            $file_extension          = $request->file('file')->getClientOriginalExtension();
            $this->user->profile_url = rand(11111,99999) . '.' . $file_extension;
            
            $file = $request->file('file')->move(
                public_path() . config('paths.user_avatars') . $this->user->id, $this->user->profile_url
            );

            $this->user->save();

            return asset('img/user/' . $this->user->id . '/' . $this->user->profile_url);
        }
        
        return 'Error uploading image';
    }

    /**
     * Show the form to change password
     * 
     * @param  ShowRequest $request
     * @param  Integer $id
     * @return Response
     */
    public function getUpdatePassword(ShowRequest $request, $id) {
        return view('user/update_password')
            ->with('user', $this->user);
    }

    /**
     * Update user password
     * 
     * @param  UpdatePasswordRequest $request
     * @param  Integer $id
     * @return Redirect
     */
    public function putUpdatePassword(UpdatePasswordRequest $request, $id) {

        // If old password does not match
        if ( ! \Hash::check($request->get('current_password'), $this->user->password)) {
            return redirect('user/' . $this->user->id . '/change_password')
                ->withErrors('Error updating password');
        }

        $this->user->password = \Hash::make($request->get('password'));
        
        $this->user->save();

        Auth::logout();

        return redirect('user/' . $this->user->id . '/change_password')
                ->with('status', \Lang::get('user.updated_password'));
    }
}
