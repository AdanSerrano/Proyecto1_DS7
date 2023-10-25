<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checklist App</title>
</head>

<body>
  <div>
    <h1>Checklist App</h1>
    <form id="formulario-tarea">
      <label for="">Titulo</label>
      <input type="text" id="titulo" placeholder="Título" required /><br />
      <label for="">Descripción</label>
      <textarea id="descripcion" placeholder="Descripción"></textarea><br />
      <label for="">Estado</label>
      <select id="estado">
        <option value="por hacer">Por Hacer</option>
        <option value="en progreso">En Progreso</option>
        <option value="terminada">Terminada</option>
      </select><br />
      <label for="">Fecha de compromiso</label>
      <input type="datetime-local" id="fecha-compromiso" required /><br />
      <label for="">Responsable</label>
      <select name="userResponse" id="userResponse" required >
            <option value="" disabled selected>--- Seleccione una ---</option>
            <?php
              require_once("class/users.php");
              $objUsers = new users();
              $listUser = $objUsers->GetUsers();
              foreach($listUser as $user){
                echo "<option value='".$user['ID_USER']."'>".$user['USER_LAST_NAME']. " " .$user['USER_FIRST_NAME']."</option>";
              }

            ?>
        </select><br>
      <button type="button" onclick="agregarTarea()">Agregar Tarea</button>
    </form>
    <div id="lista-tareas"></div>
  </div>

  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
    });
  </script>
</body>

</html>