<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use App\Models\Admin;
use App\Models\Librarian;
use App\Models\Book;
use App\Models\Term;
use App\Models\classes;
use App\Models\Exam;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Mark;
use App\Models\communications;
use App\Models\cbcmarks;
use App\Models\School;
use App\Models\Guardian;
use App\Models\generalreports;
use App\Models\subjectreports;
use App\Models\Staff;
use App\Models\feepayment;
use App\Models\expenses;
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
            $username = $request->phone.'@'.$request->school;
            $admin->username = $username;
            $admin->priviledges = '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15';
            $admin->password = Hash::make('password123');
            $admin->save();

            $schooldetails = School_Data::find($request->school);

        //Inform by SMS Start
        $curl = curl_init();
        
        $post_data = [
            "mobile" => $request->phone,
            "response_type" => "json",
            "sender_name" => "23107",
            "service_id" => 0,
            "message" => "You have been registered as a Super Admin for ".$schooldetails['name'].". Username is ".$username.", and password is password123. Click https://www.shuleyetu.co.ke/adminlogin to log in"
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobitechtechnologies.com/sms/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_HTTPHEADER => array(
                'h_api_key: ae42640feb185a424fdce5d4c6bde3ab955f7e332782024b527cda3c4a8d43cc',
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
        //Inform by SMS Start

            return response()->json([
                'status' => 200,
                'messages' => 'Super Admin Registered Successfully'
            ]);
    }
    
    }

    //admin login
    public function loginAdmin(Request $request){
        $validator = Validator::make($request->all(),[
            //'school' => 'required',
            'username' => 'required|max:100',
            'password' => 'required'
        ],
    [
        //'school.required' => 'You must Select your School To Login',
        'username.required' => 'You must Enter your Phone Number or Email to Log In',
        'password.required' => 'You must Enter your password to log in'
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            
                // $sid = explode("@",$request->username)[1];
                // $school = School_Data::find($sid);
            $staff = Staff::where('username',$request->username)
                            ->first();
            if ($staff) {
                if (Hash::check($request->password, $staff->password)) {
                    // $currentuserschool = [
                    //     'schooldetails' => $school,
                    //     'LoggedInUser' => $staff
                    // ];
                    if ($staff['Active'] === "No") {
                        return response()->json([
                            'status' => 401,
                            'messages' => 'Sorry! Your account has been disabled and therefore you cannot log in to system. Please contact your system administrator.'
                        ]);
                    } else {
                        $sid = explode("@",$request->username)[1];
                        $school = School_Data::find($sid);
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
                    'messages' => 'No staff member with such Username Registered'
                ]);
            } 
    }
    }

    //Function to reset password
    public function adminresetPassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'phoneno' => 'required',
        ],
        [
            'phoneno.required' => 'You must Enter your Registered Phone Number',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $staff = Staff::where('Phone',$request->phoneno)
                            ->get();
            
            if (count($staff) == 0) {
                return response()->json([
                    'status' => 401,
                    'messages' => "Sorry! No account registered with this phone number"
                ]);
            } else {
                return [
                    'status' => 200,
                    'username' => $staff[0]['username'],
                    'password' => $staff[0]['password'],
                    'id' => $staff[0]['id'] 
                ];
            }
            
        } 
    }

    public function dashboard(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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

            $resultthreads = ResultThread::where('sid',$sid)
                                ->get();

            $cbcassessments = cbcassessment::where('sid',$sid)
                                ->get();

            $pendingbalances = [];
            $currenttermbalances = [];
            $overallbalances = [];

            foreach ($totalstudents as $key => $student) {
                array_push($pendingbalances,$student->pendingbalances);
                array_push($currenttermbalances,$student->feebalance);
                array_push($overallbalances,$student->ovbalance);
            }
            
            $data = [
                'adminInfo' => $admininfo,
                'schoolinfo' => $schoolinfo,
                'sid' => $sid,
                'pendingbalances' => array_sum($pendingbalances),
                'currenttermbalances' => array_sum($currenttermbalances),
                'overallbalances' => array_sum($overallbalances),
                'resultthreads' => count($resultthreads),
                'cbcassessments' => count($cbcassessments),
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
        } else {
            return redirect('/adminlogin');
        }
    }
    //Admin Profile Page
    public function profile(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = DB::table('school__data')->max('id');
            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
            ];

            return view('adminFiles.profile',$data);
        } else {
            return redirect('/adminlogin');
        }
    }

    //Admin Perfomance 8-4-4 Perfomance analysis page
    public function performanceAnalysis(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
        } else {
            return redirect('/adminlogin');
        }
    }

    //Admin Perfomance CBC Perfomance analysis page
    public function cbcperformanceAnalysis(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = session()->get('schooldetails.id');
            $threads = cbcassessment::where('sid',$maxid)
                                    ->OrderbyDesc('id')
                                    ->get();

            $subjects = Subject::where('sid',$maxid)
                                ->where('educationsystem','CBC')
                                ->get();

            $streams = classes::where('sid',$maxid)
                                ->where('educationsystem','CBC')
                                ->get();

            $subnames = [];
            $subids = [];

            foreach ($subjects as $key => $subject) {
                array_push($subnames,$subject->subject);
                array_push($subids,$subject->id);
            }

            $subidcombination = array_combine($subids,$subnames);

            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'threads' => $threads,
                'subjects' => $subjects,
                'streams' => $streams,
                'subnames' => $subnames,
                'subids' => $subids,
                'subidcombination' => $subidcombination
            ];

            return view('adminFiles.cbcperformanceanalysis',$data);
        } else {
            return redirect('/adminlogin');
        }
    }

