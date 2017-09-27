<?php

namespace App\Admin\Controllers;

use App\Rarity;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RarityController extends \App\Admin\AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function rarityList(Request $request, $id = null)
    {
        $sorting = ($request->input('sorting')) ? $request->input('sorting') : "desc";
        $field = ($request->input('field')) ? $request->input('field') : "id";
        $per_page = ($request->input('per_page')) ? $request->input('per_page') : "10";
        $rarity = Rarity::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting);
        $rarity = $rarity->paginate(\Config::get('admin.per_page'));
        return view('admin/rarity/list', ['raritys' => $rarity, 'sort' => $sorting, 'field' => $field, 'per_page' => $per_page]);
    }

    public function addOrEdit($id = null)
    {
        $rarityData = Rarity::where('id', $id)->first();

        return view('admin/rarity/add', ["raritysData" => $rarityData]);
    }

    public function save(Request $request, $id = null)
    {
        $rarityData = new Rarity;
        if($request->rarity_id)
        {
            $rarityData = Rarity::whereId($request->rarity_id)->first();
        }
        $rarityData->title = $request->rarity_name;
        $rarityData->status_id = 1;
        $rarityData->save();

        return redirect('Admin/rarity')->with('success',''.$request->rarity_id>0.?'Rarity updated successfully':'Rarity added successfully');

//        return redirect('Admin/rarity')->with([
//            'status' => 200,
//            'message' => __('admin/rarity.rarity_data_save_successfully'),
//            'data' => $rarityData,
//
//        ]);
    }

    public function changeStatus(Request $request)
    {
        $status = $request->get('status', Status::$ACTIVE);
        /** @var Cms $category */
        $category = Rarity::find($request->get('id'));
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
                    __('admin/rarity.invalid_rarity_id')
                ]
            ];
        }
    }

    function exportExcelFile()
    {
        $rarity = Rarity::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id', 'DESC')->get();
        $rarityArray = [[
            'id' => 'No.',
            'rarity_name' => 'Rarity Name',
            'created_at' => 'Created On',
        ]];
        $rarity->each(function(Rarity $rarity, $key) use (&$rarityArray){
            $rarityArray[$key+1]= [
                'id' => $key + 1,
                'rarity_name' => ($rarity->title) ? $rarity->title : '-',
                'created_at' => date('d-m-Y', strtotime($rarity->created_at)),
            ];
        });

        /**
         * @var Excel $excel
         */
        $excel = app('excel');
        return $excel->create('Rarity_'.Carbon::now()->toDateTimeString(), function($excel) use ($rarityArray) {
            $excel->setTitle('Rarity List');
            $excel->sheet('sheet1', function($sheet) use ($rarityArray) {
                $sheet->fromArray($rarityArray, null, 'A1', false, false);
            });
        })->download('xls',[
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    /* Single/Multiple Delete Rarity */
    public function delete(Request $request)
    {
        $selected = $request->selected;
        if ($selected != '') {
            foreach ($selected as $select) {
                $rarityData = Rarity::whereId($select)->first();
                $rarityData->status_id = Status::$DELETED;
                $rarityData->save();
            }
            return response()->json([
                'status' => 200
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'No Category Selected'
            ]);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
