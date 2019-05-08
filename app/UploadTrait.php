<?php
namespace App;
use Carbon\Carbon;
use Image;
use Illuminate\Support\Facades\Storage;

trait UploadTrait{
	public function uploadImage($fileName, $path){
        if(request()->filled($fileName)){
            $imageData = request()->get($fileName);

            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];


            $origImage = Image::make($imageData)
                ->orientate()
                ->encode();
                
            $this->saveFile($path . $fileName, $origImage);

            $this->generateThumbnails($fileName, $path, $imageData);

            return $fileName;
        }

        return false;
    }

    public function removeImages($path, $imageName){
        $path = public_path('storage/' . $path);
        
        $this->removeFile($path . $imageName);

        $thumbnails = config('site.thumbnails');

        foreach($thumbnails as $k => $thumb){
           $thumbName = thumbnail($imageName, $k);
    	   $this->removeFile($path . $thumbName);
        }
    }

    public function generateThumbnails($fileName, $path, $imageData){
        $thumbnails = config('site.thumbnails');

        foreach($thumbnails as $k => $thumb){
            $thumbName = thumbnail($fileName, $k);

            $thumbImage = $this->fitImage($imageData, $thumb['width'], $thumb['height']);

            $this->saveFile($path . $thumbName, $thumbImage->encode());
        }
    }

    public function fitImage($imageData, $width, $height, $color = '#fff'){
        
        $image = Image::make($imageData)
            ->orientate()
            ->resize($width, $height, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            });

        $fitImage = Image::canvas($width, $height);  
        $fitImage->fill($color); 
        $fitImage->insert($image, 'center')->encode();

        return $fitImage;
    }

    public function saveFile($path, $file){
        Storage::disk('public')->put($path, $file);
    }

    public function removeFile($path){
        if(is_file($path)) {
            unlink($path);
        }
    }
}