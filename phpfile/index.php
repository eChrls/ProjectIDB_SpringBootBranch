<?php
session_start(); //iniciamos la session

$url = "http://host.docker.internal:8080/crud/loginSchool?name={name}&password={password}"; // ponemos la url de login

if (isset($_POST["name"]) && isset($_POST["password"])) {// miramos si existe la llamada del login

    if ($_POST["name"] == "" || $_POST["password"] == "") {//comprobamos si esta vacia los campos
        $error = "You can't leave any empty";
    } else {
        $url = str_replace("{name}", $_POST["name"], $url); // añadimos el nombre en la url
        $url = str_replace("{password}", $_POST["password"], $url);// añadimos la contraseña en la url
        
        $curl = curl_init(); //iniciamos el curl

        curl_setopt($curl, CURLOPT_URL, $url); // añadimos la url al curl
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // le decimso al curl que nos va a devolver informacion
        curl_setopt($curl, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
        curl_setopt($curl, CURLOPT_POST, true); // le decimos que es una llamada post

        $response = curl_exec($curl); // hacemos la llamada
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // obtenemos el codigo http de la llamada

        curl_close($curl); // cerramos el curl

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
    <title>crud</title>
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
        <p>login</p>
        <form action="" method="post">
            <label for="name">user</label>
            <input class="form-control" type="text" name="name" id="name"
                value="<?php if (isset($_POST['name']))
                    echo $_POST['name'] ?>">
                <label for="password">password</label>
                <input class="form-control" type="password" name="password" id="password"
                    value="<?php if (isset($_POST['password']))
                    echo $_POST['password'] ?>">
                <button class="btn btn-primary" id="login">send</button>
            </form>
            <a href="registration.php">Don't have an account? Sign up</a>
            <a href="updateuser.php">I forgot my password</a>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    </body>

    </html>