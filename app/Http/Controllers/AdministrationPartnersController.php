<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;

class AdministrationPartnersController extends Controller
{
    private $module_father	= 32;
	private $module_create	= 33;
	private $module_edit	= 34;

    public function index()
    {
    	$data	= Module::find($this->module_father);
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
        $data = Module::find($this->module_father);
		return view('administration.partners.create',
			[
				'id'		=>	$data['father'],
				'title'		=>	$data['name'],
				'details'	=>	$data['details'],
				'child_id'	=>	$this->module_father,
				'option_id'	=> 	$this->module_create
			]);
    }
}
