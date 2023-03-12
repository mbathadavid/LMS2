<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Admin;
use App\Models\School_Data;
use Illuminate\Support\Facades\DB;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Staff;
use App\Models\classes;
use App\Models\cbcassessment;
use App\Models\cbcmarks;
use App\Models\Book;
use App\Models\notifications;
use App\Models\computedfinalresulst;
use App\Models\FinalGrade;
use App\Models\ResultThread;
use App\Models\feepayment;
use App\Models\generalreports;
use App\Models\subjectreports;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    //Register parent
    public function registerParent(Request $req){
        $maxid = session()->get('schooldetails.id');

        if ($req->email) {
            $validator = Validator::make($req->all(),[
                'firstname' => 'required',
                //'secondname' => 'required',
                'lastname' => 'required',
                'phone' => 'required|unique:guardians',
                'email' => 'email|unique:guardians', 
                //'altphone' => 'unique:guardians',
                'admsions' => 'required',
                'file' => 'image'
            ],
        [
            'admsions.required' => 'Please Match Parent With Their Child/Children'
        ]);
        } else {
            $validator = Validator::make($req->all(),[
                'firstname' => 'required',
                //'secondname' => 'required',
                'lastname' => 'required',
                'phone' => 'required|unique:guardians',
                //'email' => 'email|unique:guardians', 
                //'altphone' => 'unique:guardians',
                'admsions' => 'required',
                'file' => 'image'
            ],
        [
            'admsions.required' => 'Please Match Parent With Their Child/Children',
            'firstname.required' => 'Please specify the First Name of the Parent',
            'lastname.required' => 'Please specify the Last Name',
            'phone.required' => 'Please Enter the Phone Number of the Parent'
        ]);
        }
        
    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
        // $students = explode(',',$req->admsions);
        // for ($i=0; $i < count($students); $i++) { 
        //     $student = Student::where('UPI',$students[$i])
        //                 ->orWhere('AdmissionNo',$students[$i])
        //                 ->update(['parentinfo' => $req->firstname.','.$req->lastname.','.$req->parent_guardian.','.$req->phone.','.$req->email]);
        // }

        $students = explode(',',$req->admsions);
        $student = Student::whereIn('UPI', $students)->orWhereIn('AdmissionNo', $students)->update(['parentinfo' => $req->firstname.','.$req->lastname.','.$req->parent_guardian.','.$req->phone.','.$req->email]);


        $guardian = new Guardian;
        $guardian->sid = $req->sid;
        $guardian->Fname = $req->firstname;
        $guardian->Sname = $req->secondname;
        $guardian->Lname = $req->lastname;
       // $guardian->Active = $req->active;
        $guardian->Parent_Guardian = $req->parent_guardian;
        $guardian->Students = $req->admsions;
        $guardian->Phone = $req->phone;
        $username = $req->phone.'@'.$maxid;
        $guardian->username = $username;
        $guardian->Email = $req->email;
        $guardian->Gender = $req->gender;

        if ($req->altphone == null) {
            
        } else{
            $guardian->AltPhone = $req->altphone;
        }
        if ($req->password) {
            $guardian->Password = $req->password;  
        } else {
            $guardian->Password = Hash::make('password123');
        }
        
        if ($req->hasFile('file')) {
            $file = $req->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'logo'.'.'.$extension;
            $file->move('images/', $filename);
            $guardian->Profile = $filename;
        }

        $schooldetails = School_Data::find($req->sid);

        //Inform by SMS Start
        $curl = curl_init();

        $post_data = [
            "mobile" => $req->phone,
            "response_type" => "json",
            "sender_name" => "23107",
            "service_id" => 0,
            "message" => "You have been registered as a parent at ".$schooldetails['name'].". Username is ".$username.", and password is password123. Click https://www.shuleyetu.co.ke/parentlogin to log in"
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


        $guardian->save();
        return response()->json([
            'status' => 200,
            'messages' => 'Parent Registered Successfully'
        ]);
    }
    }

    //Fetch Parents
    public function fetchParents($sid){
        $parents = Guardian::where('deleted',0)
                        ->where('sid',$sid)
                        ->OrderbyDesc('id')
                        ->get();
        return response()->json([
            'parents' => $parents
        ]);
    }
    //generate parents pdf
    public function parentsPDF(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = DB::table('school__data')->max('id');
            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
            ];
    
            return view('adminFiles.pdf',$data);
        } else {
            return redirect('/parentlogin');
        } 
    }

    public function downloadTranscript(){
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];

        $pdf = PDF::loadView('adminFiles.pdf',$data);
        Storage::put('public/pdf/parents.pdf', $pdf->output());
        return $pdf->download('parents.pdf');
    }
    //Function to fetch one parent
    public function fetchParent($id){
        $parent = Guardian::find($id);
        return response()->json([
            'parent' => $parent
        ]);
    }

    //Function to update parent details
    public function editParent(Request $req){
        $maxid = session()->get('schooldetails.id');

        if ($req->editemail) {
            $validator = Validator::make($req->all(),[
                'editfname' => 'required',
                //'editsname' => 'required',
                'editlname' => 'required',
                'editphone' => 'required',
                //'altphone' => 'unique:guardians',
                'editemail' => 'email',
                'admsions' => 'required',
                'editprofile' => 'image'
            ],
        [
            'admsions.required' => 'Please Match Parent With Their Child/Children',
            'editemail.email' => 'The Email You entered must be valid',
            'editprofile.image' => 'The file you use for profile must be a valid image'
        ]);
        } else {
            $validator = Validator::make($req->all(),[
                'editfname' => 'required',
                //'editsname' => 'required',
                'editlname' => 'required',
                'editphone' => 'required',
                //'altphone' => 'unique:guardians',
                //'editemail' => 'email',
                'admsions' => 'required',
                'editprofile' => 'image'
            ],
        [
            'admsions.required' => 'Please Match Parent With Their Child/Children',
            //'editemail.email' => 'The Email You entered must be valid',
            'editprofile.image' => 'The file you use for profile must be a valid image'
        ]);
        }
        
    if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
    } else {
        $students = explode(',',$req->admsions);
        // for ($i=0; $i < count($students); $i++) { 
        //     $student = Student::where('UPI',$students[$i])
        //                 ->orWhere('AdmissionNo',$students[$i])
        //                 ->update(['parentinfo' => $req->editfname.','.$req->editlname.','.$req->editpargurd.','.$req->editphone.','.$req->editemail]);
        // }

        $students = explode(',',$req->admsions);
        $student = Student::whereIn('UPI', $students)->orWhereIn('AdmissionNo', $students)->update(['parentinfo' => $req->editfname.','.$req->editlname.','.$req->editpargurd.','.$req->editphone.','.$req->editemail]);


        $guardian = Guardian::find($req->editid);
        $guardian->Fname = $req->editfname;
        $guardian->Sname = $req->editsname;
        $guardian->Lname = $req->editlname;
       // $guardian->Active = $req->active;
        $guardian->Parent_Guardian = $req->editpargurd;
        $guardian->Students = $req->admsions;
        $guardian->Phone = $req->editphone;
        $username = $req->editphone.'@'.$maxid;
        $guardian->username = $username;
        $guardian->Email = $req->editemail;
        $guardian->Gender = $req->editgender;

        if ($req->altphone == null) {
            
        } else{
            $guardian->AltPhone = $req->editaltphone;
        }
        if ($req->password) {
            $guardian->Password = $req->password;  
        }
        
        if ($req->hasFile('editprofile')) {
            $file = $req->file('editprofile');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'logo'.'.'.$extension;
            $file->move('images/', $filename);
            $guardian->Profile = $filename;
        }

        $guardian->save();
        return response()->json([
            'status' => 200,
            'messages' => 'Parent Information updated Successfully'
        ]);
    }  
    }
    //Function to deactivate teachers account
    public function deactivateParent($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $parent = Guardian::find($idarray[$i]);
            $parent->Active = 'No';
            $parent->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => 'Parent account deactivated Successfullly'
        ]);
    }
    //Function to activate parent parents account
    public function activateParent($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $parent = Guardian::find($idarray[$i]);
            $parent->Active = 'Yes';
            $parent->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => "Parent's Account activated Successfullly"
        ]);
    }
    //Function to delete a parent
    public function deleteParent($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $teacher = Guardian::find($idarray[$i]);
            $teacher->deleted = '1';
            $teacher->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => count($idarray).' Parent(s) deleted Successfullly'
        ]);
    }
    //Parent Login view 
    public function loginview(){
        $data = [
            'schools' => School_Data::all()
        ];
        return view('Parents.parentlogin',$data);
    }
    //Parent Login
    public function loginParent(Request $request){
        $validator = Validator::make($request->all(),[
            //'school' => 'required',
            'username' => 'required|max:100',
            'password' => 'required'
        ],
        [
            //'school.required' => 'You must Select your School To Login',
            'username.required' => 'You must Enter your Username to Log In',
            'password.required' => 'You must Enter Password to Log In'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            //$school = School_Data::where('id',$request->school)->first();
            $parent = Guardian::where('username',$request->username)
                            //->where('sid',$request->school)
                            ->first();

         if ($parent) {
            if (Hash::check($request->password, $parent->Password)) {
                // $currentuserschool = [
                //     'schooldetails' => $school,
                //     'LoggedInUser' => $parent
                // ];
                if ($parent['Active'] === "No") {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'Sorry! Your account has been disabled and therefore you cannot log in to system. Please contact your system administrator.'
                    ]);
                } else {
                    $sid = explode("@",$request->username)[1];
                    $school = School_Data::find($sid);
                    $request->session()->put('LoggedInUser',$parent);
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
                    'messages' => 'No Parent with such Username Registered'
            ]);
            }           
            
        }
    }

    //Parent Dashboard
    public function parentDashboard(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $uid = session()->get('LoggedInUser.id');
        $maxid = session()->get('schooldetails.id');

        $notices = notifications::where('sid',$maxid)
                    ->where('type','noticeboard')
                    ->where('group','Parents')
                    ->where('deleted',0)
                    ->orderByDesc('id')
                    ->get();

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
                    ->get();
        
        $parentstudents = Guardian::find($uid);

        $fnames = [];
        $lnames = [];
        $profiles = [];
        $classes = [];
        $ids = [];

        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                                ->orWhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                ->get();
            array_push($fnames,$student[0]['Fname']);
            array_push($lnames,$student[0]['Lname']);
            array_push($profiles,$student[0]['profile']);
            array_push($classes,$student[0]['current_class']);
            array_push($ids,$student[0]['id']);
        }

        $data = [
            "students" => $parentstudents['Students'],
            "fnames" => $fnames,
            "lnames" => $lnames,
            "profiles" => $profiles,
            "classes" => $classes,
            "ids" => $ids,
            "notices" => $notices,
            "mymessages" => $mymessages,
            "notifications" => $notifications 
        ];

        return view('Parents.dashboard',$data);
        } else {
            return redirect('/parentlogin');
        }
    }

    //Function to return profile page
    public function parentProfile() {
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
                                        ->get();
                            
            $parentstudents = Guardian::find($uid);
                                    
            $fnames = [];
            $lnames = [];
            $profiles = [];
            $classes = [];
            $ids = [];
                                    
            for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
                $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                                ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                ->get();
                array_push($fnames,$student[0]['Fname']);
                array_push($lnames,$student[0]['Lname']);
                array_push($profiles,$student[0]['profile']);
                array_push($classes,$student[0]['current_class']);
                array_push($ids,$student[0]['id']);
                }
        
                $data = [
                    'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                    'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                    'notices' => $notices,
                    'fnames' => $fnames,
                    'mymessages' => $mymessages,
                    'notifications' => $notifications
                ];
        
                return view('Parents.profile',$data);
            } else {
                return redirect('/parentlogin');
            }
        //$maxid = DB::table('school__data')->max('id');
    }

    //function for returning fee structure
    public function feeStructure(){
        if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
            $maxid = session()->get('schooldetails.id');
            $classes = classes::where('sid',$maxid)
                                ->get();
    
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
                                    ->get();
                                
                $parentstudents = Guardian::find($uid);
                                        
                $fnames = [];
                $lnames = [];
                $profiles = [];
                //$classes = [];
                $ids = [];
                                        
                for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
                    $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                                       ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                        ->get();
                    array_push($fnames,$student[0]['Fname']);
                    array_push($lnames,$student[0]['Lname']);
                    array_push($profiles,$student[0]['profile']);
                    //array_push($classes,$student[0]['current_class']);
                    array_push($ids,$student[0]['id']);
                    }
    
            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'classes' => $classes,
                'fnames' => $fnames,
                'notices' => $notices,
                'mymessages' => $mymessages,
                'notifications' => $notifications
            ];
    
            return view('Parents.feestructure',$data);
        } else {
            return redirect('/parentlogin');
        }
        //$maxid = DB::table('school__data')->max('id');
    }

    //Function to update Profile pic
    public function updateprofilepic(Request $request) {
        if ($request->hasFile('profilepic')) {
            $file = $request->file('profilepic');

                $validator = Validator::make($request->all(),[
                    'profilepic' => 'required',
                    'profilepic' => 'image'
                ],
                [
                    'profilepic.required' => 'You must select an image to upload',
                    'profilepic.image' => 'The file you are using for profile must be an image'
                ]);
            
                if ($validator->fails()) {
                    return response()->json([
                        'status' => 400,
                        'messages' => $validator->getMessageBag()
                    ]);
                } else {
                    $staff = Guardian::find($request->uid); 
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'pro'.'.'.$extension;
                    $file->move('images/', $filename);
                    $staff->Profile = $filename;

                    $staff->save();
                    

                    return response()->json([
                        'status' => 200,
                        'messages' => "You have Successfully updated your profile picture"
                    ]);

                    }
                } else {
                        return response()->json([
                            'status' => 401,
                            'messages' => 'You must select an image to upload'
                        ]);
                }
    
}

