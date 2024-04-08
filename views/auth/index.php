<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php include_once __DIR__ . '../../../templates/alertas.php' ?>

<form method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" placeholder="Tu email aqui" name="email">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" placeholder="Tu password aqui" name="password">
    </div>

    <input type="submit" class="boton" value="Iniciar Sesion">
</form>

<div class="acciones">
    <a href="/crear-cuenta">¿Aun no tienes cuenta? Crea Una</a>
    <a href="/olvide">¿Olvidaste tu Password?</a>
</div>