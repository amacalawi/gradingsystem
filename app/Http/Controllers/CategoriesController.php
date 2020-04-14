<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Application;
use App\Applicant;
use App\Inventor;
use App\Category;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Illuminate\Http\File;
class CategoriesController extends Controller
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
        return view('modules/resources/categories/views/manage');
    }

    public function edit(Request $request, $id)
    {   
        $categories = (new Category)->fetch($id);
        return view('modules/resources/categories/views/edit')->with(compact('categories'));
    }   

    public function alldata(Request $request)
    {
        $res = Category::where('category_id', '!=', '0')->orderBy('category_id', 'DESC')->get();

        return $res->map(function($cat) {
            return [
                'CatID' => $cat->category_id,
                'CatCode' => $cat->category_code,
                'CatName' => $cat->category_name,
                'CatDescription' => $cat->category_desc,
                'CatModified' => ($cat->updated_at !== NULL) ? date('d-M-Y h:i A', strtotime($cat->updated_at)) : date('d-M-Y h:i A', strtotime($cat->created_at))
            ];
        });
    }

    public function update(Request $request, $id)
    {   
        $timestamp = date('Y-m-d H:i:s');
        $category = Category::find($id);

        if(!$category) {
            throw new NotFoundHttpException();
        }
        
        $category->category_code = $request->input('category_code');
        $category->category_name = $request->input('category_name');
        $category->category_desc = $request->input('category_desc');
        $category->updated_at = $timestamp;
        $category->updated_by = Auth::user()->id;

        if ($category->update()) {
            $data = array(
                'id' => $category->category_id,
                'message' => 'The information has been successfully updated.',
                'type'    => 'success'
            );

            echo json_encode( $data ); exit();
        }
    }
}
