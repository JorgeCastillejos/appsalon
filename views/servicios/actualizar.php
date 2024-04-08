<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Modifica los valores a actualizar</p>

<?php include_once __DIR__ . '../../../templates/alertas.php'; ?>

<form  method="POST" class="formulario" novalidate>
    <?php include_once __DIR__ . '/formularioServicio.php'; ?>    

    <input type="submit" class="boton" value="Actualizar">
</form>