<?php

namespace api\Responses;

interface IRestResponse {
    
    public function getStatusCode();
    public function getContentType();
    public function getCharset();
    public function getContent();    
    public function getMessage();    
    
}
