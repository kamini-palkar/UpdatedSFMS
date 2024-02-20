@extends('admin.common.main')

@section('containes')

<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
</div>
</div>
</div>
</div>
</div>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<!-- Include Select2 CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-Qy9pS/OmBOsz9mw6VEY5qk/ZL1WqI0z9D53U+oiRRGP5b2YZN/sxVjsTdh7v3Rv5q5Of9/78A2dWeGBww9kZLQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Include jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha512-ZvpU/9UEIa7eLkUGh2BTEV6zKu70lV+1Zwo4b8lT/8jtZ1JtZ9z3luLbY+UXYYfH0DcPn3eMhylR6blt9Cv/1/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Include Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-WdeY9GrFd5zvBtGO2Jqsj5H1qMy1A4Vn15DZ+czMeTInyxgSTJTZYFvAytU1Yk7H1vRXTDZBRrM3CjG4sP8/wA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<main class="py-4">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="toolbar" id="kt_toolbar">

            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">

                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">


                    <div class="d-flex align-items-center gap-2 gap-lg-3">

                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">


                        </div>

                        <a style="display:none" href="../../demo1/dist/.html" class="btn btn-sm btn-primary"
                            data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
                    </div>

                    <div class="row ">
                                <div class="col-sm-12">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
                                    <?php echo $breadcrumb ?? ''; ?>
                                    </ol>
                                </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                </div>
                <a style="display:none" href="../../demo1/dist/.html" class="btn btn-sm btn-primary"
                    data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
            </div>
        </div>
    </div>
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-xxl">
            <div class="card">
                <div class="card-header border-2 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                             &nbsp;
                            <span>Upload Files</span>
                          

                        </div>
                    </div>
                </div>
                <div class="card-body pt-8">

                    <div class="col-xl-12">
                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                            <div style="display:none" class="card-header pt-7" id="kt_chat_contacts_header">

                                <div style="display:none" class="card-title">

                                </div>
                            </div>
                            <div class="card-body pt-5">
                                <form method="POST" id="form" action="{{route('upload-file')}}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="div_append">
                                        <div class="row field_wrapper ">
                                            <label class="fs-6 fw-bold form-label mt-3 ml-1">
                                                <span class="">FILE UPLOAD</span>
                                                <span style="color:red;">*</span>
                                                <small style="color:red;">Valid file type (jpg, jpeg, png, xlsx, doc,
                                                    docx, pdf, xls, zip, cdr, ai, psd, etc. max size of each file =
                                                    600MB)</small>

                                            </label>
                                           
                                            <div class="col-8 col-sm-8 col-md-6 col-ls-6 mb-3">
                                            
                                                <input type="file" name="name[]" id="organisation_code"
                                                    class="form-control" autocomplete="off" style="border: 1px solid black;padding-top: 0px;">
                                            </div>

                                            <div class="col-4 col-sm-4 col-md-4 col-ls-4">
                                                <a href="javascript:void(0);" class="add_button" title="Add"><img
                                                        src="/images/plus.png"
                                                        style="height:30px; width:30px;padding-top: 0px;"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-8 col-sm-8 col-md-6 col-ls-6 mb-1">
                                        <label class="fs-6 fw-bold form-label ">
                                                    <span class="">Email</span><span
                                                            style="color: red;">*</span>
                                                </label>
                                            <!-- <input type="text" name="email" class="form-control" style="border: 1px solid black;padding-top: 0px;"
                                                placeholder="Enter Email Address  :" autocomplete="off" required> -->
                                                <select name="user[]" id="user_id"
                                                        class="form-control form-control-solids"
                                                        style="border: 1px solid black; padding-top:0px; padding-bottom:0px;" required multiple>

                                                        <option value="">select user</option>
                                                        @foreach($user as $key=>$value)
                                                        <option value="{{$value->name}}" >{{$value->name}}</option>
                                                        @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    

                                    <div class="row">
                                        <div class="col-8 col-sm-8 col-md-6 col-ls-6 mb-1">  
                                            <label class="fs-6 fw-bold form-label ">
                                                <span class="">Project</span>
                                                <span style="color: red;">*</span>
                                            </label>
                                            <select name="project" id="project_id"
                                                        class="form-control form-control-solids"
                                                        style="border: 1px solid black; padding-top:0px; padding-bottom:0px;" required>

                                                        <option value="">select PROJECT</option>
                                                        @foreach($project as $key=>$value)
                                                        <option value="{{$value->id}}" >{{$value->name}}</option>
                                                        @endforeach
                                            </select>
                                            <span id="project"  style="color:red;"></span>
                                            @error('project')
                                            <div id="Errormsg">{{ $message }}</div>
                                            @enderror
                                            
                                        </div>
                                    </div>

                                     <div class="row">
                                        <div class="col-8 col-sm-8 col-md-6 col-ls-6 mb-3">
                                            <label class="fs-6 fw-bold form-label ">
                                                    <span class="">Document Purpose</span>
                                                    <span style="color: red;">*</span>
                                            </label>
                                                <textarea name="purpose" class="form-control" style="border: 1px solid black; padding-top: 0px;" autocomplete="off" required></textarea>

                                        </div>
                                    </div>
                                    <span id="errorDiv" style="color:red;"></span>

                                    
                                    <div id="progress_result" style="display:none;">
                                        <progress id="uploadProgress" value="0" max="100"
                                            style="width: 100%; height: 20px;"></progress>
                                        <span id="progressLabel">0%</span><span id="progressMessage"
                                            style="margin-left: 10px; color:green;"></span>
                                    </div>


                                    <div style="float:right;">

                                        <div class="d-flex justify-content-end">

                                            <a href="{{route('show-files')}}" class="btn btn-outline-danger"
                                                id="cancel_btn" style="margin-right:10px;">Cancel</a>
                                            <button type="submit" id="submit" data-kt-contacts-type="submit"
                                                class="btn btn-primary">
                                                <span class="indicator-label">Save</span>
                                            </button>
                                        </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="marquee-container" style="width:100%">
                        <div class="marquee-content" style="padding-top:20px; color:red">

                            Note<span style="padding-left:8px;"> <span style="padding-right:4px;">:</span> You can
                                upload maximum 10 files and multiple emails at a Time.</span>
                        </div>
                    </div>
                  


                </div>


                <!-- modal -->
                <div class="modal fade" id="successModal" tabindex="-1" role="dialog"
                    aria-labelledby="successModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Email has been sent successfully!
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
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
    </div>
    </div>
    <style>
    #organisation_code-error {
        color: red;
        padding-top: 15px;

    }

    #Errormsg {
        color: red;
        margin-top: 10px;

    }

    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
    }

    .marquee-content {
        display: inline-block;
        width: 100%;
        animation: marquee 20s linear infinite;
    }
    </style>



    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


    <script>
    function updateProgressBar(percentage) {
        $('#uploadProgress').val(percentage);
        $('#progressLabel').text(percentage + '%');

        if (percentage === "100.00") {
            $('#progressMessage').text('Please wait, Email is being sent......');
            $('#submit').hide();
            $('#cancel_btn').hide();
        } else if (percentage !== 0) {
            $('#progressMessage').text('Please wait, File is being processed......');
            $('#submit').hide();
            $('#cancel_btn').hide();
        } else {
            $('#progressMessage').text('');
            $('#submit').show();
            $('#cancel_btn').show();
        }
    }

    $(document).ready(function() {
        $('#user_id').select2();
        $('#form').submit(function(e) {
            console.log('coming here');
            e.preventDefault();
            var startTime = new Date().getTime();
            console.log(startTime)
            $('#progress_result').show();

            var formData = new FormData(this);

            $.ajax({
                url: "{{ route('upload-file') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = (evt.loaded / evt.total) * 100;
                            percentComplete = percentComplete.toFixed(2);
                            $('#uploadProgress').val(percentComplete);
                            updateProgressBar(percentComplete);
                        }
                    }, false);

                    return xhr;
                },
                success: function(response) {
                    var endTime = new Date().getTime();
                    var durationInSeconds = (endTime - startTime) / 1000;
                    console.log(durationInSeconds);
                    var durationInMinutes = durationInSeconds / 60;

                    console.log('File uploaded successfully in ' + durationInMinutes
                        .toFixed(2) + ' minutes');


                    console.log('file uploaded successfully');
                    $('#successModal').modal('show');
                    $('#progress_result').hide();

                    $('#form')[0].reset();
                    updateProgressBar(0);
                    $('#uploadProgress').val(0);


                    $('#successModal').on('click', '.btn-primary', function() {
                        $('#successModal').modal('hide');
                    });
                },
                error: function(xhr, status, error) {
                    console.log('error got ' + error);
                    console.log(error, status)
                    alert('Error uploading files: ' + error);
                }
            });
        });
    });
    </script>


    <script type="text/javascript">
    $(document).ready(function() {
        $('#submit').on('click', function(e) {
            $('#errorDiv').text('');
            var fileInputs = $('input[type="file"]');

            var atLeastOneFileSelected = false;
            var allowedExtensions = ['jpg', 'jpeg', 'png', 'xlsx', 'doc', 'docx', 'pdf', 'xls', 'zip',
                'cdr', 'ai', 'psd'
            ];
            var maxFileSizeMB = 600; // 600 MB
            var renderCount = 0;

            fileInputs.each(function() {
                var files = $(this).get(0).files;

                if (files.length > 0) {
                    atLeastOneFileSelected = true;

                    for (var i = 0; i < files.length; i++) {
                        var fileName = files[i].name;
                        var fileExtension = fileName.split('.').pop().toLowerCase();


                        if (allowedExtensions.indexOf(fileExtension) === -1) {
                            e.preventDefault();
                            $('#errorDiv').text('Please select a (' + fileName +
                                ') valid file type (jpg, jpeg, png, xlsx, doc , docx , pdf ,xls, zip, cdr, ai, psd).'
                            );
                            return;
                        }

                        var fileSizeMB = files[i].size / (1024 * 1024);

                        console.log('File size of "' + fileName + '" in MB: ' + fileSizeMB
                            .toFixed(2));

                        if (fileSizeMB > maxFileSizeMB) {
                            e.preventDefault();
                            $('#errorDiv').text('File size of "' + fileName +
                                '" exceeds the limit. It should be less than ' +
                                maxFileSizeMB + ' MB.');
                            return;
                        }
                    }
                } else {
                    e.preventDefault();
                    $('#errorDiv').text('Please select file.');
                    return;
                }
            });

            if (!atLeastOneFileSelected) {
                e.preventDefault();
                $('#errorDiv').text('Please select file.');
            }
        });
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10;
        var addButton = $('.add_button');
        var wrapper = $('.div_append');


        var fieldHTML =
            '<div class="row field_wrapper new-field_wrapper"> <div class="col-8 col-sm-8 col-md-6 col-ls-6 mb-3"><input type="file"  class="form-control "   name="name[]" value="" style="border: 1px solid black;padding-top: 0px;"/ > </div> <div class="col-4 col-sm-4 col-md-4 col-ls-4"> <a href="javascript:void(0);" class="remove_button" title="Add"><img src="/images/minus.png"/ style="height:30px; width:30px;"></a></div> </div>';
        var x = 1;


        $(addButton).click(function() {

            if (x < maxField) {

                x++;
                $(wrapper).append(fieldHTML);
            }
        });
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();

            $(this).closest('.new-field_wrapper').remove();
            x--;
        });
    });
    </script>
    @endsection