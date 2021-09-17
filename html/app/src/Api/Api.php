<?php

namespace App\Api;

abstract class Api
{
    public string $apiName = '';

    protected string $method = '';
    protected string $action = '';

    public array $requestUri = [];
    public array $requestParams = [];


    public function __construct()
    {
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->requestParams = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            } elseif ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            } else {
                throw new \Exception('Unexpected header');
            }
        }
    }

    public function run()
    {
        if (array_shift($this->requestUri) !== 'api' ||
            array_shift($this->requestUri) !== $this->apiName
        ) {
            throw new \RuntimeException('API Not Found', 404);
        }
        $this->action = $this->getAction();

        if (method_exists($this, $this->action)) {

            return $this->{$this->action}();

        } else {

            throw new \RuntimeException('Invalid method', 405);
        }
    }

    protected function response($data, $responseCode = 500)
    {
        header('HTTP/1.1 ' . $responseCode . ' ' . $this->getResponseStatusByCode($responseCode));
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json; charset=utf-8");
        return json_encode($data);
    }

    private function getResponseStatusByCode($responseCode)
    {
        $status = array(
            200 => 'OK',
            400 => 'Bad Request',
            404 => 'Not found',
            405 => 'Method not allowed',
            500 => 'Internal server error',
        );
        return ($status[$responseCode]) ?: '';
    }

    protected function getAction()
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if($this->requestUri) {
                    return 'viewAction';
                } else {
                    return 'indexAction';
                }
                break;
            case 'POST':
                return 'createAction';
                break;
            case 'PUT':
                return 'updateAction';
                break;
            case 'DELETE':
                return 'deleteAction';
                break;
            default:
                return '';
        }
    }

    abstract protected function indexAction();
    abstract protected function viewAction();
    abstract protected function createAction();
    abstract protected function updateAction();
    abstract protected function deleteAction();

}
