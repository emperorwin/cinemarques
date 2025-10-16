<?php
require_once 'include/db.php';
require_once 'include/controller.php';

use Controller\CinemaController;

$controller = new CinemaController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'] ?? '';
    $horario = $_POST['horario'] ?? '';
    $data = $_POST['data'] ?? '';
    if ($descricao && $horario && $data) {
        try {
            $controller->adicionarEvento($descricao, $horario, $data);
        } catch (PDOException $e) {
            echo 'Erro ao adicionar evento: ' . htmlspecialchars($e->getMessage());
        }
    }
    header('Location: eventos.php');
    exit;
}
include 'include/header.php';
?>
    <section>
        <h2>Lista de Eventos</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Horário</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $eventos = $controller->listarEventos();
                foreach ($eventos as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DESCRICAO']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['HORARIO']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DATA']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </section>
    <form method="POST">
        <h2>Adicionar Evento</h2>
        <label for="descricao">Descrição:</label>
        <input type="text" id="descricao" name="descricao" required>
        <label for="horario">Horário:</label>
        <input type="time" id="horario" name="horario" required>
        <label for="data">Data:</label>
        <input type="date" id="data" name="data" required>
        <button type="submit">Adicionar</button>
    </form>
</body>
</html>
