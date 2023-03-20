<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\communications;
use App\Models\School_Data;
use App\Models\Staff;
use Illuminate\Http\Request;


class CommunicationsController extends Controller
{
    //Function for sending a message
    public function sendMessage(Request $req) {
        date_default_timezone_set('Africa/Nairobi');

        $uid = session()->get('LoggedInUser.id');
        $sender = Staff::find($uid);
        $school = School_Data::find($req->sid);

        if ($req->message == null) {
            return response()->json([
                'status' => 400,
                'messages' => 'Please make sure that enter message in the textarea above'
            ]);
        } else {
            //return ['data' => $req->all()];
            $numbers = explode(',',$req->numbers);

            $responsecodes = [];
            $responsedescription = [];
            $status_codes = [];
            $status_descs = [];
            $mobile_numbers = [];
            $costs = [];

        for ($i=0; $i < count($numbers); $i++) { 
            $curl = curl_init();

            $apikey = "";
            $message = "";

            if ($req->sendthrough === "Shuleyetu") {
                $apikey = "ae42640feb185a424fdce5d4c6bde3ab955f7e332782024b527cda3c4a8d43cc"; 
                $message = $req->message.'. FROM '.$school['name']; 

                $post_data = [
                    "mobile" => $numbers[$i],
                    "response_type" => "json",
                    "sender_name" => "23107",
                    "service_id" => 0,
                    "message" => $message
                  ];
                } else if ($req->sendthrough === "Owngateway") {
                    $apikey = $school['SMS_KEY'];

                    $post_data = [
                        "mobile" => $numbers[$i],
                        "response_type" => "json",
                        "sender_name" => $school['Shortcode'],
                        "service_id" => 0,
                        "message" => $req->message
                    ];
                }

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobitechtechnologies.com/sms/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_HTTPHEADER => array(
                'h_api_key: '.$apikey,
                'Content-Type: application/json'
            ),
            ));

        // 'h_api_key: ae42640feb185a424fdce5d4c6bde3ab955f7e332782024b527cda3c4a8d43cc',

            $response = curl_exec($curl);

            $data = json_decode($response, true);
            $status_code = $data[0]['status_code'];
            $status_desc = $data[0]['status_desc'];
            $message_id = $data[0]['message_id'];
            $mobile_number = $data[0]['mobile_number'];
            $network_id = $data[0]['network_id'];
            $message_cost = $data[0]['message_cost'];
            $credit_balance = $data[0]['credit_balance'];

            if ($status_code == 1000) {
                array_push($costs,$message_cost);
            }

            $communication = new communications;
            $communication->sid = $req->sid;
            $communication->senderid = $uid;
            $communication->sender_name = $sender['Fname'].' '.$sender['Lname'];
            $communication->message = $req->message;
            $communication->number = $mobile_number;
            $communication->status_code = $status_code;
            $communication->network_id = $network_id;
            $communication->message_cost = $message_cost;
            $communication->credit_balance = $credit_balance;

            if ($req->sendthrough === "Shuleyetu") {
                $communication->API_used = 'Shule yetu Gateway';
            } else if ($req->sendthrough === "Owngateway") {
                $communication->API_used = $school['name'].' Gateway';
            }
            

            if ($status_code == 1000) {
                $communication->status = 'Send Successfully';
            } else {
                $communication->status = 'Failed';
            }
            
            $communication->Description = $status_desc;
            $communication->save();

            curl_close($curl);

            }

            if ($req->sendthrough === "Shuleyetu") {
              $newwebbalance = $school['SMSbalanceonwebsite'] - array_sum($costs);
              $school->SMSbalanceonwebsite = $newwebbalance;  
              $school->save(); 
            } else if ($req->sendthrough === "Owngateway") {
               $newapibal = $school['SMSbalance'] - array_sum($costs);
               $school->SMSbalance = $newapibal;
               $school->save();    
            }
            
