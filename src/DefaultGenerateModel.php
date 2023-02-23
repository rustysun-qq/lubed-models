<?php
namespace Lubed\Models;
/**
 * Class GenerateModel from YII/GII
 *
 * @package Lubed\Models
 */
class DefaultGenerateModel
{
    const CAMEL_NAMED = 1;//驼峰命名
    const SNAKE_NAMED = 2;//蛇形命名
    private static $nameRule; //命名规则
    private $baseNamespace, $namespace, $classId, $className, $classNote, $moduleId, $moduleName;
    /**
     * @var DefaultDataTableModel
     */
    private $tableModel;
    private $outputPath, $sourceRootPath, $composerName;
    private $requestPath, $apiRequestPath;
    /**
     * @var int $projectErrorNum
     */
    private $projectErrorNum;
    /**
     * @var string $type
     */
    private $type;
    /**
     * @var string $baseClass
     */
    private $baseClass;
    /**
     * @var string $version
     */
    private $version;
    /**
     * @var string|null $viewModalName
     */
    private $viewModalName;

    /**
     * GenerateModel constructor.
     *
     * @param array $setting
     */
    public function __construct($setting)
    {
        $this->initSetting($setting);
    }

    /**
     * @return string
     */
    public function getBaseClass(string $suffix='') : string
    {
        return $this->baseClass.($suffix?:'');
    }

    /**
     * @param string $baseClass
     */
    public function setBaseClass(string $baseClass)
    {
        $this->baseClass = $baseClass;
    }

    /**
     * @return mixed
     */
    public function getClassId()
    {
        return $this->classId;
    }

    /**
     * @param mixed $classId
     */
    public function setClassId($classId)
    {
        $this->classId = $classId;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     */
    public function setClassName($className)
    {
        $this->className = $className;
    }

    /**
     * @return mixed
     */
    public function getClassNote()
    {
        return $this->classNote;
    }

    /**
     * @param mixed $classNote
     */
    public function setClassNote($classNote)
    {
        $this->classNote = $classNote;
    }

    /**
     * @return mixed
     */
    public function getComposerName()
    {
        return $this->composerName;
    }

    /**
     * @param mixed $composerName
     */
    public function setComposerName($composerName)
    {
        $this->composerName = $composerName;
    }

    /**
     * @return string
     */
    public function getFormName()
    {
        return $this->getClassId().'Form';
    }

    /**
     * @return mixed
     */
    public function getOutputPath()
    {
        return $this->outputPath;
    }

    /**
     * @param mixed $outputPath
     */
    public function setOutputPath($outputPath)
    {
        $this->outputPath = $outputPath;
    }

    /**
     * @return int
     */
    public function getProjectErrorNum() : int
    {
        return $this->projectErrorNum;
    }

    /**
     * @param int $projectErrorNum
     */
    public function setProjectErrorNum(int $projectErrorNum)
    {
        $this->projectErrorNum = $projectErrorNum;
    }

    /**
     * @return mixed
     */
    public function getApiRequestPath()
    {
        return $this->apiRequestPath;
    }

    /**
     * @param mixed $apiRequestPath
     */
    public function setApiRequestPath($apiRequestPath)
    {
        $this->apiRequestPath = $apiRequestPath;
    }

    public function getRequestPath()
    {
        return $this->requestPath;
    }

    /**
     * @param $path
     */
    public function setRequestPath($path)
    {
        $this->requestPath = $path;
    }

    /**
     * @return mixed
     */
    public function getSourceRootPath()
    {
        return $this->sourceRootPath;
    }

    /**
     * @param mixed $sourceRootPath
     */
    public function setSourceRootPath($sourceRootPath)
    {
        $this->sourceRootPath = $sourceRootPath;
    }

    /**
     * @return DefaultDataTableModel
     */
    public function getTableModel()
    {
        return $this->tableModel;
    }

    /**
     * @param string $name
     * @param string $comment
     * @param string|array $primaryKey
     * @param array $columns
     *
     * @return bool
     */
    public function setTableModel(string $name, string $comment, $primaryKey, array $columns)
    {
        $this->tableModel = new DefaultDataTableModel($name, $comment, $primaryKey, $columns);

        return true;
    }

    /**
     * @return string
     */
    public function getType() : string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getBaseNamespace(string $suffix='')
    {
        return $this->baseNamespace.($suffix?:'');
    }

    /**
     * @param null|string $namespace
     */
    public function setBaseNamespace(?string $namespace)
    {
        $this->baseNamespace = $namespace;
    }

    /**
     * @return mixed
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param null|string $namespace
     */
    public function setNamespace(?string $namespace)
    {
        $this->namespace = $namespace;
    }

    public function getModuleId()
    {
        return $this->moduleId;
    }

    /**
     * @param $moduleId
     */
    public function setModuleId($moduleId)
    {
        $this->moduleId = $moduleId;
    }

    /**
     * @return mixed
     */
    public function getModuleName()
    {
        return $this->moduleName;
    }

    /**
     * @param null|string $moduleName
     */
    public function setModuleName(?string $moduleName)
    {
        $this->moduleName = $moduleName;
    }

    /**
     * @return string
     */
    public function getVersion() : string
    {
        return ($this->version ? '\\'.$this->version : '');
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * 生成名称
     *
     * @param string $name
     *
     * @return string
     */
    protected function generateName(string $name)
    {
        if (static::CAMEL_NAMED === static::$nameRule) {
            return $this->getCamelName($name);
        }

        return $name;
    }

    /**
     * 驼峰命名
     *
     * @param string $name
     *
     * @return string
     */
    private function getCamelName(string $name)
    {
        $names = explode('_', $name);
        $result = lcfirst(array_shift($names));
        $names = array_map(function ($value) {
            return ucfirst($value);
        }, $names);
        $result .= implode('', $names);

        return $result;
    }

    /**
     * @param $value
     * @param string $delimiter
     *
     * @return string
     */
    private function getSnakeName($value, string $delimiter = '_') : string
    {
        $value = preg_replace('/\s+/u', '', ucwords($value));

        return strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value));
    }

