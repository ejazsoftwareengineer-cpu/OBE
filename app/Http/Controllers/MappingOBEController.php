<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PLO;
use App\Models\CLO;
use App\Models\PEO;
use App\Models\Program;
use App\Models\PloPeo;
use App\Models\PloKpis;
use App\Models\Department;
use App\Models\PeoPloMapping;
use App\Models\Course;
use App\Models\ProgramBatch;
use App\Models\PloByCourseSectionClo;
use Illuminate\Support\Facades\Auth;
use App\Traits\TraitFunctions;
use App\Exports\AssessmentMarksTestTemplateExport;

use App\Exports\AssessmentMarksTemplateExport;
use App\Imports\AssessmentMarksImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssessmentMarksTestImport;
class MappingOBEController extends Controller
{
    use TraitFunctions;

    public function mapPlo()
    {
        $user = Auth::user();
        $roleId = session('role_key');
        $hasFunctionalityPermission = $this->hasFunctionalityPermission($user->id , $roleId);
        // $flag = $hasFunctionalityPermission ? $hasFunctionalityPermission['flag'] ?? $hasFunctionalityPermission->relavent_table_flag : '' ;
        $program_id = $hasFunctionalityPermission['program_id'] ?? [];

        if($program_id){
            $program = Program::select('id','name')->whereIn('id',$program_id)->wherestatus(1)->get();
        }else{
            $program = Program::select('id','name')->wherestatus(1)->get();
        }

        $courses = Course::select('id','name','code')->wherestatus(1)->get();   
        // $program = Program::select('id','name')->wherestatus(1)->get();   
        return view('map.mapplo',compact('courses','program')); 
    }
    
