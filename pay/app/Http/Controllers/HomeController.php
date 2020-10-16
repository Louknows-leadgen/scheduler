<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$payperiods = DB::table('payrolls')
			->select('payrolls.payperiod as value','payrolls.payperiod as label')
			->where('payrolls.payperiod','>=', '2018-07-10')
			->groupBy('payrolls.payperiod')
			->get();
		foreach($payperiods as $payprd){
			$periods[$payprd->value] = $payprd->label;
		}
		
		$payperiods = $periods;
		$data = $request->all();
		
		//* Once Payperiod is selected

		if(!empty($data)){
		$user = DB::table('payrolls')
			->select('payrolls.*','prlemployeemaster.hourlyrate','prlemployeemaster.taxstatusid','prlemployeemaster.employmenttype','prlemployeemaster.position', DB::raw('CONCAT(payrolls.last_name, ", ",payrolls.first_name) as name', 'prlemployeemaster.employeeid as empId'))
			->join('prlemployeemaster','prlemployeemaster.employeeid','=','payrolls.employee_id')
			->where('payrolls.payperiod', $data['payperiod'])
			->where('payrolls.employee_id', Auth::user()->employee_id)
			->first();
		}
		return view('home', compact('data','user','payperiods'));
	}

	public function new_home()
	{
		
		// *Select all pay periods

		$payperiods = DB::table('prlpaysummary')
			->select('*')
			->where('prlpaysummary.payperiod','>=', '2018-07-10')
			->where('prlpaysummary.complete', 'Yes')
			->where('prlpaysummary.employeeid', Auth::user()->employee_id)
			->join('prlemployeemaster','prlemployeemaster.employeeid','=','prlpaysummary.employeeid')
			->orderBy('prlpaysummary.payperiod', 'desc')
			->groupBy('prlpaysummary.payperiod')
			->get();

  		return view('new_home', compact('payperiods'));
	}

	public function payslip(Request $request){

		$data = $request->all();

  		if(!empty($data)){

		$payperiod = date("Y-m-d", strtotime($data['payperiod']));
 
		$pay_info = DB::table('prlpaysummary')
			->select('prlpaysummary.*','prlemployeemaster.hourlyrate','prlemployeemaster.taxstatusid','prlemployeemaster.employmenttype','prlemployeemaster.position',DB::raw('CONCAT(prlemployeemaster.lastname, ", ",prlemployeemaster.firstname) as name, prlpaysummary.6thdayot AS sixthdayOT, 7thdayot AS seventhdayOT'))
			->join('prlemployeemaster','prlemployeemaster.employeeid','=','prlpaysummary.employeeid')
			->where('prlpaysummary.payperiod', $payperiod)
			->where('prlpaysummary.employeeid', Auth::user()->employee_id)
			->first();
  
		}
		
		return view('payslip', compact('data','pay_info'));

	}
 
	public function new_payslip(Request $request){
   	
		$data = $request->all();
 
		$payperiod = date("Y-m-d", strtotime($data['payperiod']));
 
		$pay_info = DB::table('prlpaysummary')
									->select('prlpaysummary.*','prlemployeemaster.hourlyrate','prlemployeemaster.taxstatusid','prlemployeemaster.employmenttype','prlemployeemaster.position',DB::raw('CONCAT(prlemployeemaster.lastname, ", ",prlemployeemaster.firstname) as name, prlpaysummary.6thdayot AS sixthdayOT, 7thdayot AS seventhdayOT'))
									->join('prlemployeemaster','prlemployeemaster.employeeid','=','prlpaysummary.employeeid')
									->where('prlpaysummary.payperiod', $payperiod)
									->where('prlpaysummary.employeeid', Auth::user()->employee_id)
									->first();

		$adjustment_log = DB::table('prladjustmentlog')
								->where('prladjustmentlog.payrollid', $payperiod)
								->where('prladjustmentlog.employeeid', Auth::user()->employee_id)
								->get();
	 	
		return view('new_payslip', compact('data','pay_info', 'adjustment_log'));

 	}

	public function import(Request $request){

		return view('import');

	}
}
