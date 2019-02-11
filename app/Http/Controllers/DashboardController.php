<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commitment;
use App\User;

class DashboardController extends Controller
{
    /**
	 * Display dashboard with a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$commitments = Commitment::all();

		$users = User::all();

		//dd($commitments, $users);

		//return view('admin.dashboard')->with('commitments', $commitments, 'users', $users);

		return view('admin.dashboard', compact('commitments', 'users'));
	}
}