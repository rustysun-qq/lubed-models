<?php
namespace Lubed\Models;
/**
 * Class TableColumnsModel from YII/GII
 *
 * @package Lubed\Models
 */
class efaultTableColumnsModel
{
    private $columns;
    private $columnNames;
    private $properties;
    private $elements;

    /**
     * TableColumnsModel constructor.
     *
     * @param $columns
     */
    public function __construct($columns)
    {
        $this->setColumns($columns);
        $this->init($columns);
    }

    /**
     * @return mixed
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param mixed $columns
     */
    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    public function getElements()
    {
        return $this->elements;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasColumn(string $name) : bool
    {
        return isset($this->columnNames[$name]);
    }

    /**
     * @return null|string
     */
    public function toString() : ?string
    {
        $str = null;
        $fields = array_column($this->getColumns(), 'name');
        if ($fields) {
            $str = implode(',', $fields);
        }

        return $str;
    }

    /**
     * @param array $columns
     */
    private function init($columns)
    {
        $properties = [];
        $elements = [];
        $fields = array_column($columns, 'name', 'comment');
        $this->columnNames = array_flip($fields);
        if ($fields) {
            foreach ($fields as $comment => $name) {
                $fieldInfo = explode('_', $name);
                $property = array_shift($fieldInfo);
                if (is_array($fieldInfo)) {
                    foreach ($fieldInfo as $word) {
                        $property .= ucfirst($word);
                    }
                }
                $properties[] = lcfirst($property);
                $elements[] = [
                    'name' => $property,
                    'property' => $property,
                    'label' => $comment,
                    'fieldName' => $name,
                ];
            }
            $this->properties = $properties;
        }
        $this->properties = $properties;
        $this->elements = $elements;
    }
}