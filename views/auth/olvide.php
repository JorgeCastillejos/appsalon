<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablece tu password escribiendo tu email a continuacion</p>

<?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu email aqui" name="email">
    </div>
    
    <input type="submit" class="boton" value="Enviar Instrucciones">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesion</a>
    <a href="/crear-cuenta">¿Aun no tienes cuenta? Crea Una</a>
</div>