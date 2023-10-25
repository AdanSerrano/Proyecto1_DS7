function agregarTarea() {
    const titulo = document.getElementById('titulo').value;
    const descripcion = document.getElementById('descripcion').value;
    const estado = document.getElementById('estado').value;
    const fechaCompromiso = document.getElementById('fecha-compromiso').value;
    const responsable = document.getElementById('responsable').value;
    const tipoTareaID = 1; // ID del tipo de tarea, ajusta según tus necesidades

    fetch('todolist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `titulo=${titulo}&descripcion=${descripcion}&estado=${estado}&fechaCompromiso=${fechaCompromiso}&responsable=${responsable}&tipoTareaID=${tipoTareaID}`
    })
        .then(response => response.text())
        .then(data => {
            alert(data); // Muestra la respuesta del servidor
            obtenerTareas();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

function obtenerTareas() {
    fetch('todolist.php', {
        method: 'GET',
    })
        .then(response => response.json())
        .then(data => {
            const listaTareas = document.getElementById('lista-tareas');
            listaTareas.innerHTML = '';
            data.forEach(tarea => {
                const tareaElemento = document.createElement('div');
                tareaElemento.textContent = `Título: ${tarea.Titulo}, Descripción: ${tarea.Descripcion}, Estado: ${tarea.Estado}, Fecha Compromiso: ${tarea.FechaCompromiso}, Responsable: ${tarea.Responsable}`;
                listaTareas.appendChild(tareaElemento);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
}
