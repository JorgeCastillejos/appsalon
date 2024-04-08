<h1>Tus Servicios</h1>


<?php 
    include_once __DIR__ . '../../../templates/barra.php';
    include_once __DIR__ . '../../../templates/alertas.php';
?>

<p class="descripcion-pagina">Actualiza o Elimina Tus Servicios</p>
<div class="citas-admin">
    <ul class="cita">
    <?php foreach($servicios as $servicio): ?>
        <li>
            
            <p><span>Id: </span> <?php echo $servicio->id; ?></p>
            <p><span>Nombre: </span> <?php echo $servicio->nombre; ?></p>
            <p><span>Precio:</span> $<?php echo $servicio->precio; ?></p>
        </li>
        
        <div class="acciones-servicios">
            <a class="boton" href="/servicios/actualizar?id=<?php echo $servicio->id ?>">Actualizar</a>
            <form method="POST" action="/servicios/eliminar">
                <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>
        </div>
        
    <?php endforeach; ?>

    </ul>
</div>


