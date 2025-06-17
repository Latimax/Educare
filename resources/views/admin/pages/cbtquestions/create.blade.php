@extends('admin.layouts.app')

@section('title', 'Create Question')

@push('styles')
    <link rel="stylesheet" href="{{ asset('adminpage/assets/css/lib/toastr.min.css') }}">
@endpush

@section('content')
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <h6 class="fw-semibold mb-0">Questions</h6>
            <ul class="d-flex align-items-center gap-2">
                <li class="fw-medium">
                    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                        Dashboard
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">
                    <a href="{{ route('admin.cbtquestions.subjects.view', ['subjectId' => $subjectId, 'className' => $className]) }}"
                        class="hover-text-primary">
                        Questions
                    </a>
                </li>
                <li>-</li>
                <li class="fw-medium">Create Question </li>
            </ul>
        </div>

        <div class="card basic-data-table">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="card-title mb-0">Create Question</h5>
                <div>
                    <a href="{{ route('admin.cbtquestions.subjects.view', ['subjectId' => $subjectId, 'className' => $className]) }}"
                        class="btn btn-outline-primary-600 radius-8 px-20 py-11 d-flex align-items-center">
                        <iconify-icon icon="icons8:left-round" class="text-xl"></iconify-icon> Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-xxl-8">
                        <div class="card p-0 overflow-hidden position-relative radius-12 h-100">
                            <div class="card-header py-16 px-24 bg-base border border-end-0 border-start-0 border-top-0">
                                <h6 class="text-lg mb-0">CBT - {{ $className }} {{ $subjectName }} </h6>
                            </div>
                            <div class="card-body p-24 pt-10">
                                <form method="POST" action="{{ route('admin.cbtquestions.subjects.save.new') }}"
                                    id="subject-form" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- Hidden Fields -->
                                    <input type="hidden" name="subject_id" value="{{ $subjectId ?? '' }}">
                                    <input type="hidden" name="classes_id" value="{{ $classId ?? '' }}">

                                    <!-- Question -->
                                    <div class="mb-3">
                                        <label for="question"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Question</label>
                                        <textarea id="question" name="question" class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}">{{ old('question') }}</textarea>
                                        @if ($errors->has('question'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('question') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Options (2x2 Grid) -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Option
                                                A</label>
                                            <textarea id="option_a" name="option_a" class="form-control {{ $errors->has('option_a') ? 'is-invalid' : '' }}">{{ old('option_a') }}</textarea>
                                            @if ($errors->has('option_a'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('option_a') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Option
                                                B</label>
                                            <textarea id="option_b" name="option_b" class="form-control {{ $errors->has('option_b') ? 'is-invalid' : '' }}">{{ old('option_b') }}</textarea>
                                            @if ($errors->has('option_b'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('option_b') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Option
                                                C</label>
                                            <textarea id="option_c" name="option_c" class="form-control {{ $errors->has('option_c') ? 'is-invalid' : '' }}">{{ old('option_c') }}</textarea>
                                            @if ($errors->has('option_c'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('option_c') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Option
                                                D</label>
                                            <textarea rows="4" id="option_d" name="option_d"
                                                class="form-control {{ $errors->has('option_d') ? 'is-invalid' : '' }}">{{ old('option_d') }}</textarea>
                                            @if ($errors->has('option_d'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('option_d') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Answer Dropdown -->
                                    <div class="mb-3">
                                        <label for="answer"
                                            class="form-label fw-semibold text-primary-light text-sm mb-8">Answer</label>
                                        <select id="answer" name="answer"
                                            class="form-select {{ $errors->has('answer') ? 'is-invalid' : '' }}">
                                            <option value="">Select Answer</option>
                                            <option value="option_a" {{ old('answer') == 'option_a' ? 'selected' : '' }}>
                                                Option A</option>
                                            <option value="option_b" {{ old('answer') == 'option_b' ? 'selected' : '' }}>
                                                Option B</option>
                                            <option value="option_c" {{ old('answer') == 'option_c' ? 'selected' : '' }}>
                                                Option C</option>
                                            <option value="option_d" {{ old('answer') == 'option_d' ? 'selected' : '' }}>
                                                Option D</option>
                                        </select>
                                        @if ($errors->has('answer'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('answer') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Description and Explanation (Side by Side) -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="description"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Description
                                                (optional)</label>
                                            <textarea id="description" name="description"
                                                class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                                            @if ($errors->has('description'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('description') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label for="explanation"
                                                class="form-label fw-semibold text-primary-light text-sm mb-8">Explanation
                                                (optional)</label>
                                            <textarea id="explanation" name="explanation"
                                                class="form-control {{ $errors->has('explanation') ? 'is-invalid' : '' }}">{{ old('explanation') }}</textarea>
                                            @if ($errors->has('explanation'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('explanation') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 mt-3">
                                        <button type="submit" class="btn btn-success d-flex align-items-center gap-2">
                                            <iconify-icon icon="mdi:content-save" class="text-lg"></iconify-icon> Save
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
    <script src="{{ asset('adminpage/assets/js/lib/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('adminpage/assets/js/lib/toastr.min.js') }}"></script>
    <script>
        // Initialize TinyMCE on all relevant textareas
        function initializeTinyMCE() {
            tinymce.init({
                selector: '#question, #option_a, #option_b, #option_c, #option_d, #description, #explanation',
                plugins: 'preview importcss searchreplace autolink autosave save directionality code fullscreen image link media table pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough superscript subscript | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample | ltr rtl',
                toolbar_sticky: true,
                autosave_ask_before_unload: true,
                autosave_interval: '30s',
                autosave_restore_when_empty: false,
                autosave_retention: '2m',
                image_advtab: true,
                height: 200,
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
            initializeTinyMCE();

            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": "3000"
            };

            @if (session('success'))
                toastr.success('Question created successfully!');
            @endif
        });
    </script>
@endpush
