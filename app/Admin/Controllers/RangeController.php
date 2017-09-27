<?php

namespace App\Admin\Controllers;

use App\Range;
use App\Status;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Session;
use Illuminate\Database\Query;
use Illuminate\Database\Eloquent;



class RangeController extends \App\Admin\AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function rangeList(Request $request, $id = null)
    {
        $sorting = ($request->input('sorting')) ? $request->input('sorting') : "desc";
        $field = ($request->input('field')) ? $request->input('field') : "id";
        $per_page = ($request->input('per_page')) ? $request->input('per_page') : "10";
        $range = Range::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting);
        $range = $range->paginate(\Config::get('admin.per_page'));
        return view('admin/range/list', ['ranges' => $range, 'sort' => $sorting,'per_page' => $per_page,'field' => $field]);
    }

    public function addOrEdit($id = null)
    {
        $rangeData = Range::where('id', $id)->first();
        return view('admin/range/add', ["rangesData" => $rangeData]);
    }

    public function save(Request $request, $id = null)
    {
        $this->validateRequest('range');
        $requestParams = app('request')->only(['range_name','range_id']);

        $range_id = $requestParams['range_id'];
        $range_name = $requestParams['range_name'];

        try {
            $rangeData = new Range;
            if ($range_id) {
                $rangeData = Range::whereId($range_id)->first();
            }
            $rangeData->title = $range_name;
            $rangeData->status_id = 1;
            $rangeData->save();

            return redirect('Admin/range')->with('success',''.$request->range_id>0.?'Range updated successfully':'Range added successfully');


//            return redirect('Admin/range')->with([
//                'status' => 200,
//                'message' => __('admin/range.range_data_save_successfully'),
//                'data' => $rangeData
//            ]);

        } catch (\Exception $e) {
            $this->error($e->getMessage(), 400);
        }
    }


    public function changeStatus(Request $request)
    {
        $status = $request->get('status', Status::$ACTIVE);
        /** @var Cms $category */
        $category = Range::find($request->get('id'));
        if ($category && ($status == Status::$ACTIVE || $status == Status::$INACTIVE)) {
            $category->status_id = $status;
            $category->save();
            return [
                'status' => '200'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('admin/range.invalid_range_id')
                ]
            ];
        }
    }


    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //  return Redirect::home();
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroyAll(Request $request)
    {

        $status = $request->get('status', Status::$DELETED);
        $ids = $request->get('id');

        /** @var Agency $range */
        $ranges = Range::whereIn('id', $ids);

        $ranges = $ranges->get();
        if (count($ranges) > 0) {
            foreach ($ranges as $range) {

                if ($range && ($status == Status::$ACTIVE || $status == Status::$INACTIVE || $status == Status::$DELETED)) {
                    $range->status_id = $status;
                    $range->save();
                }
            }
            return [
                'status' => '200'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('Invalid agency id')
                ]
            ];
        }
    }


    public function destroy(Request $request)
    {
        $status = $request->get('status', Status::$DELETED);
        /** @var Cms $category */
        $category = Range::find($request->get('id'));
        if ($category) {
            $category->status_id = $status;
            $category->save();
            return [
                'status' => '200',
                'message' => 'Range Deleted Successfully.'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('admin/range.invalid_range_id')
                ]
            ];
        }
    }

    function exportExcelFile()
    {
        $range = Range::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id', 'DESC')->get();
        $rangeArray = [[
            'id' => 'No.',
            'range_name' => 'Range Name',
            'created_at' => 'Created On',
        ]];
        $range->each(function(Range $range, $key) use (&$rangeArray){
            $rangeArray[$key+1]= [
                'id' => $key + 1,
                'range_name' => ($range->title) ? $range->title : '-',
                'created_at' => date('d-m-Y', strtotime($range->created_at)),
            ];
        });

        /**
         * @var Excel $excel
         */
        $excel = app('excel');
        return $excel->create('Range_'.Carbon::now()->toDateTimeString(), function($excel) use ($rangeArray) {
            $excel->setTitle('Range List');
            $excel->sheet('sheet1', function($sheet) use ($rangeArray) {
                $sheet->fromArray($rangeArray, null, 'A1', false, false);
            });
        })->download('xls',[
            'Access-Control-Allow-Origin' => '*'
        ]);
    }
    
}
