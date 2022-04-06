<?php

class BaseController
{
    private $view;

    protected function setView ($view)
    {
        if (!is_array($this->view)) {
            $this->view = [];
        }

        if (is_array($view) && !empty($view)) {
            $this->view = array_merge($this->view, $view);
        }
    }

    public function getView ()
    {
        return $this->view;
    }
}