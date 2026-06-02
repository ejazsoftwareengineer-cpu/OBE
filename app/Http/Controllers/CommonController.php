<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;
use App\Models\Organization;
use App\Models\CirriculumCourse;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Functionality;
use App\Models\Cirriculum;
use App\Models\Institute;
use App\Models\CourseOffer;
use App\Models\Campus;
use App\Models\Course;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
// use App\Models\User;
use App\Models\PLO;
use App\Models\ProgramBatch;
use App\Models\FunctionalityPermission;
use DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CommonController extends Controller
{
    function alterTable()
    {
        try {
            // Run the ALTER TABLE statement
            // DB::statement('ALTER TABLE application_personal_infos MODIFY hear_aboutus VARCHAR(255)');
            // Run the raw SQL query
            // $pass = Hash::make('password');
            // DB::update("UPDATE users SET password = '$pass' WHERE email = 'muhammad.ejaz@riphah.edu.pk'");

            DB::update("ALTER TABLE peo ADD COLUMN program_id INT(11)");
            
            return response()->json(['message' => 'Table altered successfully']);
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function getStateByCountry(){

        $country_id = $_REQUEST['id'];
        if($country_id){
            
            $states = State::select('id','name')->wherecountry_id($country_id)->get();
                ?>
                    <option value="">Select Province</option>
                <?php
            foreach($states as $state){
                ?>
                    <option value="<?= $state->id;?>" ><?= $state->name; ?></option>
                <?php
            }
        }
    }

    function getCitiesByStates(){

        $state_id = $_REQUEST['id'];
        if($state_id){
            
            $cities = City::select('id','name')->wherestate_id($state_id)->get();
                ?>
                    <option value="">Select City</option>
                <?php
            foreach($cities as $city){
                ?>
                    <option value="<?= $city->id;?>" ><?= $city->name; ?></option>
                <?php
            }
        }
    }
    
    
    function getCampusByOrganization(){

        $organization_id = $_REQUEST['id'];
        if($organization_id){
            
            $campus = Campus::select('id','name')->whereorganization_id($organization_id)->get();
                ?>
                    <option value="">Select Campus</option>
                <?php
            foreach($campus as $cam){
                ?>
                    <option value="<?= $cam->id;?>" ><?= $cam->name; ?></option>
                <?php
            }
        }
    }

    function getInstituteByCampus(){

        $campus_id = $_REQUEST['id'];
        if($campus_id){
            
            $institute = Institute::select('id','name')->wherecampus_id($campus_id)->get();
                ?>
                    <option value="">Select Institute</option>
                <?php
            foreach($institute as $ins){
                ?>
                    <option value="<?= $ins->id;?>" ><?= $ins->name; ?></option>
                <?php
            }
        }
    }
    function getMultipleInstituteByCampus(){

        $campus_id = $_REQUEST['id'];
        if($campus_id){
            
            $institute = Institute::select('id','name')->whereIN('campus_id' ,$campus_id)->get();
                ?>
                    <option value="">Select Institute</option>
                <?php
            foreach($institute as $ins){
                ?>
                    <option value="<?= $ins->id;?>" ><?= $ins->name; ?></option>
                <?php
            }
        }
    }
    function getFacultyByCampus(){

        $campus_id = $_REQUEST['id'];
        if($campus_id){
            
            $faculty = Faculty::select('id','name')->wherecampus_id($campus_id)->get();
                ?>
                    <option value="">Select Campus</option>
                <?php
            foreach($faculty as $fac){
                ?>
                    <option value="<?= $fac->id;?>" ><?= $fac->name; ?></option>
                <?php
            }
        }
    }
    
    function getFacultyByDepartment(){

        $faculty_id = $_REQUEST['id'];
        if($faculty_id){
            
            $departments = Department::select('id','name')->wherefaculty_id($faculty_id)->get();
                ?>
                    <option value="">Select Department</option>
                <?php
            foreach($departments as $dep){
                ?>
                    <option value="<?= $dep->id;?>" ><?= $dep->name; ?></option>
                <?php
            }
        }
    }

    function getCourseByCourseId(){

        $course_id = $_REQUEST['id'];
        if($course_id){
            $courses = Course::select('*')->whereid($course_id)->get()->toArray();
            echo json_encode($courses); exit;
        }else{
            exit;
        }
    }
    function getCoursesbyProgram(){

        $program_id = $_REQUEST['program_id'];
        if($program_id){
            
            $courses = Course::select('id','code','name')->whereprogram_id($program_id)->get();
                ?>
                    <option value="">Select Course</option>
                <?php
            foreach($courses as $cou){
                ?>
                    <option value="<?= $cou->id;?>" ><?= $cou->code; ?> - <?= $cou->name; ?></option>
                <?php
            }
        }
    }
    function getMultipleCoursesbyProgram(){

        $program_id = $_REQUEST['program_id'];
        if($program_id){
            
            $courses = Course::select('id','code','name')->whereIN('program_id',$program_id)->get();
            $courses = Course::with(['program'])->whereIN('program_id',$program_id)->latest()->get();
                ?>
                    <option value="">Select Course</option>
                <?php
            foreach($courses as $cou){
                ?>
                    <option value="<?= $cou->id;?>" ><?= $cou->code; ?> - <?= $cou->name; ?></option>
                <?php
            }
        }
    }
    
    function getDepartmentByProgram(){

        $department_id = $_REQUEST['id'];
        if($department_id){
            
            $programs = Program::select('id','name')->wheredepartment_id($department_id)->get();
                ?>
                    <option value="">Select Program</option>
                <?php
            foreach($programs as $prog){
                ?>
                    <option value="<?= $prog->id;?>" ><?= $prog->name; ?></option>
                <?php
            }
        }
    }

    function getInstituteByProgram(){

        $institute_id = $_REQUEST['id'];
        if($institute_id){
            
            // $programs = Program::select('id','name')->whereinstitute_id($institute_id)->get();
                $ids = array_filter(explode(',', $institute_id));

        // Fetch programs matching any of those institute IDs
        $programs = Program::select('id', 'name')
            ->where(function($query) use ($ids) {
                foreach ($ids as $id) {
                    $query->orWhereRaw("FIND_IN_SET(?, institute_id)", [$id]);
                }
            })
            ->get();
                ?>
                    <option value="">Select Program</option>
                <?php
            foreach($programs as $prog){
                ?>
                    <option value="<?= $prog->id;?>" ><?= $prog->name; ?></option>
                <?php
            }
        }
    }
    function getStudentByProgrambackup(){
        
        $program_id = $_REQUEST['id'];
        $session_id = $_REQUEST['session_id'];
        if($program_id){
            
            $students =Student::select('id', 'name', 'roll_no')
            ->when($session_id, function ($query, $session_id) {
                return $query->where('active_session_id', $session_id);
            })
            ->where('program_id', $program_id)
            ->get();
             ?>
            
            <option value="select_all">Select All</option>
            
            <?php 
            foreach($students as $stu){
                ?>
                   <option value="<?= $stu->id;?>" ><?= $stu->roll_no; ?>-<?= $stu->name; ?></option> 
                <?php
            }

        }
    }
    function getStudentByProgram()
{
    $program_id = $_REQUEST['id'];
    $session_id = $_REQUEST['session_id'];
    if ($program_id) {
        $students = Student::select('id', 'name', 'roll_no')
            ->when($session_id, function ($query, $session_id) {
                return $query->where('active_session_id', $session_id);
            })
            ->where('program_id', $program_id)
            ->get();
        ?>

        <div class="ml-3 mr-3 table-responsive">
            <form id="studentForm" method="POST" action="your_submit_url_here">
                <table id="outcomeTable" class="table table-bordered review-table mb-0">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>Registration No.</th>
                            <th>Student Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($students as $s) {
                            ?>
                            <tr>
                                <td><input type="checkbox" class="student-checkbox" name="student_ids[]" value="<?= $s->id; ?>"></td>
                                <td><?= $s->roll_no ?? ''; ?></td>
                                <td><?= $s->name ?? ''; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>

        <script>
            $(document).ready(function() {
                $('#outcomeTable').DataTable({
                    "paging": true,
                    "ordering": true,
                    "searching": true,
                    "info": true,
                    "pageLength": 100
                });

                // Select all checkboxes when "Select All" is clicked
                $('#selectAll').on('click', function() {
                    $('.student-checkbox').prop('checked', this.checked);
                });

                // Uncheck "Select All" if any checkbox is unchecked
                $('.student-checkbox').on('click', function() {
                    if (!$(this).prop('checked')) {
                        $('#selectAll').prop('checked', false);
                    }
                });
            });
        </script>

        <?php
    }
}

    

    function getCirriculumByProgram(){

        $program_id = $_REQUEST['id'];
        if($program_id){
            $cirriculum = Cirriculum::select('id','name')->whereprogram_id($program_id)->get(); ?>
                    <option value="">Select Cirriculum</option>
            <?php
            foreach($cirriculum as $cir){
                ?>
                    <option value="<?= $cir->id;?>" ><?= $cir->name; ?></option>
                <?php
            }
        }
    }
    function getSemesterByCirriculum(){

        $cirriculum_id = $_REQUEST['id'];
        if($cirriculum_id){
            
            $semester = CirriculumCourse::select('semester')->wherecirriculum_id($cirriculum_id)->groupBy('semester')->get();
            ?>
                <option value="">Select Semester</option>
            <?php
            foreach($semester as $cir){
                ?>
                    <option value="<?= $cir->semester;?>" ><?= $cir->semester; ?></option>
                <?php
            }
        }
    }
    function getCourseBySemester(){

        $semester_id = $_REQUEST['id'];
        $cirriculum_id = $_REQUEST['cirriculum_id'];
        $flag = $_REQUEST['flag'];
        if($flag == 'option'){

            if($semester_id){
                $course = CirriculumCourse::with(['course'])->wheresemester($semester_id)->wherecirriculum_id($cirriculum_id)->get();
                ?>
                    <option value="">Select Course</option>
                <?php
                foreach($course as $cou){ ?>
                        <option value="<?= $cou->course->id;?>" ><?= $cou->course->name ?? ''; ?></option>
                    <?php
                }
            }
        }elseif($flag == 'li'){
            
            if($semester_id){
                $course = CirriculumCourse::with(['course'])->wheresemester($semester_id)->wherecirriculum_id($cirriculum_id)->get();
                ?>
                    
                <?php
                foreach($course as $cou){ ?>
                 <li type="text" id="<?= $cou->course->id;?>" class="team_temp_members"><a class="" onclick="changecolor('<?= $cou->course->id;?>')"><?= $cou->course->name ?? ''; ?></a></li>
                        
                    <?php
                }
            }
        }
    }

    function getPeoByProgrambatch(){

        $program_batch_id = $_REQUEST['id'];
        if($program_batch_id){
            
            $plos = PLO::select('id','code','name')->whereprogram_batch_id($program_batch_id)->get();
                ?>
                    <option value="">Select PLO</option>
                <?php
            foreach($plos as $plo){
                ?>
                    <option value="<?= $plo->id;?>" ><?= $plo->code .'-'.$plo->name; ?></option>
                <?php
            }
        }
    }
    
    function getPloByProgram(){

        $program_id = $_REQUEST['id'];
        if($program_id){
            
            $plos = PLO::select('id','code','name')->whereprogram_id($program_id)->get();
                ?>
                    <option value="">Select PLO</option>
                <?php
            foreach($plos as $plo){
                ?>
                    <option value="<?= $plo->id;?>" ><?= $plo->code .'-'.$plo->name; ?></option>
                <?php
            }
        }
    }
    
    function getPloByProgrambatch(){

        $program_batch_id = $_REQUEST['id'];
        if($program_batch_id){
            
            $plos = PLO::select('id','code','name')->whereprogram_batch_id($program_batch_id)->get();
                ?>
                    <option value="">Select PLO</option>
                <?php
            foreach($plos as $plo){
                ?>
                    <option value="<?= $plo->id;?>" ><?= $plo->code .'-'.$plo->name; ?></option>
                <?php
            }
        }
    }

    function getProgramByProgrambatch(){

        $program_id = $_REQUEST['id'];
        if($program_id){
            
            $program_batch = ProgramBatch::select('id','name')->whereprogram_id($program_id)->get();
                ?>
                    <option value="">Select Program Batch</option>
                <?php
            foreach($program_batch as $prog_bat){
                ?>
                    <option value="<?= $prog_bat->id;?>" ><?= $prog_bat->name; ?></option>
                <?php
            }
        }
    }

    function getRolesByUser(){

        $user_id = $_REQUEST['id'];
        if($user_id){
                $user = User::find($user_id);
                $roleIds = $user->roles->pluck('id')->toArray();
                $roles = Role::select('id','name')->whereIn('id',$roleIds)->get();
                ?>
                    <option value="">Select Role</option>
                <?php
            foreach($roles as $role){
                ?>
                    <option value="<?= $role->id;?>" ><?= $role->name; ?></option>
                <?php
            }
        }
    }

    function getDatabyFunction(){

        $function_id = $_REQUEST['id'];
        if($function_id){
            $function = Functionality::whereid($function_id)->first();
            $name = $function->slug;

            if($name === 'all'){
                ?>
                    <input type="hidden" name="relavent_table_flag" value="all">
                    <select id="relavent_id" name="relavent_id" class="select">    
                        <option value="all">All</option>
                    </select>
                <?php           
            }elseif($name === 'institute'){
                $institute = Institute::select('id','name')->get();
                ?>
                <input type="hidden" name="relavent_table_flag" value="Institute">
                    <select id="relavent_id" name="relavent_id" class="select">   
                    <option value="">Select Institute</option>
                <?php foreach($institute as $ins){?>
                    <option value="<?= $ins->id;?>"><?= $ins->name; ?></option>
                <?php }?>
                </select>
                <?php
            }elseif($name === 'program'){
                $program = Program::select('id','name')->get();
                ?>
                <input type="hidden" name="relavent_table_flag" value="Program">
                <select id="relavent_id" name="relavent_id[]" class="select" multiple>   
                <option value="">Select Program</option>
                    <?php foreach($program as $pro){?>
                        <option value="<?= $pro->id;?>" ><?= $pro->name; ?></option>
                    <?php }?>
                </select>
                <?php
            }elseif($name === 'reports_dashboard'){
                ?>
                <input type="hidden" name="relavent_table_flag" value="report-dashboard">
                    <select id="relavent_id" name="relavent_id" class="select">   
                <option value="report-dashboard">Reports/Dashboard</option>
                </select>
                <?php
            }elseif($name === 'enrolled_course'){
                $courseoffer = CourseOffer::select('id','name')->get();
                ?>
                <input type="hidden" name="relavent_table_flag" value="CourseOffer">
                    <select id="relavent_id" name="relavent_id[]" class="select" multiple>   
                    <option value="">Select Course Offered</option>
                <?php foreach($courseoffer as $co){?>
                    <option value="<?= $co->id;?>" ><?= $co->name; ?></option>
                <?php }?>
                </select>
                <?php
            }elseif($name === 'courseoffering_enrollment'){
                ?>
                
                <input type="hidden" name="relavent_table_flag" value="offeredcourse-enrollment">
                    <select id="relavent_id" name="relavent_id" class="select">   
                <option value="offeredcourse-enrollment">Offered Course/Enrollment </option>
                </select>
                <?php
            }else{
                ?><option value="none">None</option><?php
            }
        }
        
    }

    function getOrganizationHierarchy(){
        $data = Organization::with(
            ['campus'=> function($query) 
                {
                    return $query->select(['id','organization_id', 'name']);
                }
            ])->latest()->get();

        $program = new Program;
        return view('hierarchy.hierarchy',compact('data','program'));
    }
    // public function getOrganizationHierarchy()
    // {
    //     $data = Organization::with([
    //         'campus.institute.programs'
    //     ])->orderBy('id','DESC')->get();

    //     return view('hierarchy.hierarchy', compact('data'));
    // }

}
