<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App;
use Alert;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChange;

class ConfigurationUsersController extends Controller
{
	private $module_father	= 10;
	private $module_create	= 11;
	private $module_edit	= 12;

	public function index()
	{
		$data	= App\Module::find($this->module_father);
		return view('layouts.child_module',
			[
				'id'		=> $data['father'],
				'title'		=> $data['name'],
				'details'	=> $data['details'],
				'child_id'	=> $this->module_father
			]);
	}

	public function create()
	{
		$data			= App\Module::find($this->module_father);
		$roles			= App\Role::where('status','ACTIVE')->get();
		$enterprises	= App\Enterprise::orderName()->where('status','ACTIVE')->get();
		$areas			= App\Area::orderName()->where('status','ACTIVE')->get();
		$departments	= App\Departament::orderName()->where('status','ACTIVE')->get();
		$banks			= App\Banks::orderName()->get();
		return view('configuration.user.create',
			[
				'id'			=> $data['father'],
				'title'			=> $data['name'],
				'details'		=> $data['details'],
				'child_id'		=> $this->module_father,
				'option_id'		=> $this->module_create,
				'roles' 		=> $roles,
				'enterprises' 	=> $enterprises,
				'areas'			=> $areas,
				'departments'	=> $departments,
				'banks'			=> $banks,
			]);
	}

	public function edit(Request $request)
	{
		$data	= App\Module::find($this->module_father);
		$name 	= $request->name;
		$email 	= $request->email;
		$type 	= $request->type;
		$users  = App\User::where(function($query) use ($name,$email,$type)
					{
						if ($name != "") 
						{
							$query->where(DB::raw("CONCAT_WS(' ',name,last_name,scnd_last_name)"),'LIKE','%'.$name.'%');
						}
						if ($email != "") 
						{
							$query->where('email','LIKE','%'.$email.'%');
						}
						if ($type != "") 
						{
							$query->where('sys_user',$type);
						}
					})
					->paginate(10);
		return view('configuration.user.search',
			[
				'id'			=> $data['father'],
				'title'			=> $data['name'],
				'details'		=> $data['details'],
				'child_id'		=> $this->module_father,
				'option_id'		=> $this->module_edit,
				'users'			=> $users,
				'name'			=> $name,
				'email'			=> $email,
				'type' 			=> $type
			]);
	}

	public function getData(Request $request)
	{
		//definir variable request
		if($request->ajax())
		{
			$output 	= "";
			$header 	= "";
			$footer 	= "";
			$users  	= App\User::where(DB::raw("CONCAT_WS(' ',name,last_name,scnd_last_name)"),'LIKE','%'.$request->search.'%')
								->get();
			$countUsers = count($users);
			if ($countUsers >= 1)
			{
				$header = "<table id='table' class='table table-hover'><thead><tr><th>ID</th><th>Nombre</th><th>Correo Electr&oacute;nico</th><th>Estatus</th><th>Acci&oacute;n</th></tr></thead><tbody>";
				$footer = "</tbody></table>";
				foreach ($users as $user)
				{
					$output .= "<tr>
									<td>".$user->id."</td>
									<td>".$user->name.' '.$user->last_name.' '.$user->scnd_last_name."</td>
									<td>".$user->email."</td>
									<td>".($user->status=="ACTIVE" || $user->status=="NO-BOLETIN" ? 'Activo': ($user->status=="RE-ENTRY" ||$user->status=="RE-ENTRY-NO-MAIL" ? 'Reingreso': ($user->status=="SUSPENDED"? 'Suspendido': 'Baja')))."</td>
									<td>
										<a href="."'".url::route('configuration.user.edit',$user->id)."'"."class='btn btn-green' alt='Editar' title='Editar'><span class='icon-pencil'></span></a>";
					if($user->status=="ACTIVE" || $user->status=="NO-BOLETIN" || $user->status=="RE-ENTRY" ||$user->status=="RE-ENTRY-NO-MAIL")
					{
						$output .= "
										<a href="."'".url::route('configuration.user.destroy',$user->id)."'"." class='btn-destroy-user btn btn-red' alt='Baja' title='Baja'><span class='icon-blocked'></span></a>
										<a href="."'".url::route('user.suspend',$user->id)."'"." class='btn-suspend-user btn btn-red' alt='Suspender' title='Suspender'><span class='icon-user-minus'></span></a>";
					}
					elseif($user->status=="SUSPENDED")
					{
						$output .= "
										<a href="."'".url::route('configuration.user.destroy',$user->id)."'"." class='btn-destroy-user btn btn-red' alt='Baja' title='Baja'><span class='icon-blocked'></span></a>
										<a href="."'".url::route('configuration.user.reentry',$user->id)."'"." class='btn-reentry-user btn btn-blue' alt='Reingresar' title='Reingresar'><span class='icon-user-check'></span></a>";
					}
					$output .= "
									</td>
								</tr>";
				}
				return Response($header.$output.$footer);
			}
			else
			{
				$notfound = '<div id="not-found" style="display:block;">RESULTADO NO ENCONTRADO</div>';
				return Response($notfound); 
			}
		}
	}

