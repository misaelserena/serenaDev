<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App;
use Alert;
use Auth;

class ConfigurationProductController extends Controller
{
	private $module_father	= 19;
	private $module_create	= 20;
	private $module_edit	= 21;

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
		return view('configuration.product_price.create',
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
		$product 							= new App\Products();
		$product->code						= $request->code;
		$product->description				= $request->description;
		$product->net_content				= $request->net_content;
		$product->unit						= $request->unit;
		$product->price						= $request->price;
		$product->price_purchase			= $request->price_purchase;
		$product->wholesale_price			= $request->wholesale_price;
		$product->users_id					= Auth::user()->id;
		$product->status					= 1;
		$product->save();

		$alert = "swal('','Producto Registrado Exitosamente','success')";

		return redirect()->route('configuration.product_price.show',$product->id)->with('alert',$alert);
	}

	public function edit(Request $request)
	{
		$data			= App\Module::find($this->module_father);
		$description	= $request->description;
		$code			= $request->code;
		$products 	 	= App\Products::where(function($query) use ($description,$code)
					{
						if ($description != "") 
						{
							$query->where('description','LIKE','%'.$description.'%');
						}
						if ($code != "") 
						{
							$query->where('code','LIKE','%'.$code.'%');
						}
					})
					->paginate(10);

		return view('configuration.product_price.search',
			[
				'id'			=> $data['father'],
				'title'			=> $data['name'],
				'details'		=> $data['details'],
				'child_id'		=> $this->module_father,
				'option_id'		=> $this->module_edit,
				'description'	=> $description,
				'code'			=> $code,
				'products'		=> $products,
			]);
	}

	public function show($id)
	{
		$data		= App\Module::find($this->module_father);
		$product	= App\Products::find($id);
		if($product != "")
		{
			return view('configuration.product_price.create',
				[
					'id'					=> $data['father'],
					'title'					=> $data['name'],
					'details'				=> $data['details'],
					'child_id'				=> $this->module_father,
					'option_id'				=> $this->module_edit,
					'product' 				=> $product,
				]);
		}
		else
		{
			return redirect('/error');
		}
	}

	public function update(Request $request,$id)
	{
		$product 							= App\Products::find($id);
		$product->code						= $request->code;
		$product->description				= $request->description;
		$product->net_content				= $request->net_content;
		$product->unit						= $request->unit;
		$product->price						= $request->price;
		$product->price_purchase			= $request->price_purchase;
		$product->wholesale_price			= $request->wholesale_price;
		$product->users_id					= Auth::user()->id;
		$product->status					= 1;
		$product->save();

		$alert = "swal('','Producto Actualizado Exitosamente','success')";

		return redirect()->route('configuration.product_price.show',$product->id)->with('alert',$alert);
	}

	public function delete($id)
	{
		$product 			= App\Products::find($id);
		$product->status 	= 0;
		$product->save();

		$alert = "swal('','Producto dado de baja exitosamente','success')";

		return redirect()->route('configuration.product_price.edit')->with('alert',$alert);
	}

}
