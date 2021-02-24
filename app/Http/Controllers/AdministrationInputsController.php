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
use Carbon\Carbon;


class AdministrationInputsController extends Controller
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
		return view('administration.inputs.create',
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
		$updateInputs = App\Inputs::where('description',$request->description)->get();

		if ($updateInputs != "") 
		{
			foreach ($updateInputs as $update)
			{
				$w				= App\Inputs::find($update->id);
				$w->users_id	= Auth::user()->id;
				$w->status		= 0;
				$w->save();
			}
		}

		$inputs					= new App\Inputs();
		$inputs->description	= $request->description;
		$inputs->date			= $request->date;
		$inputs->quantity		= $request->quantity;
		$inputs->price_purchase	= $request->price_purchase;
		$inputs->total			= $request->total;
		$inputs->provider_id	= $request->provider_id;
		$inputs->users_id		= Auth::user()->id;
		$inputs->status			= 1;
		$inputs->unit 			= $request->unit;
		$inputs->save();

		$alert = "swal('','Inventario Registrado Exitosamente','success')";

		return redirect()->route('administration.inputs.show',$inputs->id)->with('alert',$alert);
	}

	public function getProduct(Request $request)
	{
		if ($request->ajax()) 
		{
			$product 	= App\Products::select('products.price as price','products.wholesale_price as wholesale_price','products.price_purchase as price_purchase')
						->where('status',1)
						->find($request->idproduct);

			if (count($product)>0) 
			{
				return Response($product);
			}
		}
	}

	public function getInputs(Request $request)
	{
		if ($request->ajax()) 
		{
			$inputs = App\Inputs::select('inputs.quantity_ex as quantity_ex','inputs.id as id')
					->where('status',1)
					->where('product_id',$request->idproduct)
					->get();

			if ($inputs != "") 
			{
				return Response($inputs);
			}
		}
	}

	public function edit(Request $request)
	{
		$data			= App\Module::find($this->module_father);
		$description	= $request->description;
		$date			= $request->date;
		$inputs			= App\Inputs::where('status',1)
						->where(function($query) use ($description,$date)
						{
							if ($description != "") 
							{
								$query->whereIn('description',$description);
							}
							if ($date != "") 
							{
								$query->where('date',$date);
							}
						})
						->orderBy('id','desc')
						->paginate(10);
		return view('administration.inputs.search',
			[
				'id'		=> $data['father'],
				'title'		=> $data['name'],
				'details'	=> $data['details'],
				'child_id'	=> $this->module_father,
				'option_id'	=> $this->module_edit,
				'inputs'	=> $inputs,
				'description' => $description,
				'date'	=> $date
			]);
	}

	public function show($id)
	{
		$data					= App\Module::find($this->module_father);
		$inputs				= App\Inputs::find($id);
		if($inputs != "")
		{
			return view('administration.inputs.create',
				[
					'id'		=> $data['father'],
					'title'		=> $data['name'],
					'details'	=> $data['details'],
					'child_id'	=> $this->module_father,
					'option_id'	=> $this->module_edit,
					'inputs'	=> $inputs,
				]);
		}
		else
		{
			return redirect('/error');
		}
	}

	public function update(Request $request,$id)
	{
		$updateInputs = App\Inputs::where('description',$request->description)->get();

		$old			= App\Inputs::find($id);
		$old->date		= $request->date;
		$old->users_id	= Auth::user()->id;
		$old->status	= 0;
		$old->save();

		$inputs					= new App\Inputs();
		$inputs->description	= $request->description;
		$inputs->date			= $request->date;
		$inputs->quantity		= $request->quantity;
		$inputs->price_purchase	= $request->price_purchase;
		$inputs->total			= $request->total;
		$inputs->provider_id	= $request->provider_id;
		$inputs->users_id		= Auth::user()->id;
		$inputs->status			= 1;
		$inputs->unit 			= $request->unit;
		$inputs->save();

		$alert = "swal('','Inventario Actualizado Exitosamente','success')";

		return redirect()->route('administration.inputs.show',$inputs->id)->with('alert',$alert);
	}

	public function export(Request $request)
	{
		$description	= $request->description;
		$date		= $request->date;
		$inputs 	= App\Inputs::where('status',1)
					->where(function($query) use ($description,$date)
					{
						if ($description != "") 
						{
							$query->whereIn('description',$description);
						}
						if ($date != "") 
						{
							$query->where('date',$date);
						}
					})
					->get();

		Excel::create('Inventario', function($excel) use ($description,$date,$inputs)
		{
			$excel->sheet('Lista',function($sheet) use ($description,$date,$inputs)
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
				foreach ($inputs as $w)
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
		$old			= App\Inputs::find($id);
		$old->date		= Carbon::now();
		$old->users_id	= Auth::user()->id;
		$old->status	= 0;
		$old->save();

		$alert = "swal('','Inventario Actualizado Exitosamente','success')";

		return redirect()->route('administration.inputs.edit')->with('alert',$alert);
	}
}
