<?php
session_start();

// O que temos...
// $_GET                      --> parâmetros da busca
// $_SESSION['categorias']    --> todas as categorias atualizadas
// $_SESSION['noticias']      --> todas as noticias atualizadas

function formatacaoJSON($conteudo) {
    $news = json_encode($conteudo, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $news = str_replace(['\n', '\t', 'src', '\/'[0]], '', $news);
    $news = str_replace('<img', '<span', $news);

    return $news;
}

function filtroBasico ($conteudo) {
    $news = array_map(function ($noticia) {
        return [
            'title' => $noticia['title'],
            'description' => $noticia['description'],
            'pubDate' => $noticia['pubDate']
        ];
    }, $conteudo);

    return $news;
}


interface acoesAPI {
    function ordCrescente();
    function ordDecrescente();
    function filtro();
}

class News implements acoesAPI {
    function __construct($filtro, $qnt, $cat, $ordPor, $ord) {
        $this->filtro = $filtro;
        $this->qnt = $qnt;
        $this->cat = $cat;
        $this->ordPor = $ordPor;
        $this->ord = $ord;
    }

    public function ordCrescente () {
        if ($this->ordPor == 'title') {
            foreach ($_SESSION['title'] as $title) {
                if ($title[0] == "'") {
                    $title = str_replace("'", "", $title);
                }

                $titulos[] = $title;
            }

            sort($titulos, SORT_FLAG_CASE);

            foreach ($titulos as $title) {
                foreach ($_SESSION['noticias'] as $reportagem) {
                    if ($reportagem['title'][0] == "'") {
                        $reportagem['title'] = str_replace("'", "", $reportagem['title']);
                    }

                    if ($title == $reportagem['title']) {
                        $news[] = $reportagem;
                        break;
                    }
                }
            }

        }

        else if ($this->ordPor == 'date') {
            $news = array_reverse($this->ordDecrescente());
        }

        return $news;
    }

    public function ordDecrescente () {
        if ($this->ordPor == 'title') {
            $news = $this->ordCrescente();
            rsort($news, SORT_FLAG_CASE);
        }

        else if ($this->ordPor == 'date') {
            $news = $_SESSION['noticias'];
        }

        return $news;
    }

    public function filtro () {
        if ($this->ordPor == '0' || $this->ord == '0') {
            if ($this->cat == '0') {
                echo "<h1 style='text-align: center'>Ordenação normal com todas as Categorias</h1>";
                echo "<h2 style='text-align: center; margin-bottom: 25px'>Filtro {$this->filtro}</h2>";

                $noticia = $this->filtro == 'basico' ? filtroBasico($_SESSION['noticias']) : $_SESSION['noticias'];

                for ($c = 0; $c < intval($this->qnt); $c++) {
                    $news = formatacaoJSON($noticia[$c]);
                    $pos = $c + 1;
                    echo "<h1>NOTÍCIA $pos</h1>";
                    echo "$news <br><br><br>";
                }
            }

            else {
                echo "<h1 style='text-align: center'>Ordenação normal com a Categoria: " . ucwords($this->cat) . "</h1>";
                echo "<h2 style='text-align: center; margin-bottom: 25px'>Filtro {$this->filtro}</h2>";

                $newsCat = [];
                foreach ($_SESSION['noticias'] as $reportagem) {
                    if ($reportagem['category'] == $this->cat) {
                        $newsCat[] = $reportagem;
                    }
                }

                $noticia = $this->filtro == 'basico' ? filtroBasico($newsCat) : $newsCat;

                if (intval($this->qnt) < count($noticia)) {
                    for ($c = 0; $c < intval($this->qnt); $c++) {
                        $news = formatacaoJSON($noticia[$c]);
                        $pos = $c + 1;
                        echo "<h1>NOTÍCIA $pos</h1>";
                        echo "$news <br><br><br>";
                    }
                }

                else {
                    foreach ($noticia as $c => $reportagem) {
                        $news = formatacaoJSON($reportagem);
                        $pos = $c + 1;
                        echo "<h1>NOTÍCIA $pos</h1>";
                        echo "$news <br><br><br>";
                    }
                }
            }
        }

        else if ($this->ord == 'up') {
            if ($this->cat == '0') {
                echo "<h1 style='text-align: center'>Ordenação crescente com todas as categorias ({$this->ordPor})</h1>";
                echo "<h2 style='text-align: center; margin-bottom: 25px'>Filtro {$this->filtro}</h2>";

                $reportagem = $this->ordCrescente();
                $noticia = $this->filtro == 'basico' ? filtroBasico($reportagem) : $reportagem;

                for ($c = 0; $c < intval($this->qnt); $c++) {
                    $news = formatacaoJSON($noticia[$c]);
                    $pos = $c + 1;
                    echo "<h1>NOTÍCIA $pos</h1>";
                    echo "$news <br><br><br>";
                }
            }

            else {
                echo "<h1 style='text-align: center'>Ordenação crescente com a Categoria: " . ucwords($this->cat) . " ({$this->ordPor})</h1>";
                echo "<h2 style='text-align: center; margin-bottom: 25px'>Filtro {$this->filtro}</h2>";
                
                $newsCat = [];
                $reportagem = $this->ordCrescente();
                foreach ($reportagem as $noticia) {
                    if ($noticia['category'] == $this->cat) {
                        $newsCat[] = $noticia;
                    }
                }

                $noticia = $this->filtro == 'basico' ? filtroBasico($newsCat) : $newsCat;

                if (intval($this->qnt) < count($noticia)) {
                    for ($c = 0; $c < intval($this->qnt); $c++) {
                        $news = formatacaoJSON($noticia[$c]);
                        $pos = $c + 1;
                        echo "<h1>NOTÍCIA $pos</h1>";
                        echo "$news <br><br><br>";
                    }
                }

                else {
                    foreach ($noticia as $c => $reportagem) {
                        $news = formatacaoJSON($reportagem);
                        $pos = $c + 1;
                        echo "<h1>NOTÍCIA $pos</h1>";
                        echo "$news <br><br><br>";
                    }
                }
            }
                
        }
         
        else if ($this->ord == 'down') {
            if ($this->cat == '0') {
                echo "<h1 style='text-align: center'>Ordenação decrescente com todas as categorias ({$this->ordPor})</h1>";
                echo "<h2 style='text-align: center; margin-bottom: 25px'>Filtro {$this->filtro}</h2>";

                $reportagem = $this->ordDecrescente();
                $noticia = $this->filtro == 'basico' ? filtroBasico($reportagem) : $reportagem;

                for ($c = 0; $c < intval($this->qnt); $c++) {
                    $news = formatacaoJSON($noticia[$c]);
                    $pos = $c + 1;
                    echo "<h1>NOTÍCIA $pos</h1>";
                    echo "$news <br><br><br>";
                }
            }

            else {
                echo "<h1 style='text-align: center'>Ordenação decrescente com a Categoria: " . ucwords($this->cat) . " ({$this->ordPor})</h1>";
                echo "<h2 style='text-align: center; margin-bottom: 25px'>Filtro {$this->filtro}</h2>";

                $newsCat = [];
                $reportagem = $this->ordDecrescente();
                foreach ($reportagem as $noticia) {
                    if ($noticia['category'] == $this->cat) {
                        $newsCat[] = $noticia;
                    }
                }

                $noticia = $this->filtro == 'basico' ? filtroBasico($newsCat) : $newsCat;

                if (intval($this->qnt) < count($noticia)) {
                    for ($c = 0; $c < intval($this->qnt); $c++) {
                        $news = formatacaoJSON($noticia[$c]);
                        $pos = $c + 1;
                        echo "<h1>NOTÍCIA $pos</h1>";
                        echo "$news <br><br><br>";
                    }
                }

                else {
                    foreach ($noticia as $c => $reportagem) {
                        $news = formatacaoJSON($reportagem);
                        $pos = $c + 1;
                        echo "<h1>NOTÍCIA $pos</h1>";
                        echo "$news <br><br><br>";
                    }
                }
            }
        }
    }
}


$apiNews = new News($_GET['filtro'], $_GET['qnt'], $_GET['cat'], $_GET['ordPor'], $_GET['ord']);
$apiNews->filtro();
