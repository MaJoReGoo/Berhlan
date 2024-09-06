<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AreasSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'areas:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para sincronizar los areas con siesa de forma automatica';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $SiesaAreas = PanelAreas::getAreaNombreSiesa();
        $AreasActuales = PanelAreas::getAreas();

        // Obtén las descripciones de las dos colecciones
        $AreasSiesa = $SiesaAreas->pluck('Area')->toArray();
        $AreasActuales = $AreasActuales->pluck('descripcion')->toArray();

        // Encuentra las areas que están en $SiesaAreas pero no en $AreasActuales
        $result = array_diff($AreasSiesa, $AreasActuales);
        PanelAreas::quitarTildes();
        foreach ($result as $area) {

            $infoAdicional = $SiesaAreas->Where('Area', $area);
            // Si el area no existe, crearlo en param_areas
            if ($infoAdicional->isNotEmpty()) {
                // Encuentra las descripciones que están en $DatosConsultaSiesa pero no en $CargosActuales
                foreach ($infoAdicional as $info) {

                    $empresaId = PanelEmpresas::getEmpresasNombre($info->Empresa);

                    $areaExistente = DB::table('param_areas')
                        ->where('descripcion', $info->Area)
                        ->where('empresa', $empresaId)
                        ->exists();

                    if (!$areaExistente) {
                        // Si se encuentra el área, insertar el nuevo cargo en param_cargos
                        DB::table('param_areas')->insert([
                            'descripcion' => $info->Area,
                            'empresa' => $empresaId,
                            'estado' => 1,
                            'id_siesa' => $info->id_siesa,
                        ]);
                    } else {
                        // Manejar el caso en el que el área no existe en param_areas

                        echo "Error: El área '{$info->Area}' no existe en param_areas.\n";
                    }
                }
            }
        }
        echo "Proceso completado.\n";
    }
}
