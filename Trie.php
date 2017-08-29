<?php
/**
 * User: wyp@41ms.com
 * Date: 2017/8/29
 * Time: 上午10:56
 */

class Node
{
    public $value = null;
    public $children = array();
}


class Trie
{
    public $root;
    public $max_len;
    public $count = 0;

    public function __construct()
    {
        $this->root = new Node();
        mb_internal_encoding("UTF-8");
    }


    public function insert($word)
    {
        $node =& $this->root;

        $word_len = mb_strlen($word);

        if ($word_len> $this->max_len) {
            $this->max_len = $word_len;
        }

        for ($i=0; $i<$word_len; $i++) {

            $char = mb_substr($word, $i, 1);

            if (!array_key_exists($char, $node->children)) {
                $child = new Node();
                $node->children[$char] = $child;
                $node =& $node->children[$char];

            } else {
                $node =& $node->children[$char];
            }
        }

        $node->value = $word;
    }


    public function load_words($file)
    {
        $handle = fopen($file, 'r');

        while (!feof($handle)) {
            $word = rtrim(fgets($handle));

            if (!empty($word)) {
                $this->insert($word);
            }
        }
    }


    public function search($word)
    {
        $node = $this->root;

        $word_len = mb_strlen($word);

        for ($i=0; $i<$word_len; $i++) {
            $this->count++;
            $char = mb_substr($word, $i, 1);

            if (!array_key_exists($char, $node->children)) {
                return $node->value;
            } else {
                $node = $node->children[$char];
            }
        }

        return $node->value;
    }


    public function search_all($text)
    {
        $result = array();

        for ($i = 0; $i < mb_strlen($text); $i++) {
            $this->count++;
            $filter_word = $this->search(mb_substr($text, $i, $this->max_len));
            if ($filter_word) {
                $result[] = $filter_word;
            }
        }

        return array_unique($result);
    }
}