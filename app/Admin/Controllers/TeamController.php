<?php

namespace App\Admin\Controllers;

use App\Team;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Excel;

class TeamController extends \App\Admin\AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function teamList(Request $request, $id = null)
    {

        $sorting = ($request->input('sorting')) ? $request->input('sorting') : "desc";
        $field = ($request->input('field')) ? $request->input('field') : "id";
        $per_page = ($request->input('per_page')) ? $request->input('per_page') : "10";
        $teams = Team::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting);
        $teams = $teams->paginate(\Config::get('admin.per_page'));
        return view('admin/team/list', ['teams' => $teams, 'sort' => $sorting, 'field' => $field, 'per_page' => $per_page]);
    }

    function exportExcelFile(){
        $teams = Team::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id', 'DESC')->get();
        $teamArray = [[
            'id' => 'No.',
            'team_name' => 'Team Name',
            'created_at' => 'Created On',
        ]];
        $teams->each(function(Team $team, $key) use (&$teamArray){
            $teamArray[$key+1]= [
                'id' => $key + 1,
                'team_name' => ($team->title) ? $team->title : '-',
                'created_at' => date('d-m-Y', strtotime($team->created_at)),
            ];
        });

        /**
         * @var Excel $excel
         */
        $excel = app('excel');
        return $excel->create('Team_'.Carbon::now()->toDateTimeString(), function($excel) use ($teamArray) {
            $excel->setTitle('Team List');
            $excel->sheet('sheet1', function($sheet) use ($teamArray) {
                $sheet->fromArray($teamArray, null, 'A1', false, false);
            });
        })->download('xls',[
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    public function save(Request $request, $id = null)
    {

        $teamData = new Team;
        if ($request->team_id) {
            $teamData = Team::whereId($request->team_id)->first();
        }
        $teamData->title = $request->team_name;
        $teamData->status_id = Status::$ACTIVE;
        $teamData->save();

        return redirect('Admin/team')->with('success',''.$request->team_id>0.?'Team updated successfully':'Team added successfully');


//        return redirect('Admin/team')->with([
//            'status' => 200,
//            'message' => __('admin/team.team_data_save_successfully'),
//            'data' => $teamData,
//
//        ]);
    }

    public function changeStatus(Request $request)
    {
        $status = $request->get('status', Status::$ACTIVE);
        /** @var Cms $teamData */
        $teamData = team::find($request->get('id'));
        if ($teamData && ($status == Status::$ACTIVE || $status == Status::$INACTIVE)) {
            $teamData->status_id = $status;
            $teamData->save();
            return [
                'status' => '200'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('admin/team.invalid_team_id')
                ]
            ];
        }
    }

    /* Single/Multiple Delete Team */
    public function delete(Request $request)
    {
        $selected = $request->selected;
        if ($selected != '') {
            foreach ($selected as $select) {
                $teamData = Team::whereId($select)->first();
                $teamData->status_id = Status::$DELETED;
                $teamData->save();
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