//Function to return student reviewing view
public function studentreviewsAnalysis(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = session()->get('schooldetails.id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
        ];
    
        return view('adminFiles.studentreviewsanalysis',$data);   
    } else {
        return redirect('/adminlogin');
    }
}

//Performance analysis
public function classperformanceAnalysis($class,$tid){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = session()->get('schooldetails.id');
        $subjects = Subject::where('sid',$maxid)
                                    ->where('educationsystem','8-4-4')
                                    ->where('level','Secondary')
                                    ->where('deleted',0)
                                    ->get();

        $subnames = [];
        $subids = [];

        foreach ($subjects as $key => $subject) {
            array_push($subnames,$subject->subject);
            array_push($subids,$subject->id);
        }
        
        $computedmarks = computedfinalresulst::where('sid',$maxid)
                                    ->where('tid', $tid)
                                    ->where('Class', 'LIKE', '%'.$class.'%')
                                    ->where('Finalscore','!=',null)
                                    ->orderBydesc('FinalScore')
                                    ->get();

        $subjectmarks = FinalGrade::where('sid',$maxid)
                                    ->where('tid',$tid)
                                    ->get();

        $examthread = ResultThread::find($tid);
    
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
                'subids' => $subids,
                'examthread' => $examthread,
                'subjectmarks' => $subjectmarks 
            ];
    
            return view('adminFiles.classperformanceanalysis',$data);  
    } else {
        return redirect('/adminlogin');
    }

}

//Function for analyzing Subject Perfomance for students 
public function analyzeSubjects($class,$sid,$subid,$tid){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
    } else {
        return redirect('/adminlogin');
    }
}

//function for returning students
public function students(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.students',$data);  
    } else {
        return redirect('/adminlogin');
    }
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
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.teachers',$data);  
    } else {
        return redirect('/adminlogin');
    }
}
//function for returning parents
public function parents(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.parents',$data);   
    } else {
        return redirect('/adminlogin');
    }
}
//function for returning communication view
public function communucationsview(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.communications',$data);  
    } else {
        return redirect('/adminlogin');
    }
}

//function for returning Fee Reminder View
public function feeReminders(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $sid = session()->get('schooldetails.id');

        $students = Student::where('sid',$sid)
                            ->where('deleted',0)
                            ->where('completed',0)
                            ->get();

        $parentcontacts = [];

        foreach ($students as $key => $student) {
            if ($student->parentinfo !== NULL) {
                array_push($parentcontacts,explode(',',$student->parentinfo)[4]);
            }
            
        }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'students' => $students,
            'parentcontacts' => $parentcontacts
        ];
    
        return view('adminFiles.feereminders',$data);  
    } else {
        return redirect('/adminlogin');
    }
}

