<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            require_once 'parts-new/header.php'; 
        ?>

        <title> sMedia Form :: Test Drive </title>
    </head>

    <body>
        <section id="form-section" class="smedia">
            <div class="container">
                <div class="body test-drive-body">
                    <header>
                        <h6> Your test-drive is just one step
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

                                    <div class="cs-test-drive-info">
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
                                                <textarea class="textarea" placeholder="Questions" name="questions"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col span_1_of_2">
                                    <!-- Col 2 -->
                                    <div>
                                        <div class="field">
                                            <div class="control">
                                                <input id="datepickerDemoJQuery" class="input" type="text" placeholder="Request An Appointment" name="appointment_date" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="security-label text-center">
                                        <img class="h-margin-10" src="assets-new/images/security-green-shield.png" alt="security shield logo">
                                        <span>All Information will be submitted securely.</span>
                                    </div>

                                    <button class="button action-btn smedia-button"> Apply </button>
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
                        <h2>Your Test Drive is booked!</h2>
                        <h6>Please check your email for further information!</h6>
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
