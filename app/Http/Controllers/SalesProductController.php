<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App;
use Alert;
use Auth;

class SalesProductController extends Controller
{
    private $module_father	= 16;
	private $module_create	= 17;
	private $module_edit	= 18;

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
		return view('sales.products.create',
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
		
	}

	public function edit(Request $request)
	{
		$data	= App\Module::find($this->module_father);
		
		return view('sales.products.search',
			[
				'id'			=> $data['father'],
				'title'			=> $data['name'],
				'details'		=> $data['details'],
				'child_id'		=> $this->module_father,
				'option_id'		=> $this->module_edit,
			]);
	}

	public function show($id)
	{

	}

	public function update(Request $request,$id)
	{

	}

	public function delete($id)
	{

	}

	public function getClients(Request $request)
	{
		if ($request->ajax()) 
		{
			$name = $request->name;
			$clients = App\Client::where('status',1)
					->where(function($query) use ($name)
					{
						if ($name != "") 
						{
							$query->where(DB::raw("CONCAT_WS(' ',name,last_name,scnd_last_name)"),'LIKE','%'.$name.'%');
						}
					})
					->get();

			return view('sales.products.result_client',['clients'=>$clients]);
		}
	}

	public function updateList(Request $request)
	{
		if ($request->ajax()) 
		{
			$products = App\Products::where('products.status',1)->whereNotIn('id',$request->product_id)->orderDescription()->get();


			$count = 0;
			$prods = [];
			if (count($products)>0) 
			{
				foreach ($products as $prod) 
				{
					$prods[$count]['id']			= $prod->id;
					$prods[$count]['code']			= $prod->code;
					$prods[$count]['description']	= $prod->description;
					$count++;
				}
			}
			return Response($prods);
		}
	}

	public function storeClient(Request $request)
	{
		if ($request->ajax()) 
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

			$data = [];
			$data['id'] = $client->id;
			$data['name'] = $client->name.' '.$client->last_name.' '.$client->scnd_last_name;

			return Response($data);
		}
	}
}
