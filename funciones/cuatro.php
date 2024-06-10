<?php

function cuatro($pdo, $from) {
    // Verificar si el estado es igual a 'inicio'
    $stmt = $pdo->prepare("SELECT status FROM sesiones WHERE user_id = ?");
    $stmt->execute([$from]);
    $status = $stmt->fetchColumn();
    
    // La primera condicion es solo una puerta. Se debe cambiar al terminar
    if ($status === 'inicio' ) {
        
    // Construir el mensaje del menú
        $menuMessage = hialuronico($pdo, $from);
    
        }
    
    elseif ($status === 'menuDos') {
        
        // Construir el mensaje del menú
        $menuMessage = hidratar($pdo, $from);

        }
        
    elseif ($status === 'preguntas') {
        
        // Construir el mensaje del menú
        $menuMessage = garantizado($pdo, $from);

        // Actualizar el estado 
        update_status($pdo, $from, 'garantizado');
        
    }
    
    elseif ($status === 'comprarCombos' ) {
           
            $menuMessage = comprarComboCuatro($pdo, $from);
        }
        
    else  {
        // Construir el mensaje del menú
        $menuMessage = noValida($pdo, $from);
    }
    
}

?>
