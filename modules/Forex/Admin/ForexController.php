<?php
namespace Modules\Forex\Admin;

use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Forex\Models\Forex;
use Modules\Forex\Models\ForexCountry;
use Modules\Page\Models\Page;
use Modules\Page\Models\PageTranslation;
use Modules\Template\Models\Template;
use Modules\Contact\Models\ForexOrders;
use Modules\Contact\Models\ForexOrderItems;

class ForexController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu('admin/module/forex');
        parent::__construct();
    }

    public function index(Request $request)
    {
        $page_name = $request->query('page_name');
        $datapage = new Forex();
        if ($page_name) {
            //$datapage = Forex::where('title', 'LIKE', '%' . $page_name . '%');
        }

        $datapage = $datapage->with('ForexCountry')->where('delete_status', 1)->orderBy('id', 'asc');
        $data = [
            'rows'        => $datapage->paginate(20),
            'page_title'=>__("Forex Management"),
            'breadcrumbs' => [
                [
                    'name' => __('Forex'),
                    'url'  => 'admin/module/forex'
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ]
        ];

        return view('Forex::admin.index', $data);
    }

    public function create(Request $request)
    {
        $row = new Page();
        $row->fill([
            'status' => 'publish',
        ]);

        $data = [
            'row'         => $row,
            'page_title'=>__("Create Forex"),
            'breadcrumbs' => [
                [
                    'name' => __('Forex'),
                    'url'  => 'admin/module/forex'
                ],
                [
                    'name'  => __('Add Forex'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Forex::admin.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $row = Forex::find($id);
        if (empty($row)) {
            return redirect('admin/module/forex');
        }

        $data = [
            'row' =>$row,
            'page_title'=>__("Edit Forex"),
            'breadcrumbs' => [
                [
                    'name' => __('Forex'),
                    'url'  => 'admin/module/forex'
                ],
                [
                    'name'  => __('Edit Forex'),
                    'class' => 'active'
                ],
            ]
        ];
        return view('Forex::admin.detail', $data);
    }
    public function delete(Request $request, $id)
    {

        $row = Forex::find($id);
        if (empty($row)) {
            return redirect('admin/module/forex');
        }
        $row->delete_status = 0;
        $row->save();
        return back()->with('success',  __('Forex Deleted') );
    }

    public function store(Request $request, $id){
        
        $country_id = $request->input('country_id');
        $exist = Forex::Where('country_id', $country_id)->count();
        if($id>0){
            $row = Forex::find($id);
            if($row->country_id != $country_id){
                if($exist != 0){
                    return back()->with('danger',  __('Forex already added') );
                }
            }
            if (empty($row)) {
                return redirect(route('page.admin.index'));
            }
        }else{
            if($exist == 0){
                $row = new Forex();
            }else{
                return back()->with('danger',  __('Forex already added') );
            }
            
        }

        $row->fill($request->input());
        $row->save();

        if($id > 0 ){
            return back()->with('success',  __('Forex updated') );
        }else{
            return redirect()->route('forex.admin.edit',['id'=>$row->id])->with('success', $id > 0 ?  __('Forex updated') : __('Forex created'));
        }
    }

    public function forexOrders(Request $request)
    {   

//         ForexOrders
// ForexOrderItems
        $page_name = $request->query('name');
        $datapage = new ForexOrders();
        if ($page_name) {
            //$datapage = Forex::where('title', 'LIKE', '%' . $page_name . '%');
        }

        $datapage = $datapage->orderBy('id', 'asc');
        $data = [
            'rows'        => $datapage->paginate(20),
            'page_title'=>__("Forex Orders"),
            'breadcrumbs' => [
                [
                    'name' => __('Forex'),
                    'url'  => 'admin/module/forex'
                ],
                [
                    'name'  => __('Forex Orders'),
                    'class' => 'active'
                ],
            ]
        ];

        return view('Forex::admin.orders', $data);
    }
    public function viewOrder(Request $request, $orderId)
    {   

        $datapage = ForexOrderItems::with('ForexCountry')->where('order_id', $orderId);
        $data = [
            'rows'        => $datapage->get(),
            'page_title'=>__("Forex Orders"),
            'breadcrumbs' => [
                [
                    'name' => __('Forex'),
                    'url'  => 'admin/module/forex'
                ],
                [
                    'name' => __('Forex Orders'),
                    'url'  => 'admin/module/forex/forex-order'
                ],
                [
                    'name'  => __('View Order'),
                    'class' => 'active'
                ],
            ]
        ];

        return view('Forex::admin.view-order', $data);
    }
}
