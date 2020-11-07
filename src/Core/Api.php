<?php

namespace Src\Core;

/**
 * Class Api
 * @package Src\Core
 */
class Api
{
    /** @var $route Api */
    private $route;

    /** @var $class Api */
    private $class;

    /** @var $method Api */
    private $method;

    /**
     * @param $route
     * @param $class
     * @param $method
     */
    public function get($route, $class, $method)
    {
        $this->route = $route;
        $this->class = "\\Src\\Api\\" . $class;
        $this->method = $method;

        $this->validateRoute($this->class, $this->method);

        if (empty($_SERVER['PATH_INFO'])) {
            return http_response_code(404);
        }

        if ($_SERVER['PATH_INFO'] == $this->route) {
            call_user_func(array(new $this->class, $this->method));
            return http_response_code(200);
        } else {
            return http_response_code(404);
        }
    }

    /**
     * @param $class
     * @param $method
     * @return Api
     */
    public function validateRoute($class, $method)
    {
        if (!class_exists($class)) {
            http_response_code(404);
            return null;
        }

        if (!method_exists($class, $method)) {
            http_response_code(405);
            return null;
        }

        $this->class = $class;
        $this->method = $method;
        return $this;
    }

    public function message(string $message): string
    {
        echo json_encode($message);
    }

}