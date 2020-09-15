<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\FileUpload;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;

class FileUploadController extends Controller
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
    public function index()
    {
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
}