//function for returning Send Exam Results View
public function sendExamResults(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $sid = session()->get('schooldetails.id');

        $classes = classes::where('sid',$sid)
                            ->where('deleted',0)
                            ->get();

        $asessements = cbcassessment::where('sid',$sid)
                                    ->OrderByDesc('id')
                                    ->get();

        $threads = ResultThread::where('sid',$sid)
                                ->OrderByDesc('id')
                                ->get();

        $examinations = Exam::where('sid',$sid)
                            ->where('deleted',0)
                            ->OrderByDesc('id')
                            ->get();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'classes' => $classes,
            'asessements' => $asessements,
            'threads' => $threads,
            'examinations' => $examinations
        ];
    
        return view('adminFiles.sendexamresults',$data);  
    } else {
        return redirect('/adminlogin');
    }
}

//function for returning staff
public function staff(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.staff',$data);  
    } else {
        return redirect('/adminlogin');
    }
}
//function for returning subjects
public function subjects(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.subjects',$data);   
    } else {
        return redirect('/adminlogin');
    }
}
//function for returning clubs
public function clubs(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.clubs',$data);   
    } else {
        return redirect('/adminlogin');
    }
}

//function for returning classes
public function classes(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.classes',$data);   
    } else {
        return redirect('/adminlogin');
    }
}

//function for returning classes
public function hostels(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.domitories',$data);   
    } else {
        return redirect('/adminlogin');
    }
}

//function for returning departments
public function departments(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.departments',$data);   
    } else {
        return redirect('/adminlogin');
    }
}
//function for returning expenses
public function expenses(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.expenses',$data);  
    } else {
        return redirect('/adminlogin');
    }
}
//function for returning fee structure
public function feeStructure(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];

        return view('adminFiles.feestructure',$data);    
    } else {
        return redirect('/adminlogin');
    }  
}
//Function to return collect fee information
public function feeCollection(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $sid = session()->get('schooldetails.id');
        $totalstudents = Student::where('sid',$sid)
                                    ->get();

        $pendingbalances = [];
        $currenttermbalances = [];
        $overallbalances = [];
                        
        foreach ($totalstudents as $key => $student) {
            array_push($pendingbalances,$student->pendingbalances);
            array_push($currenttermbalances,$student->feebalance);
            array_push($overallbalances,$student->ovbalance);
        }
                                    

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'pendingbalances' => array_sum($pendingbalances),
            'currenttermbalances' => array_sum($currenttermbalances),
            'overallbalances' => array_sum($overallbalances),
        ];
    
        return view('adminFiles.collectfee',$data);   
    } else {
        return redirect('/adminlogin');
    }
}
//Function to return expenses records view
public function financialReport(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $sid = session()->get('schooldetails.id');
        $expenses = expenses::where('sid',$sid)
                      ->get();

        $feepayments = feepayment::where('sid',$sid)
                      ->get();

        $actualexpenses = [];
        $actualpayments = [];

        foreach ($expenses as $key => $expense) {
            array_push($actualexpenses,$expense->amount);
        }

        foreach ($feepayments as $key => $feepayment) {
            array_push($actualpayments,$feepayment->amountpayed);
        }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'actualexpenses' => array_sum($actualexpenses),
            'actualpayments' => array_sum($actualpayments)
        ];

        return view('adminFiles.finreport',$data);    
    } else {
        return redirect('/adminlogin');
    }
}
//Function to return autoresults
public function autoresults(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $sid = session()->get('schooldetails.id');
        $subjects = Subject::where('educationsystem','8-4-4')
                            ->where('sid',$sid)
                            ->get();

        $classes = classes::where('educationsystem','8-4-4')
                            ->where('sid',$sid)
                            ->get();

        $exams = Exam::where('sid',$sid)
                     ->get();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => School_Data::find($sid),
            'exams' => $exams,
            'subjects' => $subjects,
            'classes' => $classes
        ];

        return view('adminFiles.autoresults',$data);    
    } else {
        return redirect('/adminlogin');
    }
    //$exam = exam::all();
    
}
//function for returning procurements
public function procurements(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.procurements',$data);   
    } else {
        return redirect('/adminlogin');
    }
}
//function for returning procurements
public function gradingsystem(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            //'subjects' => Subject::all(),
            //'classes' => classes::all()
        ];
    
        return view('adminFiles.gradingsystem',$data);  
    } else {
        return redirect('/adminlogin');
    }

}
//function for returning suppliers
public function suppliers(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];
    
        return view('adminFiles.suppliers',$data);   
    } else {
        return redirect('/adminlogin');
    }
}
//Function for returning final Results view 
public function finalresults(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
    } else {
        return redirect('/adminlogin');
    }
}

