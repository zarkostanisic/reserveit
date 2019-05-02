<?php
namespace App;
use Carbon\Carbon;
use Image;

trait UploadTrait{
	public function doUpload($name, $path){
        if(request()->filled('logo')){
            $imageData = request()->get($name);

            $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
            Image::make(request()->get($name))->save(public_path($path).$fileName);

            return $fileName;
        }

        return false;
    }

    public function removeOldFile($remove_path){
    	if(file_exists($remove_path)) {
            unlink($remove_path);
        }
    }
}