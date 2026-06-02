<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\FunctionalityPermission;
use App\Models\Functionality;
use App\Models\Program;
use App\Models\PEO;
use App\Models\PLO;
use App\Models\CLO;
use App\Models\Institute;
use App\Models\Cirriculum;
use App\Models\CourseOffer;
use App\Models\Course;

use Illuminate\Support\Facades\Auth;
trait TraitFunctions {

  /*-------------------------------------------------------------------------------
  CHECK PERMISSIONS FUNCTION
  -------------------------------------------------------------------------------*/
  public function checkPermissions($permission){
    $guard_name = $this->checkRole(Auth::user()->role_id);
    $permission = Permission::select('id')->wherename($permission)->whereguard_name($guard_name)->get()->toArray();
    if($permission){
      return true;
    }else{
      return false;
    }

  }
  
  public function checkRole($role_id){

    $user_roles = json_decode($role_id);
    $roles = Role::select('id','name')->get();
    $roleId = null;
    if (session()->has('role_key')) {
      $roleId = session('role_key');
    } else {
      foreach($roles as $role){
        if(in_array($role->id,$user_roles)){
          $roleId = $role->id;
        }
      }
    }
    

    $role_data = Role::select('guard_name')->whereid($roleId)->get()->toArray();
    if($role_data){
      return $role_data[0]['guard_name'];
    }else{
      return false;
    }

  }
  
  // public function checkRole($role_id){
  //   $role_data = Role::select('guard_name')->whereid($role_id)->get()->toArray();
  //   if($role_data){
  //     return $role_data[0]['guard_name'];
  //   }else{
  //     return false;
  //   }

  // }

// public function hasFunctionalityPermission($userId, $roleId)
// {
//     $permission = FunctionalityPermission::where('user_id', $userId)
//         ->where('role_id', $roleId)
//         ->first();

//     if (!$permission) {
//         return null;
//     }

//     $function = Functionality::find($permission->function_id);
//     if (!$function) {
//         return null;
//     }

//     switch ($function->slug) {
//         case 'all':
//         case 'reports_dashboard':
//         case 'courseoffering_enrollment':
//             return ['flag' => $permission->relavent_table_flag];

//         case 'institute':
//             // Handle multiple institute IDs
//             $instituteIds = array_filter(explode(',', $permission->relavent_id));
//             if (empty($instituteIds)) {
//                 return ['flag' => 'institute'];
//             }

//             return $instituteIds;

//             $program_ids = Program::whereIn('institute_id', $instituteIds)->pluck('id') ?? [];
//             $course_ids = Course::whereIn('program_id', $program_ids)->pluck('id') ?? [];
//             $campus_ids = Institute::whereIn('id', $instituteIds)->pluck('campus_id') ?? [];

//             return [
//                 'program_id' => $program_ids,
//                 'peo_id' => PEO::whereIn('program_id', $program_ids)->pluck('id') ?? [],
//                 'plo_id' => PLO::whereIn('program_id', $program_ids)->pluck('id') ?? [],
//                 'clo_id' => CLO::whereIn('course_id', $course_ids)->pluck('id') ?? [],
//                 'cirriculum_id' => Cirriculum::whereIn('institute_id', $instituteIds)->pluck('id') ?? [],
//                 'courseoffer_id' => CourseOffer::whereIn('program_id', $program_ids)->pluck('id') ?? [],
//                 'course_ids' => $course_ids,
//                 'campus_id' => $campus_ids,
//                 'institute_id' => $instituteIds,
//                 'flag' => 'institute'
//             ];
//             break;

//         case 'program':
//             $programIds = array_filter(explode(',', $permission->relavent_id));
//             if (empty($programIds)) {
//                 return ['flag' => 'program'];
//             }

//             $institute_ids = Program::whereIn('id', $programIds)->pluck('institute_id') ?? [];
//             $course_ids = Course::whereIn('program_id', $programIds)->pluck('id') ?? [];
//             $courseoffer_id = CourseOffer::whereIn('program_id', $programIds)->pluck('id') ?? [];
//             $campus_ids = Institute::whereIn('id', $institute_ids)->pluck('campus_id') ?? [];

//             return [
//                 'institute_id' => $institute_ids,
//                 'program_id' => $programIds,
//                 'peo_id' => PEO::whereIn('program_id', $programIds)->pluck('id') ?? [],
//                 'plo_id' => PLO::whereIn('program_id', $programIds)->pluck('id') ?? [],
//                 'clo_id' => CLO::whereIn('course_id', $course_ids)->pluck('id') ?? [],
//                 'cirriculum_id' => Cirriculum::whereIn('program_id', $programIds)->pluck('id') ?? [],
//                 'courseoffer_id' => $courseoffer_id,
//                 'course_ids' => $course_ids,
//                 'campus_id' => $campus_ids,
//                 'flag' => 'program'
//             ];
//             break;

//         case 'enrolled_course':
//             $offered_ids = array_filter(explode(',', $permission->relavent_id));
//             if (empty($offered_ids)) {
//                 return ['flag' => 'enrolled_course'];
//             }

//             $courseOffer = CourseOffer::whereIn('id', $offered_ids)->get();
//             if ($courseOffer->isEmpty()) {
//                 return ['flag' => 'enrolled_course'];
//             }

//             $programIds = $courseOffer->pluck('program_id')->toArray();
//             $instituteIds = $courseOffer->pluck('institute_id')->toArray();
//             $course_ids = $courseOffer->pluck('course_id')->toArray();
//             $campus_ids = Institute::whereIn('id', $instituteIds)->pluck('campus_id')->toArray();

//             return [
//                 'cirriculum_id' => Cirriculum::whereIn('institute_id', $instituteIds)->pluck('id')->toArray(),
//                 'peo_id' => PEO::whereIn('program_id', $programIds)->pluck('id')->toArray(),
//                 'plo_id' => PLO::whereIn('program_id', $programIds)->pluck('id')->toArray(),
//                 'clo_id' => CLO::whereIn('course_id', $course_ids)->pluck('id')->toArray(),
//                 'course_ids' => $course_ids,
//                 'program_id' => $programIds,
//                 'institute_id' => $instituteIds,
//                 'campus_id' => $campus_ids,
//                 'courseoffer_id' => $offered_ids,
//                 'flag' => 'enrolled_course'
//             ];
//             break;

//         default:
//             return null;
//     }
// }

