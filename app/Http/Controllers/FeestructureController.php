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
                                            ->where('sid',$req->sid)
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
                        $fee->modules = implode(",",$modules);
                        $fee->amounts = implode(",",$amounts);
                        $fee->totalamount = array_sum($amounts);
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

    //Update Fee structure Function 
    public function updateFeeStructure(Request $req) {
       // return ['data' => $req->all()];
       $modules = array_filter($req->editmodule);
       $amount = array_filter($req->editamount);

        if (count($modules) != count($amount)) {
            return response()->json([
                "status" => 401,
                "messages" => "Fee Items and Amounts mismatched"
            ]);
        } else {
            $feestructure = Feestructure::find($req->fid);
            $feestructure->Term = $req->term;
            $feestructure->modules = implode(",",$modules);
            $feestructure->amounts = implode(",",$amount);
            $feestructure->totalamount = array_sum($amount);
            $feestructure->save();

            return response()->json([
                "status" => 200,
                "messages" => "Fee Structure Updated Successfully"
            ]);
        }
        
    }

    //Delete Fee Structure
    public function deleteFeestructure($fids) {
        $idarray = explode(',',$fids);

        for ($k=0; $k < count($idarray); $k++) { 
            $feestructure = Feestructure::where('id',$idarray[$k])
                                        ->delete(); 
        }

        if ($feestructure) {
            return response()->json([
                "status" => 200,
                "messages" => "Feestucture Deleted Successfully"
            ]);
        } else {
            return response()->json([
                "status" => 400,
                "messages" => "An error occured while deleting the Fee Structure"
            ]);
        }
        
    }

    //Fetch fee structure
    public function fetchFeestructures($sid) {
        $feestructures = Feestructure::where('deleted',0)
                        ->where('sid',$sid)
                        ->OrderByDesc('id')
                        ->get();
        return response()->json([
        'feestructures' => $feestructures
    ]);
    }

    //Fetch one Fee Structure
    public function fetchFeestructure($fid) {
        $feestructure = Feestructure::find($fid);

        return response()->json([
            'feestructure' => $feestructure
        ]);
    }

    //Search Fee Structure
    public function searchFeestructure(Request $req) {
        $validator = Validator::make($req->all(),[
            'term' => 'required',
            'class' => 'required',
        ],
        [
            'term.required' => 'You must select term',
            'class.required' => 'You must select class',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
        } else {
            $feestructure = Feestructure::where('classes',$req->class)
                                          ->where('term',$req->term)
                                          ->get();

            return response()->json([
                'status' => 200,
                'feestructure' => $feestructure
            ]);
        }
        
        
    }
}
