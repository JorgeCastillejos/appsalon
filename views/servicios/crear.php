<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Llena los campos para crear un nuevo servicio</p>

<?php include_once __DIR__ . '../../../templates/alertas.php'; ?>

<form action="/servicios/crear" method="POST" class="formulario" novalidate>
    <?php include_once __DIR__ . '/formularioServicio.php'; ?>    

    <input type="submit" class="boton" value="Crear">
</form>