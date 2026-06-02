@extends('layouts.backend.app')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Change Password</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card mb-4 border-0 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center py-3">
                <div>
                    <h6 class="mb-0">{{ $user_detail->name }}</h6>
                    <small class="text-muted">Security Settings</small>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="globalToggleBtn" onclick="toggleAllPasswords()">
                    <i class="fa fa-eye mr-1"></i> <span id="toggleText">Show Passwords</span>
                </button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <div id="status-messages">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fa fa-check-circle mr-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <i class="fa fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show border-0 shadow-sm" role="alert">
                            <ul class="mb-0 px-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('update-password') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">Current Password</label>
                                <input type="password" name="current_password" class="form-control pwd-field" required>
                            </div>

                            <hr>

                            <div class="form-group">
                                <div class="d-flex justify-content-between align-items-end mb-1">
                                    <label class="font-weight-bold mb-0">New Password</label>
                                    <button type="button" onclick="generateAndPopulate()" class="btn btn-link btn-sm p-0 text-decoration-none">Auto-Generate</button>
                                </div>
                                <input type="password" name="new_password" id="main_new_password" class="form-control pwd-field" required>
                                
                                <small class="form-text text-muted" style="font-size: 0.75rem; line-height: 1.2;">
                                    <i class="fa fa-info-circle mr-1"></i>
                                    Password must be <strong>8-12 characters</strong> and include at least one <strong>letter</strong>, one <strong>number</strong>, and one <strong>special character</strong> (e.g., @$!%*#?&).
                                </small>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="main_confirm_password" class="form-control pwd-field" required>
                            </div>

                            <div id="copy-alert" class="alert alert-info mb-3" style="display:none; border-style: dashed !important;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <code id="display-pass" class="h5 mb-0"></code>
                                    <button type="button" class="btn btn-info btn-sm" onclick="copyValue()">Copy</button>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-block py-2">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    // 1. Auto-hide success messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            $('.alert-success').fadeOut('slow');
        }, 5000);
    });

    // 2. Global Toggle Logic
    function toggleAllPasswords() {
        const fields = document.querySelectorAll('.pwd-field');
        const btn = document.getElementById('globalToggleBtn');
        const label = document.getElementById('toggleText');
        const icon = btn.querySelector('i');
        const isHidden = fields[0].type === 'password';

        fields.forEach(field => { field.type = isHidden ? 'text' : 'password'; });

        if (isHidden) {
            label.innerText = 'Hide Passwords';
            icon.className = 'fa fa-eye-slash mr-1';
        } else {
            label.innerText = 'Show Passwords';
            icon.className = 'fa fa-eye mr-1';
        }
    }

    // 3. Updated Password Generator to match specific requirements
    function generateAndPopulate() {
        const letters = "abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ";
        const numbers = "23456789";
        const symbols = "@$!%*#?&";
        
        let password = "";
        // Ensure at least one of each
        password += letters.charAt(Math.floor(Math.random() * letters.length));
        password += numbers.charAt(Math.floor(Math.random() * numbers.length));
        password += symbols.charAt(Math.floor(Math.random() * symbols.length));
        
        // Fill the rest to reach 10 characters
        const all = letters + numbers + symbols;
        for (let i = 0; i < 7; i++) {
            password += all.charAt(Math.floor(Math.random() * all.length));
        }

        // Shuffle the string
        password = password.split('').sort(() => 0.5 - Math.random()).join('');

        document.getElementById('main_new_password').value = password;
        document.getElementById('main_confirm_password').value = password;
        document.getElementById('display-pass').innerText = password;
        document.getElementById('copy-alert').style.display = 'block';

        // Auto-show when generating
        const fields = document.querySelectorAll('.pwd-field');
        fields.forEach(f => f.type = 'text');
        
        // Sync the toggle button text/icon
        document.getElementById('toggleText').innerText = 'Hide Passwords';
        document.getElementById('globalToggleBtn').querySelector('i').className = 'fa fa-eye-slash mr-1';
    }

    function copyValue() {
        const text = document.getElementById('display-pass').innerText;
        navigator.clipboard.writeText(text).then(() => {
            // alert('Copied to clipboard!');
        });
    }
</script>
@endsection