<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Admin;
use App\Models\School_Data;
use Illuminate\Support\Facades\DB;
use App\Models\Guardian;
use App\Models\Student;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    //Register parent
    public function registerParent(Request $req){
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
        $students = explode(',',$req->admsions);
        for ($i=0; $i < count($students); $i++) { 
            $student = Student::where('UPI',$students[$i])
                        ->update(['parentinfo' => $req->firstname.','.$req->lastname.','.$req->parent_guardian.','.$req->phone.','.$req->email]);
        }

        $guardian = new Guardian;
        $guardian->sid = $req->sid;
        $guardian->Fname = $req->firstname;
        $guardian->Sname = $req->secondname;
        $guardian->Lname = $req->lastname;
       // $guardian->Active = $req->active;
        $guardian->Parent_Guardian = $req->parent_guardian;
        $guardian->Students = $req->admsions;
        $guardian->Phone = $req->phone;
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
        $maxid = DB::table('school__data')->max('id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];

        return view('adminFiles.pdf',$data); 
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
        for ($i=0; $i < count($students); $i++) { 
            $student = Student::where('UPI',$students[$i])
                        ->update(['parentinfo' => $req->editfname.','.$req->editlname.','.$req->editpargurd.','.$req->editphone.','.$req->editemail]);
        }

        $guardian = Guardian::find($req->editid);
        $guardian->Fname = $req->editfname;
        $guardian->Sname = $req->editsname;
        $guardian->Lname = $req->editlname;
       // $guardian->Active = $req->active;
        $guardian->Parent_Guardian = $req->editpargurd;
        $guardian->Students = $req->admsions;
        $guardian->Phone = $req->editphone;
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
            'school' => 'required',
            'emailorphone' => 'required|max:100',
            'password' => 'required|min:6|max:50'
        ],
        [
            'school.required' => 'You must Select your School To Login',
            'emailorphone.required' => 'You must Enter your Phone Number to Log In',
            'password.required' => 'You must Enter Password to Log In'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $school = School_Data::where('id',$request->school)->first();
            $parent = Guardian::where('Phone',$request->emailorphone)
                            ->where('sid',$request->school)
                            ->first();

         if ($parent) {
            if (Hash::check($request->password, $parent->Password)) {
                $currentuserschool = [
                    'schooldetails' => $school,
                    'LoggedInUser' => $parent
                ];
                if ($parent['Active'] === "No") {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'Sorry! Your account has been disabled and therefore you cannot log in to system. Please contact your system administrator.'
                    ]);
                } else {
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
                    'messages' => 'No Parent with such Phone Number Registered for '.$school['name']
                ]);
            }           
            
        }
    }

    //Parent Dashboard
    public function parentDashboard(){
        $uid = session()->get('LoggedInUser.id');
        
        $parentstudents = Guardian::find($uid);

        $fnames = [];
        $lnames = [];
        $profiles = [];
        $classes = [];
        $ids = [];

        for ($i=0; $i < count(explode(",",$parentstudents['Students'])); $i++) { 
            $student = Student::where('UPI',explode(",",$parentstudents['Students'])[$i])
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
            "ids" => $ids 
        ];

        return view('Parents.dashboard',$data);
    }

    //Functin to return profile page
    public function parentProfile(){
        //$maxid = DB::table('school__data')->max('id');
        $maxid = session()->get('schooldetails.id');
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first()
        ];

        return view('Parents.profile',$data);
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
    $maxid = session()->get('schooldetails.id');
    $staffs = Staff::where('sid',$maxid)
                    ->get();
        $data = [
            'adminInfo' => DB::table('admins')->where('id', session('LoggedInUser'))->first(),
            'schoolinfo' => DB::table('school__data')->where('id',$maxid)->first(),
            'staffs' => $staffs
        ];

        return view('Parents.sendmesage',$data);
}

//Update real details
public function updateprofileDetails (Request $request) {
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

}
