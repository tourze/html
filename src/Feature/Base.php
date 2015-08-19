<?php

namespace tourze\Html\Feature;

/**
 * 一些基础的方法
 *
 * @package tourze\Html\Feature
 */
trait Base
{

    /**
     * @var  array  默认标签的排序方式
     */
    public static $attributeOrder = [
        'action',
        'method',
        'type',
        'id',
        'name',
        'value',
        'href',
        'src',
        'width',
        'height',
        'cols',
        'rows',
        'size',
        'maxLength',
        'rel',
        'media',
        'accept-charset',
        'accept',
        'tabIndex',
        'accessKey',
        'alt',
        'title',
        'class',
        'style',
        'selected',
        'checked',
        'readonly',
        'disabled',
        'body',
    ];

    /**
     * @var array 当前标签的属性值
     */
    protected $_attributes = [];

    /**
     * 读取指定属性值
     *
     * @param $name
     * @return null|string|array
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
     * @param array $attributes
     * @return string
     */
    public static function attributes(array $attributes)
    {
        // 对属性进行排序
        $sorted = [];
        foreach (self::$attributeOrder as $key)
        {
            if (isset($attributes[$key]))
            {
                $sorted[$key] = $attributes[$key];
            }
        }
        // 再合并
        $attributes = $sorted + $attributes;

        $compiled = '';
        foreach ($attributes as $key => $value)
        {
            if (null === $value)
            {
                continue;
            }

            $compiled .= ' ' . strtolower($key);

            if ($value)
            {
                $compiled .= '="' . self::chars($value) . '"';
            }
        }

        return $compiled;
    }

    /**
     * 合并属性值
     *
     * @return string
     */
    protected function combineAttributes()
    {
        $attributes = $this->_attributes;

        return self::attributes($attributes);
    }

    /**
     * 转换一些特殊字符为实体，防止部分xss
     *
     *     echo self::chars($username);
     *
     * @param  string  $value  要转换的字符串
     * @param  boolean $encode 再编码已经存在的实体
     * @return string
     */
    public static function chars($value, $encode = true)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'utf-8', $encode);
    }

}
