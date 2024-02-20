@extends('admin.common.main')
@section('containes')
@can('show-user')
<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
</div>
</div>
</div>
</div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<main class="py-4">
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                    data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                    class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <span style="display:none" class="h-20px border-gray-300 border-start mx-4"></span>
                </div>
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                        <div data-kt-swapper="true" data-kt-swapper-mode="prepend"
                            data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}"
                            class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">

                            <span style="display:none" class="h-20px border-gray-300 border-start mx-4"></span>
                            <ul style="display:none" class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                                <li class="breadcrumb-item text-muted">
                                    <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                </li>
                                <li class="breadcrumb-item text-muted">Customers</li>
                                <li class="breadcrumb-item">
                                    <span class="bullet bg-gray-300 w-5px h-2px"></span>
                                </li>
                                <li class="breadcrumb-item text-dark">Customer Listing</li>
                            </ul>
                            <div class="row ">
                                <div class="col-sm-12">
                                    <ol class="breadcrumb ">
                                    <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
                                    <?php echo $breadcrumb ?? ''; ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 gap-lg-3">

                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                         
                              
                                <div>
                              @can('add-user')
                                    <a href="{{route('create-user')}}" class="btn btn-primary"
                                        role="button">ADD USER</a>
                                        @endcan
                                </div>
                              
                                <br>
                            </div>

                            <a style="display:none" href="../../demo1/dist/.html" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    </div>
                    <a style="display:none" href="../../demo1/dist/.html" class="btn btn-sm btn-primary"
                        data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
                </div>
            </div>
        </div>

        @if(Session::has('message'))
        <div style="text-align: center;">
            <div style="width: 500px; margin: 0 auto;" class="alert alert-success">{{ Session::get('message') }}</div>
        </div>
        @endif
        <br>
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <br>
            <div id="kt_content_container" class="container-xxl">
                <div class="card">
                    <div class="card-header border-1 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                &nbsp;

                                Users List

                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-7 gy-5" id="tableYajra">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th id="th">SR NO</th>
                                    <th id="th">NAME</th>

                                    <th id="th">USERNAME</th>
                                    
                                    <th id="th">ORGANISATION CODE</th>
                                    <th id="th">ROLE</th>
                                    <th id="th">STATUS</th>
                                    <th id="th">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    </div>

    <body>
        <style>
        #th:hover {
            color: grey;
        }
        </style>
        <script>
        $(document).ready(function() {
            var table = $('#tableYajra').DataTable({
                processing: true,
                serverSide: true,
              
                ajax: {
                url: "{{ route('user-datatable') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                                        {
                        data: 'organisation_code',
                        name: 'organisation_code',
                        render: function(data, type, full, meta) {

                        return '<span class="badge badge-success" style="margin-left:63px;padding:5px;">' +
                            data + '</span>';
                        }
                    },

                    {
                        data: 'role_name',
                        name: 'role_name',
                        render: function(data, type, full, meta) {

                        return '<span class="badge badge-primary" style="padding:5px;">' +
                            data + '</span>';
                                                }
                        
                    },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(data, type, full, meta) {
                            var statusText = data === '1' ? 'Active' : 'Inactive';
                            var statusClass = data === '1' ? 'text-success' :
                                'text-danger';
                            var iconClass = data === '1' ? 'fas fa-check-circle' :
                                'fas fa-times-circle';

                            return '<div class="status-container d-flex align-items-center">' +
                                '<i class="' + iconClass + ' ' + statusClass +
                                ' toggle-status-icon" data-id="' + full.id + '"></i>' +
                                '<span class="mx-2 ' + statusClass +
                                ' toggle-status-text" data-id="' + full.id + '">' + statusText +
                                '</span>' +
                                '</div>';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true,

                    }
                ],
                order: [
                  [0, 'desc'] 
                 ],
                rowCallback: function(row, data, index) {
                    var api = this.api();
                    var startIndex = api.page() * api.page.len();
                    var rowNum = startIndex + index + 1;
                    $(row).find('td:eq(0)').html(rowNum);
                }
            });

            setTimeout(function() {
                $("div.alert-success").remove();
            }, 3000);
        });
        </script>
        
        <script>
        $(document).ready(function() {
            console.log("ready!");
            $('body').on('click', '.Deleteuser', function () {
        
                var id = $(this).data("id");
         
                var userConfirmed = confirm("Are you sure you want to delete this User!");
                var url = "{{ url('delete-user') }}/" + id;
         
                if(userConfirmed){
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function (data) {
                                console.log(data);
                                if (data.trim() === 'deleted') {
                                    $('#tableYajra').DataTable().ajax.reload();
                                    toastr.success('This user deleted successfully');
                                } else if (data.trim() === 'not deleted') {
                                    toastr.error(' This user can not be deleted ');
                                }
                            },
                            error: function (data) {
                                console.log('Error:', data);
                            }
                        });
                    }
            
                
            });

        });
        </script>
     @can('Active/inactive')
        <script>
            $(document).ready(function() {
                    $('body').on('click', '.toggle-status-icon', function () {
                    var userId = $(this).data('id');
                       
                    $.ajax({
                        type: 'GET', 
                        url: '/user-status/' + userId, 
                    
                        success: function (data) {
                            console.log(data);
                            if (data.trim() === 'updated') {
                                $('#tableYajra').DataTable().ajax.reload();
                                toastr.success('User Status Updated Successfully');
                            }
                        },
                        error: function (error) {
                            // console.error('Error toggling user status:', error);
                        }
                    });
                });
            });
        </script>
   
     @endcan


    </body>
  @endcan
    </html>
@endsection