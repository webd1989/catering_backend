<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Leads extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'lead_code',
        'full_name',
        'mobile',
        'alternate_mobile',
        'email',
        'company_name',
        'source',
        'campaign_name',
        'interested_in',
        'budget',
        'country',
        'state',
        'city',
        'address',
        'lead_status',
        'priority',
        'assigned_to',
        'followup_date',
        'next_followup',
        'remarks',
        'created_by',
        'updated_by','comments'
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
