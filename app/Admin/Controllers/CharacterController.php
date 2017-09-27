<?php

namespace App\Admin\Controllers;

use App\Character;
use App\Range;
use App\Series;
use App\Team;
use App\Rarity;
use App\Status;
use App\Found_in_package;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Mockery\Exception;
use phpDocumentor\Reflection\Types\Null_;
use Session;
use Illuminate\Database\Query;
use Illuminate\Database\Eloquent;
use App\Http\Requests;
use DB;

class CharacterController extends \App\Admin\AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function characterList(Request $request, $id = null)
    {

        $search = $request->get('search_field', null);
        $sorting = ($request->input('sorting')) ? $request->input('sorting') : "desc";
        $field = ($request->input('field')) ? $request->input('field') : "id";
        $per_page = ($request->input('per_page')) ? $request->input('per_page') : "10";

        if ($search) {
            $category_list = DB::table('character');

            $character = $category_list->whereIn('character.status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting)
                ->join('rarity', 'rarity.id', '=', 'character.rarity_id')
                ->join('range', 'range.id', '=', 'character.range_id')
                ->join('team', 'team.id', '=', 'character.team_id')
                ->join('series', 'series.id', '=', 'character.series_id')
                //->select('character.*', 'rarity.title as rarity_name', 'range.title as range_name', 'team.title as team_name', 'series.title as series_name')
                ->select('character.*', 'rarity.title as rarity_name', 'range.title as range_name', 'team.title as team_name', 'series.title as series_name', DB::raw('(select group_concat(found_in_package.title) from found_in_package where find_in_set(found_in_package.id, character.found_in)) as title_name'))
                ->where(function ($query) use ($search) {
                    $query->orWhere('character.name', 'like', '%' . $search . '%')
                        ->orWhere('range.title', 'like', '%' . $search . '%')
                        ->orWhere('rarity.title', 'like', '%' . $search . '%')
                        ->orWhere('team.title', 'like', '%' . $search . '%')
                        ->orWhere('series.title', 'like', '%' . $search . '%')
                        ->orWhere('character.code', 'like', '%' . $search . '%')
                        ->orWhere('character.value', 'like', '%' . $search . '%');
                });
        } else {


            $character = Character::whereIn('character.status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting)
                ->join('rarity', 'rarity.id', '=', 'character.rarity_id')
                ->join('range', 'range.id', '=', 'character.range_id')
                ->join('team', 'team.id', '=', 'character.team_id')
                ->join('series', 'series.id', '=', 'character.series_id')
                ->select('character.*', 'rarity.title as rarity_name', 'range.title as range_name', 'team.title as team_name', 'series.title as series_name', DB::raw('(select group_concat(found_in_package.title) from found_in_package where find_in_set(found_in_package.id, character.found_in)) as title_name'));


        }
        $character = $character->paginate(\Config::get('admin.per_page'));
        return view('admin/character/list', ['characters' => $character, 'sort' => $sorting, 'field' => $field, 'per_page' => $per_page]);

    }

    public function addOrEdit($id = null)
    {
        $characterData = Character::where('character.id', $id)
            ->join('rarity', 'rarity.id', '=', 'character.rarity_id')
            ->join('range', 'range.id', '=', 'character.range_id')
            ->join('team', 'team.id', '=', 'character.team_id')
            ->join('series', 'series.id', '=', 'character.series_id')
            ->select('character.*', 'rarity.title as rarity_name', 'range.title as range_name', 'team.title as team_name', 'series.title as series_name')
            ->first();

        $foundSelected = array();
        if ($characterData) {
            $foundSelected = explode(',', $characterData->found_in);
        }

        $rarity = Rarity::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id')->get();
        $series = Series::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id')->get();
        $team = Team::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id')->get();
        $range = Range::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id')->get();
        $found = Found_in_package::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id')->get();

        return view('admin/character/add', [
            "characterData" => $characterData,
            "rarity" => $rarity,
            "series" => $series,
            "team" => $team,
            "range" => $range,
            "found" => $found,
            "foundSelected" => $foundSelected
        ]);
    }


    public function save(Request $request, $id = null)
    {

            $characterData = new Character;
            if ($request->character_id) {
                $characterData = Character::whereId($request->character_id)->first();
            }


            $request->found_in = implode(',', $request->found_in);

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = storage_path('images/character/');
                $image->move($destinationPath, $input['imagename']);
            } else {
                $input['imagename'] = $characterData->image;
            }

            $characterData->name = $request->name;
            $characterData->image = $input['imagename'];
            $characterData->code = $request->code;
            $characterData->range_id = $request->range_id;
            $characterData->series_id = $request->series_id;
            $characterData->team_id = $request->team_id;
            $characterData->rarity_id = $request->rarity_id;
            $characterData->finish = $request->finish;
            $characterData->character_bio = $request->character_bio;
            $characterData->value = $request->value;
            $characterData->found_in = $request->found_in;
            $characterData->available_only = $request->available_only;
            $characterData->status_id = Status::$ACTIVE;
            $characterData->save();

            return redirect('Admin/character')->with('success', $request->character_id > 0 ? 'Character updated successfully' : 'Character added successfully');
    }


    public function changeStatus(Request $request)
    {
        $status = $request->get('status', Status::$ACTIVE);
        /** @var Cms $category */
        $category = Character::find($request->get('id'));
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
                    __('admin/character.invalid_range_id')
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

    function exportExcelFile()
    {
        $characters = Character::whereIn('character.status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id', 'DESC')
            ->join('rarity', 'rarity.id', '=', 'character.rarity_id')
            ->join('range', 'range.id', '=', 'character.range_id')
            ->join('team', 'team.id', '=', 'character.team_id')
            ->join('series', 'series.id', '=', 'character.series_id')
            ->select('character.*', 'rarity.title as rarity_name', 'range.title as range_name', 'team.title as team_name', 'series.title as series_name', DB::raw('(select group_concat(found_in_package.title) from found_in_package where find_in_set(found_in_package.id, character.found_in)) as title_name'))->get();

        $charArray = [[
            'id' => 'No.',
            'name' => 'Name',
            'rarity_name' => 'Rarity Name',
            'team_name' => 'Team Name',
            'series_name' => 'Series Name',
            'range_name' => 'Range Name',
            'code' => 'Code',
            'value' => 'Value',
            'found_in' => 'found In',
            'created_at' => 'Created On',

        ]];
        $characters->each(function (Character $characters, $key) use (&$charArray) {
            $charArray[$key + 1] = [
                'id' => $key + 1,
                'name' => ($characters->name) ? $characters->name : '-',
                'rarity_name' => ($characters->rarity_name) ? $characters->rarity_name : '-',
                'team_name' => ($characters->team_name) ? $characters->team_name : '-',
                'series_name' => ($characters->series_name) ? $characters->series_name : '-',
                'range_name' => ($characters->range_name) ? $characters->range_name : '-',
                'code' => ($characters->code) ? $characters->code : '-',
                'value' => ($characters->value) ? '$' . $characters->value : '-',
                'found_in' => ($characters->title_name) ? $characters->title_name : '-',
                'created_at' => date('d-m-Y', strtotime($characters->created_at)),
            ];
        });

        /**
         * @var Excel $excel
         */
        $excel = app('excel');
        return $excel->create('Characters_' . Carbon::now()->toDateTimeString(), function ($excel) use ($charArray) {
            $excel->setTitle('Character List');
            $excel->sheet('sheet1', function ($sheet) use ($charArray) {
                $sheet->fromArray($charArray, null, 'A1', false, false);
            });
        })->download('xls', [
            'Access-Control-Allow-Origin' => '*'
        ]);
    }

    public function destroyAll(Request $request)
    {

        $status = $request->get('status', Status::$DELETED);
        $ids = $request->get('id');

        /** @var Agency $range */
        $character = Character::whereIn('id', $ids);

        $character = $character->get();
        if (count($character) > 0) {
            foreach ($character as $char) {

                if ($char && ($status == Status::$ACTIVE || $status == Status::$INACTIVE || $status == Status::$DELETED)) {
                    $char->status_id = $status;
                    $char->save();
                }
            }
            return [
                'status' => '200'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('Invalid character id')
                ]
            ];
        }
    }


    public function destroy(Request $request)
    {
        $status = $request->get('status', Status::$DELETED);
        /** @var Cms $category */
        $category = Character::find($request->get('id'));
        if ($category) {
            $category->status_id = $status;
            $category->save();
            return [
                'status' => '200',
                'message' => 'Character Deleted Successfully.'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('admin/character.invalid_character_id')
                ]
            ];
        }
    }
}