//function to return reporting view
public function studentReport() {
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $sid = session()->get('schooldetails.id');
        $classes = classes::where('sid',$sid)
                            ->get();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => School_Data::find($sid),
            'classes' => $classes
        ];

        return view('adminFiles.studentreport',$data);   
    } else {
        return redirect('/adminlogin');
    }
}


//function for returning libary info
public function library(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
    } else {
        return redirect('/adminlogin');
    }
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
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
    } else {
        return redirect('/adminlogin');
    }
}
    //Set Current Term
public function currentTerm(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
    } else {
        return redirect('/adminlogin');
    }
}
    //return Exam view
public function examinations(){
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $classes = classes::all();
        $librarians = Librarian::all();
        $terms = Term::all();
        $exams = Exam::where('deleted',0)
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
    } else {
        return redirect('/adminlogin');
    }   
    }  
    
    //Return Exams View 
    public function cbcAssessments(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = session()->get('schooldetails.id');

            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            ];
    
            return view('adminFiles.cbcassessements',$data);
        } else {
            return redirect('/adminlogin');
        }
    }

    //Function to return view for result computation
    public function getClassCompResults($examid,$classid,$sid){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $classes = classes::where('sid',$sid)
                        ->where('educationsystem','8-4-4')
                        ->get();
            $currentclass = classes::find($classid);
            $currentexam = Exam::find($examid);
            $students = Student::where('current_classid',$classid)
                        ->where('sid',$sid)
                        ->get();
            $adms = [];
            $terms = Term::all();
            $exams = Exam::where('deleted',0)
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
        } else {
            return redirect('/adminlogin');
        }
        //$schoolid = session()->get('schooldetails.id');
        // $classes = classes::all();
    }

     //Function to return view for result computation
     public function getCBCAddmarksView($examid,$classid,$sid){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
        } else {
            return redirect('/adminlogin');
        }
    }

    //Function to return admin notifications page
    public function notificationsView(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = session()->get('schooldetails.id');

            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
            ];

            return view('adminFiles.notifications',$data);
        } else {
            return redirect('/adminlogin');
        }
    }

    //Function to return Admin Notify page
    public function adminnotififyView(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = session()->get('schooldetails.id');
            $data = [
                'adminInfo' => DB::table('staff')->where('id', session('LoggedInUser.id'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
            ];
    
            return view('adminFiles.notify',$data);
        } else {
            return redirect('/adminlogin');
        } 
    }

    //Function to return parent notifications view
    public function adminparentmessagesView(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
        } else {
            return redirect('/adminlogin');
        }  
    }

    //Function to return admin's send messages
    public function adminmymessagesView(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
        } else {
            return redirect('/adminlogin');
        }
    }

    //Funxction to return messaging history
    public function messagingHistory(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = session()->get('schooldetails.id');

            $uid = session()->get('LoggedInUser.id');

            $messaginghistory = communications::where('sid',$maxid)
                                    ->orderByDesc('id')
                                    ->get();

            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'messaginghistory' => $messaginghistory
            ];

            return view('adminFiles.messaginghistory',$data);
        } else {
            return redirect('/adminlogin');
        }
    }
    

    //Function to return noticeboard view
    public function adminnoticeboardView(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
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
        } else {
            return redirect('/adminlogin');
        }
        
    }

    //Function to return details view
