<?php

namespace Sirgrimorum\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Sirgrimorum\CrudGenerator\Traits\CrudGenForModels;

class Pagina extends Model {

    use CrudGenForModels;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    //The validation rules
    public $rules = [
    ];
    //The validation error messages
    public $error_messages = [
    ];
    //For serialization
    protected $with = [
            //'sections',
    ];

    public function _construct() {
        $this->error_messages = [
        ];
    }

    public function sections() {
        return $this->hasMany('Sirgrimorum\Pages\Models\Section', 'pagina_id', 'id');
    }

    public static function getByLink($link){
        if ($pagina = Pagina::where('id','=',$link)->first()){
            return $pagina;
        }
        if ($pagina = Pagina::all()->filter(function($pagina) use($link){
            return strtolower($pagina->get('link'))==str_replace(" ", "_", strtolower($link));
        })->first()){
            return $pagina;
        }
        return null;
    }

}
