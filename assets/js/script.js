function verificarTipoUsuario() {
    const tipo = document.getElementById('id_tipo').value;
    const camposLogin = document.getElementById('camposLogin');

    if (tipo === '1' || tipo === '2') {
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

function mostrarOcultarCampos() {
    const tipo = document.getElementById('campo_tipo').value;
    const mostrar = (tipo === '1' || tipo === '2');
    
    document.getElementById('campo_usuario').style.display = mostrar ? '' : 'none';
    document.getElementById('campo_contrasena').style.display = mostrar ? '' : 'none';
    document.getElementById('campo_puesto').style.display = mostrar ? '' : 'none';
}

window.onload = mostrarOcultarCampos;

document.addEventListener('DOMContentLoaded', verificarTipoUsuario);

