<?php

namespace App\Console\Commands;


use App\Models\Parametrizacion\PanelEmpleados;
use App\Models\Parametrizacion\PanelUsuariosSiesa;
use App\Http\Controllers\Parametrizacion\EmpleadosPanelController;
use Illuminate\Console\Command;

class EmpleadosInactivarSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'empleadoina:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para sincronizar los empleados con siesa de forma automatica e inactivar los que ya no existen en la compañia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         // Resolver la instancia del controlador EmpleadoController
         //$controller = app()->make(EmpleadosPanelController::class);

         $DatosConsultaSiesa = PanelUsuariosSiesa::EmpleadoTodos();
         $EmpleadosActuales = PanelEmpleados::EmpleadosActivos();

         // Obtén las identificaciones de las dos colecciones
         $identificacionesSiesa = $DatosConsultaSiesa->pluck('f200_nit')->toArray();
         $identificacionesActuales = $EmpleadosActuales->pluck('identificacion')->toArray();

         // Encuentra las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
         $result = array_diff($identificacionesActuales, $identificacionesSiesa);
         //dd($result);
         $results = [];
         foreach ($result as $DatosSiesa) {
             $infoAdicional = $EmpleadosActuales->firstWhere('identificacion', $DatosSiesa);
             //dd($infoAdicional);
             if ($infoAdicional) {

                 $result = (['estado' => 0]);
                 PanelEmpleados::actualizarEmpleado($infoAdicional->id_empleado, $result);
                 $results[] = [
                     'identificacion' => $infoAdicional->identificacion,
                     'mensaje' => 'se inactivo correctamente',
                 ];
             }

         }
        // Llamar al método del controlador
       $controller->EmpleadoUpdate();
        return $results;
    }
}
