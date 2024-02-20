
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
                
                <div class="menu menu-column menu-rounded menu-sub-indention sidebar px-3" id="#kt_app_sidebar_menu"
                    data-kt-menu="true" data-kt-menu-expand="false">

               
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        @foreach(App\Models\Menu::orderBy('position','asc')->get() as $menuItem)    
    @php ($mnames = [])                  
    @php ($mnames[] = strtolower(trans(ltrim($menuItem->url,'\\'))))
        
    @if( $menuItem->parent_id == 0 )
        @php ($names = [])                
        @foreach($menuItem->children as $subMenuItemC)
            @php ($names[] = strtolower(trans(ltrim($subMenuItemC->url,'\\'))))
        @endforeach
        <li 
        @if( $menuItem->url == '' )   
                @if(in_array(strtolower(trans(request()->segment(1))), $names))            
                    class="nav-item has-treeview menu-open"
                @else
                    class="nav-item has-treeview"
                @endif
        @else
            class="nav-item"
        @endif     
        >
        <a href="{{ $menuItem->children->isEmpty() ? $menuItem->url : '#' }}"
        @if( $menuItem->children->isEmpty() )
            @if(in_array(strtolower(trans(request()->segment(1))), $mnames))
                class="nav-link active"
            @else            
                class="nav-link"
            @endif
        @else
            @if(in_array(strtolower(trans(request()->segment(1))), $names))
                class="nav-link active"
            @else            
                class="nav-link"
            @endif
        @endif         
        >
            <i class="nav-icon {{ $menuItem->icon }}"></i>
            <p>{{ $menuItem->title }}
            @if( $menuItem->url == '' )
            <i class="right fas fa-angle-left"></i>
            @endif
            </p>
        </a>
    @endif
  
    @if( ! $menuItem->children->isEmpty() )
        @if( $menuItem->url == '' )
            <ul class="nav nav-treeview">
        @else
            <ul>
        @endif
        @foreach($menuItem->children as $subMenuItem)
            @php ($snames = [])
            @php ($snames[] = strtolower(trans(ltrim($subMenuItem->url,'\\'))))
            <li class="nav-item">
                <a href="{{ $subMenuItem->url }}" 
                @if(in_array(strtolower(trans(request()->segment(1))), $snames))            
                    class="nav-link active"
                @else
                    class="nav-link"
                @endif                
                >
                <i class="nav-icon {{ $subMenuItem->icon }}"></i>
                <p>{{ $subMenuItem->title }}</p>
                </a>
            </li>
        @endforeach
            </ul>
    @endif
  </li> 

@endforeach

                    


                    

                  