    function getMappingViewByCourse()
    {
        $course_id = $_REQUEST['course_id'];
        $program_id = $_REQUEST['program_id'];
        if($course_id){
            $course = Course::select('id','name','code')->whereid($course_id)->wherestatus(1)->get();
            $plos = PLO::where('program_id',$program_id)->wherestatus(1)->get();
            $clos = CLO::where('course_id',$course_id)->wherestatus(1)->get();
            ?>
            
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>CLO's</th>
                            <?php foreach($plos as $plo){ ?>
                                <th title="<?= $plo->description; ?>"><?php echo $plo->name; ?>  (<?php echo $plo->code; ?>) </th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i =1; ?>
                        <?php foreach($clos as $clo){ ?>
                            <tr>
                                <input type="hidden" name="clo_id" value="<?php echo $clo->id; ?>" id="clo_id_<?php echo $clo->id; ?>">
                                <td title="<?= $clo->description; ?>"><?php echo $clo->code; ?></td>
                                <?php foreach($plos as $plo){ 
                                    $checked = PloByCourseSectionClo::whereclo_id($clo->id)->whereplo_id($plo->id)->wherecourse_id($course_id)->first();
                                ?>
                                    <td><input id="checkbox<?= $i; ?>"  onclick="mapPLOCLO('<?php echo route('addPloCloByCourse');?>','<?php echo  $plo->id ;?>','<?php echo  $clo->id ;?>','<?php echo  $course_id ;?>','<?php echo  $i++ ;?>')" type="checkbox"  <?php if($checked) echo "checked"; ?>></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            
               
            <?php
        }
    }

    function getMappingViewByPeoPlo(){

        $program_id = $_REQUEST['peo_plo_program_id'];
        if($program_id){
            $peos = PEO::where('program_id',$program_id)->wherestatus(1)->get();
            $plos = PLO::where('program_id',$program_id)->wherestatus(1)->get();
            ?>
            
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>PEO's</th>
                            <?php foreach($plos as $plo){ ?>
                                <th title="<?= $plo->description; ?>"> <?php echo $plo->name; ?> (<?php echo $plo->code; ?>)</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i =1; ?>
                        <?php foreach($peos as $peo){ ?>
                            <tr>
                                <input type="hidden" name="peo_id" value="<?php echo $peo->id; ?>" id="peo_id_<?php echo $peo->id; ?>">
                                <td title="<?= $peo->description; ?>">  <?php echo $peo->name; ?>(<?php echo $peo->code; ?>)</td>
                                <?php foreach($plos as $plo){ 
                                    $checked = PeoPloMapping::wherepeo_id($peo->id)->whereplo_id($plo->id)->first();
                                ?>
                                    <td><input id="peoplocheckbox<?= $i; ?>"  onclick="mapPEOPLO('<?php echo route('addPeoPloMapping');?>','<?php echo  $plo->id ;?>','<?php echo  $peo->id ;?>','<?php echo  $program_id ;?>','<?php echo  $i++ ;?>')" type="checkbox"  <?php if($checked) echo "checked"; ?>></td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            
               
            <?php
        }
    }
    
    public function addPeoPloMapping(){

        $plo_id = $_REQUEST['plo_id'];
        $peo_id = $_REQUEST['peo_id'];
        $program_id = $_REQUEST['program_id'];
        $checked = $_REQUEST['checked'];
        if($checked =='1'){
            // $PloByCourseSectionClo_object = new PloByCourseSectionClo();
            // $PloByCourseSectionClo_object->whereclo_id($clo_id)->wherecourse_id($course_id)->delete();
            PeoPloMapping::create([
                'plo_id' => $plo_id,
                'peo_id' => $peo_id,
                'program_id' => $program_id,
                'status' => '1',
                'created_by' => Auth::user()->id,
            ]);
        }else if($checked =='0'){   
            $PloByCourseSectionClo_object = new PeoPloMapping();
            $PloByCourseSectionClo_object->whereplo_id($plo_id)->wherepeo_id($peo_id)->whereprogram_id($program_id)->delete();
        }
    }

    public function addPloCloByCourse(){
        // exit('jjj');
        $plo_id = $_REQUEST['plo_id'];
        $clo_id = $_REQUEST['clo_id'];
        $course_id = $_REQUEST['course_id'];
        $program_id = $_REQUEST['program_id'];
        $checked = $_REQUEST['checked'];
        if($checked =='1'){
            // $PloByCourseSectionClo_object = new PloByCourseSectionClo();
            // $PloByCourseSectionClo_object->whereclo_id($clo_id)->wherecourse_id($course_id)->delete();
            PloByCourseSectionClo::create([
                'clo_id' => $clo_id,
                'course_id' => $course_id,
                'plo_id' => $plo_id,
                'program_id' => $program_id,
                'status' => '1',
                'created_by' => Auth::user()->id,
            ]);
        }else if($checked =='0'){   
            $PloByCourseSectionClo_object = new PloByCourseSectionClo();
            $PloByCourseSectionClo_object->whereclo_id($clo_id)->whereplo_id($plo_id)->wherecourse_id($course_id)->delete();
        }
    }

    public function downloadExcelTemplete($id){
        // $courseoffer = CourseOffer::with(['institute', 'course','teacher','sesssion'])->where('id',$id)->first();
        // $enrolledstudent = EnrollStudent::with(['student','course_section'])->wherecourse_section_id($id)->latest()->get(); 
        return Excel::download(new AssessmentMarksTemplateExport($id), 'assessment_marks_template.xlsx');
    }

 
public function downloadExcelTestTemplate($id)
{
    return Excel::download(
        new AssessmentMarksTestTemplateExport($id),
        'assessment_marks_template.xlsx'
    );
}

 
public function uploadTestAssessment(Request $request){
    $request->validate([
        'assessment_file' => 'required|file|mimes:xlsx,xls,csv',
        'course_offer_id' => 'required',
    ]);
    
    ini_set('max_execution_time', 300);
    ini_set('memory_limit', '1024M');

    $file = $request->file('assessment_file');
    $courseOfferId = $request->input('course_offer_id');
    // dd($file);
    // dd($courseOfferId);
    try {
        Excel::import(new AssessmentMarksTestImport($courseOfferId), $file);
        return back()->with('success', 'Assessment marks uploaded successfully.');
    } catch (\Exception $e) {
        return back()->with('error', 'Error during upload: ' . $e->getMessage());
    }
}
    public function uploadAssessment(Request $request)
    {
        $request->validate([
            'assessment_file' => 'required|file|mimes:xlsx,xls',
        ]);
        
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '1024M');

        $file = $request->file('assessment_file');
        $courseOfferId = $request->input('course_offer_id');
        // echo "<pre>";
        // print_r($courseOfferId);
        // die();

        Excel::import(new AssessmentMarksImport($courseOfferId), $file);

        return back()->with('success', 'Assessment marks uploaded successfully.');
    }

}
