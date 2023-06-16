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
Use Auth;
// use Illuminate\Support\Facades\Auth;
use Hash;

class UsersApiController extends Controller
{

    public $successStatus = 200;

    public function collection_card(){
        
        if(auth()->check()){
            $collections = User::with('class')->find(auth()->user()->id);
            
            return response()->json(['status'=>true,'message' => 'Collection Card Info for Student ' .  auth()->user()->name . '.','data'=>$collections], 200);
        }

        return response()->json(['status'=>false,'message'=>'No login information','data'=>[]], 401);
    }


    public function index()
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource(User::with(['roles', 'class'])->get());
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update_cur_usr_ver(Request $request)
    {
	$user =  auth()->user();

        $user->update(['version' => $request->version]);
  
	return response()->json(['status'=>'success'], $this->successStatus);


    }


    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserResource($user->load(['roles', 'class']));
    }

    public function update(UpdateUserRequest $request, User $user)
    {

        $user->update($request->all());

        $user->roles()->sync($request->input('roles', []));

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function login(Request $request){

       // return response()->json(['email' => Request('email')]);

        if(auth()->attempt(['email' => $request->email, 'password' => $request->password],true)){
            $user = auth()->user();
            $success = $user->createToken('MyApp')->accessToken;
            
            if(!$user->roles->contains(4))
                return response()->json(['status'=>false,'message'=>'You are not student.','data'=>[]],401);
                

            $firebase_key = $request->firebase_token;

            $token = Firebasetoken::where('firebasekey', $firebase_key)->get();

            if($token->count() > 0){
                $user->firebasetokens()->syncWithoutDetaching($token->first()->id);
                //$data = ['user_id'=>$user-id,'firebasetoken_id'=>$token->first()->id];
                //$user->firebasetokens()->sync($data);

                // $user->firebasetokens()->detach($token->first()->id);
                // $user->firebasetokens()->attach($token->first()->id);
               // $user->firebasetokens()->updateOrCreate(['user_id'=>$user-id,'firebasetoken_id'=>$token->first()->id],['user_id'=>$user-id,'firebasetoken_id'=>$token->first()->id]);
            }else{
                return response()->json(['status'=>false,'message'=>'Incorrect Token Key','data'=>[]],401);
            }

            // $user = User::find(auth()->user()->id);
            // $user->api_token = $success; // or Str::random(60), // <- This will be used in client access
            // $user->save();

            return response()->json(['status'=>true,'message'=>'Successful Login.', 'data'=>['token' => $success,'student_id'=>$user->email, 'class_id'=>$user->class->id, 'user_id'=> $user->id]], $this->successStatus);
        }else{
            return response()->json(['status'=>false,'message'=>'Unauthorized','data'=>[]],401);
        }

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email'=>'required|email|unique:users',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->access_token;
        $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function logout (Request $request) {

        if(!$request->has('firebasekey'))
            return response(['status'=>false,'message' => 'Unathorized.','data'=>[]], 401);

        $token = Firebasetoken::has('users')->where('firebasekey',$request->firebasekey)->first();

        if(!$token)
             return response(['status'=>false,'message' => 'Incorrect Larvel Token..','data'=>[]], 401);
        $token->users()->detach(auth()->user()->id);
        $accessToken=Auth::user()->token()->revoke();

//$token = $request->user()->tokens->find()
       // auth()->user()->token()->find($request->firebasekey)->revoke();
        //Auth::logoutCurrentDevice();
        
        // $token= $request->user()->tokens->find($accessToken);
        // $token->revoke();
        return response(['status'=>true,'message' => 'You have been successfully logged out.','data'=>[]], 200);
    }

    public function logoutotherdevice (Request $request) {

         if(!$request->has('password'))
             return response(['status'=>false,'message' => 'Unathorized.','data'=>[]], 401);

         Auth::logoutOtherDevices($request->password);

         return response(['status'=>true,'message' => 'You have been successfully logged out all device.','data'=>[]], 200);
     }

    public function change_password(Request $request)
    {
    $input = $request->all();
    $userid = Auth::guard('api')->user()->id;
    $rules = array(
        'old_password' => 'required',
        'new_password' => 'required|min:6',
        'confirm_password' => 'required|same:new_password',
    );
    $validator = Validator::make($input, $rules);
    if ($validator->fails()) {
        $arr = array("status" => false, "message" => $validator->errors()->first(), "data" => array());
    } else {
        try {
            if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                $arr = array("status" => false, "message" => "Check your old password.", "data" => array());
            } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                $arr = array("status" => false, "message" => "Please enter a password which is not similar then current password.", "data" => array());
            } else {
                User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                $arr = array("status" => true, "message" => "Password updated successfully.", "data" => array());

                // Auth::logoutOtherDevices($request->old_password);

                // $refreshTokenRepository = app(\Laravel\Passport\RefreshTokenRepository::class);
                // foreach(User::find(auth()->user()->id)->tokens as $token) {
                //     $token->revoke();
                //     $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
                // }

            }
        } catch (\Exception $ex) {
            if (isset($ex->errorInfo[2])) {
                $msg = $ex->errorInfo[2];
            } else {
                $msg = $ex->getMessage();
            }

            $arr = array("status" => false, "message" => $msg, "data" => array());
        }
    }
    return \Response::json($arr);   
    }

    public function getDetails(){
        
        if(!auth()->guard('api')->check())
            return response()->json(['status'=>false,'message'=>'No login information','data'=>[]], 401);
       
        $class_name = Auth::user();
       
        $data = auth()->user()->toArray();
        //return $data;
        $data['class_name'] = $class_name->class->name;
        $data['campus'] = $class_name->class->campus;
        
        return response()->json(['status'=>true,'message'=>'User information','data'=>['data'=>[$data]]], 200);
    }

    public function register_firebasetoken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firebase_token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>false,'message'=>$validator->errors(),'data'=>[]], 401);            
        }

        

        $firebase_key = $request->firebase_token;
        $device = $request->model;
        $os_type = $request->os_type;
        
        $firebasetokens = Firebasetoken::where('firebasekey',$firebase_key)->get();


        if($firebasetokens->count()<=0)
            Firebasetoken::create(['firebasekey'=>$firebase_key,'model'=>$device,'os_type'=>$os_type]);

        return response()->json(['status'=>true,'message'=>'Successful Register Token','data'=>[]], $this->successStatus);
    }

    public function isSuccessPush($tokens,$title,$body,$data){
        $ch = curl_init("https://fcm.googleapis.com/fcm/send");

        //The device token.
        // $token = $token; //token here

        // //Title of the Notification.
        // $title = $request->title;

        // //Body of the Notification.
        // $body = description

        //Creating the notification array.
        $notification = array('title' =>$title , 'body' => $body,'sound'=> 'Enabled');

        //This array contains, the token and the notification. The 'to' attribute stores the token.
       // $arrayToSend = array('to' => $token, 'notification' => $notification,'data' =>$data,'priority'=>10);
       if(is_array($tokens))
            $arrayToSend = [
                'registration_ids' => $tokens,
                'notification' => $notification,
                'data' => $data
            ];
        else
            $arrayToSend = [
                'to' => $token, 
                'notification' => $notification,
                'data' => $data,
                'priority'=>10
            ];

        //Generating JSON encoded string form the above array.
        //$json = ;
        //Setup headers:
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: key= AAAAnrysdHA:APA91bH1SLdG5jVObcZzY5EZoqbHjlB35qZLGS5ANLHUl_pbJHGQsgg4kGmSrNcgwVF0GsYDHyk1Sh0tHybhdNzwzQBcSDtjEW5xzhX2-PIdD0foHHq4FN1Z1caZFbLgo1AgS-2SGThU'; // key here
        
        //Setup curl, add headers and post parameters.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayToSend));
        curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //Send the request
        $response = curl_exec($ch);

        //Close request
        curl_close($ch);

        return $response;
    }

    public function FirebaseMessage($title,$message,$fcmTokens,$data){

        // $title         = $data('title');
        // $description   = $data('message');
        // $token         = $data('fcmTokens');

       
        $jsonArray = json_decode($this->isSuccessPush($fcmTokens,$title,$message,$data),true);
        
      
            return Response::json(array(
                                        'status' => true,
                                        'message' => 'Success Sent',
                                        'data' => $jsonArray
                                        ));
    }

    public function send_notification(Request $request){
   
            $title         = $request->input('title');
            $description   = $request->input('message');
            $token         = $request->input('token');
            $data = ['id'=> $request->input('id'), 'route' => $request->input('route')];
    
            $jsonArray = json_decode($this->isSuccessPush($token,$title,$description,$data),true);

            return Response::json(array(
                                        'status' => true,
                                        'message' => 'Success Sent',
                                        'data' => $jsonArray
                                        ));
        
    }

    
    

}
