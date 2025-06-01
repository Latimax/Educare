@extends('admin.layouts.app')

@section('title', 'All Subjects')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/toastr.min.css') }}">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Subjects</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Subjects</li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">All Subjects</h5>
                <h5 class="card-title mb-0">
                    <div class="row">
                        <div class="col-12 mb-20">
                            @if (isset($subjects) || isset($classes))
                                <a href="{{ route('admin.examquestions.index') }}"
                                    class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center">
                                    <iconify-icon icon="icons8:left-round" class="text-xl"></iconify-icon> Back
                                </a>
                            @endif
                        </div>
                    </div>
                </h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                            <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                                <h6 class="text-lg mb-0">Subjects</h6>
                            </div>
                            <div class="card-body p-24 pt-10">
                                <div class="d-flex align-items-start">
                                    <ul class="nav button-tab nav-pills mb-16 flex-column me-3" id="subject-tab"
                                        role="tablist">
                                        @foreach ($subjects as $i => $subject)
                                            <li class="nav-item" role="presentation">
                                                <button
                                                    class="nav-link fw-semibold text-primary-light radius-4 px-16 py-10 @if ($i === 0) active @endif"
                                                    id="subject-tab-{{ $subject->id }}" data-bs-toggle="pill"
                                                    data-bs-target="#subject-content" type="button" role="tab"
                                                    aria-controls="subject-content"
                                                    aria-selected="{{ $i === 0 ? 'true' : 'false' }}"
                                                    data-subject-id="{{ $subject->id }}"
                                                    data-class-id="{{ $classId }}">{{ $subject->subject_name }}</button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="tab-content flex-grow-1" id="subject-tabContent">
                                        <div class="tab-pane fade show active" id="subject-content" role="tabpanel"
                                            aria-labelledby="subject-tab" tabindex="0">
                                            <form method="POST" action="{{ route('admin.examquestions.subjects.save') }}"
                                                id="subject-form" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="subject_id" id="subject-id"
                                                    value="{{ $subjects[0]->id }}">
                                                <input type="hidden" name="classes_id" id="class-id"
                                                    value="{{ $classId }}">

                                                <div class="mb-3">
                                                    <label for="contents"
                                                        class="form-label fw-semibold text-primary-light text-sm mb-8">Contents</label>
                                                    <textarea id="contents" name="contents" class="form-control">{{ $subjects[0]->content ?? '' }}</textarea>
                                                </div>
                                                <div class="d-flex gap-2 mt-3">
                                                    <button type="submit"
                                                        class="btn btn-success d-flex align-items-center gap-2">
                                                        <iconify-icon icon="mdi:content-save"
                                                            class="text-lg"></iconify-icon> Save
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-info d-flex align-items-center gap-2 insertTemplateBtn"
                                                        data-target="contents">
                                                        <iconify-icon icon="mdi:file-document-edit-outline"
                                                            class="text-lg"></iconify-icon> Insert Template
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-secondary d-flex align-items-center gap-2 printBtn"
                                                        data-target="contents">
                                                        <iconify-icon icon="mdi:printer" class="text-lg"></iconify-icon>
                                                        Print
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-danger d-flex align-items-center gap-2 deleteBtn"
                                                        data-target="contents">
                                                        <iconify-icon icon="mdi:delete" class="text-lg"></iconify-icon>
                                                        Delete
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('adminpage/assets/js/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/toastr.min.js') }}"></script>
    <script>
        // Initialize TinyMCE on the single textarea
        function initializeTinyMCE() {
            tinymce.init({
                selector: '#contents',
                plugins: 'preview importcss searchreplace autolink autosave save directionality code fullscreen image link media table pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough superscript subscript | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignalignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                autosave_interval: '30s',
                autosave_restore_when_empty: false,
                autosave_retention: '2m',
                image_advtab: true,
                height: 400,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: 'mceNonEditable',
                contextmenu: 'link image imagetools table',
                automatic_uploads: true,
                images_upload_credentials: true,
                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                images_upload_handler: function(blobInfo, progress) {
                    return new Promise((resolve, reject) => {
                        var xhr, formData;
                        xhr = new XMLHttpRequest();
                        xhr.withCredentials = true;
                        xhr.open('POST', '/admin/examquestions/question/upload-image');
                        var token = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                        xhr.upload.onprogress = function(e) {
                            if (e.lengthComputable) {
                                progress(Math.round((e.loaded / e.total) * 100));
                            }
                        };
                        xhr.onload = function() {
                            if (xhr.status === 403) {
                                reject('HTTP Error: ' + xhr.status + ' ' + xhr.statusText);
                                return;
                            }
                            if (xhr.status < 200 || xhr.status >= 300) {
                                reject('HTTP Error: ' + xhr.status + ' ' + xhr.statusText);
                                return;
                            }
                            var json = JSON.parse(xhr.responseText);
                            if (!json || typeof json.location != 'string') {
                                reject('Invalid JSON: ' + xhr.responseText);
                                return;
                            }
                            resolve(json.location);
                        };
                        xhr.onerror = function() {
                            reject('Image upload failed due to a XHR Transport error. Code: ' + xhr
                                .status);
                        };
                        formData = new FormData();
                        formData.append('file', blobInfo.blob(), blobInfo.filename());
                        formData.append('_token', token);
                        xhr.send(formData);
                    });
                }
            });
        }

        $(document).ready(function() {
            // Initialize TinyMCE on page load
            initializeTinyMCE();

            // Auto-click the first tab when page loads
            setTimeout(function() {
                // Get the first tab
                var firstTab = $('#subject-tab .nav-link').first();

                // Check if there's a stored subject ID in session storage
                var storedSubjectId = sessionStorage.getItem('selectedSubjectId');

                if (storedSubjectId) {
                    // Find the tab with the stored subject ID
                    var storedTab = $('#subject-tab .nav-link[data-subject-id="' + storedSubjectId + '"]');

                    // If found, click it, otherwise click the first tab
                    if (storedTab.length > 0) {
                        storedTab.click();
                    } else {
                        firstTab.click();
                    }
                } else {
                    // No stored ID, click the first tab
                    firstTab.click();
                }
            }, 100);

            // Remove alert
            $('.remove-button').on('click', function() {
                $(this).closest('.alert').addClass('d-none');
            });

            // Store class name globally
            var currentClassName = '';

            // Function to fetch class name
            function fetchClassName(classId) {
                $.ajax({
                    url: '/admin/examquestions/classes/' + classId + '/name',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        currentClassName = response.class_name || '';
                    },
                    error: function(xhr) {
                        console.error('Error fetching class name:', xhr);
                        currentClassName = '';
                    }
                });
            }

            // Initialize with the first class ID
            fetchClassName({{ $classId }});

            // Store current subject name - initialize with first tab's text
            var currentSubjectName = $('#subject-tab .nav-link').first().text().trim();

            // Handle tab click to fetch content
            $('#subject-tab .nav-link').on('click', function() {
                var subjectId = $(this).data('subject-id');
                var classId = $(this).data('class-id');

                // Get the subject name from the clicked tab
                currentSubjectName = $(this).text().trim();

                // Store the selected subject ID in session storage
                sessionStorage.setItem('selectedSubjectId', subjectId);

                $('#subject-id').val(subjectId);
                $('#class-id').val(classId);

                // Update class name if needed
                fetchClassName(classId);


                // Make AJAX request to fetch content
                $.ajax({
                    url: '/admin/examquestions/subjects/' + subjectId + '/' + classId + '/content',
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // Destroy existing TinyMCE instance
                        tinymce.get('contents').remove();
                        // Update textarea content
                        $('#contents').val(response.contents || '');
                        // Reinitialize TinyMCE
                        initializeTinyMCE();
                    },
                    error: function(xhr) {
                        console.error('Error fetching content:', xhr);
                        alert('Failed to load content for the selected subject.');
                    }
                });
            });



            // Insert Template button
            $('.insertTemplateBtn').on('click', function() {
                tinymce.get('contents').insertContent(`
        <h2 style="text-align: center;">{{ $schoolinfo->school_name }}</h2>
        <h3 style="text-align: center;">{{ ucfirst($schoolinfo->current_term) }} Examination for {{ $schoolinfo->current_session }} Session</h3>
        <p style="text-align: center;"><strong>Subject</strong>: ${currentSubjectName}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Class</strong>: ${currentClassName}&nbsp;&nbsp;&nbsp;&nbsp;<strong>Duration</strong>: 1hrs</p>
        <p style="text-align: center;"><span style="text-decoration: underline;"><em>Instructions: Answer all questions</em></span></p>
    `);
            });

            // Print button
            $('.printBtn').on('click', function() {
                tinymce.get('contents').execCommand('mcePrint');
            });

            // Delete button
            $('.deleteBtn').on('click', function() {
                tinymce.get('contents').setContent('');
            });

            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            //Notification
            @if (session('success'))
                toastr.success('Question updated successfully!');
            @endif

            // Handle form submission
            $('#subject-form').on('submit', function() {
                // The selectedSubjectId is already stored when clicking tabs
                // No need to do anything special here as we're using sessionStorage
            });
        });
    </script>
@endpush
