<?php

namespace Sirgrimorum\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Sirgrimorum\CrudGenerator\Traits\CrudGenForModels;

class Section extends Model {

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
            //'pagina',
    ];

    public function __construct(array $attributes = []) {
        parent::__construct($attributes);
        $this->error_messages = [
        ];
    }

    public function pagina() {
        return $this->belongsTo('Sirgrimorum\Pages\Models\Pagina', 'pagina_id', 'id');
    }

}
