
		<!-- Favicon -->
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.ico')}}">
		
		<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet"> -->
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
		
		<!-- Select2 CSS-->
		<link rel="stylesheet"href="{{asset('public/assets/css/select2.min.css')}}">
		<!-- Lineawesome CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css')}}">

		<!-- Datatable CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/dataTables.bootstrap4.min.css')}}">
		

		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ asset('assets/css/select2.min.css')}}">
		
		<!-- Summernote CSS -->
		<link rel="stylesheet" href="{{ asset('assets/plugins/summernote/dist/summernote-bs4.css')}}">
		<!-- Datetimepicker CSS -->
		<!-- <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datetimepicker.min.css')}}"> -->
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		<!-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet"> -->
		<!-- Bootstrap Datepicker CSS -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">

    </head>
    <body>
		<!-- Loader -->
		<div id="loader-overlay" 
			style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999; text-align:center;">

			<div style="position:absolute; top:50%; left:50%; transform:translate(-50%,-50%);">
				<div class="spinner-border text-primary" role="status" style="width:3rem; height:3rem;">
					<span class="sr-only">Loading...</span>
				</div>
				<p class="mt-2">Please wait...</p>
			</div>
		</div>

		

		<!-- Main Wrapper -->
        <div class="main-wrapper">


            <x-layout.header/>

            <x-layout.sidebar/>

                @yield('content')

            <x-layout.footer />
			

			<!-- jQuery -->
			<script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
			
			<script src="{{ asset('assets/js/jquery.maskedinput.min.js')}}"></script>
			<script src="{{ asset('assets/js/mask.js')}}"></script>
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script> -->
			<!-- Custom JS -->
			<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>
			<script src="{{ asset('assets/js/custom.js')}}"></script>
			<!-- OBE JS -->
			<script src="{{ asset('assets/js/obe.js')}}"></script>
			<!-- App JS -->
			<script src="{{ asset('assets/js/app.js')}}"></script>
			
			<!-- Bootstrap Core JS -->
			<script src="{{ asset('assets/js/popper.min.js')}}"></script>
			<script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
			
			<!-- Slimscroll JS -->
			<script src="{{ asset('assets/js/jquery.slimscroll.min.js')}}"></script>
			
			<!-- Select2 JS -->
			<script src="{{ asset('assets/js/select2.min.js')}}"></script>
			
			<!-- Summernote JS -->
			<script src="{{ asset('assets/plugins/summernote/dist/summernote-bs4.min.js')}}"></script>
			<!-- <script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/jquery.inputmask.bundle.js"></script> -->
			
			<!-- Datatable JS -->
			<script src="{{ asset('assets/js/jquery.dataTables.min.js')}}"></script>
			<script src="{{ asset('assets/js/dataTables.bootstrap4.min.js')}}"></script>
			
			<!-- Datetimepicker JS -->
			<script src="{{ asset('assets/js/moment.min.js')}}"></script>

			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
			<!-- Bootstrap Datepicker JS -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
			
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
			<script>
				function showLoader() {
					document.getElementById("loader-overlay").style.display = "block";
				}

				function hideLoader() {
					document.getElementById("loader-overlay").style.display = "none";
				}

				document.addEventListener("DOMContentLoaded", function () {
					// Attach loader to all nav links
					document.querySelectorAll(".nav-link").forEach(function (link) {
						link.addEventListener("click", function () {
							// Show loader only if link has a real href
							if (this.getAttribute("href") && this.getAttribute("href") !== "#") {
								showLoader();
							}
						});
					});
				});

				// Hide loader when page finishes loading
				window.addEventListener("load", function () {
					hideLoader();
				});

				// function showToast(message, type = 'primary') {
				// 	const toastEl = document.getElementById('liveToast');
				// 	const toastBody = document.getElementById('toastMessage');

				// 	// update message
				// 	toastBody.textContent = message;

				// 	// reset and apply Bootstrap contextual class
				// 	toastEl.className = `toast align-items-center text-bg-${type} border-0`;

				// 	// show toast
				// 	const toast = new bootstrap.Toast(toastEl);
				// 	toast.show();
				// }

			</script>

			

        @yield('script')
    </body>
</html>        