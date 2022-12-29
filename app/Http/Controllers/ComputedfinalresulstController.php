<?php

namespace App\Http\Controllers;
use App\Models\computedfinalresulst;
use App\Models\Subject;
use App\Models\classes;
use App\Models\FinalGrade;
use App\Models\ResultThread;
use Illuminate\Http\Request;

class ComputedfinalresulstController extends Controller
{
    //Function to insertfinal computed results
    public function insertComputedmarks(Request $req) {
        $adms = $req->viewadmissionnumber;
        $subjects = $req->subjects;
        $fnames = $req->viewfirstname;
        $lnames = $req->viewlname;
        $finalscore = $req->viewscore;
        $finalgrades = $req->viewgrade;
        $remarks = $req->viewremarks;
        $pointscores = $req->viewpoints;
        $markscores = $req->viewmarks;
        $classes = $req->viewclass;
        $grades = $req->viewgrades;

        $positions = [];
        //$sortedfinalscores = ; 

        for ($i=0; $i < count($adms); $i++) { 
            $records = computedfinalresulst::where('AdmissionNo',$adms[$i])
                                            ->where('tid',$req->tid)
                                            ->where('Class',$classes[$i])
                                            ->get();

            if (count($records) >= 1) {
                $records = computedfinalresulst::where('AdmissionNo',$adms[$i])
                                            ->where('tid',$req->tid)
                                            ->where('Class',$classes[$i])
                                            ->delete();
            }
        }



        for ($i=0; $i < count($adms); $i++) { 
            $recordtoinsert = new computedfinalresulst;
            $recordtoinsert->tid = $req->tid;
            $recordtoinsert->sid = $req->sid;
            $recordtoinsert->AdmissionNo = $adms[$i];
            $recordtoinsert->Fname = $fnames[$i];
            $recordtoinsert->Lname = $lnames[$i];
            $recordtoinsert->Finalscore = $finalscore[$i];
            $recordtoinsert->Finalgrade = $finalgrades[$i];
            $recordtoinsert->Remarks = $remarks[$i];
            $recordtoinsert->ScoresByPoints = $pointscores[$i];
            $recordtoinsert->ScoresByMarks = $markscores[$i];
            $recordtoinsert->Grades = $grades[$i];
            $recordtoinsert->Class = $classes[$i];
            $recordtoinsert->Subjects = $subjects[$i];
            
            $recordtoinsert->save();
        }

        $computedmarks = computedfinalresulst::where('Finalscore', '!=', null)
                                                ->where('sid',$req->sid)
                                                ->where('tid', $req->tid)
                                                ->whereIn('Class',$classes)
                                                ->orderBydesc('FinalScore')
                                                ->get();

        $notincluded = computedfinalresulst::where('Finalscore','=', null)
                                            ->where('sid',$req->sid)
                                            ->where('tid', $req->tid)
                                            ->whereIn('Class',$classes)
                                            ->get();

        $marks = [];
        $points = [];

        foreach ($computedmarks as $mark) {
            array_push($marks,$mark->Finalscore);
        }

        $subnames = [];
        $subids = [];

        if ($req->gradingtype === "Points") {
            $markstotal = array_sum($marks)/count($computedmarks);
            $average = round((($markstotal/84)*12),3);
        } else if ($req->gradingtype === "Marks"){
            $markstotal = array_sum($marks)/count($computedmarks);
            //$average = round((($markstotal/84)*12),3);
            $average = array_sum($marks)/count($computedmarks); 
        }
        

        

        $subs = Subject::where('sid',$req->sid)
                        ->where('educationsystem', '8-4-4') 
                        ->get();

        foreach ($subs as $sub) {
            array_push($subnames,$sub->subject);
            array_push($subids,$sub->id);
        }

        $classarray = [];
        $actualclasses = array_unique($req->viewclass);

        // $fetchedclasses = classes::where('sid',$req->sid)
        //                           ->whereIn('class',stripos)

        foreach ($actualclasses as $key => $value) {
            array_push($classarray,$value);
        }

        // for ($i=0; $i < count($actualclasses); $i++) { 
        //     array_push($classarray,$actualclasses[$i]);
        // }

        // $finalmarks = FinalGrade::where('tid',$req->tid)
        //                         ->where('sid',$sid)
        //                         ->whereIn('')

        $thread = ResultThread::find($req->tid);


        $filename = $req->form.' '.$thread['name'];

        return response()->json([
            'filename' => $filename,
            'classes' => $classarray,
            'status' => 200,
            'subnames' => $subnames,
            'subids' => $subids,
            'message' => 'Marks added Successfully',
            'Computedmarks' => $computedmarks,
            'notinluded' => $notincluded,
            'marks' => $marks,
            'average' => $average,
            'actualaverage' => $markstotal,
            'subjects' => $subs
        ]);
    }
}
