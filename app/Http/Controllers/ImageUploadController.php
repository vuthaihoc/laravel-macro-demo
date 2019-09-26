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
        $this->original_image = public_path('original_image.jpg');
        $this->thumbnail_image = public_path('thumbnail_image.jpg');
    }
    
    
    public function index(Request $request){
        @unlink( $this->original_image );
        @unlink( $this->thumbnail_image );
        if($request->isMethod( 'post')){
            $this->processRequest($request);
        }
        $original_image = file_exists( $this->original_image ) ? url(basename( $this->original_image )) : false;
        $thumbnail_image = file_exists( $this->thumbnail_image ) ? url(basename( $this->thumbnail_image )) : false;
        return view('image_upload', compact( 'original_image', 'thumbnail_image'));
    }
    
    protected function processRequest(Request $request){
        try{
            $file = $request->file('image');
            $file->saveTo($this->original_image, ['height' => 800, 'width' => 800, 'aspectRatio' => true]);
            $file->saveTo($this->thumbnail_image, ['height' => 200, 'width' => 200, 'aspectRatio' => true]);
        }catch (\Exception $ex){
        
        }
    }
}
