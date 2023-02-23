<?php


namespace App\Sms;


use Illuminate\Support\Facades\Http;



class MrPayamak
{

    private $phone;
    private $template;
    private $firstToken = null;
    private $secondToken= null;
    private $thirdToken = null;

    public function __construct($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    public function template($template)
    {
        $this->template = $template;
        return $this;
    }
    public function setFirstToken($token)
    {
        $this->firstToken = $token;
        return $this;
    }
    public function setSecondToken($token)
    {
        $this->secondToken = $token;
        return $this;
    }
    public function setThirdToken($token)
    {
        $this->thirdToken = $token;
        return $this;
    }

    public function send($message)
    {
        $body = [
            "uname"    => 'mrp09135355259',
            "pass"     => '@@GavGav8585@@',
            "from"     => '+9890009376',
            "to"       => json_encode([$this->phone]),
            "message"  => $message ,
            'op'=>'send'
        ];
        $response = Http::post('https://ippanel.com/services.jspd',$body);
    }
    public function sendLookUp()
    {
        $body = [
            "receptor"  => $this->phone,
            "template"  => $this->template,
        ];

        if (!is_null($this->firstToken))
            $body['token']= $this->refactor($this->firstToken);

        if (!is_null($this->secondToken))
            $body['token1']= $this->refactor($this->secondToken);

        if (!is_null($this->thirdToken))
            $body['token2']= $this->refactor($this->thirdToken);

        $response = Http::get(config('sms.services.kavenegar.lookup_address'),$body);
    }

    private function refactor(string $token) :string
    {
        $token = str_replace(" " , " ", $token);
        $token = str_replace("-" , " ", $token);
        $token = str_replace("_" , " ", $token);
        $token = str_replace("\n", ".", $token);
        return $token;
    }
}
