<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App\Sales;
use App\Module;
use App\Products;
use Alert;
use Auth;

class ReportAdministrationController extends Controller
{
	private $module_father	= 4;
	public function index()
	{
		$data	= Module::find($this->module_father);
		return view('layouts.child_module',
			[
				'id'		=>	$this->module_father,
				'title'		=>	$data['name'],
				'details'	=>	$data['details'],
				'child_id'	=>	$this->module_father
			]);
	}

	public function administration()
	{
		$data	= Module::find(28);
		return view('layouts.child_module',
			[
				'id'		=>	$this->module_father,
				'title'		=>	$data['name'],
				'details'	=>	$data['details'],
				'child_id'	=> 	28
			]);
	}

	public function reportSales(Request $request)
	{
		$data 	= Module::find(29);
		$sales 	= Sales::where(function($query) use ($request)
				{
					if ($request->mindate != "" && $request->maxdate != "") 
					{
						$query->whereBetween('created_at',[''.$request->mindate.' '.date('00:00:00').'',''.$request->maxdate.' '.date('23:59:59').'']);
					}

					if ($request->product_id != "") 
					{
						$query->whereHas('detail',function($queryDetail) use ($request)
						{
							$queryDetail->whereIn('products_id',$request->product_id);
						});
					}

					if ($request->client_id != "") 
					{
						$query->whereIn('client_id',$request->client_id);
					}
				})
				->orderBy('id','DESC')
				->paginate(5);
				

		$salesForMonth = [];
		for ($i=1; $i < 13; $i++) 
		{ 
			$salesForMonth[$i] = Sales::whereMonth('created_at',$i)->count();
		}

		$productSold = [];
		foreach (Products::all() as $key => $product) 
		{
			$productSold['name'][$key] 	= $product->description;
			$productSold['total'][$key] = $product->totalSold();
		}

		return view('report.administration.sales',
			[
				'id'			=> $data['father'],
				'title'			=> $data['name'],
				'details'		=> $data['details'],
				'child_id'		=> 28,
				'option_id'		=> 29,
				'sales'			=> $sales,
				'mindate'		=> $request->mindate,
				'maxdate'		=> $request->maxdate,
				'product_id'	=> $request->product_id,
				'client_id'		=> $request->client_id,
				'salesForMonth' => $salesForMonth,
				'productSold' 	=> $productSold
			]);
	}

	public function inputsOutputs(Request $request)
	{
		$data 	= Module::find(31);
		return view('report.administration.inputs_outputs',
			[
				'id'			=> $data['father'],
				'title'			=> $data['name'],
				'details'		=> $data['details'],
				'child_id'		=> 28,
				'option_id'		=> 31
			]);
	}

}
