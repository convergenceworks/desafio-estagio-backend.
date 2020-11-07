<?php

/**
 * @param $a
 * @param $b
 * @return string
 */
function ascDateSort($a, $b): string
{
    $al = strtotime($a->pubDate);
    $bl = strtotime($b->pubDate);

    return $al > $bl;
}

/**
 * @param $a
 * @param $b
 * @return string
 */
function descDateSort($a, $b): string
{
    $al = strtotime($a->pubDate);
    $bl = strtotime($b->pubDate);

    return $al < $bl;
}

/**
 * @param $a
 * @param $b
 * @return string
 */
function ascTitleSort($a, $b): string
{
    $al = str_replace("'", "", mb_strtolower($a->title));
    $bl = str_replace("'", "", mb_strtolower($b->title));
    if ($al == $bl) {
        return 0;
    }

    return ($al > $bl) ? +1 : -1;
}

/**
 * @param $a
 * @param $b
 * @return string
 */
function descTitleSort($a, $b): string
{
    $al = str_replace("'", "", mb_strtolower($a->title));
    $bl = str_replace("'", "", mb_strtolower($b->title));
    if ($al == $bl) {
        return 0;
    }

    return ($al < $bl) ? +1 : -1;
}

/**
 * @param int $limit
 * @return int
 */
function limitValidate(int $limit): int
{
    if (!empty($limit) && $limit > 20) {
        return 20;
    }
    if (!empty($limit) && $limit < 0) {
        return 20;
    }
    return $limit;
}

/**
 * @param array $parameters
 * @return array
 */
function sanitize(array $parameters): array
{
    $data = [];

    foreach ($parameters as $key => $value) {
        $value = (is_numeric($value) ? filter_var($value, FILTER_SANITIZE_NUMBER_INT) :
            filter_var($value, FILTER_SANITIZE_STRIPPED));
        $data[$key] = $value;
    }
    return $data;
}

/**
 * @param string $text
 * @return string
 */
function removeHtml(string $text): string
{
    $result = preg_replace('/<[^>]*>/', '', $text);
    $result = trim(stripslashes($result));
    return html_entity_decode($result);
}

/**
 * @param $function
 */
function jsonOutput($function)
{
    echo json_encode($function, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}