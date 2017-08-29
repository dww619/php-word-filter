<?php

require_once 'Trie.php';

// 设置内存
ini_set('memory_limit', '1024M');


$words_file = 'dict.txt';


// 初始化 trie
$trie = new Trie();

// 加载敏感词字典库
$trie->load_words($words_file);

// 生成trie-tree文件
$blackword_tree = 'blackword.tree';

file_put_contents($blackword_tree, gzdeflate(serialize($trie), 5));

echo (memory_get_usage() / 1024 / 1024) . ' M';