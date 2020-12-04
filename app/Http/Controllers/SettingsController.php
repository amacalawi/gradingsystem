<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class SettingsController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function is_permitted($permission)
    {
        $privileges = explode(',', strtolower(Helper::get_privileges()));
        if (!$privileges[$permission] == 1) {
            return abort(404);
        }
    }

    public function index()
    {   
        $settings = (new Setting)->fetch();
        $menus = $this->load_menus();
        return view('modules/settings/index')->with(compact('menus', 'settings'));
    }

    public function update(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');
        $setting = Setting::where('is_active', 1)->get();

        if ($setting->count() > 0) {
            $setting = Setting::find($setting->first()->id);
            $setting->name = $request->name;
            $setting->location = $request->location;
            $setting->email = $request->email;
            $setting->phone = $request->phone;
            $setting->fax = $request->fax;
            $setting->avatar = $request->get('avatar');
            $setting->updated_at = $timestamp;
            $setting->updated_by = Auth::user()->id;

            if ($setting->update()) {

                $this->audit_logs('settings', $setting->id, 'has modified a setting.', Setting::find($setting->id), $timestamp, Auth::user()->id);

                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The setting has been successfully updated.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );
        
                echo json_encode( $data ); exit();
            }
        } else {
            $setting = Setting::create([
                'name' => $request->name,
                'location' => $request->location,
                'email' => $request->email,
                'phone' => $request->phone,
                'fax' => $request->fax,
                'avatar' => $request->get('avatar'),
                'created_at' => $timestamp,
                'created_by' => Auth::user()->id
            ]);
    
            if (!$setting) {
                throw new NotFoundHttpException();
            }
    
            $this->audit_logs('settings', $setting->id, 'has inserted a new setting.', Setting::find($setting->id), $timestamp, Auth::user()->id);
            
            $data = array(
                'title' => 'Well done!',
                'text' => 'The setting has been successfully saved.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
    
            echo json_encode( $data ); exit();
        }
    }

    public function uploads(Request $request)
    {   
        $files = array();

        foreach($_FILES as $file)
        {   
            $filename = basename($file['name']);
            $files[] = Storage::put($request->get('files').'/'.$filename, (string) file_get_contents($file['tmp_name']));
        }

        $data = array('files' => $files);
        echo json_encode( $data ); exit();
    }

    public function audit_logs($entity, $entity_id, $description, $data, $timestamp, $user)
    {
        $auditLogs = AuditLog::create([
            'entity' => $entity,
            'entity_id' => $entity_id,
            'description' => $description,
            'data' => json_encode($data),
            'created_at' => $timestamp,
            'created_by' => $user
        ]);

        return true;
    }
}
