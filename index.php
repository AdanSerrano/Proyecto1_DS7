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
            background-color: rgba(0,0,0,0.5);
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
    <div class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-blue-500">Crear Tarea</h2>

        <form name="formularioTarea" class="mt-2 p-2 bg-gray-50 rounded-lg"  action="index.php" method="post" >
          <label for="txtTitle" class="block text-sm font-medium leading-6 text-gray-900">Titulo</label>
          <input type="text" name="txtTitle" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Título"  >


          <label for="titulo" class="mt-2 block text-sm font-medium leading-6 text-gray-900">Descripcion</label>
          <textarea name="descripcion" placeholder="Descripción" class="block w-full rounded-md border-0 py-2 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>

          <fieldset class="mt-2">
            <legend class="text-sm font-semibold leading-6 text-gray-900">Estado</legend>
            <select name="ddlTaskState" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <?php
              require_once("class/Parameter.php");
              $objParameter = new Parameter();
              $listParameter = $objParameter->GetParameter("ESTADOS DE TAREAS");
              foreach ($listParameter as $parameter) {
                echo "<option value='" . $parameter['ID_PARAMETER'] . "'>" .  $parameter['PARA_NAME'] . "</option>";
              }

            ?>
          </select><br>
          </fieldset>

          <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" >Fecha de compromiso</label>
          <input type="datetime-local" name="fechaCompromiso"  /><br />
          <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" >Responsable</label>
          <select name="userResponse" id="userResponse" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>--- Seleccione una ---</option>
            <?php
              require_once("class/Users.php");
              $objUsers = new users();
              $listUser = $objUsers->GetUsers();
              foreach ($listUser as $user) {
                echo "<option value='" . $user['ID_USER'] . "'>" . $user['USER_LAST_NAME'] . " " . $user['USER_FIRST_NAME'] . "</option>";
              }

            ?>
          </select><br>

          <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" >Categorias</label>
          <select name="taskCategorie" id="taskCategorie" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline" >
            <option value="" disabled selected>--- Seleccione una ---</option>
            <?php
              require_once("class/Categorie.php");
              $objCatego = new Categorie();
              $listCatego = $objCatego->GetCategorie();
              foreach ($listCatego as $Catego) {
                echo "<option value='" . $Catego['ID_CATEGORIE'] . "'>" . $Catego['CAT_NAME'] ."</option>";
              }

            ?>
          </select><br>

          <input type='submit' name='addTask' value='Agregar Tarea' class="w-full block bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">

        </form>
        <div id="lista-tareas"></div>
      </div>
    </div>

    <div class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-red-500">Por Hacer</h2>
      </div>
    </div>

    <div class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-amber-500">En Curso</h2>
      </div>
    </div>

    <div class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-emerald-500">Terminada</h2>
      </div>
    </div>
  </div>

  <div>
    <h3>Filtro por categorias</h3>
    <?php
      require_once("class/Categorie.php");
      $objCatego = new Categorie();
      $listCatego = $objCatego->GetCategorie();
      foreach ($listCatego as $Catego) {
        echo "<input type='checkbox' id='ckCategories' name='ckCategories' value='" . $Catego['ID_CATEGORIE'] ."' checked>\n";
        echo "<label for='ckCategories'>" . $Catego['CAT_NAME'] ."</label><br>";
      }
    ?>
    <button>Filtrar categorias</button>
    <button>Agregar categorias</button>
  </div>

  <div>
    <h3>Filtro por Usuarios</h3>
    <?php
      require_once("class/Users.php");
      $objUsers = new users();
      $listUser = $objUsers->GetUsers();
      foreach ($listUser as $user) {
        echo "<input type='checkbox' id='ckUser' name='ckUser' value='" . $user['ID_USER'] ."' checked>\n";
        echo "<label for='ckUser'>" . $user['USER_LAST_NAME'] . " " . $user['USER_FIRST_NAME'] . "</label><br>";
      }
    ?>
    <button>Filtrar Usuarios</button>
    <button>Agregar Usuarios</button>
  </div>

  <button data-modal-target="defaultModal" data-modal-toggle="defaultModal"  id="abrirModal">Abrir Modal</button>

    <!-- Modal -->
    <div id="miModal" class="modal">
      <div class="modal-content">
        <div class="flex items-start justify-between p-4 border-b rounded-t">
          <h3 class="text-xl font-semibold text-gray-900 ">Modificar tarea</h3>
          <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="defaultModal">
            <span id="cerrarModal" style="cursor: pointer;">&times;</span>    
            <span class="sr-only">Close modal</span>
          </button>
        </div>
        <div class="p-6 space-y-6">
            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                With less than a month to go before the European Union enacts new consumer privacy laws for its citizens, companies around the world are updating their terms of service agreements to comply.
            </p>
            <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400">
                The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is meant to ensure a common set of data rights in the European Union. It requires organizations to notify users as soon as possible of high-risk data breaches that could personally affect them.
            </p>
        </div>
      </div>
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
  if(array_key_exists('addTask', $_POST))
  {
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

?>
