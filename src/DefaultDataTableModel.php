<?php
namespace Lubed\Models;
/**
 * Class DataTableModel from YII/GII
 *
 * @package Lubed\Models
 */
class DefaultDataTableModel
{
    private $name;
    private $comment;
    /**
     * @var DefaultTableColumnsModel
     */
    private $columnsModel;
    private $primaryKey;

    /**
     * DataTableModel constructor.
     *
     * @param string $name
     * @param string $comment
     * @param string|array $primaryKey
     * @param array $columns
     */
    public function __construct(string $name, string $comment, $primaryKey, array $columns)
    {
        $this->setName($name);
        $this->setComment($comment);
        $this->setPrimaryKey($primaryKey);
        $this->setColumnsModel($columns);
    }

    /**
     * @return string|array
     */
    public function getPrimaryId()
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return ucfirst($matches[2]);
        }, $this->getPrimaryKey());

        return $str;
    }

    /**
     * @return string|array
     */
    public function getPrimaryIds()
    {
        $id = $this->getPrimaryId();

        //$ids = Inflector::pluralize($id);
        return $id;
    }

    /**
     * @return string|array
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param string|array $primaryKey
     */
    public function setPrimaryKey($primaryKey)
    {
        $this->primaryKey = $primaryKey;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return DefaultTableColumnsModel
     */
    public function getColumnsModel() : ?DefaultTableColumnsModel
    {
        return $this->columnsModel;
    }

    /**
     * @param array $columns
     */
    public function setColumnsModel(array $columns)
    {
        $this->columnsModel = new DefaultTableColumnsModel($columns);
    }
}