<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App;
use Alert;
use Auth;

class ConfigurationModulesController extends Controller
{
	private $module_father	= 7;
	private $module_create	= 8;
	private $module_edit	= 9;

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

	public function create(Request $request)
	{
		$data = App\Module::find($this->module_father);
		return view('configuration.module.create',
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
		$module						= new App\Module();
		$module->name				= $request->name;
		if ($request->module_answer_father == 0) 
		{
			if ($request->module_answer_child == 0) 
			{
				$module->father	= $request->module_child;
			}
			else
			{
				$module->father	= $request->module_father;
			}
		}
		$module->cathegory			= $request->cathegory;
		$module->accion				= $request->accion;
		$module->details			= $request->details;
		$module->order				= $request->order;
		$module->url				= $request->url;
		$module->permissionRequire	= $request->permissionRequire;
		$module->save();

		$alert = "swal('','Módulo Creado Exitosamente','success')";

		return redirect()->route('configuration.module.show',$module->id)->with('alert',$alert);
	}

	public function edit(Request $request)
	{
		$data	= App\Module::find($this->module_father);
		$name 	= $request->name;
		$modules  = App\Module::where(function($query) use ($name)
					{
						if ($name != "") 
						{
							$query->where('name',$name);
						}
					})
					->paginate(10);
		return view('configuration.module.search',
			[
				'id'			=> $data['father'],
				'title'			=> $data['name'],
				'details'		=> $data['details'],
				'child_id'		=> $this->module_father,
				'option_id'		=> $this->module_edit,
				'modules'		=> $modules,
				'name'			=> $name
			]);
	}

	public function show($id)
	{
		$module					= App\Module::find($id);
		if($module != "")
		{
			$data = App\Module::find($this->module_father);
			return view('configuration.module.create',
				[
					'id'					=> $data['father'],
					'title'					=> $data['name'],
					'details'				=> $data['details'],
					'child_id'				=> $this->module_father,
					'option_id'				=> $this->module_edit,
					'module' 				=> $module,
				]);
		}
		else
		{
			return redirect('/error');
		}
	}

	public function delete($id)
	{
		$data			= App\Module::find($this->module_father);
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		$module			= App\Module::find($id);
		$module->delete();
   		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
		$alert = "swal('','Módulo dado de baja correctamente','success');";
		return redirect('/configuration/module/edit')->with('alert',$alert);
	}

	public function update(Request $request,$id)
	{
		$module						= App\Module::find($id);
		$module->name				= $request->name;
		if ($request->module_answer_father == 0) 
		{
			if ($request->module_answer_child == 0) 
			{
				$module->father	= $request->module_child;
			}
			else
			{
				$module->father	= $request->module_father;
			}
		}
		$module->cathegory			= $request->cathegory;
		$module->accion				= $request->accion;
		$module->details			= $request->details;
		$module->order				= $request->order;
		$module->url				= $request->url;
		$module->permissionRequire	= $request->permissionRequire;
		$module->save();

		$alert = "swal('','Módulo Actualizado Exitosamente','success')";

		return redirect()->route('configuration.module.show',$module->id)->with('alert',$alert);
	}

	public function getChild(Request $request)
	{
		if($request->ajax())
		{
			$modules     = App\Module::where('father',$request->idfather)
							->get();
			if (count($modules) > 0) 
			{
				return Response($modules);
			}
		}
	}
}
