<?php
namespace App\Models; use Illuminate\Database\Eloquent\Model;
class Company extends Model { protected $guarded=[]; public function projects(){return $this->hasMany(Project::class);} }
