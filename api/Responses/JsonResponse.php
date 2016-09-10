<?php

namespace api\Responses;

final class JsonResponse implements IRestResponse{
    
    private $charset;
    private $content;
    private $contentType;
    private $statusCode;
    private $message;
    
    private function __construct() { //blinda a classe e obriga a ser sempre chamada através dos metodos estaticos
        $this->charset = "utf-8";
        $this->content = "";
        $this->contentType = "application/json";
        $this->statusCode = 200;
        $this->message = "";
    }
    
    public function getCharset() {
        return $this->charset;
    }

    public function getContent() {
        return $this->content;
    }

    public function getContentType() {
        return $this->contentType;
    }

    public function getStatusCode() {
        return $this->statusCode;
    }
    
    public function getMessage() {
        return $this->statusCode;
    }
    
    /**
     * @return \Responses\JsonResponse
     */
    public static function CreateOkResponse($obj){
        $r = new JsonResponse();
        $r->content = json_encode($obj);
        $r->message = "OK";
        return $r;
    }
    
    /**
     * @return \Responses\JsonResponse
     */
    public static function CreateServerInternalErrorResponse($obj){
        $r = new JsonResponse();
        $r->content = json_encode($obj);
        $r->statusCode = 500;
        $r->message = "Internal Server Error";
        return $r;
    }
    
    /**
     * @return \Responses\JsonResponse
     */
    public static function CreateNotFoundResponse($obj){
        $r = new JsonResponse();
        $r->content = json_encode($obj);
        $r->statusCode = 400;
        $r->message = "Not Found";
        return $r;
    }

}
