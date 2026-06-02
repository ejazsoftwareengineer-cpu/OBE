
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Login | OBE</title>
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico')}}">
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
		<style>
		.account-logo img {
			width: 176px !important;
		}
		.account-box {
			border-radius: 40px !important;	
		}
		.account-page .main-wrapper{
			justify-content: space-between !important;
		}
		</style>

    </head>
	
   	
    <body class="account-page" style="background-image: url('{{ asset('assets/img/background-img.jpg') }}'); background-size: cover;">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
			<div class="account-content">
				<div class="container">
					<div class="account-box">
						<!-- Account Logo -->
						<div class="account-logo pt-3">
							<a href="{{ route('home') }}"><img src="{{ asset('assets/img/riphah-logo.png')}}"></a>
						</div>
						<!-- /Account Logo -->
						<div class="account-wrapper">
							<!-- <h3 class="account-title">Login</h3> -->
							
							<!-- Account Form -->
							<form method="POST" action="{{ route('forgetpassword') }}" >
							
                                @csrf
								<div class="form-group">
									<label>Email Address</label>
									<input class="form-control" type="text" name="email" placeholder="Enter your Correct Email ">
                                    <span class="text-danger">{{$errors->first('email')}}</span>
								</div>
								<div class="form-group text-center pt-1">
									<button class="btn btn-primary account-btn" type="submit">Reset Password</button>
								</div>
							</form>
							<!-- /Account Form -->
							
						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ asset('assets/js/popper.min.js')}}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
		
		<script src='https://www.google.com/recaptcha/api.js'></script>
    </body>
</html>
