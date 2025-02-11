<?php
$urlCheck = "http://host.docker.internal:8080/crud/findSchool?name="; // ponemso la url para mirar si existe el usuario
$urlUpdate = "http://host.docker.internal:8080/crud/updateSchool/"; // ponemos la url para actualizar

$checked = ""; // generamos un flat para mirar si esta chequeado o no el nombre 
if(isset($_POST["name"]) && !isset($_POST["nameUpdate"])){ // miramos si han enviado los datos del formulario de chequeo 
    if($_POST["name"] == ""){ // si esta vacio lamdnamo mensaje de error 
        $error = "You need to enter the name to change the password";
    }else{
        $url = $urlCheck.$_POST["name"]; // ponemos el nombre al final para añadirlo el parametro
        $curl = curl_init(); // iniciamos curls

        curl_setopt($curl, CURLOPT_URL, $url); // añadimos la url en el curl
        curl_setopt($curl, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //que esto va a devolver un resultado

        $response = curl_exec($curl); // ejecutamos la url 
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // y miramos el codigo http de la llamada

        curl_close($curl); // cerramos el curl

        if($httpcode == 200){ // si la respuesta es buena ponemos que esta chqueado con el nombre 
            
            $checked = $_POST["name"];

        }else{ // si no devolvemos un error
            $error = "internal error to check";
        }
    }
}

if(isset($_POST["nameUpdate"]) && isset($_POST["password"])){ // miramos si el form es el de actualizar
    
    if($_POST["password"] == ""){ // si la contraseña esta vacia creamos el error
        $errorUpdate = "You need to enter the password to update the password";
    }else{
        $urlUpdate = $urlUpdate.$_POST["id"];// añadimos el id en la url 
        $obj = array("name"=> $_POST["nameUpdate"], "password" => $_POST["password"]); // generamos un array asociativo con los datos necesario
        $json = json_encode($obj); // transformamos el array en un json

        $curl = curl_init(); // iniciamos el curl 

        curl_setopt($curl, CURLOPT_URL, $urlUpdate); // añadimos la url en el curl 
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT"); // ponemos el metodo a la llamada 
        curl_setopt($curl, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json); //que le vamos a pasar el json por el cuerpo de la llamada
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //que esto va a devolver un resultado
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json')); // y que el tipo que le enviamos es un json

        $resultUpdate = curl_exec($curl);//ejecutamos la llamada y ahi mismo nos da la respuesta
        $httpcodeUpdate = curl_getinfo($curl, CURLINFO_HTTP_CODE); // cogemos el estado http de la llamada 

        curl_close($curl);// cerramos curl para liberarlo de la memoria

        if($httpcodeUpdate == 200){
            header("Location: http://localhost/WebPhp/index.php"); // mandamos al usuario a la siguente pagina
        }else{
            $errorUpdate = "internal error"; // ponemos el error 
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

        <?php
        if ($checked =="") { // si no esta chequeado ponemos el form de chequeo 
            ?>
            <form action="" method="post">
                <label for="name">user</label>
                <input type="text" name="name" id="name">
                <button class="btn btn-primary" id="login">check</button>
            </form>
            <?php
        }else{ // si esta chequeado lo actualizamos 
            ?>
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php if(isset($response)) echo $response?>">
                <label for="name">user</label>
                <input type="text" readonly class="form-control-plaintext" name="nameUpdate" id="name" value="<?php if(isset($checked)) echo $checked ?>">
                <label for="password">password</label>
                <input class="form-control" type="password" name="password" id="password"
                    value="<?php if (isset($_POST['password']))
                    echo $_POST['password'] ?>">
                <button class="btn btn-primary" id="login">check</button>
            </form>
            <?php
        }
        ?>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>