//Return Messaging View
public function messaging () {
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
          
    $maxid = session()->get('schooldetails.id');
    $staffs = Staff::where('sid',$maxid)
                    ->get();

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
                                ->get();
                    
    $parentstudents = Guardian::find($uid);
                            
    $fnames = [];
    $lnames = [];
    $profiles = [];
    $classes = [];
    $ids = [];
                            
    for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
        $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                           ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                            ->get();
        array_push($fnames,$student[0]['Fname']);
        array_push($lnames,$student[0]['Lname']);
        array_push($profiles,$student[0]['profile']);
        array_push($classes,$student[0]['current_class']);
        array_push($ids,$student[0]['id']);
        }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'staffs' => $staffs,
            'notices' => $notices,
            'fnames' => $fnames,
            'mymessages' => $mymessages,
            'notifications' => $notifications
        ];

        return view('Parents.sendmesage',$data);
    } else {
        return redirect('/parentlogin');
    }
}

//Function to return fee payment div
public function feePayment () {
    if (session()->has('schooldetails') && session()->has('LoggedInUser')) {
        $maxid = session()->get('schooldetails.id');
        $staffs = Staff::where('sid',$maxid)
                        ->get();
    
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
                                    ->get();
                        
        $parentstudents = Guardian::find($uid);
                                
        $fnames = [];
        $lnames = [];
        $profiles = [];
        $classes = [];
        $ids = [];
                                
        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                               ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                ->get();
            array_push($fnames,$student[0]['Fname']);
            array_push($lnames,$student[0]['Lname']);
            array_push($profiles,$student[0]['profile']);
            array_push($classes,$student[0]['current_class']);
            array_push($ids,$student[0]['id']);
            }
    
            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'staffs' => $staffs,
                'notices' => $notices,
                'fnames' => $fnames,
                'mymessages' => $mymessages,
                'notifications' => $notifications
            ];
    
            return view('Parents.feepayment',$data);
    } else {
        return redirect('/parentlogin');
    }
}

