<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\Admin\UserResource;
use App\User;
use Gate;
use Illuminate\Http\Request;
//use Symfony\Component\HttpFoundation\Response;
use Validator;
use App\Firebasetoken;
use Response;
use App\Announcement;
use Notification;
use App\Notifications\FirebaseNotification;

class CanteenApiController extends Controller
{

    public $successStatus = 200;


    public function topup_notify(Request $request){

        $alternate_id = $request->input('student_id');//alternate_id
        $order_id = $request->input('order_id');
      
        $student = User::where('email',$alternate_id)->first(); 

        if($student)
            $request->request->add(['real_id'=>$student->id]);
        else
            return response()->json(['status'=>false,'message'=>'Student ID is not exist.','data'=>[]], 401);

          //  $fcmTokens = $student->firebasetokens;
            $tokenkey = $student->firebasetokens->pluck('firebasekey')->toArray();
        //    return response()->json($tokenkey);
            $title = "Top up Notification";
            $app_name = "Top up Notification";
            $message = "Your top up has been successfully transferred to iWallet."; 

            $data=[
                'user_id' => 1,
                'student_id'=>$request->input('real_id'), 
                'status' => 'Confirm',
            ];   

            Notification::send($student,new FirebaseNotification($message,$title,$tokenkey,$app_name,$order_id,''));

           

            // Data for insert into attadendance tablle
           


        return response()->json(['status'=>true,'message'=>'Message sent', 'data'=>$data], $this->successStatus);

   

       // return response()->json(['status'=>false,'message'=>'Unauthorized.','data'=>[]], 401);

    }

    public function preorder_notify(Request $request){
        $alternate_id = $request->input('student_id');//alternate_id
        $order_id = $request->input('order_id');
      
        $student = User::where('email',$alternate_id)->first(); 

        if($student)
            $request->request->add(['real_id'=>$student->id]);
        else
            return response()->json(['status'=>false,'message'=>'Student ID is not exist.','data'=>[]], 401);

          //  $fcmTokens = $student->firebasetokens;
            $tokenkey = $student->firebasetokens->pluck('firebasekey')->toArray();
        //    return response()->json($tokenkey);
            $title = "Order Notification";
            $app_name = "Order Notification";
            $message = "Your order has been picked up."; 

            $data=[
                'user_id' => 1,
                'student_id'=>$request->input('real_id'), 
                'status' => 'Confirm',
            ];   

            Notification::send($student,new FirebaseNotification($message,$title,$tokenkey,$app_name,$order_id,''));

           

            // Data for insert into attadendance tablle
           


        return response()->json(['status'=>true,'message'=>'Message sent', 'data'=>$data], $this->successStatus);

   

       // return response()->json(['status'=>false,'message'=>'Unauthorized.','data'=>[]], 401);

    }
    
    public function get_topupinstruction(){

        $html = '<br>Top-up infomation</b><br/>Please top-up by scanning any QR code with any KHQR amount($20, $50 or $100) from any Local Bank Apps or pay by ABA PayWay to ABA Account Below:<br/>- Account Name: Dalya KHUON<br/>- Account No: xxx xxx xxx <br/><br/><b>How to top-up</b><br/> 1- Scan KHQR or link ABA PayWay <br/>2- Upload receipt<br/>3- Fill Amount<br/>4- Tab on Submit button<br/><br/><b>Remark</b><br/>Your top-up amount will be transfer to your iWallet within 24 hours.';


        return response()->json(['status'=>true,'data'=>html_entity_decode($html),'message' => 'successful']);

    }


    public function get_preorderinstruction(){

        $html = '<br>Pre-order infomation</b><br/>Please make pre-order(Food and Drink) for your child for lunch time before 10:00 AM. <br/><br/><b>How to order</b><br/> 1- Select Food/Drink <br/>2- Tab on symbol "+"<br/>3- Tab on Order button<br/><br/><b>Remark</b><br/>We will prepare food/drink for your child at lunch time.';

        return response()->json(['status'=>true,'data'=>html_entity_decode($html),'message' => 'successful']);

    }


    public function get_iwalletinstruction(){
        $html = 'iWallet Term and Condition';
        return response()->json(['status'=>true,'data'=>html_entity_decode($html),'message' => 'successful']);

    }

    public function get_abaqrcodelist(){

        $data=[
            'data' => [
                [
                    'amount' => 10,
                    'image' => url('storage/aba_qrcode/aba_qrcode_10.png'),
                    'link' => "https://link.payway.com.kh/ABAPAYAe68927J"
                ],
                [
                    'amount' => 20,
                    'image' => url('storage/aba_qrcode/aba_qrcode_20.png'),
                    'link' => "https://link.payway.com.kh/ABAPAYIC67626Y"
                ],
                [
                    'amount' => 50,
                    'image' => url('storage/aba_qrcode/aba_qrcode_50.png'),
                    'link' => "https://link.payway.com.kh/ABAPAYWO67628D"
                ] ,
                [
                    'amount' => 100,
                    'image' => url('storage/aba_qrcode/aba_qrcode_100.png'),
                    'link' => "https://link.payway.com.kh/ABAPAYzH67629l"
                ]      
                    
            ],

            'status' => true,
            

        ];

        return response()->json($data);
    }
    
    

}
