<?php
namespace Modules\Coupon\Models;

use App\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\SEO;

class Coupon extends BaseModel
{
    use SoftDeletes;

    protected $table = 'coupons';
    protected $fillable = [
        'title',
        'discount_type',
        'discount',
        'code',
        'expire_date',
        'note',
        'status'
    ];
    // protected $slugField     = 'slug';
    // protected $slugFromField = 'title';

    // protected $seo_type = 'Coupon';

    public function getDetailUrl($locale = false)
    {
        return route('page.detail',['slug'=>$this->slug]);
    }

    public static function getModelName()
    {
        return __("Coupon");
    }

    public static function getAsMenuItem($id)
    {
        return parent::select('id', 'title as name')->find($id);
    }

    public static function searchForMenu($q = false)
    {
        $query = static::select('id', 'title as name');
        if (strlen($q)) {

            $query->where('title', 'like', "%" . $q . "%");
        }
        $a = $query->limit(10)->get();
        return $a;
    }

    public function getEditUrlAttribute()
    {
        return url('admin/module/coupon/edit/' . $this->id);
    }

}
