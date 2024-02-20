<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
    <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar"
        data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px"
        data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
        <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
           
            <h5 style="color:white; text-align:right; margin-right:20px;"><strong>SFMS</strong></h5>
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

                    <!--start new-->


                    @php ($urlname=strtolower(trans(request()->segment(1))))
                    @foreach(App\Models\Menu::orderBy('position','asc')->get() as $menuItem)
                        @php ($mnames = [])
                        @php ($mnames[] = strtolower(trans(ltrim($menuItem->url,'\\'))))
                    
                        @if( $menuItem->parent_id == 0 )
                        @php ($names = [])
                        
                        @foreach($menuItem->children as $subMenuItemC)
                            @php ($names[] = strtolower(trans(ltrim($subMenuItemC->url,'\\'))))
                        @endforeach
                       
                        
                        @if( ! $menuItem->children->isEmpty() )
                  
                            <div data-kt-menu-trigger="click" @if(in_array($urlname, $names)) class="menu-item hover show" @else
                                class="menu-item hover  " @endif>
                        @else
                            <div class="menu-item">
                        @endif

                                <span class="menu-link">
                                    <span class="menu-icon pr-3">
                                        <i class="{{ $menuItem->icon }}" style="font-size: 2em;">

                                        </i>
                                    </span>
                                    @if( $menuItem->url != '' )
                                        <span class="menu-title"><a href="{{ $menuItem->url}}">{{ $menuItem->title }}</a></span>
                                    @else
                                        <span class="menu-title">{{ $menuItem->title }}ww</span>
                                    @endif

                                    @if( ! $menuItem->children->isEmpty() )
                                        <span class="menu-arrow"></span>
                                    @endif
                                </span>

                                @if( ! $menuItem->children->isEmpty() )
                                 @foreach($menuItem->children as $subMenuItem)
                                     @php ($snames = [])
                                     @php ($snames[] = strtolower(trans(ltrim($subMenuItem->url,'\\'))))
                                        <div class="menu-sub menu-sub-accordion" @if(in_array($urlname, $snames)) style="" @endif>
                          
                                     @if( !$subMenuItem->children->isEmpty() )
                             
                                        <div data-kt-menu-trigger="click" @if(in_array($urlname, $snames))
                                            class="menu-item hover show" @else class="menu-item hover" @endif>
                                            
                                     @else
                                            <div class="menu-item ">
                                     @endif

                                                <a class="menu-link" href="{{ $subMenuItem->url }}">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>

                                                    <span class="menu-title">{{ $subMenuItem->title }}</span>
                                     <!-- @if( ! $subMenuItem->children->isEmpty() )
                                                    <span class="menu-arrow"></span>
                                        @endif -->
                                                </a>

                                                <!-- @if( !$subMenuItem->children->isEmpty() )
                                                @foreach($subMenuItem->children as $subMenuItemChild)
                                                @php ($cnames = [])
                                                @php ($cnames[] = strtolower(trans(ltrim($subMenuItemChild->url,'\\'))))
                                                <div class="menu-sub menu-sub-accordion" @if(in_array($urlname, $cnames))
                                                    style="" @endif>

                                                    <div class="menu-item">
                                                        <a class="menu-link" href="{{ $subMenuItemChild->url }}">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>

                                                            <span class="menu-title">{{ $subMenuItemChild->title }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                @endforeach

                                                @endif -->


                                            </div>
                                        </div>
                                        @endforeach

                                        @endif
                                    </div>
                                    @endif




                    @endforeach
                      
                         