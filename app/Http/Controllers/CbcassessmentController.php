<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\cbcassessment;
use Illuminate\Http\Request;

class CbcassessmentController extends Controller
{
    //function to return all exams
    public function fetchAssesments($sid){
        $assessments = cbcassessment::where('deleted',0)
                        ->where('sid',$sid)
                        ->OrderByDesc('id')
                        ->get();
        return response()->json([
            'assessments' => $assessments
        ]);
    }

    //Function to add new assessment
    public function addAssessment(Request $req){
        $validator = Validator::make($req->all(),[
            'assessmentname' => 'required',
            'year' => 'required|max:4|min:4',
            'term' => 'required',
            'assessmenttype' => 'required',
        ],
    [
       'year.max' => 'A year must have a maximum of four digits', 
       'year.min' => 'A year must have a minimum of four digits',
       'assessmentname.required' => 'You must enter the Assessment Name',
       'assessmenttype.required' => 'You must select the exam type',
       'year.required' => 'You must include the year',
       'term.required' => 'You must associate this assessment to a particular to certain term' 
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
           $cbcassessment = new cbcassessment;
           $cbcassessment->sid = $req->sid;
           $cbcassessment->Assessment = $req->assessmentname.'_'.$req->term.'_'.$req->year;
           $cbcassessment->Name = $req->assessmentname;
           $cbcassessment->Year = $req->year;
           $cbcassessment->Term = $req->term;
           $cbcassessment->Type = $req->assessmenttype;
           $cbcassessment->save();

           return response()->json([
                'status' => 200,
                'messages' => 'Assessment Added Successfully'
           ]);
        }
    }

    //Edit Exam
    public function editAssessment(Request $req){
        $validator = Validator::make($req->all(),[
            'exameditname' => 'required',
            'edityear' => 'required|max:4|min:4',
            'editterm' => 'required',
            'examedittype' => 'required',
        ],
    [
       'edityear.max' => 'A year must have a maximum of four digits', 
       'edityear.min' => 'A year must have a minimum of four digits',
       'examedittype.required' => 'You must select the Assessment type',
       'edityear.required' => 'The year cannot be empty',
       'editterm.required' => 'You must associate this Assessment to a particular to certain term' 
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
        $assessment = cbcassessment::find($req->assessmentid);
        $assessment->Assessment = $req->exameditname.'_'.$req->editterm.'_'.$req->edityear;
        $assessment->Year = $req->edityear;
        $assessment->Term = $req->editterm;
        $assessment->Name = $req->exameditname;
        $assessment->Type = $req->examedittype;
        $assessment->save();

        return response()->json([
             'status' => 200,
             'messages' => 'Assessment Edited Successfully'
        ]);  
    } 
    }

     //Delete assessment
     public function deleteAssessment($ids){
        $idarray = explode(',',$ids);
            for ($i=0; $i < count($idarray) ; $i++) { 
                $exam = cbcassessment::find($idarray[$i]);
                $exam->deleted = '1';
                $exam->save(); 
            }
        return response()->json([
            'status' => 200,
            'messages' => 'Assessment deleted Successfullly'
        ]);
    }

    //fetch Exam
    public function getAssessment($id){
        $cbcassessment = cbcassessment::find($id);
        return response()->json([
            'cbcassessment' => $cbcassessment
        ]);
    }
}
