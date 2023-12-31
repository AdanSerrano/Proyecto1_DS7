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

?>

<?php
require_once("class/Tasks.php");
$objTasks = new Tasks(); // Asegúrate de crear una instancia de la clase Tasks
$listTasks = $objTasks->GetTasks(); // Obtener todas las tareas

// Lógica para procesar el formulario de filtrado
if (array_key_exists('filtrar', $_POST)) {
  // Obtener valores de filtro
  $filtroCategoria = isset($_POST['filtroCategoria']) ? $_POST['filtroCategoria'] : null;
  $filtroResponsable = isset($_POST['filtroResponsable']) ? $_POST['filtroResponsable'] : null;
  $filtroEstado = isset($_POST['filtroEstado']) ? $_POST['filtroEstado'] : null;
  

  // Filtrar la lista de tareas
  $listTasks = $objTasks->GetFilteredTasks($filtroCategoria, $filtroResponsable, $filtroEstado);
} else {
  // Si no se ha enviado el formulario de filtro, obtener todas las tareas
  $listTasks = $objTasks->GetTasks();
}
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

  <form id="filtroForm" class="mt-2 p-2 bg-gray-50 rounded-lg" action="index.php" method="post">
  <!-- Otros campos de formulario -->

  <!-- Agregar selector para categoría -->
  <label for="filtroCategoria" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Filtrar por Categoría</label>
  <select name="filtroCategoria" id="filtroCategoria" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
  <option value="" disabled selected>--- Todas ---</option>
  
    <?php
    require_once("class/Categorie.php");
    $objCatego = new Categorie();
    $listCatego = $objCatego->GetCategorie();
    foreach ($listCatego as $Catego) {
      echo "<option value='" . $Catego['ID_CATEGORIE'] . "'>" . $Catego['CAT_NAME'] . "</option>";
    }
    ?>
  </select><br>

  <!-- Agregar selector para responsable -->
  <label for="filtroResponsable" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Filtrar por Responsable</label>
  <select name="filtroResponsable" id="filtroResponsable" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
  <option value="" disabled selected>--- Todos ---</option>
  
    <?php
    require_once("class/Users.php");
    $objUsers = new users();
    $listUser = $objUsers->GetUsers();
    foreach ($listUser as $user) {
      echo "<option value='" . $user['ID_USER'] . "'>" . $user['USER_LAST_NAME'] . " " . $user['USER_FIRST_NAME'] . "</option>";
    }
    ?>
  </select><br>
  <!-- Agregar selector para estado -->
  <label for="filtroEstado" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Filtrar por Estado</label>
  <select name="filtroEstado" id="filtroEstado" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
  <option value="" disabled selected>--- Todos ---</option>
  
    <?php
    require_once("class/Parameter.php");
    $objParameter = new Parameter();
    $listParameter = $objParameter->GetParameter("ESTADOS DE TAREAS");
    foreach ($listParameter as $parameter) {
      echo "<option value='" . $parameter['ID_PARAMETER'] . "'>" .  $parameter['PARA_NAME'] . "</option>";
    }
    ?>
  </select><br>

  <input type='submit' name='filtrar' value='Filtrar' class="w-full block bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
</form>

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

          <label for="fechaCompromiso" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Fecha de
            compromiso</label>
          <input type="datetime-local" id="fechaCompromiso" name="fechaCompromiso" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline mb-4">
          <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Responsable</label>
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

          <label for="" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Categorias</label>
          <select name="taskCategorie" id="taskCategorie" class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
            <option value="" disabled selected>--- Seleccione una ---</option>
            <?php
            require_once("class/Categorie.php");
            $objCatego = new Categorie();
            $listCatego = $objCatego->GetCategorie();
            foreach ($listCatego as $Catego) {
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
                      citizens, companies around the world are updating their terms of service agreements to comply.
                    </p>
                    <p class='text-base leading-relaxed text-gray-500 dark:text-gray-400'>
                      The European Union’s General Data Protection Regulation (G.D.P.R.) goes into effect on May 25 and is
                      meant to ensure a common set of data rights in the European Union. It requires organizations to
                      notify users as soon as possible of high-risk data breaches that could personally affect them.
                    </p>
                  </div>
                </div>
              </section>";

          foreach ($listTasks as $tasks) {
            if ($tasks['TASK_STATE'] == 1) {
              echo "<div class='flex flex-col bg-white rounded-lg shadow-lg overflow-hidden bg-black m-2'>";
              echo "<div class='p-2'>";
              echo "<label class='text-base font-semibold text-gray-800'><b>" . $tasks['TASK_NAME'] . "</b></label><br>";
              echo "<label $style><b>Descripción: </b>" . $tasks['TASK_DESCRIPTION'] . "</label><br>";
              echo "<label $style>" . $tasks['CAT_NAME'] . "</label><br>";
              echo "<span class='text-base font-semibold text-gray-600 uppercase tracking-wide center' >" . $tasks['USER_NAME'] . "</span>";
              echo "</div>";
              echo "<div class='flex items-center justify-around px-2 py-2 bg-gray-100'>";
              echo $buttonEdit;
              echo $buttonModal;
              echo "<button data-task-id='" . $tasks['ID_TASK'] . "' class='delete-task-button px-3 py-1 text-xs font-semibold text-gray-700 uppercase bg-gray-200 rounded-full bg-red-400'>Eliminar</button>";
              echo "</div>";
              echo "</div>";
            }
          }

          ?>
          <button type="button" name="btn" id="5" value = "5"></button>
        </div>
      </div>
    </article>

    <article class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-amber-500">En Curso</h2>

      </div>
    </article>

    <article class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-emerald-500">Terminada</h2>
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


    var deleteButtons = document.querySelectorAll('.delete-task-button');
    deleteButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        var taskId = button.getAttribute('data-task-id');

        // Llamar a la función para eliminar la tarea y manejar la respuesta
        deleteTask(taskId);
      });
    });

    function deleteTask(taskId) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'deleteTask.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.onload = function() {
        if (xhr.status === 200) {
          // Si la eliminación fue exitosa, puedes realizar acciones adicionales si es necesario
          console.log(xhr.responseText);
          // Puedes, por ejemplo, ocultar la tarea eliminada del DOM
          var deletedTaskElement = document.querySelector('[data-task-id="' + taskId + '"]').closest('.flex-col');
          deletedTaskElement.remove();
        } else {
          // Manejar errores si es necesario
          console.error('Error al eliminar la tarea.');
        }
      };
      xhr.send('taskId=' + encodeURIComponent(taskId));
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

  require_once("class/Tasks.php");
  $objTasks = new Tasks();
  $result = $objTasks->PostTasks($titulo, $descripcion, $estado, $fechaCompromiso, $responsable, $categoria);
}

?>