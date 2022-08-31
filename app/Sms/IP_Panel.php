<?php


namespace App\Sms;


use App\Sms\Contract\Methods;
use App\Sms\Contract\SMS;
use Http;


class IP_Panel  implements  SMS
{
    private $template = "uw6nxcuhaj";
    private $address;
    private $username;
    private $password;

    public function __construct()
    {
        $this->username   = config("sms.services.ip_panel.uname");
        $this->password   = config("sms.services.ip_panel.pass");
        $this->address    = config("sms.services.ip_panel.address");

    }

    public function template($template) {
        $this->template = $template;
        return $this;
    }

    public function tokens(array $tokens) {
        $this->tokens = $tokens;
        return $this;
    }

    public function send($receptor , $message)
    {
        $body = [
            "uname"         => $this->username,
            "pass"          => $this->password,
            'from'          => '3000505',
            'pattern_code'  => $this->template,
            'to'            => json_encode([$receptor]),
            "input_data"    => json_encode(['OTP' => $message]) ,
        ];

        $response = Http::post( $this->address,$body);
        dd($response);
        return  $this->hasSucceed($response) ? true : false;
    }

    public function sendLookUp($receptor)
    {
        $body = [
            "receptor"  => $receptor,
            "template"  => $this->template,
        ];
        $body += $this->refactor($this->tokens);

        $response = Http::get( $this->lookup_address,$body);
        return  $this->hasSucceed($response) ? true : false;
    }

    private function hasSucceed($response): bool
    {
        return $response->status() == 200 && json_decode($response->body())->entries[0]->status == 5;
    }
    private function refactor(array $tokens) : array
    {
        $func = function ($data){
            $data = str_replace(" " , " ", $data);
            $data = str_replace("-" , " ", $data);
            $data = str_replace("_" , " ", $data);
            $data = str_replace("\n", ".", $data);
            return $data;
        };

        $tokens = array_map($func, $tokens);
        return $tokens;
    }
}
