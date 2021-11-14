<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kobster Elite, A new age procurement tool that streamlines procurement in bulk for Corporates, SMEs etc">
    <link rel="shortcut icon" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}favicon.ico">
    <title>Login | Kobster Elite</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,600' rel='stylesheet' type='text/css'>
    <link href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}dash/login.css" rel="stylesheet">
    <script type="text/javascript">
        window.onload = function(e){
            var url = window.location.href.split("#"); 
            if(url[1] != undefined){
                window.goTo = "#"+url[1];
                document.getElementById("gotoPageAfterLogin").value = window.goTo;
            }
        }
    </script>
    <script type="text/javascript" src="dash/js/dash-login.js"></script>
    <style>
        #load_gif, #loading{
            display: none;
        }
        #reg_load{
            display: none;
            justify-content: center;
            align-items: center;
            position: fixed;
            left: 0;
            right: 0;
            top: 0;
            bottom: 0;
            flex-direction: column;
            z-index: 6000;
        }
    </style>
</head>

<body>
    <header class="navbar navbar-fixed-top padding10 business-fixed-header">
        <a class="logo" href="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}dash-index.php">
            <img src="{if isset($force_ssl) && $force_ssl}{$base_dir_ssl}{else}{$base_dir}{/if}dash/img/kobster-elite-logo.svg" alt="Kobster Elite"/>
        </a>
        <div class="conatct-info">
            <p><button class="request-demo-button" id="request-demo-button-id">Sign Up</button></p>
        </div>
    </header>
    <div class="container">
        <div class="content-wrapper">
            <div id="reg_load">
                <img src="dash/images/bx_loader.gif" alt="loading">
            </div>
            <div class="welcome">
                <h1>NEW & BETTER!</h1>
                <p>The Tool that Transformed Your Life, Now Transformed for Better!</p>
            </div>
            <form id="dash_login_form" class="login-form" method="POST" action="{$link->getPageLink('dash-login.php')}">
                {if isset($login_error) == 1}<p class="errors">The Email or Password you entered is incorrect, please try again.</p>{/if}
                <div class="form-group-wrapper">
                    <span class="validation-errors" id="error-email"></span>
                    <div class="form-group">
                        <span class="icon email"></span>
                        <input autofocus type="email" id="login_email" placeholder="E-mail ID" name="login_email" value="{if isset($email)}{$email|escape:'htmlall':'UTF-8'|stripslashes}{/if}" class="form-control" required/>
                    </div>
                    <span class="validation-errors" id="error-password"></span>
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input type="password" name="login_passwd" id="login_passwd" value="" class="form-control" placeholder="Password" required/>
                    </div>
                    <div class="form-group">
                        <button type="submit" onclick="submitCredential(event);" id="SubmitDashLogin" name="SubmitDashLogin" class="login-button">Login</button>
                        <a class="forget-password" href="#" id="modalLink">Forgot Password?</a>
                    </div>
                    <input type="hidden" name="gotoPageAfterLogin" id="gotoPageAfterLogin" value="" />
                </div>
            </form>
            <form id="dash_register_form" class="register-form" method="POST" onsubmit="submitRegister(event)">
                <div class="form-group"> 
                    <h3>Basic Details</h3>
                </div>
                {if isset($register_error) == 1}<p class="errors">The Email or Password you entered is incorrect, please try again.</p>{/if}
                <div class="form-group-wrapper row">
                    <div class="form-group">
                        <span class="icon email"></span>
                        <input autofocus type="text" id="corporate_name" placeholder="Corporate Name" name="corporate_name" class="form-control" />
                        <span class="validation-errors" id="error_corporate_name"></span>
                    </div>
                    
                    <div class="form-group">
                        <span class="icon email"></span>
                        <input type="text" name="corporate_email" id="corporate_email" class="form-control" placeholder="Corporate Email" />
                        <span class="validation-errors" id="error_corporate_email"></span>
                    </div>
                </div>
                <div class="form-group-wrapper row">
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input autofocus type="password" id="corporate_pwd" placeholder="Password" name="corporate_pwd" class="form-control" />
                        <span class="validation-errors" id="error_corporate_pwd"></span>
                    </div>
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input autofocus type="password" name="corporate_pwd_cnfm" id="corporate_pwd_cnfm" class="form-control" placeholder="Confirm Password" />
                        <span class="validation-errors" id="error_corporate_pwd_cnfm"></span>
                    </div>
                </div>
                <div class="form-group"> 
                    <h3>Address Details</h3>
                </div>
                <div class="form-group-wrapper">
                    <div class="form-group">
                        <span class="icon email"></span>
                        <textarea rows="4" cols="50" autofocus id="corporate_address" placeholder="Corporate Address" name="corporate_address" class="form-control" /></textarea>
                        <span class="validation-errors" id="error_corporate_address"></span>
                    </div>
                </div>
                <div class="form-control">
                    <input type="checkbox" name="corporate_sez" id="corporate_sez" value="1">
                    <label for="corporate_sez">Is this SEZ Zone ?</label>
                </div>
                <div class="form-group-wrapper row">
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input autofocus type="text" id="corporate_mobile" placeholder="Mobile" name="corporate_mobile" class="form-control" />
                        <span class="validation-errors" id="error_corporate_mobile"></span>
                    </div>
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input type="text" name="corporate_city" id="corporate_city" class="form-control" placeholder="City" />
                        <span class="validation-errors" id="error_corporate_city"></span>
                    </div>
                </div>
                <div class="form-group-wrapper row">
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <select autofocus id="corporate_state" name="corporate_state" class="form-control" >
                            <option value="0">States</option>
                            <option value=313>Andhra Pradesh</option>
                            <option value=314>Arunachal Pradesh</option>
                            <option value=315>Assam</option>
                            <option value=316>Bihar</option>
                            <option value=317>Chhattisgarh</option>
                            <option value=318>Goa</option>
                            <option value=319>Gujarat</option>
                            <option value=320>Haryana</option>
                            <option value=321>Himachal Pradesh</option>
                            <option value=322>Jammu and Kashmir</option>
                            <option value=323>Jharkhand</option>
                            <option value=324>Karnataka</option>
                            <option value=325>Kerala</option>
                            <option value=326>Madhya Pradesh</option>
                            <option value=327>Maharashtra</option>
                            <option value=328>Manipur</option>
                            <option value=329>Meghalaya</option>
                            <option value=330>Mizoram</option>
                            <option value=331>Nagaland</option>
                            <option value=332>Orissa</option>
                            <option value=333>Punjab</option>
                            <option value=334>Rajasthan</option>
                            <option value=335>Sikkim</option>
                            <option value=336>Tamil Nadu</option>
                            <option value=337>Tripura</option>
                            <option value=338>Uttaranchal</option>
                            <option value=339>Uttar Pradesh</option>
                            <option value=340>West Bengal</option>
                            <option value=341>Andaman and Nicobar Islands</option>
                            <option value=342>Chandigarh</option>
                            <option value=343>Dadra and Nagar Haveli</option>
                            <option value=344>Daman and Diu</option>
                            <option value=345>Delhi</option>
                            <option value=346>Lakshadweep</option>
                            <option value=347>Pondicherry</option>
                            <option value=348>Telangana</option>
                            <option value=349>uttarakhand</option>
                        </select>
                        <span class="validation-errors" id="error_corporate_state"></span>
                    </div>
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <select autofocus id="corporate_country" name="corporate_country" class="form-control" disabled>
                            <option value="110">India</option>
                        </select>
                        <span class="validation-errors" id="error_corporate_country"></span>
                    </div>
                </div>
                <div class="form-group-wrapper row">
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input autofocus type="text" id="corporate_pincode" placeholder="Pincode" name="corporate_pincode" class="form-control"/>
                        <span class="validation-errors" id="error_corporate_pincode"></span>
                    </div>
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input type="text" name="corporate_gst" id="corporate_gst" class="form-control" placeholder="GST" />
                        <span class="validation-errors" id="error_corporate_gst"></span>
                    </div>
                </div>
                <div class="form-group-wrapper"> 
                    <h3>Contact Details</h3>
                </div>
                <div class="form-group-wrapper row">
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input autofocus type="text" id="corporate_contact_name" placeholder="Contact Person Name" name="corporate_contact_name" class="form-control" />
                        <span class="validation-errors" id="error_corporate_contact_name"></span>
                    </div>
                    <div class="form-group">
                        <span class="icon lock"></span>
                        <input type="text" name="corporate_contact_mobile" id="corporate_contact_mobile" class="form-control" placeholder="Mobile" />
                        <span class="validation-errors" id="error_corporate_contact_mobile"></span>
                    </div>
                </div>
                <div class="form-group-wrapper">
                    <div class="form-group">
                        <button onclick="submitRegister(event);" id="SubmitDashRegisters" name="SubmitDashRegisters" class="login-button">Register</button>
                    </div>
                    <input type="hidden" name="SubmitDashRegister" id="SubmitDashRegister" value="1" />
                </div>
            </form>
        </div>

        <div role="dialog" tabindex="-1" id="forgetPasswordModal" class="modal" style="display: none">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Forgot Password ?</h4>
                        <button type="button" id="closeButton" class="close-button" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="dash-login.php" method="post" id="forgot_password" onsubmit="forgotPassword(event)">
                            <p id="resetHint">Enter your E-mail Address below to reset your password.</p>
                            <span class="validation-errors" id="error_span"></span>
                            <div class="form-group" id="forgetPwdForm">
                                <span class="icon email"></span>
                                <input type="text" id="email" name="email" placeholder="Email Address" autocomplete="off" class="form-control placeholder-no-fix">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <img id="load_gif" src="/dash/images/bx_loader.gif" />
                        <button type="button" id="dash-forgot-pwd" onclick="forgotPassword(event)" name="dash-forgot-pwd" class="button-success">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <div role="dialog" tabindex="-1" id="forgetPasswordResponseModal" class="modal" style="display: none">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Forgot Password ?</h4>
                        <button type="button" id="ResponsecloseButton" class="close-button" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form >
                            <span class="validation-errors" id="error_span">A link to reset your password has been sent to your email. Kindly follow the instructions given in the mail. Thank you.</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
