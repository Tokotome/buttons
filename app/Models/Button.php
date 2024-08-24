<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    use HasFactory;
    
    public $timestamps = true;
    
    protected $table = 'buttons';
    
    protected $fillable = ['position', 'color', 'hyperlink'];
    
    protected $hidden = [];
}
