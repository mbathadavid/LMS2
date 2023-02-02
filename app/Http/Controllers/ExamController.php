<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\exam;
use Illuminate\Support\Facades\DB;
use App\Models\classes;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    //register Exam
    public function registerExam(Request $req){
        $validator = Validator::make($req->all(),[
            'examname' => 'required',
            'year' => 'required|max:4|min:4',
            'term' => 'required',
            'examtype' => 'required',
            'classes' => 'required',
        ],
    [
       'classes.required' => 'You should select some classes that will sit for this exam',
       'year.max' => 'A year must have a maximum of four digits', 
       'year.min' => 'A year must have a minimum of four digits',
       'examtype.required' => 'You must select the exam type',
       'year.required' => 'The year cannot be empty',
       'term.required' => 'You must associate this exam to a particular to certain term' 
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
           $classnames = [];
           $classids = explode(',',$req->classes);
           for ($i=0; $i < count($classids) ; $i++) { 
               $classess = classes::find($classids[$i]);
               $classname = $classess['class'];
               $classstream = $classess['stream'];
               array_push($classnames,$classname.' '.$classstream);
           }
           $exam = new exam;
           $exam->sid = $req->sid;
           $exam->Examination = $req->examname.'_'.$req->term.'_'.$req->year;
           $exam->Year = $req->year;
           $exam->classes = $req->classes;
           $exam->Term = $req->term;
           $exam->exam = $req->examname;
           $exam->classnames = implode(',',$classnames);
           $exam->ExamType = $req->examtype;
           $exam->save();

           return response()->json([
                'status' => 200,
                'messages' => 'Exam Added Successfully'
           ]);
        }  
    }
    //function to return all exams
    public function fetchExams($sid){
        $exams = exam::where('deleted',0)
                        ->where('sid',$sid)
                        ->OrderByDesc('id')
                        ->get();
        return response()->json([
            'exams' => $exams
        ]);
    }
    //Delete a exam
    public function deleteExams($ids){
        $idarray = explode(',',$ids);
            for ($i=0; $i < count($idarray) ; $i++) { 
                $exam = exam::find($idarray[$i]);
                $exam->deleted = '1';
                $exam->save(); 
            }
        return response()->json([
            'status' => 200,
            'messages' => 'Exam deleted Successfullly'
        ]);
    }
    //fetch Exam
    public function getExam($id){
        $exam = exam::find($id);
        return response()->json([
            'exam' => $exam
        ]);
    }
    //Edit Exam
    public function editExam(Request $req){
        $validator = Validator::make($req->all(),[
            'exameditname' => 'required',
            'edityear' => 'required|max:4|min:4',
            'editterm' => 'required',
            'examedittype' => 'required',
            'classes' => 'required',
        ],
    [
       'classes.required' => 'You should select some classes that will sit for this exam',
       'edityear.max' => 'A year must have a maximum of four digits', 
       'edityear.min' => 'A year must have a minimum of four digits',
       'examedittype.required' => 'You must select the exam type',
       'edityear.required' => 'The year cannot be empty',
       'editterm.required' => 'You must associate this exam to a particular to certain term' 
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
        $classnames = [];
        $classids = explode(',',$req->classes);
        for ($i=0; $i < count($classids) ; $i++) { 
            $classess = classes::find($classids[$i]);
            $classname = $classess['class'];
            $classstream = $classess['stream'];
            array_push($classnames,$classname.' '.$classstream);
            //$classnames = [$classname.' '.$classstream];
        }
        $exam = exam::find($req->examid);
        $exam->Examination = $req->exameditname.'_'.$req->editterm.'_'.$req->edityear;
        $exam->Year = $req->edityear;
        $exam->classes = $req->classes;
        $exam->Term = $req->editterm;
        $exam->exam = $req->exameditname;
        $exam->classnames = implode(',',$classnames);
        $exam->ExamType = $req->examedittype;
        $exam->save();

        return response()->json([
             'status' => 200,
             'messages' => 'Exam Added Successfully'
        ]);  
    } 
    }
}
