@extends('admin.layouts.app')

@section('title', 'Parent Profile')

@section('content')
<div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <h6 class="fw-semibold mb-0">Parent Profile</h6>
        <a href="{{ route('admin.parents.edit', $parent->id) }}" class="btn btn-primary">Edit Profile</a>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden mb-4">
        <div class="card-body p-40">
            <div class="row align-items-center">
                <div class="col-md-2 text-center mb-3 mb-md-0">
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                        <span class="text-white fs-1">{{ strtoupper(substr($parent->fullname,0,1)) }}</span>
                    </div>
                </div>
                <div class="col-md-10">
                    <h4 class="fw-bold mb-1">{{ $parent->fullname }}</h4>
                    <div class="mb-2 text-muted">{{ ucfirst($parent->relationship) }}</div>
                    <div class="mb-2">Phone: <b>{{ $parent->phone }}</b></div>
                    <div class="mb-2">Email: <b>{{ $parent->email ?? 'N/A' }}</b></div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <h6 class="fw-semibold">Personal Information</h6>
                    <ul class="list-unstyled mb-3">
                        <li><b>Occupation:</b> {{ $parent->occupation }}</li>
                        <li><b>State:</b> {{ $parent->state }}</li>
                        <li><b>Nationality:</b> {{ $parent->nationality }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6 class="fw-semibold">Other Details</h6>
                    <ul class="list-unstyled mb-3">
                        <li><b>Relationship:</b> {{ ucfirst($parent->relationship) }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="card h-100 p-0 radius-12 overflow-hidden mb-4">
        <div class="card-body p-24">
            <h6 class="fw-semibold mb-3">Children</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Class</th>
                            <th>Admission No</th>
                            <th>Status</th>
                            <th>Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $childIndex = 1; @endphp
                        @forelse($children as $child)
                            <tr>
                                <td>{{ $childIndex++ }}</td>
                                <td>{{ $child->firstname }} {{ $child->middlename }} {{ $child->lastname }}</td>
                                <td>{{ $child->studentClass->class_name ?? 'N/A' }}</td>
                                <td>{{ $child->admission_number }}</td>
                                <td><span class="badge bg-{{ $child->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($child->status) }}</span></td>
                                <td><a href="{{ route('admin.students.show', $child->id) }}" class="btn btn-sm btn-info">View</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center">No children found for this parent.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });
        let table = new DataTable('#dataTable');


        $(document).ready(function() {
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

