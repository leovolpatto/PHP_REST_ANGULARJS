<?php

namespace api\Resources;

abstract class Resource implements IResource{
    
    /**
     * @var \api\Responses\JsonResponse
     */
    protected $response;
    
    /**
     * @var \api\Request
     */
    protected $request;
    
    public function __construct() {
        $this->response = \api\Responses\JsonResponse::CreateOkResponse("");
    }
    
    /**
     * @return \api\Responses\IRestResponse
     */
    public function getResponse() {
        return $this->response;
    }
    
    public function setRequest(\api\Request $request) {
        $this->request = $request;
    }
    
}
