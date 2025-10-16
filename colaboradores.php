<?php

require_once 'include/controller.php';
require_once 'include/db.php';

use Controller\CinemaController;
$controller = new CinemaController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $dataNasc = $_POST['dataNasc'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    if ($nome && $cpf) {
        try {
            $controller->adicionarColaborador($nome, $cpf, $sexo, $dataNasc, $endereco, $telefone, $usuario, $senha, $tipo);
            header('Location: colaboradores.php');
        } catch (PDOException $e) {
            echo 'Erro ao adicionar colaborador: ' . htmlspecialchars($e->getMessage());
        }
    }
    exit;
}
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
    <form method="POST">
        <h2>Adicionar Colaborador</h2>
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo">
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
        </select>
        <label for="usuario">Usuário:</label>
        <input type="text" id="usuario" name="usuario" required>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
        <label for="admin">Admin:</label>
        <input type="checkbox" id="tipo" name="tipo" value="admin"> 
        <button type="submit">Adicionar</button> 

        <label for="dataNasc">Data de Nascimento:</label>
        <input type="date" id="dataNasc" name="dataNasc">
        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco">
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone">
    </form>
</body>
</html>