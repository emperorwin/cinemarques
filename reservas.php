<?php
require_once 'include/db.php';
require_once 'include/controller.php';

use Controller\CinemaController;

$controller = new CinemaController($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST['data'] ?? '';
    $idCliente = $_POST['id_cliente'] ?? '';
    $idColaborador = $_POST['id_colaborador'] ?? '';
    $idEvento = $_POST['id_evento'] ?? '';
    $idCadeira = $_POST['id_cadeira'] ?? '';
    
    if ($data && $idCliente && $idColaborador && $idEvento && $idCadeira) {
        try {
            $controller->adicionarReserva($data, $idCliente, $idColaborador, $idEvento, $idCadeira);
        } catch (PDOException $e) {
            echo 'Erro ao adicionar reserva: ' . htmlspecialchars($e->getMessage());
        }
    }
    header('Location: reservas.php');
    exit;
}
include 'include/header.php';
?>
    <section>
        <h2>Lista de Reservas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data Reserva</th>
                    <th>Data Criação</th>
                    <th>Cliente</th>
                    <th>Colaborador</th>
                    <th>Evento</th>
                    <th>Cadeira</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reservas = $controller->listarReservas();
                foreach ($reservas as $row) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DATA']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['DATA_ATUAL']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['CLIENTE_NOME']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['COLABORADOR_NOME']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['EVENTO_DESCRICAO']) . '</td>';
                    echo '<td>Fileira ' . htmlspecialchars($row['FILEIRA']) . ' - Assento ' . htmlspecialchars($row['NUM']) . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </section>
    <form method="POST">
        <h2>Adicionar Reserva</h2>
        <label for="data">Data da Reserva:</label>
        <input type="date" id="data" name="data" required>
        
        <label for="id_cliente">Cliente:</label>
        <select id="id_cliente" name="id_cliente" required>
            <option value="">Selecione um cliente</option>
            <?php
            $clientes = $controller->listarClientes();
            foreach ($clientes as $cliente) {
                echo '<option value="' . htmlspecialchars($cliente['ID']) . '">' . htmlspecialchars($cliente['NOME']) . '</option>';
            }
            ?>
        </select>
        
        <label for="id_colaborador">Colaborador:</label>
        <select id="id_colaborador" name="id_colaborador" required>
            <option value="">Selecione um colaborador</option>
            <?php
            $colaboradores = $controller->listarColaboradores();
            foreach ($colaboradores as $colaborador) {
                echo '<option value="' . htmlspecialchars($colaborador['ID']) . '">' . htmlspecialchars($colaborador['NOME']) . '</option>';
            }
            ?>
        </select>
        
        <label for="id_evento">Evento:</label>
        <select id="id_evento" name="id_evento" required>
            <option value="">Selecione um evento</option>
            <?php
            $eventos = $controller->listarEventos();
            foreach ($eventos as $evento) {
                echo '<option value="' . htmlspecialchars($evento['ID']) . '">' . htmlspecialchars($evento['DESCRICAO']) . ' - ' . htmlspecialchars($evento['DATA']) . ' ' . htmlspecialchars($evento['HORARIO']) . '</option>';
            }
            ?>
        </select>
        
        <label>Cadeira:</label>
        <table style="border-collapse: collapse; margin: 20px auto;">
            <tbody>
                <?php
                $cadeiras = $controller->listarCadeiras();
                $fileiras = [];
                foreach ($cadeiras as $cadeira) {
                    $fileiras[$cadeira['FILEIRA']][$cadeira['NUM']] = $cadeira['ID'];
                }
                
                $letras = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                
                foreach ($fileiras as $numFileira => $assentos) {
                    echo '<tr>';
                    echo '<td style="padding: 5px; font-weight: bold;">' . $letras[$numFileira - 1] . '</td>';
                    ksort($assentos);
                    foreach ($assentos as $numAssento => $idCadeira) {
                        echo '<td style="padding: 2px;">';
                        echo '<input type="radio" name="id_cadeira" id="cadeira_' . $idCadeira . '" value="' . $idCadeira . '" required style="display: none;">';
                        echo '<label for="cadeira_' . $idCadeira . '" style="display: block; width: 30px; height: 30px; border: 1px solid #333; background: #91e794ff; cursor: pointer; text-align: center; line-height: 30px; font-size: 11px;">' . $numAssento . '</label>';
                        echo '</td>';
                    }
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        
        <style>
            input[type="radio"]:checked + label {
                background: #fdff6aff !important;
                border-color: #ff5252ff !important;
            }
        </style>
        
        <button type="submit">Adicionar Reserva</button>
    </form>
</body>
</html>
