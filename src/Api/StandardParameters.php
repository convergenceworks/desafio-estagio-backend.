<?php

namespace Src\Api;

trait StandardParameters
{
    /**
     * @return \SimpleXMLElement
     */
    public function initialize()
    {
        $feed = file_get_contents('https://www.correio24horas.com.br/rss/');
        return $xml = simplexml_load_string($feed);
    }

    /**
     * @param array $data
     * @param object|null $option
     * @return array
     */
    function standardData(array $data, object $option = null): array
    {
        foreach ($data as $item) {
            $arrDesc = [
                'title' => $item->title->__toString(),
                'description' => $item->description->__toString(),
                'link' => $item->link->__toString(),
                'author' => $item->author->__toString(),
                'pubDate' => $item->pubDate->__toString(),
                'category' => $item->category->__toString(),
                'content' => (empty($option) ? '' : (removeHtml($option->__toString())))
            ];
            $standarArr[] = $arrDesc;
        }
        return $standarArr;
    }
}