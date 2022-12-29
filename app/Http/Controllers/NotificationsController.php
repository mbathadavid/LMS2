<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\notifications;
use Illuminate\Support\Facades\Validator;

class NotificationsController extends Controller
{
    //Function to receive Parent message
    public function receiveParentmessage(Request $req) {
        date_default_timezone_set('Africa/Nairobi');
        $validator = Validator::make($req->all(),[
            'subject' => 'required|max:40',
            'message' => 'required',
            
           ],[
            'message.required' => 'You must include a message',
            'subject.required' => 'You must include a subject for yor message',
            'subject.max' => 'The subject cannot be longer than 40 characters. Please make it shorter',
           ]);

           if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
            } else {
                $notification = new notifications;
                $notification->sid = $req->sid;
                $notification->type = "parentmessage"; 
                //$notification->replyfor = $req->;
                //$notification->toberecievedby = 'school';
                $notification->noficationtxt = $req->fname.' '.$req->lname.' (Parent) send a new message';
                $notification->group = "Staff";
                $notification->topic = $req->subject;
                $notification->message = $req->message;
                $notification->ucategory = "parent";
                $notification->uid = $req->uid;
                $notification->sendername = $req->fname.' '.$req->lname;

                if ($req->hasFile('fileattachment')) {
                    $file = $req->file('fileattachment');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'upload'.'.'.$extension;
                    $file->move('images/', $filename);
                    $notification->filetype = $extension;
                    $notification->filename = $filename;
                }

                $notification->save();

                $sname = session()->get('schooldetails.name');

                return response()->json([
                    'status' => 200,
                    'messages' => 'Message Send Successfully. You will get a reply from '.$sname
                ]);

                
            } 
    }

    //Receive and store General Message
    public function receiveGeneralmessage(Request $req) {
        date_default_timezone_set('Africa/Nairobi');
        $validator = Validator::make($req->all(),[
            'subject' => 'required|max:40',
            'message' => 'required',
            'group' => 'required'
           ],[
            'message.required' => 'You must include a message',
            'subject.required' => 'You must include a subject for yor message',
            'subject.max' => 'The subject cannot be longer than 40 characters. Please make it shorter',
            'group.required' => 'You must select the group to be notified'
           ]);

           if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->getMessageBag()
            ]);
            } else {
                $notification = new notifications;
                $notification->sid = $req->sid;
                $notification->type = "noticeboard"; 
                //$notification->replyfor = $req->;
                //$notification->toberecievedby = 'school';
                $notification->noficationtxt = $req->fname.' '.$req->lname. '('.$req->role.') send a general message to all '.$req->group;
                $notification->group = $req->group;
                $notification->topic = $req->subject;
                $notification->message = $req->message;
                $notification->ucategory = "parent";
                $notification->uid = $req->uid;
                $notification->sendername = $req->fname.' '.$req->lname;

                if ($req->hasFile('fileattachment')) {
                    $file = $req->file('fileattachment');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'upload'.'.'.$extension;
                    $file->move('images/', $filename);
                    $notification->filetype = $extension;
                    $notification->filename = $filename;
                }

                $notification->save();

                $sname = session()->get('schooldetails.name');

                return response()->json([
                    'status' => 200,
                    'messages' => 'Message Send Successfully. You will get a reply from '.$sname
                ]);
            } 
    }

    //Fetch notifications for Staff
    public function fetchadmiNotifications($sid) {
        $notifications = notifications::where('sid',$sid)
                                        ->where('group','Staff')
                                        ->orderByDesc('id')
                                        ->get();
                                        
        return response()->json([
            "notifications" => $notifications
        ]);
    }

}