//Update real details
public function updateprofileDetails (Request $request) {
    $maxid = session()->get('schooldetails.id');

    $validator = Validator::make($request->all(),[
        'fname' => 'required',
        'lname' => 'required',
        'phone' => 'required',
        'email' => 'email|required',
        'gender' => 'required',  
       ],[
        'fname.required' => 'First Name is required',
        'lname.required' => 'Last Name is required',
        'gender.required' => 'Gender of the teacher is required',
        'email.required' => 'Email is required',
        'email.email' => 'Email must be a valid email'
       ]);

       if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
       } else {
            $staff = Guardian::find($request->uid);
            $staff->Fname = $request->fname;
            $staff->Lname = $request->lname;
            $staff->Gender = $request->gender;
            $staff->Email = $request->email;
            $staff->Phone = $request->phone;
            $username = $request->phone.'@'.$maxid;
            $staff->username = $username;
            $staff->save();
            return response()->json([
                'status' => 200,
                'messages' => "You have Successfully Updated Your Account Details. Log in Again to see the Changes" 
            ]);
       }
}

//Update Password 
public function updatePassword(Request $request){
    $validator = Validator::make($request->all(),[
        'cpass' => 'required',
        'npass' => 'required',
        'cnpass' => 'required',
       ],[
        'cpass.required' => 'Current Password is Required',
        'npass.required' => 'Your New Password is Required',
        'cnpass.required' => 'You Must Confirm Your New Password'
       ]);
       
       if ($validator->fails()) {
        return response()->json([
            'status' => 400,
            'messages' => $validator->getMessageBag()
        ]);
        } else {
           $staff = Guardian::find($request->uid);
           if (Hash::check($request->cpass, $staff->Password)) {
            $staff->Password = Hash::make($request->npass);
            $staff->save();
            return response()->json([
                'status' => 200,
                'messages' => 'You have Successfully Updated your Password'
            ]);
           } else {
            return response()->json([
                'status' => 401,
                'messages' => 'Sorry. This is not your current password.'
            ]);
           }  
        }
}

