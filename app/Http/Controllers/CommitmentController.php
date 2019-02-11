<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Commitment;
use App\Objective;
use App\User;
use App\Step;
use Alert;
use Auth;
use DB;

class CommitmentController extends Controller
{
    // RUTA DE DIRECTORIO PARA ALMACENAR LOS ARCHIVOS
	const FILES_DIR = './files';

	// REQUIERE AUTENTICACION DE ACCESO
	
	/*public function __construct(){
		$this->beforeFilter('auth');
	}*/

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// MUESTRA LOS DATOS DE LOS COMPROMISOS EN LA VISTA DE ADMINISTRACION
		if(Auth::user()->is_admin){
			$commitments = Commitment::all();
		}
		else{
			$commitments = Auth::user()->commitments;
		}

		return view('admin.commitments', compact('commitments'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		// SOLO LOS USUARIOS CON PERFIL ADMINISTRADOR PUEDE CREAR COMPROMISOS
		if(! Auth::user()->is_admin ) return Redirect::to('commitment');

		//$users = User::all()->lists('name','id');

		//return View::make('admin.commitments_add')->with(['users' => $users]);

		$users = User::all()->pluck('name','id');

		return view('admin.commitments_add', compact('users'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// SOLO LOS USUARIOS CON PERFIL ADMINISTRADOR PUEDE CREAR COMPROMISOS
		if(! Auth::user()->is_admin ) return Redirect::to('commitment');

		$commitment = new Commitment(Input::all());

		// GUARDA DESCRIPCIÓN ARCHIVO; ELIMINAR ARCHIVO ANTERIOR SI EXISTE
		if(Input::hasFile('plan')){
			$name = uniqid() . '.' . Input::file('plan')->getClientOriginalExtension();
			Input::file('plan')->move(self::FILES_DIR, $name);
			$commitment->plan = $name;
		}

		$commitment->save();

		// ACTUALIZA USUARIOS
		$users_array = array_unique(Input::get('users'));

		foreach($users_array AS $key => $value){
			DB::table('commitment_user')->insert([
				'user_id' => $value,
				'commitment_id' => $commitment->id
			]);
		}

		// CREA LAS CUATRO ETAPAS
		// Las fechas por defecto
		$dates = [
			mktime(0,0,0,10,27,2014),
			mktime(0,0,0,3,8,2015),
			mktime(0,0,0,7,22,2015),
			mktime(0,0,0,12,31,2015),
		];

		for($i = 1; $i <= 4; $i++ ){
			$step = new Step([
			  	'commitment_id' => $commitment->id,
		  		'ends'          => date('Y-m-d', $dates[$i-1]),
			  	'step_num'      => $i
			]);

			$step->save();

			// CREA UN EVENTO POR CADA PASO
			$objective = new Objective([
					'step_id'   => $step->id,
					'step_num'  => $step->step_num,
					'event_num' => 1,
					'status'    => 'a'
			]);
			
			$objective->save();
		}

		//return Redirect::to('commitment');

		Alert::success('El compromiso fue creado satisfactoriamente!!!','Compromiso Creado!!!')->autoclose(6500);

		return redirect()->action('CommitmentController@index');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$commitment = Commitment::with('steps.objectives')->find($id);


		if(Auth::user()->is_admin || $commitment->users->find(Auth::user()->id)){

		  $users = User::all()->pluck('name','id');

		  return view('admin.commitments_update', compact('commitment', 'users'));

		}
		else{
			return Redirect::to('commitment');
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$commitment = Commitment::find($id);

		if(Auth::user()->is_admin || $commitment->users->find(Auth::user()->id)){

		  $commitment->fill(Input::all());

		  // update the new file if exist, and remove the previous file
		  if(Input::hasFile('plan')){
			  @unlink(self::FILES_DIR . '/' . $commitment->plan);

	  	  $name = uniqid() . '.' . Input::file('plan')->getClientOriginalExtension();
	  	  Input::file('plan')->move(self::FILES_DIR, $name);
	  	  $commitment->plan = $name;
	    }

		  $commitment->save();

		  // UPDATE THE USERS (only for admin)
		  if(Auth::user()->is_admin){
		    DB::table('commitment_user')->where('commitment_id', $commitment->id)->delete();
	      $users_array = array_unique(Input::get('users'));
	      foreach($users_array AS $key => $value){
	  	    DB::table('commitment_user')->insert([
	  		    'user_id' => $value,
	  		    'commitment_id' => $commitment->id
	  	    ]);
	      }
	    }

		// SAVE THE DATES FOR EACH STEP
		for($i = 1; $i <= 4; $i++){
			Step::where([
			  'commitment_id' => $commitment->id, 
			  'step_num' => $i
			])->update(['ends' => Input::get('step-' . $i)]);
		}

			return Redirect::to('commitment');

		}else{

			return Redirect::to('commitment');

		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		if(! Auth::user()->is_admin ) return Redirect::to('commitment');

		$commitment = Commitment::find($id);

		if(! empty($commitment->plan) ){
			@unlink(self::FILES_DIR . '/' . $commitment->plan);
		}

		$commitment->delete();

		Alert::success('El compromiso fue eliminado satisfactoriamente!!!','Compromiso Eliminado!!!')->autoclose(6500);

		return Redirect::to('commitment');
	}
}
