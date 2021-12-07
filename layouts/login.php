<section class="container">
    <div class="row header">
        <div class="col-12">
            <div class="row">
                <div class="col-12">
                    <figure class="iconotipo text-center">
                        <img src="https://thankyoutipper.com/wp-content/uploads/2021/08/newIsotipo.svg" alt="Logo ThankYou Tipper">
                    </figure>
                </div>
            </div>
            <div class="row welcome">
                <div class="col-6">
                    <p class="text-end text-white">Welcome to</p>
                </div>
                <div class="col-6">
                    <figure class="logo text-start">
                        <img src="https://thankyoutipper.com/wp-content/uploads/2021/08/newLogo-W.svg" alt="Logo ThankYou Tipper">
                    </figure>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5 login">
        <div class="col-12 text-center">
            <label for="tel--login" class="form-label">Login with your phone number:</label>
            <input type="tel" id="tel--login" class="form-control text-center">
        </div>
        <div class="col-12 mt-3 text-center">
            <input class="form-check-input" type="radio" name="acept--terms" id="acept--terms">
            <label class="form-check-label" for="acept--terms">Accept <a href="http://">terms and conditions</a></label>
        </div>
        <div class="col-12 d-grid mt-5">
            <button type="button" id="btn--generateCode" class="btn btn-primary">Sign in</button>
        </div>
    </div>

    <div class="row mt-5 check-code hide">
        <div class="col-12 text-center">
            <label for="tel--login" class="form-label">Enter the code that we have sent to the number: <span class="number"></span></label>
            <input type="number" id="check--code" class="form-control text-center">
        </div>
        <div class="col-12 text-center">
            <p class="code"></p>
        </div>
        <div class="col-12 d-grid mt-5">
            <button type="button" id="btn--checkCode" class="btn btn-primary">Check code</button>
        </div>
    </div>
</section>