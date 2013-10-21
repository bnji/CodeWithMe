<?php
echo isUserLoggedIn();
return;
if(isUserLoggedIn())
{
	#checkSession();
	#redirect('manage');
}
var_dump($GLOBALS['dirCore']);
return;
require_once $GLOBALS['dirCore'].'/view/standard/header.inc.php';
?>
<link href="<?php echo $GLOBALS['urlCore']; ?>/view/standard/css/sign-in.css" rel="stylesheet" />

<div class="container">
	<form class="form-signin" name="sign-in">
		<h1>CodeWithMe</h1>
		<br />
		<h2 class="form-signin-heading">Please sign in</h2>
		<input id="email" type="text" class="form-control" placeholder="Email address" value="hammerbenjamin@gmail.com" autofocus />
		<input id="password" type="password" class="form-control" placeholder="Password" value="1234" />
		<label class="checkbox">
			<input id="rememberMe" type="checkbox"> Remember me
		</label>
		<button id="sign-in" class="btn btn-lg btn-primary btn-block" data-loading-text="Loading..." type="button"></button>
		<br />
		<br />
		<div id="sign-up-result"></div>
		<!--<span class="label label-info">Note: If you don't already have an account, <br />it will be created when you click on 'Sign in'.</span>-->
	</form>
</div> <!-- /container -->

<?php include $GLOBALS['dirCore'].'/view/standard/footer.inc.php'; ?>

<script>
$(function() {

	//alert(storage.get('uid'));

	// Perform authentication
	/*if(CWMCommon.GetIsLoggedIn(function() {
	  window.location = "manage.php";
	}, null));*/

var email = "";

var signInBtnText = "Sign in or Create account";

$("#sign-in").text(signInBtnText);

$("#email, #password").keydown(function(e) {
	if (e.which == 13) {
		SignIn();
		e.preventDefault();
	}
});

$('#sign-in').click(function(e){
	SignIn();
	e.preventDefault();
});

/*$.getJSON('api/solution/22', function(json) {
	console.log(json[1]['Id']);
});*/

function SignIn() {
	var signInBtn = $("#sign-in");
	if(signInBtn.hasClass('disabled'))
	{
		return;
	}

	signInBtn.addClass('disabled').text('Signing in...');

		  //alert(CryptoJS.SHA1($('#password').val()));
		  email = $('#email').val();
		  $.ajax({
		  	type: "POST",
		  	url: "core/controller/login.php",
		  	data: {
		  		'email': email,
			  	'hash': CryptoJS.SHA1($('#password').val()).toString(), // CWMCommon.GetPasswordHashHex($('#password').val()),
			  	'rememberMe': $("#rememberMe:checked").length
			}
		  }).done(function(data) { // data: uid, email, isNew
		  	data = JSON.parse(data);
		  	//alert(data.isNew);
			//alert(uid + "\n" + CWMCommon.SHA1('9'));
			//alert(storage.get('session'));
			CWMCommon.SignIn(data, "manage");
			//alert(JSON.stringify(data, null, 2));
			// Existing or new user
			if(data['uid'] !== null && data['isEmailValid']) {
			  // Existing user which is verified (login)
			  if(!data['isNew'] && data['isVerified']) {
			  	window.location = "manage";
			  }
			  // Existing user which is NOT verified
			  else if(!data['isNew'] && !data['isVerified']) {
			  	signInBtn.removeClass('disabled').text(signInBtnText);
			  	$('#sign-up-result').html('<div class="alert alert-info">You need to activate your account. Please check your email...</div>').hide().slideDown('slow');
			  }
			  // New user and is not verified
			  else if(data['isNew'] && !data['isVerified']) {
			  	signInBtn.removeClass('disabled').text(signInBtnText);
			  	$('#sign-up-result').html('<div class="alert alert-success">Success! An activation link has been sent, which should be arriving any minute! Please check your email...</div>').hide().slideDown('slow');
			  }
			}
			else {
				if(data['isEmailValid']) {
					signInBtn.removeClass('disabled').text(signInBtnText);
					$('#sign-up-result').html('<div class="alert alert-error">Wrong Email or Password! Please try again...</div>').hide().slideDown('slow');
				}
				else {
					signInBtn.removeClass('disabled').text(signInBtnText);
					$('#sign-up-result').html('<div class="alert alert-warning">Please use a valid email address! Please try again...</div>').hide().slideDown('slow');
				}
			}

		}).fail(function(jqXHR, textStatus) {
			alert( "Request failed: " + textStatus );
		});
	}
});
</script>