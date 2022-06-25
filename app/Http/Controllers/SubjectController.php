<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use App\Models\classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    //
    public function saveSubject(Request $req){
        $validator = Validator::make($req->all(),[
            'subjects' => 'required',
        ],
        [
            'subjects.required' => 'Please make sure that you have selected some subjects for registration.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
                $sub = explode(',',$req->subjects);

                for ($i=0; $i < count($sub); $i++) { 
                    $deletesub = Subject::where('subject',$sub[$i])
                                        ->where('sid',$req->sid)
                                        ->where('educationsystem',$req->system)
                                        ->where('level',$req->level)
                                        ->delete();
                }

                for ($i=0; $i < count($sub); $i++) {
                    $subject = new Subject; 
                    $subject->subject = $sub[$i];
                    $subject->sid = $req->sid;
                    $subject->educationsystem = $req->system;
                    $subject->level = $req->level;
                    $subject->pathway = $req->pathway;
                    $subject->save();
                }
        
        return response()->json([
            'status' => 200,
            'messages' => 'Subjects Registered successfully'
        ]);
        }   
    }
    //fetch subjects
    public function fetchSubjects($sid){
        $subjects = Subject::where('sid',$sid)
                            ->get();
        $classes = classes::where('sid',$sid)
                            ->get();

        return response()->json([
            'subjects' => $subjects,
            'classes' => $classes
        ]);
    }
    //Delete Subject 
    public function deleteSubject($sid){
        $delaction = Subject::where('id',$sid)
                        ->delete();
        
        if ($delaction == TRUE) {
            return response()->json([
                'messages' => 'Subject Successfully Deleted'
            ]);
        } else {
            return response()->json([
                'messages' => 'Error occurred while deleting the Subject. Please try again later'
            ]);
        }  
    }
    //Get Subject Details
    public function subDetails($sid){
        $subjectdetails = Subject::where('id',$sid)
                                ->first();
        return response()->json([
            'subjectdetails' => $subjectdetails
        ]);
    }
    //Update Subject
    public function updateSubject(Request $req){
        $validator = Validator::make($req->all(),[
            'subject' => 'required',
            'category' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
        $subject = Subject::find($req->subid);
        $subject->subject = $req->subject;
        $subject->category = $req->category;
        $subject->save();
        
        return response()->json([
            'status' => 200,
            'messages' => 'Subject Updated successfully'
        ]);
        }  
    }
}
