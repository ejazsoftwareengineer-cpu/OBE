        <!-- Header -->
        <div class="header">
			
            <!-- Logo -->
            <div class="header-left">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('assets/img/logo.png')}}" width="200" height="40" alt="">
                </a>
            </div>
            <!-- /Logo -->
            
            <a id="toggle_btn" href="javascript:void(0);">
                <span class="bar-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
            </a>
            <!-- Header Title -->
            <div class="page-title-box">
                <h3>Outcome Based Education</h3>
            </div>
            <!-- /Header Title -->
            
            <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
            
            <!-- Header Menu -->
            <ul class="nav user-menu">
                <!-- Notifications -->
                <li class="nav-item dropdown">
                    <!-- <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i> <span class="badge badge-pill">3</span>
                    </a> -->
                    <!-- <div class="dropdown-menu notifications">
                        <div class="topnav-dropdown-header">
                            <span class="notification-title">Notifications</span>
                            <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                        </div>
                        <div class="noti-content">
                            <ul class="notification-list">
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ asset('assets/img/profiles/avatar-02.jpg')}}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">John Doe</span> added new task <span class="noti-title">Patient appointment booking</span></p>
                                                <p class="noti-time"><span class="notification-time">4 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ asset('assets/img/profiles/avatar-03.jpg')}}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Tarah Shropshire</span> changed the task name <span class="noti-title">Appointment booking with payment gateway</span></p>
                                                <p class="noti-time"><span class="notification-time">6 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ asset('assets/img/profiles/avatar-06.jpg')}}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Misty Tison</span> added <span class="noti-title">Domenic Houston</span> and <span class="noti-title">Claire Mapes</span> to project <span class="noti-title">Doctor available module</span></p>
                                                <p class="noti-time"><span class="notification-time">8 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="assets/img/profiles/avatar-17.jpg">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Rolland Webber</span> completed task <span class="noti-title">Patient and Doctor video conferencing</span></p>
                                                <p class="noti-time"><span class="notification-time">12 mins ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="notification-message">
                                    <a href="activities.html">
                                        <div class="media">
                                            <span class="avatar">
                                                <img alt="" src="{{ asset('assets/img/profiles/avatar-13.jpg')}}">
                                            </span>
                                            <div class="media-body">
                                                <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span> added new task <span class="noti-title">Private chat module</span></p>
                                                <p class="noti-time"><span class="notification-time">2 days ago</span></p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="topnav-dropdown-footer">
                            <a href="activities.html">View all Notifications</a>
                        </div>
                    </div> -->
                </li>
                <!-- /Notifications -->
                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" style="background-color: #654c3f;border: 1px solid #8e6648;" data-toggle="dropdown" href="#" role="button">
                         <span>{{$usersession->title ?? '-Select-'}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <?php foreach($sesssion as $s){?>
                            <a  href="{{route('changesession',$s->id)}}" class="dropdown-item">{{ $s->title ?? '-' }}</a>
                        <?php }?>
                    </div>
                </li>
                <li class="nav-item dropdown has-arrow flag-nav">
                    <a class="nav-link dropdown-toggle" style="background-color: #654c3f;border: 1px solid #8e6648;" data-toggle="dropdown" href="#" role="button">
                        <span>{{ $userRole->name ?? '-Role-' }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                    <?php foreach($roles as $r){?>
                            <a href="{{route('changerole',$r->id)}}" class="dropdown-item">{{ $r->name ?? '-' }}</a>
                        <?php }?>
                    </div>
                </li>
                <li class="nav-item dropdown has-arrow main-drop">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <span class="user-img"><img src="{{ asset('assets/img/profiles/avatar-21.jpg')}}" alt="">
                        <span class="status online"></span></span>
                        <span>{{ Auth::user()->name ?? '' }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('userprofile') }}">My Profile</a>
                        <!-- <a class="dropdown-item"  data-toggle="modal" data-target="#changepassword">Change Password</a> -->
                        <a class="dropdown-item" href="{{ route('userchangepassword') }}">Change Password</a>
                        <!-- <a class="dropdown-item" href="settings.html">Settings</a> -->
                        <a class="dropdown-item" href="{{ url('/logout') }}" href="login.html">Logout</a>
                    </div>
                </li>
            </ul>
            <!-- /Header Menu -->
        </div>
        
            <!-- Delete Leave Modal -->
            <div class="modal custom-modal fade" id="changepassword" role="dialog">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Change Password</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>New Password <span class="text-danger">*</span></label>
                                <input class="form-control" type="password" id="new_password" name="new_password">
                            </div>                                    
                            <div class="form-group">
                                <label>Confirm New Password <span class="text-danger">*</span></label>
                                <input class="form-control" type="password" id="confirm_new_password" name="confirm_new_password">
								<span class="text-danger" id="span_change_password"></span>
                            </div>
                            <div class="submit-section">
                                <button id="change-password-btn" class="btn btn-success" onclick="changePassword('{{route('changepassword')}}','{{ route('indexlogin')}}')">Change</button>
                                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             <!-- /Delete Leave Modal -->
        <!-- /Header -->