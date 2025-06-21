@extends('admin.layouts.app')

@section('title', 'Staff Profile')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/audioplayer.css') }}">
@endpush

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Staff Profile</h6>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.staffs.edit', $staff->id) }}" class="btn btn-primary">Edit Profile</a>
            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#staffIdCardModal">
                Show Staff ID Card
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
                    @if($staff->photo)
                        <img src="{{ asset('storage/' . $staff->photo) }}" alt="Photo" class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <span class="text-white fs-1">{{ strtoupper(substr($staff->fullname,0,1)) }}</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-10">
                    <h4 class="fw-bold mb-1">{{ $staff->fullname }}</h4>
                    <div class="mb-2 text-muted">Position: <b>{{ $staff->position }}</b></div>
                    <div class="mb-2">User Type: <b>{{ ucfirst($staff->user_type) }}</b></div>
                    <div class="mb-2">Status: <span class="badge bg-{{ $staff->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($staff->status) }}</span></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-semibold">Personal Information</h6>
                    <ul class="list-unstyled mb-3">
                        <li><b>Email:</b> {{ $staff->email }}</li>
                        <li><b>Phone:</b> {{ $staff->phone }}</li>
                        <li><b>Date of Birth:</b> {{ $staff->dob }}</li>
                        <li><b>Gender:</b> {{ ucfirst($staff->gender) }}</li>
                        <li><b>State:</b> {{ $staff->state }}</li>
                        <li><b>Country:</b> {{ $staff->country }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-semibold">Employment Details</h6>
                    <ul class="list-unstyled mb-3">
                        <li><b>Employment Date:</b> {{ $staff->employment_date }}</li>
                        <li><b>Highest Qualification:</b> {{ $staff->highest_qualification }}</li>
                        <li><b>Subject Specialty:</b> {{ $staff->subject_specialty }}</li>
                        <li><b>Department (Level):</b> {{ optional($levels->where('id', $staff->department)->first())->level_name ?? 'N/A' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden mb-4">
        <div class="card-body p-24">
            <h6 class="fw-semibold mb-3">Subjects Assigned</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Subject Name</th>
                            <th>Class</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $subjectIndex = 1; @endphp
                        @forelse($subjects as $subject)
                            <tr>
                                <td>{{ $subjectIndex++ }}</td>
                                <td>{{ $subject->subject_name }}</td>
                                <td>{{ $subject->level->level_name ?? 'N/A' }}</td>
                                <td>{{ $subject->status ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center">No subjects assigned.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Staff ID Card Modal -->
    <div class="modal fade" id="staffIdCardModal" tabindex="-1" aria-labelledby="staffIdCardModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title w-100 text-center" id="staffIdCardModalLabel">Staff ID Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <div id="idCardContainer" class="w-100 d-flex justify-content-center">
                        <div id="staffIdCard" style="width:340px;min-height:420px;background:#f8f9fa;border-radius:16px;box-shadow:0 2px 12px #0001;padding:24px 16px;display:flex;flex-direction:column;align-items:center;gap:12px;">
                            <h5 class="mb-2 text-center" style="font-weight:700;">{{ $schoolinfo->school_name }}</h5>
                            <div style="width:100px;height:100px;overflow:hidden;border-radius:50%;border:3px solid #007bff;display:flex;align-items:center;justify-content:center;background:#fff;">
                                @if($staff->photo)
                                    <img src="{{ asset('storage/' . $staff->photo) }}" alt="Photo" style="width:100px;height:100px;object-fit:cover;">
                                @else
                                    <div style="width:100px;height:100px;display:flex;align-items:center;justify-content:center;background:#6c757d;color:#fff;font-size:2.5rem;font-weight:700;">
                                        {{ strtoupper(substr($staff->fullname,0,1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2 text-center">
                                <div style="font-size:1.2rem;font-weight:600;">{{ $staff->fullname }}</div>
                                <div style="font-size:1rem;">Staff ID: <b>{{ $staff->staffId ?? $staff->id }}</b></div>
                                <div style="font-size:1rem;">Position: <b>{{ $staff->position }}</b></div>
                                <div style="font-size:1rem;">DOB: <b>{{ $staff->dob }}</b></div>
                                <hr class="text-danger fw-bold" style="border: 1px solid dashed #311316; margin: 10px 0;">
                                <div style="font-size:1rem;"><b>{{ ucfirst($staff->user_type) }}</b></div>
                                <hr class="text-danger fw-bold" style="border: 1px solid dashed #311316; margin: 10px 0;">
                            </div>
                            <div class="mt-3 mb-2">
                                <canvas id="staffQrCode"></canvas>
                            </div>
                            <button id="downloadIdCardBtn" class="btn btn-outline-primary mt-2">Download as JPG</button>
                        </div>
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

        let table = new DataTable('#dataTable', {
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'excel',
                'pdf',
                'print'
            ]
        });

        $(document).ready(function() {
            // QR code generation for staff ID
            var qr = new QRious({
                element: document.getElementById('staffQrCode'),
                value: "{{ $staff->staffId ?? $staff->id }}",
                size: 80,
                background: 'white',
                foreground: '#007bff',
                level: 'H'
            });

            // Download as JPG
            $('#downloadIdCardBtn').on('click', function() {
                $(this).hide();
                html2canvas(document.getElementById('staffIdCard')).then(function(canvas) {
                    var link = document.createElement('a');
                    link.download = 'staff_id_card_{{ $staff->fullname }}_{{ $staff->staff_id ?? $staff->id }}.jpg';
                    link.href = canvas.toDataURL('image/jpeg', 0.95);
                    link.click();
                });
                $(this).show();
            });
        });
    </script>
@endpush
