<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;
use App\Traits\HasSlug;
class Category extends Model
{
    use HasFactory;
    use HasSlug;
    protected $fillable=['title','slug','summary','status','is_parent','parent_id','added_by'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public static function getAllCategory(){
        return  Category::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('id','ASC')->pluck('title','id');
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Category','parent_id','id')->where('status','active')->orderBy('title','ASC');
    }
    public static function getAllParentWithChild(){
        return Category::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    public function products()
    {
        return $this->hasMany(Products::class, 'cat_id', 'id')
                    ->where('status', 'active')
                    ->where('stock', '>', 0);
    }

    public function sub_products()
    {
        return $this->hasMany(Products::class, 'child_cat_id', 'id')
                    ->where('status', 'active')
                    ->where('stock', '>', 0);
    }

    public static function getProductByCat($slug)
    {
        return Category::with('products')->where('slug', $slug)->first();
    }

    public static function getProductBySubCat($slug)
    {
        return Category::with('sub_products')->where('slug', $slug)->first();
    }
    public function addedBy()
{
    return $this->belongsTo(User::class, 'added_by');
}
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
