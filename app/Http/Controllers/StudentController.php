<?php

namespace App\Http\Controllers;
use Excel;
use DB;
use App\Exports\StudentExport;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\classes;
use App\Models\School_Data;
use App\Models\Subject;
use App\Models\Feestructure;
use App\Models\Book;
use App\Models\feepayment;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    //Register student
    public function registerStudent(Request $req){
        $validator = Validator::make($req->all(),[
            'upi' => 'required|unique:students',
            'firstname' => 'required',
            'lastname' => 'required',
            'gender' => 'required',
            'educationsystem' => 'required',
            'disabled' => 'required',
            'current_class' => 'required',
            'county' => 'required',
            'subcounty' => 'required',
            'file' => 'image'
        ],[
            'upi.required' => 'You Must Enter the UPI Number',
            'upi.unique' => 'Sorry! This UPI Number has already registered another student',
            'firstname.required' => 'You must state the first name of the student',
            'lastname.required' => 'You must specify the last name of the student',
            'gender.required' => 'You must speficy the gender of the student',
            'educationsystem.required' => 'You need to specify which education system the student is to be enrolled in',
            'disabled.required' => 'You must indicate whether the student is disabled or not',
            'current_class.required' => 'You must select a class to enroll the student in',
            'county.required' => 'You must specify the county',
            'subcounty.required' => 'You must specify the student subcounty',
            'file.image' => 'You can only upload an image as a profile',
        ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag() 
                ]);
            } else {
                $checkstudent = Student::where('AdmissionNo',$req->admissionNo)
                                        ->where('sid',$req->sid)
                                        ->get();
                if (count($checkstudent) > 0) {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'Sorry! A student with similar Admission Number has already been registered. Admission Number should only be entitled to one student.' 
                    ]);
                } else {
                $student = new Student;
                $student->AdmissionNo = $req->admissionNo;

                $school = School_Data::find($req->sid); 
                $schoolname = $school['name'];
                $words = explode(' ',$schoolname);
                $word1 = $words[0];
                $word2 = $words[1];
                $student->StudentId = $req->admissionNo.'@'.$word1.$word2;

                $student->sid = $req->sid; 
                $student->Fname = $req->firstname;
                $student->Sname = $req->secondname;
                $student->Lname = $req->lastname;
                $student->UPI = $req->upi;
                $student->EduSystem = $req->educationsystem;

                $classinfo = explode(',',$req->current_class);

                $student->current_class = $classinfo[1];
                $student->current_classid = $classinfo[0];

                //$ssytem = classes::find($classinfo[0]);
                //$student->schoolsystem = $ssytem['educationsystem'];
                $student->schoolsystem = $req->educationsystem;
                

                $student->gender = $req->gender;
                $student->dob = $req->dob;
                $student->county = $req->county;
                $student->subcounty = $req->subcounty;
                $student->disabled = $req->disabled;
                $student->disability = $req->disabilitytype;
                $student->d_description = $req->disabilitydescription;
                $student->password = Hash::make('password123');

                if ($req->hasFile('file')) {
                    $file = $req->file('file');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'pro'.'.'.$extension;
                    $file->move('images/', $filename);
                    $student->profile = $filename;
                }
                $student->save();
                return response()->json([
                    'status' => 200,
                    'messages' => 'New Student Registered Successfully'
                ]);
            }
        }
    }
    //fetch students
    public function fetchStudents($sid){
        $students = Student::where('deleted',0)
                            ->where('sid',$sid)
                            ->OrderByDesc('id')
                            ->get();
        return response()->json([
            'students' => $students
        ]);
    }

    //Fetch Student for pathway
    public function getStudentpathway($sid){
        $student = Student::find($sid);
        $class = classes::find($student['current_classid']);

        return response()->json([
            'student' => $student,
            'class' => $class,
        ]);
    }

    //Assign Pathway
    public function assignPathway(Request $req){
        //return ['data' => $req->all()];
        $validator = Validator::make($req->all(),[
            'path' => 'required'
        ],[
            'path.required' => 'You must Select a pathway to Assign to assign to the Student'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag() 
            ]);
        } else {
            $student = Student::find($req->studentid2);
            $student->pathway = $req->path;
            $student->save();

            return response()->json([
                'status' => 200,
                'messages' => "Pathway Assigned Successfully for ".$student['Fname'].' '.$student['Lname']
            ]);
        }
    }

    public function filterStudents($filter,$sid){
        // $filtervalue = $req->filtervalue;
        if ($filter === 'ALL') {
            $students = Student::where('sid',$sid)
                                ->where('deleted',0)
                                ->OrderByDesc('id')
                                ->get();
            return response()->json([
                'students' => $students
            ]);
        } else {
            $students = Student::where('current_classid', $filter)
                                ->where('sid',$sid)
                                ->where('deleted',0)
                                ->OrderByDesc('id')
                                ->get();
            return response()->json([
                'students' => $students
            ]);
        }  
    }
    //Students Excel
    public function excelStudents(){
        $students = Student::all();
        return view('adminFiles.excelstudent',['students' => $students]);
    }
    //produce students excel sheet
    public function produceStudentsExcel(){
        return Excel::download(new StudentExport,'students.xlsx');
    }
    //Function to delete student(s)
    public function deleteStudents($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $student = Student::find($idarray[$i]);
            $student->deleted = '1';
            $student->save(); 
        }
    return response()->json([
        'status' => 200,
        'messages' => 'Student deleted Successfullly'
    ]);
    }
