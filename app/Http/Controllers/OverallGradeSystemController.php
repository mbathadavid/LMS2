<?php

namespace App\Http\Controllers;

use App\Models\overallGradeSystem;
use App\Models\classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OverallGradeSystemController extends Controller
{
    public function registeroverallgrading(Request $req){
        $validator = Validator::make($req->all(),[
            'gradingtype' => 'required',
            'class' => 'required',
            'minA' => 'required|max:4',
            'maxA' => 'required|max:4',
            'gradeA' => 'required|max:4',
            'RemarksA' => 'required',
            'minA_minus' => 'required|max:4',
            'maxA_minus' => 'required|max:4',
            'gradeA_minus' => 'required|max:4',
            'RemarksA_minus' => 'required',
            'minB_plus' => 'required|max:4',
            'maxB_plus' => 'required|max:4',
            'gradeB_plus' => 'required|max:4',
            'RemarksB_plus' => 'required',
            'minB' => 'required|max:4',
            'maxB' => 'required|max:4',
            'gradeB' => 'required|max:4',
            'RemarksB' => 'required',
            'minB_minus' => 'required|max:4',
            'maxB_minus' => 'required|max:4',
            'gradeB_minus' => 'required|max:4',
            'RemarksB_minus' => 'required',
            'minC_plus' => 'required|max:4',
            'maxC_plus' => 'required|max:4',
            'gradeC_plus' => 'required|max:4',
            'RemarksC_plus' => 'required',
            'minC' => 'required|max:4',
            'maxC' => 'required|max:4',
            'gradeC' => 'required|max:4',
            'RemarksC' => 'required',
            'minC_minus' => 'required|max:4',
            'maxC_minus' => 'required|max:4',
            'gradeC_minus' => 'required|max:4',
            'RemarksC_minus' => 'required',
            'minD_plus' => 'required|max:4',
            'maxD_plus' => 'required|max:4',
            'gradeD_plus' => 'required|max:4',
            'RemarksD_plus' => 'required',
            'minD' => 'required|max:4',
            'maxD' => 'required|max:4',
            'gradeD' => 'required|max:4',
            'RemarksD' => 'required',
            'minD_minus' => 'required|max:4',
            'maxD_minus' => 'required|max:4',
            'gradeD_minus' => 'required|max:4',
            'RemarksD_minus' => 'required',
            'minE' => 'required|max:4',
            'maxE' => 'required|max:4',
            'gradeE' => 'required|max:4',
            'RemarksE' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $results = overallGradeSystem::where('class',explode(',',$req->class)[0])
                                            ->get();
            if (count($results) >= 1) {
                $results = overallGradeSystem::where('class',explode(',',$req->class)[0])
                                                ->delete();
            }

            $grade = new overallGradeSystem;
            $grade->class = explode(',',$req->class)[0];
            $grade->sid = $req->sid;
            $grade->consideration = $req->gradingtype;
            $grade->minA = $req->minA;
            $grade->maxA = $req->maxA;
            $grade->gradeA = $req->gradeA;
            $grade->RemarksA = $req->RemarksA;
            $grade->minA_minus = $req->minA_minus;
            $grade->maxA_minus = $req->maxA_minus;
            $grade->gradeA_minus = $req->gradeA_minus;
            $grade->RemarksA_minus = $req->RemarksA_minus;
            $grade->minB_plus = $req->minB_plus;
            $grade->maxB_plus = $req->maxB_plus;
            $grade->gradeB_plus = $req->gradeB_plus;
            $grade->RemarksB_plus = $req->RemarksB_plus;
            $grade->minB = $req->minB;
            $grade->maxB = $req->maxB;
            $grade->gradeB = $req->gradeB;
            $grade->RemarksB = $req->RemarksB;
            $grade->minB_minus = $req->minB_minus;
            $grade->maxB_minus = $req->maxB_minus;
            $grade->gradeB_minus = $req->gradeB_minus;
            $grade->RemarksB_minus = $req->RemarksB_minus;
            $grade->minC_plus = $req->minC_plus;
            $grade->maxC_plus = $req->maxC_plus;
            $grade->gradeC_plus = $req->gradeC_plus;
            $grade->RemarksC_plus = $req->RemarksC_plus;
            $grade->minC = $req->minC;
            $grade->maxC = $req->maxC;
            $grade->gradeC = $req->gradeC;
            $grade->RemarksC = $req->RemarksC;
            $grade->minC_minus = $req->minC_minus;
            $grade->maxC_minus = $req->maxC_minus;
            $grade->gradeC_minus = $req->gradeC_minus;
            $grade->RemarksC_minus = $req->RemarksC_minus;
            $grade->minD_plus = $req->minD_plus;
            $grade->maxD_plus = $req->maxD_plus;
            $grade->gradeD_plus = $req->gradeD_plus;
            $grade->RemarksD_plus = $req->RemarksD_plus;
            $grade->minD = $req->minD;
            $grade->maxD = $req->maxD;
            $grade->gradeD = $req->gradeD;
            $grade->RemarksD = $req->RemarksD;
            $grade->minD_minus = $req->minD_minus;
            $grade->maxD_minus = $req->maxD_minus;
            $grade->gradeD_minus = $req->gradeD_minus;
            $grade->RemarksD_minus = $req->RemarksD_minus;
            $grade->minE = $req->minE;
            $grade->maxE = $req->maxE;
            $grade->gradeE = $req->gradeE;
            $grade->RemarksE = $req->RemarksE;

            $grade->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Overall Grading System set Successfully'
                //'messages' => explode(',',$req->classid)[1].' '.explode(',',$req->classid)[2].' '.explode(',',$req->subject)[1].' '.'Grading set Successfully'
                //'messages' => 'Overall Grading System set Successfully for '.explode(',',$req->class)[1].' '.explode(',',$req->class)[2]
            ]);
        }
    }
    //Function to fetch one Class Grading System
    public function fetchFinalResult($sid,$cid){
        $grades = overallGradeSystem::where('class',explode(',',$cid)[0])
                                     ->where('sid',$sid)
                                     ->get();

        //$class = classes::find(explode(',',$cid)[0]);
        return response()->json([
            'grades' => $grades,
            'class' => $cid
            //'class' => $class['class'].' '.$class['stream']
        ]);
        
    }
}
