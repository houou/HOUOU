<?php
$fixture = "houou";
$_app = "api";

include_once dirname(__FILE__) . '/../../bootstrap/database.php';
include_once dirname(__FILE__) . '/../../bootstrap/unit.php';

$t = new lime_test(null, new lime_output_color());

//INIT
require_once dirname(__FILE__).'/../../../config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::getApplicationConfiguration("api", 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);
$M1_API_KEY = "4bfa2544608f61d87b9f40383222baef58bc75017c63146e2ce77fbf2864a48a";
//INIT


$t->todo("APIKEY 取得用APIをつくる");
/*
$conn->beginTransaction(); $ua = new opBrowser(); //SETUP

$action = "/member/apikey.json";
$params = array("screenname" => "tenchitennou" ,"password" => md5("password"));
$ua->get($action,array());
$content = json_decode($ua->getResponse()->getContent(),true);
$t->is($content['data']['apiKey'],$M1_API_KEY,"テスト用キーと同じ");

$conn->rollback(); //TEARDOWN
*/


$conn->beginTransaction(); $ua = new opBrowser(); //SETUP

$ua->get("/activity/post.json",array("apiKey"=>"INVALID"));
$t->is($ua->getResponse()->getStatusCode(),401,"認証失敗時は401");

$ua->get("/activity/post.json",array());
$t->is($ua->getResponse()->getStatusCode(),400,"パラメータ不正は400");

$conn->rollback(); //TEARDOWN


$conn->beginTransaction(); $ua = new opBrowser(); //SETUP

$action = "/activity/post.json";
$t->comment($action);
$params = array("apiKey"=>$M1_API_KEY,
                "body" => "久方のひかりのどけき春の日にしづ心なく花のちるらむ");
$ua->get($action,$params);
$content = json_decode($ua->getResponse()->getContent(),true);

$t->is($ua->getResponse()->getStatusCode(),200,"投稿成功200");
$t->is($content['data']['body'],"久方のひかりのどけき春の日にしづ心なく花のちるらむ","res bodyは入力と同じ");


$conn->rollback(); //TEARDOWN

$t->todo("openpne apiKey がHTMLに仕込まれているか？");

$result = $t->to_array();
if(sizeof($result[0]["stats"]["failed"]) !=0)
{
  exit(1);
}else{
  exit(0);
}
