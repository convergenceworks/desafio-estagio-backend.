<?php
session_start();

$url = 'https://www.correio24horas.com.br/rss/';

$rss = new DOMDocument();
$rss->load($url);

$noticias = [];
foreach ($rss->getElementsByTagName('item') as $noticia) {
    $item = [
        'title' => $noticia->getElementsByTagName('title')[0]->textContent,
        'author' => $noticia->getElementsByTagName('author')[0]->textContent,
        'link' => $noticia->getElementsByTagName('link')[0]->textContent,
        'pubDate' => $noticia->getElementsByTagName('pubDate')[0]->textContent,
        'category' => $noticia->getElementsByTagName('category')[0]->textContent,
        'description' => $noticia->getElementsByTagName('description')[0]->textContent,
        'content' => $noticia->getElementsByTagName('encoded')[0]->textContent
    ];
    array_push($noticias, $item);
}

$categorias = [];
$title = [];
foreach ($noticias as $reportagem) {
    $news = json_encode($reportagem, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $news = str_replace(['\n', '\t', 'src', '\/'[0]], '', $news);
    $news = str_replace('<img', '<span', $news);

    array_push($categorias, $reportagem['category']);
    array_push($title, $reportagem['title']);
}

$categorias = array_unique($categorias);
$_SESSION['categorias'] = $categorias;
$_SESSION['title'] = $title;
$_SESSION['noticias'] = $noticias;

?>
