<?php
require('../config.php');

$method = strtolower($_SERVER['REQUEST_METHOD']);

if( $method ==='get') {
    $sql = $pdo->query("SELECT * FROM notas");
    if($sql->rowCount() > 0) {
        $data = $sql->fetchall(PDO::FETCH_ASSOC);
        foreach($data as $item) {
            $array['result'][] = [
                'id' => $item['id'],
                'titulo' => $item['titulo']
            ];
        }
    }
}else {
    $array ['error'] = 'Método não permitido(apenas GET)';
}

require('../return.php');
