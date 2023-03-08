<?php

namespace App\Http\Controllers;
use App\Models\subjectreports;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectreportsController extends Controller
{
    //Function to save report
    public function addsubjectReport(Request $req) {
        date_default_timezone_set('Africa/Nairobi');

        $validator = Validator::make($req->all(),[
            'subjectcheckbox' => 'required',
           ],[
            'subjectcheckbox.required' => 'You must select at least one to produce a report'
           ]); 
    
           if ($validator->fails()) {
               return response()->json([
                   'status' => 400,
                   'messages' => $validator->getMessageBag()
               ]);
           } else {
            $subids = array_filter($req->subjectcheckbox);
            $subnames = array_filter($req->subjecttobereported);
            $reports = array_filter($req->subjectreport);

            if (count($subnames) != count($reports)) {
                return response()->json([
                    'status' => 401,
                    'messages' => 'You must provide a report for every subject selected'
                ]);
            } else {
                $student = Student::find($req->studentid);

                for ($i=0; $i < count($subids); $i++) { 
                    $subreport = new subjectreports;
                    $subreport->studentid = $req->studentid;
                    $subreport->sid = $req->sid;
                    $subreport->Name = $student['Fname'].' '.$student['Lname']; 

                    if ($student['AdmissionNo'] == NULL) {
                        $subreport->AdmUPI = $student['UPI'];
                    } else {
                        $subreport->AdmUPI = $student['AdmissionNo'];
                    }

                    $subreport->subject = $subnames[$i];
                    $subreport->subjectid = $subids[$i];
                    $subreport->report = $reports[$i];
                    $subreport->date = date("d/m/Y");
                    $subreport->save();
                }

                return [
                    'status' => 200,
                    'messages' => 'You have successfully submitted the students report for '.implode(',',$subnames).'.'
                ];
    }
}
}
}
