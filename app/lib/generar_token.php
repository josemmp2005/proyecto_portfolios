<?php
//Funcion para generar un token
function generarToken()
{
    $rb = random_bytes(32);
    $token = base64_encode($rb);
    $secureToken = uniqid("", true) . $token;
    return $secureToken;
}

?>