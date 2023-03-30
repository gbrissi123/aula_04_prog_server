<?php
include('bd.php');

if(isset($_GET['altura']) && isset($_GET['peso']) && isset($_GET['nome'])) {
    $bd->insert("formulario", [
        "nome" => $_GET['nome'],
        "altura" => $_GET['altura'],
        "peso" => $_GET['peso']
    ]);
}

function classificacaoImc($peso, $altura) {
    $imc = 0;
    if ($peso != 0 && $altura != 0) {
        $imc = $peso / ($altura * $altura);
    }
    
    if($imc < 18.5) {
        return 'MAGREZA';
    } else if($imc < 24.9) {
        return 'NORMAL';
    } else if($imc < 29.9) {
        return 'SOBREPESO';
    } else if($imc < 39.9) {
        return 'OBESIDADE';
    } else {
        return 'OBESIDADE GRAVE';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Calculo IMC</title>
</head>
 
<body class="bg-gray-100">
    <form action="formulario.php" method="GET" class="w-full max-w-[768px] flex flex-col p-10 border shadow mx-auto mt-10 bg-white space-y-3">
        <?php
        if (isset($_GET['altura']) && isset($_GET['peso']) && isset($_GET['nome'])) :
        ?>
            <div><b><?php echo $_GET['nome'] ?></b><span>, aqui estão suas informações: </span></div>
            <br>
            <div><b>Altura(m):</b> <?php echo $_GET['altura'] ?></div>
            <div><b>Peso(kg):</b> <?php echo $_GET['peso'] ?></div>
            <div><b>Seu IMC é de: </b> <?php echo $_GET['peso'] / ($_GET['altura'] * $_GET['altura']) ?></div>
            <div><b>Classificação de IMC: </b> <?php echo classificacaoImc($_GET['peso'], $_GET['altura']) ?></div>
        
            <div class='w-full max-w-[768px] flex flex-col p-10 border shadow mx-auto mt-10 bg-white space-y-3'>
                <h2><b>Dados de outros usuários: </b></h2>
                <?php
                    $data = $bd->select('formulario', ['nome', 'peso', 'altura']);
                    foreach($data as $item) {
                        $imc = classificacaoImc($item['peso'], $item['altura']);

                        echo "<p>Nome do usuario: <b>{$item['nome']}</b></p>";
                        echo "<p>Altura: <b>{$item['altura']}</b></p>";
                        echo "<p>Peso: <b>{$item['peso']}</b></p>";
                        echo "<p>IMC: <b>$imc</b></p><br><br>";
                    }
               ?>
            </div>

            <a href="formulario.php" class="text-blue-500 font-bold">Voltar</a>

        <?php
        return;
        endif;
        ?>

        <input type="text" name="nome" placeholder="Seu nome, ex: João Paulo" class="py-2 px-2 border border-gray-300 outline-none">
        <input type="number" step="0.01" name="altura" placeholder="Altura(m), ex: 1.78" class="py-2 px-2 border border-gray-300 outline-none">
        <input type="number" step="0.01" name="peso" placeholder="Peso(kg), ex: 78" class="py-2 px-2 border border-gray-300 outline-none">
        <button type="submit" class="bg-blue-500 text-white font-bold py-2">Enviar</button>
    </form>
</body>
 
</html>