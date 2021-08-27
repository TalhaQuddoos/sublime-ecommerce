<?php

require_once("DotEnv.php");

(new DotEnv(__DIR__ . '/../.env'))->load();

class Cloudinary {
    public $api_key, $api_secret, $url;
    
    public function __construct()
    {   
        $this->api_key = getenv("CLOUDINARY_APIKEY");
        $this->api_secret = getenv("CLOUDINARY_APISECRET");
        $this->url = getenv("CLOUDINARY_URL");
    }

    public function uploadImages($images) {
        $images = $this->parseImages($images);
        $imageUrls = [];

        foreach($images as $image => $type) {
            $url = $this->upload($image, $type);
            $imageUrls[] = $url;
        }

        return $imageUrls;
    }

    public function parseImages($images) {
        return array_combine($images['tmp_name'], $images['type']);
    }

    public function upload($image, $type) {
        $timestamp = time();
        
        $signature = $this->sign([
            "timestamp" => $timestamp
        ]);
        
        $image = base64_encode(file_get_contents($image));
        $file = "data:$type;base64,$image";

        $data = [
            "api_key" => $this->api_key,
            "timestamp" => $timestamp,
            "file" => $file,
            "signature" => $signature
        ];

        $options = [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $data
        ];

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        
        $result = curl_exec($curl);
        $url = json_decode($result, true)['secure_url'];
        return $url;

    }

    public function sign($params) {
        ksort($params);
        return sha1(urldecode(http_build_query($params)) . $this->api_secret);
    }
}

?>