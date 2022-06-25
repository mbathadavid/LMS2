<?php

namespace App\Http\Controllers;
use PDF;
use App\Models\Admin;
use App\Models\School_Data;
use Illuminate\Support\Facades\DB;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
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
            $student = Student::where('AdmissionNo',$students[$i])
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
            $student = Student::where('AdmissionNo',$students[$i])
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
}
