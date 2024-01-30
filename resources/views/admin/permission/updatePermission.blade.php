

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

                            Edit Permission
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
                                <form method="POST" id="form" action="{{ route('update-permission',encrypt($edit->id)) }}">
                                
                                    @csrf
                                    <div class="row row-cols-2 row-cols-sm-3 rol-cols-md-1 row-cols-lg-2">
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">Permission Name</span><span
                                                            style="color: red;">*</span>
                                                </label>
                                                <input type="text" name="name" id="organisation_name"
                                                    class="form-control form-control-solids"
                                                    value="{{$edit->name}}" autocomplete="off"
                                                    style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)" required>
                                                    <span id="nameError" style="color:red;"></span>
                                                @error('name')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>


                                        
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label mt-3">
                                                    <span class="">Guard Name</span><span
                                                            style="color: red;">*</span>
                                                </label>
                                                <input type="text" name="guard_name" id="organisation_code"
                                                    class="form-control form-control-solids"
                                                    value="web" autocomplete="off"
                                                    style="border: 1px solid black; padding: 13px;"
                                                    oninput="removeBorderStyle(this)" >
                                                 <span id="Error" style="color:red;"></span>
                                                @error('code')
                                                <div id="Errormsg">{{ $message }}</div>
                                                @enderror

                                            </div>
                                        </div>

                                        <div class="col">
                                        <div class="fv-row mb-2">  
                                            <label class="fs-6 fw-bold form-label ">
                                                <span class="">Menu</span>
                                                <span style="color: red;">*</span>
                                            </label>
                                            <select name="menu_id" id="menu_id"
                                                        class="form-control form-control-solids"
                                                        style="border: 1px solid black; padding-top:0px; padding-bottom:0px;" >

                                                        <option value="">select menu</option>
                                                        @foreach($Menus as $key=>$value)
                                                    <option value="{{$value->id}}" @if($value->id == $edit->menu_id)
                                                        selected @endif>{{$value->title}}</option>
                                                    @endforeach
                                            </select>
                                            <span id="roleError"  style="color:red;"></span>
                                            @error('role_id')
                                            <div id="Errormsg">{{ $message }}</div>
                                            @enderror
                                            
                                        </div>
                                    </div>
                                        <div class="col">
                                            <div class="fv-row mb-2">
                                                <label class="fs-6 fw-bold form-label ">
                                                <span class="">SubMenu</span><span style="color: red;">*</span>
                                                </label>
                                                <select name="submenu_id" id="submenu_id"
                                                            class="form-control form-control-solids"
                                                            style="border: 1px solid black; padding-top:0px; padding-bottom:0px;" >

                                                            <option value="">select SubMenu</option>
                                                         
                                                         
                                                </select>
                                                <span id="project"  style="color:red;"></span>
                                                @error('submenu_id')
                                                    <div id="Errormsg">{{ $message }}</div>
                                                @enderror

                                                
                                            </div>
                                        </div>
                                 
                                       

                                    
                                    </div>
                                    <br>
                                    <div style="float:right;">

                                        <div class="d-flex justify-content-end">
                                        <a href="{{route('show-permission')}}"  class="btn btn-outline-danger"  style="margin-right:10px;">Cancel</a> 
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var selectedMenuId = {!! json_encode($edit->menu_id ?? null) !!};
        var selectedSubmenuId = {!! json_encode($edit->sub_menu_id ?? null) !!};
       

        var menuId = {!! json_encode($edit->menu_id ?? null) !!};
        $('#menu_id').val(menuId).change();

        // Use AJAX to fetch submenus based on the selected menu
        fetchSubmenus(menuId, selectedSubmenuId);

        // Use AJAX to fetch child menus based on the selected submenu
        fetchChildMenus(selectedSubmenuId, selectedChildMenuId);
    });

    $('#menu_id').on('change', function() {
        var menuId = $(this).val();

        // Fetch submenus based on the selected menu
        fetchSubmenus(menuId, null);
    });

    $('#submenu_id').on('change', function() {
        var submenuId = $(this).val();

        // Fetch child menus based on the selected submenu
        fetchChildMenus(submenuId, null);
    });

    function fetchSubmenus(menuId, selectedSubmenuId) {
        var submenuDropdown = $('#submenu_id');

        $.ajax({
            url: '/get-submenus/' + menuId,
            type: 'GET',
            success: function(data) {
                submenuDropdown.empty();

                if (data.length > 0) {
                    $.each(data, function(index, submenu) {
                        var option = $('<option value="' + submenu.id + '">' + submenu.title + '</option>');

                        if (submenu.id == selectedSubmenuId) {
                            option.prop('selected', true);
                        }

                        submenuDropdown.append(option);
                    });
                } else {
                    submenuDropdown.append('<option value="' + selectedSubmenuId + '"></option>');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function fetchChildMenus(submenuId, selectedChildMenuId) {
        var childMenuDropdown = $('#child_menu_id');

        $.ajax({
            url: '/get-child-menus/' + submenuId,
            type: 'GET',
            success: function(data) {
                childMenuDropdown.empty();

                if (data.length > 0) {
                    $.each(data, function(index, childMenu) {
                        var option = $('<option value="' + childMenu.id + '">' + childMenu.title + '</option>');

                        if (childMenu.id == selectedChildMenuId) {
                            option.prop('selected', true);
                        }

                        childMenuDropdown.append(option);
                    });
                } else {
                    childMenuDropdown.append('<option value="' + selectedChildMenuId + '"></option>');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }
</script>
    @endsection