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
                            <h3> Special pricing is one step away </h3>
                            <img class="align-right" src="assets-new/images/security-ssl-seal.png" alt="rapid ssl logo">
                        </div>
                        <button class="form-close-btn" id="form-close-btn"></button>
                    </header>

                    <section class="form-container">
                        <form id="salesForm">
                            *Required Fields

                            <br>

                            <input type="hidden" name="act" value="fillup">
                            <input type="hidden" name="form" value="">

                            <div class="alerts hidden">
                                <p class="text-danger text-center"> Problem with info! Errors have been highlighted below. * </p>
                            </div>

                            <br>

                            <div>
                                <div class="field">
                                    <div class="control">
                                        <h4> First Name* </h4>
                                        <input class="input" type="text" placeholder="John" name="first_name" required="required">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <h4> Last Name* </h4>
                                        <input class="input" type="text" placeholder="Doe" name="last_name" required="required">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <h4> Email* </h4>
                                        <input class="input" type="email" placeholder="someone@example.com" name="email_address" required="required">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <h4> Phone* </h4>
                                        <input class="input" type="tel" placeholder="+101234567890" name="phone_number" id="phone_number" required="required">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <h4> Have a question for us? </h4>
                                        <input class="input" type="text" placeholder="Question?" name="questions">
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="control">
                                        <label class="checkbox">
                                            <input type="checkbox" name="no-marketing" value="Yes">
                                            Other than responding to this request, please do not send further marketing communications including offers and information on new products and services, as outlined in our privacy statement.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="security-label text-center">
                                <img class="h-margin-10" src="assets-new/images/security-green-shield.png" alt="security shield">
                                <span> All of the information above will be submitted securely. </span>
                            </div>

                            <button class="button action-btn smedia-form-button"> See Special Pricing </button>
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