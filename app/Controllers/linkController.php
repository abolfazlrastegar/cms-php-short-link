<?php

namespace App\Controllers;


use App\caching\cache;
use App\Middleware\Authorization;
use App\Response\json;
use Database\db;

class linkController
{
    private $DB;
    private $JSON;
    private $auth;
    public function __construct () {
        $this->auth = new Authorization();
        $this->DB = new db();
        $this->JSON = new json();

    }

    public function index () {
        if ($this->auth->check()) {
            $db = $this->DB;
            $json = $this->JSON;
            if ($cache = cache::check($this->auth->getId())) {
                $json->data = json_decode($cache);
                $json->status = 'OK';
                $json->send();
            } else {
                $json->data =  $db->select('links', '*', [
                    'user_id' => $this->auth->getId()
                ]);
                cache::file($this->auth->getId(), $json->data);
                $json->status = 'OK';
                $json->send();
            }
        }
    }

    public function createLink () {
        if ($this->auth->check()){
            $db = $this->DB;
            $json = $this->JSON;
            if (!isset($_REQUEST['short'])) {
                $short = 'http://localhost/test/' . $this->makeHash(6);
            }else {
                $short = $_REQUEST['short'];
            }
            $create = $db->insert('links', [
                'url' => $_REQUEST['url'],
                'user_id' => $this->auth->getId(),
                'short' => $short
            ]);
            if ($create) {
                $json->status = 'ok';
                $json->message = 'لینک کوتاه شد';
                $json->send();
            }
        }
    }

    public function edit () {
        if ($this->auth->check()) {
            $db = $this->DB;
            $json = $this->JSON;
            if (!isset($_REQUEST['short'])) {
                $data = [
                    'url' => $_REQUEST['url'],
                    'created_at' => date('Y-m-d H:i:s')
                ];
            } else {
                $data = [
                    'url' => $_REQUEST['url'],
                    'short' => $_REQUEST['short'],
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }

            $update =  $db->update('links', $_REQUEST['id'], $data);
            if ($update) {
                $json->status = 'ok';
                $json->message = 'لینک مورد نظر ویرایش شد';
                $json->send();
            }
        }
    }

    public function delete () {
        if ($this->auth->check()) {
            $db = $this->DB;
            $json = $this->JSON;
            $delete = $db->delete('links', ['id' => $_REQUEST['id']]);
            if ($delete) {
                $json->status = 'ok';
                $json->message = 'لینک مورد نظر حذف شد';
                $json->send();
            }
        }
    }

    function makeHash($number) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $number; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
        return $randomString;
    }
}