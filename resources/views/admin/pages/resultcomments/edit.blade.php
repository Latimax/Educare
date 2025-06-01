@extends('admin.layouts.app')

@section('title', 'Edit Comment')

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Comments</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Edit Comment</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Edit Comment</h5>
                <a href="{{ route('admin.resultcomments.index') }}"
                    class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center gap-2">
                    <iconify-icon icon="icons8:left-round" class="text-xl"></iconify-icon> Back
                </a>
            </div>

            @if (session('success'))
                <div class="alert alert-success my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px px-24 py-13 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
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

            <div class="card-body">
                <!-- Edit Comment Form -->
                <form action="{{ route('admin.resultcomments.update', $comment->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Comment -->
                        <div class="col-sm-12 mb-20">
                            <label for="comment" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Comment <span class="text-danger-600">*</span>
                            </label>
                            <textarea class="form-control radius-8 @error('comment') is-invalid @enderror" id="comment" name="comment"
                                placeholder="Enter Comment" rows="4">{{ old('comment', $comment->comment) }}</textarea>

                            @error('comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Grade -->
                        <div class="col-sm-12 mb-20">
                            <label for="grade_id" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Grade <span class="text-danger-600">*</span>
                            </label>
                            <select name="grade_id" id="grade_id"
                                class="form-select radius-8 @error('grade_id') is-invalid @enderror">
                                <option value="">-- Select Grade --</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}"
                                        {{ old('grade_id', $comment->grade_id) == $grade->id ? 'selected' : '' }}>
                                        {{ $grade->grade_name }}</option>
                                @endforeach
                            </select>
                            @error('grade_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Comment</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });
    </script>
@endpush
