<?php

namespace App\Console\Commands;

use App\Models\Parametrizacion\PanelCargos;
use App\Models\Parametrizacion\PanelCentrosOp;
use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelUsuarios;
use App\Models\Parametrizacion\PanelUsuariosSiesa;
use App\Http\Controllers\Parametrizacion\EmpleadosPanelController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Command;

class EmpleadosSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'empleado:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para sincronizar los empleados con siesa de forma automatica';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Resolver la instancia del controlador EmpleadoController
        $controller = app()->make(EmpleadosPanelController::class);
        $DatosConsultaSiesa = PanelUsuariosSiesa::EmpleadoTodos();
        $EmpleadosActuales = PanelEmpleados::EmpleadosT();

        // Obtén las identificaciones de las dos colecciones
        $identificacionesSiesa = $DatosConsultaSiesa->pluck('f200_nit')->toArray();
        $identificacionesActuales = $EmpleadosActuales->pluck('identificacion')->toArray();

        // Encuentra las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
        $result = array_diff($identificacionesSiesa, $identificacionesActuales);

        // $diff ahora contiene las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
        $results = [];

        //dd($result);
        foreach ($result as $DatosSiesa) {

            $infoAdicional = $DatosConsultaSiesa->firstWhere('f200_nit', $DatosSiesa);
            //dd($infoAdicional);

            if ($infoAdicional) {
                $nombres = $infoAdicional->f200_nombres;

                if (strpos($nombres, ' ') !== false) {
                    list($nombre1, $nombre2) = explode(' ', $nombres, 2);
                } else {
                    $nombre1 = $nombres;
                    $nombre2 = '';
                }

                // Obtener el ID del cargo correspondiente
                $cargo = PanelCargos::getCargoNombre($infoAdicional->Cargo);
                $centro = PanelCentrosOp::getCentroNombre($infoAdicional->CentroDes);

                if ($cargo && $centro) {

                    $result = ([
                        'identificacion' => $infoAdicional->f200_nit,
                        'primer_nombre' => $nombre1,
                        'ot_nombre' => $nombre2,
                        'primer_apellido' => $infoAdicional->f200_apellido1,
                        'ot_apellido' => $infoAdicional->f200_apellido2,
                        'fecha_nacimiento' => $infoAdicional->f200_fecha_nacimiento,
                        'correo' => $infoAdicional->Correo,
                        'numtel' => $infoAdicional->Tel,
                        'cargo' => $cargo->id_cargo,
                        'centro_op' => $centro->id_centro,
                        'estado' => 1,

                    ]);
                    $empleadoId = PanelEmpleados::insertarEmpleadoGetId($result);
                    //PanelEmpleados::insertarEmpleado($result);

                    $usuario = ([
                        'empleado' => $empleadoId,
                        'login' => $infoAdicional->f200_nit,
                        'password' => Hash::make($infoAdicional->f200_nit),
                        'estado' => 0,
                        'master' => 0,
                        'modulos' => 1,

                    ]);
                    PanelUsuarios::insertarUsuario($usuario);

                    $results[] = [
                        'identificacion' => $infoAdicional->f200_nit,
                        'mensaje' => 'Inserción exitosa',
                    ];

                } else {
                    // Manejar el caso donde no se encuentra el cargo correspondiente
                    $results[] = [
                        'identificacion' => $infoAdicional->f200_nit,
                        'mensaje' => 'Error: Cargo no encontrado',
                    ];

                }

            }
        }
        // Llamar al método del controlador
       $controller->EmpleadoUpdate();

        return 'ok';
    }
}
