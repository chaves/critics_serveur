<?php

namespace App\Http\Controllers;

const CONSTANT = 'valeur constante';
use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetsController extends Controller
{
    public function index(Request $request) {
        $type = $request->segment(3);
        // var_dump($type);
        // exit();
        if($type == 'all') {
            return Tweet::where('done', 0)->orderBy('hashtag', 'asc')->orderBy('updated_at', 'asc')->paginate(12);
        } else {
            return Tweet::where('done', 0)->orderBy('hashtag', 'asc')->where('owner', $type)->orderBy('updated_at', 'asc')->paginate(12);
        }
    }

    public function done(Request $request) {
        $type = $request->segment(4);
        if($type == 'all') {
            return Tweet::where('done', 1)->orderBy('hashtag', 'asc')->orderBy('updated_at', 'asc')->paginate(12);
        } else {
            return Tweet::where('done', 1)->orderBy('hashtag', 'asc')->orderBy('updated_at', 'asc')->where('owner', $type)->paginate(12);
        }
    }

    public function update(Request $request)
    {
        $type = $request->segment(4);
        if($type) {
            $type == 'ignore' || $type == 'done' ? $value = 1 : $value = $request->input('value');
            if ($type == 'un_done') {
                $type = 'done';
                $value = 0;
            }
            $tweet = Tweet::findId($request->input('id'))->first();
            $tweet->$type = $value;
            $tweet->save();
        }
    }
}
