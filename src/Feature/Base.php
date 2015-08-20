<?php

namespace tourze\Html\Feature;
use tourze\Html\Html;

/**
 * 一些基础的方法
 *
 * @package tourze\Html\Feature
 */
trait Base
{

    /**
     * @var array 当前标签的属性值
     */
    protected $_attributes = [];

    /**
     * 读取指定属性值
     *
     * @param $name
     * @return string|array
     */
    protected function getAttribute($name)
    {
        return isset($this->_attributes[$name]) ? $this->_attributes[$name] : null;
    }

    /**
     * 设置属性值
     *
     * @param $name
     * @param $value
     * @return $this
     */
    public function setAttribute($name, $value)
    {
        $this->_attributes[$name] = $value;

        return $this;
    }

    /**
     * 合并属性值
     *
     * @return string
     */
    protected function combineAttributes()
    {
        $attributes = $this->_attributes;

        return Html::attributes($attributes);
    }

}
