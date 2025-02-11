<?php
session_start(); // iniciamos la session
if (!isset($_SESSION["token"])) { // si la session no esta mandamos al usuario al login
    header("Location: http://localhost/WebPhp/");
}

if (isset($_POST["idDelete"])) { // miramo si se ha enviado el form de borrar estudiante
    $urlDelete = "http://host.docker.internal:8080/crud/deleteStudent/"; // ponemos la url de eliminar
    $urlDelete .= $_POST["idDelete"]; // añadimos en la url el id del estudiante

    $curlDelete = curl_init(); // iniciamos el curl 
    curl_setopt($curlDelete, CURLOPT_URL, $urlDelete); // añadimos la url al curl
    curl_setopt($curlDelete, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
    curl_setopt($curlDelete, CURLOPT_HTTPHEADER, array('token:' . $_SESSION["token"])); // y que el tipo que le enviamos es un json
    curl_setopt($curlDelete, CURLOPT_RETURNTRANSFER, true); // esto devuelve una respuesta
    curl_setopt($curlDelete, CURLOPT_CUSTOMREQUEST, "DELETE"); // metemos el metodo de la llamada

    $responseDelete = curl_exec($curlDelete);// ejecutamos al url 
    $httpcodeDelete = curl_getinfo($curlDelete, CURLINFO_HTTP_CODE); //devolvemos la reespuesta de la url 

    curl_close($curlDelete); //cerramo el curl 
    if ($httpcodeDelete != 200) { // si falla mostramos un mensaje de error
        $error = "error to delete";
    }
}

if (isset($_POST["delete"])) {// miramo si se ha enviado el form de borrar escuela

    $urlDelete = "http://host.docker.internal:8080/crud/deleteSchool";// ponemos la url de eliminar

    $curlDeleteS = curl_init(); // iniciamos el curl 
    curl_setopt($curlDeleteS, CURLOPT_URL, $urlDelete);// añadimos la url al curl
    curl_setopt($curlDeleteS, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
    curl_setopt($curlDeleteS, CURLOPT_HTTPHEADER, array('token:' . $_SESSION["token"])); // y que el tipo que le enviamos es un json
    curl_setopt($curlDeleteS, CURLOPT_RETURNTRANSFER, true);// esto devuelve una respuesta
    curl_setopt($curlDeleteS, CURLOPT_CUSTOMREQUEST, "DELETE");// metemos el metodo de la llamada

    $responseDeleteS = curl_exec($curlDeleteS);// ejecutamos al url 
    $httpcodeDeleteS = curl_getinfo($curlDeleteS, CURLINFO_HTTP_CODE);//devolvemos la reespuesta de la url 

    curl_close($curlDeleteS); //cerramo el curl 
    if ($httpcodeDeleteS == 200) { // si todo ha ido bien rompemos la session y lo mandamos a la pagina principal
        session_destroy();
        header("Localtion: http://localhost/WebPhp/");
    } else { // si va mal mostramos mensaje de error
        $error = "Error to delete school";
    }

}

if (
    isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["phone"]) && isset($_POST["address"]) && isset($_POST["city"])
    && isset($_POST["age"]) && isset($_POST["course"]) && isset($_POST["dateInit"])
) { // vemos que se ha enviado el formulario de insertar

    if (
        $_POST["name"] == "" || $_POST["email"] == "" || $_POST["phone"] == "" || $_POST["address"] == "" || $_POST["city"] == ""
        || $_POST["age"] == "" || $_POST["course"] == "" || $_POST["dateInit"] == ""
    ) { // comprobamos si hay algo vacio para mostrar error
        $error = "You can't leave any empty";
    } else {
        $urlInsert = "http://host.docker.internal:8080/crud/insertStudents"; // ponemos la url de insertar
        $obj = array(
            "name" => $_POST["name"],
            "email" => $_POST["email"],
            "phone" => $_POST["phone"],
            "address" => $_POST["address"],
            "city" => $_POST["city"],
            "age" => $_POST["age"],
            "course" => $_POST["course"],
            "dateInit" => $_POST["dateInit"]
        ); // creamos el array asociativo con los datos que enviaremoa a la url
        $json = json_encode($obj); // convertimos ese array asociativo en un json

        $curlInsert = curl_init(); // iniciamos el curl

        curl_setopt($curlInsert, CURLOPT_URL, $urlInsert); // añadimos la url
        curl_setopt($curlInsert, CURLOPT_POST, 1); // le decimos que en este caso va a ser un metodo POST
        curl_setopt($curlInsert, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
        curl_setopt($curlInsert, CURLOPT_POSTFIELDS, $json); //que le vamos a pasar el json por el cuerpo de la llamada
        curl_setopt($curlInsert, CURLOPT_RETURNTRANSFER, 1); //que esto va a devolver un resultado
        curl_setopt($curlInsert, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'token:' . $_SESSION["token"])); // y que el tipo que le enviamos es un json

        $response = curl_exec($curlInsert); // ejecutamos la url
        $httpcode = curl_getinfo($curlInsert, CURLINFO_HTTP_CODE);//devolvemos la reespuesta de la url 

        curl_close($curlInsert); // cerramos el curl 

        if ($httpcode != 200) {// si falla mostramos un mensaje de error
            $error = 'Internal error to insert';
        }
    }



}

if(isset($_POST["idUpdate"]) && isset($_POST["nameUpdate"]) && isset($_POST["emailUpdate"]) && isset($_POST["phoneUpdate"]) && isset($_POST["addressUpdate"]) &&
isset($_POST["cityUpdate"]) && isset($_POST["ageUpdate"]) && isset($_POST["courseUpdate"]) && isset($_POST["dateInitUpdate"])){ // vemos que se ha enviado el formulario de actualizar

    if($_POST["idUpdate"] == "" || $_POST["nameUpdate"] == "" || $_POST["emailUpdate"]=="" || $_POST["phoneUpdate"] == "" || $_POST["addressUpdate"]=="" ||
    $_POST["cityUpdate"] == "" || $_POST["ageUpdate"] == "" || $_POST["courseUpdate"] == "" || $_POST["dateInitUpdate"] == ""){ // comprobamos si hay algo vacio para mostrar error
        $error = "You can't leave any empty";
    }else{
        $urlUpdate = "http://host.docker.internal:8080/crud/updateStudent/".$_POST["idUpdate"]; // generamos la url de actualizar

        $obj = array(
            "name" => $_POST["nameUpdate"],
            "email" => $_POST["emailUpdate"],
            "phone" => $_POST["phoneUpdate"],
            "address" => $_POST["addressUpdate"],
            "city" => $_POST["cityUpdate"],
            "age" => $_POST["ageUpdate"],
            "course" => $_POST["courseUpdate"],
            "dateInit" => $_POST["dateInitUpdate"]
        );// creamos el array asociativo con los datos que enviaremoa a la url

        $json = json_encode($obj);// convertimos ese array asociativo en un json

        $curlUpdate = curl_init(); // iniciamos el curl

        curl_setopt($curlUpdate, CURLOPT_URL, $urlUpdate); // añladimos la url al curl
        curl_setopt($curlUpdate, CURLOPT_POSTFIELDS, $json); //que le vamos a pasar el json por el cuerpo de la llamada
        curl_setopt($curlUpdate, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
        curl_setopt($curlUpdate, CURLOPT_CUSTOMREQUEST, "PUT"); // ponemos el metodo de la llamada
        curl_setopt($curlUpdate, CURLOPT_RETURNTRANSFER, 1); //que esto va a devolver un resultado
        curl_setopt($curlUpdate, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'token:' . $_SESSION["token"])); // y que el tipo que le enviamos es un json

        $response = curl_exec($curlUpdate);// ejecutamos la url
        $httpcode = curl_getinfo($curlUpdate, CURLINFO_HTTP_CODE); //devolvemos la reespuesta de la url 

        curl_close($curlUpdate); // cerramos el curl 

        if ($httpcode != 200) { // si falla mostramos un mensaje de error
            $error = 'Internal error to insert';
        } 

    }
}

$urlData = "http://host.docker.internal:8080/crud/getStudent"; // url para obtener lo usuario de una escuela

$curl = curl_init();// inicamos el curl 

curl_setopt($curl, CURLOPT_URL, $urlData); // metemos la url en el curl 
curl_setopt($curl, CURLOPT_HEADER, false); //le decimos que nos da igual el header que nos devuelva
curl_setopt($curl, CURLOPT_HTTPHEADER, array('token:' . $_SESSION["token"])); // y que el tipo que le enviamos es un json
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // le decimso que devuelve datos esa llamada

$responseData = curl_exec($curl); // ejecutamos la url

curl_close($curl); // cerramos el curl 
$jsonData = json_decode($responseData, true); // obtenemos la lista de json con los datos 
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

<body>

    <?php if (isset($error)) // si hay algun error lo mostramos 
        echo "<p>" . $error . "</p>"; ?>

    <table class="table table-dark table-striped table-bordered">
        <thead>
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>phone</th>
            <th>address</th>
            <th>city</th>
            <th>age</th>
            <th>course</th>
            <th>dateInit</th>
            <th>actions</th>
        </thead>
        <tbody>
            <?php

            for ($i = 0; $i < count($jsonData); $i++) { // recorremos el array de los alumnos 
                echo "<tr>"; // añadimos la linea de la tabla 
                foreach ($jsonData[$i] as $key => $value) { // recorremos el json que hay en esa lista 
                    if ($key != "schoolUser") { // quitamos la union de la llamada
                        echo "<td class=" . $jsonData[$i]["id"] . ">" . $jsonData[$i][$key] . "</td>"; // añadimo la celda con los datos 
                    }
                }
                ?>
                <td>
                    <button type="button" class="btn btn-trasparent" data-bs-toggle="modal" data-bs-target="#deleteModal"
                        onclick="putInputHiddenValue(this)">
                        <img src="images/delete.png" alt="" class="<?php echo $jsonData[$i]["id"] ?>">
                    </button>
                    <button type="button" class="btn btn-trasparent" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="putValueInForm(this)">
                        <img src="images/tool.png" alt="" id="<?php echo $jsonData[$i]["id"] ?>">
                    </button>
                </td>

                <?php
                echo "</tr>"; // cerramo el tr
            }

            ?>
        </tbody>
    </table>

    <form action="" method="post">
        <input type="hidden" name="delete">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteSchoolModal">
            delete School
        </button>
    </form>


    <form action="" method="post" class="d-flex flex-row flex-nowrap justify-content-around">
        <label for="name" class="me-2">name: </label>
        <input type="text" name="name" id="name" class="insert form-control w-25 me-4">
        <label for="email" class="me-2">email: </label>
        <input type="email" name="email" id="emial" class="insert form-control w-25 me-4">
        <label for="phone" class="me-2">phone: </label>
        <input type="tel" name="phone" id="phone" class="insert form-control w-25 me-4">
        <label for="address" class="me-2">address: </label>
        <input type="text" name="address" id="address" class="insert form-control w-25 me-4">
        <label for="city" class="me-2">city: </label>
        <input type="text" name="city" id="city" class="insert form-control w-25 me-4">
        <label for="age" class="me-2">age: </label>
        <input type="number" name="age" id="age" class="insert form-control w-25 me-4">
        <label for="course" class="me-2">course: </label>
        <select name="course" id="course" class="insert form-select w-25 me-4">
            <option value="CHILDISH">childish</option>
            <option value="ELEMENTARY">elementary</option>
            <option value="INTERMEDIATE">intermediate</option>
            <option value="ADVANCED">advance</option>
        </select>
        <label for="date" class="me-2">date: </label>
        <input type="date" name="dateInit" id="dateInit" class="insert form-control w-25 me-4">
        <button class="btn btn-secondary" id="buttonInsertStudent"> send</button>
    </form>

        <!-- Modal -->
        <div class="modal fade" id="deleteSchoolModal" tabindex="-1" aria-labelledby="deleteSchoolModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteSchoolModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this School?</p>
                    <form action="" method="post">
                        <input type="hidden" name="idDeleteSchool" id="idStudentDetelete">
                        <button class="btn btn-primary"> delete</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this student?</p>
                    <form action="" method="post">
                        <input type="hidden" name="idDelete" id="idStudentDetelete">
                        <button class="btn btn-primary"> delete</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="idUpdate" class="update">
                        <label for="name" class="me-2">name: </label>
                        <input type="text" name="nameUpdate" id="name" class="insert form-control update me-4">
                        <label for="email" class="me-2">email: </label>
                        <input type="email" name="emailUpdate" id="emial" class="insert form-control update me-4">
                        <label for="phone" class="me-2">phone: </label>
                        <input type="tel" name="phoneUpdate" id="phone" class="insert form-control update me-4">
                        <label for="address" class="me-2">address: </label>
                        <input type="text" name="addressUpdate" id="address" class="insert form-control update me-4">
                        <label for="city" class="me-2">city: </label>
                        <input type="text" name="cityUpdate" id="city" class="insert form-control update me-4">
                        <label for="age" class="me-2">age: </label>
                        <input type="number" name="ageUpdate" id="age" class="insert form-control update me-4">
                        <label for="course" class="me-2">course: </label>
                        <select name="courseUpdate" id="courseUpdate" class="insert form-select update me-4">
                            <option value="CHILDISH">childish</option>
                            <option value="ELEMENTARY">elementary</option>
                            <option value="INTERMEDIATE">intermediate</option>
                            <option value="ADVANCED">advance</option>
                        </select>
                        <label for="date" class="me-2">date: </label>
                        <input type="date" name="dateInitUpdate" id="dateInit" class="insert form-control update me-4">
                        <button class="btn btn-secondary" id="buttonInsertStudent"> send</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script>
        function putInputHiddenValue(elemento) {
            const inputHidden = document.getElementById("idStudentDetelete");//elemento oculto en el popUp de borrar
            let img = elemento.children[0]; // cogemos el elemento hijo
            inputHidden.value = img.className; // le metemos el valor de la clase al input hidden
        }

        function putValueInForm(elemento) {
            let img = elemento.children[0]; // obtenemos el hijo del elemento 
            let values = document.getElementsByClassName(img.id); //obtenemos los datos del usuario en la tabla que tiene como clase el id del usuario
            let inputs = document.getElementsByClassName("update"); // obtenemos los inputs que esta en la pagina para actalizar

            for (let index = 0; index < values.length - 1; index++) {
                inputs[index].value = values[index].innerHTML;  //recorremos y metemos en los value de los input el valor de los usuarios      
            }
        }
    </script>
</body>

</html>