            return response()->json([
                'costs' => array_sum($costs),
                'successfullysendmessages' => count($costs),
                'gateway' => $req->sendthrough
            ]);
            
        } 
    }

    //Function for sending fee reminders
    public function sendfeeReminder(Request $req) {
        date_default_timezone_set('Africa/Nairobi');

        $uid = session()->get('LoggedInUser.id');
        $sender = Staff::find($uid);
        $school = School_Data::find($req->sid);

            $numbers = $req->parentnumber;
            $messages = $req->message;

            $responsecodes = [];
            $responsedescription = [];
            $status_codes = [];
            $status_descs = [];
            $mobile_numbers = [];
            $costs = [];

        for ($i=0; $i < count($numbers); $i++) { 
            $curl = curl_init();

            $apikey = "";
            //$message = "";

            if ($req->sendthrough === "Shuleyetu") {
                $apikey = "ae42640feb185a424fdce5d4c6bde3ab955f7e332782024b527cda3c4a8d43cc"; 
                //$message = $messages[$i]; 

                $post_data = [
                    "mobile" => $numbers[$i],
                    "response_type" => "json",
                    "sender_name" => "23107",
                    "service_id" => 0,
                    "message" => $messages[$i]
                  ];
                } else if ($req->sendthrough === "Owngateway") {
                    $apikey = $school['SMS_KEY'];

                    $post_data = [
                        "mobile" => $numbers[$i],
                        "response_type" => "json",
                        "sender_name" => $school['Shortcode'],
                        "service_id" => 0,
                        "message" => $messages[$i]
                    ];
                }

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mobitechtechnologies.com/sms/sendsms',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_HTTPHEADER => array(
                'h_api_key: '.$apikey,
                'Content-Type: application/json'
            ),
            ));

        // 'h_api_key: ae42640feb185a424fdce5d4c6bde3ab955f7e332782024b527cda3c4a8d43cc',

            $response = curl_exec($curl);

            $data = json_decode($response, true);
            $status_code = $data[0]['status_code'];
            $status_desc = $data[0]['status_desc'];
            $message_id = $data[0]['message_id'];
            $mobile_number = $data[0]['mobile_number'];
            $network_id = $data[0]['network_id'];
            $message_cost = $data[0]['message_cost'];
            $credit_balance = $data[0]['credit_balance'];

            if ($status_code == 1000) {
                array_push($costs,$message_cost);
            }

            $communication = new communications;
            $communication->sid = $req->sid;
            $communication->senderid = $uid;
            $communication->sender_name = $sender['Fname'].' '.$sender['Lname'];
            $communication->message = $req->message[$i];
            $communication->number = $mobile_number;
            $communication->status_code = $status_code;
            $communication->network_id = $network_id;
            $communication->message_cost = $message_cost;
            $communication->credit_balance = $credit_balance;

            if ($req->sendthrough === "Shuleyetu") {
                $communication->API_used = 'Shule yetu Gateway';
            } else if ($req->sendthrough === "Owngateway") {
                $communication->API_used = $school['name'].' Gateway';
            }
            
            if ($status_code == 1000) {
                $communication->status = 'Send Successfully';
            } else {
                $communication->status = 'Failed';
            }
            
            $communication->Description = $status_desc;
            $communication->save();

            curl_close($curl);

            }

            if ($req->sendthrough === "Shuleyetu") {
              $newwebbalance = $school['SMSbalanceonwebsite'] - array_sum($costs);
              $school->SMSbalanceonwebsite = $newwebbalance;  
              $school->save(); 
            } else if ($req->sendthrough === "Owngateway") {
               $newapibal = $school['SMSbalance'] - array_sum($costs);
               $school->SMSbalance = $newapibal;
               $school->save();    
            }
            
            return response()->json([
                'costs' => array_sum($costs),
                'successfullysendmessages' => count($costs),
                'gateway' => $req->sendthrough
            ]);
            
        //} 
    }

    //Fetch Messaging History
    public function fetchsendMessages($sid){
        $messaginghistory = communications::where('sid',$sid)
                                            ->OrderByDesc('id')
                                            ->get();

        return response()->json([
            'messaginghistory' => $messaginghistory
        ]);
    }
}
