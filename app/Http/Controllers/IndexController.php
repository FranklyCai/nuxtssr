<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Carousel;
use App\VideoType;
use App\IndexVideo;

class IndexController extends Controller
{
    public function __invoke(Request $request){
        $carousel = Carousel::all();
        $types = VideoType::all();
        $subjects = [];
        foreach ($types as $type){
            $subjects[$type->ename] = IndexVideo::where('video_type',$type->ename)->orderBy('id','desc')->limit(7)->get();
        }
        return response()->json(['carousel'=>$carousel,'types'=>$types,'subjects'=>$subjects]);
    }
}
