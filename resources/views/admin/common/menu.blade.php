<div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
                            data-kt-menu="true" data-kt-menu-expand="false">
                        

                            <!-- get id from session and fetch all tree where that id is present -->
                            @php
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

                    @if($menuItem->parent_id == 0)
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
                                    <i class="{{ $menuItem->icon }}" style="font-size: 2em;"></i>
                                </span>
                                @if($menuItem->url != '')
                                <span class="menu-title">
                                    <a href="{{ $menuItem->url }}" @if($isActiveParent) class="active" @endif>
                                        {{ $menuItem->title }}
                                    </a>
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
                            
                            @endphp

                            <div class="menu-sub menu-sub-accordion" @if(in_array($urlname, $snames) || $isActiveChild)
                                style="" @endif>
                                @if(!$subMenuItem->children->isEmpty())
                                <div data-kt-menu-trigger="click" @if(in_array($urlname, $snames) || $isActiveChild) class="menu-item hover show"
                                    @else class="menu-item" @endif>
                                    @else
                                    <div class="menu-item">
                                        @endif

                                        <a class="menu-link" href="{{ $subMenuItem->url }}">
                                            <span class="menu-bullet">
                                                <span class="bullet bullet-dot"></span>
                                            </span>
                                            <span class="menu-title">{{ $subMenuItem->title }}</span> 
                                            @if(!$subMenuItem->children->isEmpty())
                                            <span class="menu-arrow"></span>
                                            @endif
                                        </a>

                                        @if(!$subMenuItem->children->isEmpty())
                                        @foreach($subMenuItem->children as $subMenuItemChild)
                                        @php
                                        $cnames = [];
                                        $cnames[] = strtolower(trans(ltrim($subMenuItemChild->url,'\\')));

                                        $isActiveGrandchild = false;

                                        if ($cat3== $subMenuItemChild->id) {
                                        $isActiveGrandchild = true;
                                       
                                        }
                                        if($isActiveGrandchild) {$active_class="active"; } else{$active_class="";} 
                                        @endphp
                                        
                                        <div class="menu-sub menu-sub-accordion" @if(in_array($urlname, $cnames) ||
                                            $isActiveGrandchild) style="" @endif>
                                            <div class="menu-item">
                                                <a class="menu-link sidebar-item <?php echo $active_class; ?>" href="{{ $subMenuItemChild->url }}"
                                                    data-menu-item-id="{{ $subMenuItemChild->id }}"
                                                    >
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">{{ $subMenuItemChild->title }}</span>
                                                </a>
                                            </div>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                @endif

                            </div>
                            @endif
                            @endforeach

                    </div>
                </div>
         