//Function to clear student
    public function clearStudents($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray); $i++) { 
            $student = Student::find($idarray[$i]);
            $student->current_class = 'completed';
            $student->save();
        }

        return response()->json([
            'status' => 200,
            'messages' => 'Student cleared Successfullly'
        ]);
    }

    //Function to promote students
    public function promoteStudents($ids,$nextclass){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $student = Student::find($idarray[$i]);
            $classinfo = explode(',',$nextclass);
            $student->current_class = $classinfo[1];
            $student->current_classid = $classinfo[0];
            $student->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => count($idarray).' Students Promoted to '.$nextclass.' Successfully'
        ]);  
    }
    //Function to deactivate account
    public function deactivateStudents($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $student = Student::find($idarray[$i]);
            $student->Active = 'No';
            $student->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => 'Student account activated Successfullly'
        ]); 
    }
    //Function to activate accoutnt
    public function activateStudents($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $student = Student::find($idarray[$i]);
            $student->Active = 'Yes';
            $student->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => 'Student Account activated Successfullly'
        ]); 
    } 
    //Function to fetch one student
    public function getStudent($id){
        $student = Student::find($id);
        $books = Book::where('borrowed_by',$student['AdmissionNo'])
                      ->orWhere('borrowed_by',$student['UPI'])
                      ->get();

        return response()->json([
            'student' => $student,
            'books' => $books
        ]);
    }

    //Fetch Student for Subject Enrollment
    public function getStudentforsubEnrollemt($ids){
        $student = Student::find($ids);
        $class = classes::where('id', $student['current_classid'])
                            ->get();

        $educationsystem = $class[0]['educationsystem'];
        $class = $class[0]['class'];
        // $sid = $class[0]['sid'];
        $sid = session()->get('schooldetails.id');

        
        if ($educationsystem == "8-4-4") {
            $subjects = Subject::where('educationsystem','8-4-4')
                                ->where('sid',$sid)
                                ->get();

            return response()->json([
                'availstatus' => 'Available',
                'subjects' => $subjects,
                ]);

        } else if($class == "GRADE TEN" || $class == "GRADE ELEVEN" || $class == "GRADE TWELVE") {
            $pathway = $student['pathway']; 

            if ($pathway == null) {
                return response()->json([
                    'availstatus' => 'Not Available',
                    'missingpathway' => "Please Assign a pathway to the student so as to be able to enroll them in Learning Areas",
                    ]); 
            } else {
                $subjects = Subject::where('educationsystem','CBC')
                                    ->where('sid',$sid)
                                    ->where('pathway',$pathway)
                                    ->get();

                return response()->json([
                    'availstatus' => 'Available',
                    'subjects' => $subjects,
                    ]);
            }
            
        } else{
            $subjects = Subject::where('educationsystem','CBC')
                                ->where('sid',$sid)
                                ->where('level','Junior Secondary')
                                ->get();

            return response()->json([
                'availstatus' => 'Available',
                'subjects' => $subjects,
                ]);
        }

        
    }

    //Function to Enroll Subjects
    public function enrollSubjects(Request $req) {
        //return ["data" => $req->all()];
        $subjectids = [];
        $subnames = [];

        for ($i=0; $i < count($req->subjectid); $i++) { 
            array_push($subjectids,explode(',',$req->subjectid[$i])[0]);
            array_push($subnames,explode(',',$req->subjectid[$i])[1]);
        }

        $student = Student::find($req->studentid);
        $student->suborlearningpaths = implode(',',$subnames);
        $student->subids = implode(',',$subjectids); 
        $student->save();

        return response()->json([
            'status' => 200,
            'messages' => $student['Fname'].' '.$student['Lname']. ' enrolled for '.implode(',',$subnames).' Successfully'
        ]);

    }

    //Return Fee Payment View
    public function feeInformation($sid,$stuid){
        $student = Student::find($stuid);
        $feepayments = feepayment::where('AdmorUPI',$student['AdmissionNo'])
                                  ->where('sid',$sid)
                                  ->orWhere('AdmorUPI',$student['UPI'])
                                  ->OrderByDesc('created_at')
                                  ->get();

        $data = [
            //'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'adminInfo' => Staff::find(session('LoggedInUser.id')),
            'schoolinfo' => School_Data::find($sid),
            "student" => $student,
            "feepayments" => $feepayments
        ];

        return view('adminFiles.feeinformation',$data);
    }


    //Function to update student
    public function editStudent(Request $req){
        $validator = Validator::make($req->all(),[
            'seditadmno' => 'required',
            'sediteducation' => 'required',
            'seditupi' => 'required',
            'seditfname' => 'required',
            'seditlname' => 'required',
            'seditgender' => 'required',
            'seditclass' => 'required',
            'seditcounty' => 'required',
            'seditscounty' => 'required',
            'seditprofile' => 'image'
        ],
    [
       'seditprofile.image' => 'File selected for profile photo must be an image',
       'seditlname.required' => 'Last name is required',
       'sediteducation.required' => 'Education System',
       'seditupi.required' => 'UPI is required',
       'seditfname.required' => 'First name is required',
       'seditgender.required' => 'Gender field is required',
       'seditcounty.required' => 'The county field is required',
       'seditscounty.required' => 'Sub County field is required' 
    ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag() 
                ]);
            } else {
                // $checkstudent = Student::where('AdmissionNo',$req->seditadmno)
                //                         ->where('sid',$req->sid)
                //                         ->get();

                // if (count($checkstudent) > 0) {
                //     return response()->json([
                //             'status' => 401,
                //             'messages' => 'Sorry! A student with similar Admission Number has already been registered. Admission Number should only be entitled to one student.' 
                //             ]);
                // } else {
                 $student = Student::find($req->seditid);
                 $scode = $student['StudentId'];
                 $scode2 = explode("@",$scode)[1];

                $student->AdmissionNo = $req->seditadmno; 
                $student->StudentId = $req->seditadmno."@".$scode2;
                $student->Fname = $req->seditfname;
                $student->Sname = $req->seditsname;
                $student->Lname = $req->seditlname;
                $student->UPI = $req->seditupi;
                $student->schoolsystem = $req->sediteducation;

                $classinfo = explode(',',$req->seditclass);

                $student->current_class = $classinfo[1];
                $student->current_classid = $classinfo[0];
                $student->gender = $req->seditgender;
                $student->dob = $req->seditdob;
                $student->county = $req->seditcounty;
                $student->subcounty = $req->seditscounty;
                $student->disabled = $req->seditdisability;
                if ($req->seditdisability == 'Yes') {
                    $student->disability = $req->editdisabilitytype;
                }
                if ($req->editdisabilitytype == 'Other') {
                    $student->d_description = $req->seditdisabilitydescription;  
                }
                
                if ($req->hasFile('seditprofile')) {
                    $file = $req->file('seditprofile');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'pro'.'.'.$extension;
                    $file->move('images/', $filename);
                    $student->profile = $filename;
                } 
                $student->save();
                return response()->json([
                    'status' => 200,
                    'messages' => 'Student Details updated Successfully'
                ]);
            
           // } 
        }
    }

    //Search Student For Fee Information
    public function searchStudent(Request $req) {
        $validator = Validator::make($req->all(),[
            'searchnumber' => 'required',
            ],
            [
            'searchnumber.required' => 'You must enter Admission or UPI number',
            ]); 

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag() 
            ]);
        } else {
            $student = Student::where('AdmissionNo',$req->searchnumber)
                                ->orWhere('UPI',$req->searchnumber)
                                ->get();

            if (count($student) == 0) {
                return response()->json([
                    'status' => 401,
                    'messages' => 'There is no student with such Admission or UPI number registered'
                ]);
            } else {
            $class = classes::find($student[0]["current_classid"]);
            
            if ($class['current_term'] == "Not Set") {
                return response()->json([
                    'status' => 401,
                    'messages' => 'The Current Term for the Student has not been set. Please Set it so as to be able to Collect Fee for the student'
                ]);
            } else {
            $feestructrure = Feestructure::where('sid',$req->sid)
                                        ->where('Term',$class['current_term'])
                                        ->where('classes',$class['id'])
                                        ->get();

            if (count($feestructrure) == 0) {
                return response()->json([
                    'status' => 401,
                    'messages' => 'The Fee Structure for the students Class has not been set. Make sure you create it so as to be able to collect fees'
                ]);
            } else {
            return response()->json([
                'status' => 200,
                'student' => $student,
                'class' => $class,
                'feestructure' => $feestructrure,
                'upiadm' => $req->searchnumber
            ]);
            }
        }
        } 
        }
    }

    //Update Fee Structure
    public function updateFeeStructure(Request $req) {
        $validator = Validator::make($req->all(),[
            'pendingbalancefield' => 'required',
            'ctermbalancefield' => 'required'
            ],
            [
            'pendingbalancefield.required' => 'You must enter the Pending Fee Balance',
            'ctermbalancefield.required' => 'You must enter Current Term Balance'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag() 
                ]);
            } else {
                $student = Student::find($req->stuid);
                $student->pendingbalances = $req->pendingbalancefield;
                $student->feebalance = $req->ctermbalancefield;
                $student->ovbalance = $req->totalfeedebtfield;
                $student->save();

                return response()->json([
                    'status' => 200,
                    'messages' => 'Fee information for '.$student['Fname'].' '.$student['Lname'].' Updated Successfully',
                    'pendingbalance' => $req->pendingbalancefield,
                    'feebalance' => $req->ctermbalancefield,
                    'ovbalance' => $req->totalfeedebtfield
                ]);
            } 
    }

    //Pay Fees
    public function payFees(Request $req) {
        date_default_timezone_set("Africa/Nairobi");
        $validator = Validator::make($req->all(),[
                'paymentmethod' => 'required',
                //'payedfor' => 'required',
                'amountreceived' => 'required'
            ],
            [
                'paymentmethod.required' => 'You must indicate the method of payment',
               // 'payedfor.required' => 'You must indicate what the money was paid for',
                'amountreceived.required' => 'You must indicate the amount received'
            ]);
            
            if ($validator->fails()) {
                return response()->json([
                    'status' => 400,
                    'messages' => $validator->getMessageBag() 
                ]);
            } else if ($req->paymentmethod !== "Cash" && $req->transcationcode == "") {
                return response()->json([
                    'status' => 401,
                    'messages' => 'You must indicate the Cheque number of MPESA Transaction Code' 
                ]);  
            } else {
                //return ["data" => $req->all()];
                $student = Student::find($req->stuid2);
                $amountpayed = $req->amountreceived;
                $payedfor = $req->payedfor;
                $paymentmethod = $req->paymentmethod;
                $pendingarrears = $req->pendingarrears2;
                $pendingtermbalance = $req->pendingtermbalance;
                $totalfeedebt = $req->totalfeedebt;
                $transcationcode = $req->transcationcode;

                $date = date("Y/m/d h:i:sa");

                // $newpendingbalances = 0;
                // $newfeebalance = 0;
                // $newovbalance = 0;

               if ($amountpayed == $totalfeedebt) {
                    $newpendingbalances = 0;
                    $newfeebalance = 0;
                    $newovbalance = 0;

                    $student->pendingbalances = $newpendingbalances;
                    $student->feebalance = $newfeebalance;
                    $student->ovbalance = $newovbalance;
                    $student->save();

                    $feepayment = new feepayment;
                    $feepayment->sid = $req->sid;
                    $feepayment->AdmorUPI = $req->studentadmupi;
                    $feepayment->amountpayed = $amountpayed;
                    $feepayment->academicyear = $req->studentacayear;
                    $feepayment->term = $req->termpayed;
                    $feepayment->amount = $amountpayed;
                    $feepayment->paymentmethod = $req->paymentmethod;
                    
                    if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                        $feepayment->Cheque_number = $req->transcationcode;
                    } else if ($req->paymentmethod === "MPESA") {
                        $feepayment->MPESA_Code	 = $req->transcationcode;
                    }

                    $collected = Staff::find(session()->get('LoggedInUser.id'));

                    $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                    $feepayment->save();


                    return response()->json([
                        "status" => 200,
                        "messages" => "Fee payment completed successfully",
                        "student" => $student,
                        "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                        "amount" => $amountpayed,
                        "term" => $req->termpayed,
                        "initialpendingarrears" => $pendingarrears,
                        "initialpendingtermbalance" => $pendingtermbalance,
                        "initialtotalfeedebt" => $totalfeedebt,
                        "pendingbalances" => $newpendingbalances,
                        "feebalance" => $newfeebalance,
                        "ovbalance" => $newovbalance,
                        "date" => $date
                    ]);
               } else if ($amountpayed > $totalfeedebt){
                    $newpendingbalances = 0;
                    $newfeebalance = 0;
                    $newovbalance = $totalfeedebt - $amountpayed; 

                    $student->pendingbalances = $newpendingbalances;
                    $student->feebalance = $newfeebalance;
                    $student->ovbalance = $newovbalance;
                    $student->save();

                    $feepayment = new feepayment;
                    $feepayment->sid = $req->sid;
                    $feepayment->AdmorUPI = $req->studentadmupi;
                    $feepayment->amountpayed = $amountpayed;
                    $feepayment->academicyear = $req->studentacayear;
                    $feepayment->term = $req->termpayed;
                    $feepayment->amount = $amountpayed;
                    $feepayment->paymentmethod = $req->paymentmethod;
                    
                    if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                        $feepayment->Cheque_number = $req->transcationcode;
                    } else if ($req->paymentmethod === "MPESA") {
                        $feepayment->MPESA_Code	 = $req->transcationcode;
                    }

                    $collected = Staff::find(session()->get('LoggedInUser.id'));

                    $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                    $feepayment->save();

                    return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                     ]);
               } else if ($pendingarrears == 0 && $pendingtermbalance == $amountpayed) {
                    $newpendingbalances = 0;
                    $newfeebalance = 0;
                    $newovbalance = $totalfeedebt - $amountpayed; 

                    $student->pendingbalances = $newpendingbalances;
                    $student->feebalance = $newfeebalance;
                    $student->ovbalance = $newovbalance;
                    $student->save();

                    $feepayment = new feepayment;
                    $feepayment->sid = $req->sid;
                    $feepayment->AdmorUPI = $req->studentadmupi;
                    $feepayment->amountpayed = $amountpayed;
                    $feepayment->academicyear = $req->studentacayear;
                    $feepayment->term = $req->termpayed;
                    $feepayment->amount = $amountpayed;
                    $feepayment->paymentmethod = $req->paymentmethod;
                    
                    if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                        $feepayment->Cheque_number = $req->transcationcode;
                    } else if ($req->paymentmethod === "MPESA") {
                        $feepayment->MPESA_Code	 = $req->transcationcode;
                    }

                    $collected = Staff::find(session()->get('LoggedInUser.id'));

                    $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                    $feepayment->save();

                    
                    return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                     ]);
               } else if ($pendingarrears == 0 && $amountpayed > $pendingtermbalance) {
                    $newpendingbalances = 0;
                    $newfeebalance = 0;
                    $newovbalance = $totalfeedebt - $amountpayed; 

                    $student->pendingbalances = $newpendingbalances;
                    $student->feebalance = $newfeebalance;
                    $student->ovbalance = $newovbalance;
                    $student->save();

                    $feepayment = new feepayment;
                    $feepayment->sid = $req->sid;
                    $feepayment->AdmorUPI = $req->studentadmupi;
                    $feepayment->amountpayed = $amountpayed;
                    $feepayment->academicyear = $req->studentacayear;
                    $feepayment->term = $req->termpayed;
                    $feepayment->amount = $amountpayed;
                    $feepayment->paymentmethod = $req->paymentmethod;
                    
                    if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                        $feepayment->Cheque_number = $req->transcationcode;
                    } else if ($req->paymentmethod === "MPESA") {
                        $feepayment->MPESA_Code	 = $req->transcationcode;
                    }

                    $collected = Staff::find(session()->get('LoggedInUser.id'));

                    $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                    $feepayment->save();

                    return response()->json([
                        "status" => 200,
                        "messages" => "Fee payment completed successfully",
                        "student" => $student,
                        "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                        "amount" => $amountpayed,
                        "term" => $req->termpayed,
                        "initialpendingarrears" => $pendingarrears,
                        "initialpendingtermbalance" => $pendingtermbalance,
                        "initialtotalfeedebt" => $totalfeedebt,
                        "pendingbalances" => $newpendingbalances,
                        "feebalance" => $newfeebalance,
                        "ovbalance" => $newovbalance,
                        "date" => $date
                     ]);
               } else if ($pendingarrears > 0 && $amountpayed == $pendingarrears) {
                    $newpendingbalances = 0;
                    $newfeebalance = $pendingtermbalance;
                    $newovbalance = $totalfeedebt - $amountpayed; 

                    $student->pendingbalances = $newpendingbalances;
                    $student->feebalance = $newfeebalance;
                    $student->ovbalance = $newovbalance;
                    $student->save();

                    $feepayment = new feepayment;
                    $feepayment->sid = $req->sid;
                    $feepayment->AdmorUPI = $req->studentadmupi;
                    $feepayment->amountpayed = $amountpayed;
                    $feepayment->academicyear = $req->studentacayear;
                    $feepayment->term = $req->termpayed;
                    $feepayment->amount = $amountpayed;
                    $feepayment->paymentmethod = $req->paymentmethod;
                    
                    if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                        $feepayment->Cheque_number = $req->transcationcode;
                    } else if ($req->paymentmethod === "MPESA") {
                        $feepayment->MPESA_Code	 = $req->transcationcode;
                    }

                    $collected = Staff::find(session()->get('LoggedInUser.id'));

                    $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                    $feepayment->save();


                    return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                     ]);
               } else if ($pendingarrears > 0 && $amountpayed > $pendingarrears) {
                    $newpendingbalances = 0;
                    $supplus = $amountpayed - $pendingarrears; 

                    if ($supplus == $pendingtermbalance) {
                        $newpendingbalances = 0;
                        $newfeebalance = 0;
                        $newovbalance = $totalfeedebt - $amountpayed;

                        $student->pendingbalances = $newpendingbalances;
                        $student->feebalance = $newfeebalance;
                        $student->ovbalance = $newovbalance;
                        $student->save();
    
                        $feepayment = new feepayment;
                        $feepayment->sid = $req->sid;
                        $feepayment->AdmorUPI = $req->studentadmupi;
                        $feepayment->amountpayed = $amountpayed;
                        $feepayment->academicyear = $req->studentacayear;
                        $feepayment->term = $req->termpayed;
                        $feepayment->amount = $amountpayed;
                        $feepayment->paymentmethod = $req->paymentmethod;
                        
                        if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                            $feepayment->Cheque_number = $req->transcationcode;
                        } else if ($req->paymentmethod === "MPESA") {
                            $feepayment->MPESA_Code	 = $req->transcationcode;
                        }
    
                        $collected = Staff::find(session()->get('LoggedInUser.id'));
    
                        $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                        $feepayment->save();    

                        return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                         ]);
                    } else if ($supplus < $pendingtermbalance) {
                        $newpendingbalances = 0;
                        $newfeebalance = $pendingtermbalance - $supplus;
                        $newovbalance = $totalfeedebt - $amountpayed;

                        $student->pendingbalances = $newpendingbalances;
                        $student->feebalance = $newfeebalance;
                        $student->ovbalance = $newovbalance;
                        $student->save();
    
                        $feepayment = new feepayment;
                        $feepayment->sid = $req->sid;
                        $feepayment->AdmorUPI = $req->studentadmupi;
                        $feepayment->amountpayed = $amountpayed;
                        $feepayment->academicyear = $req->studentacayear;
                        $feepayment->term = $req->termpayed;
                        $feepayment->amount = $amountpayed;
                        $feepayment->paymentmethod = $req->paymentmethod;
                        
                        if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                            $feepayment->Cheque_number = $req->transcationcode;
                        } else if ($req->paymentmethod === "MPESA") {
                            $feepayment->MPESA_Code	 = $req->transcationcode;
                        }
    
                        $collected = Staff::find(session()->get('LoggedInUser.id'));
    
                        $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                        $feepayment->save();    

                        return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                         ]);
                    } else if ($supplus > $pendingtermbalance) {
                        $newpendingbalances = 0;
                        $newfeebalance = 0;
                        $newovbalance = $totalfeedebt - $amountpayed;

                        $student->pendingbalances = $newpendingbalances;
                        $student->feebalance = $newfeebalance;
                        $student->ovbalance = $newovbalance;
                        $student->save();
    
                        $feepayment = new feepayment;
                        $feepayment->sid = $req->sid;
                        $feepayment->AdmorUPI = $req->studentadmupi;
                        $feepayment->amountpayed = $amountpayed;
                        $feepayment->academicyear = $req->studentacayear;
                        $feepayment->term = $req->termpayed;
                        $feepayment->amount = $amountpayed;
                        $feepayment->paymentmethod = $req->paymentmethod;
                        
                        if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                            $feepayment->Cheque_number = $req->transcationcode;
                        } else if ($req->paymentmethod === "MPESA") {
                            $feepayment->MPESA_Code	 = $req->transcationcode;
                        }
    
                        $collected = Staff::find(session()->get('LoggedInUser.id'));
    
                        $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                        $feepayment->save();    

                        return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                         ]);
                    }
                        
               } else if ($pendingarrears  > $amountpayed) {
                        $newpendingbalances = $pendingarrears - $amountpayed;
                        $newfeebalance = $pendingtermbalance;
                        $newovbalance = $totalfeedebt - $amountpayed;

                        $student->pendingbalances = $newpendingbalances;
                        $student->feebalance = $newfeebalance;
                        $student->ovbalance = $newovbalance;
                        $student->save();
    
                        $feepayment = new feepayment;
                        $feepayment->sid = $req->sid;
                        $feepayment->AdmorUPI = $req->studentadmupi;
                        $feepayment->amountpayed = $amountpayed;
                        $feepayment->academicyear = $req->studentacayear;
                        $feepayment->term = $req->termpayed;
                        $feepayment->amount = $amountpayed;
                        $feepayment->paymentmethod = $req->paymentmethod;
                        
                        if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                            $feepayment->Cheque_number = $req->transcationcode;
                        } else if ($req->paymentmethod === "MPESA") {
                            $feepayment->MPESA_Code	 = $req->transcationcode;
                        }
    
                        $collected = Staff::find(session()->get('LoggedInUser.id'));
    
                        $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                        $feepayment->save();    

                        return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                         ]);
               } else if ($pendingarrears == 0 && $pendingtermbalance > $amountpayed) {
                        $newpendingbalances = 0;
                        $newfeebalance = $pendingtermbalance - $amountpayed;
                        $newovbalance = $totalfeedebt - $amountpayed;

                        $student->pendingbalances = $newpendingbalances;
                        $student->feebalance = $newfeebalance;
                        $student->ovbalance = $newovbalance;
                        $student->save();
    
                        $feepayment = new feepayment;
                        $feepayment->sid = $req->sid;
                        $feepayment->AdmorUPI = $req->studentadmupi;
                        $feepayment->amountpayed = $amountpayed;
                        $feepayment->academicyear = $req->studentacayear;
                        $feepayment->term = $req->termpayed;
                        $feepayment->amount = $amountpayed;
                        $feepayment->paymentmethod = $req->paymentmethod;
                        
                        if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                            $feepayment->Cheque_number = $req->transcationcode;
                        } else if ($req->paymentmethod === "MPESA") {
                            $feepayment->MPESA_Code	 = $req->transcationcode;
                        }
    
                        $collected = Staff::find(session()->get('LoggedInUser.id'));
    
                        $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                        $feepayment->save();    

                        return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                         ]);
               } else if ($amountpayed < $pendingarrears) {
                        $newpendingbalances = $pendingarrears - $amountpayed;
                        $newfeebalance = $pendingtermbalance;
                        $newovbalance = $totalfeedebt - $amountpayed;

                        $student->pendingbalances = $newpendingbalances;
                        $student->feebalance = $newfeebalance;
                        $student->ovbalance = $newovbalance;
                        $student->save();
    
                        $feepayment = new feepayment;
                        $feepayment->sid = $req->sid;
                        $feepayment->AdmorUPI = $req->studentadmupi;
                        $feepayment->amountpayed = $amountpayed;
                        $feepayment->academicyear = $req->studentacayear;
                        $feepayment->term = $req->termpayed;
                        $feepayment->amount = $amountpayed;
                        $feepayment->paymentmethod = $req->paymentmethod;
                        
                        if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                            $feepayment->Cheque_number = $req->transcationcode;
                        } else if ($req->paymentmethod === "MPESA") {
                            $feepayment->MPESA_Code	 = $req->transcationcode;
                        }
    
                        $collected = Staff::find(session()->get('LoggedInUser.id'));
    
                        $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                        $feepayment->save();    

                        return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                         ]);
               } else if ($pendingarrears == 0 && $pendingtermbalance < $amountpayed) {
                        $newpendingbalances = 0;
                        $newfeebalance = 0;
                        $newovbalance = $totalfeedebt - $amountpayed;

                        $student->pendingbalances = $newpendingbalances;
                        $student->feebalance = $newfeebalance;
                        $student->ovbalance = $newovbalance;
                        $student->save();

                        $feepayment = new feepayment;
                        $feepayment->sid = $req->sid;
                        $feepayment->AdmorUPI = $req->studentadmupi;
                        $feepayment->amountpayed = $amountpayed;
                        $feepayment->academicyear = $req->studentacayear;
                        $feepayment->term = $req->termpayed;
                        $feepayment->amount = $amountpayed;
                        $feepayment->paymentmethod = $req->paymentmethod;
                        
                        if ($req->paymentmethod === "Bank" || $req->paymentmethod === "Bursary") {
                            $feepayment->Cheque_number = $req->transcationcode;
                        } else if ($req->paymentmethod === "MPESA") {
                            $feepayment->MPESA_Code	 = $req->transcationcode;
                        }

                        $collected = Staff::find(session()->get('LoggedInUser.id'));

                        $feepayment->Collected_By = $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'];
                        $feepayment->save();    

                        return response()->json([
                            "status" => 200,
                            "messages" => "Fee payment completed successfully",
                            "student" => $student,
                            "collectedby" => $collected['Salutation'].' '.$collected['Fname'].' '.$collected['Lname'].','.$collected['Role'],
                            "amount" => $amountpayed,
                            "term" => $req->termpayed,
                            "initialpendingarrears" => $pendingarrears,
                            "initialpendingtermbalance" => $pendingtermbalance,
                            "initialtotalfeedebt" => $totalfeedebt,
                            "pendingbalances" => $newpendingbalances,
                            "feebalance" => $newfeebalance,
                            "ovbalance" => $newovbalance,
                            "date" => $date
                        ]);
               }
            }
    }

}
