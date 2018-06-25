<?php namespace App;

class Controller {

    protected $controller;
    protected $action;
    protected $scriptbehind;
    protected $layout;
    protected $model;
    protected $querystring;

    function __construct($_controller, $_action, $querystring, $_scriptbehind, $_layout, $_model) {
        $this->controller = $_controller;
        $this->action = $_action;
        $this->querystring = $querystring;
        $this->scriptbehind = $_scriptbehind;
        $this->layout = $_layout;
        $this->model = $_model;

        //$this->model = new $_model;
        //$this->_template = new Template($controller,$action);

    }

    function set($name,$value) {
        $this->_template->set($name,$value);
    }

    function __destruct() {
           // $this->_template->render();
    }

}