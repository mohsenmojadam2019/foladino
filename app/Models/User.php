<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','mobile','company_name','national_id','economic_code','default_address','password','role','is_active','last_login_at'];
    protected $hidden = ['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','last_login_at'=>'datetime','password'=>'hashed','is_active'=>'boolean']; }
}
