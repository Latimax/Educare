@extends('admin.layouts.app')

@section('title', 'Advanced Settings | Admin')

@php
    // Check if the request has an 'activeTab' parameter
    $activeTab = session('activeTab') ? session('activeTab') : 'promotion';
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/toastr.min.css') }}">
    <style>
        .countdown-timer {
            display: none;
            color: red;
            font-weight: bold;
        }

        .disabled-button {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
@endpush

@section('content')

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Advanced Settings</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Advanced Settings</li>
            </ul>
        </div>

        @if (session('success'))
            <div class="alert alert-info my-4 bg-success-100 text-success-600 border-success-600 border-start-width-4-px border-top-0 border-end-0 border-bottom-0 px-24 py-13 mb-0 fw-semibold text-lg radius-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div class="d-flex align-items-center gap-2">
                    <iconify-icon icon="mingcute:emoji-line" class="icon text-xl"></iconify-icon>
                    {{ session('success') }}
                </div>
                <button class="remove-button text-success-600 text-xxl line-height-1">
                    <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                </button>
            </div>
        @endif

        <div class="row gy-4">
            <div class="col-lg-12">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'promotion' ? 'active' : '' }}"
                                    id="pills-promotion-tab" data-bs-toggle="pill" data-bs-target="#pills-promotion"
                                    type="button" role="tab" aria-controls="pills-promotion"
                                    aria-selected="{{ $activeTab == 'promotion' ? 'true' : 'false' }}">
                                    Student Promotion
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'delete-questions' ? 'active' : '' }}"
                                    id="pills-delete-questions-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-delete-questions" type="button" role="tab"
                                    aria-controls="pills-delete-questions"
                                    aria-selected="{{ $activeTab == 'delete-questions' ? 'true' : 'false' }}"
                                    tabindex="-1">
                                    Delete CBT Questions
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link d-flex align-items-center px-24 {{ $activeTab == 'delete-results' ? 'active' : '' }}"
                                    id="pills-delete-results-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-delete-results" type="button" role="tab"
                                    aria-controls="pills-delete-results"
                                    aria-selected="{{ $activeTab == 'delete-results' ? 'true' : 'false' }}" tabindex="-1">
                                    Delete Results & Scores
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                            <!-- Student Promotion Tab -->
                            <div class="tab-pane fade {{ $activeTab == 'promotion' ? 'show active' : '' }}"
                                id="pills-promotion" role="tabpanel" aria-labelledby="pills-promotion-tab" tabindex="0">
                                <div class="alert alert-warning mb-20">
                                    <strong>Warning:</strong> Promoting students is a critical action that may delete data.
                                    Please proceed with caution.
                                </div>
                                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#promotionModal">
                                    Initiate Student Promotion
                                </button>

                                <!-- Promotion Modal -->
                                <div class="modal fade" id="promotionModal" tabindex="-1"
                                    aria-labelledby="promotionModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="promotionModalLabel">Student Promotion Options
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="promotionForm" action="{{ route('admin.advanced.promote') }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('POST')
                                                    <p class="text-danger mb-3">Please select an option for promoting
                                                        students:</p>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            name="promotion_option" id="option1" value="full_promotion"
                                                            required>
                                                        <label class="form-check-label" for="option1">
                                                            Begin a new academic term by advancing students to the next
                                                            level. This action will permanently erase all exam questions,
                                                            student scores, and historical results to start afresh.
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            name="promotion_option" id="option2"
                                                            value="partial_promotion">
                                                        <label class="form-check-label" for="option2">
                                                            Advance students to the next level while retaining existing exam
                                                            questions for reuse. Only student results and scores will be
                                                            deleted to prepare for the new term.
                                                        </label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input class="form-check-input" type="radio"
                                                            name="promotion_option" id="option3"
                                                            value="export_promotion">
                                                        <label class="form-check-label" for="option3">
                                                            Promote students and archive all current exam questions, scores,
                                                            and results. This creates a backup for future reference while
                                                            clearing active data for the new term.
                                                        </label>
                                                    </div>
                                                    <div class="countdown-timer mt-3" id="countdownTimer">Please wait
                                                        <span id="countdown">10</span> seconds...
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" form="promotionForm"
                                                    class="btn btn-danger disabled-button" id="confirmPromotion"
                                                    disabled>Agree & Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete CBT Questions Tab -->
                            <div class="tab-pane fade {{ $activeTab == 'delete-questions' ? 'show active' : '' }}"
                                id="pills-delete-questions" role="tabpanel" aria-labelledby="pills-delete-questions-tab"
                                tabindex="0">
                                <div class="alert alert-warning mb-20">
                                    <strong>Warning:</strong> Deleting CBT questions is irreversible. Ensure you have a
                                    backup if needed.
                                </div>
                                <form action="{{ route('admin.advanced.delete-questions') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="mb-20">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Select Question Types to Delete
                                        </label>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="delete_cbt_questions"
                                                id="delete_cbt_questions">
                                            <label class="form-check-label" for="delete_cbt_questions">
                                                Delete CBT Questions
                                            </label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="delete_exam_questions"
                                                id="delete_exam_questions">
                                            <label class="form-check-label" for="delete_exam_questions">
                                                Delete Exam Questions
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-danger text-md px-56 py-12 radius-8">
                                            Delete Selected Questions
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Delete Results & Scores Tab -->
                            <div class="tab-pane fade {{ $activeTab == 'delete-results' ? 'show active' : '' }}"
                                id="pills-delete-results" role="tabpanel" aria-labelledby="pills-delete-results-tab"
                                tabindex="0">
                                <div class="alert alert-warning mb-20">
                                    <strong>Warning:</strong> Deleting student results and scores is irreversible. Ensure
                                    you have a backup if needed.
                                </div>
                                <form action="{{ route('admin.advanced.delete-results') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <div class="mb-20">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Select Data to Delete
                                        </label>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="delete_computed_results"
                                                id="delete_computed_results">
                                            <label class="form-check-label" for="delete_computed_results">
                                                Delete Computed Result
                                            </label>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" name="delete_student_scores"
                                                id="delete_student_scores">
                                            <label class="form-check-label" for="delete_student_scores">
                                                Delete All Student Scores
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <a href="{{ route('admin.dashboard') }}"
                                            class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-danger text-md px-56 py-12 radius-8">
                                            Delete Selected Data
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/lib/toastr.min.js') }}"></script>
    <script>
        // Close alert
        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });

        // Countdown timer for promotion modal
        $('#promotionModal').on('shown.bs.modal', function() {
            let countdown = 10;
            const countdownTimer = $('#countdownTimer');
            const confirmButton = $('#confirmPromotion');
            countdownTimer.show();

            const timer = setInterval(function() {
                countdown--;
                $('#countdown').text(countdown);
                if (countdown <= 0) {
                    clearInterval(timer);
                    countdownTimer.hide();
                    confirmButton.removeClass('disabled-button').prop('disabled', false);
                }
            }, 1000);
        });

        // Reset countdown on modal close
        $('#promotionModal').on('hidden.bs.modal', function() {
            $('#countdown').text('10');
            $('#countdownTimer').hide();
            $('#confirmPromotion').addClass('disabled-button').prop('disabled', true);
            $('#promotionForm')[0].reset();
        });

        // AJAX for promotion submission
        $('#promotionForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "3000"
                    };
                    toastr.success(response.message || 'Promotion completed successfully!');
                    $('#promotionModal').modal('hide');
                },
                error: function(xhr) {
                    toastr.error(xhr.message);
                }
            });
        });

        // AJAX for deleting questions
        $('#pills-delete-questions form').on('submit', function(e) {
            e.preventDefault();

            const form = this;

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
                    $.ajax({
                        url: "{{ route('admin.advanced.delete-questions') }}",
                        method: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            toastr.success(response.message ||
                                'Questions deleted successfully!');
                        },
                        error: function(xhr) {
                            console.log(xhr);
                            toastr.error('Failed to delete questions. Please try again.');
                        }
                    });
                }
            });
        });


        // AJAX for deleting results with SweetAlert confirmation
        $('#pills-delete-results form').on('submit', function(e) {
            e.preventDefault();

            const form = this; // Save reference to form

            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete the selected results and scores. This action is irreversible!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete them!'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: $(form).attr('action'),
                        method: 'POST',
                        data: $(form).serialize(),
                        success: function(response) {
                            toastr.success(response.message ||
                                'Results and scores deleted successfully!');
                        },
                        error: function(xhr) {
                            toastr.error('Failed to delete results. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@endpush
