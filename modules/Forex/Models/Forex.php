<?php
namespace Modules\Forex\Models;

use App\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\SEO;

class Forex extends BaseModel
{
    use SoftDeletes;

    protected $table = 'forex_master';
    protected $fillable = [
        'country_id',
        'sell_cash',
        'sell_card',
        'buy_cash',
        'buy_card',
        'note',
        'status'
    ];
    // protected $slugField     = 'slug';
    // protected $slugFromField = 'title';

    // protected $seo_type = 'Forex';
    public function ForexCountry()
    {
        return $this->belongsTo('Modules\Forex\Models\ForexCountry', 'country_id');
    }
    public function getDetailUrl($locale = false)
    {
        return route('page.detail',['slug'=>$this->slug]);
    }

    public static function getModelName()
    {
        return __("Forex");
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
        return url('admin/module/forex/edit/' . $this->id);
    }

}
