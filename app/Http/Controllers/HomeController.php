<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Carbon\Carbon;

class HomeController extends Controller
{
    private $father_module = [
            'sales'     => 1,
            'packs'         => 2,
            'administration'=> 3,
            'reports'       => 4,
            'contacts'      => 5,
            'configuration' => 6
            ];

    public function index()
    {
        return view('home');
    }

    public function administration()
    {
        return $this->parent_module($this->father_module['administration']);
    }

    public function packs()
    {
        return $this->parent_module($this->father_module['packs']);
    }

    public function contacts()
    {
        return $this->parent_module($this->father_module['contacts']);
    }

    public function sales()
    {
        return $this->parent_module($this->father_module['sales']);
    }

    public function reports()
    {
        return $this->parent_module($this->father_module['reports']);
    }

    public function configuration()
    {
        return $this->parent_module($this->father_module['configuration']);
    }

    public function parent_module($id)
    {
        if(Auth::user()->module->where('id',$id)->count()>0)
        {
            $data = App\Module::find($id);
            return view('layouts.parent_module',
                [
                    'id'        =>$data['id'],
                    'title'     =>$data['name'],
                    'details'   =>$data['details']
                ]);
        }
        else
        {
            return redirect('/');
        }
    }
}
