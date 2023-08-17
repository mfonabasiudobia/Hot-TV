<?php 

namespace App\Helpers;
use Str;

class SMSModule {


    public static function send($receiver, $otp, $templateId = null)
    {

        // $config = self::get_settings('twilio_sms');
        // if (isset($config) && $config['status'] == 1) {
        //     $response = self::twilio($receiver, $otp);
        //     return $response;
        // }

        // $config = self::get_settings('nexmo_sms');
        // if (isset($config) && $config['status'] == 1) {
        //     $response = self::nexmo($receiver, $otp);
        //     return $response;
        // }

        // $config = self::get_settings('2factor_sms');
        // if (isset($config) && $config['status'] == 1) {
        //     $response = self::two_factor($receiver, $otp);
        //     return $response;
        // }

        // $config = self::get_settings('msg91_sms');
        // if (isset($config) && $config['status'] == 1) {
            $response = self::msg91($receiver, $otp, $templateId);
            return $response;
        // }

        // return 'not_found';
    }




    public static function msg91($receiver, $otp, $templateId = null)
    {
        return "success"; //Remove if not testing
        // $config = self::get_settings('msg91_sms');
        $response = 'error';
        // if (isset($config) && $config['status'] == 1) {
            
            $receiver = str_replace("+", "", $receiver);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=" . $templateId . "&mobile=" . $receiver . "&authkey=" . config("msg_91.auth_key") . "",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "{\"OTP\":\"$otp\"}",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json"
                ),
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if (!$err) {
                $response = 'success';
            } else {
                $response = 'error';
            }
        // } elseif (empty($config)) {
        //     DB::table('business_settings')->updateOrInsert(['key' => 'msg91_sms'], [
        //         'key' => 'msg91_sms',
        //         'value' => json_encode([
        //             'status' => 0,
        //             'template_id' => '',
        //             'authkey' => '',
        //         ]),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
        return $response;
    }

}
