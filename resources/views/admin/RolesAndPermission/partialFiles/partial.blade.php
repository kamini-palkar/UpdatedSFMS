<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        ul {
            list-style: none;
            padding-left: 20px;
        }

        li {
            position: relative;
            margin-bottom: 5px;
            border: 1px dotted #ccc;
            padding: 5px;
            background-color: #f9f9f9; 
        }

        input[type="checkbox"] {
            margin-right: 5px;
            transform: scale(0.8); 
        }

        a {
            text-decoration: none;
            color: #333;
        }

        a:hover {
            text-decoration: underline;
        }

       
        li:before {
            content: "▶";
            position: absolute;
            left: -15px;
            top: 0;
            cursor: pointer;
        }

        li.collapsed:before {
            content: "▶";
        }

        li.expanded:before {
            content: "▼";
        }

      
        ul ul {
            margin-left: 20px;
        }

        ul ul ul {
            margin-left: 40px;
        }

        ul ul ul ul {
            margin-left: 60px;
        }

        li > input[type="checkbox"] {
            /* display: none; */
        }

        li > ul > li > input[type="checkbox"] {
            /* display: none; */
        }

        li > ul > li > ul > li > input[type="checkbox"] {
            display: inline-block;
        }

        li > ul > li > ul > li > ul > li > input[type="checkbox"] {
            display: inline-block;
        }
    </style>
</head>
<body>

<label class="fs-6 fw-bold form-label mt-3">
    <span class="border-span">❂ Permissions </span>
</label>

<ul id="treeview">
    @foreach ($Menus as $menu)
        <li class="toggle">
            <a style="font-size: 15px;">{{ strtoupper($menu->title) }}</a>
            @if ($menu->submenus && count($menu->submenus) > 0)
                <ul>
                    @foreach ($menu->submenus as $submenu)
                        <li class="toggle">
                            <a style="font-size: 12px;">{{ strtoupper($submenu->title) }}</a>
                            @if ($submenu->permissions && count($submenu->permissions) > 0)
                                <ul>
                                    @foreach ($submenu->permissions as $permission)
                                        <li class="permission-item">
                                            <div class="form-check" style="margin-left: 1em;">
                                                <input type="checkbox" class="form-check-input" style="margin-top:-2px;" id="permission_{{ $permission->id }}"
                                                    value="{{ $permission->id }}"
                                                    {{ in_array($permission->id, $rolepermission) ? 'checked' : '' }}
                                                    name="permission[]">
                                                <label class="form-check-label" for="permission_{{ $permission->id }}" style="border: 1px dotted lightgrey;">{{ strtoupper($permission->name) }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
        </li>
    @endforeach
</ul>
<script src="{{ asset('js/treeview.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var treeview = document.getElementById('treeview');

        treeview.addEventListener('click', function (e) {
            if (e.target.tagName === 'A' && e.target.parentElement.tagName === 'LI' && e.target.parentElement.querySelectorAll('ul').length > 0) {
                e.target.parentElement.classList.toggle('collapsed');
                e.target.parentElement.classList.toggle('expanded');
                toggleSymbol(e.target.parentElement);
            }
        });

        function toggleSymbol(liElement) {
            var symbol = liElement.querySelector('a');
            if (liElement.classList.contains('collapsed')) {
                symbol.textContent = '▶';
            } else if (liElement.classList.contains('expanded')) {
                symbol.textContent = '▼';
            }
        }
    });
</script>


</body>
</html>