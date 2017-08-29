<?php
/**
 * http://blog.41ms.com/post/41.html
 */

// 设置脚本最大运行内存，根据字典大小调整
ini_set('memory_limit', '512M');

// 设置时区
date_default_timezone_set('Asia/Shanghai');

// 加载助手文件
require_once('FilterHelper.php');

// http服务绑定的ip及端口
$serv = new swoole_http_server("127.0.0.1", 9502);

$serv->set(array(
    'daemonize' => 1,
    'log_file' => '/data/www/filter/log/swoole.log',
    'user' => 'www',
    'group' => 'www'
));

/**
 * 处理请求
 */
$serv->on('Request', function($request, $response) {

    // 接收get请求参数
    $content = isset($request->get['content']) ? $request->get['content']: '';

    $result = '';

    if (!empty($content)) {

        // 字典树文件路径，默认当时目录下
        $tree_file = 'blackword.tree';

        // 清除文件状态缓存
        clearstatcache();

        // 获取请求时，字典树文件的修改时间
        $new_mtime = filemtime($tree_file);

        // 获取最新trie-tree对象
        $resTrie = FilterHelper::getResTrie($tree_file, $new_mtime);

        // 执行过滤
        $arrRet = trie_filter_search_all($resTrie, $content);

        // 提取过滤出的敏感词
        $a_data = FilterHelper::getFilterWords($content, $arrRet);

        $result = json_encode($a_data);
    }

    // 定义http服务信息及响应处理结果
    $response->cookie("User", "W.Y.P");
    $response->header("X-Server", "W.Y.P WebServer(Unix) (Red-Hat/Linux)");
    $response->header('Content-Type', 'Content-Type: text/html; charset=utf-8');
    $response->end($result);
});

$serv->start();