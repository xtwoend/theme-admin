<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{

    protected $types = [
        'image' => ['png', 'jpg', 'jpeg', 'gif'],
        'audio' => ['mp3', 'wav', 'mpga'],
        'video' => ['mp4', 'avi']
    ];

    public function upload(Request $request)
    {
        if ($request->file('file')->isValid()) {
            $extension = $request->file->extension();
            $fileName = str_random(10) . '.' .$extension;
            $fileType = 'unknown';
            foreach ($this->types  as $type => $lists) {
                if(in_array($extension, $lists)){
                    $fileType = $type;
                }
            }
            if($fileType == 'image'){
                // process image resize
                $img = Image::make($request->file->path());
                if($img->width() > 640){
                    $img->resize(640, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                }
                $img->save(storage_path('app/public/upload/'.$fileName), 80);  
            }else{
                $file = $request->file->storeAs('public/upload', $fileName);
            }         
            
            $url = asset('storage/upload/'.$fileName);
            return response()->json([
                'success' => true, 
                'data' => [
                    'url' => $url,
                    'type' => $fileType
                ]
            ], 200);
        }

    }
}
