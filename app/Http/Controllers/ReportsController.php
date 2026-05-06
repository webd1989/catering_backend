<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\LogoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Validator;
use Illuminate\Validation\Rule;
use ReallySimpleJWT\Token;
use App\Models\Users;
use App\Models\Responses;
use Session;
use App\Models\TokenHelper;
use App\Models\Invoices;
use App\Models\InvoiceItems;
use App\Models\Customers;
use App\Models\Projects;
use Mpdf\Mpdf;

class ReportsController extends Controller{

	private static $Users;
	private static $TokenHelper;
	private static $Invoices;
	private static $InvoiceItems;
	private static $Customers;
	private static $LogoController;
	private static $Projects;
	
	public function __construct(){
		self::$Users = new Users();
		self::$TokenHelper = new TokenHelper();
		self::$Invoices = new Invoices();
		self::$InvoiceItems = new InvoiceItems();
		self::$Customers = new Customers();
		self::$LogoController = new LogoController();
		self::$Projects = new Projects();
	}
	public function getYearwiseBusiness(Request $request){
		$result = [];
		$result2 = [];
		$result3 = [];
		$counter = 0;
		for($i=2024; $i <= date('Y'); $i++){
			$result[$counter]['label'] = $i;
			$result[$counter]['y'] = self::$Invoices->where('year',$i)->where('currency','INR')->sum('amount');
			
			$result2[$counter]['label'] = $i;
			$result2[$counter]['y'] = self::$Invoices->where('year',$i)->where('currency','$')->sum('amount');
			
			$counter++;
		}
		$counter2 = 0;
		$years = ['4-2025','5-2025','6-2025','7-2025','8-2025','9-2025','10-2025','11-2025','12-2025','1-2026','2-2026','3-2026'];
		foreach($years as $key => $year){
			$explode = explode('-',$year);
			$total = self::$Invoices->where('year',$explode[1])->where('month',$explode[0])->where('status',1)->where('currency','INR')->sum('amount');
			if($total > 0){
				$result3[$counter2]['label'] = $year;
				$result3[$counter2]['y'] = $total;
				$counter2++;
			}
			
		}


		
		return response()->json(['success'=>true,'result'=>$result,'result2'=>$result2,'result3' => $result3],200);
	}
	public function getPaidUnpaid(Request $request){
		$result[0]['y'] = self::$Invoices->where('status',1)->where('currency','INR')->sum('amount');
		$result[0]['name'] = 'Paid Amount';
		
		$result[1]['y'] = self::$Invoices->where('status',2)->where('currency','INR')->sum('amount');
		$result[1]['name'] = 'Pending Amount';
		
		$result2[0]['y'] = self::$Invoices->where('status',1)->where('currency','$')->sum('amount');
		$result2[0]['name'] = 'Paid Amount';
		
		$result2[1]['y'] = self::$Invoices->where('status',2)->where('currency','$')->sum('amount');
		$result2[1]['name'] = 'Pending Amount';
		
		$totalClients = self::$Customers->where('status',1)->count();
		$totalProjects = self::$Projects->where('status',1)->count();
		
		$result3 = [];
		$projects = self::$Projects->groupBy('customer_id')->select('customer_id',DB::raw('count(*) as total'))->where('status',1)->orderBy('total','DESC')->get();
		foreach($projects as $key => $project){
			$clientData = self::$Customers->select('company')->where('id',$project->customer_id)->first();
			$projectCount = self::$Projects->where('customer_id',$project->customer_id)->where('status',1)->count();
			$result3[$key]['client'] = strlen($clientData->company) > 25 ? substr($clientData->company,0,25).'...' : $clientData->company;
			$result3[$key]['client_name'] = $clientData->company;
			$result3[$key]['projects'] = $projectCount;
			$result3[$key]['percentage'] = round(($projectCount/$totalProjects)*100);
			$result3[$key]['style'] = 'width: '.round(($projectCount/$totalProjects)*100).'%;';
			if($key == 3){break;}
		}
		
		return response()->json(['success'=>true,'result'=>$result,'totalClients' => $totalClients,'result2'=>$result2,'totalProjects'=>$totalProjects,'result3'=>$result3],200);
	}
}
