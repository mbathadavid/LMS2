<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use App\Models\classes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    //Insert grades
    public function registerGrade(Request $req){
        $validator = Validator::make($req->all(),[
            'subject' => 'required',
            'class' => 'required',
            'minA' => 'required|max:2',
            'maxA' => 'required|max:2',
            'gradeA' => 'required|max:2',
            'pointsA' => 'required|max:2',
            'RemarksA' => 'required',
            'minA_minus' => 'required|max:2',
            'maxA_minus' => 'required|max:2',
            'gradeA_minus' => 'required|max:2',
            'pointsA_minus' => 'required|max:2',
            'RemarksA_minus' => 'required',
            'minB_plus' => 'required|max:2',
            'maxB_plus' => 'required|max:2',
            'gradeB_plus' => 'required|max:2',
            'pointsB_plus' => 'required|max:2',
            'RemarksB_plus' => 'required',
            'minB' => 'required|max:2',
            'maxB' => 'required|max:2',
            'gradeB' => 'required|max:2',
            'pointsB' => 'required|max:2',
            'RemarksB' => 'required',
            'minB_minus' => 'required|max:2',
            'maxB_minus' => 'required|max:2',
            'gradeB_minus' => 'required|max:2',
            'pointsB_minus' => 'required|max:2',
            'RemarksB_minus' => 'required',
            'minC_plus' => 'required|max:2',
            'maxC_plus' => 'required|max:2',
            'gradeC_plus' => 'required|max:2',
            'pointsC_plus' => 'required|max:2',
            'RemarksC_plus' => 'required',
            'minC' => 'required|max:2',
            'maxC' => 'required|max:2',
            'gradeC' => 'required|max:2',
            'pointsC' => 'required|max:2',
            'RemarksC' => 'required',
            'minC_minus' => 'required|max:2',
            'maxC_minus' => 'required|max:2',
            'gradeC_minus' => 'required|max:2',
            'pointsC_minus' => 'required|max:2',
            'RemarksC_minus' => 'required',
            'minD_plus' => 'required|max:2',
            'maxD_plus' => 'required|max:2',
            'gradeD_plus' => 'required|max:2',
            'pointsD_plus' => 'required|max:2',
            'RemarksD_plus' => 'required',
            'minD' => 'required|max:2',
            'maxD' => 'required|max:2',
            'gradeD' => 'required|max:2',
            'pointsD' => 'required|max:2',
            'RemarksD' => 'required',
            'minD_minus' => 'required|max:2',
            'maxD_minus' => 'required|max:2',
            'gradeD_minus' => 'required|max:2',
            'pointsD_minus' => 'required|max:2',
            'RemarksD_minus' => 'required',
            'minE' => 'required|max:2',
            'maxE' => 'required|max:2',
            'gradeE' => 'required|max:2',
            'pointsE' => 'required|max:2',
            'RemarksE' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $results = Grade::where('subid',explode(',',$req->subject)[0])
                        ->where('classid',explode(',',$req->class)[0])
                        ->get();
            if (count($results) >= 1) {
                $results = Grade::where('subid',explode(',',$req->subject)[0])
                            ->where('classid',explode(',',$req->class)[0])
                            ->delete();
            }

            $grade = new Grade;
            $grade->subid = explode(',',$req->subject)[0];
            $grade->subject = explode(',',$req->subject)[1];
            $grade->classid = explode(',',$req->class)[0];
            $grade->minA = $req->minA;
            $grade->maxA = $req->maxA;
            $grade->gradeA = $req->gradeA;
            $grade->pointA = $req->pointsA;
            $grade->RemarksA = $req->RemarksA;
            $grade->minA_minus = $req->minA_minus;
            $grade->maxA_minus = $req->maxA_minus;
            $grade->gradeA_minus = $req->gradeA_minus;
            $grade->pointA_minus = $req->pointsA_minus;
            $grade->RemarksA_minus = $req->RemarksA_minus;
            $grade->minB_plus = $req->minB_plus;
            $grade->maxB_plus = $req->maxB_plus;
            $grade->gradeB_plus = $req->gradeB_plus;
            $grade->pointB_plus = $req->pointsB_plus;
            $grade->RemarksB_plus = $req->RemarksB_plus;
            $grade->minB = $req->minB;
            $grade->maxB = $req->maxB;
            $grade->gradeB = $req->gradeB;
            $grade->pointB = $req->pointsB;
            $grade->RemarksB = $req->RemarksB;
            $grade->minB_minus = $req->minB_minus;
            $grade->maxB_minus = $req->maxB_minus;
            $grade->gradeB_minus = $req->gradeB_minus;
            $grade->pointB_minus = $req->pointsB_minus;
            $grade->RemarksB_minus = $req->RemarksB_minus;
            $grade->minC_plus = $req->minC_plus;
            $grade->maxC_plus = $req->maxC_plus;
            $grade->gradeC_plus = $req->gradeC_plus;
            $grade->pointC_plus = $req->pointsC_plus;
            $grade->RemarksC_plus = $req->RemarksC_plus;
            $grade->minC = $req->minC;
            $grade->maxC = $req->maxC;
            $grade->gradeC = $req->gradeC;
            $grade->pointC = $req->pointsC;
            $grade->RemarksC = $req->RemarksC;
            $grade->minC_minus = $req->minC_minus;
            $grade->maxC_minus = $req->maxC_minus;
            $grade->gradeC_minus = $req->gradeC_minus;
            $grade->pointC_minus = $req->pointsC_minus;
            $grade->RemarksC_minus = $req->RemarksC_minus;
            $grade->minD_plus = $req->minD_plus;
            $grade->maxD_plus = $req->maxD_plus;
            $grade->gradeD_plus = $req->gradeD_plus;
            $grade->pointD_plus = $req->pointsD_plus;
            $grade->RemarksD_plus = $req->RemarksD_plus;
            $grade->minD = $req->minD;
            $grade->maxD = $req->maxD;
            $grade->gradeD = $req->gradeD;
            $grade->pointD = $req->pointsD;
            $grade->RemarksD = $req->RemarksD;
            $grade->minD_minus = $req->minD_minus;
            $grade->maxD_minus = $req->maxD_minus;
            $grade->gradeD_minus = $req->gradeD_minus;
            $grade->pointD_minus = $req->pointsD_minus;
            $grade->RemarksD_minus = $req->RemarksD_minus;
            $grade->minE = $req->minE;
            $grade->maxE = $req->maxE;
            $grade->gradeE = $req->gradeE;
            $grade->pointE = $req->pointsE;
            $grade->RemarksE = $req->RemarksE;

            $grade->save();
            return response()->json([
                'status' => 200,
                //'messages' => explode(',',$req->classid)[1].' '.explode(',',$req->classid)[2].' '.explode(',',$req->subject)[1].' '.'Grading set Successfully'
                'messages' => explode(',',$req->subject)[1].' '.'Grading System set Successfully for '.explode(',',$req->class)[1].' '.explode(',',$req->class)[2]
            ]);
        }
        
    }
}
