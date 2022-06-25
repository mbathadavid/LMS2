<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Messages;

class MessagesController extends Controller
{
    //Function to register message
    public function regmessage(Request $req) {
        $validator = Validator::make($req->all(),[
            'fullname' => 'required',
            'phoneno' => 'required',
            'message' => 'required',
        ],
        [
            'fullname.required' => 'Please Tell us your Name',
            'phoneno.required' => 'Please Specify Your Phone Number. We will use it to reach back to you',
            'message.required' => 'Please Enter your message',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'messages' => $validator->messages()
            ]);
        } else {
            $message = new Messages;
            $message->sendername = $req->fullname;
            $message->phoneno = $req->phoneno;
            $message->message = $req->message;

            $message->save();
            return response()->json([
                'status' => 200,
                'messages' => 'Your Message was delivered successfully. Our Team will Reach Back To You.'
            ]);
        }
    }
}
