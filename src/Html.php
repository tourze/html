<?php

namespace tourze\Html;

use tourze\Base\Object;
use tourze\Html\Tag\A;
use tourze\Html\Tag\Img;
use tourze\Html\Tag\Link;
use tourze\Html\Tag\Script;

/**
 * HTML助手基础
 *
 * @package tourze\Html
 */
class Html extends Object
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
     * 转换一些特殊字符为实体，防止部分xss
     *
     *     echo Html::chars($username);
     *
     * @param  string $value  要转换的字符串
     * @param  bool   $encode 再编码已经存在的实体
     * @return string
     */
    public static function chars($value, $encode = true)
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'utf-8', $encode);
    }

    /**
     * 转换内容为实体
     *
     *     echo Html::entities($username);
     *
     * @param  string $value  要转换的字符串
     * @param  bool   $encode 重复转换编码
     * @return string
     */
    public static function entities($value, $encode = true)
    {
        return htmlentities((string) $value, ENT_QUOTES, 'utf8', $encode);
    }

    /**
     * 创建一个链接
     *
     *     echo Html::anchor('/user/profile', '个人信息');
     *
     * @param  string $uri        URL
     * @param  string $title      提示文本
     * @param  array  $attributes 属性
     * @return string
     */
    public static function anchor($uri, $title = null, array $attributes = null)
    {
        if ($title === null)
        {
            $title = $uri;
        }

        $attributes['href'] = $uri;

        return (new A($attributes, $title))->render();
    }

    /**
     * 创建一个style标签，引用css
     *
     *     echo Html::style('media/css/screen.css');
     *
     * @param  string $file       文件名
     * @param  array  $attributes 默认属性
     * @return string
     */
    public static function style($file, array $attributes = null)
    {
        $attributes['href'] = $file;
        $attributes['rel'] = empty($attributes['rel']) ? 'stylesheet' : $attributes['rel'];
        $attributes['type'] = 'text/css';

        return (new Link($attributes))->render();
    }

    /**
     * 创建一个script标签
     *
     * @param  string $file       文件名
     * @param  array  $attributes 默认属性
     * @return string
     */
    public static function script($file, array $attributes = null)
    {
        $attributes['src'] = $file;
        $attributes['type'] = 'text/javascript';

        return (new Script($attributes))->render();
    }

    /**
     * 创建一个img标签
     *
     * @param  string $file       文件名
     * @param  array  $attributes 默认属性
     * @return string
     */
    public static function image($file, array $attributes = null)
    {
        $attributes['src'] = $file;

        return (new Img($attributes))->render();
    }
}
