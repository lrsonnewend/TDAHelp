<!DOCTYPE html>
<?php
    require_once '../models/avaliacao.php';
    $avaliacao = new Avaliacao;
    $id_avaliacao = $_GET['id'];
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
    crossorigin="anonymous">
    <link rel="stylesheet" href="../css/login.css">
    <title>Ver avaliação</title>
</head>
<body style="background-image: url('../images/cow.jpg'); background-size: 200px 150px;">
    <div class="container mt-3">
    <?php
        $avaliacao->connect("projeto_tcc", "localhost", "root", "sonnewend2006");
        $result = $avaliacao->getAvaliacaoById($id_avaliacao);

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
    ?>
        <form method="POST">
            <div class="form-group">
                <label style="color:white" for="nome_jogo"><b>Nome do usuário</b></label>
                <input type="text" name="nome_usuario" class="form-control" value="<?php echo $row['nome_usuario'];?>" disabled>
            </div>

            <div class="form-group"> 
                <label style="color:white" for="nome_jogo"><b>Jogo</b></label>
                <input type="text" name="nome_jogo" class="form-control" value="<?php echo $row['nome_jogo'];?>" disabled>
            </div>

            <div class="form-group"> 
                <label style="color:white" for="nome_jogo"><b>Categoria</b></label>
                <input type="text" name="nome_jogo" class="form-control" value="<?php echo $row['nome_jogo'];?>" disabled>
            </div>

            <div class="form-group">
                <label style="color:white" for="pontuacao"><b>Pontuação máxima</b></label>
                <input type="number" name="pontuacao" class="form-control" value="<?php echo $row['pontuacao'];?>" disabled>
            </div>

            <div class="form-group">
                <label style="color:white" for="nivel"><b>Nível máximo conquistado</b></label>
                <input type="number" name="nivel" class="form-control" value="<?php echo $row['nivel'];?>" disabled>
            </div>
            
            <div class="form-group">
                <label style="color:white" for="auto_avaliacao"><b>Feedback do usuário</b></label>
                <textarea class="form-control" name="auto_avaliacao" rows="3" disabled><?php echo $row['auto_avaliacao'];?></textarea>
            </div>
            
            
            <div class="form-group">
                <a href="./avaliacoesAdm.php">
                    <button class="btn btn-success" type="button">Voltar</button>
                </a>
            </div>    
        </form>
        <?php } ?>
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