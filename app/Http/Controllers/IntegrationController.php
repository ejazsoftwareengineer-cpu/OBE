<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\SapObeData;
use App\Models\SapEnrolledStudent;
use App\Models\Organization;
use App\Models\SapCurriculum;
use App\Models\Campus;
use App\Models\Institute;
use App\Models\Program;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use App\Models\Cirriculum;
use App\Models\CirriculumCourse;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class IntegrationController extends Controller
{
    // public function __construct()
    // {
    //     // ini_set('memory_limit', '500M');
    // }

    //  Excel Import Data 
    public function OrgRegInsPro(){

        $Organizations = SapEnrolledStudent::select( 'organization_id' , 'organization_name')
            ->distinct()
            ->get();
      
        foreach ($Organizations as $org){
            $existingOrganization = Organization::where('id', $org->organization_id)->first();

            if (!$existingOrganization) {
                $newOrganization = Organization::create([
                    'id' => $org->organization_id,
                    'name' => $org->organization_name,
                    'status' => '1'
                ]);
            } else {
                $existingOrganization->update([
                    'name' => $org->organization_name,
                    'status' => '1'
                ]);
            }

            $region = SapEnrolledStudent::select( 'region_id' , 'region_name')
            ->where( 'organization_id', $org->organization_id)
            ->distinct()
            ->get();
            foreach ($region as $reg){

                $existingCampus = Campus::where('id', $reg->region_id)->first();
                if (!$existingCampus) {
                    $newCampus = Campus::create([
                        'id' => $reg->region_id,
                        'name' => $reg->region_name,
                        'organization_id' => $org->organization_id,
                        'status' => '1'
                    ]);
                } else {
                    $existingCampus->update([
                        'name' => $reg->region_name,
                        'organization_id' => $org->organization_id,
                        'status' => '1'
                    ]);
                }

                $institute = SapEnrolledStudent::select( 'institute_id' , 'institute_name')
                    ->where( 'region_id', $reg->region_id)
                    ->distinct()
                    ->get();
                
                foreach ($institute as $ins){
                    $existingInstitute = Institute::where('id', $ins->institute_id)->first();

                    if (!$existingInstitute) {
                        $newInstitute = Institute::create([
                            'id' => $ins->institute_id,
                            'name' => $ins->institute_name,
                            'campus_id' =>  $reg->region_id,
                            'status' => '1'
                        ]);
                    } else {
                        $existingInstitute->update([
                            'name' => $ins->institute_name,
                            'campus_id' =>  $reg->region_id,
                            'status' => '1'
                        ]);
                    }

                    $programs = SapEnrolledStudent::select( 'program_id' , 'program_name')
                        ->where( 'institute_id', $ins->institute_id)
                        ->distinct()
                        ->get();

                    foreach ($programs as $pro){
                        
                        $existingProgram = Program::where('id', $pro->program_id)->first();

                        if (!$existingProgram) {
                            $newProgram = Program::create([
                                'id' => $pro->program_id,
                                'name' => $pro->program_name,
                                'organization_id' => $org->organization_id,
                                'campus_id' => $reg->region_id,
                                'institute_id' => $ins->institute_id,
                                'status' => '1'
                            ]);
                        } else {
                            $existingProgram->update([
                                'name' => $pro->program_name,
                                'organization_id' => $org->organization_id,
                                'campus_id' => $reg->region_id,
                                'institute_id' => $ins->institute_id,
                                'status' => '1'
                            ]);
                        }   
                    }
                }
            }
        }
        $this->Teachers();
        $this->Students();
        $this->Courses();
        $this->Curriculums();
        $this->CourseSection();
    }
    
    public function Teachers(){
        
        $teachers = SapEnrolledStudent::select( 'teacher_id','teacher_name','teacher_email','teacher_phone_no')
            ->distinct()
            ->get();

        $i = 1;
        foreach ($teachers as $teach){
            $existingteacher = User::where('SapTeacherId', $teach->teacher_id)->first();

            if (!$existingteacher) {
                $newteacher = User::create([
                    'SapTeacherId' => $teach->teacher_id,
                    'name' => $teach->teacher_name,
                    'email' => $teach->teacher_email ?? 'teacher'.$i.'@gmail.com',
                    'password' => Hash::make('Riphah@123'),
                    'phone_number' => $teach->teacher_phone_no,
                    'status' => '1',
                    'role_id' => '5'
                ]);
            } else {
                $existingteacher->update([
                    'name' => $teach->teacher_name,
                    'phone_number' => $teach->teacher_phone_no,
                    'status' => '1',
                    'role_id' => '5'
                ]);
            }
            $i++;
        }
    }

    public function Students(){
        $students = SapEnrolledStudent::select('student_id','student_name','student_email_address','student_phonenumber')
            ->distinct()
            ->get();

        $i = 1;
        foreach ($students as $stu){
            $existingstudent = Student::where('id', $stu->student_id)->first();

            if (!$existingstudent) {
               
                $newstudent = Student::create([
                    'id' => $stu->student_id,
                    'name' => $stu->student_name,
                    'roll_no' => $stu->student_id,
                    'registration_no' => $stu->student_id,
                    'email' => $stu->student_email_address ?? 'student'.$i.'@testemail.com',
                    'status' => '1'
                ]);
            } else {
                $existingstudent->update([
                    'name' => $stu->student_name,
                    'roll_no' => $stu->student_id,
                    'registration_no' => $stu->student_id,
                    'status' => '1'
                ]);
            }
            $i++;
        }
    }

    public function Courses(){

        $courses = SapEnrolledStudent::select('course_obj_id')
            ->distinct('course_obj_id')
            ->get();
        foreach ($courses as $cour){
            if($cour->course_obj_id){
                $c = SapEnrolledStudent::select('course_obj_id' , 'course_code','course_name','course_crh')->where('course_obj_id',$cour->course_obj_id)->first();
    
                Course::create([
                    'id' => $c->course_obj_id,
                    'code' => $c->course_code,
                    'name' => $c->course_name,
                    'total_credit_hr' => $c->course_crh,
                    'status' => '1'
                ]);
            }
        }
    }

    public function Curriculums(){
        $cirriculum_rec = SapCurriculum::select('institute_id','program_id','catalog_id' , 'catalog_description','curriculum_id','curriculum_name')
            ->distinct('catalog_id')
            ->whereNotNull('catalog_id')
            ->get();

        foreach ($cirriculum_rec as $cirr){
           
            $cirriculum = Cirriculum::create([
                'sapcatalogid' => $cirr->catalog_id,
                'sapcurriculumid' => $cirr->curriculum_id,
                'sapcurriculumname' => $cirr->curriculum_name,
                'name' => $cirr->catalog_description,
                'institute_id' => $cirr->institute_id,
                'program_id' => $cirr->program_id,
                'status' => '1'
            ]);

            $course_rec = SapCurriculum::select('*')
                ->whereNotNull('catalog_id')
                ->wherecatalog_id($cirr->catalog_id)
                ->whereprogram_id($cirr->program_id)
                ->whereinstitute_id($cirr->institute_id)
                ->get();
                foreach ($course_rec as $cour){

                    CirriculumCourse::create([
                        'course_id' => $cour->course_id,
                        'semester' => substr($cour->semester, 9, 8),
                        'cirriculum_id' => $cirriculum->id,
                        'status' => '1'
                    ]);

                }



        }
    }

    public function CourseOffer(){
        $sections = SapEnrolledStudent::select( 'section_id')
        ->distinct('section_id')
        ->get();

        foreach ($sections as $sec){
            $section = SapEnrolledStudent::select('*')
            ->wheresection_id($sec->section_id)
            ->get();
            
            $flag = 1;
            foreach ($section as $s){

                if($flag == 1){
                    $curriculum = Cirriculum::select('*')
                        ->where('institute_id', $s->institute_id)
                        ->where('program_id', $s->program_id)
                        ->where('sapcurriculumid', $s->curriculum_id)
                        ->first();

                    if($curriculum){
                        $curriculum_course = CirriculumCourse::select('*')
                            ->where('course_id', $s->course_id)
                            ->where('cirriculum_id', $curriculum->id)
                            ->first();
                        $teacher = User::select('*')
                            ->where('SapTeacherId', $s->teacher_id)
                            ->first();
                        $courseoffer = CourseOffer::create([
                            'id' => $s->section_id,
                            'sapsectionid' => $s->section_id,
                            'code' => $s->section_code,
                            'name' => $s->section_name,
                            'institute_id' => $s->institute_id,
                            'program_id' => $s->program_id,
                            'course_id' => $s->course_id,
                            'teacher_id' => $teacher->id,
                            'cirriculum_id' => $curriculum->id,
                            'semester' => $curriculum_course->semester,
                            'status' => '1'
                        ]);
                    }
                }
                $flag = 2;
                if($curriculum){
                    EnrollStudent::create([
                        'student_id' => $s->student_id,
                        'course_section_id' => $s->section_id
                    ]);
                }
            }
        }
    }

    // Api Integration 
    
    public function getUserRecordCurl(){

        set_time_limit(-1);
        ini_set('memory_limit', '200048M');

        // $url = 'http://riphahsu10qas.riphah.edu.pk:8020/sap/opu/odata/sap/ZABM_OBE_INTEGRATION_SRV/ZzobeDataSet?$filter=(AdmAyear%20eq%20%272024%27%20and%20AdmPerid%20eq%20%27001%27)&$format=json&sap-client=210';
        // $url = 'http://172.29.97.177:8020/sap/opu/odata/sap/ZABM_OBE_INTEGRATION_SRV/ZzobeDataSet?$filter=(AdmAyear%20eq%20%272024%27%20and%20AdmPerid%20eq%20%27001%27)&$format=json&sap-client=210';
        // $url = 'http://riphah-hanapv.riphah.edu.pk:8030/sap/opu/odata/sap/ZABM_OBE_INTEGRATION_SRV/ZzobeDataSet?$filter=(AdmAyear%20eq%20%272024%27%20and%20AdmPerid%20eq%20%27001%27)&$format=json';
        // $url = 'http://riphahsu10qas.riphah.edu.pk:8020/sap/opu/odata/sap/ZABM_OBE_INTEGRATION_SRV/ZOBESet?$filter=(AdmAyear%20eq%20%272024%27%20and%20AdmPerid%20eq%20%27001%27)&$format=json&sap-client=210';
        $url = 'http://riphahsu10qas.riphah.edu.pk:8020/sap/opu/odata/sap/ZABM_OBE_INTEGRATION_SRV/ZOBESet?$filter=(AdmAyear%20eq%20%272024%27%20and%20AdmPerid%20eq%20%27001%27)&$format=json&sap-client=210';

        $username = 'SAP_MIS';
        $password = 'sap123';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10000); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','X-Requested-With: X'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $result = curl_exec ($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        curl_close ($ch);

        $get_res = json_decode($result);
        // $a = $get_res->d;
        // $b = $a->results;
        echo "<pre>"; 
        print_r($get_res);
        die();
            //     foreach ($b as $val){
            //         echo "<pre>"; 
            //         print_r($val);
            //         die();
                    
            //         SapObeData::create([
            //             'AdmAyear' => $val->AdmAyear,
            //             'AdmPerid' => $val->AdmPerid,
            //             'SapId' => $val->Id,
            //             'OrgId' => $val->OrgId,
            //             'OrgNam' => $val->OrgNam,
            //             'RegId' => $val->RegId,
            //             'RegNam' => $val->RegNam,
            //             'InstId' => $val->InstId,
            //             'Sobid' => $val->Sobid,
            //             'InstNam' => $val->InstNam,
            //             'ScObjid' => $val->ScObjid,
            //             'ProgNam' => $val->ProgNam,
            //             'CsObjid' => $val->CsObjid,
            //             'Rlcatvers' => $val->Rlcatvers,
            //             'Rlcatverst' => $val->Rlcatverst,
            //             'AwObjid' => $val->AwObjid,
            //             'Course' => $val->Course,
            //             'Cpattemp' => $val->Cpattemp,
            //             'Packnumber' => $val->Packnumber,
            //             'SecNam' => $val->SecNam,
            //             'Tabnr' => $val->Tabnr,
            //             'TeacherId' => $val->TeacherId,
            //             'Teacher' => $val->Teacher,
            //             'StObjid' => $val->StObjid,
            //             'Student12' => $val->Student12,
            //             'VornaMc' => $val->VornaMc,
            //             'NachnMc' => $val->NachnMc,
            //             'Student' => $val->Student,
            //             'Smstatus' => $val->Smstatus,
            //             'Agrid' => $val->Agrid,
            //             'Agrtype' => $val->Agrtype,
            //             'Agrremark' => $val->Agrremark,
            //             'Sessional' => $val->Sessional,
            //             'Mid' => $val->Mid,
            //             'Final' => $val->Final,
            //             'Performance' => $val->Performance,
            //             'Viva' => $val->Viva,
            //             'LvId' => $val->LvId,
            //         ]); 
            //     }    

    }

    // public function OrgRegInsPro(){

    //     $Organizations = SapObeData::select( 'OrgId' , 'OrgNam')
    //         ->distinct()
    //         ->get();

    //     foreach ($Organizations as $org){
    //         $existingOrganization = Organization::where('OrgId', $org->OrgId)->first();

    //         if (!$existingOrganization) {
    //             $newOrganization = Organization::create([
    //                 'OrgId' => $org->OrgId,
    //                 'name' => $org->OrgNam,
    //                 'status' => '1'
    //             ]);
    //         } else {
    //             $existingOrganization->update([
    //                 'name' => $org->OrgNam,
    //                 'status' => '1'
    //             ]);
    //         }

    //         $region = SapObeData::select( 'RegId' , 'RegNam')
    //         ->where( 'OrgId', $org->OrgId)
    //         ->distinct()
    //         ->get();

    //         foreach ($region as $reg){

    //             $existingCampus = Campus::where('RegId', $reg->RegId)->first();
    //             if (!$existingCampus) {
    //                 $newCampus = Campus::create([
    //                     'RegId' => $reg->RegId,
    //                     'name' => $reg->RegNam,
    //                     'organization_id' => $org->OrgId,
    //                     'status' => '1'
    //                 ]);
    //             } else {
    //                 $existingCampus->update([
    //                     'name' => $reg->RegNam,
    //                     'organization_id' => $org->OrgId, 
    //                     'status' => '1'
    //                 ]);
    //             }

    //             $institute = SapObeData::select( 'InstId' , 'InstNam')
    //                 ->where( 'RegId', $reg->RegId)
    //                 ->distinct()
    //                 ->get();
                
    //             foreach ($institute as $ins){
    //                 $existingInstitute = Institute::where('InstId', $ins->InstId)->first();

    //                 if (!$existingInstitute) {
    //                     $newInstitute = Institute::create([
    //                         'InstId' => $ins->InstId,
    //                         'name' => $ins->InstNam,
    //                         'campus_id' =>  $reg->RegId,
    //                         'status' => '1'
    //                     ]);
    //                 } else {
    //                     $existingInstitute->update([
    //                         'name' => $ins->InstNam,
    //                         'campus_id' =>  $reg->RegId, 
    //                         'status' => '1'
    //                     ]);
    //                 }

    //                 $programs = SapObeData::select( 'ScObjid' , 'ProgNam')
    //                     ->where( 'OrgId', $org->OrgId)
    //                     ->where( 'RegId', $reg->RegId)
    //                     ->where( 'InstId', $ins->InstId)
    //                     ->distinct()
    //                     ->get();

    //                 foreach ($programs as $pro){
                        
    //                     $existingProgram = Program::where('SapProId', $pro['ScObjid'])->first();
    //                     if (!$existingProgram) {
    //                         $newProgram = Program::create([
    //                             'SapProId' => $pro['ScObjid'],
    //                             'name' => $pro['ProgNam'],
    //                             'organization_id' => $org->OrgId,
    //                             'campus_id' => $reg->RegId,
    //                             'institute_id' => $ins->InstId,
    //                             'status' => '1'
    //                         ]);
    //                     } else {
    //                         $existingProgram->update([
    //                             'name' => $pro['ProgNam'],
    //                             'organization_id' => $org->OrgId,
    //                             'campus_id' => $reg->RegId,
    //                             'institute_id' => $ins->InstId,
    //                             'status' => '1'
    //                         ]);
    //                     }   
    //                 }
    //             }
    //         }
    //     }
    // }

    // public function Teachers(){
        
    //     $teachers = SapObeData::select( 'TeacherId' , 'Teacher')
    //         ->distinct('TeacherId')
    //         ->get();
    //     $i = 1;
    //     foreach ($teachers as $teach){
    //         $existingteacher = User::where('SapTeacherId', $teach->TeacherId)->first();

    //         if (!$existingteacher) {
    //             $newteacher = User::create([
    //                 'SapTeacherId' => $teach->TeacherId,
    //                 'name' => $teach->Teacher,
    //                 'email' => 'teacher'.$i.'@gmail.com',
    //                 'password' => Hash::make('Riphah@123'),
    //                 'status' => '1',
    //                 'role_id' => '5'
    //             ]);
    //         } else {
    //             $existingteacher->update([
    //                 'name' =>  $teach->Teacher,
    //                 'status' => '1',
    //                 'role_id' => '5'
    //             ]);
    //         }
    //         $i++;
    //     }
    // }

    // public function Students(){
    //     $students = SapObeData::select( 'Student12' , 'VornaMc' , 'NachnMc', 'Student')
    //         ->distinct('Student12')
    //         ->get();

    //     $i = 1;
    //     foreach ($students as $stu){
    //         $existingstudent = Student::where('SapStudentId', $stu->Student12)->first();

    //         if (!$existingstudent) {
               
    //             $newstudent = Student::create([
    //                 'SapStudentId' => $stu->Student12,
    //                 'name' => $stu->Student,
    //                 'roll_no' => $stu->Student12,
    //                 'registration_no' => $stu->Student12,
    //                 'email' => 'student'.$i.'@testemail.com',
    //                 'status' => '1'
    //             ]);
    //         } else {
    //             $existingstudent->update([
    //                 'name' => $stu->Student,
    //                 'roll_no' => $stu->Student12,
    //                 'registration_no' => $stu->Student12,
    //                 'status' => '1'
    //             ]);
    //         }
    //         $i++;
    //     }
    // }

    // public function Courses(){

    //     $courses = SapObeData::select('AwObjid' , 'Course')
    //         ->distinct('AwObjid')
    //         ->get();
    //     foreach ($courses as $cour){
    //         if($cour->AwObjid){
    //             $c = SapObeData::select('AwObjid' , 'Course','Cpattemp')->where('AwObjid',$cour->AwObjid)->first();
    
    //             Course::create([
    //                 'sapcourseid' => $c->AwObjid,
    //                 'name' => $c->Course,
    //                 'total_credit_hr' => $c->Cpattemp,
    //                 'status' => '1'
    //             ]);
    //         }
    //     }
    // }

    // public function Cirriculum(){
    //     $cirriculum = SapObeData::select('Rlcatvers' , 'Rlcatverst')
    //         ->distinct('Rlcatvers')
    //         ->get()->toArray();
            
    //     echo "<pre>";
    //     print_r($cirriculum);
    //     die();

    // }


}
