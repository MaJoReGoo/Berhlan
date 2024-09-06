<?php
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCentrosOp;
?>

<style>
    .sidebar-menu>li>a:hover {
        color: #67d3e0;
    }
</style>

<header class="sidebar-header">
  <!-- -------------- Sidebar - Author -------------- -->
  <div class="sidebar-widget author-widget">
    <div class="media">
      <div class="media-body">
        <div style="text-align: left">
          {{-- <span class="media-author">
            <?php
            $Empleado = PanelEmpleados::getEmpleado($DatLog->empleado);
            ?>
            @foreach($Empleado as $DatEmpleados)
              <?php
              echo $DatEmpleados->primer_nombre." ".$DatEmpleados->ot_nombre;
              echo "&nbsp;";
              echo $DatEmpleados->primer_apellido." ".$DatEmpleados->ot_apellido;
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
                    echo " | ";
                    echo $DatCargo->descripcion;
                    ?>
                  @endforeach
                @endforeach
                <?php
                $Centro = PanelCentrosOp::getCentroOp($DatEmpleados->centro_op);
                ?>
                &nbsp;|&nbsp;
                @foreach($Centro as $DatCentro)
                  <?=$DatCentro->descripcion?>
                @endforeach
              </font>
            @endforeach
          </span> --}}
        </div>
      </div>
    </div>
  </div>
</header>

<br>

<ul class="nav sidebar-menu">
  <li>
    <a  class="menu-link" href="<?=$server?>/panel/noticias/noticias" style="cursor: pointer" onclick="localStorage.setItem('menu', '<?= $server ?>/panel/noticias/noticias')">
      <span class="fa fa-home fa-5x"></span>
      <span class="sidebar-title">
        <font>
          Inicio
        </font>
      </span>
    </a>
  </li>

  <!-- Lista los accesos del menú permitidos -->
  <?php
  //Si tiene todos los permisos tipo Máster
  if($DatLog->master == 1)
    $Modulo = PanelLogin::getMenuT(0);
  else
    $Modulo = PanelLogin::getMenu($DatLog->modulos, 0);
  ?>
  @foreach($Modulo as $DatMod)
    <li>
      <a class="menu-link" href="<?=$server?>/panel/<?=$DatMod->url?>" style="cursor: pointer" onclick="localStorage.setItem('menu', '<?= $server ?>/panel/<?= $DatMod->url ?>')">
        <span class="fa <?=$DatMod->icono?> fa-2x"></span>
        <span class="sidebar-title">
          <?=$DatMod->nombre?>
        </span>
      </a>
    </li>
  @endforeach

  <!-- Logout -->
  {{-- <li>
    <a href="<?=$server?>/panel/logout" style="cursor: pointer">
      <span class="fa fa-sign-out fa-2x" style="color: #CADB47;"></span>
      <span class="sidebar-title">
        <font style="color: #CADB47;">
          Salir
        </font>
      </span>
    </a>
  </li> --}}
</ul>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let urlveri = window.location.href;
        urlveri = urlveri.split('/');
        urlveri = urlveri[5] + '/' + urlveri[6];
        if (urlveri === 'panel/loginverification') {
            localStorage.setItem('menu', '<?= $server ?>/panel/noticias/noticias')
        }

        var menuLinks = document.querySelectorAll('.menu-link');
        menuLinks.forEach(function(link) {
            var url = link.getAttribute('href');
            if (localStorage.getItem('menu') === url) {
                link.style.color = '#CADB47';

            }
        });
    });
</script>
