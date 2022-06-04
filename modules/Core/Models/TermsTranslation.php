<?php
namespace Modules\Core\Models;

use App\BaseModel;

class TermsTranslation extends BaseModel
{
    protected $table = 'bravo_terms_translations';
    protected $fillable = [
        'name',
        'content',
        'price',
        'type',
        'transfer_price',
        'inclusions',
        'duration',
        'exclude',
        'direction',
        'time_zone',
        'emails',
        'desc',
        'hide_in_single',
        'must'
    ];
    protected $cleanFields = [
        'content'
    ];
}