    /**
     * 初始化设置
     *
     * @param array $setting
     */
    private function initSetting(array $setting)
    {
        //设置
        $namespace = $setting['baseNamespace'] ?? null;
        $this->setBaseNamespace($namespace);
        $namespace = $setting['namespace'] ?? null;
        $this->setNamespace($namespace);
        $this->setProjectErrorNum($setting['projectErrorNum'] ?? 0);
        //类型
        $this->setType($setting['type'] ?? '');
        //版本
        $this->setVersion($setting['version'] ?? '');
        //基础类
        $this->setBaseClass($setting['baseClass'] ?? '');
        $composerName = $setting['composerName'] ?? null;
        $this->setComposerName($composerName);
        $sourcePath = $setting['sourcePath'] ?? null;
        $this->setSourceRootPath($sourcePath);
        $outputPath = $setting['outputPath'] ?? null;
        $this->setOutputPath($outputPath);
        $moduleName = $setting['moduleName'] ?? null;
        $moduleId = $setting['moduleId'] ?? $moduleName;
        $this->setModuleName($moduleName);
        $this->setModuleId($moduleId);
        $className = $setting['className'] ?? null;
        $this->setClassName($className);
        $classId = $className ? $this->getCamelName($className) : null;
        $this->setClassId($classId);
        $viewModalName = $this->getSnakeName($className, '-');
        $this->setViewModalName($viewModalName);
        $requestPath = sprintf('/%s/%s', $moduleName, $classId);
        $this->setRequestPath($requestPath);
        $apiRequestPath = sprintf('/%s', $classId);
        $this->setApiRequestPath($apiRequestPath);
        //table Models
        $tableName = $setting['tableName'] ?? null;
        $tableInfo = $setting['tableInfo'] ?? null;
        $tableComment = $tableInfo['comment'] ?? '';
        $this->setClassNote($tableComment);
        $primaryKey = $tableInfo['primaryKey'] ?? null;
        $primary_keys = $primaryKey && is_array($primaryKey) ? array_keys($primaryKey) : 'id';
        $columns = $tableInfo['columns'] ?? [];
        $this->setTableModel($tableName, $tableComment, $primary_keys, $columns);
    }

    /**
     * @return string|null
     */
    public function getViewModalName() : ?string
    {
        return $this->viewModalName;
    }

    /**
     * @param string|null $viewModalName
     */
    public function setViewModalName(?string $viewModalName) : void
    {
        $this->viewModalName = $viewModalName;
    }
}