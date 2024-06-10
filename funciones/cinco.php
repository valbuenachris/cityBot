<?php

    function cinco($pdo, $from) {
        // Verificar si el estado es igual a 'inicio'
        $stmt = $pdo->prepare("SELECT status FROM sesiones WHERE user_id = ?");
        $stmt->execute([$from]);
        $status = $stmt->fetchColumn();
        
        if ($status === 'inicio' ) {
            $menuMessage = kit($pdo, $from);
            }
        
        elseif ($status === 'preguntas') {
            $menuMessage = componentes($pdo, $from);
            }
        
        elseif ($status === 'menuDos') {
            $menuMessage = rosas($pdo, $from);
            }
            
        elseif ($status === 'comprarCombos' ) {
           
            $menuMessage = comprarComboCinco($pdo, $from);
        }
        
        else  {
            $menuMessage = noValida($pdo, $from);
            }
        
    }

?>
