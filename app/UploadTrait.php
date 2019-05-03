<?php
namespace App;
use Carbon\Carbon;
use Image;

trait UploadTrait{
	public function uploadFile($name, $path){
        if(request()->filled($name)){
            $imageData = request()->get($name);

            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make($imageData)->save(public_path($path).$fileName);

            return $fileName;
        }

        return false;
    }

    public function removeFile($remove_path){
    	if(is_file($remove_path)) {
            unlink($remove_path);
        }
    }
}