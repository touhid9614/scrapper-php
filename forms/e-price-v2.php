<!DOCTYPE html>
<html>
    <head>
        <?php 
            require_once 'parts/header.php'; 
        ?>
        <title> sMedia Form :: E-Price </title>
    </head>

    <body>
        <section id="form-section" class="smedia">
            <div class="container">
                <div class="body sales-body">
                    <header>
                        <h6> Contact Info </h6>
                        <p class="h-margin-10"> *Required Fields </p>
                        <img src="assets/images/security-ssl-seal.png">
                        <button class="form-close-btn" id="form-close-btn"></button>
                    </header>

                    <section class="form-container">
                        <form id="salesForm">
                            <input type="hidden" name="act" value="fillup">
                            <input type="hidden" name="form" value="">

                            <div class="alerts hidden">
                                <p class="text-danger text-center"> Problem with info! Errors have been highlighted below. * </p>
                            </div>

                            <div>
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
                                        <input class="input" type="text" placeholder="Questions" name="questions">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="checkbox">
                                            <input type="checkbox" name="no-marketing" value="Yes">
                                            Other than responding to this request, please do not send further marketing communications. including offers and information on new products and services, as outlined in our privacy statement.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="security-label text-center">
                                <img class="h-margin-10" src="assets/images/security-green-shield.png"> 
                                <span> All of the information above will be submitted securely. </span>
                            </div>

                            <button class="button action-btn smedia-button"> Get E-Price </button>
                        </form>
                    </section>
                </div>
            </div>
        </section>

        <section class="smedia" id="thank-you-section">
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

        <style type="text/css">
            #thank-you-section
            {
                display: none;
            }
        </style>

        <?php 
            require_once 'parts/footer.php'; 
        ?>
    </body>
</html>
