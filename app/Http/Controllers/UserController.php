<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Notifications\UserCreate;
use App\User;
use Redirect;
use Alert;
use Auth;

class UserController extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	  if(! Auth::user()->is_admin ) return Redirect::to('user/' . Auth::user()->id . '/edit');
	  
	  $users = User::all();

	  return view('admin.users', compact('users'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(! Auth::user()->is_admin ) return Redirect::to('user/' . Auth::user()->id . '/edit');		

		return view('admin.users_add');
	}

	/**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
	public function store(Request $request)
	{
		if(! Auth::user()->is_admin ) return Redirect::to('user/' . Auth::user()->id . '/edit');

		$user = Input::all();
		$user['password'] = Hash::make($user['password']);
		$user['is_admin'] = ! empty($user['is_admin']);
		unset($user['_token']);

		$user = new User;
		$user->email  		= Input::get('email');
		$user->password  	= Hash::make(Input::get('password'));
		$user->name      	= Input::get('name');
		$user->phone     	= Input::get('phone');
		$user->charge    	= Input::get('charge');
		$user->user_type 	= Input::get('user_type');
		$user->is_admin  	= Input::get('is_admin') ? TRUE : FALSE;

		//dd($user);

		$user->save();

		//return Redirect::to('user');

		$user->notify(new UserCreate($user));

		Alert::success('El usuario fue creado satisfactoriamente!!!','Usuario Creado!!!')->autoclose(6500);

		return redirect()->action('UserController@index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$id = Auth::user()->is_admin ? (int)$id : Auth::user()->id;

		$user = User::find($id);

		return view('admin.users_update', compact('user'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$id = Auth::user()->is_admin ? (int)$id : Auth::user()->id;

		$user = User::find($id);

		$user->email  		= Input::get('email');
		$user->name      	= Input::get('name');
		$user->phone     	= Input::get('phone');
		$user->charge    	= Input::get('charge');
		
		if(Auth::user()->is_admin){
			$user->user_type 	= Input::get('user_type');
		  	$user->is_admin  	= Input::get('is_admin') ? TRUE : FALSE;
		}

		if( Input::get('password') != ""):
			$user->password  = Hash::make(Input::get('password'));
		endif;

		$user->save();

		//return Redirect::to('user');

		Alert::success('El usuario fue editado satisfactoriamente!!!','Usuario Editado!!!')->autoclose(6500);

		return redirect()->action('UserController@index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(! Auth::user()->is_admin ) return Redirect::to('user/' . Auth::user()->id . '/edit');

		$user = User::find($id);

		$user->delete();

		//return Redirect::to('user');

		Alert::success('El usuario fue eliminado satisfactoriamente!!!','Usuario Eliminado!!!')->autoclose(6500);

		return redirect()->action('UserController@index');
	}
}
