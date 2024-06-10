<?php

function nueve($pdo, $from) {
    // Verificar si el estado es igual a 'inicio'
    $stmt = $pdo->prepare("SELECT status FROM sesiones WHERE user_id = ?");
    $stmt->execute([$from]);
    $status = $stmt->fetchColumn();
    
    if ($status === 'inicio') {
        // Construir el mensaje del menú
        $menuMessage = menuDos($pdo, $from);
    }

    elseif ($status === 'menuDos') {

        $menuMessage = menu($pdo, $from);
    }
    
    elseif ($status === 'preguntas') {
        $menuMessage = catalogo($pdo, $from);
    }
    
    else  {
        $menuMessage = noValida($pdo, $from);
    }
    
}

?>
