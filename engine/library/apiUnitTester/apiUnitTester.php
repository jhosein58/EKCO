<?php

namespace apiUnitTester;

class apiUnitTester
{
    private string $method = 'get';
    private string $url = '/';
    private array $params = [];
    private object $response;

    public function setMethod($method): void{
        $this->method = $method;
    }
    public function setUrl(string $url): void{
        $this->url = $url;
    }
    public function setData(array $params): void{
        $this->params = $params;
    }
    public function test(): void{
        if($this->method == 'get' or $this->method == 'GET'){
            $this->response = get($this->url);
            echo $this->response->body;
        }elseif ($this->method == 'post' or $this->method == 'POST'){
            $this->response = post($this->url, $this->params);
            echo $this->response->body;
        }else{
            echo 'ERROR: Method is wrong';
        }
    }
}