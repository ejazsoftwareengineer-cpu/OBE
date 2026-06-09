{{--
    ============================================================
    Analytics Dashboard — Light Theme
    Uses existing <x-layout.*> components. Light "island" inside
    the dark app shell, with Tailwind (preflight disabled) +
    Chart.js for fully reactive visualisations.
    ============================================================
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard | OBE</title>

    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    {{-- Tailwind CDN (preflight disabled so it can coexist with Bootstrap) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    fontFamily: {
                        display: ['"Space Grotesk"', 'sans-serif'],
                        sans:    ['Inter', 'sans-serif'],
                    },
                }
            }
        };
    </script>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        /* ─── Light island scope ───
           The global dark theme set body/html dark. We carve out a
           bright workspace inside the page-wrapper using #ax-light. */
        #ax-light {
            font-family: 'Inter', system-ui, sans-serif;
            color: #0f172a;        /* slate-900 */
            background: #f8fafc;   /* slate-50  */
            border-radius: 20px;
            padding: 28px;
            margin: -6px -6px 0;
            box-shadow:
                0 30px 80px -30px rgba(15, 23, 42, 0.45),
                inset 0 1px 0 rgba(255,255,255,0.8);
        }
        #ax-light * { box-sizing: border-box; }

        /* Card */
        #ax-light .ax-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;          /* slate-200 */
            border-radius: 16px;
            box-shadow:
                0 1px 2px rgba(15,23,42,0.04),
                0 8px 24px -12px rgba(15,23,42,0.08);
            transition: transform 280ms cubic-bezier(.22,1,.36,1),
                        box-shadow 280ms cubic-bezier(.22,1,.36,1),
                        border-color 280ms cubic-bezier(.22,1,.36,1);
        }
        #ax-light .ax-card:hover {
            transform: translateY(-2px);
            border-color: #cbd5e1;              /* slate-300 */
            box-shadow:
                0 1px 2px rgba(15,23,42,0.05),
                0 18px 40px -14px rgba(15,23,42,0.14);
        }

        /* Accent icon tiles */
        #ax-light .ax-tile-blue    { background: linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; }
        #ax-light .ax-tile-teal    { background: linear-gradient(135deg,#14b8a6,#0d9488); color:#fff; }
        #ax-light .ax-tile-indigo  { background: linear-gradient(135deg,#6366f1,#4f46e5); color:#fff; }
        #ax-light .ax-tile-violet  { background: linear-gradient(135deg,#8b5cf6,#7c3aed); color:#fff; }
        #ax-light .ax-tile-amber   { background: linear-gradient(135deg,#f59e0b,#d97706); color:#fff; }
        #ax-light .ax-tile-emerald { background: linear-gradient(135deg,#10b981,#059669); color:#fff; }

        /* Pill chips */
        #ax-light .ax-chip {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 4px 10px; border-radius: 999px;
            font-size: 11px; font-weight: 600; letter-spacing: 0.3px;
        }
        #ax-light .ax-chip-blue  { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }
        #ax-light .ax-chip-teal  { background:#f0fdfa; color:#0f766e; border:1px solid #99f6e4; }
        #ax-light .ax-chip-up    { background:#ecfdf5; color:#059669; border:1px solid #a7f3d0; }

        /* Form controls */
        #ax-light label.ax-label {
            font-size: 11px; font-weight: 600;
            letter-spacing: 0.6px; text-transform: uppercase;
            color: #64748b;                    /* slate-500 */
            margin-bottom: 6px; display: block;
        }
        #ax-light select.ax-select {
            width: 100%;
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            border-radius: 10px;
            padding: 10px 36px 10px 14px;
            font-size: 14px;
            font-family: inherit;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            transition: border-color .2s, box-shadow .2s, background-color .2s;
        }
        #ax-light select.ax-select:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.14);
        }

        /* Bar fill */
        #ax-light .ax-bar-track { background:#f1f5f9; border-radius:999px; overflow:hidden; height:8px; }
        #ax-light .ax-bar-fill  { height:8px; border-radius:999px; transition: width 600ms cubic-bezier(.22,1,.36,1); }

        /* Animations */
        @keyframes ax-fade-up { from { opacity:0; transform: translateY(10px);} to { opacity:1; transform: translateY(0);} }
        #ax-light .ax-fade { animation: ax-fade-up 480ms cubic-bezier(.22,1,.36,1) both; }

        /* Subtle gradient hero strip on the page header */
        #ax-light .ax-hero-strip {
            background:
                radial-gradient(60% 80% at 0% 0%, rgba(59,130,246,0.10), transparent 60%),
                radial-gradient(60% 80% at 100% 0%, rgba(20,184,166,0.10), transparent 60%),
                #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
        }

        /* Table */
        #ax-light .ax-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        #ax-light .ax-table th {
            text-align: left;
            font-size: 11px; font-weight: 700; letter-spacing: 0.6px;
            text-transform: uppercase; color: #64748b;
            padding: 12px 14px;
            border-bottom: 1px solid #e2e8f0;
            background: #f8fafc;
        }
        #ax-light .ax-table td {
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13.5px;
            color: #1e293b;
            transition: background .15s ease;
        }
        #ax-light .ax-table tr:hover td { background: #f8fafc; }
        #ax-light .ax-table tr:last-child td { border-bottom: none; }

        /* Avatar initials bubble */
        #ax-light .ax-avatar {
            width: 36px; height: 36px; border-radius: 50%;
            display: grid; place-items: center;
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700; font-size: 12px;
            background: linear-gradient(135deg,#dbeafe,#bfdbfe);
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        /* Reset link colour inside the light island */
        #ax-light a { color: #2563eb; }
        #ax-light a:hover { color: #1d4ed8; }
    </style>
</head>
<body>
    <div class="main-wrapper">

        <x-layout.header />
        <x-layout.sidebar />

        <!-- Page Wrapper -->
        <div class="page-wrapper">
            <div class="content container-fluid" style="padding: 22px 22px 12px;">

                {{-- ╔═══════════════════════════════════════════════
                     ║   LIGHT-THEME ANALYTICS WORKSPACE
                     ╚═══════════════════════════════════════════════ --}}
                <div id="ax-light">

                    {{-- ─── Hero header strip ─── --}}
                    <div class="ax-hero-strip ax-fade p-6 mb-6 flex flex-wrap items-end justify-between gap-4">
                        <div>
                            <span class="ax-chip ax-chip-blue">
                                <span class="inline-block w-1.5 h-1.5 rounded-full" style="background:#2563eb"></span>
                                LIVE ANALYTICS
                            </span>
                            <h1 class="font-display font-bold mt-3 text-[28px] md:text-[32px] leading-tight" style="color:#0f172a; letter-spacing:-0.4px;">
                                Outcome-Based Education — Insights
                            </h1>
                            <p class="text-[14px] mt-1" style="color:#64748b;">
                                Programs, enrolments, teacher loads & faculty mix at a glance.
                            </p>
                        </div>

                        <div class="text-[12px] flex items-center gap-2" style="color:#64748b;">
                            <i class="fa fa-calendar"></i>
                            <span>Updated {{ now()->format('M d, Y · H:i') }}</span>
                        </div>
                    </div>

                    {{-- ─── Filter form ─── --}}
                    <form method="GET" action="{{ route('home') }}"
                          class="ax-card ax-fade p-5 mb-6" style="animation-delay:60ms">
                        <input type="hidden" name="view" value="analytics">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <span class="w-9 h-9 rounded-xl grid place-items-center ax-tile-blue">
                                    <i class="fa fa-filter"></i>
                                </span>
                                <div>
                                    <div class="font-display font-semibold text-[15px]" style="color:#0f172a;">Filter Dimensions</div>
                                    <div class="text-xs" style="color:#64748b;">Slice data by faculty, timeline, program, or course</div>
                                </div>
                            </div>
                            <a href="{{ route('home', ['view' => 'analytics']) }}"
                               class="text-xs font-medium" style="color:#2563eb;">
                                <i class="fa fa-refresh mr-1"></i> Reset
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
                            <div>
                                <label class="ax-label">Faculty / Department</label>
                                <select name="institute_id" class="ax-select">
                                    <option value="">All faculties</option>
                                    @foreach($institutes as $i)
                                        <option value="{{ $i->id }}" {{ (string)$instituteId === (string)$i->id ? 'selected' : '' }}>
                                            {{ $i->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="ax-label">Academic Year</label>
                                <select name="academic_year" class="ax-select">
                                    <option value="">All years</option>
                                    @foreach($academicYears as $y)
                                        <option value="{{ $y }}" {{ (string)$academicYear === (string)$y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="ax-label">Semester</label>
                                <select name="session_id" class="ax-select">
                                    <option value="">All semesters</option>
                                    @foreach($sessions as $s)
                                        <option value="{{ $s->id }}" {{ (string)$sessionId === (string)$s->id ? 'selected' : '' }}>
                                            {{ $s->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="ax-label">Program</label>
                                <select name="program_id" class="ax-select">
                                    <option value="">All programs</option>
                                    @foreach($programs as $p)
                                        <option value="{{ $p->id }}" {{ (string)$programId === (string)$p->id ? 'selected' : '' }}>
                                            {{ $p->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="ax-label">Course</label>
                                <select name="course_id" class="ax-select">
                                    <option value="">All courses</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c->id }}" {{ (string)$courseId === (string)$c->id ? 'selected' : '' }}>
                                            {{ $c->code }} — {{ $c->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end gap-2">
                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-[13px] transition-all duration-300 hover:-translate-y-0.5"
                                    style="background: linear-gradient(135deg,#3b82f6,#2563eb); color:#fff; box-shadow: 0 8px 22px -8px rgba(37,99,235,0.55);">
                                <i class="fa fa-bolt"></i> Apply Filters
                            </button>
                        </div>
                    </form>

                    {{-- ─── KPI cards ─── --}}
                    @php
                        $kpis = [
                            ['Programs Offered',  $totalPrograms,        'la la-graduation-cap', 'ax-tile-blue',    'Distinct active programs'],
                            ['Real Enrolments',   $totalEnrollments,     'la la-users',          'ax-tile-teal',    "{$totalSeatRows} total seat rows"],
                            ['Teachers Engaged',  $totalTeachers,        'la la-user-tie',       'ax-tile-indigo',  'Distinct teaching faculty'],
                            ['Student / Teacher', $studentTeacherRatio,  'la la-balance-scale',  'ax-tile-violet',  "Avg {$avgStudentsPerSection} per section"],
                        ];
                        $delays = [0, 80, 160, 240];
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        @foreach($kpis as $idx => $k)
                            <div class="ax-card ax-fade p-5" style="animation-delay: {{ $delays[$idx] }}ms">
                                <div class="flex items-start justify-between">
                                    <div class="w-12 h-12 rounded-xl grid place-items-center text-xl {{ $k[3] }}">
                                        <i class="{{ $k[2] }}"></i>
                                    </div>
                                    <span class="ax-chip ax-chip-up">
                                        <i class="fa fa-arrow-up text-[9px]"></i> Live
                                    </span>
                                </div>
                                <div class="mt-5">
                                    <div class="font-display font-bold text-[28px] tracking-tight" style="color:#0f172a;">
                                        {{ is_numeric($k[1]) ? number_format($k[1], (is_float($k[1]) ? 1 : 0)) : $k[1] }}
                                    </div>
                                    <div class="text-[13.5px] font-medium mt-0.5" style="color:#334155;">{{ $k[0] }}</div>
                                    <div class="text-[11.5px] mt-2" style="color:#94a3b8;">{{ $k[4] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- ─── Charts row ─── --}}
                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-6">

                        {{-- Bar chart: Offerings by Faculty --}}
                        <div class="ax-card ax-fade p-5 lg:col-span-3" style="animation-delay:120ms">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="font-display font-semibold text-[15px]" style="color:#0f172a;">Offerings by Faculty</div>
                                    <div class="text-xs" style="color:#64748b;">Top departments by section count</div>
                                </div>
                                <span class="w-9 h-9 rounded-xl grid place-items-center ax-tile-blue">
                                    <i class="la la-university"></i>
                                </span>
                            </div>
                            <div style="position: relative; height: 280px;">
                                <canvas id="chartByInstitute"></canvas>
                            </div>
                        </div>

                        {{-- Donut: Program Mix --}}
                        <div class="ax-card ax-fade p-5 lg:col-span-2" style="animation-delay:180ms">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <div class="font-display font-semibold text-[15px]" style="color:#0f172a;">Program Mix</div>
                                    <div class="text-xs" style="color:#64748b;">Share of offerings</div>
                                </div>
                                <span class="w-9 h-9 rounded-xl grid place-items-center ax-tile-teal">
                                    <i class="la la-pie-chart"></i>
                                </span>
                            </div>
                            <div style="position: relative; height: 280px;">
                                <canvas id="chartByProgram"></canvas>
                            </div>
                        </div>
                    </div>

                    {{-- ─── Trend line: Offerings per Session ─── --}}
                    <div class="ax-card ax-fade p-5 mb-6" style="animation-delay:200ms">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <div class="font-display font-semibold text-[15px]" style="color:#0f172a;">Enrolment Trend Across Sessions</div>
                                <div class="text-xs" style="color:#64748b;">How offerings have moved across the academic timeline</div>
                            </div>
                            <span class="w-9 h-9 rounded-xl grid place-items-center ax-tile-indigo">
                                <i class="la la-area-chart"></i>
                            </span>
                        </div>
                        <div style="position: relative; height: 240px;">
                            <canvas id="chartBySession"></canvas>
                        </div>
                    </div>

                    {{-- ─── Teacher analytics ─── --}}
                    <div class="ax-card ax-fade p-5 mb-6" style="animation-delay:260ms">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl grid place-items-center ax-tile-emerald">
                                    <i class="la la-user-tie"></i>
                                </span>
                                <div>
                                    <div class="font-display font-semibold text-[15px]" style="color:#0f172a;">Teacher Activities &amp; Load</div>
                                    <div class="text-xs" style="color:#64748b;">Sections taught, students reached, and S/T ratio</div>
                                </div>
                            </div>
                            <span class="text-[11px] font-bold uppercase tracking-widest" style="color:#94a3b8;">Top 10</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="ax-table">
                                <thead>
                                    <tr>
                                        <th>Teacher</th>
                                        <th class="text-center">Sections</th>
                                        <th class="text-center">Unique Courses</th>
                                        <th class="text-center">Students</th>
                                        <th>Load</th>
                                        <th class="text-right">S / T Ratio</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $maxSections = max($teacherAnalytics->pluck('sections')->push(1)->toArray()); @endphp
                                    @forelse($teacherAnalytics as $t)
                                        @php $loadPct = $maxSections > 0 ? round(($t->sections / $maxSections) * 100) : 0; @endphp
                                        <tr>
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <span class="ax-avatar">{{ strtoupper(substr($t->name, 0, 2)) }}</span>
                                                    <div class="min-w-0">
                                                        <div class="font-semibold truncate" style="color:#0f172a;">{{ $t->name }}</div>
                                                        <div class="text-[11.5px] truncate" style="color:#94a3b8;">{{ $t->email }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center font-semibold" style="color:#2563eb;">{{ $t->sections }}</td>
                                            <td class="text-center">{{ $t->courses }}</td>
                                            <td class="text-center">{{ $t->students }}</td>
                                            <td style="min-width:160px;">
                                                <div class="ax-bar-track">
                                                    <div class="ax-bar-fill"
                                                         style="width:{{ $loadPct }}%; background:linear-gradient(90deg,#14b8a6,#3b82f6);">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <span class="ax-chip ax-chip-teal">{{ $t->ratio }}</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center py-10" style="color:#94a3b8;">No teacher activity for this slice.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ─── Recent offerings ─── --}}
                    <div class="ax-card ax-fade p-5 mb-2" style="animation-delay:320ms">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <span class="w-10 h-10 rounded-xl grid place-items-center ax-tile-amber">
                                    <i class="la la-book-open"></i>
                                </span>
                                <div>
                                    <div class="font-display font-semibold text-[15px]" style="color:#0f172a;">Recent Course Offerings</div>
                                    <div class="text-xs" style="color:#64748b;">Latest sections matching your filters</div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
                            @forelse($recentOfferings as $o)
                                <div class="rounded-xl p-4 transition-all duration-300 hover:-translate-y-0.5"
                                     style="background:#f8fafc; border:1px solid #e2e8f0;">
                                    <div class="flex items-center justify-between mb-3">
                                        <span class="ax-chip ax-chip-blue">{{ $o->course->code ?? '—' }}</span>
                                        <span class="w-2 h-2 rounded-full" style="background:#10b981; box-shadow:0 0 8px #6ee7b7;"></span>
                                    </div>
                                    <div class="font-display font-semibold text-[14px] leading-snug mb-1" style="color:#0f172a;">
                                        {{ \Illuminate\Support\Str::limit($o->course->name ?? 'Untitled course', 48) }}
                                    </div>
                                    <div class="text-[12px] mb-3 truncate" style="color:#64748b;">
                                        <i class="la la-university mr-1"></i>{{ $o->institute->name ?? '—' }}
                                    </div>
                                    <div class="flex items-center justify-between pt-3" style="border-top:1px solid #e2e8f0;">
                                        <span class="text-[12px] truncate" style="color:#334155;">
                                            <i class="la la-user mr-1" style="color:#2563eb"></i>{{ $o->teacher->name ?? '—' }}
                                        </span>
                                        <span class="ax-chip ax-chip-teal">Sec {{ $o->section ?? '—' }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full text-center py-10" style="color:#94a3b8;">No offerings in this slice.</div>
                            @endforelse
                        </div>
                    </div>

                </div>
                {{-- ═════ /ax-light ═════ --}}

            </div>
            <x-layout.footer />
        </div>
        <!-- /Page Wrapper -->
    </div>

    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    {{-- ──────────────────────────────────────────────────────────
         Chart.js — interactive light-theme visualisations
         ────────────────────────────────────────────────────────── --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const palette = {
                blue:   '#3b82f6', blueSoft:   'rgba(59,130,246,0.18)',
                teal:   '#14b8a6', tealSoft:   'rgba(20,184,166,0.18)',
                indigo: '#6366f1', indigoSoft: 'rgba(99,102,241,0.18)',
                violet: '#8b5cf6',
                amber:  '#f59e0b',
                rose:   '#fb7185',
                emerald:'#10b981',
            };

            const baseFont = { family: 'Inter', size: 12 };
            Chart.defaults.font = baseFont;
            Chart.defaults.color = '#475569';
            Chart.defaults.borderColor = '#e2e8f0';

            /* ── Bar: Offerings by Faculty ── */
            const elInst = document.getElementById('chartByInstitute');
            if (elInst) {
                const ctx  = elInst.getContext('2d');
                const grad = ctx.createLinearGradient(0, 0, 0, 280);
                grad.addColorStop(0, '#3b82f6');
                grad.addColorStop(1, 'rgba(59,130,246,0.25)');

                new Chart(elInst, {
                    type: 'bar',
                    data: {
                        labels:   @json($byInstitute->pluck('label')),
                        datasets: [{
                            label: 'Offerings',
                            data:  @json($byInstitute->pluck('value')),
                            backgroundColor: grad,
                            borderColor: palette.blue,
                            borderWidth: 1.5,
                            borderRadius: 8,
                            maxBarThickness: 38,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#0f172a', padding: 10,
                                titleFont: { weight: '600' }, cornerRadius: 8,
                            }
                        },
                        scales: {
                            x: { grid: { display: false }, ticks: { autoSkip: false, maxRotation: 30, minRotation: 0 } },
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { precision: 0 } }
                        }
                    }
                });
            }

            /* ── Donut: Program Mix ── */
            const elProg = document.getElementById('chartByProgram');
            if (elProg) {
                new Chart(elProg, {
                    type: 'doughnut',
                    data: {
                        labels:   @json($byProgram->pluck('label')),
                        datasets: [{
                            data: @json($byProgram->pluck('value')),
                            backgroundColor: [palette.blue, palette.teal, palette.indigo, palette.violet, palette.amber, palette.emerald],
                            borderColor: '#ffffff',
                            borderWidth: 3,
                            hoverOffset: 8,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '64%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: { boxWidth: 10, boxHeight: 10, padding: 12, usePointStyle: true, pointStyle: 'circle' }
                            },
                            tooltip: { backgroundColor: '#0f172a', cornerRadius: 8 }
                        }
                    }
                });
            }

            /* ── Line: Enrolment Trend ── */
            const elSess = document.getElementById('chartBySession');
            if (elSess) {
                const ctx  = elSess.getContext('2d');
                const grad = ctx.createLinearGradient(0, 0, 0, 240);
                grad.addColorStop(0, 'rgba(99,102,241,0.35)');
                grad.addColorStop(1, 'rgba(99,102,241,0.00)');

                new Chart(elSess, {
                    type: 'line',
                    data: {
                        labels:   @json($bySession->pluck('label')),
                        datasets: [{
                            label: 'Offerings',
                            data:  @json($bySession->pluck('value')),
                            fill: true,
                            backgroundColor: grad,
                            borderColor: palette.indigo,
                            borderWidth: 2.5,
                            tension: 0.35,
                            pointBackgroundColor: '#fff',
                            pointBorderColor: palette.indigo,
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { backgroundColor: '#0f172a', cornerRadius: 8 }
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { precision: 0 } }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
