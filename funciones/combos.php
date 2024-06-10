
<?php

    function combos($pdo, $from) {
    
       /*/////////////   MENSAJE SUBHEADER   ////////////*/

        $stmt = $pdo->query("SELECT * FROM headerCombos ORDER BY RAND() LIMIT 1");
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
        
        //////////////   MENSAJE IMAGEN  ////////////
        
        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
        
            // Array de URLs de las imágenes
            $image_urls = array(
                "http://bot.tienderu.com/app/storage?url=1/combos_skin_madre.png",
                "http://bot.tienderu.com/app/storage?url=1/combo_skin_1.png",
                "http://bot.tienderu.com/app/storage?url=1/combo_skin_2.png",
                "http://bot.tienderu.com/app/storage?url=1/combo_skin_3.png",
                "http://bot.tienderu.com/app/storage?url=1/combo_skin_4.png",
                "http://bot.tienderu.com/app/storage?url=1/combo_skin_5.png",
                "http://bot.tienderu.com/app/storage?url=1/combo_skin_superDuo.jpeg",
                
                "http://bot.tienderu.com/app/storage?url=1/combo_skin_.png"
            );
    
            // Iterar sobre cada URL de imagen y enviarla como una solicitud individual
            foreach ($image_urls as $url) {
                $body = array(
                    "api_key" => $api_key,
                    "receiver" => $from,
                    "data" => array(
                        "url" => $url,
                        "media_type" => "image",
                        "caption" => ""
                    )
                );

        // Enviar solicitud de imagen
        $response = sendCurlRequestImage($body);
        }

        /////////////////////
        
        $stmt = $pdo->query("SELECT * FROM menuCombos");
        $menuItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Construir el mensaje del menú principal
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
        update_status($pdo, $from, 'combos');
    
    }    
    
    
    function footerCombos($pdo, $from) {
    
       // Incluir el archivo que contiene la API key
        require_once 'api_key.php';
        
        $stmt = $pdo->query("SELECT * FROM footerCombos ORDER BY RAND() LIMIT 1");
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
        
    }
    
?>
