<?php

    namespace App;

use Illuminate\Database\Eloquent\Model;

class Whatsapp extends Model
{
    protected $table = 'whatsapp';
    protected $dates = ['deleted_at'];


    function __construct()
    {
        
        parent::__construct();
          
          
    }
    public static function Send($type,$payload){
          
            
           
           if($type=="Image")
           {
            $post = [
                 'key' => 'LM2BYTJECWWWWTNGHOLIDAYSCOMQCL869HXS',
                 'mobileno' => $payload['args']['to'],
                 'msg'   => $payload['args']['content'],
                 'File' => $payload['args']['File'],
                 'type'=>'Image'  //Image For Image
               ];
           }
           else
           {
            
               
               $post = [
                   'key' => 'LM2BYTJECWWWWTNGHOLIDAYSCOMQCL869HXS',
                   'mobileno' => $payload['args']['to'],
                   'msg'   => $payload['args']['content'],
                   'type'=>'Text'  //Image For Image
                 ];
             
           }
           
              
             $url="https://www.cp.bigtos.com/api/v1/sendmessage";
             $ch = curl_init( $url );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            curl_close($ch);
            // echo $response;die();
             # Print response.
             return $response;
          
        }
    public static function sync($mobileno){
          
            
            
               
               $post = [
                   'key' => 'LM2BYTJECWWWWTNGHOLIDAYSCOMQCL869HXS',
                   'mobileno' => $mobileno,
                 ];
              
             $url="https://www.cp.bigtos.com/api/v1/history";
             $ch = curl_init( $url );
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            $response = curl_exec($ch);
            curl_close($ch);
            // echo $response;die();
             # Print response.
             return $response;
          
        }
    public static function DataInsert($data){
        
           $whatappdata=Whatsapp::where('username',$data->chatId)->first();
           $mobileno=explode('@', $data->chatId);
           $mobileno=substr($mobileno[0],2);
           $name=@$data->sender->pushname;
           if($name=="")
           {
             $name=@$data->sender->name;
           }
           $command=(is_numeric($data->body))?$data->body:9;
           if($whatappdata)
           {
             $input['name']=$name;
             $input['mobile']=$mobileno;
             $input['command']=$command;
             $input['data']=json_encode($data);;
             Whatsapp::where('username',$data->chatId)->update($input);
             
           }
           else{
             $Whatsapp = new Whatsapp();
             $Whatsapp->name= $name;
             $Whatsapp->mobile= $mobileno;
             $Whatsapp->command=$command;
             $Whatsapp->data=json_encode($data);
             $Whatsapp->username= $data->chatId;
             $Whatsapp->save();
            
           }
           
        
      }    

}

