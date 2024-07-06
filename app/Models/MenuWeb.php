<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
use SolutionForest\FilamentTree\Concern\ModelTree;
 
class MenuWeb extends Model
{
    use ModelTree;
 
    protected $fillable = ["components", "parent_id", "title", "order"];
 
    protected $table = 'menu_web';
}