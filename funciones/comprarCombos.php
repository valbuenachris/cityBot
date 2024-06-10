<?php

function comprarCombos($pdo, $from) {
    
    // Verificar si el estado es igual a 'inicio'
    $stmt = $pdo->prepare("SELECT status FROM sesiones WHERE user_id = ?");
    $stmt->execute([$from]);
    $status = $stmt->fetchColumn();
    
    // Incluir el archivo que contiene la API key
    require_once 'api_key.php';
    
    // La primera condicion es solo una puerta. Se debe cambiar al terminar
    if ($status === 'combos') {
      
    // Mensajes de texto
    $mensajes = array(
        
        "1️⃣ Combo 1   \n2️⃣ Combo 2 \n3️⃣ Combo 3  \n4️⃣ Combo 4  \n5️⃣ Combo 5  \n6️⃣ Super Dúo"
        
        );

    // Enviar cada mensaje de texto
    foreach ($mensajes as $mensaje) {
        enviarMensajecomprarCombos($from, $mensaje);
    }
    
    // Actualizar el estado 
    update_status($pdo, $from, 'comprarCombos');
    
    } 
}


// Función para enviar mensajes de texto
function enviarMensajecomprarCombos($from, $mensaje) {
    enviarMensajescomprarCombos($from, $mensaje);
}

// Función genérica para enviar mensajes
function enviarMensajescomprarCombos($from, $mensaje) {
    $api_key = API_KEY;
    $body = array(
        "api_key" => $api_key,
        "receiver" => $from,
        "data" => array("message" => $mensaje)
    );
    return sendCurlRequestText($body);
}

?>

