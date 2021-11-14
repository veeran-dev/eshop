<!DOCTYPE html>
<html>
<head>
	<title>Kobster Perks | buy at low cost</title>
</head>
<body>
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
</body>
</html>