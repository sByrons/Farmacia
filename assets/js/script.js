function verificarTipoUsuario() {
    const tipo = document.getElementById('campo_tipo') || document.getElementById('id_tipo');
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

    const cantonSelected = canton.getAttribute('data-selected');
    const distritoSelected = distrito.getAttribute('data-selected');

    function cargarCantones(idProvincia, selectedCanton = null) {
        fetch(`/Farmacia/controllers/catalogoController.php?accion=cantones&provincia=${idProvincia}`)
            .then(res => res.json())
            .then(data => {
                canton.innerHTML = '<option value="">Seleccione cantón</option>';
                data.forEach(c => {
                    const selected = (c.CANTON_ID_CANTON_PK == selectedCanton) ? 'selected' : '';
                    canton.innerHTML += `<option value="${c.CANTON_ID_CANTON_PK}" ${selected}>${c.NOMBRE}</option>`;
                });
                if (selectedCanton) {
                    cargarDistritos(selectedCanton, distritoSelected);
                }
            });
    }

    function cargarDistritos(idCanton, selectedDistrito = null) {
        fetch(`/Farmacia/controllers/catalogoController.php?accion=distritos&canton=${idCanton}`)
            .then(res => res.json())
            .then(data => {
                distrito.innerHTML = '<option value="">Seleccione distrito</option>';
                data.forEach(d => {
                    const selected = (d.DISTRITO_ID_DISTRITO_PK == selectedDistrito) ? 'selected' : '';
                    distrito.innerHTML += `<option value="${d.DISTRITO_ID_DISTRITO_PK}" ${selected}>${d.NOMBRE}</option>`;
                });
            });
    }

    if (provincia.value && cantonSelected) {
        cargarCantones(provincia.value, cantonSelected);
    }

    provincia.addEventListener('change', () => {
        if (provincia.value) {
            cargarCantones(provincia.value);
            distrito.innerHTML = '<option value="">Seleccione distrito</option>';
        }
    });

    canton.addEventListener('change', () => {
        if (canton.value) {
            cargarDistritos(canton.value);
        }
    });
}

window.addEventListener('DOMContentLoaded', () => {
    verificarTipoUsuario();
    cargarCombosDireccion();
});



