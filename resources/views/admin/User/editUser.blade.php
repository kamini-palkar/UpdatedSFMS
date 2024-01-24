@extends('admin.common.main')

@section('containes')


<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
</div>
</div>
</div>
</div>

</div>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
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
                                    <ol class="breadcrumb float-sm-right">
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

                           Edit User
                        </div>
                    </div>
                </div>
                <div class="card-body pt-8">

                    <div class="col-xl-12">
                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                            <div style="display:none" class="card-header pt-7" id="kt_chat_contacts_header">

                                <div style="display:none" class="card-title">

                                    <h2>Edit User</h2>
                                </div>
                            </div>

                            <div class="card-body pt-5">
                                <form method="POST" id="form" action="/update-user/{{encrypt($editUser->id)}}">
                                    @csrf

                                    <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">ORGANISATION</span>
                                                </label>

                                                <select name="organisation_id" id="organisation_id"
                                                    class="form-control form-control-solids"
                                                    style="border: 1px solid black; padding-top:0px; padding-bottom:0px;"
                                                    disabled>
                                                    <option value="">select</option>
                                                    @foreach($data as $key => $value)
                                                    <option value="{{ $value->id }}" @if($value->id ==
                                                        $editUser->organisation_id) selected @endif>{{ $value->name }}
                                                    </option>
                                                    @endforeach
                                                </select>


                                                @error('organisation_id')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">ORGANISATION CODE</span>
                                                </label>
                                                <input type="text" name="organisation_code" id="organisation_code"
                                                    class="form-control form-control-solids"
                                                    value="{{$editUser->organisation_code}}" autocomplete="off"
                                                    style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)" disabled>

                                                @error('organisation_code')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">NAME</span>
                                                </label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control form-control-solids" value="{{$editUser->name}}"
                                                    autocomplete="off" style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)">

                                                @error('name')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">USERNAME</span>
                                                </label>
                                                <input type="text" name="username" id="username"
                                                    class="form-control form-control-solids"
                                                    value="{{$editUser->username}}" autocomplete="off"
                                                    style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)" disabled>

                                                @error('username')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">PASSWORD</span>
                                                </label>
                                                <input type="password" name="password" id="password"
                                                    class="form-control form-control-solids" aria-required="true"
                                                    aria-invalid="true" value="{{$editUser->password}}"
                                                    autocomplete="off" style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)">
                                                @error('password')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                           
                                        </div>
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">ROLE</span>
                                                </label>

                                                <select name="role_id" id="organisation_id"
                                                    class="form-control form-control-solids"
                                                    style="border: 1px solid black; padding-top:0px; padding-bottom:0px;"
                                                    >
                                                    <option value="">select</option>
                                                    @foreach($roles as $key => $value)
                                                    <option value="{{ $value->id }}" @if($value->id ==
                                                        $editUser->role_id) selected @endif>{{ $value->name }}
                                                    </option>
                                                    @endforeach
                                                </select>


                                                @error('organisation_id')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div style="float:right;">

                                        <div class="d-flex justify-content-end">

                                        <a href="{{route('show-user')}}"  class="btn btn-outline-danger"  style="margin-right:10px;">Cancel</a> 
                                            <button type="submit" id="submit" data-kt-contacts-type="submit"
                                                class="btn btn-primary">
                                                <span class="indicator-label">Save</span>
                                            </button>
                                        </div>

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
    </style>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
   
    <script>
        $('#organisation_id').on('change', function () {
            var selectedOrganisationId = $(this).val();

            console.log(selectedOrganisationId);

            jQuery.ajax({
                url: "{{ url('get-organisation-code') }}/" + selectedOrganisationId,
                type: 'GET',
                success: function (data) {
                    $('#organisation_code').val(data.organisation_code);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });

        $(document).ready(function() {
        $("#togglePassword").click(function() {
            var passwordInput = $("#password");
            var type = passwordInput.attr("type");
            
            if (type === "password") {
                passwordInput.attr("type", "text");
            } else {
                passwordInput.attr("type", "password");
            }
        });
    });

        function removeBorderStyle(element) {
            if (element.value.trim() !== '') {
                element.style.border = 'none';
                element.style.padding = '13px';
            } else {
                element.style.border = '1px solid black';
                element.style.padding = '13px';
            }
        }
    </script>
    @endsection