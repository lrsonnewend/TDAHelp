<!DOCTYPE html>
<?php
    $id_user = $_GET['id'];
    require_once '../models/game.php';
    $jogo = new Jogo;
?>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&display=swap" rel="stylesheet">
        <title>Jogos</title>
    </head>
    <body style="background-image: url('../images/gameboy.jpg'); background-size: 1240px 640px">
        <?php
            $jogo->connect("projeto_tcc", "localhost", "root", "sonnewend2006");

            $result = $jogo->getGame();

            while($row = $result->fetch(PDO::FETCH_ASSOC)){            
        ?>
        <p class="text-center mt-3" style="font-size: 4em; color: black; font-family: 'Bree Serif', serif;">Jogos</p>
        <p class="text-center mt-3">
            <a style="color: black; font-size: 1.3em;" href="../services/exit.php">Sair</a>
        </p>
        <div class="row">
            <div class="col-3">
                <div class="card-body mt-3" style="width: 18rem;">
                    <h5 class="text-center" style="font-size: 2em; font-family: 'Bree Serif', serif;">
                        <?php echo $row['nome'];?>        
                    </h5>
                    <img class="card-img-top" src="../images/pulaBloco.png" alt="Card image cap">
                    <p class="text-center">
                        <a href="<?php echo "../game.php?id={$row['id_jogo']}"; ?>">
                            <button class="btn btn-primary btn-block">Jogar</button>
                        </a>                           
                    </p>  
                </div>
            </div>
        </div>
        <?php } ?>
    </body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
crossorigin="anonymous"></script>