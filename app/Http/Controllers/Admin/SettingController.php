<?php

namespace App\Http\Controllers\Admin;

use App\Entities\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    protected $setting;

    public function __construct(Setting $setting)
    {
        config(['site.menu' => 'setting']);
        $this->setting = $setting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->setting->create($request->all());
        return redirect()->route('admin.setting.index')->with(['message' => 'Saved..']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $row = $this->setting->findOrFail($id);
        $row->fill($request->all());
        $row->save();

        return redirect()->route('admin.setting.index')->with(['message' => 'Success edit setting']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function logo(Request $request)
    {   
        if($request->hasFile('img') && $request->file('img')->isValid()){

            list($width, $height) = getimagesize($request->img->path());
            
            $filename = str_random(10) . '.' . $request->img->extension();
            $path = $request->img->storeAs('public/photo', $filename);

            return response()->json([
                'status'    => 'success',
                'url'       => url('storage/photo/'.$filename),
                'width'     => $width,
                'height'    => $height,
            ],200);
        }

        return response()->json([
            'status'    => 'error',
            'message'   => 'ops.. error upload'
        ], 200);
    }

    public function logoCrop(Request $request)
    {   
        $filename = $filename = str_random(10) . '_'. $request->cropW. 'x' .$request->cropH . '.png';
        $img = Image::make($request->imgUrl);
        $img->resize($request->imgW, $request->imgH);
        $img->crop($request->cropW, $request->cropH, $request->imgX1 ,$request->imgY1);
        $img->save(storage_path('app/public/photo/'.$filename), 80);

        return response()->json([
            'status' =>'success',
            'url' =>  url('storage/photo/'. $filename)
        ], 200);
    }
}
