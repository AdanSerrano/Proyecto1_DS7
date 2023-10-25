<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checklist App</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
  <div class="py-2 px-1">
    <h1 class="font-bold text-4xl text-center py-5 bg-indigo-600 rounded-lg text-white">CheckList Tracker App</h1>
  </div>

  <div class="flex flex-row">
    <div class="basis-1/4 rounded-lg">
      <div class="container px-1">
        <h2 class="font-bold text-xl text-white rounded-lg py-1 text-center bg-blue-500">Crear Tarea</h2>

        <form id="formulario-tarea" class="mt-2 p-2 bg-gray-50 rounded-lg">
          <label for="titulo" class="block text-sm font-medium leading-6 text-gray-900">Titulo</label>
          <input type="text" id="titulo" class="block w-full rounded-md border-0 py-1.5 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Título" required />

          <label for="titulo" class="mt-2 block text-sm font-medium leading-6 text-gray-900">Descripcion</label>
          <textarea id="descripcion" placeholder="Descripción" class="block w-full rounded-md border-0 py-2 px-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>

          <fieldset class="mt-2">
            <legend class="text-sm font-semibold leading-6 text-gray-900">Estado</legend>
            <div class="flex items-center gap-x-3">
              <input id="rbhacer" name="por hacer" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
              <label for="rbhacer" class="block text-sm font-normal leading-6 text-gray-900">Por hacer</label>
            </div>

            <div class="flex items-center gap-x-3">
              <input id="rbcurso" name="en progreso" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
              <label for="rbcurso" class="block text-sm font-normal leading-6 text-gray-900">En curso</label>
            </div>

            <div class="flex items-center gap-x-3">
              <input id="rbterminada" name="terminada" type="radio" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600">
              <label for="rbterminada" class="block text-sm font-normal leading-6 text-gray-900">Terminada</label>
            </div>
          </fieldset>

          <input type="datetime-local" id="fecha-compromiso" required /><br />
          <label for="">Responsable</label>
          <select name="userResponse" id="userResponse" required>
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
          <button type="button" onclick="agregarTarea()">Agregar Tarea</button>
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

  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {});
  </script>
</body>

</html>