<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Feestructure;
use App\Models\Staff;
use App\Models\classes;


class FeestructureController extends Controller
{
    //Create a fee structure
    public function createFeeStructure(Request $req) {
        $validator = Validator::make($req->all(),[
            'term' => 'required',
            'classes' => 'required',
            'modules' => 'required',
            'amounts' => 'required'
        ],
        [
            'term.required' => 'You must select term',
            'classes.required' => 'You must select classes from the table above for which the fee structure shall apply',
            'modules.required' => 'The Module field cannot be empty',
            'amounts.required' => 'The Amount field cannot be empty'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $modules = array_filter(explode(',',$req->modules));
            $amounts = array_filter(explode(',',$req->amounts));

            if (count($modules) != count($amounts)) {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Fee modules and Amounts mismatch. Make sure that you provide fee amounts for each module'
                ]);
            } else {
                $checkpriorreg = Feestructure::where('Term',$req->term)
                                            ->where('deleted',0)
                                            ->get();

                $postedclasses = explode(',',$req->classes);

                $classids = [];
                $classname = [];
                $availableclasses = [];

                for ($i=0; $i < count($checkpriorreg); $i++) { 
                    array_push($classids,$checkpriorreg[$i]['classes']);
                    array_push($classname,$checkpriorreg[$i]['classnames']);
                }


                for ($i=0; $i < count($postedclasses); $i++) { 
                    if (in_array($postedclasses[$i],$classids)) {
                        array_push($availableclasses,$classname[$i]);
                    }
                }

                // return ['data' => count($availableclasses)];]

                if (count($availableclasses) > 0) {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'The Fee Structure for '.implode(',',$availableclasses).' for '.$req->term.' has already been set.' 
                    ]);
                } else {
                    $classids = explode(',',$req->classes);
                    $classnames = [];
    
                        for ($i=0; $i < count($classids); $i++) { 
                            $class = classes::find($classids[$i]);
                            if ($class['stream'] == null) {
                            array_push($classnames,$class['class']);
                            } else {
                            array_push($classnames,$class['class'].' '.$class['stream']);
                            }
                        }
    
                    for ($i=0; $i < count($classids); $i++) {
                        $createdby = Staff::find($req->uid);
                        $fee = new Feestructure;
                        $fee->sid = $req->sid;
                        $fee->Term = $req->term;
                        $fee->classes = $classids[$i];
                        $fee->classnames = $classnames[$i];
                        $fee->modules = $req->modules;
                        $fee->amounts = $req->amounts;
                        $fee->totalamount = array_sum(explode(',',$req->amounts));
                        $fee->cid = $req->uid;
                        $fee->crole = $createdby['Role'];
                        $fee->createdby = $createdby['Fname'].' '.$createdby['Lname'];
    
                        $fee->save();    
                    }
    
                    return response()->json([
                        'status' => 200,
                        'messages' => 'Fee structure created successfully.'
                   ]);  
                }
                                          
            }
            
        }
    } 
    //Fetch fee structure
    public function fetchFeestructures($sid) {
        $feestructures = Feestructure::where('deleted',0)
                        ->where('sid',$sid)
                        ->get();
        return response()->json([
        'feestructures' => $feestructures
    ]);
    }
}
