<h1 class="nombre-pagina">Crear Cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear una cuenta</p>

<?php include_once __DIR__ . '/../../templates/alertas.php'; ?>

<form method="POST" class="formulario">
    
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="nombre" placeholder="Tu nombre aqui" name="nombre">
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="apellido" placeholder="Tu apellido aqui" name="apellido">
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" placeholder="Tu telefono aqui" name="telefono">
    </div>


    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu email aqui" name="email">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" placeholder="Tu password aqui" name="password">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesion</a>
    <a href="/olvide">¿Olvidaste tu Password?</a>
</div>