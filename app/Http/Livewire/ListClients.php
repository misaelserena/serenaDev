<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use App\Client;

class ListClients extends Component
{
	use WithPagination;

	protected $paginationTheme = 'bootstrap';

	public $name = '';

    public function render()
    {
		$clients 	= Client::where('status',1)->paginate(5);

        return view('livewire.list-clients',compact(['clients',$clients]));
    }

    public function search()
    {
    	$clients 	= Client::where('status',1)->where(DB::raw("CONCAT_WS(' ',name,last_name,scnd_last_name)"),'LIKE','%'.$this->name.'%')->paginate(5);

    	return view('livewire.list-clients',['clients'=>$clients]);
    }
}
