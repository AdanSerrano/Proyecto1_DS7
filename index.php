<?php
if (array_key_exists('addTask', $_POST)) {
  $miArray = $_POST;

  $titulo = $_POST['txtTitle'];
  $descripcion = $_POST['descripcion'];
  $estado = $_POST['ddlTaskState'];
  $fechaCompromiso = $_POST['fechaCompromiso'];
  $responsable = $_POST['userResponse'];
  $categoria = $_POST['taskCategorie'];

  require_once("class/Tasks.php");
  $objTasks = new Tasks();
  $result = $objTasks->PostTasks($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $categoria);
}

$url = 'http://localhost/Proyecto1_DS7/api/';

// Obtiene los datos de los usuarios
$dataUser = file_get_contents($url . 'Users/GetUsers.php');
$optionsUser = json_decode($dataUser, true);

//Obtiene los datos de las tareas
$dataTasks = file_get_contents($url . 'Tasks/GetTasks.php');
$optionsTasks = json_decode($dataTasks, true);

//obtiene los datos de las categorias
$dataCatego = file_get_contents($url . 'Categorie/GetCategorie.php');
$optionsCatego = json_decode($dataCatego, true);

//obtiene los datos  de los estados de las tareas
$dataState = file_get_contents($url . 'Parameter/GetState.php');
$optionsState = json_decode($dataState, true);

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checklist App</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fff;
      width: 80%;
      max-width: 800px;
      margin: 100px auto;
      padding: 20px;
    }
  </style>

</head>

