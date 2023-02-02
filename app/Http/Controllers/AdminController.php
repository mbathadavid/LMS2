<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Models\Admin;
use App\Models\Librarian;
use App\Models\Book;
use App\Models\Term;
use App\Models\classes;
use App\Models\exam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Mark;
use App\Models\cbcmarks;
use App\Models\School;
use App\Models\Guardian;
use App\Models\Staff;
use App\Models\School_Data;
use App\Models\ResultThread;
use App\Models\notifications;
use App\Models\computedfinalresulst;
use App\Models\cbcassessment;
use App\Models\FinalGrade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function landingpage(){
        //$schools = School::all();
        $data = [
            'schools' => School_Data::all()
        ];
        return view('General.landingpage',$data);
    }
    public function index(){
        $data = [
            'schools' => School_Data::all()
        ];
        return view('admin.adminlogin',$data);
    }

    public function register(){
        $data = [
            'schools' => School_Data::all()
        ];
        return view('admin.adminregister',$data);
    }

    public function resetpass(){
        return view('admin.adminforgotpass');
    }

    public function newpassreset(){
        return view('admin.resetpass');
    }
    //hande user registration ajax request
    public function saveAdmin(Request $request){
        $validator = Validator::make($request->all(),[
            'school' => 'required|max:50',
            'fname' => 'required|max:50',
            'lname' => 'required|max:50',
            'gender' => 'required|max:50',
            'salutation' => 'required|max:50',
            'email' => 'required|email|unique:staff|max:100',
            'phone' => 'required|unique:staff',
            // 'password' => 'required|min:6|max:50',
            // 'cpassword' => 'required|min:6|same:password',
        ],
    [
            'gender.required' => 'You must select gender',
            'school.required' => 'You must select your school'
        // 'cpassword.same' => 'Passwords did not match',
        // 'cpassword.required' => 'Confirm Password is required'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
            $admin = new Staff();
            $admin->sid = $request->school;
            $admin->Fname = $request->fname;
            $admin->Lname = $request->lname;
            $admin->Gender = $request->gender;
            $admin->Role = 'Super Admin';
            $admin->Salutation = $request->salutation;
            $admin->email = $request->email;
            $admin->phone = $request->phone;
            $admin->password = Hash::make('password123');
            $admin->save();

            $schooldetails = School_Data::find($request->school);

            $client = new Client();

            $url = 'https://quicksms.advantasms.com/api/services/sendsms/?';

            $params = [
                "apikey" => "0872c31420f6d597a067e23dd27ba658",
                "partnerID" => "5031",
                "message" => "Hello ".$request->fname." ".$request->lname. ". Myschool has registered you as the system administrator for ".$schooldetails['name']. ". Use your Email ".$request->email." or phone number and password123 as your Password to access your account. Follow the link https://www.myschool.co.ke/staffportal to log in. Once you Log in register the rest of the sytem users for your school: Students, Teachers, Staff Members, and Parents. You are also required to register any other required details concernung your school. Experience the best with us.",
                "shortcode" => "JuaMobile",
                "mobile" => $request->phone
            ];

            $response = $client->request('GET', $url, [
                'json' => $params,
                'verify'  => false,
            ]);

            $responseBody = json_decode($response->getBody());

            return response()->json([
                'status' => 200,
                'messages' => 'Super Admin Registered Successfully'
            ]);
    }
    
    }

    //admin login
    public function loginAdmin(Request $request){
        $validator = Validator::make($request->all(),[
            'school' => 'required',
            'emailorphone' => 'required|max:100',
            'password' => 'required|min:6|max:50'
        ],
    [
        'school.required' => 'You must Select your School To Login',
        'emailorphone.required' => 'You must Enter your Phone Number or Email to Log In'
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            if (is_numeric($request->emailorphone)) {
                $school = School_Data::where('id',$request->school)->first();
                $staff = Staff::where('Phone',$request->emailorphone)
                            ->where('sid',$request->school)
                            ->first();
            if ($staff) {
                if (Hash::check($request->password, $staff->password)) {
                    $currentuserschool = [
                        'schooldetails' => $school,
                        'LoggedInUser' => $staff
                    ];
                    if ($staff['Active'] === "No") {
                        return response()->json([
                            'status' => 401,
                            'messages' => 'Sorry! Your account has been disabled and therefore you cannot log in to system. Please contact your system administrator.'
                        ]);
                    } else {
                        $request->session()->put('LoggedInUser',$staff);
                        $request->session()->put('schooldetails',$school);
                    return response()->json([
                        'status' => 200,
                        'messages' => 'success'
                    ]);
                    }
                } else{
                    return response()->json([
                        'status' => 401,
                        'messages' => 'The password you entered is incorrect'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'No staff member with such Phone Number Registered for '.$school['name']
                ]);
            } 
        }     
         else {
            $school = School_Data::where('id',$request->school)->first();
            $staff = Staff::where('Email',$request->emailorphone)
                            ->where('sid',$request->school)
                            ->first();
            if ($staff) {
                if (Hash::check($request->password, $staff->password)) {
                    $currentuserschool = [
                        'schooldetails' => $school,
                        'LoggedInUser' => $staff
                    ];

                    if ($staff['Active'] === "No") {
                        return response()->json([
                            'status' => 401,
                            'messages' => 'Sorry! Your account has been disabled and therefore you cannot log in to system. Please contact your system administrator.'
                        ]);
                    } else {
                    $request->session()->put('LoggedInUser',$staff);
                    $request->session()->put('schooldetails',$school);
                    return response()->json([
                        'status' => 200,
                        'messages' => 'success'
                    ]);
                 }
                } else{
                    return response()->json([
                        'status' => 401,
                        'messages' => 'The password you entered is incorrect'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'No staff member with such Email Registered for '.$school['name']
                ]);
            } 
        } 
    }
    }

    public function dashboard(){
        $sid = session()->get('schooldetails.id');
        //$maxid = DB::table('school__data')->max('id');LoggedInUser
        $schoolinfo = School_Data::find($sid);
        $admininfo = Staff::find(session()->get('LoggedInUser.id'));
        $totalstudents = Student::where('sid',$sid)
                                ->get();

        $cbcstudents = Student::where('sid',$sid)
                                ->where('schoolsystem','CBC')
                                ->get();

        $oldsystemstudents = Student::where('sid',$sid)
                                    ->where('schoolsystem','8-4-4')
                                    ->get();

        $malestudents = Student::where('sid',$sid)
                                ->where('gender','male')
                                ->get();

        $femalestudents = Student::where('sid',$sid)
                                ->where('gender','female')
                                ->get();

        $teachers = Staff::where('sid',$sid)
                        ->where('Role','Teacher')
                        ->get();

        $femaleteachers = Staff::where('sid',$sid)
                                ->where('Role','Teacher')
                                ->where('Gender','Female')
                                ->get();

        $maleteachers = Staff::where('sid',$sid)
                                ->where('Role','Teacher')
                                ->where('Gender','Male')
                                ->get();

        $supportstaff = Staff::where('sid',$sid)
                            ->where('Role','Support Staff')
                            ->get();

        $femalestaff = Staff::where('sid',$sid)
                            ->where('Role','Support Staff')
                            ->where('Gender','Female')
                            ->get();

        $malestaff = Staff::where('sid',$sid)
                            ->where('Role','Support Staff')
                            ->where('Gender','Mlae')
                            ->get();

        $stream = classes::where('sid',$sid)
                        ->get();

        $cbcstream = classes::where('sid',$sid)
                            ->where('educationsystem','CBC')
                            ->get();

        $oldsystemstream = classes::where('sid',$sid)
                                    ->where('educationsystem','8-4-4')
                                    ->get();

        $parents = Guardian::where('sid',$sid)
                            ->get();

        $maleparents = Guardian::where('sid',$sid)
                                ->where('Gender','Male')
                                ->get();

        $femaleparents = Guardian::where('sid',$sid)
                                    ->where('Gender','Female')
                                    ->get();

        $books = Book::where('sid',$sid)
                      ->get();

        $borrowedbooks = Book::where('sid',$sid)
                              ->where('Status','Borrowed')
                              ->get();

        $instorebooks = Book::where('sid',$sid)
                              ->where('Status','In Store')
                              ->get();

        
        
        $data = [
            'adminInfo' => $admininfo,
            'schoolinfo' => $schoolinfo,
            'sid' => $sid,
            'books' => count($books),
            'borrowedbooks' => count($borrowedbooks),
            'instorebooks' => count($instorebooks),
            'parents' => count($parents),
            'maleparents' => count($maleparents),
            'femaleparents' => count($femaleparents),
            'totalstudents' => count($totalstudents),
            'cbcstudents' => count($cbcstudents),
            'oldsystemstudents' => count($oldsystemstudents),
            'malestudents' => count($malestudents),
            'femalestudents' => count($femalestudents),
            'teachers' => count($teachers),
            'femaleteachers' => count($femaleteachers),
            'maleteachers' => count($maleteachers),
            'supportstaff' => count($supportstaff),
            'femalestaff' => count($femalestaff),
            'malestaff' => count($malestaff),
            'stream' => count($stream),
            'cbcstream' => count($cbcstream),
            'oldsystemstream' => count($oldsystemstream)
        ];

        return view('adminFiles.dashboard', $data);
    }
    //Admin Profile Page
    public function profile(){
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];

        return view('adminFiles.profile',$data);
    }

    //Admin Login page
    public function performanceAnalysis(){
        $maxid = session()->get('schooldetails.id');
        $threads = ResultThread::where('sid',$maxid)
                                ->OrderbyDesc('id')
                                ->get();

        $subjects = Subject::where('sid',$maxid)
                            ->where('educationsystem','8-4-4')
                            ->get();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'threads' => $threads,
            'subjects' => $subjects
        ];

        return view('adminFiles.performanceanalysis',$data);
    }

//Performance analysis
public function classperformanceAnalysis($class,$tid){
    $maxid = session()->get('schooldetails.id');
    $subjects = Subject::where('sid',$maxid)
                                ->where('educationsystem','8-4-4')
                                ->where('level','Secondary')
                                ->where('deleted',0)
                                ->get();
    
    $computedmarks = computedfinalresulst::where('sid',$maxid)
                                ->where('tid', $tid)
                                ->where('Class', 'LIKE', '%'.$class.'%')
                                ->where('Finalscore','!=',null)
                                ->orderBydesc('FinalScore')
                                ->get();

    $subnames = [];
    $subids = [];

    foreach ($subjects as $key => $subject) {
        array_push($subnames,$subject->subject);
        array_push($subids,$subject->id);
    }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'subjects' => $subjects,
            'computedmarks' => $computedmarks,
            'subnames' => $subnames,
            'subids' => $subids 
        ];

        return view('adminFiles.classperformanceanalysis',$data);
}

//Function for analyzing Subject Perfomance for students 
public function analyzeSubjects($class,$sid,$subid,$tid){
    $maxid = session()->get('schooldetails.id');

    $subject = Subject::where('sid',$maxid)
                       ->where('id',$subid)
                       ->where('educationsystem','8-4-4')
                       ->where('level','Secondary')
                       ->where('deleted',0)
                       ->first();

    $grades = FinalGrade::where('sid',$maxid)
                        ->where('classid',$sid)
                        ->where('subid',$subid)
                        ->where('tid',$tid)
                        ->OrderByDesc('score')
                        ->get();

    $availablescores = FinalGrade::where('sid',$maxid)
                                    ->where('classid',$sid)
                                    ->where('subid',$subid)
                                    ->where('tid',$tid)
                                    ->first();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'class' => $class,
            'subid' => $subid,
            'tid' => $tid,
            'subject' => $subject['subject'],
            'grades' => $grades,
            'availablescores' => $availablescores['availablescores']
        ];

        return view('adminFiles.subjectperformanceanalysis',$data);
}

