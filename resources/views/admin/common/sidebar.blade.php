
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
              

                    @php
                    $roleId= auth()->user()->role_id; 
                    $selectedMenuItemId = session('selected_menu_item_id');
              
                 
                    $treecode = '';
                        $cat1=0;
                        $cat2=0;        
                        $cat3=0; 
                    if ($selectedMenuItemId) {
                    $menuItem = App\Models\Menu::find($selectedMenuItemId);
                    
                    if ($menuItem) {
                        $treecode = $menuItem->treecode;
                   
                        $split_code=explode(':', $treecode);
                        $tc=count($split_code);
                    
                        for($c=0; $c < $tc; $c++){
                            $ac=$c+1;
                            ${"cat$ac"} = $split_code[$c]; 
                        }
                    }
                    }
                    
                    $urlname = strtolower(trans(request()->segment(1)));

                    $userPermissions = DB::table('permissions')
    ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
    ->where('role_has_permissions.role_id', $roleId)
    ->whereColumn('permissions.menu_id', '=', 'permissions.sub_menu_id')
    ->pluck('permissions.menu_id')->toArray();
 

                    @endphp
                   

                   
                    @foreach(App\Models\Menu::orderBy('position','asc')->get() as $menuItem)
                  
                    @php
                
                    $mnames = [];
                    $mnames[] = strtolower(trans(ltrim($menuItem->url,'\\')));
              
                    $isActiveParent = false;

                    if ($cat1 == $menuItem->id) {
                    $isActiveParent = true;
                    }
                   
                  
                    @endphp
                    
                    @if ($menuItem->parent_id == 0 )
                    @php
                    $names = [];
                    foreach($menuItem->children as $subMenuItemC) {
                    
                    $names[] = strtolower(trans(ltrim($subMenuItemC->url,'\\')));
                   
                    }
                    @endphp

                    @if(!$menuItem->children->isEmpty())
                  
                         <div data-kt-menu-trigger="click" @if(in_array($urlname, $names) || $isActiveParent)
                        class="menu-item hover show" @else class="menu-item" @endif>
                    @else
                          <div class="menu-item">
                    @endif

                            <span class="menu-link">
                                <span class="menu-icon pr-3">
                                    <i class="{{ $menuItem->icon }}" style="font-size: 1.5rem;"></i>
                                </span>
                                @if($menuItem->url != '')
                                <span class="menu-title">
                                    <a href="{{ $menuItem->url }} " @if($isActiveParent) class="active" @endif>
                                        {{ $menuItem->title }} </a>
                                </span>
                                @else
                                <span class="menu-title">{{ $menuItem->title }}</span>
                                @endif
                                @if(!$menuItem->children->isEmpty())
                                <span class="menu-arrow"></span>
                                @endif
                            </span>

                            @if(!$menuItem->children->isEmpty())
                            @foreach($menuItem->children as $subMenuItem)
                            @php
                       
                            $snames = [];
                            $snames[] = strtolower(trans(ltrim($subMenuItem->url,'\\')));

                            $isActiveChild = false;
                           
                            if ($cat2== $subMenuItem->id) {
                            $isActiveChild = true;
                            }
                      
                            if($isActiveChild) {$active_class="active"; } else{$active_class="";} 
                            @endphp

                            <div class="menu-sub menu-sub-accordion" @if(in_array($urlname, $snames) || $isActiveChild)
                                style="" @endif>
                                @if(!$subMenuItem->children->isEmpty())
                                <div data-kt-menu-trigger="click" @if(in_array($urlname, $snames) || $isActiveChild) class="menu-item hover show"
                                    @else class="menu-item" @endif>
                                    @else
                                    <div class="menu-item">
                                        @endif

                                        <a class="menu-link diplsidebarsubmenu sidebar-item <?php echo $active_class; ?>" href="javascript:void(0)" data-menu-item-id="{{ $subMenuItem->id }}" data-url="{{ $subMenuItem->url }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ $subMenuItem->title }}</span> 
                                            @if(!$subMenuItem->children->isEmpty())
                                            <span class="menu-arrow"></span>
                                            @endif
                                        </a>

                                      
                                    </div>
                                </div>
                                @endforeach
                                @endif

                            </div>
                            @endif
                            @endforeach

                    


                    

                  