<?php
namespace App\Admin\Controllers;

use App\Cms;
use App\Status;
use Illuminate\Http\Request;

class CmsController extends \App\Admin\AdminController{

    public function cmsList(Request $request){
        /** @var Cms $cmss */
        $cmss = Cms::whereIn('status_id', [Status::$ACTIVE, Status::$INACTIVE])->orderBy('id')->get();
        return view('admin/cms/list', ['cmss' => $cmss]);
    }


    public function cmsAdd($id){
        if($id > 0 && $cms = Cms::find($id)){
            /** @var Language $languages */

            return view('admin/cms/add', [ 'cms' => $cms]);
        } else {
            return redirect('Admin/cms')->with(\Config::get('admin.message'), [
                'type' => 'danger',
                'message' => [__('admin/cms.invalid_cms_id')]
            ]);
        }
    }

    public function changeStatus(Request $request) {
        $status = $request->get('status', Status::$ACTIVE);
        /** @var Cms $category */
        $category = Cms::find($request->get('id'));
        if($category && ($status == Status::$ACTIVE || $status == Status::$INACTIVE)){
            $category->status_id = $status;
            $category->save();
            return [
                'status' => '200'
            ];
        } else {
            return [
                'status' => '400',
                'message' => [
                    __('admin/cms.invalid_cms_id')
                ]
            ];
        }
    }

    public function save(Request $request, $id) {
        if($id > 0 && $cms = Cms::find($id)){
            $value = $request->get('value', []);
            if(!empty($value)){
                collect($value)->each(function ($text, $languageId) use ($id){
                    if($text) {
                        $languageId = $id == 8 || $id == 5 || $id == 6 || $id == 9 ? Language::$ENGLISH : $languageId;
                        $cmsTranslations = CmsTranslations::whereCmsId($id)->whereLanguageId($languageId)->first();

                        if (!$cmsTranslations) {
                            $cmsTranslations = new CmsTranslations();
                            $cmsTranslations->language_id = $languageId;
                            $cmsTranslations->cms_id = $id;
                        }
                        $cmsTranslations->value = $text;
                        $cmsTranslations->save();
                    }
                });
            }
            return redirect('Admin/cms')->with(\Config::get('admin.message'), [
                'type' => 'success',
                'message' => __('admin/cms.cms_save_successfully')
            ]);
        } else {
            return redirect('Admin/cms')->with(\Config::get('admin.message'), [
                'type' => 'danger',
                'message' => [__('admin/cms.invalid_cms_id')]
            ]);
        }

    }

}