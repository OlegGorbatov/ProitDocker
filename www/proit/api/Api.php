<?php
/**
 * Базовый класс работы с API
 *
 * @author Oleg Gorbatov <o.i.gorbatov@yandex.ru>
 */
abstract class Api
{
    public $requestUri = [];
    public $requestParams = [];
    protected $postParams = '';

    protected $method = '';
    protected $action = '';

    protected $header = '"HTTP/1.1 200 Default"';

    /**
     * Api constructor.
     */
    public function __construct() {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this->requestParams = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];

        $requestUri = explode('/', trim($_SERVER['REDIRECT_URL'],'/'));
        $this->requestUri = $requestUri;
        $api = array_shift($requestUri);
        $action = array_shift($requestUri);

        if ($this->method == 'GET' and
            $api == 'api' and
            $action == 'show-contacts') {
                $this->action = 'viewAction';
        } elseif ($this->method == 'POST' and
                  $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' and
                  $api == 'api' and
                  $action == 'create-contacts') {
                      $this->postParams = file_get_contents('php://input');
                      $this->action = 'createAction';
        } else {
            header("HTTP/1.0 405 " . $this->requestStatus(405));
            throw new RuntimeException('Method not found in api ', 405);
        }
    }

    /**
     * Запуск метода АПИ
     *
     * @return mixed
     * @throws RuntimeException
     */
    public function run() {
        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            header("HTTP/1.0 405 " . $this->requestStatus(405));
            throw new RuntimeException('Invalid Method', 405);
        }
    }

    /**
     * @param object $data
     * @param int $status
     * @return false|string
     */
    protected function response($data, $status = 500) {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data);
    }

    /**
     * @param int $code
     * @return string
     */
    private function requestStatus($code) {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
            520 => 'Unknown Error',
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }

    abstract protected function viewAction();
    abstract protected function createAction();
}