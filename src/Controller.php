<?php

namespace PHPCensor;

use PHPCensor\Http\Request;
use PHPCensor\Http\Response;

abstract class Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Config
     */
    protected $config;

    /**
     * @param Config  $config
     * @param Request $request
     */
    public function __construct(Config $config, Request $request)
    {
        $this->config   = $config;
        $this->request  = $request;
    }

    /**
     * Initialise the controller.
     */
    abstract public function init();

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function hasAction($name)
    {
        if (method_exists($this, $name)) {
            return true;
        }

        if (method_exists($this, '__call')) {
            return true;
        }

        return false;
    }

    /**
     * Handles an action on this controller and returns a Response object.
     *
     * @param string $action
     * @param array  $actionParams
     *
     * @return Response
     */
    public function handleAction($action, $actionParams)
    {
        return call_user_func_array([$this, $action], $actionParams);
    }

    /**
     * Get a hash of incoming request parameters ($_GET, $_POST)
     *
     * @return array
     */
    public function getParams()
    {
        return $this->request->getParams();
    }

    /**
     * Get a specific incoming request parameter.
     *
     * @param string $key
     * @param mixed  $default Default return value (if key does not exist)
     *
     * @return mixed
     */
    public function getParam($key, $default = null)
    {
        return $this->request->getParam($key, $default);
    }

    /**
     * Change the value of an incoming request parameter.
     *
     * @param string $key
     * @param mixed  $value
     */
    public function setParam($key, $value)
    {
        $this->request->setParam($key, $value);
    }

    /**
     * Remove an incoming request parameter.
     *
     * @param string $key
     */
    public function unsetParam($key)
    {
        $this->request->unsetParam($key);
    }
}
