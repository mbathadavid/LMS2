<?php

namespace App\Http\Controllers;
use Excel;
use DB;
use App\Exports\StudentExport;
use App\Models\Subject;
use App\Models\classes;
use App\Models\Student;
use App\Models\ResultThread;
use App\Models\FinalGrade;
use App\Models\overallGradeSystem;
use App\Models\Grade;
use App\Models\subjectmeans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinalGradeController extends Controller
{
    //Insert Final Grade for Subject In Exam Thread 
   public function insertResults(Request $req){
     $records = FinalGrade::where('tid',$req->examthread)
                         ->where('sid',$req->sid)
                         ->where('subid',$req->subid)
                         ->where('classid',$req->cid)
                         ->get();

          
        if (count($records) >= 1) {
          $records = FinalGrade::where('tid',$req->examthread)
                         ->where('sid',$req->sid)
                         ->where('subid',$req->subid)
                         ->where('classid',$req->cid)
                         ->delete();   
        }
        //print_r($req->all());
          $validator = Validator::make($req->all(),[
               'examthread' => 'required'
          ],
          [
               'examthread.required' => 'You must select an Exam thread'
          ]);

          if ($validator->fails()) {
               return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag()
               ]);
          } else {
               //return response()->json(['data' => $req->all()]);
               $adms = $req->viewadmissionnumber;
               $mark = $req->finalscore;
               $missingadms = [];

               for ($i=0; $i < count($adms); $i++) { 
                    if ($mark[$i] == '') {
                         array_push($missingadms,$adms[$i]);
                    }
               }

                  $admnos = array_filter($req->viewadmissionnumber);
                  $marks = array_filter($req->finalscore);
                  $fnames = $req->viewfirstname;
                  $lnames = $req->viewlname;
                  $availablescores = $req->availableexams;
                  $scores = $req->scores;
                  $grades = $req->grades;
                  $points = $req->points;
                  $remarks = $req->remarks;
                  $examstocompute = explode(',',$req->examinations);
                  $markscount = count($marks);
                  $pointscount = count($points);
                  $marksum = array_sum($marks);
                  $pointsum = array_sum($points);
                  $marksavg = $marksum/$markscount;
                  $pointavg = $pointsum/$markscount;
                  $classes = array_values(array_unique($req->currentclass));



               if (count($admnos) != count($marks)) {
                    return response()->json([
                         'status' => 401,
                         'messages' => 'System detected that marks for the following students missing '.'<b>'.implode(',',$missingadms).'</b>'.' students missing. Please eliminate 
                          them if they did not sit for this subject. Including them can adversely lower the mean score'
                    ]);
               } else {
                    for ($i=0; $i < count($admnos); $i++) { 
                            $finalgrade = new FinalGrade;
                            $finalgrade->sid = $req->sid;  
                            $finalgrade->tid = $req->examthread;
                            $finalgrade->AdmissionNo = $admnos[$i];
                            $finalgrade->Fname = $fnames[$i];
                            $finalgrade->Lname = $lnames[$i];
                            $finalgrade->subid = $req->subid;
                            $finalgrade->classid = $req->cid;
                            $finalgrade->availablescores = $req->examinations;
                            //$finalgrade->availablescores = $availablescores[$i];examinations

                            $avaexams = [];
                            $finalarr = [];
                            if (count($examstocompute) == count(explode(',',$availablescores[$i]))) {
                              $finalgrade->scores = $scores[$i];
                              } else {
                              for ($k=0; $k < count($examstocompute); $k++) { 
                                   array_push($avaexams,rand(0,100));     
                              }
                              $comarr  = array_combine($examstocompute,$avaexams);

                              foreach ($comarr as $key => $value) {
                               if (in_array($key,explode(',',$availablescores[$i]))) {
                                   for ($y=0; $y < count(explode(',',$availablescores[$i])); $y++) { 
                                        $comarr[$key] = $scores[$i];   
                                        }
                                   } 
                                   else {
                                        $comarr[$key] = '_'; 
                                   }
                              }

                              $finalgrade->scores = implode(',',$comarr);    
                              }

                            $finalgrade->score = $marks[$i];
                            $finalgrade->points = $points[$i];
                            $finalgrade->grade = $grades[$i];

                            $lastscore = FinalGrade::where('tid',($req->tid) - 1)
                                                ->where('sid',$req->sid)
                                                ->where('AdmissionNo',$admnos[$i])
                                                ->where('classid',$req->cid)
                                                ->where('subid',$req->subid)
                                                ->get();

                            if (count($lastscore) > 0) {
                                   $dev = $marks[$i] - $lastscore[0]['score'];
                                   $finalgrade->Prev_Score = $lastscore[0]['score']; 
                                   if ($dev < 0) {
                                        $finalgrade->DEV = $dev;
                                   } else {
                                        $finalgrade->DEV = '+'.$dev;
                                   }
                              } else {
                                   $finalgrade->DEV = "N/A";
                                   $finalgrade->Prev_Score = "N/A";
                              }

                            $finalgrade->Remarks = $remarks[$i];
                            $finalgrade->save();
                    }

                    //Work on subject
                    $records = subjectmeans::where('tid',$req->examthread)
                                            ->where('sid',$req->sid)
                                            ->where('subid',$req->subid)
                                            ->where('classid',$req->cid)
                                            ->get();

                    if (count($records) >= 1) {
                         $records = subjectmeans::where('tid',$req->examthread)
                                            ->where('sid',$req->sid)
                                            ->where('subid',$req->subid)
                                            ->where('classid',$req->cid)
                                            ->delete();
                    }

                    $subjectmean = new subjectmeans;
                    $subjectmean->sid = $req->sid;
                    $subjectmean->tid = $req->examthread;
                    $subjectmean->subid = $req->subid;
                    $subjectmean->classid = $req->cid;
                    $subjectmean->class = $classes[0];
                    $subjectmean->mean_marks = round($marksavg,3);
                    $subjectmean->mean_points = round($pointavg,3);
                    $subjectmean->student_count = count($admnos);
                    $subjectmean->save();

                    $data = FinalGrade::where('tid',$req->examthread)
                                        ->where('subid',$req->subid)
                                        ->where('classid',$req->cid)
                                        ->orderBy('score','DESC')
                                        ->get();

                    $subject = Subject::select('subject')
                                        ->where('id',$req->subid)
                                        ->first(); 

                    $clas = classes::where('id',$req->cid)
                                    ->where('sid',$req->sid)
                                    ->get();

                    $thread = ResultThread::where('id',$req->examthread)
                                        ->where('sid',$req->sid)
                                        ->get();                    

                    return response()->json([
                         'filename' => $clas[0]['class'].'_'.$clas[0]['stream'].'_'.$thread[0]['thread'].'_'.$thread[0]['year'].'_'.$thread[0]['term'].'_'.$subject['subject'],
                         'status' => 200,
                         'messages' => 'Marks Successfully added to Results Thread.',
                         'data' => $data,
                         'examinations' => $req->examinations,
                         'marksavg' => round($marksavg,3),
                         'pointsavg' => round($pointavg,3),
                         'gradingavg' => round($marksavg),
                         'classes' => $classes
                    ]);

               }
               
          }
     
   }
   //Return all the marks for final computation
   public function fetchGrades(Request $req){
        $validator = Validator::make($req->all(),[
          'class' => 'required',
          'thread' => 'required'
        ],
          [
               'class.required' => 'You must select a class',
               'thread.required' => 'You must select exam thread'
          ]);

          if ($validator->fails()) {
               return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag()
               ]);
          } else {
               $tid = explode(',',$req->thread)[0];
               //$cid = explode(',',$req->class)[0];
                $cid = $req->class;
                $classes = classes::where('class',$cid)
                                   ->where('sid',$req->sid)
                                   ->get();

                $classids = array();
                foreach ($classes as $class) {
                    array_push($classids,$class->id);
                }                   

               $records = FinalGrade::where('tid',$tid)
                                   ->whereIn('classid',$classids)
                                   ->get();

               $students = Student::whereIn('current_classid',$classids)
                                   ->where('sid',$req->sid)
                                   ->get(); 
                                   
               // $subjects = Subject::all();
               $subjects = Subject::where('sid',$req->sid)
                                   ->where('educationsystem','8-4-4')
                                   ->get();

               $subids = [];
               $subnames = [];
               $stupersub = [];

               foreach ($subjects as $subject) {
                    array_push($subids,$subject->id);
                    array_push($subnames,$subject->subject);

                    $studentscount = FinalGrade::where('tid',$tid)
                                        ->whereIn('classid',$classids)
                                        ->where('subid',$subject->id)
                                        ->where('sid',$req->sid)
                                        ->get();

                    array_push($stupersub,count($studentscount));
               }

               $finalsubstucount = array_combine($subnames,$stupersub);
               $grades = overallGradeSystem::where('class',$cid)
                                             ->where('sid',$req->sid)
                                             ->get();

               $subidnames = array_combine($subids,$subnames);


               return response()->json([
                    'status' => 200,
                    'subids' => $subids,
                    'subnames' => $subnames,
                    'subidnames' => $subidnames,
                    'students' => $students,
                    'records' => $records,
                    'subjects' => $subjects,
                    'substudents' => $finalsubstucount,
                    'classthread' => $req->class.' '.explode(',',$req->thread)[1],
                    'grades' => $grades
               ]);
          }
          
   }
   //Function to fetch Subject Grades
   public function fetchSubGrades($sid,$cid,$subid){
     $grades = Grade::where('subject',$subid)
                    ->where('sid',$sid)
                    ->where('class',$cid)
                    ->get();
     
     $subject = Subject::where('subject',$subid)
                    // ->where('id',$subid)
                    ->where('educationsystem','8-4-4')
                    ->where('sid',$sid)
                    ->first();   
                    
     $clas = classes::select('class')
                    ->where('id',$cid)
                    ->where('sid',$sid)
                    ->first();

     $stream = classes::select('stream')
                    ->where('id',$cid)
                    ->where('sid',$sid)
                    ->first();
                         
     return response()->json([
          'grades' => $grades,
          'class' => $cid,
          'subject' => $subject['subject'],
          //'class' => $clas['class'].' '.$stream['stream'],
     ]);               
   }
}
