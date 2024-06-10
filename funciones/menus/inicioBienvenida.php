<?php


function inicioBienvenida($pdo, $from) {
    try {
        
        // Incluir el archivo que contiene la API key
        require_once __DIR__ . '/../api_key.php';
            $api_key = API_KEY;
    
            $stmt = $pdo->query("SELECT * FROM mensajeNuevo ORDER BY RAND() LIMIT 1");
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
        
        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
        
            $body = array(
                "api_key" => $api_key,
                "receiver" => "$from",
                "data" => array(
                    "url" => "http://bot.tienderu.com/app/storage?url=1/botti.png",
                    "media_type" => "image",
                    "caption" => ""
                )
            );
            
        // Enviar solicitud de texto
        $response = sendCurlRequestImage($body);

        // Construir el mensaje del menú
        $menuMessage = "📢 ¡Obtén más información y descuentos exclusivos! 🎁 Para recibir atención personalizada, *escribe tu nombre* para continuar 🚀.";
       
            // Mensaje de texto con el menú
            $body = array(
                "api_key" => $api_key,
                "receiver" => $from,
                "data" => array("message" => $menuMessage)
            );

        // Enviar solicitud de texto
        $response = sendCurlRequestText($body);
                    
        // Actualizar el estado 
        update_status($pdo, $from, 'registrar');

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
