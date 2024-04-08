<h1>Panel de Administracion</h1>

<?php 
    include_once __DIR__ . '../../../templates/barra.php';
?>

<h3>Buscar Cita</h3>

<?php include_once __DIR__ . '../../../templates/alertas.php'; ?>

<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha"  value="<?php echo $fecha ?>">
        </div>
    </form>
</div>

<?php if(count($citas) === 0): ?>
    <h4 class="alerta error">No hay Citas en esta fecha</h4>
<?php endif; ?>

<div class="citas-admin">
    <ul class="cita">
        <?php 
            $inicio = 0;
        foreach($citas as $key => $cita): ?>
            <?php if($inicio !== $cita->id): ?>
                <li>
                    <p><span>Id: </span><?php echo $cita->id; ?></p>
                    <p><span>Cliente: </span><?php echo $cita->cliente; ?></p>
                    <p><span>Email: </span><?php echo $cita->email; ?></p>
                    <p><span>Telefono: </span><?php echo $cita->telefono; ?></p>
                    <p><span>Hora: </span><?php echo $cita->hora; ?></p>
                    <h3>Servicios Solicitados</h3>
                </li>

            <?php 
                $inicio = $cita->id;
            endif; ?>

            <p><?php echo $cita->servicio . " " . $cita->precio; ?></p>



            <!--Calcular el Total  a Pagar (Identificar el ultimo elemento)-->
            <?php 
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;
                $total += $cita->precio;

                if(esUltimo($actual,$proximo)){ ?>
                    <p>Total: $<?php echo $total; ?> Pesos</p>

                        <form method="POST" action="/api/eliminar">
                            <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                            <input type="submit" class="boton-eliminar" value="Borrar">
                        </form>
            <?php    }
            
            ?>

                
        <?php endforeach; ?>

        
    </ul>
</div>


<?php $script = "
    <script src='build/js/buscador.js'></script>
" ?>