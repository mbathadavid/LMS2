<?php

namespace App\Http\Controllers;
use App\Models\cbcassessment;
use App\Models\cbcmarks;
use App\Models\classes;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CbcmarksController extends Controller
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
       $marks = $req->maxscored;
       $adms = $req->admissionnumber;
       $fnames = $req->firstname;
       //$lnames = $req->lname;
       
       $newmarks = array_filter($marks);
       $newadms = array_filter($adms);
       $newfnames = array_filter($fnames);
       //$newlnames = array_filter($lnames);
       
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
            // return response()->json(['data' => $req->all()]);
           for ($i=0; $i < count($newmarks); $i++) { 
               $mark = new cbcmarks;
               $mark->sid = $req->sid;
               $mark->classid = $req->classfield;
               $mark->examid = $req->examfield;
               $mark->subid = $req->subjectno;
               $mark->subject = $req->subjectname;
               $mark->AdmissionNo = $newadms[$i];
               $mark->Name = $newfnames[$i];
               $mark->marks = $newmarks[$i];

               if ($req->gradescored[$i] === null) {
                    $mark->Grade = 'Not Assigned';
               } else {
                    $mark->Grade = $req->gradescored[$i];
               }

               if ($req->remarks[$i] === null) {
                    $mark->Remarks = 'Not Assigned';
               } else {
                    $mark->Remarks = $req->remarks[$i];
               }
        
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

    //Function to delete marks
    public function deleteMarks($stuid,$exam,$classid,$sub){
        $mark = cbcmarks::where('AdmissionNo',$stuid)
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

        //Add missing marks
        public function addmissingMarks(Request $req){
            $ids = array_filter($req->enablemarksinsert);
            $adms = array_filter($req->enteradmissionnumber);
            $fnames = array_filter($req->enterfirstname);
            //$lnames = array_filter($req->enterlname);
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
                    //return ['data' => $req->all()];
                    for ($i=0; $i < count($marks); $i++) { 
                        $mark = new cbcmarks;
                        $mark->sid = $req->sid;
                        $mark->classid = $req->classid;
                        $mark->examid = $req->examid;
                        $mark->subid = $req->subid;
                        $mark->subject = $req->subname;
                        $mark->AdmissionNo = $adms[$i];
                        $mark->Name = $fnames[$i];
                        //$mark->Lname = $lnames[$i];
                        $mark->marks = $marks[$i];

                        if ($req->entergrade[$i] === null) {
                            $mark->Grade = 'Not Assigned';
                       } else {
                            $mark->Grade = $req->entergrade[$i];
                       }
        
                       if ($req->enterremarks[$i] === null) {
                            $mark->Remarks = 'Not Assigned';
                       } else {
                            $mark->Remarks = $req->enterremarks[$i];
                       }

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
        //$lnames = array_filter($req->viewlname);
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
                //return ['data' => $req->all()];
                for ($i=0; $i < count($ids); $i++) { 
                    $mark = cbcmarks::find($pkeys[$i]);
                    $mark->marks = $marks[$i];
                    $mark->maxscore = $maxscore[$i];

                   if ($req->viewgrades[$i] === null) {
                        $mark->Grade = 'Not Assigned';
                   } else {
                        $mark->Grade = $req->viewgrades[$i];
                   }
    
                   if ($req->viewremarks[$i] === null) {
                        $mark->Remarks = 'Not Assigned';
                   } else {
                        $mark->Remarks = $req->viewremarks[$i];
                   }
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
    public function fetchMarks($exam,$cid,$sid) {
        $marks = cbcmarks::where('classid',$cid)
                        ->where('examid',$exam)
                        ->where('subject',$sid)
                        ->get();
        $outof = cbcmarks::select('maxscore')
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
        $grades = [];
        $remarks = [];
        foreach ($marks as $mark) {
            array_push($student,$mark->AdmissionNo);
            array_push($score,$mark->marks);
            array_push($ids,$mark->id);

            if ($mark->Grade === null) {
                array_push($grades, 'N/A');
            } else {
                array_push($grades, $mark->Grade);
            }

            if ($mark->Remarks === null) {
                array_push($remarks, 'N/A');
            } else {
                array_push($remarks, $mark->Remarks);
            }
            
        }

        $admsmarks = array_combine($student,$score);
        $pids = array_combine($student,$ids);
        $admgrades = array_combine($student,$grades);
        $admremarks = array_combine($student,$remarks);
        return response()->json([
            'marks' => $marks,
            'subject' => $sid,
            'pids' => $pids,
            'score' => $score,
            'students' => $students,
            'student' => implode(',',$student),
            'student2' => $student,
            'admsmarks' => $admsmarks,
            'admremarks' => $admremarks,
            'admgrades' => $admgrades,
            'outof' => $outof,
            'class' => $class[0]['class'].' '.$class[0]['stream']
        ]);
    }

    //Fetch Marks for viewing
    public function viewMarks(Request $req) {
        $admupis = [];
        $admmarks = [];
        $admsubs = [];
        $admmaxscores = [];
        $admgrades = [];
        $admremarks = [];

        $students = Student::where('sid',$req->sid)
                            ->where('current_classid',$req->stream)
                            ->get();
                            
        $marks = cbcmarks::where('sid',$req->sid)
                        ->where('classid',$req->stream)
                        ->where('examid',$req->subexamthread)
                        ->get();

        foreach ($students as $key => $student) {
            if ($student->AdmissionNo === NULL) {
                array_push($admupis,$student->UPI);
            } else {
                array_push($admupis,$student->AdmissionNo);
            }   
        }

        foreach ($admupis as $key) {
            $admmarks[$key] = [];
            $admsubs[$key] = [];
            $admgrades[$key] = [];
            $admremarks[$key] = [];
            $admmaxscores[$key] = [];
        }

        foreach ($admmarks as $key => $admmark) {
            foreach ($marks as $mark) {
                if ($key == $mark->AdmissionNo) {
                    array_push($admmarks[$key],$mark->marks);
                    array_push($admsubs[$key],$mark->subject);
                    array_push($admgrades[$key],$mark->Grade);
                    array_push($admremarks[$key],$mark->Remarks);
                    array_push($admmaxscores[$key],$mark->maxscore);
                }
            }
        }

        return response()->json([
            'students' => $students,
            'marks' => $marks,
            'admupis' => $admupis,
            'admgrades' => $admgrades,
            'admsubs' => $admsubs,
            'admmarks' => $admmarks,
            'admremarks' => $admremarks,
            'admmaxscores' => $admmaxscores
        ]);
    } 
}
