@extends('admin.common.main')

@section('containes')

@can('role-has-permission')
<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
</div>
</div>
</div>
</div>

</div>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link href="/css/treeview.css" rel="stylesheet">

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
                                    <ol class="breadcrumb ">
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

                            Role Has Permissions
                        </div>
                    </div>
                </div>
                <!-- <div class="card-body pt-8"> -->

                    <!-- <div class="col-xl-12"> -->
                        <div class="card card-flush h-lg-100" id="kt_contacts_main">

                            <!-- <div style="display:none" class="card-header pt-7" id="kt_chat_contacts_header">

                                <div style="display:none" class="card-title">
                                </div>
                            </div> -->
                            
                            @if(session('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                            @endif
                            <style>
                            .alert-success {
                                transition: opacity 2s ease-in-out;
                                opacity: 1;
                            }

                            .hide-alert {
                                opacity: 0;
                            }

                            .alert-success {
                                width: 50%;
                                margin: 0 auto;
                               margin-top:10px;
                                text-align: center;
                                transition: opacity 2s ease-in-out;
                                opacity: 1;
                            }

                            .hide-alert {
                                opacity: 0;
                            }
                            </style>
                            

                            <!-- <div class="card-body "> -->
                                <form method="POST" id="form" action="{{ route('showroles_and_permissions') }}">
                                    @csrf
                                    <div class="panel panel-primary " style="margin-bottom:0px">
                                    <div class="panel-heading">❂ Assign Permissions To Role</div>
                                    <div class="panel-body">
                                        <!-- <div class="row">
                                            <div class="col"> -->
                                            <!-- <span class="border-span">❂ Assign Permissions To Role :</span> -->

                                                <ul id="tree1">
                                                    @foreach($roles as $role)
                                                        <li >
                                                        <input type="checkbox" name="roles[]" value="{{ $role->id }}" checked> {{ $role->name }}


                                                            
                                                                <ul id="tree1">
                                                                    @foreach($allPermissions as $permission)
                                                                        <li>
                                                                        <input type="checkbox" 
                                                                        name="permissions[]" 
                                                                        value="{{ $permission->id }}" 
                                                                        @if ($role->permissions->contains('id', $permission->id)) checked @endif
                                                                    > {{ $permission->name }}
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            
                                                    
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            <!-- </div>
                                        </div> -->
                                        <div  class="mb-5"style="float:right;">

                                            <div class="d-flex justify-content-end ">
                                                <a href="/showroles_and_permission" class="btn btn-outline-danger"
                                                    style="margin-right:10px;">Cancel</a>
                                                <button type="submit" id="submit" data-kt-contacts-type="submit"
                                                    class="btn btn-primary">
                                                    <span class="indicator-label">Save</span>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                    </div>
                                   
                                </form>                           
                                
                            <!-- </div> -->
                        </div>
                    <!-- </div> -->
                <!-- </div> -->
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
     <script src="/js/treeview.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var alertElement = document.querySelector('.alert-success');

        if (alertElement) {
            setTimeout(function() {
                alertElement.classList.add('hide-alert');
            }, 1000);
        }
    });
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('form');
        form.addEventListener('submit', function(event) {
            // Validate the dropdown selection
            var roleDropdown = document.getElementById('role');
            if (roleDropdown.value === '') {
                $('#Error').text('Please select role to get permission according to Role.');
                event.preventDefault();
            } else {

                $('#Error').text('');
            }
        });
        $('#role').on('change', function() {

            $('#Error').text('');
        });
    });
    </script>

    <script src="{{ asset('js/admin_js/rolesAndpermission.js') }}"></script>

@endcan


    @endsection