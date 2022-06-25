<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Regrequest;

class RegrequestController extends Controller
{
    //Function To Register Request
    public function registerrequest(Request $req){
        $validator = Validator::make($req->all(),[
            'srfullname' => 'required',
            'srpnumber' => 'required',
            'srsname' => 'required',
            'srcounty' => 'required',
        ],
        [
            'srfullname.required' => 'Please Tell us your Name',
            'srpnumber.required' => 'Please Specify Your Phone Number. We will use it to reach back to you',
            'srsname.required' => 'Please Tell us the Name of your school',
            'srcounty.required' => 'Please Tell us where your school is located',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->messages()
            ]);
        } else {
            $regreq = new Regrequest;
            $regreq->RequestedBy = $req->srfullname;
            $regreq->phoneno = $req->srpnumber;
            $regreq->nameofSchool = $req->srsname;
            $regreq->CountyLocated = $req->srcounty;

            $regreq->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Your School Registration Request has been submitted successfully. Our Team will reach back to you. Thank you.'
            ]);
        }
    }
}
