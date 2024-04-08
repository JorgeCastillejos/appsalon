<h1>Crear nueva Cita</h1>
<p class="descripcion-pagina">Elije tus Servicios y Coloca tus datos</p>

<?php include_once __DIR__ . '/../../templates/barra.php'; ?>

<div id="app">
    <!--Navegacion-->
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>

    

    <!--SECCION 1-->
    <div id="paso-1" class="seccion">
        <h3>Servicios</h3>
        <p class="descripcion-pagina">Elije tus Servicios a continuacion</p>
        <div id="servicios" class="listado-servicios"></div> <!--Aqui Inyectaremos el Codigo JS-->
    </div>

    <!--SECCION 2--->
    <div id="paso-2" class="seccion">
        <h3>Tus Datos y Cita</h3>
        <p class="descripcion-pagina">Elije la Fecha y Hora de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" placeholder="Tu Nombre Aqui" value="<?php echo $nombre; ?>" disabled>
            </div>

            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" id="fecha" min="<?php echo date('Y-m-d', strtotime("+2 day"))?>">
            </div>

            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time" id="hora">
            </div>

            <input type="hidden" id="id" value="<?php echo $id; ?>">
            <input type="hidden" id="nombre" value="<?php echo $nombre; ?>">
        </form>
    </div>

    <!--SECCION 3-->
    <div id="paso-3" class="seccion contenido-resumen">
        <h3>Resumen</h3>
        <p class="descripcion-pagina">Verifica que la informacion sea Correcta</p>
    </div>

    <!--PAGINACION-->
    <div class="paginacion">
        <button type="button" class="boton" id="anterior">&laquo; Anterior</button>
        <button type="button" class="boton" id="siguiente">Siguiente &raquo;</button>
    </div>

</div>

<?php $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script src='/build/js/app.js'></script>
"; ?>