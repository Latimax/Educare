@extends('staff.layouts.resultpreview')

@section('title', 'Print Student Result')


@php
    $imgpath = 'storage/front/images/';
@endphp

@push('styles')
    <style>
        .custom-main {
            margin-left: 15px;
            margin-right: 15px;
            padding: 10px;
            position: relative;
            overflow: visible;
            /* Prevent clipping */
        }

        .custom-main::before {
            content: "{{ $schoolinfo->school_name ?? 'School Name' }}";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 60px;
            color: rgba(217, 197, 197, 0.2);
            pointer-events: none;
            z-index: 1;
            white-space: nowrap;
            /* Prevents text from wrapping */
        }

        .custom-main>* {
            position: relative;
            z-index: 2;
            /* Content above watermark */
        }

        .form-control {
            border: 1px solid #ede9e9;
            border-radius: 4px;
            font-weight: bold;

        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;

        }

        .custom-table th,
        .custom-table td {
            padding: 3px;
            border-bottom: 1px solid #ccc;
            text-align: center;

        }

        .custom-table th {
            color: white;
        }

        .custom-table td:first-child,
        .custom-table td:nth-child(2) {
            text-align: center;
        }

        .section-title {
            font-size: 1.05rem;
            font-weight: 600;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #ccc;
            margin-bottom: 0.5rem;
        }


        .info-group {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
            align-items: stretch;
            /* This ensures all items stretch to fill the row height */
        }

        .info-block {
            display: flex;
            flex-direction: column;
            height: 100%;
            /* Take full height of grid cell */
            margin-bottom: 0;
            /* Remove margin since gap handles spacing */
        }

        .info-label {
            background-color: #007bff;
            color: white;
            padding: 5px 10px;
            font-weight: bold;
            border-radius: 4px 4px 0 0;
            flex-shrink: 0;
            /* Prevent label from shrinking */
        }

        .info-value {
            border: 1px solid #dee2e6;
            padding: 10px;
            border-radius: 0 0 4px 4px;
            background-color: #f8f9fa;
            flex-grow: 1;
            /* Allow value to expand and fill remaining space */
            min-height: 60px;
            /* Optional: Set minimum height if needed */
        }

        /* <!-- Print Styling --> */
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 12pt;
            }

            .no-print {
                display: none;
            }

            .bg-white {
                width: 100%;
                max-width: none;
            }

            table {
                page-break-inside: avoid;
            }

            .custom-main::before {
                content: "{{ $schoolinfo->school_name ?? 'Confidential' }}";
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 60px;
                color: rgba(217, 197, 197, 0.2);
                pointer-events: none;
                z-index: 1;
                white-space: nowrap;
                /* Prevents text from wrapping */
            }
        }
    </style>
@endpush


