<?php
namespace Modules\Coupon\Admin;

use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Coupon\Models\Coupon;
use Modules\Page\Models\Page;
use Modules\Page\Models\PageTranslation;
use Modules\Template\Models\Template;

class CouponController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu('admin/module/coupon');
        parent::__construct();
    }

    public function index(Request $request)
    {
        $page_name = $request->query('page_name');
        $datapage = new Coupon();
        if ($page_name) {
            $datapage = Coupon::where('title', 'LIKE', '%' . $page_name . '%');
        }

        $datapage = $datapage->where('delete_status', 1)->orderBy('title', 'asc');
        $data = [
            'rows'        => $datapage->paginate(20),
            'page_title'=>__("Coupon Management"),
            'breadcrumbs' => [
                [
                    'name' => __('Coupon'),
                    'url'  => 'admin/module/coupon'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ]
        ];

        return view('Coupon::admin.index', $data);
    }

    public function create(Request $request)
    {
        $row = new Page();
        $row->fill([
            'status' => 'publish',
        ]);

        $data = [
            'row'         => $row,
            'translation'=>new Coupon(),
            'page_title'=>__("Create Coupon"),
            'breadcrumbs' => [
                [
                    'name' => __('Coupon'),
                    'url'  => 'admin/module/coupon'
                ],
                [
                    'name'  => __('Add Coupon'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Coupon::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $row = Coupon::find($id);
        if (empty($row)) {
            return redirect('admin/module/coupon');
        }

        $data = [
            'row' =>$row,
            'page_title'=>__("Edit Coupon"),
            'breadcrumbs' => [
                [
                    'name' => __('Coupon'),
                    'url'  => 'admin/module/coupon'
                ],
                [
                    'name'  => __('Edit Coupon'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Coupon::admin.detail', $data);
    }
    public function delete(Request $request, $id)
    {

        $row = Coupon::find($id);
        if (empty($row)) {
            return redirect('admin/module/coupon');
        }
        $row->delete_status = 0;
        $row->save();
        return back()->with('success',  __('Coupon Deleted') );
    }

    public function store(Request $request, $id){

        if($id>0){
            $row = Coupon::find($id);
            if (empty($row)) {
                return redirect(route('page.admin.index'));
            }
        }else{
            $row = new Coupon();
        }

        $row->fill($request->input());
        if(!empty($request->input('expire_date'))){
            $expire_date = str_replace("/", "-", $request->input('expire_date'));
            $expire_date = date('Y-m-d', strtotime($expire_date));
            $row->expire_date = $expire_date;
        }

        $row->save();

        if($id > 0 ){
            return back()->with('success',  __('Coupon updated') );
        }else{
            return redirect()->route('coupon.admin.edit',['id'=>$row->id])->with('success', $id > 0 ?  __('Coupon updated') : __('Coupon created'));
        }
    }
}
