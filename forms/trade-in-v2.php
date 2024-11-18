<!DOCTYPE html>
<html>
    <head>
        <?php require_once 'parts/header.php'; ?>
        <title>sMedia Form :: Trade In v2</title>
    </head>
    <body>
        <section id="form-section" class="smedia">
              <div class="container">
                <div class="body trade-in-body">
                  <header>
                    <h6>Looking to trade-in your vehicle?</h6>
                    <span class="h-margin-10">*Required Fields</span>
                    <img src="assets/images/security-ssl-seal.png">
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
                            <p class="text-danger text-center">Problem with info! Errors have been highlighted below. *</p>
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
                        <textarea class="textarea" placeholder="Questions" name="questions"></textarea>
                      </div>
                    </div>
                          </div>
                          
                          

                        </div>
                        <div class="col span_1_of_2">
                          <!-- Col 2 -->
                         
                  <div class="field">
                    <div class="control">
                      <label class="checkbox">
                          <input type="checkbox" name="considering-tradein" value="Yes">
                        I am considering trading in my current vehicle
                      </label>
                    </div>
                  </div>

                  <div class="field">
                    <div class="control">
                      <label class="checkbox">
                          <input type="checkbox" name="qualify-gm-pricing" value="Yes">
                        I may qualify for GM Preferred Pricing
                      </label>
                    </div>
                  </div>

                  <hr>

                          <div class="security-label text-center">
                            <img class="h-margin-10" src="assets/images/security-green-shield.png"> <span>All Information will be submitted securely.</span>
                          </div>

                          <button class="button action-btn smedia-button">Submit</button>

                        </div>
                      </div>
                    </form>
                  </section>
                </div>
              </div>
            </section>
        <section class="smedia" id="thank-you-section" style="display: none;">
            <div class="container">
              <div class="body thank-you-body-wide">
                <section class="thank-you-container text-center">
                    <h2>Let’s get you into your new ride!</h2>
                    <h6>A sales professional will be in touch with you shortly.</h6>
                    <br>
                    <h6>Please be sure to check your junk/spam folder if you do not receive a prompt reply</h6>
                </section>
              </div>
            </div>
        </section>
        <?php require_once 'parts/footer.php'; ?>
    </body>
</html>
