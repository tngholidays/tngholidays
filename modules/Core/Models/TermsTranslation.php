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
        'transfer_prices',
        'inclusions',
        'duration',
        'exclude',
        'direction',
        'time_zone',
        'emails',
        'must',
        'hide_in_single',
        'desc',
    ];
    protected $cleanFields = [
        'content'
    ];

     protected $casts = [
        'transfer_prices' => 'array'

    ];
}