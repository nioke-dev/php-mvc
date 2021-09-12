<?php

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url_construct = $this->parseURL();

        // controller
        if (file_exists('../app/controllers/' . $url_construct[0] . '.php')) {
            $this->controller = $url_construct[0];
            unset($url_construct[0]);
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // method
        if (isset($url_construct[1])) {
            if (method_exists($this->controller, $url_construct[1])) {
                $this->method = $url_construct[1];
                unset($url_construct[1]);
            }
        }

        // params
        if (!empty($url_construct)) {
            $this->params = array_values($url_construct);
        }

        // jalankan controller dan method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
        // ini untuk menjalankan controller dan method serta mengirimkan parameter jika ada
    }
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            // Supaya bersih dari karakter karakter aneh
            $url = explode('/', $url);
            // pecah urlnya berdasarkan tanda /  menggunakan explode
            return $url;
        }
    }
}
