@php ($urlname=strtolower(trans(request()->segment(1))))  
          @foreach(App\Models\Menu::orderBy('position','asc')->get() as $menuItem)    
          @php ($mnames = [])                  
          @php ($mnames[] = strtolower(trans(ltrim($menuItem->url,'\\'))))

          @if( $menuItem->parent_id == 0 )
          @php ($names = [])                
          @foreach($menuItem->children as $subMenuItemC)
          @php ($names[] = strtolower(trans(ltrim($subMenuItemC->url,'\\'))))
          @endforeach

          @if($urlname=='qrindexpagesd' || $urlname=='qrindexpagegen')
          @php ($urlname='qrindexpage')
          @endif
          <li 
          @if( $menuItem->url == '' )   
          @if(in_array($urlname, $names))        
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
            @if(in_array($urlname, $mnames))
            class="nav-link active"
            @else            
            class="nav-link"
            @endif
            @else
            @if(in_array($urlname, $names))
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

              @if($urlname=='qrindexpagesd' || $urlname=='qrindexpagegen')
              @php ($urlname='qrindexpage')
              @endif	

              @foreach($menuItem->children as $subMenuItem)
              @php ($snames = [])
              @php ($snames[] = strtolower(trans(ltrim($subMenuItem->url,'\\'))))
              <li class="nav-item">
                <a href="{{ $subMenuItem->url }}" 
                  @if(in_array($urlname, $snames))            
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