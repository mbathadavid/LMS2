<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\generalreports;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class GeneralreportsController extends Controller
{
    //function to insert general report
    public function addgeneralReport(Request $req) {
        //return ['data' => $req->all()];
        date_default_timezone_set('Africa/Nairobi');

        $validator = Validator::make($req->all(),[
            'genreportcheckbox' => 'required',
           ],[
            'genreportcheckbox.required' => 'You must select at least one student to produce a report'
           ]); 
    
           if ($validator->fails()) {
               return response()->json([
                   'status' => 400,
                   'messages' => $validator->getMessageBag()
               ]);
           } else {
                $studentids = array_filter($req->genreportcheckbox);
                $studentnames = array_filter($req->generalreportname);
                $reports = array_filter($req->thegeneralreport);

                if (count($studentids) != count($reports)) {
                    return response()->json([
                        'status' => 401,
                        'messages' => 'You must provide a report for every student selected'
                    ]);
                } else {
                    for ($i=0; $i < count($studentids); $i++) { 
                        $student = Student::find($studentids[$i]);
                        $report = new generalreports;
                        $report->sid = $req->sid;
                        $report->studentid = $studentids[$i];
                        $report->Name = $studentnames[$i];
                        $report->report = $reports[$i];
                        $report->date = date("d/m/Y");

                        if ($student['AdmissionNo'] == NULL) {
                            $report->AdmUPI = $student['UPI'];
                        } else {
                            $report->AdmUPI = $student['AdmissionNo'];
                        }
                        $report->save();
                    }

                return [
                    'status' => 200,
                    'messages' => 'You have successfully submitted the students report for '.implode(',',$studentnames).'.'
                ];
                        
                }
                
           }
    }
}
