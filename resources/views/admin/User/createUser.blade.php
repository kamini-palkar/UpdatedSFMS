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
                            <span>Add User</span>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-8">

                    <div class="col-xl-12">
                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                            <div style="display:none" class="card-header pt-7" id="kt_chat_contacts_header">

                                <div style="display:none" class="card-title">

                                    <h2>Add User</h2>
                                </div>
                            </div>

                            <div class="card-body pt-5">
                                <form method="POST" id="form" action="{{route('create-user')}}">
                                    @csrf

                                    <div class="row row-cols-1 row-cols-sm-3 rol-cols-md-1 row-cols-lg-3">
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">ORGANISATION</span><span
                                                            style="color: red;">*</span>
                                                </label>





                                                <select name="organisation_id" id="organisation_id"
                                                    class="form-control form-control-solids"
                                                    style="border: 1px solid black; padding-top:0px; padding-bottom:0px;">

                                                    <option value="">select</option>
                                                    @foreach($data as $key=>$value)
                                                    <option value="{{$value->id}}" {{ old('organisation_id') == $value->id ? 'selected' : '' }}>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="OrganisationError"  style="color:red;"></span>
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
                                                    value="{{old('organisation_code')}}" autocomplete="off"
                                                    style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)" readOnly>

                                                    <span id="OrganisationCodeError"  style="color:red;"></span>
                                                @error('organisation_code')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">NAME</span><span
                                                            style="color: red;">*</span>
                                                </label>
                                                <input type="text" name="name" id="name"
                                                    class="form-control form-control-solids" value="{{old('name')}}"
                                                    autocomplete="off" style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)">
                                                    <span id="NameError"  style="color:red;"></span>
                                                @error('name')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">USERNAME</span><span
                                                            style="color: red;">*</span>
                                                </label>
                                                <input type="text" name="username" id="username"
                                                    class="form-control form-control-solids" value="{{old('username')}}"
                                                    autocomplete="off" style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)">
                                                    <span id="usernameError" style="color:red;"></span>
                                                @error('username')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">PASSWORD</span><span
                                                            style="color: red;">*</span>
                                                </label>
                                                <input type="text" name="password" id="password"
                                                    class="form-control form-control-solids" aria-required="true"
                                                    aria-invalid="true" value="{{old('password')}}" autocomplete="off"
                                                    style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)">
                                                    <span id="passwordError"  style="color:red;"></span>
                                                @error('password')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                            
                                    <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">ROLE</span><span
                                                            style="color: red;">*</span>
                                                </label>

                                                <select name="role_id" id="role_id"
                                                    class="form-control form-control-solids"
                                                    style="border: 1px solid black; padding-top:0px; padding-bottom:0px;">

                                                    <option value="">select</option>
                                                    @foreach($roles as $key=>$value)
                                                    <option value="{{$value->id}}" {{ old('role_id') == $value->id ? 'selected' : '' }}>{{$value->name}}</option>
                                                    @endforeach
                                                </select>
                                                <span id="roleError"  style="color:red;"></span>

                                                @error('role_id')
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.getElementById('form');
        var organisationInput = document.getElementById('organisation_id');
        var codeInput = document.getElementById('organisation_code');
        var nameInput = document.getElementById('name');
        var usernameInput = document.getElementById('username');
        var passwordInput = document.getElementById('password');
        var roleInput = document.getElementById('role_id');

        var organisationError = document.getElementById('OrganisationError');
        var codeError = document.getElementById('OrganisationCodeError');
        var nameError = document.getElementById('NameError');
        var usernameError = document.getElementById('usernameError');
        var passwordError = document.getElementById('passwordError');
        var roleError = document.getElementById('roleError');

        form.addEventListener('submit', function (event) {
            // Validation logic as before...

            if (organisationInput.value.trim() === '') {
                organisationError.textContent = 'Organisation is required.';
                event.preventDefault(); 
            } else {
                organisationError.textContent = '';
            }

            if (codeInput.value.trim() === '') {
                codeError.textContent = '';
                event.preventDefault(); 
            } else {
                codeError.textContent = '';
            }

            if (nameInput.value.trim() === '') {
                nameError.textContent = 'Name is required.';
                event.preventDefault(); 
            } else {
                nameError.textContent = '';
            }

            if (usernameInput.value.trim() === '') {
                usernameError.textContent = 'Username is required.';
                event.preventDefault(); 
            } else {
                usernameError.textContent = '';
            }

            if (passwordInput.value.trim() === '') {
                passwordError.textContent = 'Password is required.';
                event.preventDefault(); 
            } else {
                passwordError.textContent = '';
            }

            if (roleInput.value.trim() === '') {
                roleError.textContent = 'Role is required.';
                event.preventDefault(); 
            } else {
                roleError.textContent = '';
            }
        });

        // Add input event listeners to clear errors when the user types
        organisationInput.addEventListener('input', function () {
            organisationError.textContent = '';
        });

        codeInput.addEventListener('input', function () {
            codeError.textContent = '';
        });

        nameInput.addEventListener('input', function () {
            nameError.textContent = '';
        });

        usernameInput.addEventListener('input', function () {
            usernameError.textContent = '';
        });

        passwordInput.addEventListener('input', function () {
            passwordError.textContent = '';
        });

        roleInput.addEventListener('change', function () {
            roleError.textContent = '';
        });
    });

    function removeBorderStyle(element) {
        element.style.border = '1px solid black';
    }
</script>

    

       
       <script>
    $('#organisation_id').on('change', function() {
        var selectedOrganisationId = $(this).val();

        console.log(selectedOrganisationId);

        jQuery.ajax({
            url: "{{ url('get-organisation-code') }}/" + selectedOrganisationId,
            type: 'GET',
            success: function(data) {
                $('#organisation_code').val(data.organisation_code);
            },
            error: function(error) {
                console.log(error);
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