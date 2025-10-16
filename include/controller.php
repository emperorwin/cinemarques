<?php

namespace Controller;
use PDO;

require_once __DIR__ . '/../include/db.php';

class CinemaController {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // ===== CLIENTES =====
    
    public function listarClientes() {
        $stmt = $this->pdo->query("SELECT * FROM CLIENTE");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarCliente($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM CLIENTE WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionarCliente($nome, $telefone) {
        $stmt = $this->pdo->prepare("INSERT INTO CLIENTE (NOME, TEL) VALUES (:nome, :telefone)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        return $stmt->execute();
    }

    public function atualizarCliente($id, $nome, $telefone) {
        $stmt = $this->pdo->prepare("UPDATE CLIENTE SET NOME = :nome, TEL = :telefone WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        return $stmt->execute();
    }

    public function deletarCliente($id) {
        $stmt = $this->pdo->prepare("DELETE FROM CLIENTE WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // ===== COLABORADORES =====
    
    public function listarColaboradores() {
        $stmt = $this->pdo->query("SELECT * FROM COLABORADORES");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarColaborador($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM COLABORADORES WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionarColaborador($nome, $cpf, $sexo, $dataNasc, $endereco, $telefone, $usuario, $senha, $tipo) {
        $stmt = $this->pdo->prepare("INSERT INTO COLABORADORES (NOME, CPF, SEXO, DATA_NASC, ENDERECO, TELEFONE, USUARIO, SENHA, TIPO) 
                                      VALUES (:nome, :cpf, :sexo, :dataNasc, :endereco, :telefone, :usuario, :senha, :tipo)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':dataNasc', $dataNasc);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        return $stmt->execute();
    }

    public function atualizarColaborador($id, $nome, $cpf, $sexo, $dataNasc, $endereco, $telefone, $usuario, $senha, $tipo) {
        $stmt = $this->pdo->prepare("UPDATE COLABORADORES SET NOME = :nome, CPF = :cpf, SEXO = :sexo, DATA_NASC = :dataNasc, 
                                      ENDERECO = :endereco, TELEFONE = :telefone, USUARIO = :usuario, SENHA = :senha, TIPO = :tipo 
                                      WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':sexo', $sexo);
        $stmt->bindParam(':dataNasc', $dataNasc);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        return $stmt->execute();
    }

    public function deletarColaborador($id) {
        $stmt = $this->pdo->prepare("DELETE FROM COLABORADORES WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // ===== EVENTOS =====
    
    public function listarEventos() {
        $stmt = $this->pdo->query("SELECT * FROM EVENTOS");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarEvento($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM EVENTOS WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionarEvento($descricao, $horario, $data) {
        $stmt = $this->pdo->prepare("INSERT INTO EVENTOS (DESCRICAO, HORARIO, DATA) VALUES (:descricao, :horario, :data)");
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':data', $data);
        return $stmt->execute();
    }

    public function atualizarEvento($id, $descricao, $horario, $data) {
        $stmt = $this->pdo->prepare("UPDATE EVENTOS SET DESCRICAO = :descricao, HORARIO = :horario, DATA = :data WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':horario', $horario);
        $stmt->bindParam(':data', $data);
        return $stmt->execute();
    }

    public function deletarEvento($id) {
        $stmt = $this->pdo->prepare("DELETE FROM EVENTOS WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    // ===== CADEIRAS =====
    
    public function listarCadeiras() {
        $stmt = $this->pdo->query("SELECT * FROM CADEIRA ORDER BY FILEIRA, NUM");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarCadeira($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM CADEIRA WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function buscarCadeiraPorPosicao($num, $fileira) {
        $stmt = $this->pdo->prepare("SELECT * FROM CADEIRA WHERE NUM = :num AND FILEIRA = :fileira");
        $stmt->bindParam(':num', $num);
        $stmt->bindParam(':fileira', $fileira);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ===== RESERVAS =====
    
    public function listarReservas() {
        $stmt = $this->pdo->query("SELECT R.*, C.NOME as CLIENTE_NOME, COL.NOME as COLABORADOR_NOME, 
                                   E.DESCRICAO as EVENTO_DESCRICAO, CAD.NUM, CAD.FILEIRA
                                   FROM RESERVA R
                                   JOIN CLIENTE C ON R.ID_CLIENTE = C.ID
                                   JOIN COLABORADORES COL ON R.ID_COLABORADOR = COL.ID
                                   JOIN EVENTOS E ON R.ID_EVENTO = E.ID
                                   JOIN CADEIRA CAD ON R.ID_CADEIRA = CAD.ID
                                   ORDER BY R.DATA DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarReserva($id) {
        $stmt = $this->pdo->prepare("SELECT R.*, C.NOME as CLIENTE_NOME, COL.NOME as COLABORADOR_NOME, 
                                     E.DESCRICAO as EVENTO_DESCRICAO, CAD.NUM, CAD.FILEIRA
                                     FROM RESERVA R
                                     JOIN CLIENTE C ON R.ID_CLIENTE = C.ID
                                     JOIN COLABORADORES COL ON R.ID_COLABORADOR = COL.ID
                                     JOIN EVENTOS E ON R.ID_EVENTO = E.ID
                                     JOIN CADEIRA CAD ON R.ID_CADEIRA = CAD.ID
                                     WHERE R.ID = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function adicionarReserva($data, $idCliente, $idColaborador, $idEvento, $idCadeira) {
        $stmt = $this->pdo->prepare("INSERT INTO RESERVA (DATA, ID_CLIENTE, ID_COLABORADOR, ID_EVENTO, ID_CADEIRA) 
                                      VALUES (:data, :idCliente, :idColaborador, :idEvento, :idCadeira)");
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->bindParam(':idColaborador', $idColaborador);
        $stmt->bindParam(':idEvento', $idEvento);
        $stmt->bindParam(':idCadeira', $idCadeira);
        return $stmt->execute();
    }

    public function deletarReserva($id) {
        $stmt = $this->pdo->prepare("DELETE FROM RESERVA WHERE ID = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function buscarCadeirasDisponiveisParaEvento($idEvento) {
        $stmt = $this->pdo->prepare("SELECT C.* FROM CADEIRA C
                                      WHERE C.ID NOT IN (
                                          SELECT R.ID_CADEIRA FROM RESERVA R WHERE R.ID_EVENTO = :idEvento
                                      )
                                      ORDER BY C.FILEIRA, C.NUM");
        $stmt->bindParam(':idEvento', $idEvento);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