	public function store(Request $request)
	{
		$data					= App\Module::find($this->module_father);
		$user					= new App\User();
		$user->name				= $request->name;
		$user->last_name		= $request->last_name;
		$user->scnd_last_name	= $request->scnd_last_name;
		$user->gender			= $request->gender;
		$user->phone			= $request->phone;
		$user->cell				= $request->cell;
		$user->email			= $request->email;
		$user->password			= bcrypt($request->password);
		$user->status			= "ACTIVE";
		$user->enterprise_id	= $request->enterprise;
		$user->area_id			= $request->area;
		$user->department_id	= $request->department;
		$user->position			= $request->position;
		$user->sys_user			= 1;
		$user->save();
		

		$alert = "swal('','Usuario Creado Exitosamente','success')";

		return redirect()->route('configuration.user.show',$user->id)->with('alert',$alert);
	}

	public function show($id)
	{
		$data					= App\Module::find($this->module_father);
		$roles					= App\Role::where('status','ACTIVE')->get();
		$user_has_enterprises	= DB::table('user_has_enterprise')->select('enterprise_id')->where('user_id',$id)->get();
		$user					= App\User::find($id);
		if($user != "")
		{
			return view('configuration.user.create',
				[
					'id'					=> $data['father'],
					'title'					=> $data['name'],
					'details'				=> $data['details'],
					'child_id'				=> $this->module_father,
					'option_id'				=> $this->module_edit,
					'user' 					=> $user,
					'roles' 				=> $roles,
					'user_has_enterprises' 	=> $user_has_enterprises,
				]);
		}
		else
		{
			return redirect('/error');
		}
	}

	public function validation(Request $request)
	{
		$response = array(
			'valid'		=> false,
			'message'	=> 'Error.'
		);

		$exist = App\User::where('email',$request->email)->get();
		if(count($exist)>0)
		{
			if(isset($request->oldUser) && $request->oldUser===$request->email)
			{
				$response = array('valid' => true);
			}
			else
			{
				$response = array(
					'valid'		=> false,
					'message'	=> 'El usuario ya se encuentra registrado.'
				);
			}
		}
		else
		{
			$response = array('valid' => true);
		}
		return Response($response);
	}

	public function update(Request $request, $id)
	{
		$data					= App\Module::find($this->module_father);
		$user					= App\User::find($id);
		$user->name				= $request->name;
		$user->last_name		= $request->last_name;
		$user->scnd_last_name	= $request->scnd_last_name;
		$user->gender			= $request->gender;
		$user->phone			= $request->phone;
		$user->cell				= $request->cell;
		$user->email			= $request->email;
		$user->password			= bcrypt($request->password);
		$user->enterprise_id	= $request->enterprise;
		$user->area_id			= $request->area;
		$user->department_id	= $request->department;
		$user->position			= $request->position;
		$user->sys_user			= 1;
		$user->save();

		$alert = "swal('', 'Usuario Actualizado Exitosamente', 'success');";
		return redirect('configuration/user')->with('alert',$alert);
	}


	public function destroy($id)
	{
		$data			= App\Module::find($this->module_father);
		$user			= App\User::find($id);
		$user->status	= 'DELETED';
		$user->active	= 0;
		$user->save();
		$alert = "swal('','Usuario dado de baja correctamente','success');";
		return redirect('/configuration/user/edit')->with('alert',$alert);
	}

	public function delete($id)
	{
		$data			= App\Module::find($this->module_father);
		$user			= App\User::find($id);
		$user->status	= 'DELETED';
		$user->active	= 0;
		$user->save();
		$alert = "swal('','Usuario dado de baja correctamente','success');";
		return redirect('/configuration/user/edit')->with('alert',$alert);
	}

	public function suspend($id)
	{
		$data			= App\Module::find($this->module_father);
		$user			= App\User::find($id);
		$user->status	= 'SUSPENDED';
		$user->active	= 0;
		$user->save();
		$alert = "swal('','Usuario suspendido correctamente','success');";
		return redirect('/configuration/user/edit')->with('alert',$alert);
	}

	public function reentry($id)
	{
		$data			= App\Module::find($this->module_father);
		$user			= App\User::find($id);
		$user->status	= 'RE-ENTRY';
		$user->active	= 1;
		$user->save();
		$alert = "swal('','Usuario reingresado correctamente','success');";
		return redirect('/configuration/user/edit')->with('alert',$alert);
	}