//function for returning students
public function students(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.students',$data);
}
//Function for returning Examination Thread
public function resultThread(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.resultthread',$data);
}
//function for returning teachers
public function teachers(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.teachers',$data);
}
//function for returning parents
public function parents(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.parents',$data);
}
//function for returning communication view
public function communucationsview(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.communications',$data);
}


//function for returning staff
public function staff(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.staff',$data);
}
//function for returning subjects
public function subjects(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.subjects',$data);
}
//function for returning clubs
public function clubs(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.clubs',$data);
}
//function for returning classes
public function classes(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.classes',$data);
}
//function for returning departments
public function departments(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.departments',$data);
}
//function for returning expenses
public function expenses(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.expenses',$data);
}
//function for returning fee structure
public function feeStructure(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.feestructure',$data);
}
//Function to return collect fee information
public function feeCollection(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.collectfee',$data);
}
//Function to return expenses records view
public function financialReport(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.finreport',$data);
}
//Function to return autoresults
public function autoresults(){
    //$exam = exam::all();
    $maxid = DB::table('school__data')->max('id');
    $sid = session()->get('schooldetails.id');
    $subjects = Subject::where('educationsystem','8-4-4')
                        ->where('sid',$sid)
                        ->get();

    $classes = classes::where('educationsystem','8-4-4')
                        ->where('sid',$sid)
                        ->get();

    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => School_Data::find($sid),
        'exams' => exam::all(),
        'subjects' => $subjects,
        'classes' => $classes
    ];

    return view('adminFiles.autoresults',$data);
}
//function for returning procurements
public function procurements(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.procurements',$data);
}
//function for returning procurements
public function gradingsystem(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
        //'subjects' => Subject::all(),
        //'classes' => classes::all()
    ];

    return view('adminFiles.gradingsystem',$data);
}
//function for returning suppliers
public function suppliers(){
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
    ];

    return view('adminFiles.suppliers',$data);
}
//Function for returning final Results view 
public function finalresults(){
    $sid = session()->get('schooldetails.id');
    $classes = classes::where('educationsystem','8-4-4')
                        ->where('sid',$sid)
                        ->get();
    $threads = ResultThread::where('sid',$sid)
                            ->get();
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => School_Data::find($sid),
        'classes' => $classes,
        'threads' => $threads
    ];

    return view('adminFiles.finalresults',$data);
}
//function for returning libary info
public function library(){
    $librarians = Librarian::all();
    $books = Book::all();
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
        'librarians' => $librarians,
        'books' => $books
    ];
    return view('adminFiles.library',$data);
}
//function for returning books view to the admin
public function books(){
    $librarians = Librarian::all();
    $books = Book::where('deleted',0)
                    ->get();
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
        'librarians' => $librarians,
        //'books' => $books
    ];
    return view('adminFiles.books',$data);
}
//function for returning terms view
public function terms(){
    $classes = classes::all();
    $librarians = Librarian::all();
    $terms = Term::all();
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
        'librarians' => $librarians,
        'terms' => $terms,
        'classes' => $classes
    ];
    return view('adminFiles.terms',$data);
}
    //Set Current Term
