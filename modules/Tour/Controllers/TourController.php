<?php

    namespace Modules\Tour\Controllers;
    use App\Http\Controllers\Controller;
    use Modules\Tour\Models\Tour;
    use Illuminate\Http\Request;
    use Modules\Tour\Models\TourCategory;
    use Modules\Location\Models\Location;
    use Modules\Review\Models\Review;
    use Modules\Core\Models\Attributes;
        use Modules\Hotel\Models\Hotel;
    use Modules\Hotel\Models\HotelRoom;
    use Modules\Coupon\Models\Coupon;
    use Modules\Core\Models\Terms;
    use DB;

    class TourController extends Controller
    {
        protected $tourClass;
        protected $locationClass;
        protected $tourCategoryClass;
        protected $attributesClass;

        public function __construct()
        {
            $this->tourClass = Tour::class;
            $this->locationClass = Location::class;
            $this->tourCategoryClass = TourCategory::class;
            $this->attributesClass = Attributes::class;
        }
        public function callAction($method, $parameters)
        {
            if(setting_item('tour_disable'))
            {
                return redirect('/');
            }
            return parent::callAction($method, $parameters); // TODO: Change the autogenerated stub
        }

        public function index(Request $request)
        {
            $is_ajax = $request->query('_ajax');
            $attributesIds = [];
            $listByLocation = $this->tourClass::select('id')->where("location_id", $request->query('location_id'))->where("status", "publish")->get();
            if (!empty($listByLocation)) {
                foreach ($listByLocation as $row) {
                    $idss = $row->tour_term->pluck('term_id')->toArray();
                   $attributesIds=array_merge($attributesIds,$idss);
                }
            }
            $list = call_user_func([$this->tourClass,'search'],$request);
            $markers = array();
            if (!empty($list)) {
                foreach ($list as $row) {
                    $markers[] = [
                        "id" => $row->id,
                        "title" => $row->title,
                        "lat" => (float)$row->map_lat,
                        "lng" => (float)$row->map_lng,
                        "gallery" => $row->getGallery(true),
                        "infobox" => view('Tour::frontend.layouts.search.loop-gird', ['row' => $row, 'disable_lazyload' => 1, 'wrap_class' => 'infobox-item'])->render(),
                        'marker' => url('images/icons/png/pin.png'),
                    ];
                }
            }
            $limit_location = 15;
            if( empty(setting_item("space_location_search_style")) or setting_item("space_location_search_style") == "normal" ){
                $limit_location = 1000;
            }
            $data = [
                'rows' => $list,
                'tour_category' => $this->tourCategoryClass::where('status', 'publish')->with(['translations'])->get()->toTree(),
                'tour_location' => $this->locationClass::where('status', 'publish')->with(['translations'])->limit($limit_location)->get()->toTree(),
                'tour_min_max_price' => $this->tourClass::getMinMaxPrice(),
                'markers' => $markers,
                "blank" => 1,
                "seo_meta" => $this->tourClass::getSeoMetaForPageList()
            ];
            $layout = setting_item("tour_layout_search", 'normal');
            if ($request->query('_layout')) {
                $layout = $request->query('_layout');
            }
            if ($is_ajax) {
                return $this->sendSuccess([
                    'html' => view('Tour::frontend.layouts.search-map.list-item', $data)->render(),
                    "markers" => $data['markers']
                ]);
            }
            $data['attributes'] = $this->attributesClass::where('service', 'tour')->where('is_filter', 1)->with(['terms','translations'])->get();
            $data['attributesIds'] = array_unique($attributesIds);
            if ($layout == "map") {
                $data['body_class'] = 'has-search-map';
                $data['html_class'] = 'full-page';
                return view('Tour::frontend.search-map', $data);
            }
            return view('Tour::frontend.search', $data);
        }

        public function detail(Request $request, $slug)
        {
            $row = $this->tourClass::where('slug', $slug)->with(['location','translations','hasWishList'])->first();
            if ( empty($row) or !$row->hasPermissionDetailView()) {
                return redirect('/');
            }
            $translation = $row->translateOrOrigin(app()->getLocale());
            $tour_related = [];
            $location_id = $row->location_id;
            if (!empty($location_id)) {
                $tour_related = $this->tourClass::where('location_id', $location_id)->where("status","publish")->take(4)->whereNotIn('id', [$row->id])->with(['location','translations','hasWishList'])->get();
            }
            $review_list = $row->getReviewList();
            $getBookingData = $row->getBookingData();
            $itineraries = array();
            $dayCount = 1;
            $k = 0;
            $bookingDate = $getBookingData['start_date'];
            if(isset($getBookingData['default_hotels'])){
                foreach ($getBookingData['default_hotels'] as $key => $hotel) {
                    $dateDay = "+$k day";
                    $default_date = date('d/m/Y', strtotime($getBookingData['start_date'] . $dateDay));
    
                    $days = $hotel['days'] * 2;
                    $noDays = $hotel['days'] * 2;
                    $dayPlus = "+$noDays day";
                    $hotel['check_in'] = date('d M, Y', strtotime($bookingDate));
                    $hotel['check_out'] = date('d M, Y', strtotime($bookingDate . $dayPlus));
    
                    $date = date('Y-m-d', strtotime($bookingDate . $dayPlus));
                    $bookingDate = date('Y-m-d', strtotime($date));
    
                    $getBookingData['default_hotels'][$key]['check_in'] = $hotel['check_in'];
                    $getBookingData['default_hotels'][$key]['check_out'] = $hotel['check_out'];
    
                    $getBookingData['by_default_hotels'][$key]['check_out'] = $hotel['check_out'];
                    $getBookingData['by_default_hotels'][$key]['check_out'] = $hotel['check_out'];
                    if (count($getBookingData['default_hotels']) == ($key+1)) {
                        $days += 1;
                    }
                    
                    $days = (int) $days;
                    $array['index'] = $key;
                    $j = 1;
                    // dd($row->itinerary);
                    $row->itinerary = array_combine(range(0, count($row->itinerary)-1), array_values($row->itinerary));
    
    
                    for ($i=0; $i < $days; $i++) {
                        $dayPlus = "+$k day";
                        $default_date = date('d/m/Y', strtotime($getBookingData['start_date'] . $dayPlus));
                        $array = array(
                            'transfer' => array(),
                            'morning_activity' => array(),
                            'hotel' => null,
                            'activity' => array(),
                            'evening_activity' => array(),
                            'day' => 'Day '.$dayCount,
                            'location' => $hotel['location_name'],
                            'location_id' => $hotel['location_id'],
                            'date' => $default_date,
                            'index' => $key,
                            'itinerary' => $row->itinerary[$k]
                        );
    
                        if (isset($row->itinerary[$k]['transfer'])) {
                            $terms = getTermOnly($row->itinerary[$k]['transfer'])->toArray();
    
                            foreach ($terms as $key => $term) {
                                // dd($term);
                                $terms[$key]['img_url'] = url('/uploads').'/'.getImageUrlById($term['image_id']);
                                $terms[$key]['inclusions_name'] = (isset($term['inclusions']) && !empty($term['inclusions'])) ? getInclusionsArray($term['inclusions']) : null;
                            }
                            $array['transfer'] = $terms;
                        }
                        if ($j == 1) {
                            $array['hotel'] = $hotel;
                        }
                        
                        
                        if (isset($row->itinerary[$k]['term']) && !empty($row->itinerary[$k]['term'])) {
                            $terms = getTermOnly($row->itinerary[$k]['term'])->toArray();
                            $morningArray = array();
                            $dayArray = array();
                            $eveningArray = array();
                            foreach ($terms as $key => $term) {
                                $term['img_url'] = url('/uploads').'/'.getImageUrlById($term['image_id']);
                                $term['inclusions_name'] = (isset($term['inclusions']) && !empty($term['inclusions'])) ? getInclusionsArray($term['inclusions']) : null;
    
                                if ($term['time_zone'] == 1) {
                                    $morningArray[] = $term;
                                }elseif ($term['time_zone'] == 3) {
                                    $eveningArray[] = $term;
                                }else{
                                    $dayArray[] = $term;
                                }
                            }
                            $array['morning_activity'] = $morningArray;
                            $array['activity'] = $dayArray;
                            $array['evening_activity'] = $eveningArray;
                        }
                        
                        $itineraries[] = $array;
                        $j++;
                        $dayCount++;
                        $k++;
                    }
                }
            }
            
            // dd($itineraries);
            $getBookingData['itineraries'] = $itineraries;

            $getBookingData['hotelrooms'] = array(array('adults'=>2,'children'=>0,'room'=>1,'price'=>1));
            $data = [
                'row' => $row,
                'translation' => $translation,
                'itineraries' => $itineraries,
                'tour_related' => $tour_related,
                'booking_data' => $getBookingData,
                'review_list' => $review_list,
                'seo_meta' => $row->getSeoMetaWithTranslation(app()->getLocale(), $translation),
                'body_class'=>'is_single'
            ];
            $this->setActiveMenu($row);
            return view('Tour::frontend.detail', $data);
        }
        public function getChangeHotels(Request $request)
        {
            $data = $request->all();
            $details = $data['default_hotels'];
            $details['total_guest'] = ($data['total_guest'] < 1) ? 1 : $data['total_guest'];
            $start_date = $data['start_date'];
            $hotels = Hotel::with('location','rooms')->whereHas('rooms', function($q){ $q->where('title','like','%standard%');})
            ->where('id', '!=', $details['hotel'])->where('location_id', $details['location_id'])->where("status", "publish")->get();
            $current = $details;
            return view('Tour::frontend.layouts.details.tour-change-hotel', compact('hotels','current','start_date'));
        }
        public function getChangeRooms(Request $request)
        {
            $data = $request->all();
            $details = $data['default_hotels'];
            $details['total_guest'] = ($data['total_guest'] < 1) ? 1 : $data['total_guest'];
            $start_date = $data['start_date'];
            $rooms = HotelRoom::where('id', '!=', $details['room'])->where('parent_id',$details['hotel'])->get();
            $current = $details;
            return view('Tour::frontend.layouts.details.tour-change-room', compact('rooms','current','start_date'));
        }
        public function getTourActivities(Request $request)
        {
            $data = $request->all();
            $term = null;
            $duration = 0;
            $evening = 0;
            if (isset($data['last_activity']) && count($data['last_activity']) > 0) {
                $term = Terms::where('time_zone','!=', 3)->whereNull('hide_in_single')->whereIn('id', $data['last_activity'])->first();

                $duration = Terms::where('time_zone','!=', 3)->whereNull('hide_in_single')->whereIn('id', $data['last_activity'])->get()->sum('duration');
                $evening = Terms::where('time_zone', 3)->whereNull('hide_in_single')->whereIn('id', $data['last_activity'])->count();
            }
            if (!empty($term)) {
                $query = Terms::whereNull('hide_in_single')->where('attr_id', $data['attribute']);
                
                $query->where(function ($q) use($term, $duration, $evening) {
                    if ($duration > 0) {
                        $duration = (8-$duration);
                        $q->where('duration', '<=', $duration);
                    }
                    $q->where('direction', $term->direction);
                    if ($evening == 0) {
                        $q->orWhere('time_zone', 3);
                    }
                });
                if (count($data['all_ids']) > 0) {
                   $query->whereNotIn('id', $data['all_ids']);
                }
                $termss = $query->get();
            }else{
                $query = Terms::whereNull('hide_in_single')->where('attr_id', $data['attribute']);
                if (count($data['all_ids']) > 0) {
                   $query->whereNotIn('id', $data['all_ids']);
                }
                if ($evening > 0) {
                    $query->where('time_zone', '!=', 3);
                }

                 $termss = $query->get();

            }
            $index = $data['index'];

            return view('Tour::frontend.layouts.details.tour-change-activity', compact('termss','index'));
        }
        public function applyCouponCode(Request $request)
        {
            $data = $request->all();
            $coupon = Coupon::select('id','title','code','discount_type','discount','code','note')->where('code','like','%'.$data['code'].'%')->whereDate('expire_date','>=', date('Y-m-d'))->first();
            if (!empty($coupon)) {
                return $coupon;
            }else{
                return 0;
            }
        }
    }
