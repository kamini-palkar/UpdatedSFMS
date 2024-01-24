@extends('admin.common.main')
@section('containes')


@can('show-files')

<div class="d-flex align-items-center ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
</div>
</div>
</div>
</div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>



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
                        </div>
                        <div class="d-flex align-items-center gap-2 gap-lg-3">

                        @can('upload-files')
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <div>
                                    <a href="{{route('upload-file')}}" class="btn btn-primary" role="button">UPLOAD
                                        FILE</a>
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

         <!-- details modal starts from here -->
        <div class="modal fade" id="detailModal" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelHeading">Email Receivers</h4>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" id="closebtn"></button>

                    </div>
                    <div class="modal-body">
                        <span id="receiverEmail" class="col-sm-6 control-span"></span>
                    </div>
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

                                List Of Files

                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-7 gy-5" id="tableYajra">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                    <th id="th">SR NO</th>
                                    <th id="th">UNIQUE ID</th>
                                    <th id="th">FILE NAME</th>
                                    <th id="th">BY</th>
                                    <th id="th">ON</th>
                                    <th id="th">SIZE</th>
                                    <th id="th">ORGANISATION CODE</th>
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
                ajax: "{{ route('show-files') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },

                    {
                        data: 'unique_id',
                        name: 'unique_id'
                    },
                    {
                        data: 'name',
                        name: 'name',
                   
                    },
                    {
                        data: 'added_by',
                        name: 'added_by'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, full, meta) {

                            if (data) {
                                var formattedDate = moment(data).format('YYYY-MM-DD h:mm A');
                                return formattedDate;
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'org_code',
                        name: 'org_code',
                        render: function(data, type, full, meta) {
                            return '<span class="badge badge-success" style="margin-left:63px;padding:5px;">' +
                                data + '</span>';
                        }
                    },
                  

                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true,

                    },
                    { data: 'downloaded', name: 'downloaded', visible: false },

                ],
                order: [
                    [0, 'desc']
                ],
                rowCallback: function(row, data, index) {
                    var api = this.api();
                    var startIndex = api.page() * api.page.len();
                    var rowNum = startIndex + index + 1;
                    $(row).find('td:eq(0)').html(rowNum);
                   


                    var downloadedColIndex = table.column('downloaded:name').index();
                    var nameColIndex = table.column('name:name').index();

                    var user_id = "{{ auth()->id() }}";

                    if (downloadedColIndex !== undefined && downloadedColIndex !== null) {
                        if ('downloaded' in data) {
                            //  console.log(data);
                             var downloadedUserIds = data.downloaded.split(',');
                            if (!downloadedUserIds.includes(user_id)) {
                                $(row).find('td:eq(' + nameColIndex + ')').css('font-weight', 'bold');
                            }
                    
                        } 
                        else {
                            console.log("Invalid downloadedColIndex");
                        }
                    }

                },

            });

            $('#tableYajra tbody').on('click', 'a[data-target="#emailModal"]', function() {
                var uniqueId = $(this).data('file-id');
                $('#emailModal').data('file-id', uniqueId);
                $('#emailModal').find('#mailIds').val('');
            });

            setTimeout(function() {
                $("div.alert-success").remove();
            }, 3000);

           


     
     });
    </script>
        
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        
        <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
        <script>
       

    $('body').on('click', '.viewReceiver', function () {
              
               var id = $(this).data('id');
               var url = "{{ url('view-receiver') }}/" + id;
               // console.log('URL:', url);

                $.get(url, function (data) {
                    // console.log('Received data:', data);
                    $('#modelHeading').html("Email Receivers");
                    $('#receiverEmail').empty();
                   
            
                    if (Array.isArray(data)) {
                        data.forEach(function (item) {
                            var emailsArray = item.email.split(',');
                            var emailList = $('<ul>');
                            emailsArray.forEach(function (email) {
                                var listItem = $('<li>').text(email.trim());
                                emailList.append(listItem);
                            });
                            $('#receiverEmail').append(emailList);
                        });
                    } else {
                        $('#receiverEmail').text("Invalid data format");
                    }
                }).fail(function (xhr, status, error) {
                    console.error(xhr.responseText);
            });
        });
        


        
   
        </script>


        <script>
        $(document).ready(function() {
            $('#close').on('click', function() {
                $('#Error').text('');
            });
            $('#mailIds').on('input', function() {
                $('#Error').text('');
            });
            $('#sendEmailBtn').on('click', function() {
                var email = $('#mailIds').val();
                var fileId = $('#emailModal').data('file-id');

                if (email === '') {
                    $('#Error').text('Email id is required.');
                    return false;
                }

                if (email != '') {

                    emails = email.split(",");
                    var valid = true;
                    var regex =/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    var invalidEmails = [];

                    for (var i = 0; i < emails.length; i++) {

                        emails[i] = emails[i].trim();

                        // Check email against our regex to determine if email is valid
                        if (emails[i] == "" || !regex.test(emails[i])) {
                            invalidEmails.push(emails[i]);
                        }
                    }
                    if (invalidEmails != 0) {


                        toastr.error('Invalid Email : ' + invalidEmails.join(', '));
                        return false;
                    }
                }

                $('#Error').text('');



                $.ajax({
                    url: "{{ route('send-email') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email,
                        fileId: fileId
                    },
                    beforeSend: function() {
                        toastr.info('please wait email is sending....!', 'Processing');
                    },


                    success: function(response) {
                        $('#Error').text('');
                        console.log(response);
                        toastr.success('Email sent successfully!', 'Success');

                        if (response.success) {
                           
                            $('#emailModal').modal('hide');


                        }
                        console.log(response);
                    },
                    error: function(error) {
                        toastr.clear();
                        toastr.error('Error sending email', 'Error');

                    },


                });
            });
        });
        </script>

    </body>
    @endcan
    </html>
    
    @endsection