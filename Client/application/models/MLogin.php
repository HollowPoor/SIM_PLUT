<?php
use GuzzleHttp\Client;

class MLogin extends CI_model
{
    public function AuthLogin($email, $password)
    {
        $client = new Client();
        $respons = $client->request('POST', API_User, [
            'form_params' => [
                'email' => $email,
                'password' => $password,
            ],
        ]);

        $result = json_decode($respons->getBody()->getContents(), true);

        return $result;
    }
}
