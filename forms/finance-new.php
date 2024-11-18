<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            require_once 'parts-new/header.php'; 
        ?>

        <title> sMedia Form :: Finance </title>
    </head>

    <body>
        <section id="form-section" class="smedia">
            <div class="container">
                <div class="body finance-body">
                    <header>
                        <h6> Your finance is just one step
                            away </h6>
                        <p class="h-margin-10"> *Required Fields </p>
                        <img src="assets-new/images/security-ssl-seal.png" alt="rapidssl logo">
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
                                        <p class="text-danger text-center"> Problem with info! Errors have been highlighted below. * </p>
                                    </div>

                                    <div class="cs-finance-info">
                                        <div class="field">
                                            <div class="control">
                                                <input class="input" type="text" placeholder="First Name" name="first_name" required="required">
                                            </div>
                                        </div>

                                        <div class="field">
                                            <div class="control">
                                                <input class="input" type="text" placeholder="Last Name" name="last_name" required="required">
                                            </div>
                                        </div>

                                        <div class="field">
                                            <div class="control">
                                                <input class="input" type="email" placeholder="Email Address" name="email_address" required="required">
                                            </div>
                                        </div>

                                        <div class="field">
                                            <div class="control">
                                                <input class="input" type="tel" placeholder="Phone Number" name="phone_number" id="phone_number" required="required">
                                            </div>
                                        </div>

                                        <div class="field">
                                            <div class="control">
                                                <input class="input" type="text" placeholder="Address Line 1" name="address_line_1">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col span_1_of_2">
                                    <!-- Col 2 -->
                                    <div class="highlight-inputs">
                                        <h6 class="label"> Date of Birth <span class="text-danger">* </span></h6>

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
                                                        <input class="input" type="text" placeholder="Day" name="dob_day" required="required" data-rule-number="true">
                                                    </div>
                                                </div>

                                                <div class="field">
                                                    <div class="control">
                                                        <input class="input" type="text" placeholder="Year" name="dob_year" required="required" data-rule-number="true">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="security-label text-center">
                                        <img class="h-margin-10" src="assets-new/images/security-green-shield.png" alt="security-green-shield"> 
                                        <span> All of the information above will be submitted securely. </span>
                                    </div>

                                    <button class="button action-btn smedia-button">Apply</button>
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
                        <h2> You’ve started your finance application! </h2>
                        <h6> A sales professional will be in touch with you shortly complete the application. </h6>
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
