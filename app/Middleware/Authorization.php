<?php

namespace App\Middleware;

use Database\db;

class Authorization
{
    public $auth = null;
    private $user;
    public $headers;
    public $token;

    public function __construct()
    {
        $DB = new db();
        $this->setHeaders(getallheaders());
        $this->auth = $DB->select('users', '*', ['token' => $this->token]);

    }

    public function check() {
        if ($this->auth) {
            return true;
        }
        header("Location: http://localhost/test/404");
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function user() {
        return json_decode(json_encode($this->user), true);
    }

    public function getId () {
        return json_decode(json_encode($this->user), true)['id'];
    }

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }


    /**
     * @param mixed $headers
     */
    public function setHeaders($headers): void
    {
        $this->headers = $headers;
        if (isset($headers['Authorization'])) {
            $headers = ltrim($headers['Authorization'], 'Bearer');
            $base64 = json_decode(base64_decode($headers));
            $this->setToken($base64->token);
            $this->setUser($base64->user[0]);
        }

    }

}