@section('content')
    <div class=" p-6 m-6 mx-auto font-sans custom-main">
        <!-- Header Section -->
        <div class="row text-center align-items-center">
            <!-- School Logo -->
            <div class="col-3 d-flex justify-content-center align-items-center">
                <img src="{{ asset('storage/front/images/logo.png') }}" alt="School Logo" class="w-24 h-24">
            </div>

            <!-- School Details -->
            <div class="col-6">
                <h2 class="text-2xl font-bold mb-1">{{ $schoolinfo->school_name ?? 'School Name' }}</h2>
                <p class="text-sm mb-1">{{ $schoolinfo->school_motto ?? 'School Motto' }}</p>
                <p class="text-sm mb-1">{{ $schoolinfo->address ?? 'School Address' }}</p>
                <p class="text-sm mb-1">Phone: {{ $schoolinfo->phone ?? 'Not Provided' }}</p>
                <p class="text-sm mb-1">Email: {{ $schoolinfo->email ?? 'Not Provided' }}</p>
            </div>

            <!-- Student Profile -->
            <div class="col-3 d-flex justify-content-center align-items-center">
                @if ($result->student->photo)
                    <img src="{{ asset('storage/' . $result->student->photo) }}" alt="photo" width="100"
                        height="100" class="rounded-circle">
                @else
                    <img src="{{ asset($imgpath . 'default-avatar.png') }}" alt="default" width="100" height="100"
                        class="rounded-circle">
                @endif
            </div>
        </div>


        <!-- Student Information -->
        <div class="mb-6">
            <h3 class="text-lg text-center bg-primary-500 p-3 text-white font-semibold border-b-2 border-gray-300">Student
                Information</h3>
            <table class="table table-bordered table-sm">
                <tbody>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Full Name</button>
                                </div>
                                <div class="form-control">
                                    {{ $result->student->firstname ?? '' }}
                                    {{ $result->student->middlename ?? '' }}
                                    {{ $result->student->lastname ?? '' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Age</button>
                                </div>
                                <div class="form-control">
                                    @php
                                        $dob = $result->student->dob ?? now();
                                        $age = \Carbon\Carbon::parse($dob)->diff(\Carbon\Carbon::now());
                                        $years = $age->y;
                                        $months = $age->m;
                                        $ageString = $years . ' years' . ($months > 0 ? ", $months months" : '');
                                    @endphp
                                    {{ $ageString }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Gender</button>
                                </div>
                                <div class="form-control">
                                    {{ ucfirst($result->student->gender) ?? 'N/A' }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Class</button>
                                </div>
                                <div class="form-control">
                                    {{ $class->class_name ?? ($class->name ?? 'Class ' . $class->id) }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Reg No</button>
                                </div>
                                <div class="form-control">
                                    {{ $result->student->studentId ?? 'N/A' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">No. in Class</button>
                                </div>
                                <div class="form-control">
                                    {{ count(\App\Models\Student::where('class_id', $class->id)->get()) ?? 0 }}
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Attendance</button>
                                </div>
                                <div class="form-control">
                                    {{ $result->total_time_present }} out of {{ $schoolinfo->school_opened }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Term</button>
                                </div>
                                <div class="form-control">
                                    {{ ucfirst($result->term) }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn">Next Term Begins</button>
                                </div>
                                <div class="form-control">
                                    @php
                                        $nextTermDate = \Carbon\Carbon::parse(
                                            $schoolinfo->next_term_begin_date ?? now(),
                                        )->format('jS F, Y');
                                    @endphp
                                    {{ $nextTermDate }}
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Result Breakdown -->
        <div class="mb-6">
            <h3 class="text-lg text-center bg-primary-500 p-3 text-white font-semibold border-b-2 border-gray-300">Result
                Breakdown for
                {{ $result->student->firstname ?? '' }}</h3>
            <div class="table-responsive">
                <table class="text-center w-100" style="border-collapse: collapse;">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border p-3">S/N</th>
                            <th class="border p-3">Subject</th>
                            <th class="border p-3">First Test ({{ $level_config->ft_max_score ?? 20 }})</th>
                            <th class="border p-3">Second Test ({{ $level_config->st_max_score ?? 20 }})</th>
                            <th class="border p-3">Exam ({{ $level_config->exam_max_score ?? 60 }})</th>
                            <th class="border p-3">Total</th>
                            <th class="border p-3">Grade</th>
                            <th class="border p-3">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $resultData = json_decode($result->resultData, true);
                            $sn = 1;
                            $remarkMap = [
                                'A' => 'Distinction',
                                'B' => 'Credit',
                                'C' => 'Merit',
                                'D' => 'Pass',
                                'F' => 'Fail',
                            ];
                        @endphp
                        @foreach ($subjects as $subject)
                            @php
                                $score = $resultData['scores'][$subject->id] ?? [
                                    'first_test' => 0,
                                    'second_test' => 0,
                                    'exam' => 0,
                                    'total' => 0,
                                    'grade' => '',
                                    'offer' => true,
                                ];
                            @endphp
                            <tr>
                                <td class="border p-2 text-center">{{ $sn++ }}</td>
                                <td class="border p-2">{{ $subject->subject_name }}</td>
                                <td class="border p-2 text-center">{{ $score['total'] > 0 ? $score['first_test'] : '-' }}
                                </td>
                                <td class="border p-2 text-center">{{ $score['total'] > 0 ? $score['second_test'] : '-' }}
                                </td>
                                <td class="border p-2 text-center">{{ $score['total'] > 0 ? $score['exam'] : '-' }}</td>
                                <td class="border p-2 text-center">{{ $score['total'] > 0 ? $score['total'] : '-' }}</td>
                                <td class="border p-2 text-center">{{ $score['total'] > 0 ? $score['grade'] : '-' }}</td>
                                <td class="border p-2 text-center">
                                    {{ $score['total'] > 0 ? $remarkMap[$score['grade']] ?? '' : '-' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="border p-2 text-center"></td>
                            <td class="border p-2 fw-bold">Overall Total</td>
                            <td class="border p-2 text-center fw-bold">
                                {{ $resultData['summary']['first_test_total'] ?? 0 }}
                            </td>
                            <td class="border p-2 text-center fw-bold">
                                {{ $resultData['summary']['second_test_total'] ?? 0 }}
                            </td>
                            <td class="border p-2 text-center fw-bold">{{ $resultData['summary']['exam_total'] ?? 0 }}</td>
                            <td class="border p-2 text-center fw-bold">{{ $resultData['summary']['overall_total'] ?? 0 }}
                            </td>
                            <td class="border p-2 text-center"></td>
                            <td class="border p-2 text-center">

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>


        <div class="mb-6 row">
            <!-- Left Column -->
            <div class="col-6">
                <!-- Psychomotor -->
                <div class="mb-4">
                    <div class="section-title">Psychomotor</div>
                    <table class="custom-table">
                        <thead style="background-color: #20C997;">
                            <tr>
                                <th>S/N</th>
                                <th>Psychomotor</th>
                                <th>Excellent</th>
                                <th>Good</th>
                                <th>Fair</th>
                                <th>Poor</th>
                                <th>V.Poor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (['handwriting', 'verbal', 'sports', 'drawing', 'craftwork'] as $index => $field)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ ucwords(str_replace('_', ' ', $field)) }}</td>
                                    @foreach (['excellent', 'good', 'fair', 'poor', 'v_poor'] as $value)
                                        <td>{{ $result->$field === $value ? '✔' : '' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Grading Key -->
                <div>
                    <div class="section-title">Grading Key</div>
                    <table class="custom-table">
                        <thead style="background-color: #20C997;">
                            <tr>
                                <th>Score Range</th>
                                <th>Grade</th>
                                <th>Remark</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>70–100</td>
                                <td>A</td>
                                <td>Distinction</td>
                            </tr>
                            <tr>
                                <td>60–69</td>
                                <td>B</td>
                                <td>Credit</td>
                            </tr>
                            <tr>
                                <td>50–59</td>
                                <td>C</td>
                                <td>Merit</td>
                            </tr>
                            <tr>
                                <td>40–49</td>
                                <td>D</td>
                                <td>Pass</td>
                            </tr>
                            <tr>
                                <td>0–39</td>
                                <td>F</td>
                                <td>Fail</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Right Column: Effective Area -->
            <div class="col-6">
                <div class="section-title">Effective Area</div>
                <table class="custom-table">
                    <thead style="background-color: #20C997;">
                        <tr>
                            <th>S/N</th>
                            <th>Effective Area</th>
                            <th>Excellent</th>
                            <th>Good</th>
                            <th>Fair</th>
                            <th>Poor</th>
                            <th>V.Poor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['punctuality', 'regularity', 'neatness', 'politeness', 'honesty', 'cooperation', 'emotional', 'health', 'behaviour', 'attentiveness'] as $index => $field)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ ucwords(str_replace('_', ' ', $field)) }}</td>
                                @foreach (['excellent', 'good', 'fair', 'poor', 'v_poor'] as $value)
                                    <td>{{ $result->$field === $value ? '✔' : '' }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="info-group">
            <div class="info-block">
                <div class="info-label">No. of Subjects Passed</div>
                <div class="info-value">{{ $result->noofsubjectpass ?? 0 }}</div>
            </div>

            <div class="info-block">
                <div class="info-label">Average</div>
                <div class="info-value">{{ $result->average }}</div>
            </div>

            <div class="info-block">
                <div class="info-label">Grade</div>
                <div class="info-value">{{ $resultData['summary']['grade'] ?? '' }}</div>
            </div>

            <div class="info-block">
                <div class="info-label">Conduct</div>
                <div class="info-value">{{ $result->conduct ?? '' }}</div>
            </div>

            <div class="info-block">
                <div class="info-label">Teacher's Comment</div>
                <div class="info-value">
                    @php
                        $teacherComment = $comments->firstWhere('id', $result->class_teacher_comment);
                    @endphp
                    {{ $teacherComment->comment ?? 'N/A' }}
                </div>
            </div>

            <div class="info-block">
                <div class="info-label">Principal's Comment</div>
                <div class="info-value">
                    @php
                        $principalComment = $comments->firstWhere('id', $result->principal_comment);
                    @endphp
                    {{ $principalComment->comment ?? 'N/A' }}
                </div>
            </div>

            <div class="info-block">
                <div class="info-label">School Close Date</div>
                <div class="info-value">
                    @php
                        $closeDate = \Carbon\Carbon::parse($schoolinfo->school_close_date ?? now())->format('jS F, Y');
                    @endphp
                    {{ $closeDate }}
                </div>
            </div>

            <div class="info-block">
                <div class="info-label">Signature</div>
                <div class="info-value">____________________</div>
            </div>
        </div>

    </div>

@endsection