//Function to return notice board view
public function noticeBoard(){
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
                                    ->get();
                        
        $parentstudents = Guardian::find($uid);
                
        $fnames = [];
        $lnames = [];
        $profiles = [];
        $classes = [];
        $ids = [];
                
        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                              ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                            ->get();
            array_push($fnames,$student[0]['Fname']);
            array_push($lnames,$student[0]['Lname']);
            array_push($profiles,$student[0]['profile']);
            array_push($classes,$student[0]['current_class']);
            array_push($ids,$student[0]['id']);
            }
    
            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'notices' => $notices,
                'fnames' => $fnames,
                'mymessages' => $mymessages,
                'notifications' => $notifications
            ];
    
            return view('Parents.noticeboard',$data);
    } else {
        return redirect('/parentlogin');
    }  
}

//Function to return reset-password div
public function resetPasswordview() {
    return view('Parents.parentforgotpass');
}

//Function to reset password
public function parentresetPassword(Request $request) {
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
        
        $parent = Guardian::where('Phone',$request->phoneno)
                        ->orWhere('AltPhone',$request->phoneno)
                        ->get();

        //return ['data' => $parent];
        
        if (count($parent) == 0) {
            return response()->json([
                'status' => 401,
                'messages' => "Sorry! No account registered with this phone number"
            ]);
        } else {
            return [
                'status' => 200,
                'username' => $parent[0]['username'],
                'password' => $parent[0]['password'],
                'id' => $parent[0]['id'] 
            ];
        }
        
    } 
}

 //Set new password
 public function parentsetnewPass(Request $request) {
    //return ['data' => $request->all()];
    $staff = Guardian::find($request->uid);
    $staff->password = Hash::make($request->npass);
    $staff->save();

    return response()->json([
        'status' => 200,
        'password' => $request->npass,
        'username' => $request->username
    ]);

}

