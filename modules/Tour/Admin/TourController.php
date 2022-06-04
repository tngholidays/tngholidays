<?php

    namespace Modules\Tour\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Modules\AdminController;
    use Modules\Core\Events\CreatedServicesEvent;
    use Modules\Core\Events\UpdatedServiceEvent;
    use Modules\Core\Models\Attributes;
    use Modules\Location\Models\LocationCategory;
    use Modules\Tour\Models\TourTerm;
    use Modules\Tour\Models\Tour;
    use Modules\Tour\Models\TourCategory;
    use Modules\Tour\Models\TourTranslation;
    use Modules\Location\Models\Location;
    use Modules\Hotel\Models\Hotel;
    use Modules\Hotel\Models\HotelRoom;
    use Modules\Coupon\Models\Coupon;
    use Modules\Core\Models\Terms;
        use Modules\Flight\Models\Flight;
    use DB;


    class TourController extends AdminController
    {
        protected $tourClass;
        protected $tourTranslationClass;
        protected $tourCategoryClass;
        protected $tourTermClass;
        protected $attributesClass;
        protected $locationClass;
        protected $hotelClass;
        protected $roomClass;
        /**
         * @var string
         */
        private $locationCategoryClass;

        public function __construct()
        {
            parent::__construct();
            $this->setActiveMenu('admin/module/tour');
            $this->tourClass = Tour::class;
            $this->tourTranslationClass = TourTranslation::class;
            $this->tourCategoryClass = TourCategory::class;
            $this->tourTermClass = TourTerm::class;
            $this->attributesClass = Attributes::class;
            $this->locationClass = Location::class;
            $this->locationCategoryClass = LocationCategory::class;
            $this->hotelClass = Hotel::class;
            $this->roomClass = HotelRoom::class;
        }

        public function index(Request $request)
        {
            $this->checkPermission('tour_view');
            $query = $this->tourClass::query();
            $query->orderBy('id', 'desc');
            if (!empty($tour_name = $request->input('s'))) {
                $query->where('title', 'LIKE', '%'.$tour_name.'%');
                $query->orderBy('title', 'asc');
            }
            if (!empty($cate = $request->input('cate_id'))) {
                $query->where('category_id', $cate);
            }
            if (!empty($location = $request->input('location_id'))) {
                $query->where('location_id', $location);
            }
            if ($this->hasPermission('tour_manage_others')) {
                if (!empty($author = $request->input('vendor_id'))) {
                    $query->where('create_user', $author);
                }
            } else {
                $query->where('create_user', Auth::id());
            }
            $data = [
                'rows'               => $query->with(['getAuthor', 'category_tour'])->paginate(20),
                'tour_categories'    => $this->tourCategoryClass::where('status', 'publish')->get()->toTree(),
                'tour_manage_others' => $this->hasPermission('tour_manage_others'),
                'locations' => Location::select('id', 'name')->where("status","publish")->orderBy('id', 'desc')->get(),
                'page_title'         => __("Tour Management"),
                'breadcrumbs'        => [
                    [
                        'name' => __('Tours'),
                        'url'  => 'admin/module/tour'
                    ],
                    [
                        'name'  => __('All'),
                        'class' => 'active'
                    ],
                ]
            ];
            return view('Tour::admin.index', $data);
        }

        public function recovery(Request $request)
        {
            $this->checkPermission('tour_view');
            $query = $this->tourClass::onlyTrashed();
            $query->orderBy('id', 'desc');
            if (!empty($tour_name = $request->input('s'))) {
                $query->where('title', 'LIKE', '%'.$tour_name.'%');
                $query->orderBy('title', 'asc');
            }
            if (!empty($cate = $request->input('cate_id'))) {
                $query->where('category_id', $cate);
            }
            if ($this->hasPermission('tour_manage_others')) {
                if (!empty($author = $request->input('vendor_id'))) {
                    $query->where('create_user', $author);
                }
            } else {
                $query->where('create_user', Auth::id());
            }
            $data = [
                'rows'               => $query->with(['getAuthor', 'category_tour'])->paginate(20),
                'tour_categories'    => $this->tourCategoryClass::where('status', 'publish')->get()->toTree(),
                'tour_manage_others' => $this->hasPermission('tour_manage_others'),
                'page_title'         => __("Recovery Tour Management"),
                'recovery'           => 1,
                'breadcrumbs'        => [
                    [
                        'name' => __('Tours'),
                        'url'  => 'admin/module/tour'
                    ],
                    [
                        'name'  => __('Recovery'),
                        'class' => 'active'
                    ],
                ]
            ];
            return view('Tour::admin.index', $data);
        }

        public function create(Request $request)
        {
            $this->checkPermission('tour_create');
            $row = new Tour();
            $row->fill([
                'status' => 'publish'
            ]);
            $data = [
                'row'               => $row,
                'attributes'        => $this->attributesClass::with('terms')->where('service', 'tour')->get(),
                'tour_category'     => $this->tourCategoryClass::where('status', 'publish')->get()->toTree(),
                'tour_location'     => $this->locationClass::where('status', 'publish')->get()->toTree(),
                'location_category' => $this->locationCategoryClass::where("status", "publish")->get(),
                'translation'       => new $this->tourTranslationClass(),
                'coupons'       => Coupon::where(["status"=>"publish","delete_status"=>1])->whereDate('expire_date','>=', date('Y-m-d'))->get(),
                'breadcrumbs'       => [
                    [
                        'name' => __('Tours'),
                        'url'  => 'admin/module/tour'
                    ],
                    [
                        'name'  => __('Add Tour'),
                        'class' => 'active'
                    ],
                ]
            ];
            return view('Tour::admin.detail', $data);
        }

        public function edit(Request $request, $id)
        {
            $this->checkPermission('tour_update');
            $row = $this->tourClass::find($id);
            if (empty($row)) {
                return redirect('admin/module/tour');
            }
            $translation = $row->translateOrOrigin($request->query('lang'));
            if (!$this->hasPermission('tour_manage_others')) {
                if ($row->create_user != Auth::id()) {
                    return redirect('admin/module/tour');
                }
            }
            $data = [
                'row'               => $row,
                'translation'       => $translation,
                "selected_terms"    => $row->tour_term->pluck('term_id'),
                'attributes'        => $this->attributesClass::where('service', 'tour')->get(),
                'tour_category'     => $this->tourCategoryClass::where('status', 'publish')->get()->toTree(),
                'tour_location'     => $this->locationClass::where('status', 'publish')->get()->toTree(),
                'location_category' => $this->locationCategoryClass::where("status", "publish")->get(),
                'coupons'       => Coupon::where(["status"=>"publish","delete_status"=>1])->get(),
                'enable_multi_lang' => true,
                'breadcrumbs'       => [
                    [
                        'name' => __('Tours'),
                        'url'  => 'admin/module/tour'
                    ],
                    [
                        'name'  => __('Edit Tour'),
                        'class' => 'active'
                    ],
                ]
            ];
            return view('Tour::admin.detail', $data);
        }

        public function store(Request $request, $id)
        {

            if ($id > 0) {
                $this->checkPermission('tour_update');
                $row = $this->tourClass::find($id);
                if (empty($row)) {
                    return redirect(route('tour.admin.index'));
                }
                if ($row->create_user != Auth::id() and !$this->hasPermission('tour_manage_others')) {
                    return redirect(route('tour.admin.index'));
                }

            } else {
                $this->checkPermission('tour_create');
                $row = new $this->tourClass();
                $row->status = "publish";
            }
            $row->fill($request->input());
            if ($request->input('slug')) {
                $row->slug = $request->input('slug');
            }
            $row->ical_import_url = $request->ical_import_url;
            $row->create_user = $request->input('create_user');
            $row->default_state = $request->input('default_state', 1);
            $row->enable_service_fee = $request->input('enable_service_fee');
            $row->service_fee = $request->input('service_fee');
            $res = $row->saveOriginOrTranslation($request->input('lang'), true);
            if ($res) {
                if (!$request->input('lang') or is_default_lang($request->input('lang'))) {
                    $this->saveTerms($row, $request);
                    $row->saveMeta($request);
                }
                if ($id > 0) {
                    event(new UpdatedServiceEvent($row));

                    return back()->with('success', __('Tour updated'));
                } else {
                    event(new CreatedServicesEvent($row));

                    return redirect(route('tour.admin.edit', $row->id))->with('success', __('Tour created'));
                }
            }
        }

        public function saveTerms($row, $request)
        {
            if (empty($request->input('terms'))) {
                $this->tourTermClass::where('tour_id', $row->id)->delete();
            } else {
                $term_ids = $request->input('terms');
                foreach ($term_ids as $term_id) {
                    $this->tourTermClass::firstOrCreate([
                        'term_id' => $term_id,
                        'tour_id' => $row->id
                    ]);
                }
                $this->tourTermClass::where('tour_id', $row->id)->whereNotIn('term_id', $term_ids)->delete();
            }
        }

        public function bulkEdit(Request $request)
        {

            $ids = $request->input('ids');
            $action = $request->input('action');
            if (empty($ids) or !is_array($ids)) {
                return redirect()->back()->with('error', __('No items selected!'));
            }
            if (empty($action)) {
                return redirect()->back()->with('error', __('Please select an action!'));
            }

            switch ($action) {
                case "delete":
                    foreach ($ids as $id) {
                        $query = $this->tourClass::where("id", $id);
                        if (!$this->hasPermission('tour_manage_others')) {
                            $query->where("create_user", Auth::id());
                            $this->checkPermission('tour_delete');
                        }
                        $row =$query->first();
                        if (!empty($row)) {
                            $row->delete();
                            event(new UpdatedServiceEvent($row));

                        }
                    }
                    return redirect()->back()->with('success', __('Deleted success!'));
                    break;
                case "recovery":
                    foreach ($ids as $id) {
                        $query = $this->tourClass::withTrashed()->where("id", $id);
                        if (!$this->hasPermission('tour_manage_others')) {
                            $query->where("create_user", Auth::id());
                            $this->checkPermission('tour_delete');
                        }
                        $row =$query->first();
                        if (!empty($row)) {
                            $row->restore();
                            event(new UpdatedServiceEvent($row));

                        }
                    }
                    return redirect()->back()->with('success', __('Recovery success!'));
                    break;
                case "clone":
                    $this->checkPermission('tour_create');
                    foreach ($ids as $id) {
                        (new $this->tourClass())->saveCloneByID($id);
                    }
                    return redirect()->back()->with('success', __('Clone success!'));
                    break;
                default:
                    // Change status
                    foreach ($ids as $id) {
                        $query = $this->tourClass::where("id", $id);
                        if (!$this->hasPermission('tour_manage_others')) {
                            $query->where("create_user", Auth::id());
                            $this->checkPermission('tour_update');
                        }
                        $row = $query->first();
                        $row->status = $action;
                        $row->save();

                        event(new UpdatedServiceEvent($row));
                    }
                    return redirect()->back()->with('success', __('Update success!'));
                    break;
            }
        }
        public function getHotels(Request $request)
        {
            $data = $request->all();
            $hotel_related = $this->hotelClass::select('id','title')->where('location_id', $data['location_id'])->where("status", "publish")->get();
            return $hotel_related;
        }
        public function getRooms(Request $request)
        {
            $data = $request->all();
            $rooms = $this->roomClass::orderBy('id', 'DESC')->where('parent_id',$data['hotel_id'])->where("status","publish")->get();
            if(isset($data['start_date']) && !empty($data['start_date'])){
                $start_date = str_replace("/", "-", $data['start_date']);
                $start_date = date('Y-m-d', strtotime($start_date));
                if (count($rooms) > 0) {
                    foreach ($rooms as $room) {
                        $room->getCustomDatesInRange($start_date,'','single');
                    }
                }
            }
            return $rooms;
        }
        public function getToursByLocation(Request $request)
        {
            $data = $request->all();
            if($data['type'] == 'location') {
                $array = [];
                $array['tours']  = getToursByLocation($data['location_id']);
                $attributesIds = [];
                if (!empty($array['tours'])) {
                    foreach ($array['tours'] as $row) {
                        $idss = $row->tour_term->pluck('term_id')->toArray();
                       $attributesIds=array_merge($attributesIds,$idss);
                    }
                }
                $attributes = getTermsById(array_unique($attributesIds));
                $durations = [];
                if (isset($attributes[12]) and count($attributes[12]) > 0) {
                    foreach ($attributes[12]['child'] as  $duration) {
                        $durations[] = $duration;
                    }
                }
                $array['durations'] = $durations;
                $sightseen = [];
                if (!empty($attributes)) {
                    foreach ($attributes as  $attribute) {
                        if (strpos($attribute['parent']->slug, 'sightseeing') !== false) {
                            $sightseen[] = $attribute;
                        }
                    }
                }
                $array['attributes'] = $sightseen;
                return $array;
            }
            if($data['type'] == 'sightseeing') {
                $terms = $data['sightseeings'];
                $model_Tour = $this->tourClass::select('bravo_tours.id','bravo_tours.title')->where("bravo_tours.status", "publish")->where('location_id', $data['location_id']);
                if(isset($data['sightseeings'])) {
                    if (is_array($terms) && !empty($terms)) {
                        $model_Tour->join('bravo_tour_term as tt', 'tt.tour_id', "bravo_tours.id")->whereIn('tt.term_id', $terms)->groupBy('tt.tour_id')->having(DB::raw('count(tt.tour_id)'), '>=', count($terms));
                    }
                }
                
                $tours = $model_Tour->get();
                return $tours;
            }
            
        }
        public function getTermsByAttr(Request $request)
        {
            $data = $request->all();
            $termss = getTermsByAttr($data['id']);
            return $termss;
        }
        public function getFlights(Request $request)
        {

            $data = $request->all();

            $query = Flight::select('id','title','departure_time','arrival_time');
            if(!empty($data['airport_from'])){
                $query->where('airport_from', $data['airport_from']);
            }
            if(!empty($data['airport_to'])){
                $query->where('airport_to', $data['airport_to']);
            }
            $results = $query->where("status", "publish")->get();
            return $results;
        }
    }
