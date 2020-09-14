<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App;
use Alert;
use Auth;

class AdministrationClientController extends Controller
{
    private $module_father	= 13;
	private $module_create	= 14;
	private $module_edit	= 15;

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
		return view('administration.client.create',
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
		$client					= new App\Client();
		$client->name			= $request->name;
		$client->last_name		= $request->last_name;
		$client->scnd_last_name	= $request->scnd_last_name;
		$client->phone			= $request->phone;
		$client->rfc			= $request->rfc;
		$client->address		= $request->address;
		$client->number			= $request->number;
		$client->colony			= $request->colony;
		$client->postalCode		= $request->postalCode;
		$client->city			= $request->city;
		$client->state_idstate	= $request->state_idstate;
		$client->status			= 1;
		$client->users_id		= Auth::user()->id;
		$client->save();

		$alert = "swal('','Cliente Registrado Exitosamente','success')";

		return redirect()->route('administration.client.show',$client->id)->with('alert',$alert);
	}

	public function edit(Request $request)
	{
		$data		= App\Module::find($this->module_father);
		$name 		= $request->name;
		$clients 	= App\Client::where(function($query) use ($name)
					{
						if ($name != "") 
						{
							$query->where(DB::raw("CONCAT_WS(' ',name,last_name,scnd_last_name)"),'LIKE','%'.$name.'%');
						}
					})
					->paginate(10);
		return view('administration.client.search',
			[
				'id'		=> $data['father'],
				'title'		=> $data['name'],
				'details'	=> $data['details'],
				'child_id'	=> $this->module_father,
				'option_id'	=> $this->module_edit,
				'clients'	=> $clients,
				'name'		=> $name
			]);
	}

	public function show($id)
	{
		$data	= App\Module::find($this->module_father);
		$client	= App\Client::find($id);
		if($client != "")
		{
			return view('administration.client.create',
				[
					'id'		=> $data['father'],
					'title'		=> $data['name'],
					'details'	=> $data['details'],
					'child_id'	=> $this->module_father,
					'option_id'	=> $this->module_edit,
					'client'	=> $client,
				]);
		}
		else
		{
			return redirect('/error');
		}
	}

	public function update(Request $request,$id)
	{
		$client					= App\Client::find($id);
		$client->name			= $request->name;
		$client->last_name		= $request->last_name;
		$client->scnd_last_name	= $request->scnd_last_name;
		$client->phone			= $request->phone;
		$client->rfc			= $request->rfc;
		$client->address		= $request->address;
		$client->number			= $request->number;
		$client->colony			= $request->colony;
		$client->postalCode		= $request->postalCode;
		$client->city			= $request->city;
		$client->state_idstate	= $request->state_idstate;
		$client->status			= 1;
		$client->users_id		= Auth::user()->id;
		$client->save();

		$alert = "swal('','Cliente Actualizado Exitosamente','success')";

		return redirect()->route('administration.client.show',$client->id)->with('alert',$alert);
	}

	public function delete($id)
	{
		$client				= App\Client::find($id);
		$client->status		= 0;
		$client->users_id	= Auth::user()->id;
		$client->save();

		$alert = "swal('','Cliente Suspendido Exitosamente','success')";

		return redirect()->route('administration.client.edit')->with('alert',$alert);
	}
}