	public static function build_modules($father,$accessMod)
	{
		$result		= '';
		$modules	= App\Module::all()
					->where('permissionRequire',0)
					->where('father',$father);
		if(isset($modules) && count($modules)>0)
		{
			$result .= '<ul>';
			foreach ($modules as $key => $value)
			{
				if(in_array($value['id'], $accessMod))
				{
					$result .= '<li><input name="moduleCheck[]" type="checkbox" value="'.$value['id'].'" id="module_'.$value['id'].'" checked><label class="switch"  for="module_'.$value['id'].'"><span class="slider round"></span>'.$value['name'].'</label>'.App\Http\Controllers\ConfigurationUsersController::build_modules($value['id'],$accessMod).'</li>';
				}
				else
				{
					$result .= '<li><input name="moduleCheck[]" type="checkbox" value="'.$value['id'].'" id="module_'.$value['id'].'"><label class="switch"  for="module_'.$value['id'].'"><span class="slider round"></span>'.$value['name'].'</label>'.App\Http\Controllers\ConfigurationUsersController::build_modules($value['id'],$accessMod).'</li>';
				}
			}
			$result .= '</ul>';
		}
		return $result;
	}

	public function getMod(Request $request)
	{
		if($request->ajax())
		{
			$role		= App\User::find($request->user_id);
			$response	= array();
			$modules	= $role->module;
			foreach ($modules as $key => $value)
			{
				$response[] = $value->id;
			}
			return Response($response);
		}
	}

	public function getEntDep(Request $request)
	{
		if ($request->ajax())
		{
			$modules = App\Role_has_module::where('module_id',$request->module_father)->get();
			$edits = '';
			if ($modules != null) 
			{
				$edits .= "<button class='follow-btn editModule' type='button'><span class='icon-pencil'></span></button>";
				foreach ($modules as $mod) 
				{
					foreach(App\Permission_role_enterprise::where('role_has_module_idrole_has_module',$mod->idrole_has_module)->get() as $permissionEnt)
					{
						$edits .= "<span>".
									"<input type='hidden' class='enterprises' name='enterprises_module_'".$request->module_father."'[]' value='".$permissionEnt->enterprise_id."'>".
									"</span>";
					}
					
					foreach(App\Permission_role_dep::where('role_has_module_idrole_has_module',$mod->idrole_has_module)->get() as $permissionDep)
					{
						$edits.= "<span>".
									"<input type='hidden' class='departments' name='departments_module_'".$request->module_father."'[]' value='".$permissionDep->department_id."'>".
									"</span>";
					}
				}
			}
			return Response($edits);
		}
	}

	public function modulePermission(Request $request)
	{
		if ($request->ajax())
		{
			$response = array();
			$user	= App\User::find($request->user);
			$response['enterprise'] = $user->inChargeEnt($request->module)->pluck('enterprise_id');
			$response['department'] = $user->inChargeDep($request->module)->pluck('department_id');
			return Response($response);
		}
	}

	public function modulePermissionUpdate(Request $request)
	{
		if ($request->ajax())
		{
			$user	= App\User::find($request->user);
			$UHM	= App\User_has_module::where('user_id',$request->user)->where('module_id',$request->module)->get();
			if(count($UHM)>0)
			{
				foreach ($UHM as $data)
				{
					$data->delete();
				}
			}
			if($request->action == 'on')
			{
				$user->module()->attach($request->module);
				if($request->additional != '')
				{
					$user->module()->detach($request->additional);
					$user->module()->attach($request->additional);
				}
				if(isset($request->enterprise) || isset($request->department))
				{
					$UHM	= App\User_has_module::where('user_id',$request->user)->where('module_id',$request->module)->first();
					if(isset($request->enterprise))
					{
						foreach ($request->enterprise as $ent)
						{
							$entM										= new App\Permission_user_enterprise();
							$entM->user_has_module_iduser_has_module	= $UHM->iduser_has_module;
							$entM->enterprise_id						= $ent;
							$entM->save();
						}
					}
					if(isset($request->department))
					{
						foreach ($request->department as $dep)
						{
							$depM										= new App\Permission_user_dep();
							$depM->user_has_module_iduser_has_module	= $UHM->iduser_has_module;
							$depM->department_id						= $dep;
							$depM->save();
						}
					}
				}
			}
			else
			{
				$user->module()->detach($request->module);
				if($request->additional != '')
				{
					$user->module()->detach($request->additional);
				}
			}
			return 'DONE';
		}
	}
	public function modulePermissionUpdateSimple(Request $request)
	{
		if ($request->ajax())
		{
			$user		= App\User::find($request->user);
			$modules	= App\Module::where('permissionRequire',0)->pluck('id');
			$user->module()->detach($modules);
			$user->module()->attach($request->modules);
		}
		return 'DONE';
	}
}
