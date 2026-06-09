
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

		{{-- Premium serif/sans pairing — feels like a university brand --}}
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Cormorant+Garamond:wght@500;600;700&display=swap" rel="stylesheet">

		<style>
		/* ============================================================
		   LOGIN — palette extracted from the bookshelf background
		   Cognac / honey / cream / charcoal — with whisper-quiet
		   violet and teal ambient hints from the photo's edge lights.
		   ============================================================ */
		:root {
			/* Ink — warm, not cold */
			--ink:        #1f1611;          /* deep coffee/charcoal */
			--ink-soft:   #3b2a1f;
			--ink-dim:    #6b5a4d;
			--ink-mute:   #9b8676;

			/* Paper / card */
			--paper:      #fbf6ec;          /* cream parchment */
			--paper-warm: #f5ead4;
			--line:       #e6d9c0;          /* aged-paper border */

			/* Brand — cognac + honey gold from book spines */
			--cognac-900: #3e2316;          /* darkest leather */
			--cognac-700: #6b3a1f;
			--cognac-600: #8a4a26;          /* leather binding */
			--cognac-500: #a45a2d;
			--honey-500:  #c98a3c;          /* gilded title text */
			--honey-400:  #e0a85a;
			--honey-300:  #f1c47a;

			/* Edge-light hints (used very sparingly) */
			--violet-glow: rgba(124, 92, 184, 0.30);
			--teal-glow:   rgba(60, 140, 150, 0.25);

			--danger:     #b91c1c;
			--ease:       cubic-bezier(0.22, 1, 0.36, 1);
		}

		/* ──────────────── Background overlay — warms the photo & adds depth ──────────────── */
		body.account-page::before {
			content: "";
			position: fixed; inset: 0;
			z-index: 0;
			pointer-events: none;
			/* Honors the existing background image; tints rather than masks */
			background:
				/* Left violet wash respected (toned down) */
				radial-gradient(45% 55% at 8% 10%, var(--violet-glow) 0%, transparent 60%),
				/* Right teal ambient respected */
				radial-gradient(55% 60% at 95% 80%, var(--teal-glow) 0%, transparent 60%),
				/* Subtle warm centre vignette so the card sits in light */
				radial-gradient(45% 50% at 50% 50%, rgba(255, 220, 170, 0.10) 0%, transparent 60%),
				/* Deep coffee vignette around the edges for focus */
				radial-gradient(120% 80% at 50% 50%, transparent 35%, rgba(20, 12, 6, 0.55) 100%);
		}

		body.account-page .main-wrapper { position: relative; z-index: 1; }
		.account-page .main-wrapper {
			align-items: center !important;
			justify-content: center !important;
			min-height: 100vh;
		}
		.account-page .account-content { width: 100%; }

		/* ──────────────── Card — aged paper / leather-bound book feel ──────────────── */
		.account-page .account-box {
			width: 100%;
			max-width: 460px;
			margin: 0 auto;
			padding: 0 !important;
			/* Cream paper with a hint of warm tint */
			background:
				linear-gradient(180deg, rgba(251, 246, 236, 0.97) 0%, rgba(245, 234, 212, 0.95) 100%) !important;
			backdrop-filter: blur(18px) saturate(120%);
			-webkit-backdrop-filter: blur(18px) saturate(120%);
			border: 1px solid rgba(230, 217, 192, 0.7) !important;
			border-radius: 22px !important;
			overflow: hidden;
			position: relative;
			box-shadow:
				/* Warm ambient drop — coffee tinted */
				0 50px 100px -30px rgba(20, 12, 6, 0.6),
				/* Soft amber glow halo */
				0 25px 50px -20px rgba(138, 74, 38, 0.35),
				/* Paper highlight on top edge */
				inset 0 1px 0 rgba(255, 255, 255, 0.7),
				/* Aged-paper inner border */
				inset 0 0 0 1px rgba(255, 244, 220, 0.4) !important;
			animation: card-rise 600ms var(--ease) both;
			transition: transform 500ms var(--ease), box-shadow 500ms var(--ease);
		}
		.account-page .account-box:hover {
			transform: translateY(-3px);
			box-shadow:
				0 60px 120px -30px rgba(20, 12, 6, 0.65),
				0 30px 60px -20px rgba(138, 74, 38, 0.45),
				inset 0 1px 0 rgba(255, 255, 255, 0.75),
				inset 0 0 0 1px rgba(255, 244, 220, 0.5) !important;
		}
		@keyframes card-rise {
			from { opacity: 0; transform: translateY(24px) scale(0.97); }
			to   { opacity: 1; transform: translateY(0)    scale(1);    }
		}

		/* Top accent — like the gilt edge of a book spine */
		.account-page .account-box::before {
			content: "";
			position: absolute;
			top: 0; left: 0; right: 0;
			height: 4px;
			background: linear-gradient(90deg,
				var(--cognac-900) 0%,
				var(--cognac-600) 30%,
				var(--honey-400) 55%,
				var(--cognac-600) 80%,
				var(--cognac-900) 100%);
			box-shadow: 0 2px 12px -2px rgba(201, 138, 60, 0.55);
		}

		/* Subtle paper grain overlay (mimics aged paper) */
		.account-page .account-box::after {
			content: "";
			position: absolute; inset: 0;
			pointer-events: none;
			background-image:
				radial-gradient(rgba(110, 70, 30, 0.04) 1px, transparent 1.5px),
				radial-gradient(rgba(110, 70, 30, 0.03) 1px, transparent 1.5px);
			background-size: 6px 6px, 10px 10px;
			background-position: 0 0, 3px 4px;
			mix-blend-mode: multiply;
			opacity: 0.6;
		}

		/* Inner content above the grain */
		.account-page .account-logo,
		.account-page .account-wrapper { position: relative; z-index: 1; }

		/* Logo */
		.account-page .account-logo {
			padding: 38px 36px 6px !important;
			text-align: center;
			margin: 0 !important;
		}
		.account-page .account-logo img {
			width: 160px !important;
			height: auto;
			filter: drop-shadow(0 6px 14px rgba(62, 35, 22, 0.22));
			transition: transform 360ms var(--ease);
		}
		.account-page .account-box:hover .account-logo img { transform: scale(1.03); }

		.account-page .account-wrapper {
			padding: 16px 38px 36px !important;
			font-family: 'Inter', system-ui, sans-serif;
		}

		/* ──────────────── Welcome heading — serif for a scholarly feel ──────────────── */
		.welcome {
			text-align: center;
			margin-bottom: 26px;
			position: relative;
		}
		.welcome h2 {
			font-family: 'Cormorant Garamond', Georgia, serif;
			font-weight: 600;
			font-size: 30px;
			color: var(--ink);
			letter-spacing: 0.3px;
			margin: 0 0 4px;
		}
		.welcome p {
			font-family: 'Inter', sans-serif;
			font-size: 13.5px;
			color: var(--ink-dim);
			margin: 0;
		}
		.welcome::after {
			content: "";
			display: block;
			width: 48px; height: 2px;
			margin: 14px auto 0;
			background: linear-gradient(90deg, transparent, var(--honey-500), transparent);
		}

		/* ──────────────── Form fields ──────────────── */
		.account-page .form-group { margin-bottom: 18px; position: relative; }
		.account-page .form-group label {
			display: block;
			font-family: 'Inter', sans-serif;
			font-size: 11.5px;
			font-weight: 600;
			letter-spacing: 0.8px;
			text-transform: uppercase;
			color: var(--ink-soft);
			margin-bottom: 8px;
		}

		/* Input + leading FontAwesome icon via ::before */
		.account-page .form-group.has-icon { position: relative; }
		.account-page .form-group.has-icon .form-control { padding-left: 46px !important; }
		.account-page .form-group.has-icon::before {
			content: "";
			position: absolute;
			left: 18px;
			top: calc(50% + 8px);  /* account for label height above */
			width: 16px; height: 16px;
			font: 14px/1 FontAwesome;
			color: var(--cognac-600);
			pointer-events: none;
			transition: color 200ms var(--ease);
		}
		.account-page .form-group.has-icon.icon-mail::before { content: "\f0e0"; }
		.account-page .form-group.has-icon.icon-lock::before { content: "\f023"; }
		.account-page .form-group.has-icon:focus-within::before { color: var(--cognac-900); }

		.account-page .form-control {
			width: 100% !important;
			padding: 13px 16px !important;
			background: rgba(255, 252, 244, 0.85) !important;
			border: 1.5px solid var(--line) !important;
			border-radius: 11px !important;
			color: var(--ink) !important;
			font-size: 14px !important;
			font-family: 'Inter', sans-serif !important;
			height: auto !important;
			outline: none !important;
			box-shadow:
				inset 0 1px 2px rgba(62, 35, 22, 0.05) !important;
			transition: border-color 200ms var(--ease),
						box-shadow 200ms var(--ease),
						background 200ms var(--ease) !important;
		}
		.account-page .form-control::placeholder { color: #b8a68f; }
		.account-page .form-control:focus {
			border-color: var(--cognac-600) !important;
			background: #fffdf6 !important;
			box-shadow:
				0 0 0 4px rgba(201, 138, 60, 0.18),
				inset 0 1px 2px rgba(62, 35, 22, 0.03) !important;
		}

		/* Forgot link — quiet, scholarly */
		.account-page .form-group .float-right {
			float: none !important;
			display: inline-block;
			margin-top: 8px;
			font-size: 12.5px;
			font-weight: 500;
			color: var(--cognac-700) !important;
			text-decoration: none;
			transition: color 200ms var(--ease);
			border-bottom: 1px dotted transparent;
		}
		.account-page .form-group .float-right:hover {
			color: var(--cognac-900) !important;
			border-bottom-color: var(--cognac-700);
		}

		.account-page .text-danger {
			font-size: 12px !important;
			color: var(--danger) !important;
			font-weight: 500;
			display: block;
			margin-top: 5px;
		}

		/* reCAPTCHA centering */
		.account-page .g-recaptcha {
			display: flex;
			justify-content: center;
			margin: 8px 0 18px;
			transform: scale(0.95);
			transform-origin: center;
		}

		/* ──────────────── Submit Button — leather-bound book look ──────────────── */
		.account-page .account-btn,
		.account-page .btn-primary.account-btn {
			width: 100%;
			padding: 14px 18px !important;
			border: none !important;
			border-radius: 12px !important;
			background:
				linear-gradient(135deg,
					var(--cognac-900) 0%,
					var(--cognac-600) 40%,
					var(--cognac-700) 60%,
					var(--cognac-900) 100%) !important;
			background-size: 220% 100% !important;
			color: #f9eccf !important;        /* gilt text */
			font-family: 'Inter', sans-serif !important;
			font-weight: 600 !important;
			font-size: 14.5px !important;
			letter-spacing: 1.4px !important;
			text-transform: uppercase !important;
			cursor: pointer;
			position: relative;
			overflow: hidden;
			box-shadow:
				0 16px 32px -12px rgba(62, 35, 22, 0.55),
				0 6px 14px -6px rgba(20, 12, 6, 0.4),
				inset 0 1px 0 rgba(255, 220, 170, 0.25),
				inset 0 -1px 0 rgba(20, 12, 6, 0.4) !important;
			transition: transform 240ms var(--ease),
						box-shadow 280ms var(--ease),
						background-position 500ms var(--ease),
						filter 200ms var(--ease) !important;
		}
		/* Gilt shine sweep */
		.account-page .account-btn::after {
			content: "";
			position: absolute; top: 0; left: -30%;
			width: 30%; height: 100%;
			background: linear-gradient(120deg,
				transparent 0%,
				rgba(241, 196, 122, 0.35) 50%,
				transparent 100%);
			transform: skewX(-20deg);
			transition: left 700ms var(--ease);
		}
		.account-page .account-btn:hover {
			transform: translateY(-2px);
			background-position: 100% 0 !important;
			box-shadow:
				0 22px 40px -10px rgba(62, 35, 22, 0.65),
				0 10px 18px -6px rgba(20, 12, 6, 0.5),
				inset 0 1px 0 rgba(255, 220, 170, 0.35),
				inset 0 -1px 0 rgba(20, 12, 6, 0.5) !important;
		}
		.account-page .account-btn:hover::after { left: 130%; }
		.account-page .account-btn:active { transform: translateY(0); }

		/* Foot caption */
		.account-foot {
			margin-top: 18px;
			text-align: center;
			font-family: 'Inter', sans-serif;
			font-size: 11.5px;
			color: var(--ink-dim);
			letter-spacing: 0.5px;
		}
		.account-foot .dot {
			display: inline-block;
			width: 4px; height: 4px;
			border-radius: 50%;
			background: var(--honey-500);
			margin: 0 8px;
			vertical-align: middle;
		}

		/* ──────────────── Soft ambient warm glow behind card (subtle, harmonised) ──────────────── */
		.glow {
			position: fixed;
			pointer-events: none;
			z-index: 0;
			filter: blur(80px);
		}
		.glow-honey {
			width: 480px; height: 480px;
			top: 50%; left: 50%;
			transform: translate(-50%, -50%);
			background: radial-gradient(closest-side, rgba(224, 168, 90, 0.35), transparent);
			opacity: 0.7;
		}

		/* ──────────────── Responsive ──────────────── */
		@media (max-width: 540px) {
			.account-page .account-box { max-width: calc(100% - 32px); border-radius: 18px !important; }
			.account-page .account-logo { padding: 30px 22px 4px !important; }
			.account-page .account-logo img { width: 138px !important; }
			.account-page .account-wrapper { padding: 14px 24px 28px !important; }
			.welcome h2 { font-size: 25px; }
			.glow-honey { width: 320px; height: 320px; opacity: 0.5; }
		}

		@media (prefers-reduced-motion: reduce) {
			.account-page .account-box,
			.account-page .account-btn { animation: none !important; transition: none !important; }
		}
		</style>

    </head>


    <body class="account-page" style="background-image: url('{{ asset('assets/img/background-img.jpg') }}'); background-size: cover;">

		{{-- Warm ambient glow behind card — harmonises with the bookshelf lighting --}}
		<div class="glow glow-honey"></div>

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

							{{-- Welcome heading --}}
							<div class="welcome">
								<h2>Welcome back</h2>
								<p>Sign in to continue to your workspace</p>
							</div>

							<!-- Account Form -->
							<form method="POST" action="{{ route('userlogin') }}" >
							<x-alert></x-alert>
                                @csrf
								<div class="form-group has-icon icon-mail">
									<label>Email Address</label>
									<input class="form-control" type="text" name="email" value="{{ old('email') }}" placeholder="you@riphah.edu.pk">
                                    <span class="text-danger">{{$errors->first('email')}}</span>
								</div>


								<div class="form-group has-icon icon-lock">
									<div class="row">
										<div class="col">
											<label>Password</label>
										</div>
									</div>
									<input class="form-control" type="password" name="password" placeholder="Enter your password" autocomplete="current-password">
									<!-- <span class="text-danger">{{$errors->first('password')}}</span> -->
									<a tabindex="4" href="{{ route('resetpassword') }}" class="float-right text-danger">
										<small>Forgot your password?</small>
									</a>
                                </div>

								@if(config('services.recaptcha.key'))
								    <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}"></div>
								@endif
								<span class="text-danger">{{$errors->first('g-recaptcha-response')}}</span>

								<div class="form-group text-center pt-1">
									<button class="btn btn-primary account-btn" type="submit">Sign in</button>
								</div>
							</form>
							<!-- /Account Form -->

							<div class="account-foot">
								Riphah International University
								<span class="dot"></span>
								Secured Access
							</div>

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
