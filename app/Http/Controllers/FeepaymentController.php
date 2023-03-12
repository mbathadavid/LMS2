<?php

namespace App\Http\Controllers;
use App\Models\feepayment;
use App\Models\expenses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeepaymentController extends Controller
{
    //Fetch Fee Payment Controller
    public function feepaymentReport(Request $req) {
        $validator = Validator::make($req->all(),[
            'feereportselect' => 'required',
        ],[
            'feereportselect.required' => 'You Must Select the Period for Retrieving the Fee Payment Report',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag() 
            ]);
        } else {
            if ($req->feereportselect != "ALL" && $req->feestartdate == "") {
                return response()->json([
                    'status' => 401,
                    'messages' => "You must Specify the start for the date range" 
                ]);
            } else if($req->feereportselect != "ALL" && $req->feetodate == "") {
                return response()->json([
                    'status' => 402,
                    'messages' => "You must Specify the end for the date range" 
                ]);
            } else if ($req->feereportselect == "ALL") {
                $feepayments = feepayment::where('sid',$req->sid)
                                          ->OrderByDesc('id')
                                          ->get();

                $totalpayed = [];
                $datearr = [];

                foreach ($feepayments as $feepayment) {
                    array_push($totalpayed,$feepayment->amount);
                    array_push($datearr,$feepayment->created_at);
                }
                     
                return response()->json([
                    "status" => 200,
                    "from" => $datearr[count($datearr) - 1],
                    "to" => $datearr[0],
                    "totalpayed" => array_sum($totalpayed),
                    "feepayments" => $feepayments
                ]);
            } else {
                $feepayments = feepayment::where('sid',$req->sid)
                                          ->whereBetween('created_at',[$req->feestartdate,$req->feetodate])
                                          ->OrderByDesc('id')
                                          ->get();

                $totalpayed = [];

                foreach ($feepayments as $feepayment) {
                    array_push($totalpayed,$feepayment->amount);
                }

                return response()->json([
                    "status" => 200,
                    "from" => $req->feestartdate,
                    "to" => $req->feetodate,
                    "totalpayed" => array_sum($totalpayed),
                    "feepayments" => $feepayments
                ]);
            }
            
        }
    }

    public function feeexpenseCompare(Request $req) {
        $validator = Validator::make($req->all(),[
            'expensefeestartdate' => 'required',
            'expensefeetodate' => 'required',
        ],[
            'expensefeestartdate.required' => 'You Must Select the Start Period for Retrieving the Fee Payment Report',
            'expensefeetodate.required' => 'You Must Select the End Period for Retrieving the Fee Payment Report',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag() 
            ]);
        } else {
            $feepayments = feepayment::where('sid',$req->sid)
                                          ->whereBetween('created_at',[$req->expensefeestartdate,$req->expensefeetodate])
                                          ->OrderByDesc('id')
                                          ->get();

            $expenses = expenses::where('sid',$req->sid)
                                          ->whereBetween('dateofexpenditure',[$req->expensefeestartdate,$req->expensefeetodate])
                                          ->OrderByDesc('id')
                                          ->get();

            $actualpayments = [];
            $actualexpenses = [];

            foreach ($feepayments as $key => $feepayment) {
                array_push($actualpayments,$feepayment->amountpayed);
            }

            foreach ($expenses as $key => $expense) {
                array_push($actualexpenses,$expense->amount);
            }

            return response()->json([
                "status" => 200,
                "from" => $req->expensefeestartdate,
                "to" => $req->expensefeetodate,
                "totalfeepayed" => array_sum($actualpayments),
                "totalexpenses" => array_sum($actualexpenses)
            ]);   
        }
    }
}