  public function hasFunctionalityPermission($userId, $roleId)
  {
      $permission = FunctionalityPermission::select('*')->whereuser_id($userId)->whererole_id($roleId)->first();
      // return  $permission->function_id;
      if (!$permission) {
        return null; 
      }
      $function = Functionality::where(['id' => $permission->function_id])->first();

      // return $function->slug;
      if (!$function) {
        return null; 
      }
      switch ($function->slug) {
        case 'all':
          return ['flag'=> $permission->relavent_table_flag];
          break;
        case 'reports_dashboard':
          return ['flag' => $permission->relavent_table_flag];
          break;
        case 'courseoffering_enrollment':
          return ['flag' => $permission->relavent_table_flag];
          break;

        case 'institute':
          $instituteId = $permission->relavent_id  ?? null;
          $program_ids = Program::whereRaw("FIND_IN_SET(?, institute_id)", [$instituteId])->pluck('id') ?? [];
          // return $program_ids;
          $course_ids = Course::whereIn('program_id', $program_ids)->pluck('id') ?? [];
          $campus_ids = Institute::where('id', $instituteId)->pluck('campus_id') ?? [];
          $instituteIds = Institute::where('id', $instituteId)->pluck('id') ?? [];
          return [
            'program_id' => $program_ids,
            'peo_id' => PEO::whereIn('program_id', $program_ids)->pluck('id') ?? [],
            'plo_id' => PLO::whereIn('program_id', $program_ids)->pluck('id') ?? [],
            'clo_id' => CLO::whereIn('course_id', $course_ids)->pluck('id') ?? [],
            'cirriculum_id' => Cirriculum::where('institute_id', $instituteId)->pluck('id') ?? [],
            'courseoffer_id' => CourseOffer::whereIn('program_id', $program_ids)->where('institute_id', $instituteId)->pluck('id') ?? [],
            'course_ids' => $course_ids,
            'campus_id' => $campus_ids,
            'institute_id' => $instituteIds,
            'flag' => 'institute'
          ];
          break;

        case 'program':
          $programIds = explode(',', $permission->relavent_id);
          // return $programIds;
          $institute_ids = Program::whereIn('id', $programIds)->pluck('institute_id') ?? [];
          $course_ids = Course::whereIn('program_id', $programIds)->pluck('id') ?? [];
          $courseoffer_id = CourseOffer::whereIn('program_id', $programIds)->pluck('id') ?? [];
          $campus_ids = Institute::whereIn('id', $institute_ids)->pluck('campus_id') ?? [];
          return [
            'institute_id' => $institute_ids, 
            'program_id' => $programIds, 
            'peo_id' => PEO::whereIn('program_id', $programIds)->pluck('id') ?? [],
            'plo_id' => PLO::whereIn('program_id', $programIds)->pluck('id') ?? [],
            'clo_id' => CLO::whereIn('course_id', $course_ids)->pluck('id') ?? [],
            'cirriculum_id' => Cirriculum::whereIn('program_id', $programIds)->pluck('id') ?? [],
            'courseoffer_id' => $courseoffer_id,
            'course_ids' => $course_ids, 
            'campus_id' => $campus_ids, 
            'flag' => 'program'
          ];
          break;
      case 'enrolled_course':
        // Split the relavent_id field into an array of IDs
        $offered_ids = explode(',', $permission->relavent_id);
    
        // Get the course offers based on the IDs
        $courseOffer = CourseOffer::whereIn('id', $offered_ids)->get();
    
        // If no course offers found, return early with a flag
        if ($courseOffer->isEmpty()) {
            return [
                'flag' => 'enrolled_course'
            ];
        }
    
        // Extract program IDs and institute IDs from the course offers
        $programIds = $courseOffer->pluck('program_id')->toArray();
        $instituteIds = $courseOffer->pluck('institute_id')->toArray();
        $course_ids = $courseOffer->pluck('course_id')->toArray();
    
        // Get course IDs based on the program IDs
        // $course_ids = Course::whereIn('program_id', $programIds)->pluck('id')->toArray();
    
        // Get campus IDs based on the institute IDs
        $campus_ids = Institute::whereIn('id', $instituteIds)->pluck('campus_id')->toArray();
    
        // Prepare the response data
        return [
            'cirriculum_id' => Cirriculum::whereIn('institute_id', $instituteIds)->pluck('id')->toArray(),
            'peo_id' => PEO::whereIn('program_id', $programIds)->pluck('id')->toArray(),
            'plo_id' => PLO::whereIn('program_id', $programIds)->pluck('id')->toArray(),
            'clo_id' => CLO::whereIn('course_id', $course_ids)->pluck('id')->toArray(),
            'course_ids' => $course_ids, 
            'program_id' => $programIds,
            'institute_id' => $instituteIds,
            'campus_id' => $campus_ids,
            'courseoffer_id' => $offered_ids,
            'flag' => 'enrolled_course'
        ];
        break;
        
        // case 'enrolled_course':
        //   $offered_ids = explode(',', $permission->relavent_id);
        //   $courseOffer = CourseOffer::whereIn($offered_ids)->pluck('id');
        //   if (!$courseOffer) {
        //     return [
        //       'flag' => 'enrolled_course'
        //     ];
        //     break;
        //   }
        //   $programIds = $courseOffer->pluck('program_id')  ?? [];
        //   $instituteIds = $courseOffer->pluck('institute_id')  ?? [] ?? [];
        //   $course_ids = Course::whereIn('program_id', $instituteIds)->pluck('id')  ?? [];
        //   $campus_ids = Institute::whereIn('id', $instituteIds)->pluck('campus_id')  ?? [];
          
        //   return [
        //     'cirriculum_id' => Cirriculum::whereIn('institute_id', $instituteIds)->pluck('id')  ?? [],
        //     'peo_id' => PEO::whereIn('program_id', $programIds)->pluck('id')  ?? [],
        //     'plo_id' => PLO::whereIn('program_id', $programIds)->pluck('id')  ?? [],
        //     'clo_id' => CLO::whereIn('course_id', $course_ids)->pluck('id')  ?? [],
        //     'course_ids' => $course_ids, 
        //     'program_id' => $programIds,
        //     'institute_id' => $instituteIds,
        //     'campus_id' => $campus_ids,
        //     'courseoffer_id' => $permission->relavent_id,
        //     'flag' => 'enrolled_course'
        //   ];
        //   break;

      default:
        return null;
        break;
    }
  }
}
