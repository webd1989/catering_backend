<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AnnualMaintenances extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'added_by',
        'title',
        'description',
		'status',
		'customer_id'
    ];

	public function GetRecordById($id){
		return $this::where('id', $id)->first();
	}
	public function UpdateRecord($Details){
		$Record = $this::where('id', $Details['id'])->update($Details);
		return true;
	}
	public function CreateRecord($Details){
		$Record = $this::create($Details);
		return $Record;
	}
}
