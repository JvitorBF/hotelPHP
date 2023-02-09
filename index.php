<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <title>Hotel Eldorado</title>
</head>

<body style="">
  <div class="container">
    <form action="servico.php" method="post">
      <?php
      // Inclua a classe de conexão com o banco de dados
      include_once "database/database.php";

      // Instancie a classe de conexão com o banco de dados
      $database = new Database();

      // Obtenha a conexão com o banco de dados
      $conn = $database->getConnection();

      // Verifique se a conexão foi estabelecida com sucesso
      if ($conn) {

        // Execute a consulta SQL para selecionar todos os dados das tabelas
        $stmt_hotel = $database->runQuery("SELECT * FROM hotel");
        $stmt_quarto = $database->runQuery("SELECT * FROM quarto");

        // Obtenha o número de linhas retornadas pela consulta
        $num_hotel = $database->getRowCount($stmt_hotel);
        $num_quarto = $database->getRowCount($stmt_quarto);

        // Verifique se a consulta retornou resultados
        if ($num_hotel > 0) {
          // Exiba os resultados em HTML
          echo "<div class='title'>";
          echo "<h1>- Hotel Eldorado -</h1>";
          echo "<h4>O melhor serviço de hotelaria da cidade</h4>";
          echo "</div>";
          echo "<div class='tabelas'>";
          echo "<table border='1' style='width: 50%; margin: 20px'>";
          echo "<tr>";
          echo "<th>Hotel</th>";
          echo "<th>ID</th>";
          echo "<th>Seleção</th>";
          echo "</tr>";
          // Execute o laço de repetição para exibir cada linha retornada pela consulta
          while ($row = $stmt_hotel->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['nome_hotel'] . "</td>";
            echo "<td style='text-align: center'>" . $row['id_hotel'] . "</td>";
            # Para utilizar o JavaScript é só trocar o id pelo nome da cada, utilizando a mesma lógica do value. 
            echo "<td><input type='radio' name='hotel' id='hotel' value=" . $row['id_hotel'] . "/></td>";
            echo "</tr>";
          }
          echo "</table>";
        } else {
          echo "Não há resultados para exibir de Hoteis.";
        }

        if ($num_quarto > 0) {
          // Exiba os resultados em HTML
          echo "<table border='1' style='width: 50%; margin: 20px'>";
          echo "<tr>";
          echo "<th>Numeração</th>";
          echo "<th>Situação</th>";
          echo "<th>Camas</th>";
          echo "<th>Seleceção</th>";
          echo "</tr>";
          // Execute o laço de repetição para exibir cada linha retornada pela consulta
          while ($row = $stmt_quarto->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['num_quarto'] . "</td>";
            echo "<td style='text-align: center'>" . $row['situacao'] . "</td>";
            echo "<td style='text-align: center'>" . $row['qtd_cama'] . "</td>";
            # Para utilizar o JavaScript é só trocar o id pelo nome da cada, utilizando a mesma lógica do value. 
            echo "<td><input type='radio' name='quarto' id='quarto' value=" . $row['num_quarto'] . "/></td>";
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
      $database->closeConnection();
      ?>
      <div class="dados">
        <label for="data__entrada">Data entrada: </label>
        <input type="date" name="data__entrada" id="data__entrada">
        <label for="data__saida">Data saída: </label>
        <input type="date" name="data__saida" id="data__saida">
      </div>
      <button type="submit" style="margin-top: 20px; width: 50px; color: red; background-color: black">Enviar</button>
    </form>
  </div>
</body>

</html>