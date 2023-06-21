<!DOCTYPE html>
<html>
<head>
    <title>Orden de trabajo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>


<style>
    .logo {
        width: 40px; /* Ajusta el ancho del logo según tus necesidades */
    }
    .logo-container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px; /* Ajusta el margen inferior según tus necesidades */
    }
    .nav-bg {
        background-image: url('public/img/fondo.jpg'); /* Ruta de la imagen de fondo */
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<div class="nav-bg">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarNav">
            <div class="logo-container">
                <img src="img/car-repair.png" alt="Logo de la empresa" class="logo">
            </div>
            <a class="navbar-brand" href="#"><h2>Bienvenido </h2></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="vistaWelcome.html">Atras</a>
                </li>
            </ul>
        </div>
    </nav>
</div>

<div class="container-fluid">
    <div class="row">


        <div class="col-md-8">

            <h2 class="pull-left"> ordenes de trabajo</h2>
            <a href="create.php" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Agregar </a>




        </div>

        <?php
             // Include config file
             require_once "config.php";

              // Attempt select query execution
              $sql = "SELECT * FROM orden_de_trabajo";
             if($result = mysqli_query($link, $sql)){
            if(mysqli_num_rows($result) > 0){
        echo '<table class="table table-bordered table-striped">';
        echo "<thead>";
        echo "<tr>";
            echo "<th>id_orden_trabajo</th>";
            echo "<th>Fecha Creacion</th>";
            echo "<th>Fecha Actual</th>";
            echo "<th>Fecha Estimada</th>";
            echo "<th>Descripcion</th>";
            echo "<th>estado</th>";
            echo "<th>Cliente</th>";
            echo "<th>Patente</th>";
            echo "<th>Trabajador</th>";
            echo "<th>Acciones</th>";
            echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = mysqli_fetch_array($result)){
        echo "<tr>";
            echo "<td>" . $row['id_orden_trabajo'] . "</td>";
            echo "<td>" . $row['fecha_creacion'] . "</td>";
            echo "<td>" . $row['fecha_actual'] . "</td>";
            echo "<td>" . $row['fecha_estimada'] . "</td>";
            echo "<td>" . $row['descripcion'] . "</td>";
            echo "<td>" . $row['estado'] . "</td>";
            echo "<td>" . $row['fkid_cliente'] . "</td>";
            echo "<td>" . $row['fkid_patente'] . "</td>";
            echo "<td>" . $row['fkrut'] . "</td>";
            echo "<td>";
                echo '<a href="read.php?id_orden_trabajo='. $row['id_orden_trabajo'] .'" class="mr-3" title="View Record" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                echo '<a href="update.php?id_orden_trabajo='. $row['id_orden_trabajo'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                echo '<a href="delete.php?id_orden_trabajo='. $row['id_orden_trabajo'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                echo "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
        } else{
        echo '<div class="alert alert-danger"><em>No existen registros</em></div>';
        }
        } else{
        echo "Oops! Something went wrong. Please try again later.";
        }

        // Close connection
        mysqli_close($link);
        ?>

    </div>
</div>

<!-- Modal para mostrar los datos de la orden de trabajo -->
<div class="modal fade" id="ordenModal" tabindex="-1" role="dialog" aria-labelledby="ordenModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ordenModalLabel">Detalles de la orden de trabajo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>ID de Orden: <span id="modalIdOrden"></span></h6>
                <p>Fecha de Creación: <span id="modalFechaCreacion"></span></p>
                <p>Fecha Actual: <span id="modalFechaActual"></span></p>
                <p>Fecha Estimada: <span id="modalFechaEstimada"></span></p>
                <p>Trabajador Asignado: <span id="modalTrabajadorAsignado"></span></p>
                <p>ID de Cliente: <span id="modalClienteId"></span></p>
                <p>Patente: <span id="modalPatente"></span></p>
                <p>ID de Producto: <span id="modalIdProducto"></span></p>
                <p>Descripción: <span id="modalDescripcion"></span></p>
                <p>Estado de Proceso: <span id="modalEstadoProceso"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" onclick="borrarOrden()">Borrar</button>
                <button type="button" class="btn btn-warning" onclick="modificarOrden()">Modificar</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script>
    function guardarOrden() {
        // Aquí puedes agregar la lógica para guardar la orden en el servidor


        // Actualizar la lista de órdenes en el sidebar
        var idOrden = document.getElementById('idOrden').value;
        var ordenList = document.getElementById('orden-list');
        var newOrder = document.createElement('li');
        newOrder.className = 'list-group-item';
        newOrder.innerHTML = 'Orden de trabajo ' + idOrden;
        ordenList.appendChild(newOrder);

        // Limpiar los campos del formulario
        document.getElementById('idOrden').value = '';
        document.getElementById('fechaCreacion').value = '';
        document.getElementById('fechaActual').value = '';
        document.getElementById('fechaEstimada').value = '';
        // document.getElementById('trabajadorAsignado').value = '';
        //document.getElementById('clienteId').value = '';
        // document.getElementById('patente').value = '';
        // document.getElementById('idProducto').value = '';
        document.getElementById('descripcion').value = '';
        document.getElementById('estadoProceso').value = '';

        return false; // Para evitar que se envíe y se recargue la página
    }

    function mostrarDatosOrden(ordenId) {
        // Aquí puedes agregar la lógica para obtener los datos de la orden seleccionada del servidor
        // En este ejemplo, utilizaremos datos de muestra
        var idOrden = ordenId;
        var fechaCreacion = '2023-06-16';
        var fechaActual = '2023-06-16';
        var fechaEstimada = '2023-06-30';
        var trabajadorAsignado = 'John Doe';
        var clienteId = '12345';
        var patente = 'ABC123';
        var idProducto = '67890';
        var descripcion = 'Descripción de la orden ' + ordenId;
        var estadoProceso = 'En proceso';

        // Actualizar los elementos del modal con los datos de la orden
        document.getElementById('modalIdOrden').textContent = idOrden;
        document.getElementById('modalFechaCreacion').textContent = fechaCreacion;
        document.getElementById('modalFechaActual').textContent = fechaActual;
        document.getElementById('modalFechaEstimada').textContent = fechaEstimada;
        document.getElementById('modalTrabajadorAsignado').textContent = trabajadorAsignado;
        document.getElementById('modalClienteId').textContent = clienteId;
        document.getElementById('modalPatente').textContent = patente;
        document.getElementById('modalIdProducto').textContent = idProducto;
        document.getElementById('modalDescripcion').textContent = descripcion;
        document.getElementById('modalEstadoProceso').textContent = estadoProceso;

        // Actualizar los campos del formulario con los datos de la orden
        document.getElementById('idOrden').value = idOrden;
        document.getElementById('fechaCreacion').value = fechaCreacion;
        document.getElementById('fechaActual').value = fechaActual;
        document.getElementById('fechaEstimada').value = fechaEstimada;
        document.getElementById('trabajadorAsignado').value = trabajadorAsignado;
        document.getElementById('clienteId').value = clienteId;
        document.getElementById('patente').value = patente;
        document.getElementById('idProducto').value = idProducto;
        document.getElementById('descripcion').value = descripcion;
        document.getElementById('estadoProceso').value = estadoProceso;

        // Mostrar el modal
        $('#ordenModal').modal('show');
    }


    function borrarOrden() {
        // Aquí puedes agregar la lógica para borrar la orden seleccionada del servidor
        // En este ejemplo, mostraremos una alerta con el mensaje de confirmación
        alert('Orden borrada');

        // Cerrar el modal
        $('#ordenModal').modal('hide');
    }

    function modificarOrden() {
        // Obtener los nuevos valores de los campos del formulario
        var idOrden = document.getElementById('idOrden').value;
        var fechaCreacion = document.getElementById('fechaCreacion').value;
        var fechaActual = document.getElementById('fechaActual').value;
        var fechaEstimada = document.getElementById('fechaEstimada').value;
        var trabajadorAsignado = document.getElementById('trabajadorAsignado').value;
        var clienteId = document.getElementById('clienteId').value;
        var patente = document.getElementById('patente').value;
        var idProducto = document.getElementById('idProducto').value;
        var descripcion = document.getElementById('descripcion').value;
        var estadoProceso = document.getElementById('estadoProceso').value;

        // Aquí puedes agregar la lógica para guardar los cambios en la orden en el servidor

        // Actualizar los elementos del modal con los nuevos valores
        document.getElementById('modalIdOrden').textContent = idOrden;
        document.getElementById('modalFechaCreacion').textContent = fechaCreacion;
        document.getElementById('modalFechaActual').textContent = fechaActual;
        document.getElementById('modalFechaEstimada').textContent = fechaEstimada;
        document.getElementById('modalTrabajadorAsignado').textContent = trabajadorAsignado;
        document.getElementById('modalClienteId').textContent = clienteId;
        document.getElementById('modalPatente').textContent = patente;
        document.getElementById('modalIdProducto').textContent = idProducto;
        document.getElementById('modalDescripcion').textContent = descripcion;
        document.getElementById('modalEstadoProceso').textContent = estadoProceso;

        // Cerrar el modal
        $('#ordenModal').modal('hide');
    }

</script>
</body>
</html>
