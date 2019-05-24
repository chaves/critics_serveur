<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tweet;

class TweetsController extends Controller
{
    public function index(Request $request) {
        $type = $request->segment(3);

        if($type == 'all') {
            return Tweet::where('done', 0)->orderBy('hashtag', 'asc')->orderBy('updated_at', 'desc')->paginate(12);
        } else {
            return Tweet::where('done', 0)->orderBy('hashtag', 'asc')->where(
              'owner',
              $type
            )->orderBy('updated_at', 'desc')->paginate(12);
        }
    }

    public function done(Request $request) {
        $type = $request->segment(4);
        if($type == 'all') {
            return Tweet::where('done', 1)->orderBy('hashtag', 'asc')->orderBy('updated_at', 'desc')->paginate(12);
        } else {
            return Tweet::where('done', 1)->orderBy('hashtag', 'asc')->orderBy('updated_at', 'desc')->where('owner', $type)->paginate(12);
        }
    }

    public function stats($type){
        $stats = array();

        if($type == 'all') {

            $stats['critiques_nb_yes'] = Tweet::where('criticism', 'yes')
              ->where('done', 1)
              ->where('ignore', 0)
              ->count();
            $stats['critiques_nb_no'] = Tweet::where('criticism', 'no')->where(
              'done',
              1
            )->where('ignore', 0)->count();

            $stats['constructive_nb_yes'] = Tweet::where('constructive', 'yes')
              ->where('done', 1)
              ->where('ignore', 0)
              ->count();
            $stats['constructive_nb_no'] = Tweet::where('constructive', 'no')
              ->where('done', 1)
              ->where('ignore', 0)
              ->count();

            $stats['ignore_nb_no'] = Tweet::where('done', 1)
              ->where('ignore', 0)
              ->count();
            $stats['ignore_nb_yes'] = Tweet::where('done', 1)->where(
              'ignore',
              1
            )->count();
        }
        else {
            $stats['critiques_nb_yes'] = Tweet::where('criticism', 'yes')
              ->where('done', 1)
              ->where('ignore', 0)
              ->where('owner', $type)
              ->count();
            $stats['critiques_nb_no'] = Tweet::where('criticism', 'no')->where(
              'done',
              1
            )->where('ignore', 0)->where('owner', $type)->count();

            $stats['constructive_nb_yes'] = Tweet::where('constructive', 'yes')
              ->where('done', 1)
              ->where('ignore', 0)
              ->where('owner', $type)
              ->count();
            $stats['constructive_nb_no'] = Tweet::where('constructive', 'no')
              ->where('done', 1)
              ->where('ignore', 0)
              ->where('owner', $type)
              ->count();

            $stats['ignore_nb_no'] = Tweet::where('done', 1)
              ->where('ignore', 0)
              ->where('owner', $type)
              ->count();
            $stats['ignore_nb_yes'] = Tweet::where('done', 1)->where('ignore', 1)->where('owner', $type)->count();

        }

        return $stats;
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
