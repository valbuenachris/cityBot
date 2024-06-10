<?php

function ropaDeportivaNinos($pdo, $from, $mensaje) {
    try {
        $api_url = 'https://tienderu.com/myApiProject/myApi.php';
        $data = array(
            'search' => 'ropa deportiva'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Error en la solicitud cURL: ' . curl_error($ch));
        }
        curl_close($ch);

        $productos = json_decode($response, true);

        if (empty($productos)) {
            
            $respuesta = "No se encontraron productos que coincidan con *'ropa deportiva niños'*";
            
            require_once 'api_key.php';
            $api_key = API_KEY;

            $body = array(
                "api_key" => $api_key,
                "receiver" => $from,
                "data" => array("message" => $respuesta)
            );

            $response = sendCurlRequestText($body);
            
            // Actualizar el estado 
            update_status($pdo, $from, 'ropaDeportivaNinos');
        
            $menuMessage = menuRegresar($pdo, $from);
            
        } else {
            // Mezclar los productos en orden aleatorio
            shuffle($productos);
            
            $respuesta = "Resultados de la búsqueda para *'ropa deportiva niños'*:\n\n";
            foreach ($productos as $producto) {
                $respuesta .= "📦 *{$producto['title']}*\n";
                $respuesta .= "💲 *{$producto['price']}*\n";
                $respuesta .= "🛒 {$producto['external_link']}\n";
                $respuesta .= "🛍️ *{$producto['shop_name']}*\n";
                $respuesta .= "📞 {$producto['phone_number']}\n________________________\n\n";
            }

            require_once 'api_key.php';
            $api_key = API_KEY;

            $body = array(
                "api_key" => $api_key,
                "receiver" => $from,
                "data" => array("message" => $respuesta)
            );

            $response = sendCurlRequestText($body);
            $menuMessage = menuRegresar($pdo, $from);
            
        }
    } catch (PDOException $e) {
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ]
        ];
    } catch (Exception $e) {
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error: ' . $e->getMessage()
            ]
        ];
    }
}

function ropaDeportivaMujeres($pdo, $from, $mensaje) {
    try {
        $api_url = 'https://tienderu.com/myApiProject/myApi.php';
        $data = array(
            'search' => 'ropa deportiva mujeres'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Error en la solicitud cURL: ' . curl_error($ch));
        }
        curl_close($ch);

        $productos = json_decode($response, true);

        if (empty($productos)) {
            
            $respuesta = "No se encontraron productos que coincidan con *'ropa deportiva mujeres'*";
            
            require_once 'api_key.php';
            $api_key = API_KEY;

            $body = array(
                "api_key" => $api_key,
                "receiver" => $from,
                "data" => array("message" => $respuesta)
            );

            $response = sendCurlRequestText($body);
            
            // Actualizar el estado 
            update_status($pdo, $from, 'ropaDeportivaMujeres');
        
            $menuMessage = menuRegresar($pdo, $from);
            
        } else {
            // Mezclar los productos en orden aleatorio
            shuffle($productos);
            
            $respuesta = "Resultados de la búsqueda para *'ropa deportiva mujeres'*:\n\n";
            foreach ($productos as $producto) {
                $respuesta .= "📦 *{$producto['title']}*\n";
                $respuesta .= "💲 *{$producto['price']}*\n";
                $respuesta .= "🛒 {$producto['external_link']}\n";
                $respuesta .= "🛍️ *{$producto['shop_name']}*\n";
                $respuesta .= "📞 {$producto['phone_number']}\n________________________\n\n";
            }

            require_once 'api_key.php';
            $api_key = API_KEY;

            $body = array(
                "api_key" => $api_key,
                "receiver" => $from,
                "data" => array("message" => $respuesta)
            );

            $response = sendCurlRequestText($body);
            $menuMessage = menuRegresar($pdo, $from);
            
        }
    } catch (PDOException $e) {
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ]
        ];
    } catch (Exception $e) {
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error: ' . $e->getMessage()
            ]
        ];
    }
}

function ropaDeportivaHombres($pdo, $from, $mensaje) {
    try {
        $api_url = 'https://tienderu.com/myApiProject/myApi.php';
        $data = array(
            'search' => 'ropa deportiva hombres'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url . '?' . http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

        $response = curl_exec($ch);
        if ($response === false) {
            throw new Exception('Error en la solicitud cURL: ' . curl_error($ch));
        }
        curl_close($ch);

        $productos = json_decode($response, true);

        if (empty($productos)) {
            
            $respuesta = "No se encontraron productos que coincidan con *'ropa deportiva hombres'*";
            
            require_once 'api_key.php';
            $api_key = API_KEY;

            $body = array(
                "api_key" => $api_key,
                "receiver" => $from,
                "data" => array("message" => $respuesta)
            );

            $response = sendCurlRequestText($body);
            
            // Actualizar el estado 
            update_status($pdo, $from, 'ropaDeportivaHombres');
        
            $menuMessage = menuRegresar($pdo, $from);
            
        } else {
            // Mezclar los productos en orden aleatorio
            shuffle($productos);
            
            $respuesta = "Resultados de la búsqueda para *'ropa deportiva hombres'*:\n\n";
            foreach ($productos as $producto) {
                $respuesta .= "📦 *{$producto['title']}*\n";
                $respuesta .= "💲 *{$producto['price']}*\n";
                $respuesta .= "🛒 {$producto['external_link']}\n";
                $respuesta .= "🛍️ *{$producto['shop_name']}*\n";
                $respuesta .= "📞 {$producto['phone_number']}\n________________________\n\n";
            }

            require_once 'api_key.php';
            $api_key = API_KEY;

            $body = array(
                "api_key" => $api_key,
                "receiver" => $from,
                "data" => array("message" => $respuesta)
            );

            $response = sendCurlRequestText($body);
            $menuMessage = menuRegresar($pdo, $from);
            
        }
    } catch (PDOException $e) {
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error en la base de datos: ' . $e->getMessage()
            ]
        ];
    } catch (Exception $e) {
        return [
            'message_type' => 'text',
            'message' => [
                'message' => 'Error: ' . $e->getMessage()
            ]
        ];
    }
}


?>
