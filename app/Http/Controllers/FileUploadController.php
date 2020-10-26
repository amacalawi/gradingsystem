<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use App\Models\AuditLog;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;
use App\Helper\Helper;

class FileUploadController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        $this->middleware('auth');
    }

    public function is_permitted($permission)
    {
        $privileges = explode(',', strtolower(Helper::get_privileges()));
        if (!$privileges[$permission] == 1) {
            return abort(404);
        }
    }

    public function index()
    {   
        $this->is_permitted(1);
        $menus = $this->load_menus();
        return view('modules/components/file-management/'.request()->segment(count(request()->segments())).'/manage')->with(compact('menus'));
    }

    public function all_active(Request $request)
    {
        $res = FileUpload::where(['is_active' => 1, 'category' => $request->get('category')])->orderBy('id', 'DESC')->get();

        return $res->map(function($upload) {
            return [
                'uploadID' => $upload->id,
                'uploadName' => $upload->name,
                'uploadType' => $upload->type,
                'uploadSize' => $upload->size,
                'uploadModified' => ($upload->updated_at !== NULL) ? date('d-M-Y', strtotime($upload->updated_at)).'<br/>'. date('h:i A', strtotime($upload->updated_at)) : date('d-M-Y', strtotime($upload->created_at)).'<br/>'. date('h:i A', strtotime($upload->created_at))
            ];
        });
    }

    public function import(Request $request)
    {   
        $this->is_permitted(0);
        $timestamp = date('Y-m-d H:i:s');
        $uploaddir = 'uploads/file-management/'.$request->get('category');
        Storage::disk('uploads')->makeDirectory('file-management/'.$request->get('category'));

        foreach($_FILES as $file)
        {   
            if(Storage::put('uploads/file-management/'. $request->get('category') .'/'. $file['name'], (string) file_get_contents($file['tmp_name'])))
            {
                $files[] = $uploaddir . '/'. $file['name'];

                $exist = FileUpload::where(['is_active' => 1, 'name' => $file['name'], 'category' => $request->get('category')])->get();

                if ($exist->count() > 0) {
                    $FileUpload = FileUpload::find($exist->first()->id);
                    $FileUpload->name = $file['name'];
                    $FileUpload->type = $file['type'];
                    $FileUpload->size = $file['size'];
                    $FileUpload->updated_at = $timestamp;
                    $FileUpload->updated_by = Auth::user()->id;

                    if (!$FileUpload->update()) {
                        throw new NotFoundHttpException();
                    }

                    $this->audit_logs('files', $FileUpload->id, 'has modified a '.$request->get('category').' file.', FileUpload::find($FileUpload->id), $timestamp, Auth::user()->id);
                } else {
                    $FileUpload = FileUpload::create([
                        "category" => $request->get('category'),
                        "name" => $file['name'],
                        "type" => $file['type'],
                        "size" => $file['size'],
                        'created_at' => $timestamp,
                        'created_by' => Auth::user()->id
                    ]);

                    if(!$FileUpload) {
                        throw new NotFoundHttpException();
                    }

                    $this->audit_logs('files', $FileUpload->id, 'has inserted a new '.$request->get('category').' file.', FileUpload::find($FileUpload->id), $timestamp, Auth::user()->id);
                }
            }
        }

        $data = array(
            'files' => $files,
            'message' => 'success'
        );

        echo json_encode( $data );

        exit();
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
