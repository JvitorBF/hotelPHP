<?php
include_once "database/database.php";

if ($_POST) {
    $hotel = $_POST['hotel'];
    $quarto = $_POST['quarto'];
    $data_entrada = $_POST['data__entrada'];
    $data_saida = $_POST['data__saida'];

    //formatando datas
    $formato = "Y-m-d";
    $data_entrada_formatada = date($formato, strtotime($data_entrada));
    $data_saida_formatada = date($formato, strtotime($data_saida));

    $database = new Database();
    $conn = $database->getConnection();
    if ($conn) {
        $stmt_quarto = $database->runQuery("SELECT * FROM quarto WHERE num_quarto = '$quarto' AND (data_entrada BETWEEN  '$data_entrada_formatada' AND  '$data_saida_formatada' OR data_saida BETWEEN  '$data_entrada_formatada' AND  '$data_saida_formatada');");
        if ($stmt_quarto) {
            $num_quarto = $stmt_quarto->rowCount();
            if ($num_quarto > 0) {
                echo "Desculpe, as datas já foram reservadas!";
            } else {
                $insert_quarto = $database->runQuery("UPDATE quarto SET situacao = 1, data_entrada = :data_entrada, data_saida = :data_saida WHERE num_quarto = :quarto", [
                    ':quarto' => $quarto,
                    ':data_entrada' => $data_entrada_formatada,
                    ':data_saida' => $data_saida_formatada,
                ]);
                if ($insert_quarto) {
                    echo "<br><br>";
                    echo "Tudo certo! Reserva concluída :)";
                    echo "Dados da sua reserva: ";
                    echo "Hotel: $hotel";
                    echo "Quarto: $quarto";
                    echo "Data entrada: $data_entrada";
                    echo "Data saida: $data_saida";
                } else {
                    echo "Houve um erro ao realizar a reserva.";
                }
            }
        } else {
            echo "A consulta falhou";
        }
    }
}
