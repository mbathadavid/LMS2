<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\ResultThread;
use Illuminate\Http\Request;

class ResultThreadController extends Controller
{
    public function resultThreads(){
        $threads = ResultThread::all();
        return response()->json([
            'threads' => $threads
        ]);
    }
    //Function To register Thread
    public function registerThread(Request $req){
        $validator = Validator::make($req->all(),[
            'resultsname' => 'required',
            'term' => 'required',
            'year' => 'required'
        ],[
            'resultsname.required' => 'Results Name is Required',
            'term.required' => 'The term is Required',
            'year.required' => 'The year is required'
        ]);

        if ($validator->fails()) {
             return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
             ]);
        } else {
            $thread = new ResultThread;
            $thread->name = $req->resultsname;
            $thread->term = $req->term;
            $thread->year = $req->year;
            $thread->save();

            return response()->json([
                'status' => 200,
                'messages' => 'Results Threads Added Successfully'
            ]);
        }
        
    }
}
