<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CentrosSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'centros:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commando para sincronizar los centros con siesa de forma automatica';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $SiesaCentros = PanelCentrosOp::getCentrosSiesa();
        $CentrosActuales = PanelCentrosOp::getCentrosOp();

        // Obtén las descripciones de las dos colecciones
        $CentrosSiesa = $SiesaCentros->pluck('CentroDes')->toArray();
        $CentrosActuales = $CentrosActuales->pluck('descripcion')->toArray();

        // Encuentra las areas que están en $SiesaAreas pero no en $AreasActuales
        $result = array_diff($CentrosSiesa, $CentrosActuales);
        PanelCentrosOp::quitarTildes();
        foreach ($result as $centro) {

            $infoAdicional = $CentrosSiesa->where('CentroDes', $centro);
            if ($infoAdicional) {
                // Si se encuentra el área, insertar el nuevo cargo en param_cargos
                DB::table('param_centros')->insert([
                    'descripcion' => $centro,
                    'direccion' => 'N/A',
                    'ciudad' => 1,
                    'tel1' => 0,
                    'tel2' => 0,
                    'estado' => 1,

                ]);
            }
        }
        echo "Proceso completado.\n";
    }
}