//My Send Messages 
public function myMessages() {
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
                
        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                              ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                ->get();
            array_push($fnames,$student[0]['Fname']);
            array_push($lnames,$student[0]['Lname']);
            array_push($profiles,$student[0]['profile']);
            array_push($classes,$student[0]['current_class']);
            array_push($ids,$student[0]['id']);
            }
    
            $data = [
                'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
                'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
                'notices' => $notices,
                'fnames' => $fnames,
                'mymessages' => $mymessages,
                'notifications' => $notifications
            ];
    
            return view('Parents.mymessages',$data);
    } else {
        return redirect('/parentlogin');
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
                
        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                              ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                ->get();
            array_push($fnames,$student[0]['Fname']);
            array_push($lnames,$student[0]['Lname']);
            array_push($profiles,$student[0]['profile']);
            array_push($classes,$student[0]['current_class']);
            array_push($ids,$student[0]['id']);
            }
    
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
    
            return view('Parents.cbcstudentperfomance',$data);
    } else {
        return redirect('/parentlogin');
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
            
    for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
        $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                          ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                            ->get();
        array_push($fnames,$student[0]['Fname']);
        array_push($lnames,$student[0]['Lname']);
        array_push($profiles,$student[0]['profile']);
        array_push($classes,$student[0]['current_class']);
        array_push($ids,$student[0]['id']);
        }

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

        return view('Parents.studentperfomance',$data);
    } else {
        return redirect('/parentlogin');
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
                
        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                              ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                ->get();
            array_push($fnames,$student[0]['Fname']);
            array_push($lnames,$student[0]['Lname']);
            array_push($profiles,$student[0]['profile']);
            array_push($classes,$student[0]['current_class']);
            array_push($ids,$student[0]['id']);
            }
    
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
    
        return view('Parents.subjectperfomance',$data);
    } else {
        return redirect('/parentlogin');
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
            
    for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
        $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                          ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                            ->get();
        array_push($fnames,$student[0]['Fname']);
        array_push($lnames,$student[0]['Lname']);
        array_push($profiles,$student[0]['profile']);
        array_push($classes,$student[0]['current_class']);
        array_push($ids,$student[0]['id']);
        }

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

        return view('Parents.studentdetails',$data);
    } else {
        return redirect('/parentlogin');
    } 
}

