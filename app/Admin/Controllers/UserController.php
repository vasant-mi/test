<?php

namespace App\Admin\Controllers;

use App\Series;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;


class UserController extends \App\Admin\AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function usersList(Request $request, $id = null)
    {
        $search = $request->get('search_field', null);
        $sorting = ($request->input('sorting')) ? $request->input('sorting') : "desc";
        $field = ($request->input('field')) ? $request->input('field') : "id";
        $per_page = ($request->input('per_page')) ? $request->input('per_page') : "10";
        if ($search) {

            $category_list = DB::table('users');


            $users = $category_list->whereIn('users.status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting)
                ->join('country', 'country.id', '=', 'users.country_id')
                ->select('users.*', 'country.country_name as country_name')
                ->where(function ($query) use ($search) {
                    $query->orWhere('users.username', 'like', '%' . $search . '%')
                        ->orWhere('users.email', 'like', '%' . $search . '%')
                        ->orWhere('users.parent_email', 'like', '%' . $search . '%')
                        ->orWhere('users.dob', 'like', '%' . $search . '%')
                        ->orWhere('users.age', 'like', '%' . $search . '%')
                        ->orWhere('users.own', 'like', '%' . $search . '%')
                        ->orWhere('users.want', 'like', '%' . $search . '%')
                        ->orWhere('users.own_spv', 'like', '%' . $search . '%')
                        ->orWhere('users.want_spv', 'like', '%' . $search . '%')
                        ->orWhere('country.country_name', 'like', '%' . $search . '%');
                });
        } else {
            $users = User::whereIn('users.status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy($field, $sorting)
                ->join('country', 'country.id', '=', 'users.country_id')
                ->select('users.*', 'country.name as country_name');

        }


        $users = $users->paginate(\Config::get('admin.per_page'));
        return view('admin/user/list', ['users' => $users,'sort' => $sorting, 'field' => $field, 'per_page' => $per_page]);
    }

    public function changePassword(Request $request, $id = null)
    {
        return view('admin/change-password/list');
    }

    public function addOrEdit($id = null)
    {
        $seriesData = Range::where('id', $id)->first();
        return view('admin/series/add', ["seriesData" => $seriesData]);
    }

    public function save(Request $request, $id = null)
    {

        $seriesData = new Series;
        if ($request->series_id) {
            $seriesData = Series::whereId($request->series_id)->first();
        }
        $seriesData->title = $request->series_name;
        $seriesData->status_id = 1;
        $seriesData->save();

        return redirect('Admin/team')->with('success',''.$request->team_id>0.?'Team updated successfully':'Team added successfully');

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
        $category = User::find($request->get('id'));
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
                    __('admin/users.invalid_user_id')
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

    public function searchUser(Request $request)
    {

        $users = User::whereIn('users.status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id')
            ->join('country', 'country.id', '=', 'users.country_id')
            ->select('users.*', 'country.country_name as country_name');

        $users = $users->paginate(\Config::get('admin.per_page'));
        return view('admin/user/list', ['users' => $users]);
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
        $users = User::whereIn('users.status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id', 'DESC')
            ->join('country', 'country.id', '=', 'users.country_id')
            ->select('users.*', 'country.name as country_name')->get();

        $userArray = [[
            'id' => 'No.',
            'username' => 'User Name',
            'email' => 'Email',
            'parent_email' => 'Parents Email',
            'date_of_birth' => 'Date of birth',
            'age' => 'Age',
            'own' => 'Own',
            'want' => 'Want',
            'own_spv' => 'Own Spv',
            'want_spv' => 'Want Spv',
            'country_name' => 'Country Name',
            'status_id' => 'Status',
            'created_at' => 'Created On',
        ]];
        $users->each(function (User $users, $key) use (&$userArray) {
            $userArray[$key + 1] = [
                'id' => $key + 1,
                'username' => ($users->username) ? $users->username: '-',
                'email' => ($users->email) ? $users->email: '-',
                'parent_email' => ($users->parent_email) ? $users->parent_email: '-',
                'date_of_birth' => ($users->date_of_birth) ? $users->date_of_birth: '-',
                'age' => User::userAge($users->date_of_birth),
                'own' => $users->countOfCharacter('own'),
                'want' => $users->countOfCharacter('want'),
                'own_spv' => $users->sumOfCharacter('own'),
                'want_spv' => $users->sumOfCharacter('want'),
                'country_name' => ($users->country_name) ? $users->country_name: '-',
                'status_id' => ($users->status_id == 1 ? 'Verified' : 'Unverified'),
                'created_at' => date('d-m-Y', strtotime($users->created_at)),
            ];
        });

        /**
         * @var Excel $excel
         */
        $excel = app('excel');
        return $excel->create('Users_' . Carbon::now()->toDateTimeString(), function ($excel) use ($userArray) {
            $excel->setTitle('Users List');
            $excel->sheet('sheet1', function ($sheet) use ($userArray) {
                $sheet->fromArray($userArray, null, 'A1', false, false);
            });
        })->download('xls', [
            'Access-Control-Allow-Origin' => '*'
        ]);
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
}