public function studentDetails($stuid) {
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = session()->get('schooldetails.id');

    $notices = notifications::where('sid',$maxid)
                    ->where('type','noticeboard')
                    ->where('group','Parents')
                    ->where('deleted',0)
                    ->orderByDesc('id')
                    ->get();

    $uid = session()->get('LoggedInUser.id');

    $notifications = notifications::where('sid',$maxid)
                    ->where('type','noticeboard')
                    ->orWhere('toberecievedby',$uid)
                    ->where('deleted',0)
                    ->orderByDesc('id')
                    ->get();

    $mymessages = notifications::where('sid',$maxid)
                                ->where('type','parentmessage')
                                ->where('uid',$uid)
                                ->where('deleted',0)
                                ->orderByDesc('id')
                                ->get();
                    
    $parentstudents = Guardian::find($uid);
            
    $fnames = [];
    $lnames = [];
    $profiles = [];
    $classes = [];
    $ids = [];
            

    $student = Student::find($stuid);
    $books = Book::where('borrowed_by',$student['AdmissionNo'])
                      ->orWhere('borrowed_by',$student['UPI'])
                      ->get();

    $payedfees = feepayment::where('AdmorUPI',$student['AdmissionNo'])
                            ->orWhere('AdmorUPI',$student['UPI'])
                            ->get();

    $generalreports = generalreports::where('studentid',$student['id'])
                                    ->orderByDesc('created_at')
                                    ->get();

    //$computedresults = computedfinalresulst::where() 

    $issuedbooks = [];
    $fees = [];

    foreach ($payedfees as $key => $payedfee) {
        array_push($fees,$payedfee->amount);
    }

    foreach ($books as $key => $book) {
        array_push($issuedbooks,$book->BookNumber);
    }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'notices' => $notices,
            'fnames' => $fnames,
            'mymessages' => $mymessages,
            'notifications' => $notifications,
            'student' => $student,
            'books' => $issuedbooks,
            'totalfees' => array_sum($fees),
            'generalreports' => $generalreports
        ];

        return view('adminFiles.studentperfomance',$data);
    } else {
        return redirect('/adminlogin');
    } 
}

//Function to return student perfomance view
public function studentPerfomance($stuid,$aid) {
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = session()->get('schooldetails.id');

    $notices = notifications::where('sid',$maxid)
                    ->where('type','noticeboard')
                    ->where('group','Parents')
                    ->where('deleted',0)
                    ->orderByDesc('id')
                    ->get();

    $uid = session()->get('LoggedInUser.id');

    $notifications = notifications::where('sid',$maxid)
                    ->where('type','noticeboard')
                    ->orWhere('toberecievedby',$uid)
                    ->where('deleted',0)
                    ->orderByDesc('id')
                    ->get();

    $mymessages = notifications::where('sid',$maxid)
                                ->where('type','parentmessage')
                                ->where('uid',$uid)
                                ->where('deleted',0)
                                ->orderByDesc('id')
                                ->get();
                    
    $parentstudents = Guardian::find($uid);
            
    $fnames = [];
    $lnames = [];
    $profiles = [];
    $classes = [];
    $ids = [];

    $student = Student::find($stuid);
    $resultthread = ResultThread::find($aid);

    $examscores = computedfinalresulst::where('tid',$aid)
                                      ->where('AdmissionNo',$student['AdmissionNo'])
                                      ->orWhere('AdmissionNo',$student['UPI'])
                                      ->get();

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'notices' => $notices,
            'fnames' => $fnames,
            'mymessages' => $mymessages,
            'notifications' => $notifications,
            'student' => $student,
            'examscores' => $examscores[0],
            'resultthread' => $resultthread
        ];

        return view('adminFiles.studentmarks',$data);
    } else {
        return redirect('/adminlogin');
    } 
}

//Function to return CBC Analysis View
public function cbcstudentPerfomance($stuid,$aid) {
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = session()->get('schooldetails.id');

        $notices = notifications::where('sid',$maxid)
                        ->where('type','noticeboard')
                        ->where('group','Parents')
                        ->where('deleted',0)
                        ->orderByDesc('id')
                        ->get();
    
        $uid = session()->get('LoggedInUser.id');
    
        $notifications = notifications::where('sid',$maxid)
                        ->where('type','noticeboard')
                        ->orWhere('toberecievedby',$uid)
                        ->where('deleted',0)
                        ->orderByDesc('id')
                        ->get();
    
        $mymessages = notifications::where('sid',$maxid)
                                    ->where('type','parentmessage')
                                    ->where('uid',$uid)
                                    ->where('deleted',0)
                                    ->orderByDesc('id')
                                    ->get();
                        
        $parentstudents = Guardian::find($uid);
                
        $fnames = [];
        $lnames = [];
        $profiles = [];
        $classes = [];
        $ids = [];
    
        $student = Student::find($stuid);
        $cbcassessment = cbcassessment::find($aid);
        $studentmarks = cbcmarks::where('examid',$aid)
                                ->where('AdmissionNo',$student['AdmissionNo'])
                                ->orWhere('AdmissionNo',$student['UPI'])
                                ->get();
    
            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'notices' => $notices,
                'fnames' => $fnames,
                'mymessages' => $mymessages,
                'notifications' => $notifications,
                'cbcassessment' => $cbcassessment,
                'studentmarks' => $studentmarks,
                'student' => $student
            ];
    
            return view('adminFiles.cbcstudentmarks',$data);
    } else {
        return redirect('/adminlogin');
    } 
}

