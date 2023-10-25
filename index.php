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
      <input type="text" id="titulo" placeholder="Título" required /><br />
      <textarea id="descripcion" placeholder="Descripción"></textarea><br />
      <select id="estado">
        <option value="por hacer">Por Hacer</option>
        <option value="en progreso">En Progreso</option>
        <option value="terminada">Terminada</option>
      </select><br />
      <input type="datetime-local" id="fecha-compromiso" required /><br />
      <input type="text" id="responsable" placeholder="Responsable" required /><br />
      <button type="button" onclick="agregarTarea()">Agregar Tarea</button>
    </form>
    <div id="lista-tareas"></div>
  </div>

  <script src="script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      obtenerTareas();
    });
  </script>
</body>

</html>