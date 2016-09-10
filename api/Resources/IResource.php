<?php

namespace api\Resources;

interface IResource {
    
    /**
     * @return \api\Responses\IRestResponse
     */
    public function getResponse();
    
}
