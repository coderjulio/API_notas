<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if($method === 'put') {

    parse_str(file_get_contents('php://input'), $input);

    $id = $input['id'] ?? null;
    $title = $input['titulo'] ?? null;
    $body = $input['corpo'] ?? null;

    $id = filter_var($id);
    $title = filter_var($title);
    $body = filter_var($body);

    if($id && $title && $body) {

        $sql = $pdo->prepare("SELECT * FROM notas WHERE id = :id");
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0) {

            $sql = $pdo->prepare("UPDATE notas SET titulo = :titulo, corpo = :corpo WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':titulo', $title);
            $sql->bindValue(':corpo', $body);
            $sql->execute();

            $array['result'] = [
                'id' => $id,
                'titulo' => $title,
                'corpo' => $body
            ];

        } else {
            $array['error'] = 'ID inexistente';
        }

    } else {
        $array['error'] = 'Dados não enviados';
    }

} else {
    $array['error'] = 'Método não permitido (apenas PUT)';
}

require('../return.php');