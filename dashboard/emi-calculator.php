<?php

require_once 'config.php';
require_once 'includes/loader.php';

session_start();

require_once ADSYNCPATH . 'config.php';
require_once ADSYNCPATH . 'Google/Util.php';
require_once ADSYNCPATH . 'utils.php';
require_once ADSYNCPATH . 'db_connect.php';

include 'bolts/header.php'
?>

<div class="inner-wrapper">
	<?php
	$select = 'emi-calculator';
	include 'bolts/sidebar.php'
	?>

	<section role="main" class="content-body">
		<header class="page-header">

		</header>

		<div class="col-lg-12">
			<section class="panel panel-info">
				<header class="panel-heading">
					<div class="panel-actions">
						<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					</div>
					<h2 class="panel-title"> EMI Calculator </h2>
				</header>

				<div class="panel-body">
					<div class="row form-group-row">
						<div class="col-md-8">
							<form method="POST">
								<div class="form-group">
									<label class="col-sm-4 control-label"> Loan Principal </label>
									<div class="col-sm-6">
										<div class="row mb-lg">
											<div class="col-sm-12">
												<input name="loan_principal" id="loan_principal" class="form-control" type="number" min="0" step="0.01" placeholder="Loan Principal" required/>
											</div>
										</div>
									</div>

									<label class="col-sm-4 control-label"> Yearly Interest Rate(%) </label>
									<div class="col-sm-6">
										<div class="row mb-lg">
											<div class="col-sm-12">
												<input name="interest_rate" id="interest_rate" class="form-control" type="number" min="0" step="0.01" placeholder="Yearly Interest Rate(%)" required/>
											</div>
										</div>
									</div>

									<label class="col-sm-4 control-label"> Number Of Months </label>
									<div class="col-sm-6">
										<div class="row mb-lg">
											<div class="col-sm-12">
												<input name="number_of_months" id="number_of_months" class="form-control" type="number" step="1" min="1" placeholder="Number Of Months" required/>
											</div>
										</div>
									</div>

									<label class="col-md-4 control-label"> EMI Type </label>
									<div class="col-md-6">
										<div class="row mb-lg">
											<div class="col-sm-12">
												<select class="form-control" name="emi_type" id="emi_type" data-plugin-multiselect data-plugin-options='{ "maxHeight": 200 }' required>
													<option value="YEARLY"> YEARLY </option>
													<option value="HALFYEARLY"> HALFYEARLY </option>
													<option value="QUARTERLY"> QUARTERLY </option>
													<option value="TRIMONTHLY"> TRIMONTHLY </option>
													<option value="BIMONTHLY"> BIMONTHLY </option>
													<option value="MONTHLY"> MONTHLY </option>
													<option value="SEMIMONTHLY"> SEMIMONTHLY </option>
													<option value="BIWEEKLY"> BIWEEKLY </option>
													<option value="WEEKLY"> WEEKLY </option>
													<option value="DAILY"> DAILY </option>
												</select>
											</div>
										</div>
									</div>

									<label class="col-sm-4 control-label"> Number of payments <sub>(optional)</sub></label>
									<div class="col-sm-6">
										<div class="row mb-lg">
											<div class="col-sm-12">
												<input name="number_of_payments" id="number_of_payments" class="form-control" type="number" min="0" step="1" placeholder="Number of payments" />
											</div>
										</div>
									</div>

									<label class="col-sm-4 control-label"></label>
									<div class="col-sm-6">
										<div class="row mb-lg">
											<div class="col-sm-12">
												<button class="btn btn-primary ml-md pull-right" type="button" onclick="calculate_emi()"> Calculate EMI </button>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>

				<div class="panel-body">
					<div class="row form-group-row">
						<div class="col-md-8" id="report_div">
							<table class="table table-bordered table-striped">
								<tr>
									<th> EMI Amount </th>
									<td id="show_emi_amount"> </td>
								</tr>
								<tr>
									<th> Number Of Payments </th>
									<td id="show_number_of_payments"> </td>
								</tr>
								<tr>
									<th> Total Interest </th>
									<td id="show_total_interest"> </td>
								</tr>
								<tr>
									<th> Total Payment </th>
									<td id="show_total_payment"> </td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</section>
		</div>
	</section>
</div>

<script type="text/javascript">
	$("#report_div").hide();

	function calculate_emi() {
		const loan_principal = $("#loan_principal").val();
		const yearly_interest_rate = $("#interest_rate").val();
		const number_of_months = $("#number_of_months").val();
		const emi_type = $("#emi_type").val();
		let number_of_payments = $("#number_of_payments").val();
		const time_in_years = parseInt(number_of_months) / 12; // Could be fraction
		const one_year_in_days = 365.25; // Assuming 1 year = 365.25 days

		const period_chart = {
			'DAILY': 1,
			'WEEKLY': 7,
			'BIWEEKLY': 14,
			'SEMIMONTHLY': 15,
			'MONTHLY': one_year_in_days / 12, // Assuming 1 year = 365.25 days
			'BIMONTHLY': one_year_in_days / 6, // Assuming 1 year = 365.25 days
			'TRIMONTHLY': one_year_in_days / 4, // Assuming 1 year = 365.25 days
			'QUARTERLY': one_year_in_days / 3, // Assuming 1 year = 365.25 days
			'HALFYEARLY': one_year_in_days / 2, // Assuming 1 year = 365.25 days
			'YEARLY': one_year_in_days // Assuming 1 year = 365.25 days
		};

		if (!number_of_payments || Number.isInteger(number_of_payments) || number_of_payments <= 1) {
			number_of_payments = Math.round((time_in_years * one_year_in_days / period_chart[emi_type]), 0);
		}

		const number_of_payments_per_year = Math.round(number_of_payments / time_in_years, 0);
		const effective_interest_rate = yearly_interest_rate / (number_of_payments_per_year * 100);
		const complex_factor = Math.pow((1 + effective_interest_rate), number_of_payments);
		const emi_amount = Math.round((loan_principal * effective_interest_rate * complex_factor / (complex_factor - 1)), 2);

		const total_payment = emi_amount * number_of_payments;

		emi_report = {
			'emi': emi_amount,
			'number_of_payments': number_of_payments,
			'total_payment': total_payment,
			'total_interest': total_payment - loan_principal,
			'principal': loan_principal,
			'yearly_interest_rate': yearly_interest_rate + '%'
		};

		show_emi_report(emi_report);
	}

	function show_emi_report(emi_report) {
		$("#report_div").show();
		$("#show_emi_amount").html(emi_report.emi);
		$("#show_number_of_payments").html(emi_report.number_of_payments);
		$("#show_total_payment").html(emi_report.total_payment);
		$("#show_total_interest").html(emi_report.total_interest);
	}
</script>

<?php
include 'bolts/footer.php';