<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'parts-new/header.php';
        ?>
        <title> sMedia Form :: E-Price </title>
    </head>

    <body>
        <section id="form-section" class="smedia">
            <div class="container">
                <div class="body sales-body">

                <header>
                    <div class="cs-header-flex">
                        <div>
                            <h3> Submit this form </h3>
                            <p> to find out more about special pricing </p>
                        </div>

                        <div>
                            <img class="align-right" src="assets-new/images/security-ssl-seal.png" alt="rapid ssl logo">
                        </div>
                        <button class="form-close-btn" id="form-close-btn"></button>
                    </div>
                </header>


                <p class="required-fields"> *Required Fields </p>

                <section class="form-container">
                    <form id="salesForm" name="contactInfo">
                        <input type="hidden" name="act" value="fillup">
                        <input type="hidden" name="form" value="">

                        <div class="alerts hidden">
                            <p class="text-danger text-center"> Incorrect information! Errors have been highlighted below. * </p>
                        </div>

                        <div>
                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="First Name*" name="first_name" required="required">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Last Name*" name="last_name" required="required">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input" type="email" placeholder="Email Address*" name="email_address" required="required">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input" type="tel" placeholder="Phone Number*" name="phone_number" id="phone_number" required="required">
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input class="input" type="text" placeholder="Questions" name="questions">
                                </div>
                            </div>
                        </div>

                        <div class="security-label text-center">
                            <img class="h-margin-10" src="assets-new/images/security-green-shield.png" alt="security shield">
                            <span> All of the information above will be submitted securely. </span>
                        </div>

                        <button class="button action-btn smedia-form-button-v1"> Get Special Pricing </button>
                    </form>
                </section>
              </div>
            </div>
        </section>

        <section class="smedia hidden" id="thank-you-section">
            <div class="container">
                <div class="body thank-you-body">
                    <section class="thank-you-container text-center">
                        <h2> Thank You! </h2>
                        <h6> Please check your email for <br> further information! </h6>
                        <br>
                        <h6>Please be sure to check your junk/spam<br> folder if you do not receive <br>a prompt reply</h6>
                    </section>
                </div>
            </div>
        </section>

        <?php
            require_once 'parts-new/footer.php';
        ?>
    </body>
</html>
