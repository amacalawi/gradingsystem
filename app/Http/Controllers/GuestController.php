<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\UploadPhoto;
use Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\File;
use App\Components\FlashMessages;


class GuestController extends Controller
{   
    use FlashMessages;
    private $models;

    public function __construct()
    {   
        date_default_timezone_set('Asia/Manila');
        // $this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $menus = $this->load_menus();
        return view('modules/printing/upload')->with(compact('menus'));
    }

    public function upload_data(Request $request)
    {    
        $timestamp = date('Y-m-d H:i:s');

        $uploads = UploadPhoto::where('identification_no', $request->identification_no)->get();

        if ($uploads->count() > 0) {
            $uploads = UploadPhoto::find($uploads->first()->id);
            $uploads->firstname = $request->firstname;
            $uploads->lastname = $request->lastname;
            $uploads->filename = $request->get('files');
            $uploads->updated_at = $timestamp;
            if ($uploads->update()) {
                $data = array(
                    'title' => 'Well done!',
                    'text' => 'The information has been successfully uploaded.',
                    'type' => 'success',
                    'class' => 'btn-brand'
                );

                echo json_encode( $data ); exit();
            }
        } 
        else {
            $uploads = UploadPhoto::create([
                'identification_no' => $request->identification_no,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'filename' => $request->get('files'),
                'created_at' => $timestamp
            ]);

            if (!$uploads) {
                throw new NotFoundHttpException();
            }

            $data = array(
                'title' => 'Well done!',
                'text' => 'The information has been successfully uploaded.',
                'type' => 'success',
                'class' => 'btn-brand'
            );
        }

        echo json_encode( $data ); exit();
    }

    public function upload_photo(Request $request)
    {   
        if ($request->get('id') != '') {
            $folderID = $request->get('id');
        } else {
            Storage::disk('uploads')->makeDirectory($request->get('files').'/'.$reuest->identification_no);
            $folderID = $reuest->identification_no;
        }

        $files = array();

        foreach($_FILES as $file)
        {   
            $filename = basename($file['name']);
            $files[] = Storage::put($request->get('files').'/'.$folderID.'/'.$filename, (string) file_get_contents($file['tmp_name']));
        }

        $data = array('files' => $files);
        echo json_encode( $data ); exit();
    }

}
