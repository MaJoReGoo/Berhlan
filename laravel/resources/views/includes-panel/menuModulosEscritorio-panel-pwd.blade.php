<?php

use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCentrosOp;
?>

<header class="sidebar-header">
    <!-- -------------- Sidebar - Author -------------- -->
    <div class="sidebar-widget author-widget">
        <div class="media">
            <div class="media-body">
                <div style="text-align: left">
                    <span class="media-author">
                        <center>
                            <?php
                            $Empleado = PanelEmpleados::getEmpleado($DatLog->empleado);
                            ?>
                            @foreach($Empleado as $DatEmpleados)
                            <?php
                            echo $DatEmpleados->primer_nombre . " " . $DatEmpleados->ot_nombre;
                            echo "<br/>";
                            echo $DatEmpleados->primer_apellido . " " . $DatEmpleados->ot_apellido;
                            echo "<br>";
                            echo "<font size=1>";
                            $Cargo = PanelCargos::getCargo($DatEmpleados->cargo);
                            ?>
                            @foreach($Cargo as $DatCargo)
                            <?php
                            $Area = PanelAreas::getArea($DatCargo->area);
                            ?>
                            @foreach($Area as $DatArea)
                            <?php
                            echo $DatArea->descripcion;
                            echo " <br/> ";
                            echo $DatCargo->descripcion;
                            echo " <br/> ";
                            ?>
                            @endforeach
                            @endforeach
                            <?php
                            $Centro = PanelCentrosOp::getCentroOp($DatEmpleados->centro_op);
                            ?>
                            @foreach($Centro as $DatCentro)
                            <?= $DatCentro->descripcion ?>
                            @endforeach
                            </font>
                            @endforeach
                        </center>
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>

<br>

<ul class="nav sidebar-menu">
    <!-- Logout -->
    <li>
        <a href="{{ asset ('/panel/logout')}}" style="cursor: pointer">
            <span class="fa fa-sign-out fa-2x" style="color: #CADB47;"></span>
            <span class="sidebar-title">
                <font style="color: #CADB47;">
                    Salir
                </font>
            </span>
        </a>
    </li>
</ul>
