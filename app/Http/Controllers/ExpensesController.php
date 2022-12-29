<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\expenses;
use App\Models\Staff;
use Illuminate\Support\Facades\Validator;

class ExpensesController extends Controller
{
    //Function to record an expense
    public function recordExpense(Request $req){
        date_default_timezone_set("Africa/Nairobi");

        $validator = Validator::make($req->all(),[
            'dateofexpenditure' => 'required',
            'amountspend' => 'required',
            'expenditure' => 'required',
        ],[
            'dateofexpenditure.required' => 'You Must enter the Date of the Expenditure',
            'amountspend.required' => 'You must indicate the amount spend',
            'expenditure.required' => 'You must specify the expenditure you are recording',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag() 
            ]);
        } else {
            $expense = new expenses;
            $user = Staff::find($req->uid);
            $expense->sid = $req->sid;
            $expense->amount = $req->amountspend;
            $expense->expenditure = $req->expenditure;
            $expense->dateofexpenditure = $req->dateofexpenditure;
            $expense->recordedby = $user['Salutation'].' '.$user['Fname'].' '.$user['Lname'].','.$user['Role'];
            $expense->save();

            return response()->json([
                "status" => 200,
                "messages" => "Expense Recorded Successfully"
            ]);

        }
    }

    //Edit Expense
    public function editExpense(Request $req){
        date_default_timezone_set("Africa/Nairobi");
        
        $validator = Validator::make($req->all(),[
            'editdateofexpenditure' => 'required',
            'editamountspend' => 'required',
            'editexpenditure' => 'required',
        ],[
            'editdateofexpenditure.required' => 'You Must enter the Date of the Expenditure',
            'editamountspend.required' => 'You must indicate the amount spend',
            'editexpenditure.required' => 'You must specify the expenditure you are recording',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag() 
            ]);
        } else {
            $expense = expenses::find($req->eid);
            $user = Staff::find($req->uid);
            $expense->sid = $req->sid;
            $expense->amount = $req->editamountspend;
            $expense->expenditure = $req->editexpenditure;
            $expense->dateofexpenditure = $req->editdateofexpenditure;
            $expense->updatedby = $user['Salutation'].' '.$user['Fname'].' '.$user['Lname'].','.$user['Role'];
            $expense->save();

            return response()->json([
                "status" => 200,
                "messages" => "Expense Updated Successfully"
            ]);

        }
    }

    //function for fetching expenses
    public function fecthExpenses($sid) {
        $expenses = expenses::where('sid',$sid)
                             ->where('deleted','!=',1)
                             ->OrderByDesc('id')
                             ->get();

        $filteredexpenses = [];

        if (count($expenses) > 0) {
            foreach ($expenses as $expense) {
                array_push($filteredexpenses,$expense->amount);
            }
        } 
        
    return response()->json([
        "expenses" => $expenses,
        "expensestotal" => array_sum($filteredexpenses)
    ]);
        
    }

    //Delete Expense
    public function deleteExpense($eid) {
        $expense = expenses::find($eid);
        $expense->deleted = 1;
        $expense->save();
        
        return response()->json([
            "status" => 200,
            "messages" => "Expense Deleted Successfully"
        ]);
    }

    //Expenses Controller
    public function expenditureReport(Request $req) {
        $validator = Validator::make($req->all(),[
            'expensereportselect' => 'required',
        ],[
            'expensereportselect.required' => 'You Must Select the Period for Retrieving the Fee Payment Report',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag() 
            ]);
        } else {
            if ($req->expensereportselect != "ALL" && $req->expensestartdate == "") {
                return response()->json([
                    'status' => 401,
                    'messages' => "You must Specify the start for the date range" 
                ]);
            } else if($req->expensereportselect != "ALL" && $req->expensetodate == "") {
                return response()->json([
                    'status' => 402,
                    'messages' => "You must Specify the end for the date range" 
                ]);
            } else if ($req->expensereportselect == "ALL") {
                $expenses = expenses::where('sid',$req->sid)
                                          ->OrderByDesc('id')
                                          ->get();

                $totalpayed = [];
                $datearr = [];

                foreach ($expenses as $expense) {
                    array_push($totalpayed,$expense->amount);
                    array_push($datearr,$expense->created_at);
                }
                     
                return response()->json([
                    "status" => 200,
                    "from" => $datearr[count($datearr) - 1],
                    "to" => $datearr[0],
                    "totalpayed" => array_sum($totalpayed),
                    "expenses" => $expenses
                ]);
            } else {
                $expenses = expenses::where('sid',$req->sid)
                                          ->whereBetween('created_at',[$req->expensestartdate,$req->expensetodate])
                                          ->OrderByDesc('id')
                                          ->get();

                $totalpayed = [];

                foreach ($expenses as $expense) {
                    array_push($totalpayed,$expense->amount);
                }

                return response()->json([
                    "status" => 200,
                    "from" => $req->expensestartdate,
                    "to" => $req->expensetodate,
                    "totalpayed" => array_sum($totalpayed),
                    "expenses" => $expenses
                ]);
            }
            
        }
    }
}
