<?php

use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelEmpresas;
use App\Models\Parametrizacion\PanelCentrosOp;

?>

<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/css/includes-panel/modales/headerInterno-panel.blade.css') }}">

<div style="display: flex">
    <div>
        <div class="navbar-logo-wrapper bg-dark">
            <a class="navbar-logo-text" href="{{ asset('/panel/noticias/noticias') }}"
                onclick="localStorage.setItem('menu', '{{ asset('/panel/noticias/noticias') }}">
                <img src="{{ asset('/panelfiles/assets/img/logo1_wh.png') }}" style="height: 40px">
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


        </font>
        @endforeach


    </div>

    <div class="dropdown" style="margin-right: 20px;">
        <button class="dropbtn">
            <img style="width: 33px" src="{{ asset('/panelfiles/iconos/usuario.png') }}">
        </button>
        <div class="dropdown-content">
            <a href="" data-toggle="modal" data-target="#actualizarModal"> <i
                    class="fa-solid fa-pen-to-square"></i> &nbsp&nbspActualizar mis datos</a>

        </div>
    </div>
    <a href="{{ asset('/panel/logout" class="salir') }}" title="Salir">
        {{-- <i class="fa-regular fa-arrow-right-from-bracket fa-lg" style="color: #CADB47;" ></i> --}}
        <i class="fa-solid fa-power-off fa-lg" style="color: #CADB47;"></i>
    </a>


</div>

@include('includes-panel/modales/actualizarMisDatos')


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


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
