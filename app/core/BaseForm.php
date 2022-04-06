<?php

class BaseForm
{
    protected stdClass $form;

    public Array $entity;
    public Array $option;

    public function __construct ($entity, $option)
    {
        $this->entity = $entity;
        $this->option = $option;
        $this->form = new stdClass();
    }

    /**
     * @param Array $form
     * @return void
     */
    protected function createForm (Array $form): void
    {
        foreach ($form as $key => $element) {
            $this->addElement ($key, $element);
        }
    }

    /**
     * @param array $option
     * @param String $type
     * @return array
     */
    protected function createButton (Array $option = [], String $type = 'text'): array
    {
        return  array_merge(["element" => "button","id" => "","type" => $type], $option);
    }

    /**
     * @param array $option
     * @param String $type
     * @return array
     */
    protected function createInput (Array $option = [], String $type = 'text'): array
    {
        return  array_merge(["element" => "input","id" => "","type" => $type], $option);
    }

    /**
     * @param array $option
     * @return array
     */
    protected function createSelect (Array $option = []): array
    {
        return  array_merge(["element" => "select","id" => ""], $option);
    }

    /**
     * @param String $key
     * @param array $value
     * @return void
     */
    protected function addElement (String $key, Array $value): void
    {
        $this->form->{$key} = $value;
    }

    /**
     * @return stdClass
     */
    public function getForm(): stdClass
    {
        return $this->form;
    }
}