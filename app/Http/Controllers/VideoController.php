<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\Comment;
use Illuminate\Support\Facades\Schema;
class VideoController extends Controller
{
    public function __invoke($id)
    {
        $resolution = config('constants');
        $video = Video::where('url',$id)->first();
        if($video){
            if(Schema::hasTable($id)){
                $comments =(new Comment)->setTable($id)->leftJoin('users',"$id.name",'=','users.name')->select(['users.id','users.avatar','users.name','comment','up','down','upBy','downBy'])->get();
                return response()->json(['video'=>$video,'resolution'=>$resolution,'comments'=>$comments]);
            } else {
                return response()->json(['video'=>$video,'resolution'=>$resolution,]);
            }
        }else{
            return response()->json(404);
//            view('404',['message'=>'找不到这个视频哟']);
        }
    }
}
