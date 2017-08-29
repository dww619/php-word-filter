<?php
/**
 * Created by PhpStorm.
 * User: wangyupeng
 * Date: 2017/8/29
 * Time: 上午11:32
 */

require_once 'Trie.php';

$url = "http://127.0.0.1:9502";
$post_data = array('content'=>'你好，很高兴认识你，我介绍一下自己的情况，我在青岛港集团工作，青岛人，离婚的，没孩子。我离婚主要原因是对方子宫畸形不能生育，我这方面正常。在一个就是对方性冷淡[分类:不雅词汇],为这个事情我们感情也一般。我是独生子，家族都在青岛，没孩子对我前妻压力很大，有矛盾。对方也提出离婚，我慎重考虑以后选择离婚。当然我找对象主要还是考虑性格脾气合适，找的是人生伴侣，也不单单为了孩子。。我住人民路，父亲去世了，母亲退休，我自己住，和母亲住的比较近。能介绍一下自己吗？请问你找对象什么要求？');
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

$output = curl_exec($ch);

//var_dump(curl_getinfo($ch));
curl_close($ch);

//打印获得的数据
print_r($output);
