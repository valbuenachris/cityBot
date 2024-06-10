

<?php

function verCompra($pdo, $from) {
    try {
        // Verificar si el usuario tiene un registro en la tabla clientes
        $stmtClienteExist = $pdo->prepare("SELECT COUNT(*) AS count FROM clientes WHERE user_id = ?");
        $stmtClienteExist->execute([$from]);
        $clienteExist = $stmtClienteExist->fetchColumn();

        // Si el usuario no tiene un registro en la tabla clientes, llamar a la función registrarCliente
        if ($clienteExist == 0) {
            return registrarCliente($pdo, $from);
        }

        // Verificar si el usuario tiene pedidos pendientes con perfil agendado
        $stmtPedidosExist = $pdo->prepare("SELECT COUNT(*) AS count FROM pedidos WHERE user_id = ? AND perfil = 'agendado'");
        $stmtPedidosExist->execute([$from]);
        $pedidosExist = $stmtPedidosExist->fetchColumn();

        // Si no hay pedidos pendientes, informar al usuario
        if ($pedidosExist == 0) {
            return "No tienes pedidos pendientes para pagar.";
        }
        
        // Obtener los detalles del pedido que se está finalizando
        $stmtPedido = $pdo->prepare("SELECT * FROM pedidos WHERE user_id = ? AND perfil = 'agendado'");
        $stmtPedido->execute([$from]);
        $pedidos = $stmtPedido->fetchAll(PDO::FETCH_ASSOC);

        // Inicializar el valor total del pedido
        $totalPedido = 0;

        // Construir el mensaje con los detalles del pedido
        $menuMessage = "*DATOS DEL PEDIDO*\n\n*Detalles Artículos:*\n";
        foreach ($pedidos as $pedido) {
            $totalPedido += $pedido['total'];
            $menuMessage .= "{$pedido['cantidad']} - {$pedido['producto']} $ {$pedido['total']}\n";
        }

        // Consultar la tabla clientes para obtener los detalles del cliente
        $stmtCliente = $pdo->prepare("SELECT * FROM clientes WHERE user_id = ?");
        $stmtCliente->execute([$from]);
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        // Agregar los detalles del cliente al mensaje
        if ($cliente) {
            $menuMessage .= "\n*Detalles Cliente:*\n";
            $menuMessage .= "Nombre: {$cliente['nombre']}\n";
            $menuMessage .= "Dirección: {$cliente['direccion']}\n";
            $menuMessage .= "Teléfono: {$cliente['telefono']}\n";
            $menuMessage .= "Ciudad: {$cliente['ciudad']}\n";
        }

        // Agregar el valor total del pedido al mensaje
        $menuMessage .= "\nValor Total del Pedido: $ *$totalPedido*\n";

        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;

        // Mensaje de texto con los detalles del pedido
        $body = [
            "api_key" => $api_key,
            "receiver" => $from,
            "data" => ["message" => $menuMessage]
        ];

        // Enviar solicitud de texto
        $response = sendCurlRequestText($body);
        
        // Construir el mensaje del menú
        $menuMessage = menuConfirmarCompra($pdo, $from);

        return $response;
    } catch (PDOException $e) {
        // Manejar errores de base de datos
        return "Se produjo un error al finalizar la compra. Por favor, inténtalo de nuevo más tarde.";
    }
}


function modificarCompra($pdo, $from) {
    try {
        // Eliminar los pedidos pendientes
        $stmtPedido = $pdo->prepare("DELETE FROM pedidos WHERE user_id = ? AND perfil = 'agendado'");
        $stmtPedido->execute([$from]);
        
        // Agregar el valor total del pedido al mensaje
        $menuMessage .= "El pedido ha sido *ELIMINADO*, puedes volver a agregar productos al carrito";

        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;

        // Mensaje de texto con los detalles del pedido
        $body = [
            "api_key" => $api_key,
            "receiver" => $from,
            "data" => ["message" => $menuMessage]
        ];

        // Enviar solicitud de texto al remitente
        $response = sendCurlRequestText($body);
        
        // Construir el mensaje del menú
        $menuMessage = menu($pdo, $from);
        
    } catch (PDOException $e) {
        // Manejar errores de base de datos
        return "Se produjo un error al modificar la compra. Por favor, inténtalo de nuevo más tarde.";
    }
}


function finalizarCompra($pdo, $from) {
    try {
        // Obtener los detalles del pedido que se está finalizando
        $stmtPedido = $pdo->prepare("SELECT * FROM pedidos WHERE user_id = ? AND perfil = 'agendado'");
        $stmtPedido->execute([$from]);
        $pedidos = $stmtPedido->fetchAll(PDO::FETCH_ASSOC);

        // Inicializar el valor total del pedido
        $totalPedido = 0;

        // Construir el mensaje con los detalles del pedido
        $menuMessage = "*PEDIDO COMPLETADO*\n\n*Detalles Artículos:*\n";
        foreach ($pedidos as $pedido) {
            $totalPedido += $pedido['total'];
            $menuMessage .= "{$pedido['cantidad']} - {$pedido['producto']} $ {$pedido['total']}\n";
        }

        // Consultar la tabla clientes para obtener los detalles del cliente
        $stmtCliente = $pdo->prepare("SELECT * FROM clientes WHERE user_id = ?");
        $stmtCliente->execute([$from]);
        $cliente = $stmtCliente->fetch(PDO::FETCH_ASSOC);

        // Agregar los detalles del cliente al mensaje
        if ($cliente) {
            $menuMessage .= "\n*Detalles del Cliente:*\n";
            $menuMessage .= "Nombre: {$cliente['nombre']}\n";
            $menuMessage .= "Dirección: {$cliente['direccion']}\n";
            $menuMessage .= "Teléfono: {$cliente['telefono']}\n";
            $menuMessage .= "Ciudad: {$cliente['ciudad']}\n";
        }

        // Agregar el valor total del pedido al mensaje
        $menuMessage .= "\nValor Total del Pedido: $ *$totalPedido*\n";

        // Actualizar el perfil a 'finalizado' para todos los registros relacionados con el user_id
        $stmtUpdate = $pdo->prepare("UPDATE pedidos SET perfil = 'finalizado' WHERE user_id = ? AND perfil = 'agendado'");
        $stmtUpdate->execute([$from]);

        // Establecer la API utilizando la constante definida en api_key.php
        $api_key = API_KEY;
        $bodega = N_BODEGA;

        // Mensaje de texto con los detalles del pedido
        $body = [
            "api_key" => $api_key,
            "receiver" => $from,
            "data" => ["message" => $menuMessage]
        ];

        // Enviar solicitud de texto al remitente
        $response = sendCurlRequestText($body);
        
        // Enviar solicitud de texto al número especificado
        $body['receiver'] = $bodega; // Cambiar al número deseado
        sendCurlRequestText($body);

        // Construir el mensaje del menú
        $menuMessage = metodosPago($pdo, $from);

        return $response;
    } catch (PDOException $e) {
        // Manejar errores de base de datos
        return "Se produjo un error al finalizar la compra. Por favor, inténtalo de nuevo más tarde.";
    }
}



?>
