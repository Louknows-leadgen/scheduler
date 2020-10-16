<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Payroll;

class PayrollController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


	public function upload(Request $request)
	{	
		$payperiods = [
			'2018-10-10',
			'2018-10-25',
			'2018-11-10',
			'2018-11-25',
			'2018-12-10',
			'2018-12-25',
		 ];
		if($request->has('datas')){
			$data = $request->all();
			$datas =  json_decode($data['datas']);
			foreach($datas as $key => $val)
			{
				//return $data;
				unset($payrolldata);
				$payrolldata['payperiod'] = $payperiods[$request->get('payperiod')];
				if($request->has('employee_id')) { $payrolldata['employee_id'] = $val[$request->get('employee_id')]; }
				if($request->has('last_name')) { $payrolldata['last_name'] = $val[$request->get('last_name')]; }
				if($request->has('first_name')) { $payrolldata['first_name'] = $val[$request->get('first_name')]; }
				if($request->has('cost_center')) { $payrolldata['cost_center'] = str_replace(",", "",$val[$request->get('cost_center')]); }
				if($request->has('basic_pay')) { $payrolldata['basic_pay'] = str_replace(",", "",$val[$request->get('basic_pay')]); }
				if($request->has('holiday_pay')) { $payrolldata['holiday_pay'] = str_replace(",", "",$val[$request->get('holiday_pay')]); }
				if($request->has('regular_ot')) { $payrolldata['regular_ot'] = str_replace(",", "",$val[$request->get('regular_ot')]); }
				if($request->has('6th_day_ot')) { $payrolldata['6th_day_ot'] = str_replace(",", "",$val[$request->get('6th_day_ot')]); }
				if($request->has('7th_day_ot')) { $payrolldata['7th_day_ot'] = str_replace(",", "",$val[$request->get('7th_day_ot')]); }
				if($request->has('total_nd')) { $payrolldata['total_nd'] = str_replace(",", "",$val[$request->get('total_nd')]); }
				if($request->has('allowance')) { $payrolldata['allowance'] = str_replace(",", "",$val[$request->get('allowance')]); }
				if($request->has('manual_adjustment')) { $payrolldata['manual_adjustment'] = str_replace(",", "",$val[$request->get('manual_adjustment')]); }
				if($request->has('total_non_tax_allowance')) { $payrolldata['total_non_tax_allowance'] = str_replace(",", "",$val[$request->get('total_non_tax_allowance')]); }
				if($request->has('total_tax_allowance')) { $payrolldata['total_tax_allowance'] = str_replace(",", "",$val[$request->get('total_tax_allowance')]); }
				if($request->has('deductions')) { $payrolldata['deductions'] = str_replace(",", "",$val[$request->get('deductions')]); }
				if($request->has('loan')) { $payrolldata['loan'] = str_replace(",", "",$val[$request->get('loan')]); }
				if($request->has('sss')) { $payrolldata['sss'] = str_replace(",", "",$val[$request->get('sss')]); }
				if($request->has('phic')) { $payrolldata['phic'] = str_replace(",", "",$val[$request->get('phic')]); }
				if($request->has('hdmf')) { $payrolldata['hdmf'] = str_replace(",", "",$val[$request->get('hdmf')]); }
				if($request->has('withhold_tax')) { $payrolldata['withhold_tax'] = str_replace(",", "",$val[$request->get('withhold_tax')]); }
				if($request->has('gross_pay')) { $payrolldata['gross_pay'] = str_replace(",", "",$val[$request->get('gross_pay')]); }
				if($request->has('net_pay')) { $payrolldata['net_pay'] = str_replace(",", "",$val[$request->get('net_pay')]); }
				if($request->has('after_release')) { $payrolldata['after_release'] = str_replace(",", "",$val[$request->get('after_release')]); }								
				if($request->has('disputes')) {$payrolldata['disputes'] = str_replace(",", "",$val[$request->get('disputes')]); }
				if($request->has('incentive')) { $payrolldata['incentive'] = str_replace(",", "",$val[$request->get('incentive')]); }
				if($request->has('taxable_income')) { $payrolldata['taxable_income'] = str_replace(",", "",$val[$request->get('taxable_income')]); }
				$paycreate = Payroll::create($payrolldata);
			}
				$message = 'The Payroll for this period '. $request->get('payperiod'). ' has been uploaded successfully';
				return view('payroll.upload', compact('request', 'message'));

		}
		if($request->hasFile('payroll')){
		  $fileUpload = $request->file('payroll');
		  
		  if(($handle = fopen($fileUpload->getRealPath(),"r")) !== FALSE){
			$fields = fgetcsv($handle, 1000, ",");
			while($data = fgetcsv($handle, 1000, ",")){
				$datas[] = $data;
			}
			$datas = json_encode($datas);
			return view('payroll.processing', compact('request', 'payperiods', 'fields', 'datas'));
		  }
		}
		return view('payroll.upload', compact('request'));
	}

}
