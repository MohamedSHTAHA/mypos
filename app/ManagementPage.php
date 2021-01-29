<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ManagementPage extends Model
{
    use \Dimsav\Translatable\Translatable;

    protected $guarded = [];
    public $translatedAttributes = ['name', 'description'];

    public function pages()
    {
        return $this->hasMany(ManagementPage::class, 'management_page_id', 'id');
    }
}
