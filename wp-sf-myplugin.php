<?php
/*
Plugin Name: MyPlugin
Description: SymfonyComponentを使ったWPプラグインのサンプル
Auther: Hiromi Hishida <info@77-web.com>
*/


use \Symfony\Component as SFComponent;


//ClassLoaderの設定
require_once __DIR__.'/lib/Symfony/Component/ClassLoader/UniversalClassLoader.php';
$loader = new SFComponent\ClassLoader\UniversalClassLoader();
$loader->registerNamespace('Symfony\Component', __DIR__.'/lib/');
$loader->registerNamespace('My', __DIR__.'/lib/');
$loader->register();

//Translationの設定
$messages = array('asa'=>'おはようございます。', 'hiru'=>'こんにちは！', 'yoru'=>'こんばんは。');
$translationMessageSelector = new SFComponent\Translation\MessageSelector();
$translationLoader = new SFComponent\Translation\Loader\ArrayLoader();
$translator = new SFComponent\Translation\Translator('ja', $translationMessageSelector);
$translator->addLoader('array', $translationLoader);
$translator->addResource('array', $messages, 'ja');

//記事に挨拶を追加する(実際の処理内容)
//引数の$contentは元の記事内容の文字列
function wpmyplugin_add_greeting($content)
{
  date_default_timezone_set('Asia/Tokyo');
  $hour = date('G');
  $greetingType = ($hour > 4 && $hour < 11) ? 'asa' :(($hour >10 && $hour < 16) ?  'hiru' : 'yoru');

  //global使ってるのが気持ち悪いですが、サンプル用に簡易で書いたのでm(_ _)m
  global $translator;
  $greeting = $translator->trans($greetingType);

  //挨拶を追加した$contentを返す
  return '<p id="greeting">'.$greeting.'</p>'.$content;
}

//挨拶を追加する関数を記事の表示時に呼び出すよう設定（WordPress側のフィルタに登録する。add_filterはWordPress側の関数）
add_filter('the_content', 'wpmyplugin_add_greeting');
