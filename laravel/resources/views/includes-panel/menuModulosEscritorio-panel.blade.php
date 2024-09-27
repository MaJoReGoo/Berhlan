<?php
use App\Models\PanelLogin;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCentrosOp;
?>

<link rel="stylesheet" type="text/css"
    href="{{ asset('/public/css/includes-panel/modales/menuModulosEscritorio-panel.blade.css') }}">

<header class="sidebar-header">
    <!-- -------------- Sidebar - Author -------------- -->
    <div class="sidebar-widget author-widget">
        <div class="media">
            <div class="media-body">
                <div style="text-align: left">

                </div>
            </div>
        </div>
    </div>
</header>

<br>

<ul class="nav sidebar-menu">
    <li>
        <a class="menu-link" href="{{ asset('/panel/noticias/noticias') }}" style="cursor: pointer"
            onclick="localStorage.setItem('menu', '{{ asset('/panel/noticias/noticias') }}">
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
    // Verifica que $DatLog esté definido
    if (isset($DatLog)) {
        // Si tiene todos los permisos tipo Máster
        if ($DatLog->master == 1) {
            $Modulo = PanelLogin::getMenuT(0);
        } else {
            $Modulo = PanelLogin::getMenu($DatLog->modulos, 0);
        }
    }
    ?>
    @foreach ($Modulo as $DatMod)
        <li>
            <a class="menu-link" href="{{ asset('/panel') }}/{{ $DatMod->url }}" style="cursor: pointer"
                onclick="localStorage.setItem('menu', '{{ asset('/panel') }}/{{ $DatMod->url }}">
                <span class="fa <?= $DatMod->icono ?>"></span>
                <span class="sidebar-title">
                    <?= $DatMod->nombre ?>
                </span>
            </a>
        </li>
        @endforeach
</ul>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let urlveri = window.location.href;
        urlveri = urlveri.split('/');
        urlveri = urlveri[5] + '/' + urlveri[6];
        if (urlveri === 'panel/loginverification') {
            localStorage.setItem('menu', "{{ asset('/panel/noticias/noticias') }}");

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

