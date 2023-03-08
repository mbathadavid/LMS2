<?php

namespace App\Http\Controllers;
use App\Models\Mark;
use App\Models\Student;
use App\Models\classes;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\exam;
use App\Models\ResultThread;
use App\Models\cbcassessment;
use App\Models\computedfinalresulst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarkController extends Controller
{
    //Function to add marks
    public function addMarks(Request $req){
        $validator = Validator::make($req->all(),[
            'subjectno' => 'required',
            'maxscoreset' => 'required'
        ],
    [
        'subjectno.required' => 'You must select a subject for which marks are to be uploaded in the field above',
        'maxscoreset.required' => 'You must specify the maximum possible score for this subject in the field above'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
        //return response()->json(['data' => $req->all()]);
       $marks = $req->maxscored;
       $adms = $req->admissionnumber;
       $fnames = $req->firstname;
       $lnames = $req->lname;
       
       $newmarks = array_filter($marks);
       $newadms = array_filter($adms);
       $newfnames = array_filter($fnames);
       $newlnames = array_filter($lnames);
       
       if (count($newadms) != count($newmarks)) {
           return response()->json([
                'status' => 401,
                'messages' => 'System detected that marks for '.'<b>'.count($newadms) - count($newmarks).'</b>'.' students missing. Please check 
                 and make sure you fill.'
           ]);
       } else {
        $excessmarks = [];
         $maxscore = $req->maxscoreset;
         for ($i=0; $i < count($newmarks); $i++) { 
             if ($newmarks[$i] > $maxscore) {
                 array_push($excessmarks,$newmarks[$i]);
             }                   
         }

         if (count($excessmarks) > 0) {
            return response()->json([
                'status' => 402,
                'messages' => 'The system detected the marks '.'<b>'.implode(',',$excessmarks).'</b>'.' being greater than 
                 '.'<b>'.$maxscore.'</b> which is the maximum possible score.Please check and correct.'
            ]);
        } else {
           for ($i=0; $i < count($newmarks); $i++) { 
               $mark = new Mark;
               $mark->sid = $req->sid;
               $mark->classid = $req->classfield;
               $mark->examid = $req->examfield;
               $mark->subid = $req->subjectno;
               $mark->subject = $req->subjectname;
               $mark->AdmissionNo = $newadms[$i];
               $mark->Fname = $newfnames[$i];
               $mark->Lname = $newlnames[$i];
               $mark->marks = $newmarks[$i];
               $mark->maxscore = $req->maxscoreset;
               $mark->save();
           }

           return response()->json([
                'status' => 200,
                'messages' => 'Marks for '.'<b>'.$req->subjectname.'</b>'.' in '.'<b>'.$req->examnane.'</b>'.' for '.'<b>'.$req->classname.'</b>'.' set successfully'
           ]);
        }
         
       }
       
    }
    }

    //Add missing marks
    public function addmissingMarks(Request $req){
        $ids = array_filter($req->enablemarksinsert);
        $adms = array_filter($req->enteradmissionnumber);
        $fnames = array_filter($req->enterfirstname);
        $lnames = array_filter($req->enterlname);
        $marks = array_filter($req->entermarks);
        $maxscore = array_filter($req->entermaxscore);

        if (count($ids) != count($marks)) {
            return response()->json([
                'status' => 401,
                'messages' => 'System detected that marks for '.'<b>'.count($ids) - count($marks).'</b>'.' students missing. Please check 
                and make sure you fill inorder to update.'
            ]);
        } else {
            $excessmarks = [];
            for ($i=0; $i < count($ids); $i++) { 
                if ($marks[$i] > $maxscore[$i]) {
                    array_push($excessmarks,$marks[$i]);
                }   
            }

            if (count($excessmarks) > 0) {
                return response()->json([
                    'status' => 402,
                    'messages' => 'The system detected the marks '.'<b>'.implode(',',$excessmarks).'</b>'.' being greater than 
                    the maximum possible score.Please check and correct.'
                   ]);
            } else {
                for ($i=0; $i < count($marks); $i++) { 
                    $mark = new Mark;
                    $mark->sid = $req->sid;
                    $mark->classid = $req->classid;
                    $mark->examid = $req->examid;
                    $mark->subid = $req->subid;
                    $mark->subject = $req->subname;
                    $mark->AdmissionNo = $adms[$i];
                    $mark->Fname = $fnames[$i];
                    $mark->Lname = $lnames[$i];
                    $mark->marks = $marks[$i];
                    $mark->maxscore = $maxscore[$i];
                    $mark->save();   
                }

                return response()->json([
                    'status' => 200,
                    'messages' => 'Marks for '.'<b>'.implode(',',$adms).'</b>'.' Added Successfully'
               ]);
            }
         }
    }

    //Function to update marks
    public function updateMarks(Request $req){ 
        $ids = array_filter($req->enableupdate);
        $adms = array_filter($req->viewadmissionnumber);
        $fnames = array_filter($req->viewfirstname);
        $lnames = array_filter($req->viewlname);
        $marks = array_filter($req->viewmarks);
        $pkeys = array_filter($req->pkeys);
        $maxscore = array_filter($req->viewmaxscore);

        if (count($ids) != count($marks)) {
            return response()->json([
                'status' => 401,
                'messages' => 'System detected that marks for '.'<b>'.count($ids) - count($marks).'</b>'.' students missing. Please check 
                and make sure you fill inorder to update.'
            ]);
        } else {
            $excessmarks = [];
            for ($i=0; $i < count($ids); $i++) { 
                if ($marks[$i] > $maxscore[$i]) {
                    array_push($excessmarks,$marks[$i]);
                }   
            }

            if (count($excessmarks) > 0) {
                return response()->json([
                 'status' => 402,
                 'messages' => 'The system detected the marks '.'<b>'.implode(',',$excessmarks).'</b>'.' being greater than 
                 the maximum possible score.Please check and correct.'
                ]);
            } else {
                for ($i=0; $i < count($ids); $i++) { 
                    $mark = Mark::find($pkeys[$i]);
                    $mark->marks = $marks[$i];
                    $mark->maxscore = $maxscore[$i];
                    $mark->save();
                }
              
                return response()->json([
                    'status' => 200,
                    'messages' => 'Marks for '.'<b>'.implode(',',$adms).'</b>'.' updated successfully'
               ]); 
            }
            
        } 
    }

    //Function to fetch marks
    public function fetchMarks($exam,$cid,$sid){
        $marks = Mark::where('classid',$cid)
                        ->where('examid',$exam)
                        ->where('subject',$sid)
                        ->get();
        $outof = Mark::select('maxscore')
                    ->where('classid',$cid)
                    ->where('examid',$exam)
                    ->where('subject',$sid)
                    ->first();

        $class = classes::where('id',$cid)
                          ->get();

        /* $pkeys = Mark::where('classid',$cid)
                ->where('examid',$exam)
                ->where('subid',$sid)
                ->get(); */
        $students = Student::where('current_classid',$cid)
                            //->when()
                            ->get();
                            //->toArray();

        //$students = collect([$students]);

        // $results = array_filter($students, function ($item) use ($sid){
        //     if (stripos($item['suborlearningpaths'], $sid) !== false) {
        //         return true;
        //     } 
        //         return false;  
        // });

        $student = [];
        $score = [];
        $ids = [];
        foreach ($marks as $mark) {
            array_push($student,$mark->AdmissionNo);
            array_push($score,$mark->marks);
            array_push($ids,$mark->id);
        }

        $admsmarks = array_combine($student,$score);
        $pids = array_combine($student,$ids);
        return response()->json([
            'marks' => $marks,
            'subject' => $sid,
            'pids' => $pids,
            'score' => $score,
            'students' => $students,
            'student' => implode(',',$student),
            'student2' => $student,
            'admsmarks' => $admsmarks,
            'outof' => $outof,
            'class' => $class[0]['class'].' '.$class[0]['stream']
        ]);
    }

    //Delete marks
    public function deleteMarks($stuid,$exam,$classid,$sub){
        $mark = Mark::where('AdmissionNo',$stuid)
                      ->where('examid',$exam)
                      ->where('classid',$classid)
                      ->where('subject',$sub)
                      ->delete();

        if ($mark) {
            return response()->json([
                'status' => 200,
                'messages' => 'Marks for '.$stuid.' deleted successfully'
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'messages' => 'Error while deleting. Please wait'
            ]);
        }  
    }

    //Function to check term
    public function checkTerm($cid){
        $currentterm = classes::select('current_term')
                    ->where('id',$cid)
                    ->first();
        $students = Student::where('current_classid',$cid)
                    ->get();

         return response()->json([
            'cterm' => $currentterm,
            'students' => $students
         ]);          
    }

    //Function to fetch student perfomance
    public function studentPerfomance($stuid) {
        $student = Student::find($stuid);

        $computedmarks = computedfinalresulst::where('AdmissionNo',$student['AdmissionNo'])
                                            ->orWhere('AdmissionNo',$student['UPI'])
                                            ->orderByDesc('created_at')
                                            ->get();

        $cbcassessments = cbcassessment::where('sid',$student['sid'])
                                        ->orderByDesc('created_at')
                                        ->get();
                                            
        $scores = [];
        $ovpositions = [];
        $strpositions = [];
        $threads = [];
        $grades = [];
        $threadids = [];
        $terms = [];
        $years = [];

        foreach ($computedmarks as $key => $computedmark) {
            array_push($scores,$computedmark->Finalscore);
            array_push($ovpositions,$computedmark->OVRPO);
            array_push($strpositions,$computedmark->STRPOS);
            array_push($grades,$computedmark->Finalgrade);

            $thread = ResultThread::find($computedmark->tid);
            
            array_push($threads,$thread['name']);
            array_push($threadids,$thread['id']);
            array_push($terms,$thread['term']);
            array_push($years,$thread['year']);
        }

        return response()->json([
            'student' => $student,
            'scores' => $scores,
            'ovpositions' => $ovpositions,
            'strpositions' => $strpositions,
            'grades' => $grades,
            'threads' => $threads,
            'threadids' => $threadids,
            'terms' => $terms,
            'years' => $years,
            'cbcassessments' => $cbcassessments,
            'schoolsystem' => $student['schoolsystem']
        ]);
    }

    //FetchMarks
    public function checkMarks(Request $req){
        $cla = classes::where('id',$req->class)
                        ->where('sid',$req->sid)
                         ->get();

        // $sub = Subject::where('id',$req->subject)
        //                 ->where('sid',$req->sid)
        //                 ->get();   
        
        $sub = Subject::where('id',explode(',',$req->subject)[0])
                        ->where('sid',$req->sid)
                        ->get(); 

        $actualclass = $cla[0]['class'];  
        $actualsubject = $sub[0]['subject'];              

        $threads = ResultThread::where('sid',$req->sid)
                                ->OrderByDesc('id')
                                ->get();
        // $students = Student::where('current_classid',$req->class)
        //                     ->get();

        $students = Student::where('current_classid', $req->class)
                    ->whereRaw('FIND_IN_SET(?, subids)', [explode(',',$req->subject)[0]])
                    ->get();


        $subject = Subject::select('subject')
                    ->where('sid',$req->sid)
                    ->where('id',$req->subject)
                    ->first();
        $class = classes::select('class')
                    ->where('id',$req->class)
                    ->where('sid',$req->sid)
                    ->first();
        $stream = classes::select('stream')
                    ->where('id',$req->class)
                    ->where('sid',$req->sid)
                    ->first();
        $marks = Mark::where('classid',$req->class)
                    ->where('subject',$actualsubject)
                    ->where('sid',$req->sid)
                    ->get();
        $exams = explode(',', $req->exams);

        $grades = Grade::where('class',$actualclass)
                    ->where('subject',$actualsubject)
                    ->where('sid',$req->sid)
                    ->get();

        $admnos = [];
        $marksids = [];
        $finalmarks = [];
        $examnames = [];

        for ($i=0; $i < count($exams); $i++) { 
            $examname = exam::find($exams[$i]);
            array_push($examnames,$examname['Examination']);
        }

        foreach ($students as $student) {
            array_push($admnos, $student->AdmissionNo);
        }

        for ($i=0; $i < count($exams); $i++) { 
            array_push($marksids, 'mark,'.$exams[$i]);
        }

        // for ($i=0; $i < count($exams); $i++) { 
        //     array_push($marksids,$exams[$i]);
        // }

            $admmark = [];
            for ($k=0; $k < count($admnos); $k++) { 
                array_push($admmark,$admnos[$k].','.'mark');
            }

        $arrofarr = [];
        for ($i=0; $i < count($admmark); $i++) { 
            $arrname = $admmark[$i];
            $arrname = [];
            array_push($arrofarr,$arrname);
        }

        $examids = array_combine($marksids,$examnames);

        return response()->json([
            'subject' => $subject,
            'cid' => $cla[0]['id'],
            'sid' => explode(',',$req->subject)[0],
            'classid' => $req->class,
            'class' => $class,
            'stream' => $stream,
            'students' => $students,
            'marksids' => $marksids,
            'examids' => $examids,
            'admnos' => $admnos,
            'marks' => $marks,
            'threads' => $threads,
            'exams' => explode(',',$req->exams),
             'examnames' => $examnames,
             'grades' => $grades
        ]); 
    }
}
