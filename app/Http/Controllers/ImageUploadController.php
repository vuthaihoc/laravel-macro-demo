<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    
    protected $original_image;
    protected $thumbnail_image;
    
    /**
     * ImageUploadController constructor.
     */
    public function __construct() {
        $this->original_image = storage_path('original_image.jpg');
        $this->thumbnail_image = storage_path('thumbnail_image.jpg');
    }
    
    
    public function index(Request $request){
        @unlink( $this->original_image );
        @unlink( $this->thumbnail_image );
        if($request->isMethod( 'post')){
            $this->processRequest($request);
        }
        $original_image = file_exists( $this->original_image ) ? $this->original_image : false;
        $thumbnail_image = file_exists( $this->thumbnail_image ) ? $this->thumbnail_image : false;
        return view('image_upload', compact( 'original_image', 'thumbnail_image'));
    }
    
    protected function processRequest(Request $request){
        // do something here
    }
}
