<?php
use Modules\Core\Models\Settings;
use App\Currency;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
    use Modules\Hotel\Models\Hotel;
    use Modules\Hotel\Models\HotelRoom;
    use Modules\Media\Models\MediaFile;
    use Modules\Location\Models\Location;
    use Modules\Coupon\Models\Coupon;
use Modules\Core\Models\Terms;
    use Modules\Tour\Models\Tour;
        use Modules\Core\Models\Attributes;
            use Modules\Flight\Models\Airport;
    use Modules\Flight\Models\Airline;
    
    use Modules\Flight\Models\Flight;
    use Modules\Booking\Models\Enquiry;
    use Modules\Lead\Models\LeadHistory;
     use Modules\Lead\Models\LeadComment;
    
    use Modules\Lead\Models\LeadReminder;
    
    use Modules\Forex\Models\ForexCountry;
      use Propaganistas\LaravelPhone\PhoneNumber;
      use Illuminate\Support\Facades\Config;

//include '../../custom/Helpers/CustomHelper.php';

define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS', 60 * MINUTE_IN_SECONDS );
define( 'DAY_IN_SECONDS', 24 * HOUR_IN_SECONDS );
define( 'WEEK_IN_SECONDS', 7 * DAY_IN_SECONDS );
define( 'MONTH_IN_SECONDS', 30 * DAY_IN_SECONDS );
define( 'YEAR_IN_SECONDS', 365 * DAY_IN_SECONDS );

function pr($string=array()) {
        echo "<pre>";
        print_r($string);
        die;
    }
function setting_item($item,$default = '',$isArray = false){

    $res = Settings::item($item,$default);

    if($isArray and !is_array($res)){
        $res = (array) json_decode($res,true);
    }

    return $res;

}
function setting_item_array($item,$default = ''){

    return setting_item($item,$default,true);

}

function setting_item_with_lang($item,$locale = '',$default = '',$withOrigin = true){

    if(empty($locale)) $locale = app()->getLocale();

    if($withOrigin == false and $locale == setting_item('site_locale')){
        return $default;
    }

    if( empty(setting_item('site_locale'))
        OR empty(setting_item('site_enable_multi_lang'))
        OR  $locale == setting_item('site_locale')
    ){
        $locale = '';
    }

    return Settings::item($item.($locale ? '_'.$locale : ''),$withOrigin ? setting_item($item,$default) : $default);

}
function setting_item_with_lang_raw($item,$locale = '',$default = ''){

    return setting_item_with_lang($item,$locale,$default,false);
}
function setting_update_item($item,$val){

    $s = Settings::where('name',$item)->first();
    if(empty($s)){
        $s = new Settings();
        $s->name = $item;
    }

    if(is_array($val) or is_object($val)) $val = json_encode($val);
    $s->val = $val;

    $s->save();

    Cache::forget('setting_' . $item);

    return $s;
}

function app_get_locale($locale = false , $before = false , $after = false){
    if(setting_item('site_enable_multi_lang') and app()->getLocale() != setting_item('site_locale')){
        return $locale ? $before.$locale.$after : $before.app()->getLocale().$after;
    }
    return '';
}

function format_money($price){

   return Currency::format((float)$price);

}
function format_money_main($price){

   return Currency::format((float)$price,true);

}

function currency_symbol(){

    $currency_main = get_current_currency('currency_main');

    $currency = Currency::getCurrency($currency_main);

    return $currency['symbol'] ?? '';
}

function generate_menu($location = '',$options = [])
{
    $options['walker'] = $options['walker'] ?? '\\Modules\\Core\\Walkers\\MenuWalker';

    $setting = json_decode(setting_item('menu_locations'),true);

    if(!empty($setting))
    {
        foreach($setting as $l=>$menuId){
            if($l == $location and $menuId){
                $menu = (new \Modules\Core\Models\Menu())->findById($menuId);
                $translation = $menu->translateOrOrigin(app()->getLocale());

                $walker = new $options['walker']($translation);

                if(!empty($translation)){
                    $walker->generate();
                }
            }
        }
    }
}

function set_active_menu($item){
    \Modules\Core\Walkers\MenuWalker::setCurrentMenuItem($item);
}

 function get_exceprt($string,$length=200,$more = "[...]"){
        $string=strip_tags($string);
        if(str_word_count($string)>0) {
            $arr=explode(' ',$string);
            $excerpt='';
            if(count($arr)>0) {
                $count=0;
                if($arr) foreach($arr as $str) {
                    $count+=strlen($str);
                    if($count>$length) {
                        $excerpt.= $more;
                        break;
                    }
                    $excerpt.=' '.$str;
                }
                }return $excerpt;
            }
}

function getDatefomat($value) {
    return \Carbon\Carbon::parse($value)->format('j F, Y');

}

function get_file_url($file_id,$size="thumb",$resize = true){
    if(empty($file_id)) return null;
    return \Modules\Media\Helpers\FileHelper::url($file_id,$size,$resize);
}

