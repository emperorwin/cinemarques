<?php

require_once 'include/controller.php';
require_once 'include/db.php';

use Controller\CinemaController;
$controller = new CinemaController($pdo);

include 'include/header.php';

?>
    <section>
        <h2>Lista de Colaboradores</h2>
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
                $colaboradores = $controller->listarColaboradores();
                foreach ($colaboradores as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['NOME']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['CPF']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </section>
    <form>
        <h2>Adicionar Colaborador</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>
        <button type="submit">Adicionar</button>
    </form>
</body>
</html>