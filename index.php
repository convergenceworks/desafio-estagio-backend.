<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Correio</title>
</head>
<body class="bg-secondary text-white">
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="index.php">API de Notícias</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavDropdown">

            <form action="index.php" method="get">
                <ul class="navbar-nav fix-alinhar mb-2">
                    <li class="nav-item">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary mt-2">
                                <input type="radio" name="filtro" id="filtro-basico" value="basico"> Filtro Básico
                            </label>
                            <label class="btn btn-secondary ml-2 mt-2">
                                <input type="radio" name="filtro" id="filtro-normal" value="normal"> Filtro Normal
                            </label>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <div class="input-group mt-2">
                            <div class="input-group-prepend ml-3">
                                <label class="input-group-text bg-dark text-muted category" for="inputGroupSelect01">Qnt. Notícias</label>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01" name="qnt">
                                <option selected value="20">Todas</option>
                                <option value="1">1 Notícia</option>
                                <?php
                                    for ($c = 2; $c <= 20; $c++) {
                                        echo "<option value='$c'>$c Notícias</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <div class="input-group mt-2">
                            <div class="input-group-prepend ml-2">
                                <label class="input-group-text bg-dark text-muted category" for="inputGroupSelect01">Ordenação por</label>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01" name="ordPor">
                                <option selected value="0">Normal</option>
                                <option value="title">Título</option>
                                <option value="date">Data</option>
                            </select>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <div class="input-group mt-2">
                            <div class="input-group-prepend ml-2">
                                <label class="input-group-text bg-dark text-muted category" for="inputGroupSelect01">Ordenação</label>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01" name="ord">
                                <option selected value="0">Normal</option>
                                <option value="up">Crescente</option>
                                <option value="down">Decrescente</option>
                            </select>
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <div class="input-group mt-2">
                            <div class="input-group-prepend ml-2">
                                <label class="input-group-text bg-dark text-muted category" for="inputGroupSelect01">Categorias</label>
                            </div>
                            <select class="custom-select" id="inputGroupSelect01" name="cat">
                            <option selected value="0">Todas</option>
                            <?php
                                foreach ($_SESSION['categorias'] as $cat) {
                                    echo "<option value='$cat'>". ucwords($cat) . "</option>";
                                }
                            ?>
                            </select>
                        </div>
                    </li>

                    <li class="fix-alinhar3 mt-2">
                        <button class="btn btn-outline-info my-2 my-sm-0 ml-5" type="submit">Search</button>
                    </li>
                </ul>
            </form>

        </div>
    </nav>


    <div id="conteudoNoticia">
        <?php
            if (count($_GET) == 5) {
                include('filtros.php');
            }
            else {
                include('home.html');
            }
        ?>
    </div>

    <footer class="fixed-bottom">
        Desenvolvido por LUCAS LIMA 👨‍💻
    </footer>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $('#conteudoNoticia').hide().show(3000)

        $('footer')
            .css('background-image', 'linear-gradient(to right, gray, black)')
            .css('text-align', 'center')
            .css('font-size', '1.4em')

        $('#api')
            .css('display', 'flex')
            .css('flex-direction', 'column')
            .css('align-items', 'center')
        
        $('#msg')
            .css('background-image', 'linear-gradient(to right, black, gray)')
            .css('display', 'flex')
            .css('justify-content', 'center')
            .css('align-items', 'center')
            .css('text-align', 'center')
            .css('font-size', '3em')
            .css('margin-bottom', '50px')
            .css('width', '100vw')
            .css('height', '70vh')
    </script>
</body>
</html>