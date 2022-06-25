<?php

namespace App\Http\Controllers;

use App\Models\School_Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolDataController extends Controller
{
    //
    public function index(){
        return view('school.scrform2');
    }

    //Register School
    public function saveSchool(Request $req){
        $validator = Validator::make($req->all(),[
            'schoolname' => 'required',
            'motto' => 'required',
            'schoollevel' => 'required',
            'county' => 'required',
            'subcounty' => 'required',
            'semail' => 'required|email',
            'primaryphone' => 'required',
            'altphone' => 'required',
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
            $school->logo = $req->logo;

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
}
