<?php

/*
 * Theme Manager for Yii2
 *
 * @link      https://github.com/hiqdev/yii2-thememanager
 * @package   yii2-thememanager
 * @license   BSD-3-Clause
 * @copyright Copyright (c) 2015-2016, HiQDev (http://hiqdev.com/)
 */

namespace hiqdev\thememanager\widgets;

use Yii;

class LoginForm extends \yii\base\Widget
{
    public $model;
    public $message;
    public $options = [];

    protected $_shows = [];
    protected $_pages = [];
    protected $_texts = [];
    protected $_disables = [];

    protected $_defaultTexts = [
        'restore-password' => 'I forgot my password',
        'signup' => 'Register a new membership',
        'login' => 'I already have a membership',
    ];

    protected $_scenario;
    protected $_signupPage = '/site/signup';
    protected $_restorePasswordPage = '/site/restore-password';

    public function run()
    {
        return $this->render('LoginForm', [
            'model' => $this->model,
            'widget' => $this,
        ]);
    }

    public function setPages(array $values)
    {
        return $this->setValues('_pages', $values);
    }

    public function setShows(array $values)
    {
        return $this->setValues('_shows', $values);
    }

    public function setTexts(array $values)
    {
        return $this->setValues('_texts', $values);
    }

    public function setDisables(array $values)
    {
        return $this->setValues('_disables', $values);
    }

    public function setValues($name, array $values)
    {
        foreach ($values as $action => $value) {
            if (isset($value)) {
                $this->{$name}[$action] = $value;
            }
        }
    }

    public function isShown($action)
    {
        return empty($this->_disables[$action]) && !empty($this->_shows[$action]);
    }

    public function getPage($action)
    {
        return $this->isShown($action) ? $this->buildPage($this->getPageBase($action)) : null;
    }

    public function getPageBase($action)
    {
        return isset($this->_pages[$action]) ? $this->_pages[$action] : $action;
    }

    protected function buildPage($page)
    {
        if (!$page) {
            return null;
        }
        if (!is_array($page)) {
            $page = [$page];
        }
        if (!isset($page['username']) && isset($this->model->username)) {
            $page['username'] = $this->model->username;
        }

        return $page;
    }

    public function getText($action)
    {
        return isset($this->_texts[$action]) ? $this->_texts[$action] : $this->getDefaultText($action);
    }

    public function getDefaultText($action)
    {
        return Yii::t('thememanager',
            empty($this->_defaultTexts[$action]) ? $action : $this->_defaultTexts[$action]
        );
    }
}
