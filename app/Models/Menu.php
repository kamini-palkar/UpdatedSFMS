<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    use HasFactory;

    protected $table = "menus";

    public $fillable = ['title', 'url', 'icon', 'parent_id', 'treecode', 'position', 'created_at'];

    public function childs()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Menu', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id')->orderBy('position');
    }

    public function submenus()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    
    public function permissions()
    {
        return $this->hasMany(PermissionModel::class, 'sub_menu_id');
    }
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
    public function childmenus()
    {
        return $this->hasMany(Menu::class, 'parent_id')->with('submenus');
    }

    public function submenu()
{
    return $this->belongsTo(Menu::class, 'sub_menu_id');
}


    protected $hidden = [
        'updated_at', 'parent_id', 'treecode'
    ];
}
