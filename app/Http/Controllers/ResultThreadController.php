<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\ResultThread;
use Illuminate\Http\Request;

class ResultThreadController extends Controller
{
    public function resultThreads($sid){
        $threads = ResultThread::where('sid',$sid)
                                ->OrderByDesc('id')
                                ->get();
        return response()->json([
            'threads' => $threads
        ]);
    }
    //Fetch Result Thread
    public function resultThread($tid){
        $resulthread = ResultThread::find($tid);

        return response()->json([
            'resulthread' => $resulthread
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
            $thread->sid = $req->sid;
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

    //Edit Thread
    public function editThread(Request $req){
        $validator = Validator::make($req->all(),[
            'editresultsname' => 'required',
            'editterm' => 'required',
            'edityear' => 'required'
        ],[
            'editresultsname.required' => 'Results Name is Required',
            'editterm.required' => 'The term is Required',
            'edityear.required' => 'The year is required'
        ]);

        if ($validator->fails()) {
            return response()->json([
               'status' => 400,
               'messages' => $validator->getMessageBag()
            ]);
       } else {
           $thread = ResultThread::find($req->tid);
           $thread->name = $req->editresultsname;
           $thread->term = $req->editterm;
           $thread->year = $req->edityear;
           $thread->save();

           return response()->json([
               'status' => 200,
               'messages' => 'Results Threads Updated Successfully'
           ]);
       }

    }
    //Delete Thread
    public function deleteThread($tid){
        $deletion = ResultThread::where('id',$tid)
                            ->delete();

        if ($deletion == TRUE) {
            return response()->json([
             'status' => 200,
             'messages' => 'Thread Successfully Deleted'
            ]);
            } else {
            return response()->json([
                'status' => 400,
                'messages' => 'Error occurred while deleting the Thread. Please try again later'
            ]); 
        }
    }
}
