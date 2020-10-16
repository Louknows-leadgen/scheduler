<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model {

	protected $table = 'payrolls';

	protected $fillable = [
		'payperiod', 'employee_id', 'last_name', 'first_name', 'cost_center', 'basic_pay', 'holiday_pay', 'regular_ot', '6th_day_ot', '7th_day_ot', 'total_nd', 'allowance', 'manual_adjustment', 'total_non_tax_allowance', 'total_tax_allowance', 'deductions', 'loan', 'sss', 'phic', 'hdmf', 'employer_ss', 'employer_phic', 'employer_hdmf', 'withhold_tax', 'gross_pay', 'net_pay', 'after_release', 'disputes', 'incentive', 'taxable_income'
	];
}