public function currentTerm(){
    $classes = classes::all();
    $librarians = Librarian::all();
    $terms = Term::all();
    $maxid = DB::table('school__data')->max('id');
    $data = [
        'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
        'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
        'librarians' => $librarians,
        'terms' => $terms,
        'classes' => $classes
    ];
    return view('adminFiles.currentterm',$data);
}
    //return Exam view
public function examinations(){
        $classes = classes::all();
        $librarians = Librarian::all();
        $terms = Term::all();
        $exams = exam::where('deleted',0)
                            ->get();
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'librarians' => $librarians,
            'terms' => $terms,
            'exams' => $exams
        ];
        return view('adminFiles.exams',$data);
    }  
    
    //Return Exams View 
    public function cbcAssessments(){
        $maxid = session()->get('schooldetails.id');

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
        ];

        return view('adminFiles.cbcassessements',$data);
    }

    //Function to return view for result computation
    public function getClassCompResults($examid,$classid,$sid){
        //$schoolid = session()->get('schooldetails.id');
        // $classes = classes::all();
        $classes = classes::where('sid',$sid)
                            ->where('educationsystem','8-4-4')
                            ->get();
        $currentclass = classes::find($classid);
        $currentexam = exam::find($examid);
        $students = Student::where('current_classid',$classid)
                            ->where('sid',$sid)
                            ->get();
        $adms = [];
        $terms = Term::all();
        $exams = exam::where('deleted',0)
                       ->where('sid',$sid)
                       ->get();
        $subjects = Subject::where('sid',$sid)
                            ->where('educationsystem','8-4-4')
                            ->get();
        $marks = Mark::where('classid',$classid)
                        ->where('examid',$examid)
                       ->get();
        $maxid = DB::table('school__data')->max('id');

        foreach ($marks as $mark) {
            array_push($adms,$mark->AdmissionNo);
        }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'terms' => $terms,
            'exams' => $exams,
            'classes' => $classes,
            'currentclass' => $currentclass,
            'students' => $students,
            'subjects' => $subjects,
            'currentexam' => $currentexam,
            'marks' => $marks,
            'adms' => $adms
        ];
        return view('adminFiles.computeresults',$data);
    }

     //Function to return view for result computation
     public function getCBCAddmarksView($examid,$classid,$sid){
        $maxid = session()->get('schooldetails.id');
        //$schoolid = session()->get('schooldetails.id');
        // $classes = classes::all();
        $classes = classes::where('sid',$sid)
                            ->where('educationsystem','8-4-4')
                            ->get();
        $currentclass = classes::find($classid);
        $currentexam = cbcassessment::find($examid);
        $students = Student::where('current_classid',$classid)
                            ->where('sid',$sid)
                            ->get();
        $adms = [];
        $terms = Term::all();
        $exams = cbcassessment::where('deleted',0)
                       ->where('sid',$sid)
                       ->get();
        $subjects = Subject::where('sid',$sid)
                            ->where('educationsystem','CBC')
                            ->get();
        $marks = cbcmarks::where('classid',$classid)
                        ->where('examid',$examid)
                        ->get();

        foreach ($marks as $mark) {
            array_push($adms,$mark->AdmissionNo);
        }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'terms' => $terms,
            'exams' => $exams,
            'classes' => $classes,
            'currentclass' => $currentclass,
            'students' => $students,
            'subjects' => $subjects,
            'currentexam' => $currentexam,
            'marks' => $marks,
            'adms' => $adms
        ];
        return view('adminFiles.cbcmarksadd',$data);
    }

    //Function to return admin notifications page
    public function notificationsView(){
        $maxid = session()->get('schooldetails.id');

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];

        return view('adminFiles.notifications',$data);
    }

    //Function to return Admin Notify page
    public function adminnotififyView(){
        $maxid = session()->get('schooldetails.id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];

        return view('adminFiles.notify',$data); 
    }

    //Function to return parent notifications view
    public function adminparentmessagesView(){
        $maxid = session()->get('schooldetails.id');

        $parentmessages = notifications::where('sid',$maxid)
                                        ->where('type','parentmessage')
                                        ->where('deleted',0)
                                        ->orderByDesc('id')
                                        ->get();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'parentmessages' => $parentmessages
        ];

        return view('adminFiles.parentmessages',$data);  
    }

    //Function to return admin's send messages
    public function adminmymessagesView(){
        $maxid = session()->get('schooldetails.id');

        $uid = session()->get('LoggedInUser.id');

        $mymessages = notifications::where('sid',$maxid)
                                ->where('uid',$uid)
                                ->where('deleted',0)
                                ->orderByDesc('id')
                                ->get();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'mymessages' => $mymessages
        ];

        return view('adminFiles.mymessages',$data); 
    }
    

    //Function to return noticeboard view
    public function adminnoticeboardView(){
        $maxid = session()->get('schooldetails.id');
        
        $notices = notifications::where('sid',$maxid)
                    ->where('type','noticeboard')
                    ->where('group','Staff')
                    ->where('deleted',0)
                    ->orderByDesc('id')
                    ->get();

        $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'notices' => $notices,
                ];
            
        return view('adminFiles.noticeboard',$data); 
        
    }


    //function to logout
    public function logoutAdmin(){
        if (session()->has('LoggedInUser')) {
            session()->pull('LoggedInUser');
            return redirect('/adminlogin');
        }
    }
}
