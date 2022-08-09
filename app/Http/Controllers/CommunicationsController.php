<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\communications;
use Illuminate\Http\Request;


class CommunicationsController extends Controller
{
    //Function for sending a message
    public function sendMessage(Request $req) {
        if ($req->message == null) {
            return response()->json([
                'status' => 400,
                'messages' => 'Please make sure that enter message in the texarea above'
            ]);
        } else {
            $numbers = explode(',',$req->numbers);

            $responsecodes = [];
            $responsedescription = [];


            for ($i=0; $i < count($numbers); $i++) { 
                    $client = new Client();

                    $url = 'https://quicksms.advantasms.com/api/services/sendsms/?';

                    $params = [
                        "apikey" => "0872c31420f6d597a067e23dd27ba658",
                        "partnerID" => "5031",
                        "message" => $req->message,
                        "shortcode" => "JuaMobile",
                        "mobile" => $req->numbers
                    ];

                    $response = $client->request('GET', $url, [
                        'json' => $params,
                        'verify'  => false,
                    ]);

                    $responseBody = json_decode($response->getBody());
                    //array_push($responseBody.); 
            }
            

            return response()->json([
                'messagesend' => $responseBody
            ]);
        }
        
    }
}
