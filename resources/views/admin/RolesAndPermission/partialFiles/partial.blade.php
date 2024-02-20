<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    
</head>
<body>

<div class="card card-primary">
			<div class="card-body">
                    
                <div class="form-group col-md-10 required d-flex">
                    
                  

                    <button class="btn btn-secondary btn-sm open_me" data-placement="left" title="Toggle Tree" id="toggle-tree">
                        <i class="fa fa-sitemap"></i>&nbsp;<i class="fa fa-caret-down" id="toggle-tree-button"></i>
                    </button>
                </div>

                <div class="row">
                    <div class="form-group form-float col-md-4" style="padding-left: 5.3%;">
                        <input type="text" id="jstree_q" class="form-control" placeholder="Search Permissions" style="border-bottom: 1px solid #dddddd;" />
                    </div>
                    <div class="form-group clearfix col-md-8 required">

                     <div id="jstree">  
                                <ul>
                                    <li data-jstree='{"icon":"fa fa-user-secret fa-lg theme"}' id="j_alltree">All Permissions (Not recommended)
                                        <ul>

                                        <?php
                                            $currmenu = 0;
                                            $submenu = 0;
                                            $maingroupchanged = 0;
                                            $i=0;
                                        ?>

                                        
                                  
                                        @foreach($permission as $pm)
                                        <?php
                                          $i++;
                                        ?>
                                            @if($currmenu == 0)
                                        
      
                                                <li data-jstree='{"icon":"fas fa-th-large fa-fw theme"}'>{{$pm->menu->title}} 
                                                    <ul>

                                                <?php
                                                    $currmenu = 0;
                                                    $submenu = 1;
                                              
                                                ?>
                                                  

                                            @endif
                                           
                                            @if($currmenu != $pm->menu_id)
                                                <?php
                                                    $currmenu = $pm->menu_id;
                                                    $maingroupchanged = 1;
                                                ?>

                                                    @if($submenu != 1)
                                                            </ul>
                                                        </li>
                                                    @endif
                                                    </ul>
                                                </li>

                                                <li data-jstree='{"icon":"fas fa-th-large fa-fw theme"}'>{{$pm->menu->title}}
                                                    <ul>
                                            @endif

                                            @if($submenu != $pm->sub_menu_id)
                                                <?php
                                                    $submenu = $pm->sub_menu_id;
                                                  
                                                ?>

                                                @if($maingroupchanged == 0)
                                                        </ul>
                                                    </li>
                                                @endif
                                                <?php
                                                        $maingroupchanged = 0;
                                                    ?>
                                                <li data-jstree='{"icon":"fas fa-th-large fa-fw theme"}'>{{$menus[$pm->sub_menu_id]}}
                                                    <ul> 
                                                 

                                                  
                                            @endif

                                            @if(in_array($pm->id, $roles_permissions))
                                                <li id="{{$pm->id}}" data-jstree='{"icon":"fa fa-info-circle blue","selected":true}'>{{$pm->title}}</li>
                                            @else
                                                <li id="{{$pm->id}}" data-jstree='{"icon":"fa fa-info-circle blue"}'>{{$pm->title}}</li>
                                            @endif

                                        @endforeach 

                                        </ul>
                                    </li>
                                </ul>
                        </div>

                        {{-- @foreach($permission as $value)
                        @if (strpos($value->name, 'View') !== FALSE) 
                            <hr />
                        @endif
                    <div class="icheck-primary d-inline">
                        <input type="checkbox" value="{{ $value->id }}" id="{{ $value->id }}" name="permission[]" {{ in_array($value->id, $rolePermissions) ? "checked" : "" }}>
                        <label for="{{ $value->id }}" class="font-weight-normal">{{ $value->name }}</label>
                    </div><br />
                    @endforeach

                        {!! Form::label("Permissions") !!} <br/>
                    @foreach($permission as $value)
                        {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name','id' => $value->id)) }}
                        {{ $value->name }}
                        <br/>
                    @endforeach
                        --}}
                    </div>
                </div>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-primary" title="Save" id="updatePerms" type="submit">Update</button>
            </div>
        </div>    

    <script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#perms').slideUp();
        // $('#jstree_q').hide();

    //create JSTREE
    $('#jstree').jstree({ "plugins" : [ "search","checkbox" ]});
    $('#jstree').on("changed.jstree", function (e, data) {
      $perms = data.selected;
  });

    //search filter
    var to = false;
    $('#jstree_q').keyup(function () {
        if(to) { clearTimeout(to); }
        to = setTimeout(function () {
            var v = $('#jstree_q').val();
        //$("#jstree").jstree("close_all");
        //$("#jstree").jstree("open_node", $('#j_alltree'));
        $('#jstree').jstree(true).search(v);
    }, 250);
    });

    var role_id = {{ $data->id }};

    $.ajaxSetup({
		headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
	});   
    //save permission
    $('#updatePerms').click(function(){

    var roleId = role_id;
    
    console.log(roleId);
    var selectedElmsIds = [];
    var selectedElms = $('#jstree').jstree('get_selected', true);

    $.each(selectedElms, function() {
        selectedElmsIds.push(this.id);
    });

    var url = "/storeshowroles_and_permission"

     console.log(selectedElmsIds);
    $.ajax({
        url: url,
        method: "POST",
        data: {selectedElmsIds:selectedElmsIds, roleid:roleId},
        success: function() {
            alert('Permission(s) updated successfully.');
            var url = "showroles_and_permission"
            location.href = url;
  
        },
        error: function() {
            alert('An error was encountered. Please try again.');
        }
    });
    });

  
  

    //toggle tree
    $('#toggle-tree').click(function(){
        if($(this).hasClass('open_me')){
            $('#jstree').jstree('open_all');
            $(this).removeClass('open_me');
            $(this).addClass('close_me');
            $('#toggle-tree-button').addClass('fa-caret-up');
            $('#toggle-tree-button').removeClass('fa-caret-down');
        }else{
            $('#jstree').jstree('close_all');
            $(this).removeClass('close_me');
            $(this).addClass('open_me');
            $('#toggle-tree-button').addClass('fa-caret-down');
            $('#toggle-tree-button').removeClass('fa-caret-up');
            $("#jstree").jstree("open_node", $('#j_alltree'));
        }
    });
});
</script>
</body>
</html>