function get_image_tag($image_id,$size = 'thumb',$options = []){
    $options = array_merge($options,[
       'lazy'=>true
    ]);

    $url = get_file_url($image_id,$size);

    if($url){
        $alt = $options['alt'] ?? '';
        $attr = '';
        $class= $options['class'] ?? '';
        if(!empty($options['lazy'])){
            $class.=' lazy';
            $attr.=" data-src=".e($url)." ";
        }else{
            $attr.=" src='".e($url)."' ";
        }
        return sprintf("<img class='%s' %s alt='%s'>",e($class),e($attr),e($alt));
    }
}
function get_date_format(){
    return setting_item('date_format','m/d/Y');
}
function get_moment_date_format(){
    return php_to_moment_format(get_date_format());
}
function php_to_moment_format($format){

    $replacements = [
        'd' => 'DD',
        'D' => 'ddd',
        'j' => 'D',
        'l' => 'dddd',
        'N' => 'E',
        'S' => 'o',
        'w' => 'e',
        'z' => 'DDD',
        'W' => 'W',
        'F' => 'MMMM',
        'm' => 'MM',
        'M' => 'MMM',
        'n' => 'M',
        't' => '', // no equivalent
        'L' => '', // no equivalent
        'o' => 'YYYY',
        'Y' => 'YYYY',
        'y' => 'YY',
        'a' => 'a',
        'A' => 'A',
        'B' => '', // no equivalent
        'g' => 'h',
        'G' => 'H',
        'h' => 'hh',
        'H' => 'HH',
        'i' => 'mm',
        's' => 'ss',
        'u' => 'SSS',
        'e' => 'zz', // deprecated since version 1.6.0 of moment.js
        'I' => '', // no equivalent
        'O' => '', // no equivalent
        'P' => '', // no equivalent
        'T' => '', // no equivalent
        'Z' => '', // no equivalent
        'c' => '', // no equivalent
        'r' => '', // no equivalent
        'U' => 'X',
    ];
    $momentFormat = strtr($format, $replacements);
    return $momentFormat;
}

function display_date($time){

    if($time){
        if(is_string($time)){
            $time = strtotime($time);
        }

        if(is_object($time)){
            return $time->format(get_date_format());
        }
    }else{
       $time=strtotime(today());
    }

    return date(get_date_format(),$time);
}

function display_datetime($time){

    if(is_string($time)){
        $time = strtotime($time);
    }

    if(is_object($time)){
        return $time->format(get_date_format().' H:i');
    }

    return date(get_date_format().' H:i',$time);
}

function human_time_diff($from,$to = false){

    if(is_string($from)) $from = strtotime($from);
    if(is_string($to)) $to = strtotime($to);

    if ( empty( $to ) ) {
        $to = time();
    }

    $diff = (int) abs( $to - $from );

    if ( $diff < HOUR_IN_SECONDS ) {
        $mins = round( $diff / MINUTE_IN_SECONDS );
        if ( $mins <= 1 ) {
            $mins = 1;
        }
        /* translators: Time difference between two dates, in minutes (min=minute). %s: Number of minutes */
        if($mins){
            $since =__(':num mins',['num'=>$mins]);
        }else{
            $since =__(':num min',['num'=>$mins]);
        }

    } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
        $hours = round( $diff / HOUR_IN_SECONDS );
        if ( $hours <= 1 ) {
            $hours = 1;
        }
        /* translators: Time difference between two dates, in hours. %s: Number of hours */
        if($hours){
            $since =__(':num hours',['num'=>$hours]);
        }else{
            $since =__(':num hour',['num'=>$hours]);
        }

    } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
        $days = round( $diff / DAY_IN_SECONDS );
        if ( $days <= 1 ) {
            $days = 1;
        }
        /* translators: Time difference between two dates, in days. %s: Number of days */
        if($days){
            $since =__(':num days',['num'=>$days]);
        }else{
            $since =__(':num day',['num'=>$days]);
        }

    } elseif ( $diff < MONTH_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
        $weeks = round( $diff / WEEK_IN_SECONDS );
        if ( $weeks <= 1 ) {
            $weeks = 1;
        }
        /* translators: Time difference between two dates, in weeks. %s: Number of weeks */
        if($weeks){
            $since =__(':num weeks',['num'=>$weeks]);
        }else{
            $since =__(':num week',['num'=>$weeks]);
        }

    } elseif ( $diff < YEAR_IN_SECONDS && $diff >= MONTH_IN_SECONDS ) {
        $months = round( $diff / MONTH_IN_SECONDS );
        if ( $months <= 1 ) {
            $months = 1;
        }
        /* translators: Time difference between two dates, in months. %s: Number of months */

        if($months){
            $since =__(':num months',['num'=>$months]);
        }else{
            $since =__(':num month',['num'=>$months]);
        }

    } elseif ( $diff >= YEAR_IN_SECONDS ) {
        $years = round( $diff / YEAR_IN_SECONDS );
        if ( $years <= 1 ) {
            $years = 1;
        }
        /* translators: Time difference between two dates, in years. %s: Number of years */
        if($years){
            $since =__(':num years',['num'=>$years]);
        }else{
            $since =__(':num year',['num'=>$years]);
        }
    }

    return $since;
}

function human_time_diff_short($from,$to = false){
    if(!$to) $to = time();
    $today = strtotime(date('Y-m-d 00:00:00',$to));

    $diff = $from - $to;

    if($from > $today){
        return date('h:i A',$from);
    }

    if($diff < 5* DAY_IN_SECONDS){
        return date('D',$from);
    }

    return date('M d',$from);
}

