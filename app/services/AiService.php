<?php
class AiService {
    private $apiUrl;
    public function __construct($apiUrl) { $this->apiUrl = $apiUrl; }
    public function analyzeImage($filePath){
        if (!file_exists($filePath)) return ['error'=>'file not found'];
        $cfile = new CURLFile($filePath);
        $post = ['image'=>$cfile];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
        ]);
        $resp = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if ($resp === false) return ['error'=>'api_error','detail'=>$err];
        $json = json_decode($resp,true);
        if ($json === null) return ['error'=>'invalid_response','raw'=>$resp];
        return $json;
    }
}
?>