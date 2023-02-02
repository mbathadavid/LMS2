<?php

namespace App\Http\Controllers;
use App\Models\computedfinalresulst;
use App\Models\Subject;
use App\Models\classes;
use App\Models\FinalGrade;
use App\Models\ResultThread;
use App\Models\classmeans;
use App\Models\subjectmeans;
use App\Models\overallGradeSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $kcpemarks = $req->kcpemarks;
        $classids = $req->viewclassid;

        $positions = [];

        $classarray = [];
        $classidsarray = [];
        $actualclasses = array_unique($req->viewclass);
        $actualclassids = array_unique($req->viewclassid);

        foreach ($actualclasses as $key => $value) {
            array_push($classarray,$value);
        }

        $class = $classarray[0];
        $classname = explode(' ',$class)[0].' '.explode(' ',$class)[1];

        foreach ($actualclassids as $key => $value) {
            array_push($classidsarray,$value);
        }

        //Prepare Grading Systm
        $pulledremarks = [];
        $minmarks = [];
        $maxmarks = [];
        $topgrades = [];
        $pulledpoints = [];

        $gradingsystem = overallGradeSystem::where('sid',$req->sid)
                                            ->where('class',$classname)
                                            ->get();

        //$gradesarray = $gradingsystem[0];
        $gradingsystem = $gradingsystem[0]->toArray();

        foreach ($gradingsystem as $key => $value) {
            if (array_key_exists($key, $gradingsystem)) {
                if (strpos($key, 'Remarks') !== false) {
                    array_push($pulledremarks, $gradingsystem[$key]);
                }
        
                if (strpos($key, 'minE') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minD_minus') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minD') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minD_plus') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minC_minus') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minC') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minC_plus') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minB_minus') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minB') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minB_plus') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minA_minus') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'minA') !== false) {
                    array_push($minmarks, (int)$gradingsystem[$key]);
                }
        
                if (strpos($key, 'max') !== false) {
                    array_push($maxmarks, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'point') !== false) {
                    array_push($pulledpoints, (int)$gradingsystem[$key]);
                }
                if (strpos($key, 'grade') !== false) {
                    array_push($topgrades, $gradingsystem[$key]);
                }
            }
        }

        $minmarks = array_values(array_unique($minmarks));
        

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
            $recordtoinsert->KCPE_marks = $kcpemarks[$i];
            $recordtoinsert->ScoresByPoints = $pointscores[$i];
            $recordtoinsert->ScoresByMarks = $markscores[$i];
            $recordtoinsert->Grades = $grades[$i];
            $lastscore = computedfinalresulst::where('tid',($req->tid) - 1)
                                                ->where('AdmissionNo',$adms[$i])
                                                ->where('Class',$classes[$i])
                                                ->get();

            if (count($lastscore) > 0) {
                $dev = $finalscore[$i] - $lastscore[0]['Finalscore'];
                $recordtoinsert->Prev_Score = $lastscore[0]['Finalscore']; 
                if ($dev < 0) {
                    $recordtoinsert->DEV = $dev;
                } else {
                    $recordtoinsert->DEV = '+'.$dev;
                }
            } else {
                $recordtoinsert->DEV = "N/A";
                $recordtoinsert->Prev_Score = "N/A";
            }

            $recordtoinsert->Class = $classes[$i];
            $recordtoinsert->Class_id = $classids[$i];
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
        $rankedadms = [];
        $rankedids = [];
        $rankedclasses = [];
        $rankedclassids = [];

        foreach ($computedmarks as $mark) {
            array_push($marks,$mark->Finalscore);
            array_push($rankedadms,$mark->AdmissionNo);
            array_push($rankedids,$mark->id);
            array_push($rankedclasses,$mark->Class);
            array_push($rankedclassids,$mark->Class_id);
        }       

        $subnames = [];
        $subids = [];

        $ovrpositions = [];

        // Work on Overall ranking start
        $current_rank = 1;
        // iterate over the marks
        for ($i = 0; $i < count($marks); $i++) {
        // if this is the first mark or if it is not a tie with the previous mark
        if ($i == 0 || $marks[$i] != $marks[$i - 1]) {
            // assign the current rank to the mark
            $ovrpositions[] = $current_rank;
        } else {
            $ovrpositions[] = $ovrpositions[$i - 1];
        }
        $current_rank++;
        }
        // Work on Overall ranking end

        // Work on kcpe ranking start
        $kcpescores = [];
        $kcperanking = [];
        $kcperanksids = [];

        $kcperankmarks = computedfinalresulst::where('Finalscore', '!=', null)
                                                ->where('sid',$req->sid)
                                                ->where('tid', $req->tid)
                                                ->whereIn('Class',$classes)
                                                ->orderBydesc('KCPE_marks')
                                                ->get();

        foreach ($kcperankmarks as $key => $kcperankmark) {
            array_push($kcpescores,$kcperankmark->KCPE_marks);
            array_push($kcperanksids,$kcperankmark->id);
        }

        $currentkcpe_rank = 1;
        // iterate over the marks
        for ($i = 0; $i < count($kcpescores); $i++) {
        // if this is the first mark or if it is not a tie with the previous mark
        if ($i == 0 || $kcpescores[$i] != $kcpescores[$i - 1]) {
            // assign the current rank to the mark
            $kcperanking[] = $currentkcpe_rank;
        } else {
            $kcperanking[] = $kcperanking[$i - 1];
        }
        $currentkcpe_rank++;
        }
        // Work on Overall ranking end

        $idspstns = array_combine($rankedids,$ovrpositions);
        $idskcpe = array_combine($kcperanksids,$kcperanking);
        //$sortedidskcpe = krsort($idskcpe);
        
        //Update kcperaking 
        for ($i=0; $i < count($idskcpe); $i++) { 
            $rankid = array_keys($idskcpe)[$i];
            $position = $idskcpe[$rankid];

            $computedmark = computedfinalresulst::find($rankid);
            $computedmark->KCPE_rank = $position;
            $computedmark->save();  
        }

        //Update student marks 
        for ($i=0; $i < count($idspstns); $i++) { 
            $rankid = array_keys($idspstns)[$i];
            $position = $idspstns[$rankid];

            $computedmark = computedfinalresulst::find($rankid);
            $computedmark->OVRPO = $position;
            $computedmark->save();             
        }

        //$classarray = ['FORM FOUR B','FORM FOUR A'];
        $streamranks = [];
        $streampositions = [];
        $streamids = [];
        $classidscombinationations = [];

        foreach ($classarray as $key) {
            $streamranks[$key] = [];
            $streampositions[$key] = [];
            $streamids[$key] = [];
        }

        foreach ($classidsarray as $key) {
            $classidscombinationations[$key] = [];
        }

        $combinedstreammarks = array();
        $combinedidsmarks = array();
        $combinedclassidsmarks = array();

        for ($i = 0; $i < count($rankedclasses); $i++) {
            $combinedstreammarks[] = [
              'class' => $rankedclasses[$i],
              'score' => $marks[$i]
            ];

            $combinedidsmarks[] = [
                'class' => $rankedclasses[$i],
                'score' => $rankedids[$i]
            ];

          }

          for ($i=0; $i < count($rankedclassids); $i++) { 
            $combinedclassidsmarks[] = [
                'classid' => $rankedclassids[$i],
                'score' => $marks[$i]
            ];
          }

        foreach ($classidscombinationations as $key => $classidscombinationation) {
            for ($i=0; $i < count($combinedclassidsmarks); $i++) { 
                if ($key == $combinedclassidsmarks[$i]['classid']) {
                    array_push($classidscombinationations[$key],$combinedclassidsmarks[$i]['score']);
                }
            }
        }

        foreach ($streamranks as $key => $streamrank) {
            for ($i=0; $i < count($combinedstreammarks); $i++) { 
                if ($key == $combinedstreammarks[$i]['class']) {
                    array_push($streamranks[$key],$combinedstreammarks[$i]['score']);
                }
            }
        }

        foreach ($streamids as $key => $streamid) {
            for ($i=0; $i < count($combinedidsmarks); $i++) { 
                if ($key == $combinedidsmarks[$i]['class']) {
                    array_push($streamids[$key],$combinedidsmarks[$i]['score']);
                }
            }
        }

        foreach ($streamranks as $key => $streamrank) {
            $current_rank = 1;
           for ($i=0; $i < count($streamranks[$key]); $i++) { 
                if ($i == 0 || $streamranks[$key][$i] != $streamranks[$key][$i - 1]) {
                    array_push($streampositions[$key],$current_rank);
                } else {
                    array_push($streampositions[$key],$streampositions[$key][$i - 1]);
                }
                // increment the current rank
                $current_rank++; 
           } 
        }

        //Update Stream based ranking
        foreach ($streamids as $key => $streamid) {
            for ($i=0; $i < count($streamid); $i++) { 
                $computedmark = computedfinalresulst::find($streamid[$i]);
                $computedmark->STRPOS = $streampositions[$key][$i];
                $computedmark->save();
            }
        }

        //Fetch again after ranking
        $computedmarks = computedfinalresulst::where('Finalscore', '!=', null)
                                                ->where('sid',$req->sid)
                                                ->where('tid', $req->tid)
                                                ->whereIn('Class',$classes)
                                                ->orderBydesc('FinalScore')
                                                ->get();

        //Delete any previously added class averages 
            $classaverages = classmeans::where('sid',$req->sid)
                                    ->where('tid',$req->tid)
                                    ->where('class',$classname)
                                    ->get();

            if (count($classaverages) >= 1) {
                $classaverages = classmeans::where('sid',$req->sid)
                                        ->where('tid',$req->tid)
                                        ->where('class',$classname)
                                        ->delete();
            }

        $classmean = new classmeans;
        $as = [];
        $aminus = [];
        $bplus = [];
        $bs = [];
        $bminus = [];
        $cplus = [];
        $cs = [];
        $cminus = [];
        $dplus = [];
        $ds = [];
        $dminus = [];
        $es = [];

        foreach ($computedmarks as $key => $computedmark) {
            if ($computedmark->Finalgrade === "A") {
                array_push($as, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "A-") {
                array_push($aminus, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "B+") {
                array_push($bplus, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "B") {
                array_push($bs, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "B-") {
                array_push($bminus, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "C+") {
                array_push($cplus, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "C") {
                array_push($cs, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "C-") {
                array_push($cminus, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "D+") {
                array_push($dplus, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "D") {
                array_push($ds, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "D-") {
                array_push($dminus, $computedmark->Finalgrade);
            } else if ($computedmark->Finalgrade === "E") {
                array_push($es, $computedmark->Finalgrade);
            } 
        }

       // if ($req->gradingtype === "Points") {
            $grade = '';
            $markstotal = array_sum($marks)/count($computedmarks);
            if ($req->gradingtype === "Points") {
                $average = round((($markstotal/84)*12),3);
            } else if ($req->gradingtype === "Marks") {
                $average = round(array_sum($marks)/count($computedmarks),3);
            }
            
            for ($i=0; $i < count($maxmarks); $i++) { 
                if ($average >= $minmarks[$i] && $average <= $maxmarks[$i]) {
                    $grade = $topgrades[$i];
                }
            }

            $classmean->sid = $req->sid;
            $classmean->tid = $req->tid;
            $classmean->class = $classname;
            $classmean->mean_score = $average;
            $classmean->student_count = count($computedmarks);
            $classmean->As = count($as);
            $classmean->A_minus = count($aminus);
            $classmean->B_plus = count($bplus);
            $classmean->Bs = count($bs);
            $classmean->B_minus = count($bminus);
            $classmean->C_plus = count($cplus);
            $classmean->Cs = count($cs);
            $classmean->C_minus = count($cminus);
            $classmean->D_plus = count($dplus);
            $classmean->Ds = count($ds);
            $classmean->D_minus = count($dminus);
            $classmean->Es = count($es);
            $classmean->save();
        
    //Work on individual class averages start
        $testingclasses = [];
        $testingtotals = [];
        $testingcounts = [];

        foreach ($streamranks as $stream => $scores) {
            array_push($testingclasses,$stream);
            array_push($testingtotals,array_sum($scores));
            array_push($testingcounts,count($scores));
        }

        for ($i=0; $i < count($testingclasses); $i++) {
            $classaverages = classmeans::where('sid',$req->sid)
                                    ->where('tid',$req->tid)
                                    ->where('class',$testingclasses[$i])
                                    ->get();

            if (count($classaverages) >= 1) {
                $classaverages = classmeans::where('sid',$req->sid)
                                        ->where('tid',$req->tid)
                                        ->where('class',$testingclasses[$i])
                                        ->delete();
            }
                $classmean = new classmeans;
                $ass = [];
                $asminus = [];
                $bsplus = [];
                $bss = [];
                $bsminus = [];
                $csplus = [];
                $css = [];
                $csminus = [];
                $dsplus = [];
                $dss = [];
                $dsminus = [];
                $ess = [];

                foreach ($computedmarks as $key => $computedmark) {
                    if ($computedmark->Finalgrade === "A" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($ass, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "A-" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($asminus, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "B+" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($bsplus, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "B" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($bss, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "B-" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($bsminus, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "C+" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($csplus, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "C" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($css, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "C-" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($csminus, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "D+" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($dsplus, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "D" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($dss, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "D-" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($dsminus, $computedmark->Finalgrade);
                    } else if ($computedmark->Finalgrade === "E" and $computedmark->Class === $testingclasses[$i]) {
                        array_push($ess, $computedmark->Finalgrade);
                    } 
                }

               // if ($req->gradingtype === "Points") {
                    $markstotal = $testingtotals[$i]/$testingcounts[$i];

                    if ($req->gradingtype === "Points") {
                        $average = round((($markstotal/84)*12),3);
                    } else if ($req->gradingtype === "Marks") {
                        $average = round($testingtotals[$i]/$testingcounts[$i],3);
                    }
                    
                    $classmean->sid = $req->sid;
                    $classmean->tid = $req->tid;
                    $classmean->class = $testingclasses[$i];
                    $classmean->mean_score = $average;
                    $classmean->student_count = $testingcounts[$i];
                    $classmean->As = count($ass);
                    $classmean->A_minus = count($asminus);
                    $classmean->B_plus = count($bsplus);
                    $classmean->Bs = count($bss);
                    $classmean->B_minus = count($bsminus);
                    $classmean->C_plus = count($csplus);
                    $classmean->Cs = count($css);
                    $classmean->C_minus = count($csminus);
                    $classmean->D_plus = count($dsplus);
                    $classmean->Ds = count($dss);
                    $classmean->D_minus = count($dsminus);
                    $classmean->Es = count($ess);
                    $classmean->save();  
        }
    //Work on individual class averages End

        $subs = Subject::where('sid',$req->sid)
                        ->where('educationsystem', '8-4-4') 
                        ->get();

        foreach ($subs as $sub) {
            array_push($subnames,$sub->subject);
            array_push($subids,$sub->id);
        }

        $thread = ResultThread::find($req->tid);


        $filename = $req->form.' '.$thread['name'];

        return response()->json([
            'filename' => $filename,
            'class' => $class,
            'classes' => $classarray,
            'classname' => $classname,
            'combinedclassidsmarks' => $combinedclassidsmarks,
            'classidscombinationations' => $classidscombinationations,
            'classidsarray' => $classidsarray,
            'status' => 200,
            'gradingsystem' => $gradingsystem,
            'subnames' => $subnames,
            'subids' => $subids,
            'message' => 'Marks added Successfully',
            'Computedmarks' => $computedmarks,
            'notinluded' => $notincluded,
            'marks' => $marks,
            'ovrpositions' => $ovrpositions,
            'average' => $average,
            'actualaverage' => $markstotal,
            'subjects' => $subs,
            'rankedadms' => $rankedadms,
            'rankedclasses' => $rankedclasses,
            'streamranks' => $streamranks,
            'streampositions' => $streampositions,
            'streamids' => $streamids,
            'kcpescores' => $kcpescores,
            'kcperanking' => $kcperanking,
            'idskcpe' => $idskcpe,
            'kcperanksids' => $kcperanksids,
            'combinedstreammarks' => $combinedstreammarks,
            'combinedidsmarks' => $combinedidsmarks, 
            'rankedids' => $rankedids,
            'pulledremarks' => $pulledremarks,
            'minmarks' => $minmarks,
            'maxmarks' => $maxmarks,
            'points' => $pulledpoints,
            'topgrades' => $topgrades,
            'testingclasses' => $testingclasses,
            'testingtotals' => $testingtotals,
            'testingcounts' => $testingcounts
        ]);
    }

    //Function to analyse results 
    public function resultAnalysis(Request $req){
        $validator = Validator::make($req->all(),[
            'class' => 'required',
            'examthread' => 'required',
        ],
        [
                'class.required' => 'You must select a class',
                'examthread.required' => 'You must select an examination'
        ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
        $computedmarks = computedfinalresulst::where('sid',$req->sid)
                                                ->where('tid', $req->examthread)
                                                ->where('Class', 'LIKE', '%'.$req->class.'%')
                                                ->where('Finalscore','!=',null)
                                                ->orderBydesc('FinalScore')
                                                ->get();

        $lackingmarks = computedfinalresulst::where('sid',$req->sid)
                                                ->where('tid', $req->examthread)
                                                ->where('Class', 'LIKE', '%'.$req->class.'%')
                                                ->where('Finalscore','=',null)
                                                ->orderBydesc('FinalScore')
                                                ->get();

        if (count($computedmarks) == 0) {
            return response()->json([
                'status' => 401,
                'messages' => 'Sorry, there are no records matching the above selection that can be analyzed'
            ]);
        } else {
            $subjects = Subject::where('sid',$req->sid)
                                ->where('educationsystem','8-4-4')
                                ->where('level','Secondary')
                                ->where('deleted',0)
                                ->get();
                                
            $classmeans = classmeans::where('sid',$req->sid)
                                    ->where('tid',$req->examthread)
                                    ->where('Class', 'LIKE', '%'.$req->class.'%')
                                    ->get();

            $subjectmeans = subjectmeans::where('sid',$req->sid)
                                        ->where('tid',$req->examthread)
                                        ->where('Class', 'LIKE', '%'.$req->class.'%')
                                        ->get();

            $classformean = [];
            $theclassmeans = [];
            $meanclasstucounts = [];
            $subids = [];
            $subnames = [];
            $as = [];
            $aminus = [];
            $bplus = [];
            $bs = [];
            $bminus = [];
            $cplus = [];
            $cs = [];
            $cminus = [];
            $dplus = [];
            $ds = [];
            $dminus = [];
            $es = [];

            foreach ($subjects as $key => $subject) {
                array_push($subids,$subject->id);
                array_push($subnames,$subject->subject);
            }

            foreach ($classmeans as $key => $classmean) {
                array_push($classformean,$classmean->class);
                array_push($theclassmeans,$classmean->mean_score);
                array_push($meanclasstucounts,$classmean->student_count);
                array_push($as,$classmean->As);
                array_push($aminus,$classmean->A_minus);
                array_push($bplus,$classmean->B_plus);
                array_push($bs,$classmean->Bs);
                array_push($bminus,$classmean->B_minus);
                array_push($cplus,$classmean->C_plus);
                array_push($cs,$classmean->Cs);
                array_push($cminus,$classmean->C_minus);
                array_push($dplus,$classmean->D_plus);
                array_push($ds,$classmean->Ds);
                array_push($dminus,$classmean->D_minus);
                array_push($es,$classmean->Es);
            }

            $classmeancombination = array_combine($classformean,$theclassmeans);
            $classstudentcountcombination = array_combine($classformean,$meanclasstucounts);

            return response()->json([
                'status' => 200,
                'computedmarks' => $computedmarks,
                'subjects' => $subjects,
                'classmeans' => $classmeans,
                'subjectmeans' => $subjectmeans,
                'lackingmarks' => $lackingmarks,
                'classformean' => $classformean,
                'tid' => $req->examthread,
                'as' => $as,
                'aminus' => $aminus,
                'bplus' => $bplus,
                'bs' => $bs,
                'bminus' => $bminus,
                'cplus' => $cplus,
                'cs' => $cs,
                'cminus' => $cminus,
                'dplus' => $dplus,
                'ds' => $ds,
                'dminus' => $dminus,
                'es' => $es,
                'theclassmeans' => $theclassmeans,
                'meanclasstucounts' => $meanclasstucounts,
                'classmeancombination' => $classmeancombination,
                'classstudentcountcombination' => $classstudentcountcombination,
                'subids' => $subids,
                'subnames' => $subnames
            ]);
        }
    
    }
    }

    //Function for analyzing Subject Perfomance 
    public function subjectAnalysis(Request $req) {
        $validator = Validator::make($req->all(),[
            'subexamthread' => 'required',
            'subclass' => 'required',
            'subject' => 'required',
        ],
        [
            'subexamthread.required' => 'You must select examination',
            'subclass.required' => 'You must select a class',
            'subject.required' => 'You must select a subject'
        ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
        $subjectmeans = subjectmeans::where('sid',$req->sid)
                                        ->where('tid',$req->subexamthread)
                                        ->where('Class', 'LIKE', '%'.$req->subclass.'%')
                                        ->where('subid', $req->subject)
                                        ->get();

        if (count($subjectmeans) == 0) {
            return response()->json([
                'status' => 401,
                'messages' => 'Sorry, there are no records matching the above selection that can be analyzed'
            ]);
        } else {
            $subids = [];
            $subnames = [];
            $classes = [];
            $meanmarks = [];
            $stucounts = [];

            $subjects = Subject::where('sid',$req->sid)
                                ->where('educationsystem','8-4-4')
                                ->where('level','Secondary')
                                ->where('deleted',0)
                                ->get();

            foreach ($subjects as $key => $subject) {
                array_push($subids,$subject->id);
                array_push($subnames,$subject->subject);
            }

            foreach ($subjectmeans as $key => $subjectmean) {
                array_push($classes,$subjectmean->class);
                array_push($meanmarks,$subjectmean->mean_marks);
                array_push($stucounts,$subjectmean->student_count);
            }

            return response()->json([
                'status' => 200, 
                'subjectmeans' => $subjectmeans,
                'subjects' => $subjects,
                'subids' => $subids,
                'subnames' => $subnames,
                'classes' => $classes,
                'meanmarks' => $meanmarks,
                'stucounts' => $stucounts,
                'tid' => $req->subexamthread
            ]);
        }
    }
    }
}
