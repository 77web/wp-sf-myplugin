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


$messages = array('asa'=>'おはようございます。', 'hiru'=>'こんにちは！', 'yoru'=>'こんばんは。');
$translationMessageSelector = new SFComponent\Translation\MessageSelector();
$translationLoader = new SFComponent\Translation\Loader\ArrayLoader();
$translator = new SFComponent\Translation\Translator('ja', $translationMessageSelector);
$translator->addLoader('array', $translationLoader);
$translator->addResource('array', $messages, 'ja');
function wpmyplugin_add_greeting($content)
{
  date_default_timezone_set('Asia/Tokyo');
  $hour = date('G');
  $greetingType = ($hour > 4 && $hour < 11) ? 'asa' :(($hour >10 && $hour < 16) ?  'hiru' : 'yoru');
  
  global $translator;
  $greeting = $translator->trans($greetingType);
  return '<p id="greeting">'.$greeting.'</p>'.$content;
}

add_filter('the_content', 'wpmyplugin_add_greeting');