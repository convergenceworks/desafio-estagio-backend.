<?php

namespace Src\Api;

/**
 * Class Reader
 * @package Src\Api
 */
class Reader
{
    use StandardParameters;

    /** @var $limit int */
    private $limit;

    /** @var $category string */
    private $category;

    /** @var $filter string */
    private $filter;

    /** @var $order */
    private $order;

    /**
     * Responsável por disparar os endpoints para os parâmetros
     */
    public function bootstrap(): void
    {
        $this->limit = (!empty(sanitize($_GET)['limit']) ? sanitize($_GET)['limit'] : 20);
        $this->category = (!empty(sanitize($_GET)['category']) ? sanitize($_GET)['category'] : null);
        $this->filter = (!empty(sanitize($_GET)['filter']) ? sanitize($_GET)['filter'] : null);
        $this->order = (!empty(sanitize($_GET)['order']) ? sanitize($_GET)['order'] : null);

        if (!empty($this->limit) && empty($this->category) && empty($this->filter) && empty($this->order)) {
            jsonOutput($this->notices($this->limit));
        }

        if (!empty($this->category) && empty($this->filter)) {
            jsonOutput($this->category($this->category));
        }

        if (!empty($this->filter)) {
            jsonOutput($this->basic($this->filter));
        }

        if (!empty($this->order)) {
            jsonOutput($this->order($this->order));
        }

    }

    /**
     * @param int $limit
     * @return array
     */
    public function notices(int $limit = 20): array
    {
        foreach ($this->initialize()->channel->item as $value) {
            $arr[] = $value;
            $counter = count($arr);
            $content = $value->children('content', true)->encoded;

            if (!empty($limit) & empty($category)) {
                if ($counter <= limitValidate($limit)) {
                    $arrWithLimit = [
                        'title' => $value->title->__toString(),
                        'description' => $value->description->__toString(),
                        'link' => $value->link->__toString(),
                        'author' => $value->author->__toString(),
                        'pubDate' => $value->pubDate->__toString(),
                        'category' => $value->category->__toString(),
                        'content' => (removeHtml($content->__toString()))
                    ];
                    $data[] = $arrWithLimit;
                }
            }
        }
        return $data;
    }

    /**
     * @param string $basic
     * @return array
     */
    public function basic(string $basic): array
    {
        if ($basic == "basic") {
            foreach ($this->initialize()->channel->item as $value) {
                $arr[] = [
                    "title" => $value->title->__toString(),
                    "description" => $value->description->__toString(),
                    "pubDate" => $value->pubDate->__toString()
                ];
            }
        }
        $data[] = $arr;
        return $data;
    }


    /**
     * @param string $category
     * @return array|null
     */
    public function category(string $category): ?array
    {
        foreach ($this->initialize()->channel->item as $value) {
            $content = $value->children('content', true)->encoded;

            if ($value->category == $category) {
                $arr = [
                    'title' => $value->title->__toString(),
                    'description' => $value->description->__toString(),
                    'link' => $value->link->__toString(),
                    'author' => $value->author->__toString(),
                    'pubDate' => $value->pubDate->__toString(),
                    'category' => $value->category->__toString(),
                    'content' => removeHtml($content->__toString())
                ];
                $data[] = $arr;
            }
        }

        if (!isset($data)) {
            echo 'Categoria não encontrada';
            return null;
        }

        return $data;
    }

    /**
     * @param string $type
     * @return array
     */
    public function order(string $type)
    {
        switch ($type) {
            case "title:asc":
                return $this->titleAsc();
            case "title:desc":
                return $this->titleDesc();
            case "date:asc":
                return $this->dateAsc();
            case "date:desc":
                return $this->dateDesc();
            default:
                return $this->titleAsc();
        }
    }

    /**
     * @return array
     */
    public function titleAsc(): array
    {
        foreach ($this->initialize()->channel->item as $value) {
            $arr[] = $value;
            $content = $value->children('content', true)->encoded;
            usort($arr, 'ascTitleSort');
        }

        return $this->standardData($arr, $content);
    }

    /**
     * @return array
     */
    public function titleDesc(): array
    {
        foreach ($this->initialize()->channel->item as $value) {
            $arr[] = $value;
            $content = $value->children('content', true)->encoded;
            usort($arr, 'descTitleSort');
        }
        return $this->standardData($arr, $content);
    }

    /**
     * @return array
     */
    public function dateAsc(): array
    {
        foreach ($this->initialize()->channel->item as $value) {
            $arr[] = $value;
            $content = $value->children('content', true)->encoded;
            usort($arr, 'ascDateSort');
        }
        return $this->standardData($arr, $content);
    }

    /**
     * @return array
     */
    public function dateDesc(): array
    {
        foreach ($this->initialize()->channel->item as $value) {
            $arr[] = $value;
            $content = $value->children('content', true)->encoded;
            usort($arr, 'descDateSort');
        }
        return $this->standardData($arr, $content);
    }
}
