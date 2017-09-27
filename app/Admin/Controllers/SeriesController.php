<?php

namespace App\Admin\Controllers;

use App\Series;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SeriesController extends \App\Admin\AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function seriesList(Request $request, $id = null)
    {
        $sorting = ($request->input('sorting')) ? $request->input('sorting') : "desc";
        $field = ($request->input('field')) ? $request->input('field') : "id";
        $per_page = ($request->input('per_page')) ? $request->input('per_page') : "10";
        $series = Series::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting);
        $series= $series->paginate(\Config::get('admin.per_page'));
        return view('admin/series/list', ['seriess' => $series, 'sort' => $sorting,'per_page' => $per_page,'field' => $field]);
    }

    public function addOrEdit($id = null)
    {
        $seriesData = Range::where('id', $id)->first();
        return view('admin/series/add', ["seriesData" => $seriesData]);
    }

    public function save(Request $request, $id = null)
    {

        $seriesData = new Series;
        if($request->series_id)
        {
            $seriesData = Series::whereId($request->series_id)->first();
        }
        $seriesData->title = $request->series_name;
        $seriesData->status_id = 1;
        $seriesData->save();

        return redirect('Admin/series')->with('success',''.$request->series_id>0.?'Series updated successfully':'Series added successfully');

//        return redirect('Admin/series')->with([
//            'status' => 200,
//            'message' => __('admin/series.series_data_save_successfully'),
//            'data' => $seriesData,
//
//        ]);
    }


    public function changeStatus(Request $request)
    {
        $status = $request->get('status', Status::$ACTIVE);
        /** @var Cms $category */
        $category = Series::find($request->get('id'));
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
                    __('admin/series.invalid_range_id')
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

        /** @var Agency $series */
        $seriess = Series::whereIn('id', $ids);

        $seriess = $seriess->get();
        if (count($seriess) > 0) {
            foreach ($seriess as $series) {

                if ($series && ($status == Status::$ACTIVE || $status == Status::$INACTIVE || $status == Status::$DELETED)) {
                    $series->status_id = $status;
                    $series->save();
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
        $category = Series::find($request->get('id'));
        if ($category) {
            $category->status_id = $status;
            $category->save();
            return [
                'status' => '200',
                'message' => 'Series Deleted Successfully.'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('admin/series.invalid_series_id')
                ]
            ];
        }
    }

    function exportExcelFile()
    {
        $series = Series::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id', 'DESC')->get();
        $seriesArray = [[
            'id' => 'No.',
            'series_name' => 'Series Name',
            'created_at' => 'Created On',
        ]];
        $series->each(function(Series $series, $key) use (&$seriesArray){
            $seriesArray[$key+1]= [
                'id' => $key + 1,
                'series_name' => ($series->title) ? $series->title : '-',
                'created_at' => date('d-m-Y', strtotime($series->created_at)),
            ];
        });

        /**
         * @var Excel $excel
         */
        $excel = app('excel');
        return $excel->create('Series_'.Carbon::now()->toDateTimeString(), function($excel) use ($seriesArray) {
            $excel->setTitle('Series List');
            $excel->sheet('sheet1', function($sheet) use ($seriesArray) {
                $sheet->fromArray($seriesArray, null, 'A1', false, false);
            });
        })->download('xls',[
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

}
