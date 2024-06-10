<?php

    function inicioBienvenida($pdo, $from) {
        try {
            
            // Incluir el archivo que contiene la API key
            require_once 'api_key.php';
        
            ////////////////////
        
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
            
            ////////////
            
            // Establecer la API utilizando la constante definida en api_key.php
            $api_key = API_KEY;
            
            $body = array(
                "api_key" => $api_key,
                "receiver" => "$from",
                "data" => array(
                    "url" => "http://bot.tienderu.com/app/storage?url=1/IMG_9482.JPEG",
                    "media_type" => "image",
                    "caption" => ""
                )
            );
            
            // Enviar solicitud de texto
            $response = sendCurlRequestImage($body);
        
            /////////////////////////////////////
    
            // Construir el mensaje del menú
            $menuMessage = menu($pdo, $from);
                        
            // Actualizar el estado 
            update_status($pdo, $from, 'inicio');
            // Actualizar el perfil 
            update_perfil($pdo, $from, 'registrado');
    
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
