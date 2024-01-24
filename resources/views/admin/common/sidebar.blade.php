
<?php
    $currentRoute = Route::currentRouteName();
?>
<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
        <a href="{{ route('home') }}">
    <img alt="Logo" src="{{ url('assets/media/avatars/sfms.PNG') }}" class="h-30px" style="padding-left: 40px;" />
</a>


            <div id="kt_app_sidebar_toggle"
                class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
                data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
                data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-duotone ki-double-left fs-2 rotate-180">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
            <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
                data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
                data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
                data-kt-scroll-save-state="true">
                <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">
                    <div data-kt-menu-trigger="click"
                        class="menu-item {{ $currentRoute === 'show-Info' ? 'here' : '' }} show menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon pr-3">
                                <i class="ki-duotone ki-element-12 fs-2 text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">Dashboards</span>
                            <span class="menu-arrow"></span>
                        </span>
                        @can('view-all-org-data')
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                            <a class="menu-link {{ in_array($currentRoute, ['show-Info']) ? 'active' : '' }}"
                                    href="{{ route('show-Info') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">View All Organisation</span>
                                </a>
                            </div>

                        </div>
                        @endcan
                    </div>
                    @can('sfms-master-show')
                    <div data-kt-menu-trigger="click"
                        class="menu-item {{ in_array($currentRoute, ['show-user', 'show-organisation']) ? 'here' : '' }} show menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon pr-3">
                                <i class="ki-duotone ki-element-11 fs-2 text-success">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">SFMS MASTER</span>
                            <span class="menu-arrow"></span>
                        </span>


                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                                <a class="menu-link {{ in_array($currentRoute, ['show-user', 'create-user','edit-user']) ? 'active' : '' }}"
                                    href="{{ route('show-user') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                   
                                    <span class="menu-title">USER</span>
                                </a>

                            </div>
                            <div class="menu-item">
                             <a class="menu-link {{ in_array($currentRoute, ['show-organisation', 'create-organisation' , 'edit-organisation']) ? 'active' : '' }}"
                                
                                    href="{{ route('show-organisation') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">ORGANISATION</span>
                                </a>
                            </div>
                            <div class="menu-item">
                             <a class="menu-link {{ in_array($currentRoute, ['show-project', 'create-project' , 'edit-project']) ? 'active' : '' }}"
                                
                                    href="{{ route('show-project') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">PROJECTS</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endcan
                    @can('file-master')
                    <div data-kt-menu-trigger="click"
                        class="menu-item {{ $currentRoute === 'show-files' ? 'here' : '' }} show menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon pr-3">
                                <i class="ki-duotone ki-element-12 fs-2 text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">FILE UPLOAD</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                            <a class="menu-link {{ in_array($currentRoute, ['show-files', 'upload-file']) ? 'active' : '' }}"
                                    href="{{ route('show-files') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">FILES</span>
                                </a>
                            </div>

                        </div>
                    </div>
                    @endcan
                    <!-- @can('ACL') -->
                    <div data-kt-menu-trigger="click"
                        class="menu-item show menu-accordion">
                        <span class="menu-link">
                            <span class="menu-icon pr-3">
                                <i class="fas fa-user-shield" style="font-size: 17px; color: skyblue;">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                </i>
                            </span>
                            <span class="menu-title">ACL</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <div class="menu-sub menu-sub-accordion">
                            <div class="menu-item">
                            <a class="menu-link {{ in_array($currentRoute, ['show-role', 'addRoles' , 'edit-role']) ? 'active' : '' }}"
                                    href="{{route('show-role')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">ROLES</span>
                                </a>
                            </div>

                            <div class="menu-item">
                            <a class="menu-link {{ in_array($currentRoute, ['show-permission', 'add-permission' , 'edit-permission']) ? 'active' : '' }}"
                                    href="{{route('show-permission')}}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">PERMISSIONS</span>
                                </a>
                            </div>

                            <div class="menu-item">
                            <a class="menu-link {{ in_array($currentRoute, ['showroles_and_permission']) ? 'active' : '' }}"
                                    href="/showroles_and_permission">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">ROLE HAS PERMISSIONS</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- @endcan -->

                  