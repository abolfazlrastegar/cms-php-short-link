<?php

namespace App\Response;

class json
{
    public function make(){
        return json_encode($this);
    }

    public function headers(){
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // JSONs are by default dynamic data
        header('Content-type: application/json');
    }

    public function send($options = null){
        $this->headers();
        echo json_encode($this, $options);
    }

    public function send_var($var_name = 'custom', $options = null){
        $this->headers();
        echo "var {$var_name} = ";
        echo json_encode($this, $options);
        echo ';';
    }

    public function send_callback($cb_name = 'custom', $options = null){
        $this->headers();
        echo "{$cb_name}(";
        echo json_encode($this, $options);
        echo ');';
    }
}