//Function to return subject perfomance view
public function subjectPerfomance($stuid,$subid) {
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = session()->get('schooldetails.id');

        $notices = notifications::where('sid',$maxid)
                        ->where('type','noticeboard')
                        ->where('group','Parents')
                        ->where('deleted',0)
                        ->orderByDesc('id')
                        ->get();
    
        $uid = session()->get('LoggedInUser.id');
    
        $notifications = notifications::where('sid',$maxid)
                        ->where('type','noticeboard')
                        ->orWhere('toberecievedby',$uid)
                        ->where('deleted',0)
                        ->orderByDesc('id')
                        ->get();
    
        $mymessages = notifications::where('sid',$maxid)
                                    ->where('type','parentmessage')
                                    ->where('uid',$uid)
                                    ->where('deleted',0)
                                    ->orderByDesc('id')
                                    ->get();
                        
        $parentstudents = Guardian::find($uid);
                
        $fnames = [];
        $lnames = [];
        $profiles = [];
        $classes = [];
        $ids = [];
    
        $student = Student::find($stuid);
        $reports = subjectreports::where('studentid',$student['id'])
                                 ->where('subjectid',$subid)
                                 ->orderByDesc('created_at')
                                 ->get();
    
        $cbcscores = cbcmarks::where('subid',$subid)
                            ->where('AdmissionNo',$student['AdmissionNo']) 
                            ->orWhere('AdmissionNo',$student['UPI'])
                            ->orderByDesc('created_at')
                            ->get();
    
        $marks = FinalGrade::where('subid',$subid)
                           ->where('AdmissionNo',$student['AdmissionNo'])
                           ->orWhere('AdmissionNo',$student['UPI'])
                           ->orderByDesc('created_at')
                           ->get();
    
        $subject = Subject::find($subid);
    
        $cbcthreads = [];
        $examthreads = [];
        $cbcmarks = [];
        $regmarks = [];
        $cbcgrades = [];
        $reggrades = [];
        $cbcremarks = [];
        $regremarks = [];
        $availablescores = [];
        $thescores = [];
        $maxscores = [];
    
        foreach ($cbcscores as $key => $cbcscore) {
            array_push($cbcmarks,$cbcscore->marks);
            array_push($cbcremarks,$cbcscore->Remarks);
            array_push($cbcgrades,$cbcscore->Grade);
            array_push($maxscores,$cbcscore->maxscore);
    
            $cbcassessment = cbcassessment::find($cbcscore->examid);
            array_push($cbcthreads,$cbcassessment['Assessment']);
        }
    
        foreach ($marks as $key => $mark) {
            array_push($regmarks,$mark->score);
            array_push($reggrades,$mark->grade);
            array_push($regremarks,$mark->Remarks);
            array_push($availablescores,$mark->availablescores);
            array_push($thescores,$mark->scores);
    
            $resultthreads = ResultThread::find($mark->tid);
            array_push($examthreads,$resultthreads['name'].','.$resultthreads['term'].','.$resultthreads['year']);
        }
        
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'notices' => $notices,
            'fnames' => $fnames,
            'mymessages' => $mymessages,
            'notifications' => $notifications,
            'cbcthreads' => $cbcthreads,
            'examthreads' => $examthreads,
            'cbcmarks' => $cbcmarks,
            'regmarks' => $regmarks,
            'cbcgrades' => $cbcgrades,
            'reggrades' => $reggrades,
            'cbcremarks' => $cbcremarks,
            'regremarks' => $regremarks,
            'availablescores' => $availablescores,
            'thescores' => $thescores,
            'maxscores' => $maxscores,
            'student' => $student,
            'reports' => $reports,
            'subject' => $subject['subject']
        ];
    
        return view('adminFiles.subjectperfomance',$data);
    } else {
        return redirect('/adminlogin');
    } 
}

    //function to logout
    public function logoutAdmin(){
        if (session()->has('LoggedInUser')) {
            session()->pull('LoggedInUser');
            return redirect('/adminlogin');
        }
    }
}
