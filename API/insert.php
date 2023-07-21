<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'post') {

    $title = filter_input(INPUT_POST, 'titulo');
    $body = filter_input(INPUT_POST, 'corpo');

    if($title && $body) {

        $sql = $pdo->prepare("INSERT INTO notas (titulo, corpo) VALUES (:titulo, :corpo)");
        $sql->bindValue(':titulo', $title);
        $sql->bindValue(':corpo', $body);
        $sql->execute();

        $id = $pdo->lastInsertId();

        $array['result'] = [
            'id' => $id,
            'titulo' => $title,
            'corpo' => $body
        ];

    } else {
        $array['error'] = 'Campos não enviados';
    }

} else {
    $array['error'] = 'Método não permitido (apenas POST)';
}

require('../return.php');