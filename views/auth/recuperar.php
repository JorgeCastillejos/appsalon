<h1 class="nombre-pagina">Recupera tu Password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password a continuacion</p>

<?php include_once __DIR__ . '../../../templates/alertas.php'; ?>

<?php if($desaparece) return; ?>

<form method="POST" class="formulario">

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" placeholder="Tu nuevo password aqui" name="password">
    </div>

    <input type="submit" class="boton" value="Guardar Cambios">
</form>