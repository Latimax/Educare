@extends('admin.layouts.app')

@section('title', 'Create New Payment')

@push('styles')
    <!-- CSS for Autocomplete Suggestions -->
    <style>
        .autocomplete-suggestions {
            position: absolute;
            width: 100%;
            max-height: 230px;
            overflow-y: auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .06);
            z-index: 99999;
            display: none;
        }

        .autocomplete-suggestion {
            padding: 10px 15px;
            cursor: pointer;
        }

        .autocomplete-suggestion:hover,
        .autocomplete-suggestion.active {
            background: #f7f7f7;
        }
    </style>
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Payments</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">New Payment</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Create New Payment</h5>
                <a href="{{ route('admin.payments.index') }}"
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
                <form action="{{ route('admin.payments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <!-- Student (Autocomplete) -->
                        <div class="col-sm-6 mb-20 position-relative" style="z-index: 9;">
                            <label for="student_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Student <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('student_name') is-invalid @enderror"
                                id="student_name" name="student_name" placeholder="Type student name (first middle last)"
                                autocomplete="off" value="{{ old('student_name') }}" required>
                            <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">
                            <!-- Suggestions will appear here -->
                            <div id="student_suggestions" class="autocomplete-suggestions"></div>
                            @error('student_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div class="col-sm-6 mb-20">
                            <label for="amount_paid" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Amount <span class="text-danger-600">*</span>
                            </label>
                            <input type="number" class="form-control radius-8 @error('amount_paid') is-invalid @enderror"
                                id="amount_paid" name="amount_paid" placeholder="Enter Amount" value="{{ old('amount_paid') }}">
                            @error('amount_paid')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div class="col-sm-6 mb-20">
                            <label for="payment_method" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Payment Method <span class="text-danger-600">*</span>
                            </label>
                            <select name="payment_method" id="payment_method"
                                class="form-select radius-8 @error('payment_method') is-invalid @enderror">
                                <option value="">-- Select Type --</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank Transfer
                                </option>
                                <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                            </select>
                            @error('payment_method')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Date -->
                        <div class="col-sm-6 mb-20">
                            <label for="payment_date" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Payment Date <span class="text-danger-600">*</span>
                            </label>
                            <input type="date" class="form-control radius-8 @error('payment_date') is-invalid @enderror"
                                id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}">
                            @error('payment_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Purpose -->
                        <div class="col-sm-6 mb-20">
                            <label for="purpose" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Purpose <span class="text-danger-600">*</span>
                            </label>
                            <input type="text" class="form-control radius-8 @error('purpose') is-invalid @enderror"
                                id="purpose" name="purpose" placeholder="Enter Purpose" value="{{ old('purpose') }}">
                            @error('purpose')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Balance -->
                        <div class="col-sm-6 mb-20">
                            <label for="balance" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Balance
                            </label>
                            <input type="number" class="form-control radius-8 @error('balance') is-invalid @enderror"
                                id="balance" name="balance" placeholder="Enter Balance" value="{{ old('balance') }}">
                            @error('balance')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Paid By -->
                        <div class="col-sm-6 mb-20">
                            <label for="paid_by" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Paid By
                            </label>
                            <input type="text" class="form-control radius-8 @error('paid_by') is-invalid @enderror"
                                id="paid_by" name="paid_by" placeholder="Enter Payer's Name"
                                value="{{ old('paid_by') }}">
                            @error('paid_by')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Received By -->
                        <div class="col-sm-6 mb-20">
                            <label for="received_by" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Received By
                            </label>
                            <input type="text" class="form-control radius-8 @error('received_by') is-invalid @enderror"
                                id="received_by" name="received_by" placeholder="Enter Receiver's Name"
                                value="{{ old('received_by') }}">
                            @error('received_by')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <!-- Receipt Number -->
                        <div class="col-sm-3 mb-20">
                            <label for="receipt_number" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Receipt Number
                            </label>
                            <input type="text"
                                class="form-control radius-8 @error('receipt_number') is-invalid @enderror"
                                id="receipt_number" name="receipt_number" placeholder="Enter Receipt Number"
                                value="{{ old('receipt_number') }}">
                            @error('receipt_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                          <!-- Status -->
                        <div class="col-sm-3 mb-20">
                            <label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Status <span class="text-danger-600">*</span>
                            </label>
                            <select name="status" id="status"
                                class="form-select radius-8 @error('status') is-invalid @enderror">
                                <option value="">-- Select Status --</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Session (Readonly) -->
                        <div class="col-sm-3 mb-20">
                            <label for="session" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Session
                            </label>
                            <input type="text" class="form-control radius-8" id="session" name="session"
                                value="{{ $schoolinfo->current_session }}" readonly>
                        </div>

                        <!-- Term (Readonly) -->
                        <div class="col-sm-3 mb-20">
                            <label for="term" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Term
                            </label>
                            <input type="text" class="form-control radius-8" id="term" name="term"
                                value="{{ $schoolinfo->current_term }}" readonly>
                        </div>

                        <!-- Notes -->
                        <div class="col-sm-12 mb-20">
                            <label for="notes" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                Notes
                            </label>
                            <textarea name="notes" id="notes" class="form-control radius-8 @error('notes') is-invalid @enderror"
                                placeholder="Enter any notes">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-20">
                        <button type="submit" class="btn btn-primary radius-8 px-24 py-12">Create Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @push('scripts')
        <script>
            $(function() {
                let $input = $('#student_name');
                let $suggestions = $('#student_suggestions');
                let $student_id = $('#student_id');
                let typingTimeout = null;

                $input.on('input', function() {
                    clearTimeout(typingTimeout);
                    let query = $(this).val().trim();
                    $student_id.val(''); // clear any previously selected ID
                    if (query.length < 1) {
                        $suggestions.hide().empty();
                        return;
                    }
                    typingTimeout = setTimeout(function() {
                        $.ajax({
                            url: "{{ route('admin.students.byname.search') }}",
                            data: {
                                q: query
                            },
                            type: 'GET',
                            dataType: 'json',

                            success: function(data) {
                                if (Array.isArray(data) && data.length) {
                                    $suggestions.html(
                                        data.map(function(student) {
                                            return `<div class="autocomplete-suggestion" data-id="${student.id}" data-name="${student.fullname}">
                                                    ${student.fullname} <small>(${student.id || ''})</small>
                                                </div>`;
                                        }).join('')
                                    ).show();
                                } else {
                                    $suggestions.html(
                                        '<div class="autocomplete-suggestion text-muted">No matches found</div>'
                                        ).show();
                                }
                            }
                        });
                    }, 210); // slight delay to reduce requests
                });

                // Select student
                $suggestions.on('click', '.autocomplete-suggestion', function() {
                    let name = $(this).data('name');
                    let id = $(this).data('id');
                    $input.val(name);
                    $student_id.val(id);
                    $suggestions.hide().empty();
                });

                // Hide suggestions on blur (with delay to allow click)
                $input.on('blur', function() {
                    setTimeout(function() {
                        $suggestions.hide().empty();
                    }, 175);
                });

                // Optional: up/down key navigation support
                $input.on('keydown', function(e) {
                    let $items = $suggestions.find('.autocomplete-suggestion');
                    if (!$suggestions.is(':visible') || !$items.length) return;
                    let idx = $items.index($items.filter('.active'));
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        let next = (idx + 1) % $items.length;
                        $items.removeClass('active').eq(next).addClass('active').focus();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        let prev = (idx - 1 + $items.length) % $items.length;
                        $items.removeClass('active').eq(prev).addClass('active').focus();
                    } else if (e.key === 'Enter') {
                        if (idx >= 0) {
                            e.preventDefault();
                            $items.eq(idx).trigger('click');
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
