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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinalGradeController extends Controller
{
    //Insert Final Grade for Subject In Exam Thread 
   public function insertResults(Request $req){
     $records = FinalGrade::where('tid',$req->examthread)
                         ->where('subid',$req->sid)
                         ->where('classid',$req->cid)
                         ->get();

          
        if (count($records) >= 1) {
          $records = FinalGrade::where('tid',$req->examthread)
                         ->where('subid',$req->sid)
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


               if (count($admnos) != count($marks)) {
                    return response()->json([
                         'status' => 401,
                         'messages' => 'System detected that marks for the following students missing '.'<b>'.implode(',',$missingadms).'</b>'.' students missing. Please eliminate 
                          them if they did not sit for this subject. Including them can adversely lower the mean score'
                    ]);
               } else {
                    for ($i=0; $i < count($admnos); $i++) { 
                         $finalgrade = new FinalGrade;
                            $finalgrade->tid = $req->examthread;
                            $finalgrade->AdmissionNo = $admnos[$i];
                            $finalgrade->Fname = $fnames[$i];
                            $finalgrade->Lname = $lnames[$i];
                            $finalgrade->subid = $req->sid;
                            $finalgrade->classid = $req->cid;
                            $finalgrade->availablescores = $availablescores[$i];
                            
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
                            $finalgrade->Remarks = $remarks[$i];
                            $finalgrade->save();
                    }

                    $data = FinalGrade::where('tid',$req->examthread)
                                        ->where('subid',$req->sid)
                                        ->where('classid',$req->cid)
                                        ->orderBy('score','DESC')
                                        ->get();

                    $subject = Subject::select('subject')
                                        ->where('id',$req->sid)
                                        ->first();   
                                        
                    $clas = classes::select('class')
                                        ->where('id',$req->cid)
                                        ->first();

                    $stream = classes::select('stream')
                                        ->where('id',$req->cid)
                                        ->first(); 
                                        
                    $thread = ResultThread::select('name')
                                        ->where('id',$req->examthread)
                                        ->first(); 

                    $term = ResultThread::select('term')
                                        ->where('id',$req->examthread)
                                        ->first();
                                        
                    $year = ResultThread::select('year')
                                        ->where('id',$req->examthread)
                                        ->first();                    

                    return response()->json([
                         'filename' => $clas['class'].'_'.$stream['stream'].'_'.$thread['thread'].'_'.$year['year'].'_'.$term['term'].'_'.$subject['subject'],
                         'status' => 200,
                         'messages' => 'Marks Successfully added to Results Thread.',
                         'data' => $data,
                         'examinations' => $req->examinations
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
               $cid = explode(',',$req->class)[0];

               $records = FinalGrade::where('tid',$tid)
                                   ->where('classid',$cid)
                                   ->get();

               $students = Student::where('current_classid',$cid)
                                   ->get(); 
                                   
               $subjects = Subject::all();

               $subids = [];
               $subnames = [];
               $stupersub = [];

               foreach ($subjects as $subject) {
                    array_push($subids,$subject->id);
                    array_push($subnames,$subject->subject);

                    $studentscount = FinalGrade::where('tid',$tid)
                                        ->where('classid',$cid)
                                        ->where('subid',$subject->id)
                                        ->get();

                    array_push($stupersub,count($studentscount));
               }

               $finalsubstucount = array_combine($subnames,$stupersub);


               return response()->json([
                    'students' => $students,
                    'records' => $records,
                    'subjects' => $subjects,
                    'substudents' => $finalsubstucount,
                    'classthread' => explode(',',$req->class)[1].' '.explode(',',$req->class)[2].' '.explode(',',$req->thread)[1],
                    'grades' => overallGradeSystem::where('classid',$cid)->first()
               ]);
          }
          
   }
   //Function to fetch Subject Grades
   public function fetchSubGrades($cid,$subid){
     $grades = Grade::where('subid',$subid)
                    ->where('classid',$cid)
                    ->get();
     
     $subject = Subject::select('subject')
                    ->where('id',$subid)
                    ->first();   
                    
     $clas = classes::select('class')
                    ->where('id',$cid)
                    ->first();

     $stream = classes::select('stream')
                    ->where('id',$cid)
                    ->first();
                         
     return response()->json([
          'grades' => $grades,
          'subject' => $subject['subject'],
          'class' => $clas['class'].' '.$stream['stream'],
     ]);               
   }
}
