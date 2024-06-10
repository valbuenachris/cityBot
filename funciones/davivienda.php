<?php


function davivienda($pdo, $from) {
    try {
        
        // Incluir el archivo que contiene la API key
        require_once 'api_key.php';
    
        
        // Construir el mensaje del menú
        $menuMessage = "🏦 ¡Aquí tienes los datos de nuestra cuenta bancaria para que puedas realizar tu transferencia!

ℹ️ Banco: DAVIVIENDA
💼 Tipo de cuenta: DAVIPLATA
💰 Número de cuenta: 3132735796
👤 Titular: Albenis Lozano

¡Gracias por elegirnos para tus compras!";
        
    
        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
    
        // Mensaje de texto con el menú
        $body = array(
            "api_key" => $api_key,
            "receiver" => $from,
            "data" => array("message" => $menuMessage)
        );
    
        // Enviar solicitud de texto
            $response = sendCurlRequestText($body);
        
        /*/////////////   MENSAJE   ////////////*/
    
        $stmt = $pdo->query("SELECT * FROM subHeaderComprobante ORDER BY RAND() LIMIT 1");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Construir el mensaje del menú
        $menuMessage = "";
        foreach ($menuItems as $item) {
            $menuMessage .= "{$item['mensaje']}\n";
        }
    
        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
    
        // Mensaje de texto con el menú
        $body = array(
            "api_key" => $api_key,
            "receiver" => $from,
            "data" => array("message" => $menuMessage)
        );
    
        // Enviar solicitud de texto
            $response = sendCurlRequestText($body);
            
        // Construir el mensaje del menú
            $menuMessage = menuComprobante($pdo, $from);
    
        
        // Actualizar el estado 
        update_status($pdo, $from, 'comprobante');

    } catch (PDOException $e) {
        // Manejar errores de la base de datos
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ]
        ];
    } catch (Exception $e) {
        // Manejar otros errores
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error: ' . $e->getMessage()
            ]
        ];
    }
}

?>
