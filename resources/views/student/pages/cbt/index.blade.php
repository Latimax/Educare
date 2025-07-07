@extends('student.layouts.app')

@section('title', 'CBT Subjects')

@push('styles')


 <link href="{{ asset('studentpage/css/instructor-dashboard.css') }}" rel="stylesheet">
 <link href="{{ asset('studentpage/css/instructor-responsive.css') }}" rel="stylesheet">

    <style>
        .proceed-btn {
            background-color: #AF1F24;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }

        .proceed-btn:hover {
            background-color: #ffffff;
            color: white;
            text-decoration: none;
            border: 1px solid #AF1F24;
            border-radius: 4px;
            transition: 0.4s ease;
        }

        .disabled-link {
            pointer-events: none;
            opacity: 0.5;
            cursor: not-allowed;
        }

        .card-disabled {
            pointer-events: none;
            opacity: 0.5;
            background-color: #f8f9fa;
            /* Optional: light gray to indicate disabled */
        }
    </style>
@endpush

@section('content')
    <div class="sa4d25">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-8">
                    <div class="section3125">
                        <div class="explore_search">
                            <div class="ui search focus">
                                <div class="ui left icon input swdh11">
                                    <input class="prompt srch_explore" type="text" placeholder="Search Subjects...">
                                    <i class="uil uil-search-alt icon icon2"></i>
                                </div>
                            </div>
                        </div>
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

                <div class="col-md-12">
                    <div class="_14d25">
                        <div class="row">
                            @forelse ($subjects as $subject)
                                <div class="col-lg-4 col-md-6 mb-4 d-flex justify-content-center pt-3">
                                    <div class="card border-0 text-center p-4 w-100">
                                        <div class="mx-auto bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mb-3"
                                            style="width: 120px; height: 120px; font-size: 2.5rem;">
                                            {{ substr($subject->subject_name, 0, 1) }}
                                        </div>
                                        <div class="card-body {{ $subject->status != 'active' ? 'card-disabled' : '' }}">
                                            <h5 class="card-title text-primary mb-1">{{ $subject->subject_name }}</h5>
                                            <p class="text-muted mb-3">
                                                {{ $subject->status != 'active' ? 'This subject is disabled' : 'Subject' }}
                                            </p>
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ $cbt_configs->ft_status == '1' ? 'cbt/ft/' . $subject->id . '/instructions' : '#' }}"
                                                    class="proceed-btn {{ $cbt_configs->ft_status == '1' ? '' : 'disabled-link' }}"
                                                    title="Proceed"
                                                    {{ $cbt_configs->ft_status == '1' ? '' : 'tabindex=-1 aria-disabled=true data-bs-toggle=tooltip title=This test is not active yet' }}>
                                                    1st Test
                                                </a>

                                                <a href="{{ $cbt_configs->st_status == '1' ? 'cbt/st/' . $subject->id . '/instructions' : '#' }}"
                                                    class="proceed-btn {{ $cbt_configs->st_status == '1' ? '' : 'disabled-link' }}"
                                                    title="Proceed"
                                                    {{ $cbt_configs->st_status == '1' ? '' : 'tabindex=-1 aria-disabled=true data-bs-toggle=tooltip title=This test is not active yet' }}>
                                                    2nd Test
                                                </a>

                                                <a href="{{ $cbt_configs->exam_status == '1' ? 'cbt/exam/' . $subject->id . '/instructions' : '#' }}"
                                                    class="proceed-btn {{ $cbt_configs->exam_status == '1' ? '' : 'disabled-link' }}"
                                                    title="Proceed"
                                                    {{ $cbt_configs->exam_status == '1' ? '' : 'tabindex=-1 aria-disabled=true data-bs-toggle=tooltip title=Examination not active' }}>
                                                    Examination
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <div class="text-center mt-50">
                                        <p>No subjects available.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('.srch_explore');
            const subjectCards = document.querySelectorAll('.col-lg-4.col-md-6');

            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();

                subjectCards.forEach(card => {
                    const subjectName = card.querySelector('.card-title');

                    if (subjectName) {
                        const name = subjectName.textContent.toLowerCase();

                        if (query === '' || name.includes(query)) {
                            card.style.visibility = 'visible';
                            card.style.opacity = '1';
                            card.style.position = 'relative';
                        } else {
                            card.style.visibility = 'hidden';
                            card.style.opacity = '0';
                            card.style.position = 'absolute';
                        }
                    }
                });
            });
        });

        $('.remove-button').on('click', function() {
            $(this).closest('.alert').addClass('d-none');
        });
    </script>
@endpush
