@extends('admin.layouts.resultpreview')

@section('title', 'Class Broadsheet')

@php
    $imgpath = 'storage/front/images/';
@endphp

@push('styles')
    <style>
        .custom-main {
            margin: 15px;
            padding: 10px;
            position: relative;
            font-size: 0.85rem;
            overflow: visible;
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
        }

        .custom-main>* {
            position: relative;
            z-index: 2;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.75rem;
            table-layout: auto;
        }

        .custom-table th,
        .custom-table td {
            padding: 4px;
            border: 1px solid #ccc;
            text-align: center;
            vertical-align: middle;
        }

        .custom-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
            white-space: nowrap;
        }

        .custom-table td:first-child,
        .custom-table td:nth-child(2) {
            text-align: left;
            min-width: 100px;
        }

        .header-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .school-logo {
            width: 100px;
            height: 100px;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-print {
            background-color: #28a745;
            color: white;
            border: none;
        }

        .btn-pdf {
            background-color: #007bff;
            color: white;
            border: none;
        }

        .btn-excel {
            background-color: #17a2b8;
            color: white;
            border: none;
        }

        .btn-exit {
            background-color: #dc3545;
            color: white;
            border: none;
        }

        .btn:hover {
            opacity: 0.9;
        }

        .btn i {
            margin-right: 5px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 8pt;
            }

            .no-print {
                display: none;
            }

            .custom-main {
                margin: 0;
                padding: 5px;
            }

            .custom-table {
                font-size: 7pt;
                table-layout: auto;
                page-break-inside: auto;
            }

            .custom-table th,
            .custom-table td {
                padding: 2px;
                border: 1px solid #ccc;
            }

            .custom-table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .custom-main::before {
                content: "{{ $schoolinfo->school_name ?? 'Confidential' }}";
                font-size: 40px;
            }

            @page {
                size: landscape;
                margin: 0mm;
            }
        }
    </style>
@endpush

@section('content')
    <div class="custom-main" id="pdf-content">
        <!-- Button Group -->
        <div class="button-group no-print">
            <button class="btn btn-print" onclick="window.print()">
                Print
            </button>
            <button class="btn btn-pdf" onclick="generatePDF()">
                Save as PDF
            </button>
            <button class="btn btn-excel" onclick="exportToExcel()">
                Export to Excel
            </button>
            <button class="btn btn-exit" onclick="try { window.close(); } catch(e) { window.history.back(); }">
                Close
            </button>


        </div>

        <!-- Header Section -->
        <div class="header-section">
            <img src="{{ asset('storage/front/images/logo.png') }}" alt="School Logo" class="school-logo">
            <h2 class="text-xl font-bold">{{ $schoolinfo->school_name ?? 'School Name' }}</h2>
            <p class="text-sm">{{ $schoolinfo->address ?? 'School Address' }}</p>
            <p class="text-sm">Phone: {{ $schoolinfo->phone ?? 'Not Provided' }} | Email:
                {{ $schoolinfo->email ?? 'Not Provided' }}</p>
            <h3 class="text-lg font-semibold mt-3">
                Broadsheet for {{ $class->class_name ?? 'N/A' }}
                - {{ ucfirst($schoolinfo->current_term) ?? 'N/A' }} Term, {{ $schoolinfo->current_session ?? 'N/A' }}
                Session
            </h3>
        </div>

        <!-- Results Table -->
        <div class="table-responsive">
            <table class="custom-table" id="broadsheet-table">
                <thead>
                    <tr>
                        <th rowspan="2">ID</th>
                        <th rowspan="2">Student Name</th>
                        @foreach ($subjects as $subject)
                            <th colspan="4">{{ $subject->subject_name }}</th>
                        @endforeach
                        <th rowspan="2">1st Test Total</th>
                        <th rowspan="2">2nd Test Total</th>
                        <th rowspan="2">Exam Total</th>
                        <th rowspan="2">Overall</th>
                        <th rowspan="2">Grade</th>
                        <th rowspan="2">Average</th>
                        <th rowspan="2">Position</th>
                    </tr>
                    <tr>
                        @foreach ($subjects as $subject)
                            <th>1st</th>
                            <th>2nd</th>
                            <th>Exam</th>
                            <th>Total</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @php
                        $remarkMap = [
                            'A' => 'Distinction',
                            'B' => 'Credit',
                            'C' => 'Merit',
                            'D' => 'Pass',
                            'F' => 'Fail',
                        ];
                    @endphp
                    @foreach ($results as $result)
                        @php
                            $resultData = json_decode($result->resultData, true);
                            $student = $result->student;
                            $fullName = trim("{$student->firstname} {$student->middlename} {$student->lastname}");
                        @endphp
                        <tr>
                            <td>{{ $student->studentId ?? 'N/A' }}</td>
                            <td>{{ $fullName }}</td>
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
                                <td>{{ $score['total'] > 0 ? $score['first_test'] : '-' }}</td>
                                <td>{{ $score['total'] > 0 ? $score['second_test'] : '-' }}</td>
                                <td>{{ $score['total'] > 0 ? $score['exam'] : '-' }}</td>
                                <td>{{ $score['total'] > 0 ? $score['total'] : '-' }}</td>
                            @endforeach
                            <td>{{ $resultData['summary']['first_test_total'] ?? 0 }}</td>
                            <td>{{ $resultData['summary']['second_test_total'] ?? 0 }}</td>
                            <td>{{ $resultData['summary']['exam_total'] ?? 0 }}</td>
                            <td>{{ $resultData['summary']['overall_total'] ?? 0 }}</td>
                            <td>{{ $resultData['summary']['grade'] ?? '-' }}</td>
                            <td>{{ number_format($result->average ?? 0, 4) }}</td>
                            <td>{{ $result->position ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/lib/html2pdf.bundle.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/xlsx.full.min.js') }}"></script>


    <script>
        function generatePDF() {
            return new Promise((resolve, reject) => {
                const element = document.getElementById('pdf-content');
                if (!element) {
                    reject('PDF content element not found');
                    return;
                }

                const opt = {
                    margin: 3,
                    filename: 'Broadsheet_{{ $class->class_name ?? 'Class' }}_{{ $schoolinfo->current_session ?? 'Session' }}_{{ $schoolinfo->current_term ?? 'Term' }}.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 1.5,
                        useCORS: true,
                        logging: true
                    },
                    jsPDF: {
                        unit: 'mm',
                        format: 'a3',
                        orientation: 'landscape'
                    },
                    pagebreak: {
                        mode: ['css', 'legacy'],
                        avoid: 'tr'
                    }
                };

                html2pdf()
                    .set(opt)
                    .from(element)
                    .save()
                    .then(resolve)
                    .catch(error => {
                        console.error('PDF generation failed:', error);
                        alert('Failed to generate PDF. Please try again or contact support.');
                        reject(error);
                    });
            });
        }

        function exportToExcel() {
            const table = document.getElementById('broadsheet-table');
            const wb = XLSX.utils.table_to_book(table, {
                sheet: "Broadsheet"
            });
            const fileName =
                'Broadsheet_{{ $class->class_name ?? 'Class' }}_{{ $schoolinfo->current_session ?? 'Session' }}_{{ $schoolinfo->current_term ?? 'Term' }}.xlsx';

            // Correct method to trigger download
            XLSX.writeFile(wb, fileName);
        }
    </script>
@endpush
