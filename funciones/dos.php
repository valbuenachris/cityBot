<?php

function dos($pdo, $from) {
    // Verificar si el estado es igual a 'inicio'
    $stmt = $pdo->prepare("SELECT status FROM sesiones WHERE user_id = ?");
    $stmt->execute([$from]);
    $status = $stmt->fetchColumn();
    
    // La primera condicion es solo una puerta. Se debe cambiar al terminar
    if ($status === 'tonico' || $status === 'protector' || $status === 'serum' || $status === 'hialuronico' || $status === 'kit' || $status === 'niacinamida' 
    || $status === 'jabon' || $status === 'cremas' || $status === 'desmaquillante' || $status === 'spray' || $status === 'ojeras'
    || $status === 'hidratar' || $status === 'rosas' || $status === 'corporal' || $status === 'mayorista' || $status === 'tonicoRespuesta' 
    || $status === 'manchas' || $status === 'contraentrega' || $status === 'faQhorario' || $status === 'faQubicacion' || $status === 'faQmayorista' || $status === 'faQgarantizado' 
    || $status === 'faQcatalogo' || $status === 'faQmanchas' || $status === 'faQcontraentrega' || $status === 'faQresultados' || $status === 'faQrutina') {
    
    // Construir el mensaje del menú
        $menuMessage = menu($pdo, $from);
    }

    elseif ($status === 'inicio') {
        
        $menuMessage = protector($pdo, $from);
    }
        
    elseif ($status === 'menuDos') {
        
        $menuMessage = spray($pdo, $from);

    }
    
    elseif ($status === 'confirmarCompra') {
        
        $menuMessage = modificarCompra($pdo, $from);

    }
    
    elseif ($status === 'faQayuda') {
        
        $menuMessage = asesor($pdo, $from);
    }
        
    elseif ($status === 'preguntas') {
        
        $menuMessage = ubicacion($pdo, $from);
    }
    
    elseif ($status === 'comprarProtector' ) {
           
            $menuMessage = comprarProtector120($pdo, $from);
    }
    
    elseif ($status === 'comprarKit' ) {
           
            $menuMessage = comprarKitIntermedio($pdo, $from);
    }
        
    elseif ($status === 'comprarSpray' ) {
           
            $menuMessage = comprarSprayBom($pdo, $from);
    }
    
    elseif ($status === 'comprarContorno' ) {
           
            $menuMessage = comprarContornoNoche($pdo, $from);
    }
    
    elseif ($status === 'comprarMantequilla' ) {
           
            $menuMessage = comprarMantequillaBom($pdo, $from);
    }
        
    elseif ($status === 'comprarCorporal' ) {
           
            $menuMessage = comprarCorporalBom($pdo, $from);
    }
    
    elseif ($status === 'comprarCombos' ) {
           
            $menuMessage = comprarComboDos($pdo, $from);
        }
    
    elseif ($status === 'confirmarCompra' ) {
           
            $menuMessage = modificarCompra($pdo, $from);
    }
        
    elseif ($status === 'metodosPago' ) {
           
            $menuMessage = nequi($pdo, $from);
    }
    
    /*
    else  {
        
        $menuMessage = noValida($pdo, $from);
    }
    */
}

?>
