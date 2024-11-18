<!DOCTYPE html>
<html>
<head>
    <?php
    require_once 'parts-new/header.php';
    ?>

    <title> sMedia Form :: Trade In </title>
</head>

<body>
<section id="form-section" class="smedia">
    <div class="container">
        <div class="body trade-in-body">
            <section class="form-container size-eight-hundread-by-six-hundread">
                <form id="salesForm">
                    <input type="hidden" name="act" value="fillup"/>
                    <input type="hidden" name="form" value=""/>

                    <div class="columns_section group">
                        <div class="col span_1_of_2 cs-left-div-image-v2">
                            <div class="cs-security-image-div-trade-in-v2">
                                <img class="cs-security-image-trade-in" src="assets-new/images/security-ssl-seal.png"
                                     alt="rapidssl logo">
                            </div>
                        </div>
                        <button class="form-close-btn" id="form-close-btn"></button>

                        <div class="col span_1_of_2 cs-right-div">
                            <div class="cs-trade-in-right-side">
                                <div class="cs-trade-in-rightside-header-flex">
                                    <h4 style="padding-left: 20px; padding-top: 20px"><strong> Tell us about yourself and your car </strong></h4>
<!--                                    <p style="padding-left: 20px"><strong> Just fill in the brief form below </strong></p>-->
                                </div>

                                <div class="cs-personal-info-div">
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" placeholder="First Name*" name="first_name"
                                                   required="required">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" placeholder="Last Name*" name="last_name"
                                                   required="required">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="email" placeholder="Email Address*"
                                                   name="email_address" required="required">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="tel" placeholder="Phone Number*"
                                                   name="phone_number" id="phone_number" required="required">
                                        </div>
                                    </div>
                                </div>

                                <!-- Col 2 -->
                                <!-- <div class="highlight-inputs">
                                    <h6 class="label"> Vehicle you want to trade in <span class="text-danger">*</span></h6>

                                    <div class="field is-horizontal">
                                        <div class="field-body">
                                            <div class="field">
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="Year" name="car_year">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="Make" name="car_make">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="Model" name="car_model">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <div class="year-make-model">
                                    <p style="color: black; font-size: 13px; padding-left: 10px; padding-bottom: 20px; padding-top: 10px"> What is your vehicle like? </p>

                                    <!-- <div class="field is-horizontal">
                                        <div class="field-body">
                                            <div class="field">
                                                <div class="control">
                                                    <div class="field">
                                                        <div class="control">
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
                                                    <input class="input" type="text" placeholder="Day" name="dob_day" required="required" data-rule-number="true">
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="Year" name="dob_year" required="required" data-rule-number="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="field is-horizontal" name="year_make_model">
                                        <div class="field-body">
                                            <div class="field">
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="Year" name="car_year"
                                                           required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="Make" name="car_make"
                                                           required>
                                                </div>
                                            </div>

                                            <div class="field">
                                                <div class="control">
                                                    <input class="input" type="text" placeholder="Model"
                                                           name="car_model" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="security-label">
                                    <img class="h-margin-10" src="assets-new/images/security-green-shield.png"
                                         alt="security-green-shield">
                                    <p style="color: black"> All information will be submitted securely.</p>
                                </div>

                                <button class="button action-btn smedia-trade-in-v2-button">WE WANT YOUR CAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</section>

<section class="smedia hidden" id="thank-you-section">
    <div class="container">
        <div class="body thank-you-body-wide">
            <section class="thank-you-container text-center">
                <h2> Let’s get you into your new ride! </h2>
                <h6> A sales professional will be in touch with you shortly. </h6>
                <br>
                <h6>Please be sure to check your junk/spam folder if you do not receive a prompt reply</h6>
            </section>
        </div>
    </div>
</section>

<?php
require_once 'parts-new/footer.php';
?>
</body>
</html>
