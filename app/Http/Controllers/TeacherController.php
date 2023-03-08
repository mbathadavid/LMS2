<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Excel;
use App\Exports\TeacherExport;
use App\Exports\TeachertemplateExport;
use App\Imports\TeacherImport;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\School_Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    //
    public function saveTeacher(Request $request){
        $maxid = session()->get('schooldetails.id');

       $validator = Validator::make($request->all(),[
        'salutation' => 'required',
        'firstname' => 'required',
        'lastname' => 'required',
        'phone' => 'required|unique:staff',
        'email' => 'email|unique:staff',
        'position' => 'required',
        'gender' => 'required',
        'file' => 'image'
       ]); 

       if ($validator->fails()) {
           return response()->json([
               'status' => 400,
               'messages' => $validator->getMessageBag()
           ]);
       } else {
           $teacher = new Staff;
           $teacher->sid = $request->sid;
           $teacher->salutation = $request->salutation;
           $teacher->Fname = $request->firstname;
           //$teacher->Sname = $request->secondname;
           $teacher->Lname = $request->lastname;
           $teacher->Gender = $request->gender;
           $teacher->Position = $request->position;
           $teacher->Role = $request->role;
           $teacher->Email = $request->email;
           $teacher->Phone = $request->phone;
           $username = $request->phone.'@'.$maxid;
           $teacher->username = $username;
           $teacher->password = Hash::make('password123');
                       
           if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'pro'.'.'.$extension;
            $file->move('images/', $filename);
            $teacher->Profile = $filename;
           } else {
               $teacher->Profile = 'avatar.png';
           }
           $teacher->save();

           $schooldetails = School_Data::find($request->sid);

        //Inform by SMS Start
            $curl = curl_init();

            $post_data = [
                "mobile" => $request->phone,
                "response_type" => "json",
                "sender_name" => "23107",
                "service_id" => 0,
                "message" => "You have been registered as a staff member for ".$schooldetails['name'].". Username is ".$username.", and password is password123. Click https://www.shuleyetu.co.ke/adminlogin to log in"
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
         //    Inform by SMS Start

           return response()->json([
               'status' => 200,
               'messages' => $request->role."'s records registered successfully. They can use their Phone Number Or Email and Password as password123", 
           ]);
       }
       
    }
    //fetch teachers
    public function fetchteachers($sid,$uid,$stype){
      $teachers = Staff::where('deleted',0)
                        ->where('Role',$stype)
                        ->where('sid',$sid)
                        // ->whereNotIn('id',$uid)
                        ->where('id','!=',$uid)
                        ->OrderByDesc('id')
                        ->get();
      return response()->json([
          'teachers' => $teachers
      ]);  
    }
    //Fetch class teachers
    public function classTeachers($sid,$utype){
        $teachers = Staff::where('deleted',0)
                        ->where('sid',$sid)
                        // ->whereNotIn('id',$uid)
                        ->where('Role','!=',$utype)
                        ->get();
        return response()->json([
          'teachers' => $teachers
      ]); 
    }
    //Export Teachers
    public function exportTeachers(){
        return Excel::download(new TeacherExport,'teachers.xlsx');
    }
    //Show teacherr export Excel view
    public function excelimportview(){
        return view('General.teachersexcelview');
    }
    //Import Teachers to the database
    public function importTeachers(Request $req){
        $validator = Validator::make($req->all(),[
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            Excel::import(new TeacherImport,$req->file);
            return response()->json([
                'status' => 200,
                'messages' => 'Teachers Imported Successfully'
            ]);
        }
    }
    //make the teacher import excel sheet
    public function teachersImportTemplate(){
        return Excel::download(new TeachertemplateExport,'teacherstemplate.xlsx');
    }
    //Function to fetch one teacher
    public function getTeacher($id){
        $teacher = Staff::find($id);
        // $teacher = Staff::where('id',$teacher['id'])
        //             ->where('Role','Teacher')
        //             ->where('sid',$sid)
        //             ->get();
        return response()->json([
            'teacher' => $teacher
        ]);
    }
    //Function to assign priviledges
    public function assignpriviledges(Request $request){
        $validator = Validator::make($request->all(),[
            'priviledges' => 'required'
        ],
        [
            'priviledges.required' => 'Make sure you select some priviledges to assign to this teacher.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $teacherpriviledge = Staff::find($request->staffid);
            $teacherpriviledge->priviledges = $request->priviledges;
            
            $teacherpriviledge->save();
               return response()->json([
                   'status' => 200,
                   'messages' => "Priviledges Assigned successfully" 
               ]);

        }

    }


    //Function to edit Teachers
    public function editTeacher(Request $request){
        $maxid = session()->get('schooldetails.id');

        $validator = Validator::make($request->all(),[
            'editsalutation' => 'required',
            'editfname' => 'required',
            'editlname' => 'required',
            //'phone' => 'required|unique:teachers',
            //'email' => 'email|unique:teachers',
            'editposition' => 'required',
            'editgender' => 'required',
            'editprofile' => 'image'
           ],
        [
            'editsalutation.required' => 'Salutation is required',
            'editfname.required' => 'First Name is required',
            'editlname.required' => 'Last Name is required',
            'editposition.required' => 'Position for the teacher is required',
            'editgender.required' => 'Gender of the teacher is required',
            'editprofile.image' => 'The file you are using for profile must be an image'
        ]); 
    
           if ($validator->fails()) {
               return response()->json([
                   'status' => 400,
                   'messages' => $validator->getMessageBag()
               ]);
           } else {
               $teacher = Staff::find($request->editid);
               $teacher->Salutation = $request->editsalutation;
               $teacher->Fname = $request->editfname;
               //$teacher->Sname = $request->editsname;
               $teacher->Lname = $request->editlname;
               $teacher->Gender = $request->editgender;
               $teacher->Position = $request->editposition;
               $teacher->Email = $request->editemail;
               $teacher->Phone = $request->editpno;
               $teacher->username = $request->editpno.'@'.$maxid;
               //$teacher->password = 'password123';
                           
               if ($request->hasFile('editprofile')) {
                $file = $request->file('editprofile');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'pro'.'.'.$extension;
                $file->move('images/', $filename);
                $teacher->Profile = $filename;
               } 
               $teacher->save();
               return response()->json([
                   'status' => 200,
                   'messages' => $request->editrole."'s records Updated successfully" 
               ]);
           }  
    }
    //Function to delete teacher
    public function deleteTeacher($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $teacher = Staff::find($idarray[$i]);
            $teacher->deleted = '1';
            $teacher->save(); 
        }
    return response()->json([
        'status' => 200,
        'messages' => count($idarray).' Account deleted Successfullly'
    ]);
    }
    //Function to deactivate teacher
    public function deactivateTeacher($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $teacher = Staff::find($idarray[$i]);
            $teacher->Active = 'No';
            $teacher->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => "Account activated Successfullly"
        ]); 
    }
    //Function to activate Teacher account
    public function activateTeacher($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $teacher = Staff::find($idarray[$i]);
            $teacher->Active = 'Yes';
            $teacher->save(); 
        }
        return response()->json([
        'status' => 200,
        'messages' => "Account activated Successfullly"
        ]);
    }

    //Function to update profile picture
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
                        $staff = Staff::find($request->uid); 
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
    //Update profile Details 
    public function updateprofileDetails (Request $request) {
        $maxid = session()->get('schooldetails.id');

        $validator = Validator::make($request->all(),[
            'editsalutation' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'phone' => 'required',
            'email' => 'email|required',
            'gender' => 'required',  
           ],[
            'editsalutation.required' => 'Salutation is required',
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
                $staff = Staff::find($request->uid);
                $staff->Salutation = $request->editsalutation;
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

    //Change Password
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
               $staff = Staff::find($request->uid);
               if (Hash::check($request->cpass, $staff->password)) {
                $staff->password = Hash::make($request->npass);
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

    //Set new password
    public function adminsetnewPass(Request $request) {
        //return ['data' => $request->all()];
        $staff = Staff::find($request->uid);
        $staff->password = Hash::make($request->npass);
        $staff->save();

        return response()->json([
            'status' => 200,
            'password' => $request->npass,
            'username' => $request->username
        ]);

    }
}
