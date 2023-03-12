<?php

namespace App\Http\Controllers;
use App\Models\classes;
use App\Models\hostels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class HostelsController extends Controller
{
    //Function to register hostel
    public function saveHostel(Request $req){
        $validator = Validator::make($req->all(),[
            'hostel' => 'required',
        ],
    [
        'hostel.required' => 'You must enter the name of hostel or domitory to register',
    ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $checkhostel = hostels::where('sid',$req->sid)
                                ->where('Name',$req->hostel)
                                ->get();

            if (count($checkhostel) > 0) {
                return response()->json([
                    'status' => 'available',
                    'messages' => 'A hostel with similar name has already been registered'
                ]);
            } else {
                $hostel = new hostels;
                $hostel->sid = $req->sid;
                $hostel->Name = $req->hostel;
                $hostel->save();
                return response()->json([
                    'status' => 200,
                    'messages' => 'New Hostel registered successfully'
                ]);
        }
    }

    }

    //Function to edit class
    public function editHostel(Request $req){
        $validator = Validator::make($req->all(),[
            'edithostelname' => 'required',
        ],
        [
            'edithostelname.required' => 'You must include the name of the hostel'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $hostel = hostels::find($req->edithostelid);
            $hostel->Name = $req->edithostelname;
            $hostel->save();

            return response()->json([
                'status' => 200,
                'messages' => 'Hostel Edited Successfully'
            ]);
        }
    }

    //Function to delete class
    public function deleteHostels($ids){
        $idarray = explode(',',$ids);
        for ($i=0; $i < count($idarray) ; $i++) { 
            $hostel = hostels::find($idarray[$i]);
            $hostel->deleted = '1';
            $hostel->save(); 
        }

        return response()->json([
            'status' => 200,
            'messages' => 'Class deleted Successfullly'
        ]);
    }

     //Fetch classes
     public function fetchHostels($sid){
        $hostels = hostels::where('sid',$sid)
                            ->where('Deleted',0)
                            ->OrderByDesc('id')
                            ->get();
        
        return response()->json([
            'hostels' => $hostels
        ]); 
    }

    //Function to fetch details of one class
    public function getHostel($id){
        $hostel = hostels::find($id);
        return response()->json([
            'hostel' => $hostel
        ]);
    }
}
