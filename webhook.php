<?php

// Definir variables PDO
$pdo = null;
$pdo2 = null;

try {
    // Incluir archivos de funciones
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('funciones'));
    $file_list_functions = [];
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $file_list_functions[] = $file->getPathname();
        }
    }
    foreach ($file_list_functions as $file) {
        include $file;
    }

    // Analizar datos de entrada
    $data = json_decode(file_get_contents('php://input'), true);
    file_put_contents('logwebhook.txt', '[' . date('Y-m-d H:i:s') . "]\n" . json_encode($data) . "\n\n", FILE_APPEND);

    $message = $data['message'] ?? null;
    $name = $data['name'] ?? null;
    $from = $data['from'] ?? null;
    $isGroup = $data['isGroup'] ?? null;
    $isMe = $data['isMe'] ?? null;
    $responseData = $data['responseData'] ?? null;

    // Verificar si el mensaje proviene de un grupo
    if ($isGroup) {
        die();
    }

    // Consultar el estado del pedido para el usuario dado
    $stmt = $pdo->prepare("SELECT * FROM sesiones WHERE user_id = ?");
    $stmt->execute([$from]);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Procesamiento de mensajes
    
    switch (true) {
        case ($isGroup):
            die();
            break;
                case (strtolower($message) == 'salir'):
                    $responseData = borrar($pdo, $from);
                    break;
                case (strtolower($message) == 'ver'):
                    $responseData = ver($pdo, $from);
                    break;
                    
                case ($pedido && $pedido['status'] == 'registrar' && ($pedido['nombre'] == 'Sin Nombre')):
                    $responseData = manejarEstadoRegistrar($pdo, $from, $message);
                    break;
                case ($pedido && ($pedido['perfil'] == 'cantidades')):
                    $responseData = agregarCantidades($pdo, $from, $message);
                    break;
               
                case (($pedido['perfil'] == 'comprar')):
                    $responseData = comprar($pdo, $from, $message);
                    break;
                
                case ($pedido && ($pedido['status'] == 'nombreCliente')):
                    $responseData = nombreCliente($pdo, $from, $message);
                    break;
                case ($pedido && ($pedido['status'] == 'direccionCliente')):
                    $responseData = direccionCliente($pdo, $from, $message);
                    break;
                case ($pedido && ($pedido['status'] == 'ciudadCliente')):
                    $responseData = ciudadCliente($pdo, $from, $message);
                    break;
                
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'rutina') !== false):
                    $responseData = rutina($pdo, $from);
                    break;
                
                case (strpos(remove_accents(strtolower($message)), 'horario') !== false || strpos(remove_accents(strtolower($message)), 'horas atienden') !== false 
                || strpos(remove_accents(strtolower($message)), 'horas hay atencion') !== false || strpos(remove_accents(strtolower($message)), 'horas hay servicio') !== false
                || strpos(remove_accents(strtolower($message)), 'hora hay servicio') !== false):
                    $responseData = horario($pdo, $from);
                    break;
                    
                case (strpos(remove_accents(strtolower($message)), 'ubicados') !== false || strpos(remove_accents(strtolower($message)), 'direccion') !== false 
                || strpos(remove_accents(strtolower($message)), 'ubicacion') !== false ):
                    $responseData = ubicacion($pdo, $from);
                    break;
                
                case (strpos(remove_accents(strtolower($message)), 'distribuidora') !== false || strpos(remove_accents(strtolower($message)), 'vender al por mayor') !== false 
                || strpos(remove_accents(strtolower($message)), 'mayorista') !== false):
                    $responseData = mayorista($pdo, $from);
                    break;
                
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'garantizado') !== false 
                || strpos(remove_accents(strtolower($message)), 'garantia' ) !== false):
                    $responseData = garantizado($pdo, $from);
                    break;
                    
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'componentes' ) !== false || strpos(remove_accents(strtolower($message)), 'ingredientes' ) !== false):
                    $responseData = componentesTonico($pdo, $from);
                    break;
                
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'kit' ) !== false):
                    $responseData = kit($pdo, $from);
                    break;
                
                // Comparación de mensajes buscando las palabras "componentes" y "tonico" sin importar los acentos
                case (strpos(remove_accents(strtolower($message)), remove_accents('componentes')) !== false 
                || strpos(remove_accents(strtolower($message)), remove_accents('ingredientes')) !== false 
                
                && 
                    strpos(remove_accents(strtolower($message)), remove_accents('tonico')) !== false):
                    $responseData = componentes($pdo, $from);
                    break;
                    
                // Comparación de mensajes buscando las palabras "componentes" y "tonico" sin importar los acentos
                case (strpos(remove_accents(strtolower($message)), remove_accents('tratar')) !== false 
                || strpos(remove_accents(strtolower($message)), remove_accents('tratamiento')) !== false || strpos(remove_accents(strtolower($message)), remove_accents('tratan')) !== false 
                || strpos(remove_accents(strtolower($message)), remove_accents('quitar')) !== false 
                
                && 
                    strpos(remove_accents(strtolower($message)), remove_accents('manchas')) !== false):
                    $responseData = manchas($pdo, $from);
                    break;
                
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'resultado') !== false):
                    $responseData = resultados($pdo, $from);
                    break;
                    
                case (strpos(remove_accents(strtolower($message)), 'faq') !== false):
                    $responseData = preguntas($pdo, $from);
                    break;
                    
                case (strpos(remove_accents(strtolower($message)), 'enrojecimiento' ) !== false || strpos(remove_accents(strtolower($message)), 'ardor' ) !== false
                || strpos(remove_accents(strtolower($message)), 'irritacion' ) !== false || strpos(remove_accents(strtolower($message)), 'cara quemada' ) !== false
                || strpos(remove_accents(strtolower($message)), 'resequedad' ) !== false || strpos(remove_accents(strtolower($message)), 'reseca' ) !== false):
                    $responseData = enrojecimiento($pdo, $from);
                    break;
                    
                case (strpos(remove_accents(strtolower($message)), 'catalogo') !== false):
                    $responseData = catalogo($pdo, $from);
                    break;
                
                case (strpos(remove_accents(strtolower($message)), 'contraentrega') !== false || strpos(remove_accents(strtolower($message)), 'contra entrega') !== false 
                || strpos(remove_accents(strtolower($message)), 'catalogo') !== false):
                    $responseData = contraentrega($pdo, $from);
                    break;
                    
                case (strpos(remove_accents(strtolower($message)), 'menu') !== false):
                    $responseData = headerMenu($pdo, $from);
                    $responseData = menu($pdo, $from);
                    $responseData = footerMenu($pdo, $from);
                    break;    
                
                case (strpos(remove_accents(strtolower($message)), 'adi') !== false || strpos(remove_accents(strtolower($message)), 'addi') !== false):
                    $responseData = addi($pdo, $from);
                    
                    break;    
                    
                case (strpos(remove_accents(strtolower($message)), 'combo') !== false):
                    $responseData = combos($pdo, $from);
                    break;    
                    
                
                case (strtolower($message) == 'fin'):
                    $responseData = finalizarCompra($pdo, $from);
                    break;
                case (strtolower($message) == 'saldo'):
                    $responseData = verCompra($pdo, $from);
                    break;
                case (strtolower($message) == 'rc'):
                    $responseData = registrarCliente($pdo, $from);
                    break;
                case (strtolower($message) == 'mdc'):
                    $responseData = modificarCompra($pdo, $from);
                    break;
                    
                case (strtolower($message) == '0'):
                    $responseData = cero($pdo, $from);
                    break;
                case (strtolower($message) == '1'):
                    $responseData = uno($pdo, $from);
                    break;
                case (strtolower($message) == '2'):
                    $responseData = dos($pdo, $from);
                    break;
                case (strtolower($message) == '3'):
                    $responseData = tres($pdo, $from);
                    break;
                case (strtolower($message) == '4'):
                    $responseData = cuatro($pdo, $from);
                    break;
                case (strtolower($message) == '5'):
                    $responseData = cinco($pdo, $from);
                    break;
                case (strtolower($message) == '6'):
                    $responseData = seis($pdo, $from);
                    break;
                case (strtolower($message) == '7'):
                    $responseData = siete($pdo, $from);
                    break;
                case (strtolower($message) == '8'):
                    $responseData = ocho($pdo, $from);
                    break;
                    
                case (strtolower($message) == '9'):
                    $responseData = nueve($pdo, $from);
                    break;
                case (strtolower($message) == '10'):
                    $responseData = diez($pdo, $from);
                    break;
                
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'tonico') !== false):
                    $responseData = tonico($pdo, $from);
                    break;
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'protector solar') !== false):
                    $responseData = protector($pdo, $from);
                    break;
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'serum de cejas') !== false):
                    $responseData = contorno($pdo, $from);
                    break;
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'hialuronico') !== false):
                    $responseData = hialuronico($pdo, $from);
                    break;
                    
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'buenos dias') !== false || strpos(remove_accents(strtolower($message)), 'buenas tardes') !== false
                || strpos(remove_accents(strtolower($message)), 'buenas noches') !== false || strpos(remove_accents(strtolower($message)), 'buenas') !== false
                || strpos(remove_accents(strtolower($message)), 'buen dia') !== false || strpos(remove_accents(strtolower($message)), 'buena tarde') !== false):
                    $responseData = responderSaludo($pdo, $from);
                    break;
                // Comparación de mensajes ignorando acentos
                case (strpos(remove_accents(strtolower($message)), 'ayuda') !== false || strpos(remove_accents(strtolower($message)), 'asesor') !== false):
                    $responseData = ayuda($pdo, $from);
                    break;
                /*default:
                    $responseData = porDefecto($pdo, $from);
                    break;
                */
    }
    
    // Respuesta al cliente
    print json_encode([
        'status' => 'success',
        'data' => json_encode($responseData)
    ]);
} catch (PDOException $e) {
    // Manejo de errores de base de datos
    print json_encode([
        'status' => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    // Manejo de errores generales
    print json_encode([
        'status' => 'error',
        'message' => 'Error: ' . $e->getMessage()
    ]);
} finally {
    // Cierre de conexiones PDO
    if ($pdo) {
        $pdo = null;
    }
    if ($pdo2) {
        $pdo2 = null;
    }
}

?>