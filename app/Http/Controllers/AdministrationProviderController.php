<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App;
use Alert;
use Auth;

class AdministrationProviderController extends Controller
{
	private $module_father	= 25;
	private $module_create	= 26;
	private $module_edit	= 27;

	public function index()
	{
		$data	= App\Module::find($this->module_father);
		return view('layouts.child_module',
			[
				'id'		=>	$data['father'],
				'title'		=>	$data['name'],
				'details'	=>	$data['details'],
				'child_id'	=>	$this->module_father
			]);
	}

	public function create()
	{
		$data = App\Module::find($this->module_father);
		return view('administration.provider.create',
			[
				'id'		=>	$data['father'],
				'title'		=>	$data['name'],
				'details'	=>	$data['details'],
				'child_id'	=>	$this->module_father,
				'option_id'	=> 	$this->module_create
			]);
	}

	public function store(Request $request)
	{
		$provider					= new App\Provider();
		$provider->businessName		= $request->businessName;
		$provider->phone			= $request->phone;
		$provider->rfc				= $request->rfc;
		$provider->address			= $request->address;
		$provider->number			= $request->number;
		$provider->colony			= $request->colony;
		$provider->postalCode		= $request->postalCode;
		$provider->city				= $request->city;
		$provider->state_idstate	= $request->state_idstate;
		$provider->status			= 1;
		$provider->users_id			= Auth::user()->id;
		$provider->save();

		$alert = "swal('','Proveedor Creado Exitosamente','success')";

		return redirect()->route('administration.provider.show',$provider->id)->with('alert',$alert);
	}

	public function edit(Request $request)
	{
		$data		= App\Module::find($this->module_father);
		$name 		= $request->name;
		$providers 	= App\Provider::where(function($query) use ($name)
					{
						if ($name != "") 
						{
							$query->where('businessName','LIKE','%'.$name.'%');
						}
					})
					->paginate(10);
		return view('administration.provider.search',
			[
				'id'		=> $data['father'],
				'title'		=> $data['name'],
				'details'	=> $data['details'],
				'child_id'	=> $this->module_father,
				'option_id'	=> $this->module_edit,
				'providers'	=> $providers,
				'name'		=> $name
			]);
	}

	public function show($id)
	{
		$data					= App\Module::find($this->module_father);
		$provider				= App\Provider::find($id);
		if($provider != "")
		{
			return view('administration.provider.create',
				[
					'id'		=> $data['father'],
					'title'		=> $data['name'],
					'details'	=> $data['details'],
					'child_id'	=> $this->module_father,
					'option_id'	=> $this->module_edit,
					'provider'	=> $provider,
				]);
		}
		else
		{
			return redirect('/error');
		}
	}

	public function update(Request $request,$id)
	{
		$provider					= App\Provider::find($id);
		$provider->businessName		= $request->businessName;
		$provider->phone			= $request->phone;
		$provider->rfc				= $request->rfc;
		$provider->address			= $request->address;
		$provider->number			= $request->number;
		$provider->colony			= $request->colony;
		$provider->postalCode		= $request->postalCode;
		$provider->city				= $request->city;
		$provider->state_idstate	= $request->state_idstate;
		$provider->status			= 1;
		$provider->users_id			= Auth::user()->id;
		$provider->save();

		$alert = "swal('','Proveedor Actualizado Exitosamente','success')";

		return redirect()->route('administration.provider.show',$provider->id)->with('alert',$alert);
	
	}

	public function delete($id)
	{
		$provider			= App\Provider::find($id);
		$provider->status	= 0;
		$provider->users_id	= Auth::user()->id;
		$provider->save();

		$alert = "swal('','Proveedor Suspendido Exitosamente','success')";

		return redirect()->route('administration.provider.edit')->with('alert',$alert);
		
	}
}
