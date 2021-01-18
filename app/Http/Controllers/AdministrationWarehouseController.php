<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\URL;
use App;
use Alert;
use Auth;
use Excel;


class AdministrationWarehouseController extends Controller
{
    private $module_father	= 22;
	private $module_create	= 23;
	private $module_edit	= 24;

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
		return view('administration.warehouse.create',
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
		$updateWarehouse = App\Warehouse::where('product_id',$request->product_id)->get();

		if ($updateWarehouse != "") 
		{
			foreach ($updateWarehouse as $update)
			{
				$w				= App\Warehouse::find($update->id);
				$w->users_id 	= Auth::user()->id;
				$w->status		= 0;
				$w->save();
			}
		}

		$warehouse							= new App\Warehouse();
		$warehouse->product_id				= $request->product_id;
		$warehouse->date					= $request->date;
		$warehouse->quantity				= $request->quantity;
		$warehouse->price_purchase			= $request->price_purchase;
		$warehouse->price					= $request->price;
		$warehouse->provider_id				= $request->provider_id;
		$warehouse->quantity_ex				= $request->quantity_ex;
		$warehouse->wholesale_price			= $request->wholesale_price;
		$warehouse->min_wholesale_quantity	= $request->min_wholesale_quantity;
		$warehouse->users_id				= Auth::user()->id;
		$warehouse->status					= 1;
		$warehouse->save();

		$alert = "swal('','Inventario Registrado Exitosamente','success')";

		return redirect()->route('administration.warehouse.show',$warehouse->id)->with('alert',$alert);
	}

	public function getProduct(Request $request)
	{
		if ($request->ajax()) 
		{
			$product = App\Products::select('products.price as price','products.wholesale_price as wholesale_price','products.price_purchase as price_purchase')
							->where('status',1)
							->find($request->idproduct);

			if (count($product)>0) 
			{
				return Response($product);
			}
		}
	}

	public function getWarehouse(Request $request)
	{
		if ($request->ajax()) 
		{
			$warehouse = App\Warehouse::select('warehouse.quantity_ex as quantity_ex','warehouse.id as id')
							->where('status',1)
							->where('product_id',$request->idproduct)
							->get();

			if ($warehouse != "") 
			{
				return Response($warehouse);
			}
		}
	}

	public function edit(Request $request)
	{
		$data		= App\Module::find($this->module_father);
		$product_id	= $request->product_id;
		$date		= $request->date;
		$warehouse 	= App\Warehouse::where('status',1)
					->where(function($query) use ($product_id,$date)
					{
						if ($product_id != "") 
						{
							$query->whereIn('product_id',$product_id);
						}
						if ($date != "") 
						{
							$query->where('date',$date);
						}
					})
					->paginate(10);
		return view('administration.warehouse.search',
			[
				'id'		=> $data['father'],
				'title'		=> $data['name'],
				'details'	=> $data['details'],
				'child_id'	=> $this->module_father,
				'option_id'	=> $this->module_edit,
				'warehouse'	=> $warehouse,
				'product_id' => $product_id,
				'date'	=> $date
			]);
	}

	public function show($id)
	{
		$data					= App\Module::find($this->module_father);
		$warehouse				= App\Warehouse::find($id);
		if($warehouse != "")
		{
			return view('administration.warehouse.create',
				[
					'id'		=> $data['father'],
					'title'		=> $data['name'],
					'details'	=> $data['details'],
					'child_id'	=> $this->module_father,
					'option_id'	=> $this->module_edit,
					'warehouse'	=> $warehouse,
				]);
		}
		else
		{
			return redirect('/error');
		}
	}

	public function update(Request $request,$id)
	{
		$updateWarehouse = App\Warehouse::where('product_id',$request->product_id)->get();

		$old			= App\Warehouse::find($id);
		$old->date		= $request->date;
		$old->users_id	= Auth::user()->id;
		$old->status	= 0;
		$old->save();

		$warehouse							= new App\Warehouse();
		$warehouse->product_id				= $request->product_id;
		$warehouse->date					= $request->date;
		$warehouse->quantity				= $request->quantity;
		$warehouse->unit					= $request->unit;
		$warehouse->price_purchase			= $request->price_purchase;
		$warehouse->price					= $request->price;
		$warehouse->provider_id				= $request->provider_id;
		$warehouse->quantity_ex				= $request->quantity_ex;
		$warehouse->wholesale_price			= $request->wholesale_price;
		$warehouse->min_wholesale_quantity	= $request->min_wholesale_quantity;
		$warehouse->users_id				= Auth::user()->id;
		$warehouse->status					= 1;
		$warehouse->save();

		$alert = "swal('','Inventario Actualizado Exitosamente','success')";

		return redirect()->route('administration.warehouse.show',$warehouse->id)->with('alert',$alert);
	}

	public function export(Request $request)
	{
		$product_id	= $request->product_id;
		$date		= $request->date;
		$warehouse 	= App\Warehouse::where('status',1)
					->where(function($query) use ($product_id,$date)
					{
						if ($product_id != "") 
						{
							$query->whereIn('product_id',$product_id);
						}
						if ($date != "") 
						{
							$query->where('date',$date);
						}
					})
					->get();

		Excel::create('Inventario', function($excel) use ($product_id,$date,$warehouse)
		{
			$excel->sheet('Lista',function($sheet) use ($product_id,$date,$warehouse)
			{
				$sheet->setStyle([
						'font' => [
							'name'	=> 'Calibri',
							'size'	=> 12
						],
						'alignment' => [
							'vertical' => 'center',
						]
				]);
				$sheet->setColumnFormat(array(
					'D'=> '"$"#,##0.00_-',
					'E'=> '"$"#,##0.00_-',
				));
				$sheet->mergeCells('A1:G1');;

				$sheet->cell('A1:G1', function($cells)
				{
					$cells->setBackground('#000000');
					$cells->setFontColor('#ffffff');
				});
				$sheet->cell('A2:G2', function($cells)
				{
					$cells->setBackground('#1d353d');
					$cells->setFontColor('#ffffff');
				});
				$sheet->cell('A1:G2', function($cells)
				{
					$cells->setFontWeight('bold');
					$cells->setAlignment('center');
					$cells->setFont(array('family' => 'Calibri','size' => '16','bold' => true));
				});
				$sheet->row(1,['Inventario']);
				$sheet->row(2,['ID','Producto','Cantidad en existencia','Precio Normal','Precio Mayoreo','Cant. Mínima para mayoreo','Fecha']);

				$countRow = 3;
				foreach ($warehouse as $w)
				{
					$tempCount	= 0;
					$row	= [];
					$row[]	= $w->id;
					$row[]	= $w->product->description;
					$row[]	= $w->quantity_ex;
					$row[]	= $w->price;
					$row[]	= $w->wholesale_price;
					$row[]	= $w->product->min_wholesale_quantity;
					$row[] 	= $w->date;
					$sheet->appendRow($row);
					$countRow++;
				}
				$sheet->cell('A3:G'.$countRow, function($cells)
				{
					$cells->setFont(array('family' => 'Calibri','size' => '14'));
				});
			});
		})->export('xlsx');
	}

	public function delete($id)
	{

	}
}
