<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Hotel Eldorado</title>
</head>

<body>
  <div class="container">
    <form action="servico.php" method="post">
      <div class='title'>
        <h1>- Hotel Eldorado -</h1>
        <h4>O melhor serviço de hotelaria da cidade</h4>
      </div>
      <div class='tabelas'>
        
        <?php
        include_once 'database/database.php';

        $config = require 'config.php';
        $database = new Database($config['host'], $config['db_name'], $config['username'], $config['password']);
        $conn = $database->getConnection();

        if ($conn) {
          $stmt_hotel = $database->runQuery("SELECT * FROM hotel");
          $stmt_quarto = $database->runQuery("SELECT * FROM quarto");

          $num_hotel = $database->getRowCount($stmt_hotel);
          $num_quarto = $database->getRowCount($stmt_quarto);

          if ($num_hotel > 0) {
            echo '<div class="tabelas">';
            echo '<table border="1" style="width: 50%; margin: 20px">';
            echo '<tr>';
            echo '<th>Hotel</th>';
            echo '<th>ID</th>';
            echo '</tr>';

            while ($row = $stmt_hotel->fetch(PDO::FETCH_ASSOC)) {
              echo '<tr>';
              echo '<td>' . $row['nome_hotel'] . '</td>';
              echo '<td style="text-align: center">' . $row['id_hotel'] . '</td>';
              echo '</tr>';
            }

            echo '</table>';
          } else {
            echo 'Não há resultados para exibir de Hoteis.';
          }

          if ($num_quarto > 0) {
            // Exiba os resultados em HTML
            echo "<table border='1' style='width: 50%; margin: 20px'>";
            echo "<tr>";
            echo "<th>Numeração</th>";
            echo "<th>Situação</th>";
            echo "<th>Camas</th>";
            echo "<th>ID hotel</th>";
            echo "<th>Seleceção</th>";
            echo "</tr>";
            // Execute o laço de repetição para exibir cada linha retornada pela consulta
            while ($row = $stmt_quarto->fetch(PDO::FETCH_ASSOC)) {
              echo "<tr>";
              echo "<td>" . $row['num_quarto'] . "</td>";
              echo "<td style='text-align: center'>" . $row['situacao'] . "</td>";
              echo "<td style='text-align: center'>" . $row['qtd_cama'] . "</td>";
              echo "<td style='text-align: center'>" . $row['id_hotel'] . "</td>";
              # Para utilizar o JavaScript é só trocar o id pelo nome da cada, utilizando a mesma lógica do value. 
              echo "<td><input type='radio' name='quarto' id='quarto' value=" . $row['id_quarto'] . "/></td>";
              echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
          } else {
            echo "Não há resultados para exibir de Quartos.";
          }
        } else {
          echo "Não foi possível estabelecer a conexão com o banco de dados.";
        }
        // Feche a conexão com o banco de dados
        $database->__destruct();
        ?>
        <div class="dados">
          <label for="data__entrada">Data entrada: </label>
          <input type="date" name="data_entrada" id="data_entrada">
          <label for="data__saida">Data saída: </label>
          <input type="date" name="data_saida" id="data_saida">
        </div>
        <button type="submit" style="margin-top: 20px; width: 50px; color: red; background-color: black">Enviar</button>
    </form>
  </div>
</body>

</html>