<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        UploadedFile::macro( 'saveTo', function($path, $options = []){
            
            $height = Arr::pull( $options, 'height');
            $width = Arr::pull( $options, 'width');
            $aspectRatio = Arr::pull( $options, 'aspectRatio');
            $upsize = Arr::pull( $options, 'upsize');
            $quality = Arr::pull( $options, 'quality', 90);
            
            $image = Image::make( $this );
            $image->resize( $width, $height, function ($constraint) use ($aspectRatio, $upsize) {
                if($aspectRatio){
                    $constraint->aspectRatio();
                }
                if($upsize){
                    $constraint->upsize();
                }
            });
            
            return $image->save($path, $quality);
            
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
