<?php

namespace Sirgrimorum\Pages\Models;

use Illuminate\Database\Eloquent\Model;

class Pagina extends Model {

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

    /**
     * Get the flied value using the configuration array
     * 
     * @param string $key The field to return
     * @param boolean $justValue Optional If return just the formated value (true) or an array with 3 elements, label, value and data (detailed data for the field)
     * @return mixed
     */
    public function get($key, $justValue = true) {
        $celda = \Sirgrimorum\CrudGenerator\CrudGenerator::field_array($this, $key);
        if ($justValue) {
            return $celda['value'];
        } else {
            return $celda;
        }
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
