<!DOCTYPE html>
<html>
<head>
	<?php require_once 'parts/header.php'; ?>
	<title>sMedia Form :: Finance</title>
</head>
<body>
<section id="form-section" class="smedia">
	<div class="container">
		<div class="body finance-body">
			<header>
				<h6>Contact Info</h6>
				<p class="h-margin-10">*Required Fields</p>
				<img src="assets/images/security-ssl-seal.png">
				<button class="form-close-btn" id="form-close-btn"></button>
			</header>
			<section class="form-container">
				<form id="financesForm">
					<input type="hidden" name="act" value="fillup"/>
					<input type="hidden" name="form" value=""/>
					<div class="columns_section group">
						<div class="col span_1_of_2">
							<!-- Col 1 -->

							<div class="alerts hidden">
								<p class="text-danger text-center">Problem with info! Errors have been highlighted
									below. *</p>
							</div>

							<div>
								<div class="field">
									<div class="control">
										<input class="input" type="text" placeholder="First Name" name="first_name"
											   required="required">
									</div>
								</div>

								<div class="field">
									<div class="control">
										<input class="input" type="text" placeholder="Last Name" name="last_name"
											   required="required">
									</div>
								</div>

								<div class="field">
									<div class="control">
										<input class="input" type="email" placeholder="Email Address"
											   name="email_address" required="required">
									</div>
								</div>

								<div class="field">
									<div class="control">
										<input class="input" type="tel" placeholder="Phone Number" name="phone_number"
											   id="phone_number" required="required">
									</div>
								</div>

								<div class="field">
									<div class="control">
										<input class="input" type="text" placeholder="Address Line 1"
											   name="address_line_1">
									</div>
								</div>
							</div>

						</div>
						<div class="col span_1_of_2">
							<!-- Col 2 -->

							<div class="highlight-inputs">
								<h6 class="label">Date of Birth</span> <span class="text-danger">*</h6>

								<div class="field is-horizontal">
									<div class="field-body">
										<div class="field">
											<div class="control">
												<div class="field">
													<div class="control">
														<!-- <label class="label"></label> -->
														<div class="select" required="required">
															<select name="dob_month" required="required">
																<option value="">Month</option>
																<option value="01">January</option>
																<option value="02">February</option>
																<option value="03">March</option>
																<option value="04">April</option>
																<option value="05">May</option>
																<option value="06">June</option>
																<option value="07">July</option>
																<option value="08">August</option>
																<option value="09">September</option>
																<option value="10">October</option>
																<option value="11">November</option>
																<option value="12">December</option>
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="field">
											<div class="control">
												<input class="input" type="text" placeholder="Day" name="dob_day"
													   required="required" data-rule-number="true">
											</div>
										</div>
										<div class="field">
											<div class="control">
												<input class="input" type="text" placeholder="Year" name="dob_year"
													   required="required" data-rule-number="true">
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="security-label text-center">
								<img class="h-margin-10" src="assets/images/security-green-shield.png"> <span>All Information will be submitted securely.</span>
							</div>

							<button class="button action-btn smedia-button">Apply</button>

						</div>
					</div>
				</form>
			</section>
		</div>
	</div>
</section>
<section class="smedia" id="thank-you-section" style="display: none;">
	<div class="container">
		<div class="body thank-you-body">
			<section class="thank-you-container text-center">
				<h2>Thank you for your submission</h2>
				<h6>A member of our team will be in touch shortly.</h6>
			</section>
		</div>
	</div>
</section>
<?php require_once 'parts/footer.php'; ?>
</body>
</html>