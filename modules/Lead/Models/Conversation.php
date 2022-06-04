<?php
namespace Modules\Lead\Models;

use App\BaseModel;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\SEO;

class Conversation extends BaseModel
{
   

    protected $table = 'conversations';
    protected $fillable = [];
    // protected $slugField     = 'slug';
    // protected $slugFromField = 'title';

    // protected $seo_type = 'Lead';

  
}
