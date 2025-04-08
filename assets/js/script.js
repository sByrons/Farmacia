function verificarTipoUsuario() {
    const tipo = document.getElementById('id_tipo');
    const camposLogin = document.getElementById('camposLogin');

    if (!tipo || !camposLogin) return;

    const valor = tipo.value;

    if (valor === '1' || valor === '2') {
        camposLogin.style.display = 'block';

        document.getElementById('usuario').disabled = false;
        document.getElementById('contrasena').disabled = false;
        document.getElementById('id_puesto').disabled = false;
    } else {
        camposLogin.style.display = 'none';

        document.getElementById('usuario').value = '';
        document.getElementById('contrasena').value = '';
        document.getElementById('id_puesto').selectedIndex = 0;

        document.getElementById('usuario').disabled = true;
        document.getElementById('contrasena').disabled = true;
        document.getElementById('id_puesto').disabled = true;
    }
}

function cargarCombosDireccion() {
    const provincia = document.getElementById('provincia');
    const canton = document.getElementById('canton');
    const distrito = document.getElementById('distrito');

    if (!provincia || !canton || !distrito) return;

    provincia.addEventListener('change', () => {
        const idProvincia = provincia.value;
        if (!idProvincia) return;

        fetch(`/Farmacia/controllers/catalogoController.php?accion=cantones&provincia=${idProvincia}`)
            .then(res => res.json())
            .then(data => {
                canton.innerHTML = '<option value="">Seleccione cantón</option>';
                distrito.innerHTML = '<option value="">Seleccione distrito</option>';
                data.forEach(c => {
                    canton.innerHTML += `<option value="${c.CANTON_ID_CANTON_PK}">${c.NOMBRE}</option>`;
                });
            });
    });

    canton.addEventListener('change', () => {
        const idCanton = canton.value;
        if (!idCanton) return;

        fetch(`/Farmacia/controllers/catalogoController.php?accion=distritos&canton=${idCanton}`)
            .then(res => res.json())
            .then(data => {
                distrito.innerHTML = '<option value="">Seleccione distrito</option>';
                data.forEach(d => {
                    distrito.innerHTML += `<option value="${d.DISTRITO_ID_DISTRITO_PK}">${d.NOMBRE}</option>`;
                });
            });
    });
}

window.addEventListener('DOMContentLoaded', () => {
    verificarTipoUsuario();     
    cargarCombosDireccion();      
});

