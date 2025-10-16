<?php
require_once 'include/db.php';
require_once 'include/controller.php';

use Controller\CinemaController;

$controller = new CinemaController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    if ($nome && $telefone) {
        try {
            $controller->adicionarCliente($nome, $telefone);
        } catch (PDOException $e) {
            echo 'Erro ao adicionar cliente: ' . htmlspecialchars($e->getMessage());
        }
        header('Location: clientes.php');
    }
    exit;
}
include 'include/header.php';
?>
    <section>
        <h2>Lista de Clientes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $clientes = $controller->listarClientes();
                foreach ($clientes as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['NOME']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['TEL']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </section>

    <form method="POST">
        <h2>Adicionar Cliente</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required>
        <button type="submit">Adicionar</button>
    </form>
</body>
</html>