//Function to return fee payment history
public function feeHistory($stuid) {
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
                
        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                              ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                                ->get();
            array_push($fnames,$student[0]['Fname']);
            array_push($lnames,$student[0]['Lname']);
            array_push($profiles,$student[0]['profile']);
            array_push($classes,$student[0]['current_class']);
            array_push($ids,$student[0]['id']);
            }
    
        $student = Student::find($stuid);
        $feepayments = feepayment::where('AdmorUPI',$student['AdmissionNo'])
                                  //->where('sid',$sid)
                                  ->orWhere('AdmorUPI',$student['UPI'])
                                  ->OrderByDesc('created_at')
                                  ->get();
    
        $payments = [];
    
        foreach ($feepayments as $feepayment) {
            array_push($payments,$feepayment['amount']);
        }
    
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'notices' => $notices,
            'fnames' => $fnames,
            'mymessages' => $mymessages,
            'notifications' => $notifications,
            'student' => $student,
            'totalpayments' => array_sum($payments),
            'feepayments' => $feepayments
        ];
    
        return view('Parents.feeinformation',$data);
    } else {
        return redirect('/parentlogin');
    }
}

//Function to return notifications 
public function notifications(){
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
                                ->get();
                    
    $parentstudents = Guardian::find($uid);
            
    $fnames = [];
    $lnames = [];
    $profiles = [];
    $classes = [];
    $ids = [];
            
    for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
        $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
                           ->orwhere('AdmissionNo',explode(",",$parentstudents['Students'])[$i])
                           ->get();
        array_push($fnames,$student[0]['Fname']);
        array_push($lnames,$student[0]['Lname']);
        array_push($profiles,$student[0]['profile']);
        array_push($classes,$student[0]['current_class']);
        array_push($ids,$student[0]['id']);
        }

        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'notices' => $notices,
            'fnames' => $fnames,
            'mymessages' => $mymessages,
            'notifications' => $notifications
        ];

        return view('Parents.notifications',$data);
    } else {
        return redirect('/parentlogin');
    }     
}

}
