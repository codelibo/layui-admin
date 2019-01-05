<?php

/*
 * This file is part of the thans/layui-admin.
 *
 * (c) Thans <thans@thans.cn>
 *
 * This source file is subject to the Apache2.0 license that is bundled.
 */

namespace thans\layuiAdmin;

use think\View;

class Builder
{
    public $html = [];

    public $script = [];

    public $style = [];

    public $module = [
        'admin'
    ];

    public $view;

    public $css = [
        'layui' => 'vendor/layui-admin/layui/css/layui.css',
        'iconfont' => 'vendor/layui-admin/layui/modules/css/layui-icon-extend/iconfont.css',
        'admin' => 'vendor/layui-admin/css/admin.css',
    ];

    public $js = [
        'layui' => 'vendor/layui-admin/layui/layui.js',
    ];

    private $engineConfig = [];

    public function __construct($init = false)
    {
        if ($init) {
            $this->html = [];
        }
        $this->view = new View();
        $this->engineConfig['view_path'] = view_path();
        $this->engineConfig['layout_on'] = true;
        $this->engineConfig['layout_name'] = 'layout';
        $this->view->init($this->engineConfig);
    }

    final public function css($key, $css)
    {
        $this->css[$key] = $css;
        return $this;
    }

    final public function js($key, $js)
    {
        $this->js[$key] = $js;
        return $this;
    }

    final public function html($key, $html)
    {
        $this->html[$key] = $html;
        return $this;
    }

    final public function script($key, $script)
    {
        $this->script[$key] = $script;
        return $this;
    }
    
    final public function module($module)
    {
        if ($module == 'element') {
            $module = $this->module[0];
            $this->module[0] = 'element';
        }
        $this->module[] = $module;
        $this->module = array_unique($this->module);
        return $this;
    }

    final public function style($key, $style)
    {
        $this->style[$key] = $style;
        return $this;
    }

    public function fetch($vars = [], $component = false)
    {
        if ($component) {
            $this->engineConfig['layout_on'] = false;
            unset($this->engineConfig['layout_name']);
        }
        $tmpl = $this->tmpl;
        return $this->view->fetch('/'.$tmpl, $vars, $this->engineConfig);
    }
}
