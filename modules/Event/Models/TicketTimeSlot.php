<?php

namespace Modules\Event\Models;

use ICal\ICal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Modules\Booking\Models\Bookable;
use Modules\Core\Models\SEO;
use Modules\Review\Models\Review;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Hotel\Models\HotelTranslation;
use Modules\User\Models\UserWishList;

class TicketTimeSlot extends Bookable
{
    use SoftDeletes;
    protected $table = 'ticket_time_slots';

    protected $fillable = [
        'time',
        'adult_price',
        'child_price',
        'parent_id',
        'status',
    ];



    protected $bookingClass;
    protected $roomDateClass;
    protected $hotelRoomTermClass;
    protected $roomBookingClass;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    public static function getModelName()
    {
        return __("Ticket Time Slots");
    }

    public static function getTableName()
    {
        return with(new static)->table;
    }

}
