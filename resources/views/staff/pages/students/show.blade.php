@extends('staff.layouts.app')

@section('title', 'Student Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/audioplayer.css') }}">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Student Profile</h6>

            <div class="d-flex flex-wrap gap-2">

                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#studentIdCardModal">
                    Show Student ID Card
                </button>
            </div>
        </div>


        @if (session('success'))
            <div class="alert alert-success my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="akar-icons:double-check" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                </div>
                <button class="remove-button text-success-600 text-xxl line-height-1">
                    <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                </button>
            </div>
        @endif

        <div class="card h-100 p-0 radius-12 overflow-hidden mb-4">
            <div class="card-body p-40">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center mb-3 mb-md-0">
                        @if ($student->photo)
                            <img src="{{ asset('storage/' . $student->photo) }}" alt="Photo"
                                class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px;">
                                <span class="text-white fs-1">{{ strtoupper(substr($student->firstname, 0, 1)) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-10">
                        <h4 class="fw-bold mb-1">{{ $student->firstname }} {{ $student->middlename }}
                            {{ $student->lastname }}</h4>
                        <div class="mb-2 text-muted">Admission No: <b>{{ $student->admission_number }}</b></div>
                        <div class="mb-2">Class:
                            <b>{{ optional($classes->where('id', $student->class_id)->first())->class_name ?? 'N/A' }}</b>
                        </div>
                        <div class="mb-2">Status: <span
                                class="badge bg-{{ $student->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($student->status) }}</span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Personal Information</h6>
                        <ul class="list-unstyled mb-3">
                            <li><b>Date of Birth:</b> {{ $student->dob }}</li>
                            <li><b>Gender:</b> {{ ucfirst($student->gender) }}</li>
                            <li><b>Blood Group:</b> {{ $student->blood_group }}</li>
                            <li><b>Religion:</b> {{ ucfirst($student->religion) }}</li>
                            <li><b>Address:</b> {{ $student->address }}</li>
                            <li><b>State:</b> {{ $student->state }}</li>
                            <li><b>Country:</b> {{ $student->country ?? 'Nigeria' }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="fw-semibold">Admission Details</h6>
                        <ul class="list-unstyled mb-3">
                            <li><b>Admission Date:</b> {{ $student->admission_date }}</li>
                            <li><b>Previous School:</b> {{ $student->previous_school }}</li>
                            <li><b>Role:</b> {{ $student->role }}</li>
                        </ul>
                        <h6 class="fw-semibold">Parent/Guardian</h6>
                        <ul class="list-unstyled mb-3">
                            <li><b>Name:</b> {{ $student->parent->fullname ?? 'N/A' }}</li>
                            <li><b>Contact:</b> {{ $student->parent->phone ?? 'N/A' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100 p-0 radius-12 overflow-hidden">
                    <div class="card-body p-24">
                        <h6 class="fw-semibold mb-3">Promotion History</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Previous Class</th>
                                        <th>Current Class</th>
                                        <th>Promotion Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($promotion_history as $index => $promotion)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ optional($classes->where('id', $promotion->previous_class_id)->first())->class_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ optional($classes->where('id', $promotion->current_class_id)->first())->class_name ?? 'N/A' }}
                                            </td>
                                            <td>{{ $promotion->promotion_date }}</td>


                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card h-100 p-0 radius-12 overflow-hidden">
                    <div class="card-body p-24">
                        <h6 class="fw-semibold mb-3">Payment Records</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Amount</th>
                                        <th>Purpose</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $paymentIndex = 1; @endphp
                                    @foreach ($payments as $payment)
                                        <tr>
                                            <td>{{ $paymentIndex++ }}</td>
                                            <td>{{ $payment->amount_paid }}</td>
                                            <td>{{ $payment->purpose ?? 'N/A' }}</td>
                                            <td>{{ $payment->created_at ? $payment->created_at->format('Y-m-d') : '' }}
                                            </td>
                                            <td>{{ ucfirst($payment->status ?? 'N/A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Student ID Card Modal -->
    <div class="modal fade" id="studentIdCardModal" tabindex="-1" aria-labelledby="studentIdCardModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="studentIdCardModalLabel">Student ID Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div id="idCardContainer" class="w-100 d-flex justify-content-center">
                        <div id="studentIdCard"
                            style="width:340px;min-height:420px;background:#f8f9fa;border-radius:16px;box-shadow:0 2px 12px #0001;padding:24px 16px;display:flex;flex-direction:column;align-items:center;gap:12px;">
                            <h5 class="mb-2 text-center" style="font-weight:700;">{{ $schoolinfo->school_name }}</h5>
                            <div
                                style="width:100px;height:100px;overflow:hidden;border-radius:50%;border:3px solid #007bff;display:flex;align-items:center;justify-content:center;background:#fff;">
                                @if ($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" alt="Photo"
                                        style="width:100px;height:100px;object-fit:cover;">
                                @else
                                    <div
                                        style="width:100px;height:100px;display:flex;align-items:center;justify-content:center;background:#6c757d;color:#fff;font-size:2.5rem;font-weight:700;">
                                        {{ strtoupper(substr($student->firstname, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2 text-center">
                                <div style="font-size:1.2rem;font-weight:600;">{{ $student->firstname }}
                                    {{ $student->middlename }} {{ $student->lastname }}</div>
                                <div style="font-size:1rem;">Reg No: <b>{{ $student->studentId }}</b></div>
                                <div style="font-size:1rem;">Class:
                                    <b>{{ optional($classes->where('id', $student->class_id)->first())->class_name ?? 'N/A' }}</b>
                                </div>
                                <div style="font-size:1rem;">DOB: <b>{{ $student->dob }}</b></div>
                                <hr class="text-danger fw-bold" style="border: 1px solid dashed #311316; margin: 10px 0;">
                                <div style="font-size:1rem;"><b>{{ $student->role }}</b></div>
                                <hr class="text-danger fw-bold" style="border: 1px solid dashed #311316; margin: 10px 0;">
                            </div>
                            <div class="mt-3 mb-2">
                                <canvas id="studentQrCode"></canvas>
                            </div>
                            <button id="downloadIdCardBtn" class="btn btn-outline-primary mt-2">Download as JPG</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <!-- QRious for QR code generation -->
    <script src="{{ asset('adminpage/assets/js/lib/qrious.min.js') }}"></script>
    <!-- html2canvas for JPG download -->
    <script src="{{ asset('adminpage/assets/js/lib/html2canvas.min.js') }}"></script>
    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });

        let table = new DataTable('.table-bordered', {
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'excel',
                'pdf',
                'print'
            ]
        });

        $(document).ready(function() {
            // QR code generation for reg no
            var qr = new QRious({
                element: document.getElementById('studentQrCode'),
                value: "{{ $student->studentId }}",
                size: 80,
                background: 'white',
                foreground: '#007bff',
                level: 'H'
            });

            // Download as JPG
            $('#downloadIdCardBtn').on('click', function() {
                $(this).hide();
                html2canvas(document.getElementById('studentIdCard')).then(function(canvas) {
                    var link = document.createElement('a');
                    link.download =
                        'student_id_card_{{ $student->firstname }}_{{ $student->admission_number }}.jpg';
                    link.href = canvas.toDataURL('image/jpeg', 0.95);
                    link.click();
                });
                $(this).show();
            });

            $('.form-delete').on('submit', function(e) {
                e.preventDefault();
                var form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

        });
    </script>
@endpush
