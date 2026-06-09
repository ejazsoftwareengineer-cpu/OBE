<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CourseOffer;
use App\Models\EnrollStudent;
use App\Models\Institute;
use App\Models\Program;
use App\Models\Course;
use App\Models\Sesssion;
use App\Models\User;
use App\Traits\TraitFunctions;

class DashboardController extends Controller
{
    use TraitFunctions;

    /**
     * Render the Analytics Dashboard with KPIs, dynamic filters,
     * teacher analytics, distribution data, and recent offerings.
     *
     * Supported filter query params:
     *   institute_id    – Faculty / Department
     *   session_id      – Academic Session (semester)
     *   academic_year   – e.g. "2024-2025"  (matched against sesssion.title LIKE)
     *   program_id      – Specific program
     *   course_id       – Specific course
     */
    public function analytics(Request $request)
    {
        /* ----------------------------------------------------------
         |  1.  Resolve & sanitise filter inputs
         |  -------------------------------------------------------- */
        $activeSession = session()->has('session_key')
            ? Sesssion::find(session('session_key'))
            : Sesssion::where('status', 1)->first();

        $instituteId  = $request->input('institute_id');
        $sessionId    = $request->input('session_id',   $activeSession->id ?? null);
        $academicYear = $request->input('academic_year');
        $programId    = $request->input('program_id');
        $courseId     = $request->input('course_id');

        /* If an academic year is chosen but no specific session, expand it
         * into a list of session ids (e.g. all semesters in 2024-2025).  */
        $yearSessionIds = null;
        if ($academicYear && !$request->filled('session_id')) {
            $yearSessionIds = Sesssion::where('title', 'like', '%' . $academicYear . '%')
                ->pluck('id');
        }

        /* ----------------------------------------------------------
         |  2.  Build base CourseOffer query — single source of truth
         |  -------------------------------------------------------- */
        $baseQuery = CourseOffer::query()
            ->when($instituteId,    fn($q) => $q->where('institute_id', $instituteId))
            ->when($programId,      fn($q) => $q->where('program_id',   $programId))
            ->when($courseId,       fn($q) => $q->where('course_id',    $courseId))
            ->when($sessionId,      fn($q) => $q->where('active_session_id', $sessionId))
            ->when($yearSessionIds, fn($q) => $q->whereIn('active_session_id', $yearSessionIds));

        $offerIds = (clone $baseQuery)->pluck('id');

        /* ----------------------------------------------------------
         |  3.  KPI aggregations
         |  -------------------------------------------------------- */
        $totalPrograms = (clone $baseQuery)
            ->whereNotNull('program_id')
            ->distinct('program_id')
            ->count('program_id');

        $totalCoursesOffered = (clone $baseQuery)
            ->whereNotNull('course_id')
            ->distinct('course_id')
            ->count('course_id');

        $totalTeachers = (clone $baseQuery)
            ->whereNotNull('teacher_id')
            ->distinct('teacher_id')
            ->count('teacher_id');

        $totalSections = (clone $baseQuery)->count();

        // Real enrolments — DISTINCT students across the filtered offerings
        $totalEnrollments = EnrollStudent::whereIn('course_section_id', $offerIds)
            ->distinct('student_id')
            ->count('student_id');

        $totalSeatRows = EnrollStudent::whereIn('course_section_id', $offerIds)->count();

        $studentTeacherRatio   = $totalTeachers > 0 ? round($totalEnrollments / $totalTeachers, 1) : 0;
        $avgStudentsPerSection = $totalSections > 0 ? round($totalSeatRows    / $totalSections, 1) : 0;

        /* ----------------------------------------------------------
         |  4.  Teacher analytics — load + ratio per teacher
         |  -------------------------------------------------------- */
        $teacherLoad = (clone $baseQuery)
            ->select(
                'teacher_id',
                DB::raw('COUNT(*) as sections'),
                DB::raw('COUNT(DISTINCT course_id) as courses')
            )
            ->whereNotNull('teacher_id')
            ->groupBy('teacher_id')
            ->orderByDesc('sections')
            ->limit(10)
            ->get();

        $teacherUsers = User::whereIn('id', $teacherLoad->pluck('teacher_id'))->get()->keyBy('id');

        $perTeacherEnrolment = EnrollStudent::query()
            ->select('course_offers.teacher_id', DB::raw('COUNT(DISTINCT enroll_students.student_id) as students'))
            ->join('course_offers', 'enroll_students.course_section_id', '=', 'course_offers.id')
            ->whereIn('enroll_students.course_section_id', $offerIds)
            ->groupBy('course_offers.teacher_id')
            ->pluck('students', 'course_offers.teacher_id');

        $teacherAnalytics = $teacherLoad->map(function ($row) use ($teacherUsers, $perTeacherEnrolment) {
            $user     = $teacherUsers->get($row->teacher_id);
            $students = (int) ($perTeacherEnrolment[$row->teacher_id] ?? 0);
            return (object) [
                'id'       => $row->teacher_id,
                'name'     => $user->name  ?? '—',
                'email'    => $user->email ?? '',
                'sections' => (int) $row->sections,
                'courses'  => (int) $row->courses,
                'students' => $students,
                'ratio'    => $row->sections > 0 ? round($students / $row->sections, 1) : 0,
            ];
        });

        /* ----------------------------------------------------------
         |  5.  Distribution data — for Chart.js
         |  -------------------------------------------------------- */
        $byInstitute = (clone $baseQuery)
            ->select('institute_id', DB::raw('COUNT(*) as offerings'))
            ->whereNotNull('institute_id')
            ->groupBy('institute_id')
            ->with('institute:id,name')
            ->orderByDesc('offerings')
            ->limit(8)
            ->get()
            ->map(fn($r) => (object)[
                'label' => $r->institute->name ?? '—',
                'value' => (int) $r->offerings,
            ]);

        $byProgram = (clone $baseQuery)
            ->select('program_id', DB::raw('COUNT(*) as offerings'))
            ->whereNotNull('program_id')
            ->groupBy('program_id')
            ->with('program:id,name')
            ->orderByDesc('offerings')
            ->limit(6)
            ->get()
            ->map(fn($r) => (object)[
                'label' => $r->program->name ?? '—',
                'value' => (int) $r->offerings,
            ]);

        // Enrolments per session (trend)
        $bySession = (clone $baseQuery)
            ->select('active_session_id', DB::raw('COUNT(*) as offerings'))
            ->whereNotNull('active_session_id')
            ->groupBy('active_session_id')
            ->with('sesssion:id,title')
            ->orderBy('active_session_id')
            ->limit(8)
            ->get()
            ->map(fn($r) => (object)[
                'label' => $r->sesssion->title ?? '—',
                'value' => (int) $r->offerings,
            ]);

        /* ----------------------------------------------------------
         |  6.  Recent offerings (table)
         |  -------------------------------------------------------- */
        $recentOfferings = (clone $baseQuery)
            ->with(['institute:id,name', 'program:id,name', 'course:id,code,name', 'teacher:id,name'])
            ->latest()
            ->limit(10)
            ->get();

        /* ----------------------------------------------------------
         |  7.  Filter dropdown sources
         |  -------------------------------------------------------- */
        $institutes = Institute::select('id', 'name')->where('status', 1)->orderBy('name')->get();
        $sessions   = Sesssion::select('id', 'title')->orderByDesc('id')->get();

        // Build an academic-year list from session titles (best-effort regex match)
        $academicYears = $sessions
            ->map(fn($s) => preg_match('/(\d{4}\s*[-\/]\s*\d{4})/', (string) $s->title, $m) ? $m[1] : null)
            ->filter()
            ->unique()
            ->values();

        $programs = Program::select('id', 'name', 'institute_id')
            ->when($instituteId, fn($q) => $q->where('institute_id', $instituteId))
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $courses = Course::select('id', 'code', 'name')
            ->where('status', 1)
            ->orderBy('code')
            ->get();

        /* ----------------------------------------------------------
         |  8.  Send everything to the view
         |  -------------------------------------------------------- */
        return view('dashboard.analytics', compact(
            'totalPrograms',
            'totalCoursesOffered',
            'totalTeachers',
            'totalSections',
            'totalEnrollments',
            'totalSeatRows',
            'studentTeacherRatio',
            'avgStudentsPerSection',
            'teacherAnalytics',
            'byInstitute',
            'byProgram',
            'bySession',
            'recentOfferings',
            'institutes',
            'sessions',
            'academicYears',
            'programs',
            'courses',
            'instituteId',
            'sessionId',
            'academicYear',
            'programId',
            'courseId'
        ));
    }
}
