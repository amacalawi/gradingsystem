<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Status;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Http\File;
class statusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

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
        return view('modules/resources/status/views/manage');
    }

    public function edit(Request $request, $id)
    {   
        $status = (new Status)->fetch($id);
        return view('modules/resources/status/views/edit')->with(compact('status'));
    }   

    public function alldata(Request $request)
    {
        $res = Status::where('id', '!=', '0')->orderBy('id', 'DESC')->get();

        return $res->map(function($cat) {
            return [
                'StatID' => $cat->id,
                'StatCode' => $cat->code,
                'StatName' => $cat->name,
                'StatDescription' => $cat->description,
                'StatModified' => ($cat->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($cat->updated_at)) : date('d-M-Y h:i A', strtotime($cat->created_at))
            ];
        });
    }

    public function update(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $status = Status::find($id);

        if(!$status) {
            throw new NotFoundHttpException();
        }
        
        $status->code = $request->input('code');
        $status->name = $request->input('name');
        $status->description = $request->input('description');
        $status->updated_at = $timestamp;
        $status->updated_by = Auth::user()->id;

        if ($status->update()) {
            $data = array(
                'id' => $status->id,
                'message' => 'The information has been successfully updated.',
                'type'    => 'success'
            );

            echo json_encode( $data ); exit();
        }
    }
}
