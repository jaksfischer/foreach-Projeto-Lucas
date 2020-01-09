<?php
// campinho que recebe os valores digitados na pagina web linda 
if (isset($_POST['name'])) {
    $title = $_POST['name'];
}

if (isset($_POST['desc'])) {
    $descrition = $_POST['desc'];
}

if (isset($_POST['nomeCompleto'])) {
    foreach ($_POST["nomeCompleto"] as $nameC) {
        echo " => " . $nameC . "<BR>";
    }
    $count = count($_POST["nomeCompleto"]);

    for ($i = 0; $i <= $count; $i++) {
        print($nameC);
        echo("<br />");
    }
}
/* código do script pra criação de ticket por fases
1 - Inicialização da Sessão
2 - Ticket criado
3 - Finalização da sessão
*/

$i = 0;
$count = count($_POST["nomeCompleto"]);

for ($i = 0; $i <= $count; $i++) {
    print($nameC);
    echo("<br />");
}

/**
* Fiz uma alteração no seu código. Troquei o while pelo foreach, desta forma, a cada posição do array que 
* está dentro do $_POST ele irá enviar com a variável $nomeC.
* Ele enviará o Json o mesmo número de vezes em que passar pelo foreach, mas isso ir resolver o seu problema.
*/
foreach ($_POST["nomeCompleto"] as $nomeC) {
    $api_url = "http://172.16.1.193/apirest.php";
    $user_token = "avDALXUppyhTaCPCeES200JFbL0y2SHvCzSwAqz8";
    $app_token = "W3kK8m43arM0K66H3GyZEKOQFZ7GcpUQ2ZX1HrSj";
    $ch = curl_init();
    $url = $api_url . "/initSession?Content-Type=%20application/json&app_token=" . $app_token . "&user_token=" . $user_token;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($json, true);
    $sess_token = $obj['session_token'];
    $headers = array(
        'Content-Type: application/json',
        'App-Token: ' . $app_token,
        'Session-Token: ' . $sess_token
    );
    $input = '
        { "input": {
                "name": "' . $title . ' ' . $i . '",
                "content": "<b>NOME</b>: ' . $nomeC . '<br><b>CPF</b>: teste<br><b>Secretaria</b>:<br> ",
                                "status":"4",
                                "urgency":"1",
                                "priority":"4",
                                "resquesttypes_id":"5",
                                "itilcategories_id":"93",
                                "_users_id_requester":"20"
        }
    }';
    $url = $api_url . "/Ticket/";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_POSTFIELDS, $input);
    $json = curl_exec($ch);
    curl_close($ch);

    print_r($json);
    echo("<br />");
}

print("<b><font color=green><center><h1>A SUA SOLICITAÇÃO FOI CRIADA COM SUCESSO.</h1><pre> caraio</pre></center></font></b>");

?>
