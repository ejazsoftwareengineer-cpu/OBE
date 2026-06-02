<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\UserMail;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sesssion;
use App\Models\Role;
use App\Models\EnrollStudent;
use App\Models\CourseOffer;
use App\Models\ClassActivity;
use App\Models\ActivityQuestion;
use App\Models\StudentAssessment;
use App\Models\CourseOfferPlo;
use App\Models\CourseOfferClo;
use App\Traits\TraitFunctions;
use Illuminate\Support\Str;
use App\Mail\ForgotPassword;

class HomeController extends Controller
{
    
    use TraitFunctions;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.userlogin');
    } 

    public function resetPassword()
    {
        return view('auth.forgotpassword');
    } 

     public function auto_login(Request $request)
    {
        $token = $request->query('token');
 
        if (!$token) {
           return redirect('/'); 
        }
 
        // Decode the base64 token safely
        $decoded = base64_decode($token, true);
        if ($decoded === false) {
           return redirect('/'); 
        }
 
        // Split token into parts
        $parts = explode('|', $decoded);
        if (count($parts) !== 3) {
           return redirect('/'); 
        }
 
        [$email, $expires, $signature] = $parts;
        $secret = 'Y2RrQW5qN2xFbUpvQ1dZd0tNSmZrU0ZGcGJ2cGdHdXY=';
 
        // Check expiry
        if ($expires < time()) {
            return redirect()->route('logoutuser'); 
        }
 
        // Verify HMAC signature
        $expected = hash_hmac('sha256', $email . '|' . $expires, $secret);
        if (!hash_equals($expected, $signature)) {
            return redirect()->route('logoutuser'); 
        }
 
        // Lookup user in database
        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('logoutuser'); 
        }
 
        // Log the user in
        Auth::login($user);
 
        // Redirect after login
        // if (session('header') == 1) {
        //     return redirect()->to('/dashboard');
        // } else {
        //     return redirect()->to('/pms-dashboard');
        // }
        if(Auth::check()){
            $role_id = Auth::user()->role_id;
            $roles = json_decode($role_id,true);
            if(is_array($roles)){
                $role = Role::select('id')->find($roles[0]);
                session(['role_key' => $role->id]);
                
                $session_id = Auth::user()->session_id;
                if($session_id){
                    $sesssion = Sesssion::select('id','title')->wherestatus('1')->first();
                    session(['session_key' => $sesssion->id]);
                }else{
                    session(['session_key' => $session_id]);
                }
            }
            return redirect()->route('home');
        }else{
            return redirect()->route('logoutuser'); 
        }
    }
 
    public function home()
    {
set_time_limit(300); // Sets limit to 5 minutes

        if(Auth::check()){
            $userRole;
            if(session()->has('role_key')) {
                $roleId = session('role_key');
                $userRole = Role::whereid($roleId)->first();
            }
            $user = Auth::user();
            // $roleId = session('role_key');
            $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
            // echo "<pre>";
            // print_r($hasFunctionalityPermission);
            // print_r($user->session_id);
            // die();
            $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
            if($flag === 'all'){
                $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$user->session_id)->latest()->get();
            }elseif($flag === 'institute'){
                $courseoffer_ids = $hasFunctionalityPermission['courseoffer_id'];
                $data =  (!empty($courseoffer_ids)) ? CourseOffer::with(['institute', 'course','teacher'])
                ->where('active_session_id',$user->session_id)
                ->whereIn('id', $courseoffer_ids)->latest()->get() :  null; 
                
                
            }elseif($flag === 'program'){
                $courseoffer_ids = $hasFunctionalityPermission['courseoffer_id'];
                $data =  (!empty($courseoffer_ids)) ? CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$user->session_id)->whereIn('id', $courseoffer_ids)->latest()->get() :  null; 
            }elseif($flag === 'reports_dashboard'){
                $data =  [];
            }elseif($flag === 'enrolled_course'){
                // $courseoffer_ids = $hasFunctionalityPermission['courseoffer_id'];
                // $data = (!empty($courseoffer_ids)) ?  CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$user->session_id)->whereIn('id', $courseoffer_ids)->latest()->get() : CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id', $user->session_id)->where('teacher_id', $user->id)->latest()->get(); 
                $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id', $user->session_id)->where('teacher_id', $user->id)->latest()->get(); 
                // echo "<pre>";
                // print_r($courseoffer_ids);
                // die();
                // $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$user->session_id)->where('teacher_id', $user->id)->latest()->get(); 
                
            }elseif($flag === 'courseoffering_enrollment'){
                $data =  [];
            }else{
                
                $data = CourseOffer::with(['institute', 'course','teacher'])->where('active_session_id',$user->session_id)->where('teacher_id', $user->id)->latest()->get();
                // $data =  [];
            }
            //    echo "<pre>";
            // print_r($data);
            // die();
            $enrolled_student = new EnrollStudent();
            $clo = new CourseOfferClo();
            $plo = new CourseOfferPlo();
            $activity = new ClassActivity();
            // $ques_activity = new ActivityQuestion();
            // $enrollstudent = new EnrollStudent();
            // $studentassessment = new StudentAssessment();


            return view('dashboard.dashboard-backup',compact('userRole','data','enrolled_student','plo','clo','activity' ));
        }
    }

    public function changerole($role_id)
    {
        session()->forget('role_key');
        session(['role_key' => $role_id]);
        return redirect()->route('home');
    }
    
    public function changesession($session_id)
    {
        session()->forget('session_key');
        session(['session_key' => $session_id]);
        $update = [
            'session_id' => $session_id
        ];
        $user = User::whereid(Auth::user()->id)->update($update);
        return redirect()->route('home');
    }

    public function userLogin(Request $request){


       
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            // 'g-recaptcha-response' => 'required|recaptcha',
        ],[
            'password.required' => 'Password is required',
            'email.required' => 'Valid and Unique Email is required',
            // 'g-recaptcha-response.required' => 'Recaptcha is required',
        ]);
 
        $request->only('email','password');
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            if(Auth::check()){
        $user = Auth::user();
 
    // update activity time
    $user->last_active_at = now();

    // update session id
    $user->login_session_id = session()->getId();

    $user->save();

                $role_id = Auth::user()->role_id;
                $roles = json_decode($role_id,true);
                if(is_array($roles)){
                    $role = Role::select('id')->find($roles[0]);
                    session(['role_key' => $role->id]);
                    
                    $session_id = Auth::user()->session_id;
                    if($session_id){
                        $sesssion = Sesssion::select('id','title')->wherestatus('1')->first();
                        session(['session_key' => $sesssion->id]);
                    }else{
                        session(['session_key' => $session_id]);
                    }
                }
                return redirect()->route('home');
            }else{
                return redirect()->route('logoutuser'); 
            }
        }else{
            return redirect()->route('logoutuser'); 
        }
    }


    public function logoutUser(Request $request) 
    {

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function changePassword(Request $request){
        $update_data = array(
            'password' => Hash::make($request->new_password),
        );
        User::whereid(Auth::user()->id)->update($update_data);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }


    public function forgetPassword(Request $request)
    {
        // Validate email input
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.exists' => 'Email not found. Please contact your coordinator.',
        ]);

        // Find the user
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate random password
            $password = Str::random(8);
            $hashed_random_password = Hash::make($password);

            // Update user password
            $user->update([
                'password' => $hashed_random_password
            ]);

            // Prepare mail data
            $mailData = [
                'email' => $user->email,
                'password' => $password,
            ];

            // Send mail
            Mail::to($user->email)->send(new UserMail($mailData));

            return redirect()->route('indexlogin')->with('success', 'Password reset successfully and sent to email.');
        }

        return redirect()->route('indexlogin')->with('error', 'Email not found. Please contact your coordinator.');
    }



    public function sendMail(){
        $mailData = [
            'email' => 'dr.ejaz.se@gmail.com',
            'password' => 'Iy25Jo8e'
        ];
         
        Mail::to('ejazbhatti352@gmail.com')->send(new UserMail($mailData));
           
        dd("Email is sent successfully.");
    }
}
