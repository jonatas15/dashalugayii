<?php
namespace app\models;

class Mail {
    public static function send($to, $subject, $message, $modo = null) {
        $ch = curl_init();

        if($modo) {
            $assinatura = $modo['assinatura'];
        } else {
            $assinatura = 'Café Imobiliária <contato@cafeimobiliaria.com.br>';
        }

        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, 'api:key-98c8d0314f4074448cbac786bdfed3ac');
        curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/cafeinteligencia.com.br/messages');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            'from'    => $assinatura,
            'to'      => $to,
            'subject' => $subject,
            'html'    => $message,
            'text'    => strip_tags($message),
        ));

        $return = json_decode(curl_exec($ch));

        $info = curl_getinfo($ch);

        if($info['http_code'] != 200) {
            throw new Exception("Não foi posspivel enviar a mensagem.");
        }

        curl_close($ch);

        return $return;
    }
}
