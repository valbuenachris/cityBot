<?php

function kit($pdo, $from) {
    // Incluir el archivo que contiene la API key
        require_once 'api_key.php';

        $stmt = $pdo->query("SELECT * FROM headerKit ORDER BY RAND() LIMIT 1");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Construir el mensaje del menú
        $menuMessage = "";
        foreach ($menuItems as $item) {
            $menuMessage .= "{$item['mensaje']} \n";
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
        $stmt = $pdo->query("SELECT * FROM subHeaderKit ORDER BY RAND() LIMIT 1");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir el mensaje del menú
        $menuMessage = "";
        foreach ($menuItems as $item) {
            $menuMessage .= "{$item['mensaje']} \n";
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
        
        //////////////   MENSAJE IMAGEN  ////////////
        
        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
        
        $body = array(
            "api_key" => $api_key,
            "receiver" => "$from",
            "data" => array(
                "url" => "http://bot.tienderu.com/app/storage?url=1/kitPeque.JPEG",
                "media_type" => "image",
                "caption" => ""
            )
        );
        
        // Enviar solicitud de texto
        $response = sendCurlRequestImage($body);
        
        /*/////////////   MENSAJE SUBHEADER   ////////////*/

        $stmt = $pdo->query("SELECT * FROM subHeaderKitUno ORDER BY RAND() LIMIT 1");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir el mensaje del menú
        $menuMessage = "";
        foreach ($menuItems as $item) {
            $menuMessage .= "{$item['mensaje']} \n";
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
        
        //////////////   MENSAJE IMAGEN  ////////////
        
        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
        
        $body = array(
            "api_key" => $api_key,
            "receiver" => "$from",
            "data" => array(
                "url" => "http://bot.tienderu.com/app/storage?url=1/kitMed.JPEG",
                "media_type" => "image",
                "caption" => ""
            )
        );
        
        // Enviar solicitud de texto
        $response = sendCurlRequestImage($body);
        
        /*/////////////   MENSAJE SUBHEADER   ////////////*/

        $stmt = $pdo->query("SELECT * FROM subHeaderKitDos ORDER BY RAND() LIMIT 1");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir el mensaje del menú
        $menuMessage = "";
        foreach ($menuItems as $item) {
            $menuMessage .= "{$item['mensaje']} \n";
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
        
        //////////////   MENSAJE IMAGEN  ////////////
        
        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
        
        $body = array(
            "api_key" => $api_key,
            "receiver" => "$from",
            "data" => array(
                "url" => "http://bot.tienderu.com/app/storage?url=1/kitCompleto.JPEG",
                "media_type" => "image",
                "caption" => ""
            )
        );
        
        // Enviar solicitud de texto
        $response = sendCurlRequestImage($body);
        
        /*/////////////   MENSAJE SUBHEADER   ////////////*/

        $stmt = $pdo->query("SELECT * FROM menuKit");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir el mensaje del menú
        $menuMessage = "";
        foreach ($menuItems as $item) {
            $menuMessage .= "{$item['icono']} {$item['item']}\n";
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
        
        // Actualizar el estado 
        update_status($pdo, $from, 'kit');
        
    }
    
?>
