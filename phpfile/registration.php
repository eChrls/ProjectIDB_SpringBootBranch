<?php
session_start();//iniciamos la session
$url = "http://host.docker.internal:8080/crud/insertSchool"; // ponemos la url de inserccion de la escuela

if (isset($_POST["name"]) && isset($_POST["password"])) { //comprobamos si se ha enviado los datos del formulario

    if ($_POST["name"] == "" || $_POST["password"] == "") { // si esta vacio devolvemos un error
        $error = "You can't leave any empty";
    } else {
        $obj = array("name"=> $_POST["name"],"password"=> $_POST["password"]); // ponemos un array asociativo con los datos que necesitamos
        $json = json_encode($obj); // ponemos ese array asociativo codificado como un json

        $curl = curl_init(); // iniciamos el curl
        curl_setopt($curl, CURLOPT_URL, $url); // ponemos la url en el curl
        curl_setopt($curl, CURLOPT_POST, 1); // le decimos que en este caso va a ser un metodo POST
        curl_setopt($curl, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); //que le vamos a pasar el json por el cuerpo de la llamada
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //que esto va a devolver un resultado
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); // y que el tipo que le enviamos es un json

        $response = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close ($curl);
        
        if ($httpcode == 200) { // si la respues es buena 
            $_SESSION["token"] = $response; // guardamos la respuesta en la session
            header("Location: http://localhost/WebPhp/home.php"); // mandamos al usuario a la siguente pagina
        } else {
            $error = "internal error"; // si ah dio mal mandamos mensaje de error
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="min-vh-100">
    <main class="d-flex flex-column justify-content-center align-items-center align-self-center min-vh-100">
        <?php
        if (isset($error)) { // si existe algun error lo mostramos
            echo "<p>" . $error . "</p>";
        }
        ?>
        <p>registration</p>
        <form action="" method="post">
            <label for="name">user</label>
            <input class="form-control" type="text" name="name" id="name" value="<?php if (isset($_POST['name']))
                echo $_POST['name'] ?>">
                <label for="password">password</label>
                <input class="form-control" type="password" name="password" id="password" value="<?php if (isset($_POST['password']))
                echo $_POST['password'] ?>">
                <button class="btn btn-primary" id="login">send</button>
            </form>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>

    </html>