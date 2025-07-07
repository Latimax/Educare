@extends('student.layouts.cbt')

@section('title', 'CBT Test')

@push('styles')
    <style>
        body {
            overflow-x: hidden;
            overflow-y: auto;
        }

        .cbt-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .timer {
            color: #e01414;
            text-align: center;
            padding: 10px;
            font-size: 1.2em;
            font-weight: bold;
            z-index: 1000;
        }

        #time-remaining {
            font-size: 24px;
            font-weight: bold;
        }

        .question-card {
            background-color: #fff;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin-top: 60px;
        }

        .question-card.answered {
            border-color: #28a745;
        }

        .option-container {
            margin: 10px 0;
            display: flex;
            align-items: center;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .option-container.selected {
            background-color: #e7f3ff;
            border: 1px solid #007bff;
        }

        .option-container input[type="radio"] {
            margin-right: 10px;
            cursor: pointer;
            accent-color: #620cda;
        }

        .option-container input[type="radio"]:checked {
            background-color: #0f3fdc;
        }

        .option-container label {
            cursor: pointer;
            flex-grow: 1;
        }

        .question-nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }

        .question-nav-btn {
            width: 40px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            cursor: pointer;
        }

        .question-nav-btn.answered {
            background-color: #28a745;
            color: white;
        }

        .question-nav-btn.active {
            background-color: #007bff;
            color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        button.btn {
            font-weight: 600;
            font-size: 16px;
            padding: 10px 18px;
            border: none;
            border-radius: 10px;
            transition: background-color 0.2s ease, transform 0.1s ease;
            min-width: 120px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        button.btn:disabled {
            background-color: #cccccc !important;
            color: #666666 !important;
            cursor: not-allowed;
            box-shadow: none;
        }

        button.btn-primary {
            background-color: #007bff !important;
            color: #fff !important;
        }

        button.btn-primary:hover:not(:disabled) {
            background-color: #0056b3 !important;
            transform: scale(1.02);
        }

        button.btn-success {
            background-color: #28a745 !important;
            color: #fff !important;
        }

        button.btn-success:hover:not(:disabled) {
            background-color: #1e7e34;
            transform: scale(1.02);
        }
    </style>
@endpush

@section('content')
    <div class="cbt-container">
        <div class="question-card" id="question-card">
            <h4 class="fw-bold">Question <span id="current-question-number"></span></h4>
            <div id="question-text"></div>
            <div class="options">
                <div class="option-container" id="option-a-container">
                    <input type="radio" name="option" id="option-a-radio" value="A">
                    <label for="option-a-radio" id="option-a"></label>
                </div>
                <div class="option-container" id="option-b-container">
                    <input type="radio" name="option" id="option-b-radio" value="B">
                    <label for="option-b-radio" id="option-b"></label>
                </div>
                <div class="option-container" id="option-c-container">
                    <input type="radio" name="option" id="option-c-radio" value="C">
                    <label for="option-c-radio" id="option-c"></label>
                </div>
                <div class="option-container" id="option-d-container">
                    <input type="radio" name="option" id="option-d-radio" value="D">
                    <label for="option-d-radio" id="option-d"></label>
                </div>
            </div>
        </div>

        <div class="question-nav" id="question-nav"></div>

        <div class="action-buttons">
            <button class="btn btn-primary" id="prev-btn" disabled>Previous (P)</button>
            <button class="btn btn-primary" id="next-btn">Next (N)</button>
            <button class="btn btn-success" id="submit-btn">Submit (S)</button>
        </div>
    </div>

    <form action="{{ route('student.cbt.submit') }}" method="post" id="submitCbt">
        @csrf
        <input type="hidden" name="attempt_id" value="{{ $attempt->id }}">
    </form>
@endsection

@push('scripts')
    <!-- sweetalert2 -->
    <script src="{{ asset('adminpage/assets/js/sweetalert2@11.js') }}"></script>

    <script>
        const questions = @json($questions);
        const attempt = @json($attempt);
        const attemptJson = @json($attempt).questions;
        attempt.questions = Object.values(attempt.questions);
        let currentQuestionIndex = 0;
        let timeRemaining = {{ $remainingTime }};
        let timerInterval;
        let tabSwitchChances = 5; // Initialize tab switch chances
        let isSubmitting = false; // Flag to prevent beforeunload during form submission

        // 1. Join the array into a proper JSON string
        const jsonString = attempt.questions.join('');

        // 2. Parse it into a JavaScript array
        const qJson = JSON.parse(jsonString);

        // Initialize localStorage for this attempt
        const storageKey = `cbt_attempt_${attempt.id}`;

        function initLocalStorage() {
            const initialAnswers = {};
            questions.forEach(q => {
                const attemptQ = qJson.find(aq => aq.id === q.id);
                initialAnswers[q.id] = attemptQ?.selected_option || null;
            });
            localStorage.setItem(storageKey, JSON.stringify(initialAnswers));
        }

        // Get answers from localStorage
        function getStoredAnswers() {
            return JSON.parse(localStorage.getItem(storageKey)) || {};
        }

        // Save answer to localStorage
        function saveAnswer(questionId, selectedOption) {
            const answers = getStoredAnswers();
            answers[questionId] = selectedOption;
            localStorage.setItem(storageKey, JSON.stringify(answers));
        }

        // Prevent tab switching with SweetAlert2 and track chances
        $(document).on('visibilitychange', function() {
            if (document.hidden && !isSubmitting) {
                tabSwitchChances--;
                if (tabSwitchChances > 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Cheating Detected',
                        text: `Switching tabs is not allowed during the test! You have ${tabSwitchChances} chance${tabSwitchChances === 1 ? '' : 's'} remaining.`,
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Cheating Limit Reached',
                        text: 'You have exceeded the allowed tab switches. Your test will now be submitted.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        submitTest();
                    });
                }
            }
        });

        // Disable right-click and shortcuts
        $(document).on('contextmenu', function(e) {
            e.preventDefault();
        });

        $(document).on('keydown', function(e) {
            if (e.ctrlKey || e.altKey) {
                e.preventDefault();
            }
        });

        // Timer function
        function startTimer() {
            timerInterval = setInterval(() => {
                timeRemaining = Math.floor(timeRemaining);
                timeRemaining--;

                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;

                $('#time-remaining').text(
                    String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0')
                );

                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    submitTest();
                }
            }, 1000);
        }

        // Load question
        function loadQuestion(index) {
            const question = questions[index];
            const attemptQuestion = attempt.questions.find(q => q.id === question.id);
            const storedAnswers = getStoredAnswers();

            $('#current-question-number').text(index + 1);
            $('#question-text').html(question.question);
            $('#option-a').html(question.option_a);
            $('#option-b').html(question.option_b);
            $('#option-c').html(question.option_c);
            $('#option-d').html(question.option_d);

            // Update radio button states and highlight selected option
            $('input[name="option"]').prop('checked', false);
            $('.option-container').removeClass('selected');
            const selectedOption = storedAnswers[question.id] || (attemptQuestion && attemptQuestion.selected_option);
            if (selectedOption) {
                $(`#option-${selectedOption.toLowerCase()}-radio`).prop('checked', true);
                $(`#option-${selectedOption.toLowerCase()}-container`).addClass('selected');
            }

            $('.question-nav-btn').each(function(i) {
                $(this).removeClass('active');
                if (i === index) $(this).addClass('active');
                const q = questions[i];
                $(this).toggleClass('answered', !!storedAnswers[q.id]);
            });

            $('#prev-btn').prop('disabled', index === 0);
            $('#next-btn').prop('disabled', index === questions.length - 1);

            $('#question-card').toggleClass('answered', !!storedAnswers[question.id]);
        }

        // Navigation buttons
        $('#prev-btn').on('click', function() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                loadQuestion(currentQuestionIndex);
            }
        });

        $('#next-btn').on('click', function() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                loadQuestion(currentQuestionIndex);
            }
        });

        // Option selection
        $('input[name="option"]').on('change', function() {
            const questionId = questions[currentQuestionIndex].id;
            const selectedOption = $(this).val();

            // Update highlight
            $('.option-container').removeClass('selected');
            $(`#option-${selectedOption.toLowerCase()}-container`).addClass('selected');

            // Save to localStorage
            saveAnswer(questionId, selectedOption);

            $.ajax({
                url: '{{ route('student.cbt.update-option') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                contentType: 'application/json',
                data: JSON.stringify({
                    attempt_id: attempt.id,
                    question_id: questionId,
                    selected_option: selectedOption
                }),
                success: function(response) {
                },
                error: function(xhr) {
                    console.error('Error updating option:', xhr.responseText);
                }
            });

            attempt.questions[currentQuestionIndex].selected_option = selectedOption;
        });

        // Setup navigation
        function setupNavigation() {
            const $nav = $('#question-nav');
            questions.forEach((_, index) => {
                const $btn = $('<button>')
                    .addClass('question-nav-btn')
                    .text(index + 1)
                    .on('click', function() {
                        currentQuestionIndex = index;
                        loadQuestion(currentQuestionIndex);
                    });
                $nav.append($btn);
            });
        }

        // Submit test
        function submitTest() {
            // Clear localStorage on submit
            localStorage.removeItem(storageKey);
            isSubmitting = true; // Set flag to prevent beforeunload
            $("#submitCbt").submit();
        }

        $('#submit-btn').on('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Submit Test',
                text: 'Are you sure you want to submit your test? This action cannot be undone.',
                showCancelButton: true,
                confirmButtonText: 'Yes, Submit',
                cancelButtonText: 'Cancel',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then((result) => {
                if (result.isConfirmed) {
                    submitTest();
                }
            });
        });

        // Keyboard shortcuts
        $(document).on('keydown', function(e) {
            switch (e.key.toUpperCase()) {
                case 'P':
                    $('#prev-btn').click();
                    break;
                case 'N':
                    $('#next-btn').click();
                    break;
                case 'A':
                case 'B':
                case 'C':
                case 'D':
                    $(`#option-${e.key.toLowerCase()}-radio`).prop('checked', true).trigger('change');
                    break;
                case 'S':
                    $('#submit-btn').click();
                    break;
            }
        });

        // Initialize on window load
        $(window).on('load', function() {
            initLocalStorage();
            setupNavigation();
            loadQuestion(currentQuestionIndex);
            startTimer();
        });

        // Prevent navigation except during form submission
        $(window).on('beforeunload', function(e) {
            if (!isSubmitting) {
                e.preventDefault();
                e.returnValue = 'Are you sure you want to leave? Your test progress may be lost.';
            }
        });
    </script>
@endpush
