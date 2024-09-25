<?php
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;

?>

<style>
    /* Style The Dropdown Button */
    .dropbtn {
        background-color: #2a2f43 !important;
        color: #868fb3;
        height: 64px;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    /* The container <div> - needed to position the dropdown content */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    /* Dropdown Content (Hidden by Default) */
    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        min-width: 250px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
        text-align: center;
    }

    /* Links inside the dropdown */
    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    /* Change color of dropdown links on hover */
    .dropdown-content a:hover {
        background-color: #f1f1f1;
        text-decoration: underline;
        text-decoration-color: #67d3e0;
    }

    /* Show the dropdown menu on hover */
    /* .dropdown:hover .dropdown-content {
        display: block;
    } */

    .dropdown-content {
        right: 0;
    }

    /* Change the background color of the dropdown button when the dropdown content is shown */
    .dropdown:hover .dropbtn {
        background-color: #3e8e41;
    }

    .usuario {
        margin-left: auto;
        margin-right: 22px;
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
    }

    .salir {
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 40px;
    }

    .salir:hover {
        color: transparent;
    }
</style>



<div style="display: flex">
    <div>
        <div class="navbar-logo-wrapper bg-dark">
            <a class="navbar-logo-text" href="{{ asset ('/panel/noticias/noticias')}}"
                onclick="localStorage.setItem('menu', '{{ asset ('/panel/noticias/noticias')}}">
                <img src="{{ asset ('/panelfiles/assets/img/logo1_wh.png')}}" style="height: 40px">
            </a>
            <span id="sidebar_left_toggle" class="ad ad-lines"></span>
        </div>
    </div>
    <div class="usuario">
        <?php
        $Empleado = PanelEmpleados::getEmpleado($DatLog->empleado);
        ?>
        <font color = "#67d3e0">


            @foreach ($Empleado as $DatEmpleados)
                <?php
                echo $DatEmpleados->primer_nombre . ' ' . $DatEmpleados->ot_nombre;
                echo '&nbsp;';
                echo $DatEmpleados->primer_apellido . ' ' . $DatEmpleados->ot_apellido;
                echo '</font>';
                echo '<font color = "#67d3e0" size = 1>';
                $Cargo = PanelCargos::getCargo($DatEmpleados->cargo);
                ?>

                @foreach ($Cargo as $DatCargo)
                    <?php
                    $Area = PanelAreas::getArea($DatCargo->area);
                    ?>
                    @foreach ($Area as $DatArea)
                        <?php
                        echo $DatCargo->descripcion;
                        ?>
                    @endforeach
                @endforeach
                {{-- <?php
                $Centro = PanelCentrosOp::getCentroOp($DatEmpleados->centro_op);
                ?>
        &nbsp;|&nbsp;
        @foreach ($Centro as $DatCentro)
            <?= $DatCentro->descripcion ?>
        @endforeach --}}

        </font>
        @endforeach


    </div>

    <div class="dropdown" style="margin-right: 20px;">
        <button class="dropbtn">
            <img style="width: 33px" src="{{ asset ('/panelfiles/iconos/usuario.png')}}">
        </button>
        <div class="dropdown-content">
            <a href="" data-toggle="modal" data-target="#actualizarModal"> <i
                    class="fa-solid fa-pen-to-square"></i> &nbsp&nbspActualizar mis datos</a>
            {{-- <a href="<?= $server ?>/panel/cambiopwd">Cambiar mi contraseña</a> --}}
        </div>
    </div>
    <a href="{{ asset ('/panel/logout')}}" class="salir" title="Salir">
        {{-- <i class="fa-regular fa-arrow-right-from-bracket fa-lg" style="color: #CADB47;" ></i> --}}
        <i class="fa-solid fa-power-off fa-lg" style="color: #CADB47;"></i>
    </a>


</div>

@include('includes-panel/modales/actualizarMisDatos')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

{{-- <ul class="nav navbar-nav navbar-right">
    <li class="dropdown dropdown-fuse">
        <a href="<?= $server ?>/panel/noticias/noticias" class="fw600">
            <img src="<?= $server ?>/panelfiles/assets/img/logo1_wh.png" style="height: 40px">
        </a>
    </li>
</ul> --}}


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropbtn = document.querySelector('.dropbtn');
        var dropdownContent = document.querySelector('.dropdown-content');

        dropbtn.addEventListener('click', function() {
            if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
                dropdownContent.style.display = 'block';
            } else {
                dropdownContent.style.display = 'none';
            }
        });

        document.addEventListener('click', function(event) {
            if (!dropbtn.contains(event.target) && !dropdownContent.contains(event.target)) {
                dropdownContent.style.display = 'none';
            }
        });
    });
</script>
