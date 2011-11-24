<?php
/*
Plugin Name: MyPlugin
Description: SymfonyComponentを使ったWPプラグインのテスト
Auther: Hiromi Hishida <info@77-web.com>
*/


use \Symfony\Component as SFComponent;

require_once __DIR__.'/lib/Symfony/Component/ClassLoader/UniversalClassLoader.php';
$loader = new SFComponent\ClassLoader\UniversalClassLoader();
$loader->registerNamespace('Symfony\Component', __DIR__.'/lib/');
$loader->registerNamespace('My', __DIR__.'/lib/');
$loader->register();

