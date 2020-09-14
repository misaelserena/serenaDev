<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
   use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';

    protected $fillable = [
        'id','name', 'last_name', 'scnd_last_name', 'gender', 'phone', 'extension', 'email', 'status', 'role_id', 'area_id', 'departament_id', 'position', 'cash', 'cash_amount', 'sys_user', 'active','notification'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /* RELACION INVERSA CON EL MODELO 'Role' */
    public function role()
    {
        return $this->belongsTo('App\Role','role_id','id');
    }

    /* RELACION INVERSA CON EL MODELO 'Area' */
    public function area()
    {
        return $this->belongsTo('App\Area','area_id','id');
    }

    /* RELACION INVERSA CON EL MODELO 'Area' */
    public function departament()
    {
        return $this->belongsTo('App\Departament','departament_id','id');
    }

    /* RELACION CON EL MODELO 'module' */
    public function module()
    {
        return $this->belongsToMany('App\Module','user_has_module','user_id','module_id');
    }

    /* RELACION CON EL MODELO 'enterprise' */
    public function enterprise()
    {
        return $this->belongsToMany('App\Enterprise','user_has_enterprise');
    }
    
    public function employee()
    {
        return $this->hasMany('App\Employee','idUsers','id');
    }

    public function nomAppEmp()
    {
        return $this->belongsTo('App\NominaAppEmp','idUsers','id');
    }
    
    public function loan()
    {
        return $this->belongsTo('App\Loan','idUsers','id');
    }

    public function requestChecked()
    {
        return $this->hasOne('App\RequestModel','idCheck','id');
    }

    /*RELACIÓN CON EL MODELO 'Computer'
    17/05/2018, 21:11*/
    public function computer()
    {
        return $this->hasMany('App\Computer', 'idUsers', 'id');
    }

    /*public function inCharge()
    {
        return $this->belongsToMany('App\Departament','user_has_department');
    }*/

    public function inReview()
    {
        return $this->belongsToMany('App\SectionTickets','user_review_ticket');
    }

    public function inChargeDep($id)
    {
        return $this->belongsToMany('App\Permission_user_dep','user_has_module','user_id','iduser_has_module','id','user_has_module_iduser_has_module')
            ->withPivot('module_id')
            ->where('module_id',$id);
    }

    public function inChargeDepGet()
    {
        return $this->belongsToMany('App\Permission_user_dep','user_has_module','user_id','iduser_has_module','id','user_has_module_iduser_has_module')
            ->withPivot('module_id');
    }

    public function inChargeEnt($id)
    {
        return $this->belongsToMany('App\Permission_user_enterprise','user_has_module','user_id','iduser_has_module','id','user_has_module_iduser_has_module')
            ->withPivot('module_id')
            ->where('module_id',$id);
    }

    public function inChargeEntGet()
    {
        return $this->belongsToMany('App\Permission_user_enterprise','user_has_module','user_id','iduser_has_module','id','user_has_module_iduser_has_module')
            ->withPivot('module_id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordPersonalize($token));
    }

    public function scopeOrderName($query)
    {
            return $query->orderBy('name','asc')->orderBy('last_name','asc')->orderBy('scnd_last_name','asc');
    }

    public function fullName(){
        return $this->name . ' ' . $this->last_name . ' ' . $this->scnd_last_name;
    }
}