<script>

var modal = document.getElementById('forgetPasswordModal');
var modalResponse = document.getElementById('forgetPasswordResponseModal');
var modalLink = document.getElementById("modalLink");
var startButton = document.getElementById('getStarted');
var closeButton = document.getElementById("closeButton");
var responseCloseButton = document.getElementById("ResponsecloseButton");
var intro = document.getElementById("introContent");
var toggleForm = document.getElementById("request-demo-button-id");
var loginForm = document.getElementById("dash_login_form");
var registerForm = document.getElementById("dash_register_form");   
// When the user clicks the link, open the modal
modalLink.onclick = function(e) {
    e.preventDefault();
    modal.style.display = "flex";
    document.getElementById("dash-forgot-pwd").style.display = "inline";
    document.getElementById("resetHint").style.display = "block";
    document.getElementById("error_span").innerHTML = "";
    document.getElementById("email").value = ""
}

toggleForm.onclick = function(e){
    console.log("toggle link");
    console.log(toggleForm.innerHTML);
    var login = toggleForm.innerHTML == "Sign Up" ? true:false;
    if(login){
        toggleForm.innerHTML = "Login";
        loginForm.style.display = "none";
        registerForm.style.display = "block";
    }else{
        toggleForm.innerHTML = "Sign Up";
        loginForm.style.display = "block";
        registerForm.style.display = "none";
    }
    
}

// When the user clicks on close button, close the modal
closeButton.onclick = function() {
    modal.style.display = "none";
}
responseCloseButton.onclick = function() {
    modalResponse.style.display = "none";
}


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>

</html>