<body>
  <div class="py-2 px-1">
    <h1 class="font-bold text-4xl text-center py-5 bg-indigo-600 rounded-lg text-white">CheckList Tracker App</h1>
  </div>

  <div class="flex flex-row">
    <section class="basis-1/4 rounded-lg">
      <article class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-blue-500">Crear Tarea</h2>

        <form name="formularioTarea" class="mt-2 p-2 bg-gray-50 rounded-lg" action="index.php" method="post">
          <label for="txtTitle" class="block text-sm font-medium leading-6 text-gray-900">Titulo</label>
          <input type="text" name="txtTitle" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Título">


          <label for="titulo" class="mt-2 block text-sm font-medium leading-6 text-gray-900">Descripcion</label>
          <textarea name="descripcion" placeholder="Descripción" class="block w-full rounded-md border-0 py-2 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>

          <fieldset class="mt-2">
            <legend class="text-sm font-semibold leading-6 text-gray-900">Estado</legend>
            <select name="ddlTaskState" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
              <option value="" disabled selected>--- Seleccione una ---</option>
              <?php
              foreach ($optionsState['records'] as $state) {
                echo "<option value='" . $state['ID_PARAMETER'] . "'>" . $state['PARA_NAME'] . "</option>";
              }
              ?>
            </select><br>
          </fieldset>

          <label for="fechaCompromiso" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Fecha de
            compromiso</label>
          <input type="datetime-local" id="fechaCompromiso" name="fechaCompromiso" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline mb-4">
          <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Responsable</label>
          <select name="userResponse" id="userResponse" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>--- Seleccione una ---</option>
            <?php
              foreach ($optionsUser['records'] as $user) {
                echo "<option value='" . $user['ID_USER'] . "'>" . $user['USER_LAST_NAME'] . " " . $user['USER_FIRST_NAME'] . "</option>";
              }
            ?>
          </select><br>

          <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Categorias</label>
          <select name="taskCategorie" id="taskCategorie" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>--- Seleccione una ---</option>
            <?php

            foreach ($optionsCatego['records'] as $Catego) {
              echo "<option value='" . $Catego['ID_CATEGORIE'] . "'>" . $Catego['CAT_NAME'] . "</option>";
            }
            

            ?>
          </select><br>

          <input type='submit' name='addTask' value='Agregar Tarea' class="w-full block bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">

        </form>
        <div id="lista-tareas"></div>
      </article>
    </section>

    <article class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-red-500">Por Hacer</h2>
        <div class="mt-2 p-2 bg-gray-50 rounded-lg">
          <?php
          $style = "class='mt-4 text-sm text-gray-600'";
          $defaultModal = "defaultModal";
          $abrirModal = "abrirModal";
          $buttonEdit = "<button data-modal-target=$defaultModal data-modal-toggle=$defaultModal id=$abrirModal class='px-3 py-1 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-full'>Editar</button>";
          $buttonModal = "<section id='miModal' class='modal'>
                <div class='modal-content'>
                  <div class='flex items-start justify-between p-4 border-b rounded-t'>
                    <h3 class='text-xl font-semibold text-gray-900 '>Modificar tarea</h3>
                    <button type='button' class='text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white' data-modal-hide='defaultModal'>
                      <span id='cerrarModal' style='cursor: pointer;'>&times;</span>
                      <span class='sr-only'>Close modal</span>
                    </button>
                  </div>
                  <div class='p-6 space-y-6'>
                    <p class='text-base leading-relaxed text-gray-500 dark:text-gray-400'>
                      With less than a month to go before the European Union enacts new consumer privacy laws for its
                    </p>
                  </div>
                </div>
              </section>";

          foreach($optionsTasks['records'] as $task){
            if ($task['TASK_STATE'] == 1) {
              echo "<div class='flex flex-col bg-white rounded-lg shadow-lg overflow-hidden bg-black m-2'>";
              echo "<div class='p-2'>";
              echo "<label class='text-base font-semibold text-gray-800'><b>" . $task['TASK_NAME'] . "</b></label><br>";
              echo "<label $style><b>Descrición: </b>" . $task['TASK_DESCRIPTION'] . "</label><br>";
              echo "<label $style>" . $task['CAT_NAME'] . "</label><br>";
              echo "<span class='text-base font-semibold text-gray-600 uppercase tracking-wide center' >" . $task['USER_NAME'] . "</span>";
              echo "</div>";
              echo "<div class='flex items-center justify-around px-2 py-2 bg-gray-100'>";
              echo $buttonEdit;
              echo $buttonModal;
              echo "<button class='px-3 py-1 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-full bg-red-400'>eliminar</button>";
              echo "</div>";
              echo "</div>";
            }
          }

          ?>
        </div>
      </div>
    </article>

    <article class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-amber-500">En Curso</h2>
        <div class="mt-2 p-2 bg-gray-50 rounded-lg">
          <?php
          $style = "class='mt-4 text-sm text-gray-600'";
          $defaultModal = "defaultModal";
          $abrirModal = "abrirModal";
          $buttonEdit = "<button data-modal-target=$defaultModal data-modal-toggle=$defaultModal id=$abrirModal class='px-3 py-1 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-full'>Editar</button>";
          $buttonModal = "<section id='miModal' class='modal'>
                <div class='modal-content'>
                  <div class='flex items-start justify-between p-4 border-b rounded-t'>
                    <h3 class='text-xl font-semibold text-gray-900 '>Modificar tarea</h3>
                    <button type='button' class='text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white' data-modal-hide='defaultModal'>
                      <span id='cerrarModal' style='cursor: pointer;'>&times;</span>
                      <span class='sr-only'>Close modal</span>
                    </button>
                  </div>
                  <div class='p-6 space-y-6'>
                    <p class='text-base leading-relaxed text-gray-500 dark:text-gray-400'>
                      With less than a month to go before the European Union enacts new consumer privacy laws for its
                    </p>
                  </div>
                </div>
              </section>";

              foreach($optionsTasks['records'] as $task){
                if ($task['TASK_STATE'] == 2) {
                  echo "<div class='flex flex-col bg-white rounded-lg shadow-lg overflow-hidden bg-black m-2'>";
                  echo "<div class='p-2'>";
                  echo "<label class='text-base font-semibold text-gray-800'><b>" . $task['TASK_NAME'] . "</b></label><br>";
                  echo "<label $style><b>Descrición: </b>" . $task['TASK_DESCRIPTION'] . "</label><br>";
                  echo "<label $style>" . $task['CAT_NAME'] . "</label><br>";
                  echo "<span class='text-base font-semibold text-gray-600 uppercase tracking-wide center' >" . $task['USER_NAME'] . "</span>";
                  echo "</div>";
                  echo "<div class='flex items-center justify-around px-2 py-2 bg-gray-100'>";
                  echo $buttonEdit;
                  echo $buttonModal;
                  echo "<button class='px-3 py-1 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-full bg-red-400'>eliminar</button>";
                  echo "</div>";
                  echo "</div>";
                }
              }

          ?>
        </div>

      </div>
    </article>

    <article class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-emerald-500">Terminada</h2>
        <div class="mt-2 p-2 bg-gray-50 rounded-lg">
          <?php
          require_once("class/Tasks.php");
          $objTasks = new Tasks();
          $listTasks = $objTasks->GetTasks();
          $style = "class='mt-4 text-sm text-gray-600'";
          $defaultModal = "defaultModal";
          $abrirModal = "abrirModal";
          $buttonEdit = "<button data-modal-target=$defaultModal data-modal-toggle=$defaultModal id=$abrirModal class='px-3 py-1 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-full'>Editar</button>";
          $buttonModal = "<section id='miModal' class='modal'>
                <div class='modal-content'>
                  <div class='flex items-start justify-between p-4 border-b rounded-t'>
                    <h3 class='text-xl font-semibold text-gray-900 '>Modificar tarea</h3>
                    <button type='button' class='text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white' data-modal-hide='defaultModal'>
                      <span id='cerrarModal' style='cursor: pointer;'>&times;</span>
                      <span class='sr-only'>Close modal</span>
                    </button>
                  </div>
                  <div class='p-6 space-y-6'>
                    <p class='text-base leading-relaxed text-gray-500 dark:text-gray-400'>
                      With less than a month to go before the European Union enacts new consumer privacy laws for its
                    </p>
                  </div>
                </div>
              </section>";

              foreach($optionsTasks['records'] as $task){
                if ($task['TASK_STATE'] == 3) {
                  echo "<div class='flex flex-col bg-white rounded-lg shadow-lg overflow-hidden bg-black m-2'>";
                  echo "<div class='p-2'>";
                  echo "<label class='text-base font-semibold text-gray-800'><b>" . $task['TASK_NAME'] . "</b></label><br>";
                  echo "<label $style><b>Descrición: </b>" . $task['TASK_DESCRIPTION'] . "</label><br>";
                  echo "<label $style>" . $task['CAT_NAME'] . "</label><br>";
                  echo "<span class='text-base font-semibold text-gray-600 uppercase tracking-wide center' >" . $task['USER_NAME'] . "</span>";
                  echo "</div>";
                  echo "<div class='flex items-center justify-around px-2 py-2 bg-gray-100'>";
                  echo $buttonEdit;
                  echo $buttonModal;
                  echo "<button class='px-3 py-1 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-full bg-red-400'>eliminar</button>";
                  echo "</div>";
                  echo "</div>";
                }
              }
          ?>
        </div>
      </div>
    </article>
  </div>
  </div>

  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {});

    var botonAbrir = document.getElementById("abrirModal");
    var modal = document.getElementById("miModal");
    var botonCerrar = document.getElementById("cerrarModal");

    botonAbrir.onclick = function() {
      modal.style.display = "block";
    }

    botonCerrar.onclick = function() {
      modal.style.display = "none";
    }
  </script>
</body>

</html>


<?php
if (array_key_exists('addTask', $_POST)) {
  $miArray = $_POST;

  $titulo = $_POST['txtTitle'];
  $descripcion = $_POST['descripcion'];
  $estado = $_POST['ddlTaskState'];
  $fechaCompromiso = $_POST['fechaCompromiso'];
  $responsable = $_POST['userResponse'];
  $categoria = $_POST['taskCategorie'];

  //require_once("class/Tasks.php");
  //$objTasks = new Tasks();
  //$result = $objTasks->PostTasks($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $categoria);
  $dataNewTask = array(
    'titulo' => $titulo,
    'descripcion' => $descripcion,
    'estado' => $estado,
    'fechaCompromiso' => $fechaCompromiso,
    'responsable' => $responsable,
    'categoria' => $categoria
  );
  $jsonDataNewTask = json_encode($dataNewTask);


}

?>