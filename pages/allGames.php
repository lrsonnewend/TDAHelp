<!DOCTYPE html>
<?php
    require_once '../models/game.php';
    $game = new Jogo;
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
    <title>Jogos</title>
</head>
<body>
<body style="background-image: url('../images/cow.jpg'); background-size: 200px 150px;">
        <div class="row mt-3">
            <div class="container">Jogos</h2>
                <a href="./avaliacoesAdm.php">Voltar</a>              
                <table class="table mt-3">
                        <thead>
                            <tr>
                                <th style="color: white;" scope="col">#</th>
                                <th style="color: white;" scope="col">Nome</th>
                                <th style="color: white;" scope="col">Categoria</th>
                            </tr>
                        </thead>
                        <?php
                            $game->connect("projeto_tcc", "localhost", "root", "sonnewend2006");
                            $i = 0;
                            $result = $game->getGame();

                            while($row = $result->fetch(PDO::FETCH_ASSOC)){            
                                $i+=1;
                        ?>
                        <tbody>
                            <tr>  
                                <td style="color: white;"><?php echo $i; ?></td>
                                <td style="color: white;"><?php echo $row['nome'];?></td>
                                <td style="color: white;"><?php echo $row['categoria'];?></td>
                            </tr>
                        </tbody>
                        <?php } ?>
                    </table>        
                </div>
            </div>
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