function _n($l,$m,$count){
    if($count){
        return $m;
    }
    return $l;
}
function get_country_lists(){
    $countries = array
    (
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua And Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia And Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, Democratic Republic',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (Malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island & Mcdonald Islands',
        'VA' => 'Holy See (Vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic Of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle Of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KR' => 'Korea',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States Of',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts And Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre And Miquelon',
        'VC' => 'Saint Vincent And Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome And Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia And Sandwich Isl.',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard And Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad And Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks And Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.S.',
        'WF' => 'Wallis And Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    );
    return $countries;
}

function get_country_name($name){
    $all = get_country_lists();

    return $all[$name] ?? $name;
}

function get_page_url($page_id)
{
    $page = \Modules\Page\Models\Page::find($page_id);

    if($page){
        return $page->getDetailUrl();
    }
    return false;
}

function get_payment_gateway_obj($payment_gateway){

    $gateways = get_payment_gateways();

    if(empty($gateways[$payment_gateway]) or !class_exists($gateways[$payment_gateway]))
    {
        return false;
    }

    $gatewayObj = new $gateways[$payment_gateway]($payment_gateway);

    return $gatewayObj;

}

function recaptcha_field($action){
    return \App\Helpers\ReCaptchaEngine::captcha($action);
}

function add_query_arg($args,$uri = false) {

    if(empty($uri)) $uri = request()->url();

    $query = request()->query();

    if(!empty($args)){
        foreach ($args as $k=>$arg){
            $query[$k] = $arg;
        }
    }

    return $uri.'?'.http_build_query($query);
}

function is_default_lang($lang = '')
{
    if(!$lang) $lang = request()->query('lang');
    if(!$lang) $lang = request()->route('lang');

    if(empty($lang) or $lang == setting_item('site_locale')) return true;

    return false;
}

function get_lang_switcher_url($locale = false){

    $request =  request();
    $data = $request->query();
    $data['set_lang'] = $locale;

    $url = url()->current();

    $url.='?'.http_build_query($data);

    return url($url);
}
function get_currency_switcher_url($code = false){

    $request =  request();
    $data = $request->query();
    $data['set_currency'] = $code;

    $url = url()->current();

    $url.='?'.http_build_query($data);

    return url($url);
}


function translate_or_origin($key,$settings = [],$locale = '')
{
    if(empty($locale)) $locale = request()->query('lang');

    if($locale and $locale == setting_item('site_locale')) $locale = false;

    if(empty($locale)) return $settings[$key] ?? '';
    else{
        return $settings[$key.'_'.$locale] ?? '';
    }
}

function get_bookable_services(){

    $all = [];
    // Modules
    $custom_modules = \Modules\ServiceProvider::getModules();
    if(!empty($custom_modules)){
        foreach($custom_modules as $module){
            $moduleClass = "\\Modules\\".ucfirst($module)."\\ModuleProvider";
            if(class_exists($moduleClass))
            {
                $services = call_user_func([$moduleClass,'getBookableServices']);
                $all = array_merge($all,$services);
            }

        }
    }


    // Plugin Menu
    $plugins_modules = \Plugins\ServiceProvider::getModules();
    if(!empty($plugins_modules)){
        foreach($plugins_modules as $module){
            $moduleClass = "\\Plugins\\".ucfirst($module)."\\ModuleProvider";
            if(class_exists($moduleClass))
            {
                $services = call_user_func([$moduleClass,'getBookableServices']);
                $all = array_merge($all,$services);
            }
        }
    }

    // Custom Menu
    $custom_modules = \Custom\ServiceProvider::getModules();
    if(!empty($custom_modules)){
        foreach($custom_modules as $module){
            $moduleClass = "\\Custom\\".ucfirst($module)."\\ModuleProvider";
            if(class_exists($moduleClass))
            {
                $services = call_user_func([$moduleClass,'getBookableServices']);
                $all = array_merge($all,$services);
            }
        }
    }

    return $all;
}

function get_bookable_service_by_id($id){

    $all = get_bookable_services();

    return $all[$id] ?? null;
}

function file_get_contents_curl($url,$isPost = false,$data = []) {

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

    if($isPost){
        curl_setopt($ch, CURLOPT_POST, count($data));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function size_unit_format($number=''){
    switch (setting_item('size_unit')){
        case "m2":
            return $number." m<sup>2</sup>";
            break;
        default:
            return $number." ".__('sqft');
            break;
    }
}

function get_payment_gateways(){
    //getBlocks
    $gateways = config('booking.payment_gateways');
    // Modules
    $custom_modules = \Modules\ServiceProvider::getModules();
    if(!empty($custom_modules)){
        foreach($custom_modules as $module){
            $moduleClass = "\\Modules\\".ucfirst($module)."\\ModuleProvider";
            if(class_exists($moduleClass))
            {
                $gateway = call_user_func([$moduleClass,'getPaymentGateway']);
                if(!empty($gateway)){
                    $gateways = array_merge($gateways,$gateway);
                }
            }
        }
    }
    //Plugin
    $plugin_modules = \Plugins\ServiceProvider::getModules();
    if(!empty($plugin_modules)){
        foreach($plugin_modules as $module){
            $moduleClass = "\\Plugins\\".ucfirst($module)."\\ModuleProvider";
            if(class_exists($moduleClass))
            {
                $gateway = call_user_func([$moduleClass,'getPaymentGateway']);
                if(!empty($gateway)){
                    $gateways = array_merge($gateways,$gateway);
                }
            }
        }
    }

    //Custom
    $custom_modules = \Custom\ServiceProvider::getModules();
    if(!empty($custom_modules)){
        foreach($custom_modules as $module){
            $moduleClass = "\\Custom\\".ucfirst($module)."\\ModuleProvider";
            if(class_exists($moduleClass))
            {
                $gateway = call_user_func([$moduleClass,'getPaymentGateway']);
                if(!empty($gateway)){
                    $gateways = array_merge($gateways,$gateway);
                }
            }
        }
    }
    return $gateways;
}

function get_current_currency($need,$default = '')
{
    return Currency::getCurrent($need,$default);
}

function booking_status_to_text($status)
{
    switch ($status){
        case "draft":
            return __('Draft');
            break;
        case "unpaid":
            return __('Unpaid');
            break;
        case "paid":
            return __('Paid');
            break;
        case "processing":
            return __('Processing');
            break;
        case "completed":
            return __('Completed');
            break;
        case "confirmed":
            return __('Confirmed');
            break;
        case "cancelled":
            return __('Cancelled');
            break;
        case "cancel":
            return __('Cancel');
            break;
        case "pending":
            return __('Pending');
            break;
        case "partial_payment":
            return __('Partial Payment');
            break;
        case "fail":
            return __('Failed');
            break;
        default:
            return ucfirst($status ?? '');
            break;
    }
}
function verify_type_to($type,$need = 'name')
{
    switch ($type){
        case "phone":
            return __("Phone");
            break;
        case "number":
            return __("Number");
            break;
        case "email":
            return __("Email");
            break;
        case "file":
            return __("Attachment");
            break;
        case "multi_files":
            return __("Multi Attachments");
            break;
        case "text":
        default:
            return __("Text");
            break;
    }
}

function get_all_verify_fields(){
    return setting_item_array('role_verify_fields');
}
/*Hook Functions*/
function add_action($hook, $callback, $priority = 20, $arguments = 1){
    $args = func_get_args();
    $m = \Modules\Core\Helpers\HookManager::inst();
    $m->addAction($hook, $callback, $priority, $arguments);
}
function add_filter($hook, $callback, $priority = 20, $arguments = 1){
    $args = func_get_args();
    $m = \Modules\Core\Helpers\HookManager::inst();
    $m->addFilter($hook, $callback, $priority, $arguments);
}
function do_action(){
    $args = func_get_args();
    $m = \Modules\Core\Helpers\HookManager::inst();
    return call_user_func_array([$m,'action'],$args);
}
function apply_filters(){
    $args = func_get_args();
    $m = \Modules\Core\Helpers\HookManager::inst();
    return call_user_func_array([$m,'filter'],$args);
}
function is_installed(){
    return file_exists(storage_path('installed'));
}
function is_enable_multi_lang(){
    return (bool) setting_item('site_enable_multi_lang');
}

function is_enable_language_route(){
    return (is_installed() and is_enable_multi_lang() and app()->getLocale() != setting_item('site_locale'));
}

function duration_format($hour,$is_full = false)
{
    $day = floor($hour / 24) ;
    $hour = $hour % 24;
    $tmp = '';

    if($day) $tmp = $day.__('D');

    if($hour)
    $tmp .= $hour.__('H');

    if($is_full){
        $tmp = [];
        if($day){
            if($day > 1){
                $tmp[] = __(':count Days',['count'=>$day]);
            }else{
                $tmp[] = __(':count Day',['count'=>$day]);
            }
        }
        if($hour){
            if($hour > 1){
                $tmp[] = __(':count Hours',['count'=>$hour]);
            }else{
                $tmp[] = __(':count Hour',['count'=>$hour]);
            }
        }

        $tmp = implode(' ',$tmp);
    }

    return $tmp;
}
function is_enable_guest_checkout(){
    return setting_item('booking_guest_checkout');
}

function handleVideoUrl($string)
{
    if (strpos($string, 'youtu') !== false) {
        preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $string, $matches);

        if (!empty($matches[0])) return "https://www.youtube.com/embed/" . e($matches[0]);
    }
    return $string;
}

function is_api(){
    return request()->segment(1) == 'api';
}

function is_demo_mode(){
    return env('DEMO_MODE',false);
}
function credit_to_money($amount){
    return $amount * setting_item('wallet_credit_exchange_rate',1);
}

function money_to_credit($amount,$roundUp = false){
    $res = $amount / setting_item('wallet_credit_exchange_rate',1);

    if($roundUp) return ceil($res);

    return $res;
}

function clean_by_key($object, $keyIndex, $children = 'children'){
    if(is_string($object)){
        return clean($object);
    }

    if(is_array($object)){
        if(isset($object[$keyIndex])){
            $newClean = clean($object[$keyIndex]);
            $object[$keyIndex] =  $newClean;
            if(!empty($object[$children])){
                $object[$children] = clean_by_key($object[$children], $keyIndex);
            }

        }else{
            foreach($object as $key => $oneObject){
                if(isset($oneObject[$keyIndex])){
                    $newClean = clean($oneObject[$keyIndex]);
                    $object[$key][$keyIndex] =  $newClean;
                }

                if(!empty($oneObject[$children])){
                    $object[$key][$children] = clean_by_key($oneObject[$children], $keyIndex);
                }
            }
        }

        return $object;
    }
    return $object;
}
function periodDate($startDate,$endDate,$day = true,$interval='1 day'){
    $begin = new \DateTime($startDate);
    $end = new \DateTime($endDate);

//    if($begin==$end){
//        $end = $end->modify('+1 day');
//    }

    if($day){
        $end = $end->modify('+1 day');
    }


    $interval = \DateInterval::createFromDateString($interval);
    $period = new \DatePeriod($begin, $interval, $end);
    return $period;
}

function _fixTextScanTranslations(){
    return __("Show on the map");
}


function is_admin(){
    if(!auth()->check()) return false;
    if(auth()->user()->hasPermissionTo('dashboard_access')) return true;
    return false;
}
function is_vendor(){
    if(!auth()->check()) return false;
    if(auth()->user()->hasPermissionTo('dashboard_vendor_access')) return true;
    return false;
    }

function get_link_detail_services($services, $id,$action='edit'){
    if( \Route::has($services.'.admin.'.$action) ){
        return route($services.'.admin.'.$action, ['id' => $id]);
    }else{
        return '#';
    }

}

function get_link_vendor_detail_services($services, $id,$action='edit'){
    if( \Route::has($services.'.vendor.'.$action) ){
        return route($services.'.vendor.'.$action, ['id' => $id]);
    }else{
        return '#';
    }

}

function format_interval($d1, $d2 = ''){
    $first_date = new DateTime($d1);
    if(!empty($d2)){
        $second_date = new DateTime($d2);
    }else{
        $second_date = new DateTime();
    }


    $interval = $first_date->diff($second_date);

    $result = "";
    if ($interval->y) { $result .= $interval->format("%y years "); }
    if ($interval->m) { $result .= $interval->format("%m months "); }
    if ($interval->d) { $result .= $interval->format("%d days "); }
    if ($interval->h) { $result .= $interval->format("%h hours "); }
    if ($interval->i) { $result .= $interval->format("%i minutes "); }
    if ($interval->s) { $result .= $interval->format("%s seconds "); }

    return $result;
}
function getHotelsByLocation($location_id = null){
    if ($location_id != null) {
        $hotel_related = Hotel::select('id','title')->where('location_id', $location_id)->where("status", "publish")->get();
    }else{
        $hotel_related = Hotel::select('id','title')->where("status", "publish")->get();
    }
    return $hotel_related;
}
function getRoomsByHotel($hotel_id = null){
    if ($hotel_id != null) {
        $rooms = HotelRoom::select('id','title','price')->orderBy('id', 'DESC')->where("status", "publish")->where('parent_id',$hotel_id)->get();
    }else{
        $rooms = HotelRoom::select('id','title','price')->orderBy('id', 'DESC')->where("status", "publish")->get();
    }
    return $rooms;
}
function getHotelById($id){
    $data = Hotel::select('title','image_id','address','star_rate','emails','gallery')->where('id', $id)->first();
     $data['image_url'] = "";
    if (!empty($data->image_id)) {
        $data['image_url'] = url('public/uploads').'/'.getImageUrlById($data->image_id);
    }
    return $data;
}
function getRoomsById($id){
    $data = HotelRoom::where('id',$id)->first();
    $data['image_url'] = "";
    if (!empty($data->image_id)) {
        $data['image_url'] = url('public/uploads').'/'.getImageUrlById($data->image_id);
    }
    return $data;
}
function getLocationById($id){
    $data = Location::select('name')->where('id',$id)->first();
    return $data;
}
function getImageUrlById($id){
    $data = MediaFile::select('file_path')->where("id", $id)->first();
    return @$data->file_path;
}
function getHotelStandardRoom($hotel_id){
    $data = HotelRoom::select('id','title','price')->where("parent_id", $hotel_id)->where('title','like','%standard%')->where("status", "publish")->first();
    return @$data;
}
function getCouponById($id){
    $data = Coupon::select('id','title','code','discount_type','discount','code','note')->where("id", $id)->first();
    return @$data;
}
function getLocations(){
    $data = Location::select('id', 'name')->where("status","publish")->orderBy('id', 'desc')->get();
    return @$data;
}
function getDurationById($id){
    $data = Terms::select('id', 'name')->where("attr_id", 12)->where("id", $id)->first();
    return @$data;
}
function getDurations(){
    $data = Terms::select('id', 'name')->where("attr_id", 12)->orderBy('id', 'ASC')->get();
    return @$data;
}
function getToursByLocation($location_id){
    $data = Tour::select('id','title')->where('location_id', $location_id)->where("status","publish")->get();
    return @$data;
}
function getTermsById($ids){
    $data = Terms::getTermsById($ids);
    return @$data;
}
function getTermOnly($ids){
    $data = Terms::whereIn('id', $ids)->get();
    return @$data;
}
function getAttributeByType($type){
    $data = Attributes::select('id','name')->where('type', $type)->first();
    return @$data;
}
function getAllSightseeing(){
    $data = Attributes::select('id','name')->where('service', 'tour')->Where('name', 'like', '%sightseeing%')->get();
    return @$data;
}
function getTermsByAttr($attr_id){
    $data = Terms::select('id','name','desc','type')->where('attr_id', $attr_id)->get();
    return @$data;
}
function getProposalNote($type){
    if ($type == 'welcome_note') {
      $data = '<p>Good day, and I hope you are well!</p><p>Thank you for choosing TNG Holidays. Over the years, we have helped people create beautiful travel memories, just like we hope to do for you.</p><p>After reviewing your preferences and the available options, we are proposing the below package which we believe best matches your requirements. Kindly review the attached, and feel free to propose any amendments as desired.</p><p>It has been our pleasure to help you with your vacation arrangements, and we hope that it will bring you a wonderful holiday experience!</p>';
    }elseif ($type == 'term_condations') {
      $data = '<ul> <li>All Prices are in Indian Rupees and subject to change without prior notice.</li> <li>Price quoted are subject to availability at time of confirmation, we are currently not holding any blocking against the sent quotation.</li> <li>Tour prices are valid for Indian Nationals &amp; Foreigners holding Indian Resident Permit.</li> <li>Booking confirmations are subject to availability.</li> <li>All Hotels Rooms are subject to availability</li> <li>We are not holding any reservations of air seats, hotel rooms, conference rooms etc. Final availability status will only be known when we request for bookings.</li> <li>Holiday Surcharge will be additional if applicable</li> <li>Any overstay expenses due to delay or change or cancellation in flight will be on the guests own &amp; TNG Holidays will not be held liable for such expenses however we will provide best possible assistance.</li> </ul>';
    }elseif ($type == 'cancellation_note') {
      $data = '<p><p><strong>Cancellation Charge(Per Person)</strong></p> <table style="border-collapse: collapse; width: 100%;" border="1"> <tbody> <tr> <td style="width: 50%;"><strong>Days before departure:</strong></td> <td style="width: 50%;"><strong>Cancellation Charge:</strong></td> </tr> <tr> <td style="width: 50%;">10 days</td> <td style="width: 50%;">100%</td> </tr> <tr> <td style="width: 50%;">10 to 15 days</td> <td style="width: 50%;">75% + Non Refundable Component</td> </tr> <tr> <td style="width: 50%;">15 to 30 days</td> <td style="width: 50%;">30% + Non Refundable Component</td> </tr> <tr> <td style="width: 50%;">Hotel / Air</td> <td style="width: 50%;">100% in case of non-refundable ticket / Hotel Room</td> </tr> <tr> <td style="width: 50%;">Visa</td> <td style="width: 50%;">On Actual</td> </tr> </tbody> </table> <p>&nbsp;</p></p>';
    }elseif ($type == 'tips') {
      $data = '<p><strong>Payment Policy</strong></p> <table style="border-collapse: collapse; width: 100%; height: 82px; border-color: #000000; border-style: solid;" border="1"> <tbody> <tr style="height: 20px;"> <td style="width: 50%; height: 20px;">Payment Policy</td> <td style="width: 50%; height: 20px;">Online Advance as per Website</td> </tr> <tr style="height: 42px;"> <td style="width: 50%; height: 42px;">Within 45 to 30 days prior to the departure of the tour</td> <td style="width: 50%; height: 42px;">75% of total tour cost or Non Refundable component whichever is higher</td> </tr> <tr style="height: 20px;"> <td style="width: 50%; height: 20px;">Within 30 days prior to the departure of the tour</td> <td style="width: 50%; height: 20px;">100% of total tour cost</td> </tr> </tbody> </table> <p>&nbsp;</p>'; 
    }elseif ($type == 'other_note') {
      $data = '<p>Carry One Latest Photo with White Background (Size 4x6 cm)</p><p>Passport (Valid for 6 Month of Before Departure Date)</p><p>10000/- Baht Minumum at the time of thailand Arrival</p>';
    }elseif ($type == 'thankyou_note') {
      $data = '<p>Good day, and I hope you are well!</p><p>Thank you for choosing TNG Holidays. Over the years, we have helped people create beautiful travel memories, just like we hope to do for you.</p><p>After reviewing your preferences and the available options, we are proposing the below package which we believe best matches your requirements. Kindly review the attached, and feel free to propose any amendments as desired.</p><p>It has been our pleasure to help you with your vacation arrangements, and we hope that it will bring you a wonderful holiday experience!</p>';
    }
    return @$data;
}
function getArrayByValue($arrays, $key, $val)
{
  $data = array("desc" => "Age 18+","min" => "0","max" => "0","price" => "0");
  foreach ($arrays as $key2 => $array) {
    if (isset($array[$key]) && $array[$key] == $val) {
      $data = $array;
      break;
    }
  }
  return $data;
}
function getTermById($id){
    $data = Terms::find($id);
    return @$data;
}
function margeCustomTour($tour_id, $customTour){
    $tour = Tour::find($tour_id);
    foreach ($tour->getAttributes() as $key => $keyName) {
      if(isset($customTour[$key]) && !empty($customTour[$key])){
        $tour[$key] = $customTour[$key];
      }
    }
    foreach ($tour->meta->getAttributes() as $key2 => $keyName2) {
      if(isset($customTour[$key2]) && !empty($customTour)){
        $tour->meta[$key2] = $customTour[$key2];
      }else{
        if (strpos($key2, 'enable') !== false) {
            $tour->meta[$key2] = null;
        }
      }
    }
    foreach ($customTour['terms'] as $key3 => $keyName3) {
            $tour->tour_term[$key3] = getTermById($keyName3);
    }
    return @$tour;
}
function time_elapsed_string($datetime, $full = false){
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
function getAirports($id=null){
    if($id != null){
        $data = Airport::select('id', 'name','location_id')->Where('id',$id)->first();
    }else{
        $data = Airport::select('id', 'name','location_id')->orderBy('name', 'ASC')->get();
    }
    
    return @$data;
}
function getAirlines($id=null){
    if($id != null){
        $data = Airline::select('id', 'name','image_id')->Where('id',$id)->first();
    }else{
        $data = Airline::select('id', 'name')->orderBy('name', 'ASC')->get();
    }
    return @$data;
}
function getFlights($id=null){
    if($id != null){
        $data = Flight::Where('id',$id)->first();
    }else{
        $data = Flight::orderBy('name', 'ASC')->get();
    }
    return @$data;
}
function getTimeDiff($date1, $date2){
    $datetime1 = new DateTime($date1);
    $datetime2 = new DateTime($date2);
    $interval = $datetime1->diff($datetime2);
    return $interval->format('%h').'h '.$interval->format('%i')."m";
}
function getDaysDiff($date1, $date2){
    $from=date_create($date1);
    $to=date_create($date2);
    $diff=date_diff($to,$from);
    //$diff->format('%R%a days');
    return $diff->format('%a');
;
}
function getLastUserActivity($phone){
    $his = LeadHistory::where('phone',  $phone)->orderBy('id','DESC')->first();
     $result = null;
    if(!empty($his)){
        $his->content = $his->content.', '.date("d M y h:i A",strtotime($his->created_at));
        if($his->type == 'email'){
        $result = 'E-Mail Sent - '.$his->content;
        }elseif($his->type == 'comment'){
            $result = 'Comment Added - '.$his->content;
        }elseif($his->type == 'whatsapp'){
            $result = 'Send Whatsapp Message - '.$his->content;
        }elseif($his->type == 'reminder'){
            $result = 'Reminder Added - '.$his->content;
        }
    }
    return $result;
}
function getLeadLabel($label){
    
    if($label == 1){
        $lblText = 'Not Pickup';
        $lblColor = 'badge-primary';
    }elseif($label == 2){
        $lblText = 'Call Back';
        $lblColor = 'badge-info';
    }elseif($label == 3){
        $lblText = 'Not Decide';
        $lblColor = 'badge-warning';
    }elseif($label == 4){
        $lblText = 'On Hold';
        $lblColor = 'badge-danger';
    }elseif($label == 5){
        $lblText = 'Not Intrested';
        $lblColor = 'badge-success';
    }elseif($label == 6){
        $lblText = 'Cold Followup';
        $lblColor = 'badge-color6';
    }elseif($label == 7){
        $lblText = 'Not Contacted';
        $lblColor = 'badge-color7';
    }elseif($label == 8){
        $lblText = 'Sales Closed';
        $lblColor = 'badge-color8';
    }elseif($label == 9){
        $lblText = 'Sales Closed';
        $lblColor = 'badge-color9';
    }
    $result = array('color' => $lblColor,'text'=> $lblText);
    return $result;
}
function getForexCountry($id=null){
    if($id != null){
        $data = ForexCountry::select('id', 'name','code')->Where('id',$id)->first();
    }else{
        $data = ForexCountry::select('id', 'name','code')->get();
    }
    return @$data;
}
function addLeadRuno($lead){

     $dataArra = array();
      $phone = (string)PhoneNumber::make($lead->phone)->ofCountry('IN');
      $customer = array();
      $customer['name'] = (!empty($lead->name) ? $lead->name : null);
      $customer['phoneNumber'] = (!empty($phone) ? $phone : null);
      $customer['email'] = (!empty($lead->email) ? $lead->email : 'tng@gmail.com');
       
      $address = array(
      "street" => null,
      "city" => isset($lead->destination) ? @getLocationById($lead->destination)->name : null,
      "state" => null,
      "country" => 'India',
      "pincode" => null,
      );
        
      $persons = (int)(isset($lead->person_types[0]['name']) ? $lead->person_types[0]['number'] : 0);
      $persons += (int)(isset($lead->person_types[1]['name']) ? $lead->person_types[1]['number'] : 0);
      $persons += (int)(isset($lead->person_types[2]['name']) ? $lead->person_types[2]['number'] : 0);
      $kdm = array(
          "name" => (String)$persons,
          "phoneNumber" => (!empty($lead->approx_date) ? $lead->approx_date : null),
          );
      $customer['company']['name'] = isset($lead->destination) ? @getLocationById($lead->destination)->name : null;
      $customer['company']['address'] = $address;
      $customer['company']['kdm'] = $kdm;
      $dataArra['customer'] = $customer;
      $dataArra['priority'] = -1;
      $dataArra['notes'] = 'test';
      $dataArra['processName'] = "Default Process";
      $dataArra['assignedTo'] = "+917823070707";
      
      $userFields = [
          array('name'=>'source','value'=>''),
          array('name'=>'status','value'=>''),
          array('name'=>'Followup On','value'=>'')
      ];
      $dataArra['userFields'] = $userFields;
      //dd($dataArra);
    
      $endpoint = "https://api.runo.in/v1/crm/allocation";
      $client = new \GuzzleHttp\Client(['headers' => ['Auth-Key' => 'dHh4bTk2eGJyMjRsMW00bA==']]);
      $response = $client->post($endpoint,  ['json'=> $dataArra]);
      
      $result = $response->getBody()->getContents();
      $result = json_decode($result, true);
      $ret = null;
      if(isset($result['statusCode']) && $result['statusCode'] == 0) {
          $ret = 1;
      }
      
    return $ret;
}
function getAllLabel($text,$id=null){
    $array = array(1=>'not picked',2=>'call back',3=>'not decide',4=>'on hold',5=>'not interested',6=>'cold followup',7=>'not contacted',8=>'sales closed');
    if($id != null){
        $val = $array[$id];
    }else{
        $val = array_search(strtolower($text),$array,true);
    }
    return $val;
}
function getArrayByVal($arrays, $val){
    $data = null;
    foreach ($arrays as $key => $array) {
        if ($array['name'] == $val) {
          $data = $array;
          break;
        }
      }
    return $data;
}
function leadSetReminder($data){
    
    if (!empty($data['content'])) {
        $lead = Enquiry::find($data['id']);
        $row = new LeadReminder();
        
        $date = str_replace("/", "-", $data['date']);
        
        $date = date('Y-m-d', strtotime($date));
        $time = date('H:i:s', strtotime($data['time']));
        $dateTime = $date.' '.$time;
        $row->fill($data);
        $row->date = $dateTime;
        $row->enquiry_id = $lead->id;
        $row->phone = $lead->phone;
        $row->status = 'publish';
        $row->save();

        $history = new LeadHistory();
        $history->enquiry_id = $lead->id;
        $history->phone = $lead->phone;
        $history->content = $row->content;
        $history->type = 'reminder';
        $history->save();
    }
}
function storeLeadComment($data){
    
    if (!empty($data['content'])) {
        $lead = Enquiry::find($data['id']);
        $row = new LeadComment();
        $row->fill($data);
        $row->enquiry_id = $lead->id;
        $row->phone = $lead->phone;
        $row->status = 'publish';
        $row->save();
        

        $history = new LeadHistory();
        $history->enquiry_id = $lead->id;
        $history->phone = $lead->phone;
        $history->content = $row->content;
        $history->type = ($data['type'] == 2) ? 'whatsapp' : 'comment';
        $history->save();
    }
}
function getInclusions($id = null){
    $data = array(1=>'Ticket',2=>'Private Transfer',3=>'Shared Transfer',4=>'Breackfast',5=>'Lunch',6=>'Dinner');
    if ($id != null) {
       $data = $data[$id];
    }
    return $data;
}
function getDirections($id = null){
    $data = array(1=>'East',2=>'West',3=>'North',4=>'South',5=>'Center');
    if ($id != null) {
       $data = $data[$id];
    }
    return $data;
}
function getAttrTypes($id = null){
    $data = array(1=>'Sightseeing',2=>'Flight',3=>'Meal',4=>'Restaurant',5=>'Transfers',6=>'Duration',7=>'Facilities',8=>'Hotel',9=>'Extra Content',10=>'Transport Vendor');
    if ($id != null) {
       $data = $data[$id];
    }
    return $data;
}
function getInclusionsArray($ids){
    $arr = [];
    foreach ($ids as $key => $id) {
       $arr[] = getInclusions($id);
    }
    return implode(", ",$arr);
}
function getArrayByColumn($arrays, $column, $val){
    $data = null;
    foreach ($arrays as $key => $array) {
        if (isset($array[$column]) && $array[$column] == $val) {
          $data = $array;
          break;
        }
      }
    return $data;
}
function getExtraContentTypes($type=null) {
    
    $data = array(
        "duration_timings"=>"Duration and Timings",
        "itinerary"=>"Itinerary",
        "tickets_eligibility"=>"Tickets and Eligibility",
        "how_to_use_ticket"=>"How To Use Ticket",
        "remarks"=>"Remarks",
        "inclusive"=>"Inclusive",
        "not_inclusive"=>"Not Inclusive",
        "pick_up_information"=>"Pick Up Information",
        "what_to_bring"=>"What to Bring",
        "more_details_about"=>"More Details about",
        "confirmation_policy"=>"Confirmation Policy",
        "refund_policy"=>"Refund Policy",
        "booking_policy"=>"Booking Policy",
        "cancellation_policy"=>"Cancellation Policy",
        "payment_terms_policy"=>"Payment Terms Policy"
    );



    if ($type != null) {
        $data = $data[$type];
    }
    return $data;
}
function sendWhatsappBulkMsg($post)
{
    
    $SMS_TOKEN_KEY = setting_item('sms_whatsapp_token');
    $data = [
           'key' => $SMS_TOKEN_KEY,
           'mobileno' => $post['mobileno'], //comma separeted multiple mobile numbers
           'msg'   => $post['message'],
           'messageType'=>'regular',
           'type'=>"Text",
    ];
    if(!empty($post['file'])){
        $data['File'] = $post['file'];
        $data['type'] = 'Image';
    }
    $curl = WhatsAppCurl($data);
    $result = json_decode($curl,true);
    if(isset($result['status']) && $result['status']=='Error'){
        throw  new SmsException($result['msg']);
    }
    return $result;
}
function WhatsAppCurl($data){
    
    $ch = curl_init('https://www.cp.bigtos.com/api/v1/send-bulk-messages');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}
function calculateDisByPeople($amount, $type, $disVal)
{
    $type_total = 0;
    switch ($type) {
        case "fixed":
            $type_total = $disVal;
            break;
        case "percent":
            $type_total = $amount / 100 * $disVal;
            break;
    }
    return $amount-$type_total;
}

function getTransPriceByAdult($array, $totalGuest)
{

    $result = 0;

    if (isset($array)) {
        foreach ($array as $key => $value) {
            if ($value['from'] <= $totalGuest && $value['to'] >= $totalGuest) {
                $result = floatval($value['amount']);
            }
        }
    }
    return $result;
}

function roomWiseHotelPrice($price, $hotel_rooms)
{   
    $totalHotelPrice = 0;
    if (!empty($hotel_rooms) && count($hotel_rooms)) {
        foreach ($hotel_rooms as $key => $room) {
            if ($room['adults'] > 1) {
                $totalHotelPrice += $price * $room['adults'];
            }else{
                $totalHotelPrice += $price * 2;
            }

            if ($room['adults'] > 1 && $room['children'] == 1) {
                $totalHotelPrice += $price / 2;
            }else if($room['children'] > 1){
                $totalHotelPrice += $price;
            }
            
        }
    }
    return $totalHotelPrice;
}

function calculateTermPriceWithTrans($terms, $total_guests)
{   
    $array = ['price' => 0, 'transfer_price'=>0];
    if (count($terms) > 0) {
        foreach ($terms as $key => $term) {
            if (!empty($term['price']) && $term['price'] > 0) {
                $array['price'] += (float)$term['price']*$total_guests;
            }

            if (!empty($term['transfer_prices']) && $term['transfer_prices'] > 0) {
                foreach ($term['transfer_prices'] as $key => $transfer) {
                    if ($transfer['from'] <= $total_guests and $transfer['to'] >= $total_guests) {
                        $array['transfer_price'] += $transfer['amount'];
                    }
                }
            }
        }
    }
    
    return $array;
}
function getAttributeByTerm($attr_id){
    $data = Attributes::select('id','name','type')->where('id',$attr_id)->first();
    return @$data;
}