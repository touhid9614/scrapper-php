<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            require_once 'parts-new/header.php'; 
        ?>

        <title> sMedia Form :: Lease </title>
    </head>

    <body>
        <section id="form-section" class="smedia">
            <div class="container">
                <div class="body lease-body">

                    <header>
                        <h6> Your lease is just one step
                            away </h6>
                        <p class="h-margin-10"> *Required Fields </p>
                        <img src="assets-new/images/security-ssl-seal.png">
                        <button class="form-close-btn" id="form-close-btn"></button>
                    </header>

                    <section class="form-container">
                        <form id="salesForm">
                            <input type="hidden" name="act" value="fillup"/>
                            <input type="hidden" name="form" value=""/>

                            <div class="columns_section group">
                                <div class="col span_1_of_2">
                                <!-- Col 1 -->
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
                                            <input class="input" type="text" placeholder="Address Line 1" name="address_line_1">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <h6 class="label"> Vehicle use </h6>

                                        <div class="control">
                                            <label class="radio">
                                                <input type="radio" name="vehicle_use" value="business">
                                                Business
                                            </label>

                                            <label class="radio">
                                                <input type="radio" name="vehicle_use" value="personal">
                                                Personal
                                            </label>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <h6 class="label"> Living - Rent/Own </h6>

                                        <div class="control">
                                            <label class="radio">
                                                <input type="radio" name="living" value="rent">
                                                Rent
                                            </label>

                                            <label class="radio">
                                                <input type="radio" name="living" value="own">
                                                Own
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col span_1_of_2">
                                <!-- Col 2 -->
                                <div>
                                    <div class="field">
                                        <label class="label">Living Here Since</label>

                                        <div class="control">
                                            <div class="select">
                                                <select name="living_since">
                                                    <option value=""> Select Year </option>
                                                    <option value="2018"> 2018 </option>
                                                    <option value="2017"> 2017 </option>
                                                    <option value="2016"> 2016 </option>
                                                    <option value="2015"> 2015 </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="text" placeholder="Mortgage/Rent Payment" name="mortgage_rent_payment" required="required">
                                        </div>
                                    </div>

                                    <div class="field">
                                        <h6 class="label"> Marital Status </h6>
                                            <div class="control">
                                                <label class="radio">
                                                    <input type="radio" name="marital_status" value="single">
                                                    Single
                                                </label>

                                                <label class="radio">
                                                    <input type="radio" name="marital_status" value="married">
                                                    Married
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="security-label text-center">
                                        <img class="h-margin-10" src="assets-new/images/security-green-shield.png">
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
                        <h2> You’ve started your lease application! </h2>
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
