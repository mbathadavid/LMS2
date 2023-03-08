<?php

namespace App\Http\Controllers;
use App\Models\School_Data;
use App\Models\Staff;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolDataController extends Controller
{
    //Function to return all the schools
    public function Schools() {
        return view('General.schools');
    }

    //Fetch schools
    public function fetchSchools(){
        $schools = School_Data::OrderByDesc('id')
                                ->get();

        return response()->json([
            'schools' => $schools
        ]);
    }

    //Function to Deactivate school
    public function deactivateSchool($id) {
        $school = School_Data::find($id);
        $school->Active = "1";

        $school->save();

        return response()->json([
            'status' => 200,
            'messages' => 'School Deactivated Successfully'
        ]);
    }

    //Function to Deactivate school
    public function activateSchool($id) {
        $school = School_Data::find($id);
        $school->Active = "0";

        $school->save();

        return response()->json([
            'status' => 200,
            'messages' => 'School activated Successfully'
        ]);
    }

    //Fetch School
    public function getSchool($id){
        $school = School_Data::find($id);
        $superadmin = Staff::where('sid',$id)
                            ->where('deleted',0)
                            ->where('Role','Super Admin')
                            ->get();

        $staff = Staff::where('sid',$id)
                        ->get();

        $students = Student::where('sid',$id)
                            ->get(); 

        return response()->json([
            'school' => $school,
            'staff' => count($staff),
            'students' => count($students),
            'superadmin' => $superadmin
        ]);
    }

    //
    public function index(){
        return view('school.scrform2');
    }

    //Register School
    public function saveSchool(Request $req){
        date_default_timezone_set('Africa/Nairobi');

        $validator = Validator::make($req->all(),[
            'schoolname' => 'required',
            'motto' => 'required',
            'schoollevel' => 'required',
            'county' => 'required',
            'subcounty' => 'required',
            'semail' => 'email',
            'primaryphone' => 'required',
            //'altphone' => 'required',
            'pobox' => 'required',
            'town' => 'required',
            'logo'=> 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $school = new School_Data;
            $school->name = $req->schoolname;
            $school->motto = $req->motto;
            $school->level = $req->schoollevel;
            $school->county = $req->county;
            $school->subcounty = $req->subcounty;
            $school->email = $req->semail;
            $school->phone = $req->primaryphone;
            $school->alt_phone = $req->altphone;
            $school->pobox = $req->pobox;
            $school->town = $req->town;
            //$school->logo = $req->logo;

            if ($req->hasFile('logo')) {
                $file = $req->file('logo');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'logo'.'.'.$extension;
                $file->move('images/', $filename);
                $school->logo = $filename;
            }
            $school->save();
            return response()->json([
                'status' => 200,
                'message' => 'School Details Successfully Registered. You are left with one more step,i.e, Registering the Admin who will Register the rest of the System User.'
            ]);
        }
        
    }

    //Function to edit school
    public function editSchool(Request $req){
        date_default_timezone_set('Africa/Nairobi');
        
        $validator = Validator::make($req->all(),[
            'schooleditname' => 'required',
            'editmotto' => 'required',
            'schooleditlevel' => 'required',
            'editcounty' => 'required',
            'editsubcounty' => 'required',
            //'editemail' => 'required|email',
            'editprimaryphone' => 'required',
            //'altphone' => 'required',
            'editpobox' => 'required',
            'edittown' => 'required',
            //'editlogo'=> 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);
        } else {
            $school = School_Data::find($req->schoolid);
            $school->name = $req->schooleditname;
            $school->motto = $req->editmotto;
            $school->level = $req->schooleditlevel;
            $school->county = $req->editcounty;
            $school->subcounty = $req->editsubcounty;
            $school->email = $req->editemail;
            $school->phone = $req->editprimaryphone;
            $school->alt_phone = $req->editaltphone;
            $school->pobox = $req->editpobox;
            $school->town = $req->edittown;
            $school->Darajakey = $req->editdarajakey;
            $school->SMS_KEY = $req->editsmskey;
            $school->Shortcode = $req->editsmsshortcode;
            $school->MPESA_code = $req->editmpesacode;
            $school->typeofmpesacode = $req->edittype;
            $school->schoolaccountnumber = $req->editschoolaccountnumber;
            $school->SMSbalance = $req->editsmswebsitebalance;
            $school->SMSbalanceonwebsite = $req->editsmsapibalance;
            //$school->logo = $req->editlogo; 

            if ($req->hasFile('editlogo')) {
                $file = $req->file('editlogo');
                $extension = $file->getClientOriginalExtension();
                $filename = time().'logo'.'.'.$extension;
                $file->move('images/', $filename);
                $school->logo = $filename;
            }
            $school->save();
            return response()->json([
                'status' => 200,
                'message' => 'School Details Successfully Registered. You are left with one more step,i.e, Registering the Admin who will Register the rest of the System User.'
            ]);
        }
    }

    //Function to Add Alert
    public function addAlert(Request $req) {
        $sids = explode(',',$req->alertschools);

        for($i=0; $i<count($sids); $i++){
            $school = School_Data::find($sids[$i]);
            $school->Alert = $req->alertmessage;
            $school->save();
        }

        return response()->json([
            'status' => 200,
            'messages' => 'Alert Successfully Added'
        ]);
    }

    //Function to remove Alert
    public function removeAlert($sids){
        $sids = explode(',',$sids);

        for($i=0; $i<count($sids); $i++){
            $school = School_Data::find($sids[$i]);
            $school->Alert = NULL;
            $school->save();
        }

        return response()->json([
            'status' => 200,
            'messages' => 'Alert Removed Successfully'
        ]);
    }

}
