<?php

include_once "database/database.php";

if ($_POST) {
    $id_quarto = $_POST['quarto'];
    $data_entrada = $_POST['data_entrada'];
    $data_saida = $_POST['data_saida'];

    $config = require 'config.php';
    $database = new Database($config['host'], $config['db_name'], $config['username'], $config['password']);
    $conn = $database->getConnection();
    if (!$conn) {
        throw new Exception("Falha na conexão com o banco de dados");
    }

    $reservas = $database->runQuery("SELECT * FROM locacao WHERE id_quarto = '$id_quarto' AND (data_entrada BETWEEN  '$data_entrada' AND  '$data_saida' OR data_saida BETWEEN  '$data_entrada' AND  '$data_saida');");

    if (!$reservas) {
        throw new Exception("Houve um erro ao consultar as reservas");
    }

    if ($reservas->rowCount() > 0) {
        exit("Desculpe, as datas já foram reservadas ou você selecionou uma data que já está ocupada.");
    } else {
        // Insere uma nova reserva para o quarto selecionado
        $nova_reserva = $database->runQuery("INSERT INTO locacao (id_quarto, data_entrada, data_saida) 
        VALUES (:id_quarto, :data_entrada, :data_saida);", [
            ':id_quarto' => $id_quarto,
            ':data_entrada' => $data_entrada,
            ':data_saida' => $data_saida,
        ]);

        if ($nova_reserva) {
            echo "<br>";
            echo "Tudo certo! Reserva concluída :)";
            echo "<br>";
            echo "Dados da sua reserva: ";
            echo "<br>";
            echo "Quarto: $id_quarto";
            echo "<br>";
            echo "Data entrada: $data_entrada";
            echo "<br>";
            echo "Data saida: $data_saida";
        } else {
            echo "Houve um erro ao realizar a reserva.";
        }

        if (!$nova_reserva) {
            // reverte a situação do quarto para "indisponível"
            $update_quarto = $database->runQuery("UPDATE quarto SET situacao = 'true' WHERE num_quarto = :id_quarto", [
                ':id_quarto' => $id_quarto
            ]);

            if (!$update_quarto) {
                throw new Exception("Houve um erro ao reverter a situação do quarto");
            }
            throw new Exception("Houve um erro ao inserir a reserva");
        }
    }
}
