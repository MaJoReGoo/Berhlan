<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Parametrizacion\PanelAreas;
use App\Models\Parametrizacion\PanelCargos;
use DB;

class CargosSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cargos:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para sincronizar los cargos con siesa de forma automatica';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $siesaCargos = PanelCargos::getCargoNombreSiesa();
        $CargosActualesC = PanelCargos::getCargos();

        // Obtén las identificaciones de las dos colecciones
        $CargosSiesa = $siesaCargos->pluck('Cargo')->toArray();
        $CargosActuales = $CargosActualesC->pluck('descripcion')->toArray();

        // Encuentra las identificaciones que están en $DatosConsultaSiesa pero no en $EmpleadosActuales
        $result = array_diff($CargosSiesa, $CargosActuales);
        PanelCargos::quitarTildes();
        // Obtener la información de Siesa
        foreach ($result as $cargo) {

            $infoAdicional = $siesaCargos->Where('Cargo', $cargo);
            // Si el cargo no existe, crearlo en param_cargos
            if ($infoAdicional->isNotEmpty()) {

                foreach ($infoAdicional as $info) {

                    $areaId = PanelAreas::getAreasNombre($info->Area);

                    $cargoExistente = DB::table('param_cargos')
                        ->where('descripcion', $info->Cargo)
                        ->where('area', $areaId)
                        ->exists();

                    if (!$cargoExistente) {
                        // Si se encuentra el área, insertar el nuevo cargo en param_cargos
                        DB::table('param_cargos')->insert([
                            'descripcion' => $info->Cargo,
                            'area' => $areaId,
                            'estado' => 1, // Puedes ajustar el estado según tus necesidades
                        ]);
                    } else {
                        // Manejar el caso en el que el área no existe en param_areas
                        // Puedes lanzar una excepción, registrar un log, o manejarlo de acuerdo a tus necesidades.
                        // En este ejemplo, simplemente se imprimirá un mensaje.
                        echo "Error: El área '{$info->Area}' no existe en param_areas.\n";
                    }
                }
            }
        }
        echo "Proceso completado.\n";
    }
}
