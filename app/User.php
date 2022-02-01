<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPasswordNotification;
use App\Rol_permisos;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_customer',
        'email',
        'password',
        'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendPasswordResetNotification($token)
    {

       
        $this->notify(new CustomResetPasswordNotification($this->email,$token));

        return redirect()->back()-> with('message_reset', 'Correo enviado');
    }


    public function checkPermiso($permiso)
    {
        $res = Rol_permisos::join('permisos','rol_permisos.id_permiso','=','permisos.id_permiso')
        ->where('permisos.permiso',$permiso)
        ->where('rol_permisos.id_rol',$this->id_rol)
        ->count();
        return $res ? true : false ;
      
    }
}
