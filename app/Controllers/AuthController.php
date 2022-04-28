<?php

namespace App\Controllers;

use App\Response\json;
use Database\db;

class AuthController
{
    private $JSON;
    private $DB;
    public function __construct() {
        $this->JSON = new json();
        $this->DB = new db();
    }
    public function login () {

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $json = $this->JSON;
            $db = $this->DB;
            if (empty($_REQUEST['username']) || empty($_REQUEST['password'])) {
                $json->status = -1;
                $json->message = 'رمز عبور و کلمه عبور خود را وارد کنید';
                $json->send();
            } else {
                $user = $db->select('users', '*', [
                    'username' => $_REQUEST['username'],
                    'password' => md5(sha1($_REQUEST['password']))
                ]);
                if ($user) {
                    $make = $this->makeToken(50, $user[0]['id']);
                    $db->update('users', $user[0]['id'], [
                        'token' => $make['tokenHash'],
                        'end_time_token' => date("Y-m-d H:i:s", strtotime('+5 hours')),
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    $json->token = $make['token'];
                    $json->status = 'ok';
                    $json->send();
                }else {
                    $user_id = $db->insert('users', [
                        'username' => $_REQUEST['username'],
                        'password' => md5(sha1($_REQUEST['password']))
                    ]);

                    if ($user_id) {
                        $make = $this->makeToken(50, $user_id);
                        $db->update('users', $user_id, [
                            'token' => $make['tokenHash'],
                            'end_time_token' => date("Y-m-d H:i:s", strtotime('+5 hours')),
                            'created_at' => date('Y-m-d H:i:s')
                        ]);
                        $json->token = $make['token'];
                        $json->status = 'ok';
                        $json->send();
                    }
                }
            }

        }
    }

    function makeToken($number, $user_id) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        $user = $this->DB->select('users', '*', ['id' => $user_id]);
        $token = [
            'token' => $randomString,
            'user' => $user
        ];
        return  [
            'tokenHash' => $randomString,
            'token' => base64_encode(json_encode($token))
        ];
    }

}