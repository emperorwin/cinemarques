
<?php
$root = realpath(__DIR__);
$database = $root . '/data/cinema.db';
$dsn = 'sqlite:' . $database;
$error = '';
if (is_readable($database) && filesize($database) > 0)
{
    $error = 'Por favor, exclua o banco de dados existente manualmente antes de instalá-lo novamente';
}
if (!$error)
{
    $createdOk = @touch($database);
    if (!$createdOk)
    {
        $error = sprintf(
            'Não foi possível criar o banco de dados, por favor, permita que o servidor crie novos arquivos em \'%s\'',
            dirname($database)
        );
    }
}
if (!$error)
{
    $sql = file_get_contents($root . '/data/init.sql');
    if ($sql === false)
    {
        $error = 'Não foi possível encontrar o arquivo SQL.';
    }
}
if (!$error)
{
    $pdo = new PDO($dsn);
    $result = $pdo->exec($sql);
    if ($result === false)
    {
        $error = 'Não foi possível executar o SQL: ' . print_r($pdo->errorInfo(), true);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Instalador</title>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
        <style type="text/css">
            .box {
                border: 1px dotted silver;
                border-radius: 5px;
                padding: 4px;
            }
            .error {
                background-color: #ff6666;
            }
            .success {
                background-color: #88ff88;
            }
        </style>
    </head>
    <body>
        <?php if ($error): ?>
            <div class="error box">
                <?php echo $error ?>
            </div>
        <?php else: ?>
            <div class="success box">
                O banco de dados e os dados de demonstração foram criados com sucesso.
            </div>
        <?php endif ?>
    </body>
</html>
