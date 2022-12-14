<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inv_itemcard_category extends Model
{
    use HasFactory;

    protected $table = "inv_itemcard_categories";
    protected $fillable = [
        'name','active','added_by','updated_by','com_code','date',
          ];

          public function inv_itemcards(){
            return $this->hasMany(Inv_itemcard::class , 'inv_itemcard_categories_id','id');
          }
}
