@extends('admin.common.main')
@section('containes')
@can('view-all-org-data')
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
                                <li class="breadcrumb-item text-dark">Customer Listing</li>
                            </ul>
                            <div class="row ml-1 ">
                                <div class="col-sm-12">
                                    <ol class="breadcrumb ">
                                    <li class="breadcrumb-item"><a href="{{ route('home')}}">Home</a></li>
                                    <?php echo $breadcrumb ?? ''; ?>
                                    </ol>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="d-flex align-items-center gap-2 gap-lg-3">

                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                @can('add-user')
                                <div>
                                    <a href="{{route('create-user')}}" class="btn btn-primary"
                                        role="button">ADD USER</a>
                                </div>
                                @endcan
                                <br>
                            </div>

                            <a style="display:none" href="../../demo1/dist/.html" class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
                        </div> -->
                    </div>

                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                    </div>
                    <a style="display:none" href="../../demo1/dist/.html" class="btn btn-sm btn-primary"
                        data-bs-toggle="modal" data-bs-target="#kt_modal_create_app">Create</a>
                </div>
            </div>
        </div>

        <!-- @if(Session::has('message'))
        <div style="text-align: center;">
            <div style="width: 500px; margin: 0 auto;" class="alert alert-success">{{ Session::get('message') }}</div>
        </div>
        @endif -->
 
        <div class="post d-flex flex-column-fluid" id="kt_post">
            <!-- <div id="kt_content_container" class="container-xxl">
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
                                          
                    </div>
                </div>
            </div> -->

        </div>
        <div class="row g-5 g-xl-10 mb-xl-10 ml-3 mr-3">
            @foreach ($data as $orgdetails)
                                        
                <div class="col-5 col-md-5 col-lg-5 col-xl-6 col-xxl-3 mb-md-3 mb-xl-10 ">
                    <div class="card card-flush h-lg-100 mt-3">
                        <div class="card-header pt-3">
                            <h3 class="card-title text-gray-800">{{$orgdetails['name']}}</h3>
                            <div class="card-toolbar d-none">
                                <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" class="btn btn-sm btn-light    d-flex align-items-center px-4">
                                    <div class="text-gray-600 fw-bold">Loading date range...</div>
                                </div>
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body pt-3">
                            <div class="d-flex flex-stack">
                                <div class="text-gray-700 fw-semibold fs-6 me-2">No Of Users</div>
                                <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{$orgdetails['users']}}</span>                            
                                </div>
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                            <div class="d-flex flex-stack">
                                <div class="text-gray-700 fw-semibold fs-6 me-2">No Of Files</div>
                                <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{$orgdetails['file']}}</span>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                            <div class="d-flex flex-stack">
                                <div class="text-gray-700 fw-semibold fs-6 me-2">Total Size</div>
                                <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{$orgdetails['size']}}</span>
                                </div>
                            </div>
                            <div class="separator separator-dashed my-3"></div>
                            <div class="d-flex flex-stack">
                                <div class="text-gray-700 fw-semibold fs-6 me-2">Last Updated Date</div>
                
                                <div class="d-flex align-items-senter">
                                    <span class="text-gray-900 fw-bolder fs-6">{{$orgdetails['date']}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    </div>
    </html>
</main>
@endcan
   
@endsection