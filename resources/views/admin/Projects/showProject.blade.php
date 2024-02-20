
@extends('admin.common.main')
@section('containes')
@can('show-project')

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
                                <li class="breadcrumb-item text-dark">Uploaded Files Listing</li>
                            </ul>

                                <div class="col-sm-12">
                                    <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
                                    <?php echo $breadcrumb ?? ''; ?>
                                    </ol>
                               </div>
                        </div> 
                        <div class="d-flex align-items-center gap-2 gap-lg-3">

                            @can('add-project')
                                <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                    <div>
                                        <a href="{{route('create-project')}}" class="btn btn-primary" role="button">ADD PROJECT</a>
                                    </div>
                                    <br>
                                </div>
                            @endcan

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

        <!-- modal starts from here -->
        <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel"
            aria-hidden="true" data-file-id="" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="emailModalLabel">Send Email</h5><small
                            style="color:red; margin-top:6px;padding-left:8px;">[ Note : You can send multiple emails at
                            a Time ]</small>
                        <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12">
                                    <input type="text" id="mailIds" class="form-control"
                                        placeholder="Please enter email id :">
                                </div>
                            </div>
                            <small id="Error" style="color:red;"></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal"
                            id="sendEmailBtn">Send</button>
                    </div>
                </div>
            </div>
        </div>
             

        @if(Session::has('message'))
        <div style="text-align: center;">
            <div style="width: 500px; margin: 0 auto;" class="alert alert-success">{{ Session::get('message') }}</div>
        </div>
        @endif
        @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
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

                                List Of Projects:
                                

                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-7 gy-5" id="tableYajra">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th id="th">SR NO</th>
                                    <th id="th"> PROJECT NAME</th>
                                    <th id="th">STATUS</th>
                                    <th id="th">BY</th>
                                    <th id="th">ACTION</th>
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

        .emails {
            width: auto;
            padding: 5px;
            margin: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        </style>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <script>
        $(document).ready(function() {
            var table = $('#tableYajra').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                url: "{{ route('project-datatable') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },

                    {
                        data: 'name',
                        name: 'name'
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
                        data: 'created_by',
                        name: 'created_by'
                    },
                

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true,

                    },
                    
                ],
                order: [
                    [0, 'desc']
                ],
                
            });

            setTimeout(function() {
                $("div.alert-success").remove();
            }, 3000);
        });
        </script>
     
    </script>
        <script>
        $(document).ready(function() {
            console.log("ready!");

            $('body').on('click', '.DeleteProject', function () {
     
                var id = $(this).data("id");
                
                var userConfirmed = confirm("Are you sure you want to delete this Project!");
                var url = "{{ url('delete-project') }}/" + id;
                //  alert (url);
                if(userConfirmed){
                        $.ajax({
                            type: "get",
                            url: url,
                            success: function (data) {
                                // table.draw();
                                console.log(data);
                                // location.reload();
                                $('#tableYajra').DataTable().ajax.reload();
                                toastr.success('Project deleted successfully');
                                
                            },
                            error: function (data) {
                                // console.log('Error:', data);
                            }
                        });
                    }
            
                
            });
        });

        </script>
        @can('project-status')
        <script>
            $(document).ready(function() {
                    $('body').on('click', '.toggle-status-icon', function () {
                    var userId = $(this).data('id');
                        // alert(userId);
                    $.ajax({
                        type: 'GET', 
                        url: '/project-status/' + userId, 
                    
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


     @else

@endcan
   
    </body>

    </html>
    
    @endsection