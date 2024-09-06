<table>
    <thead>
        <tr>
            <th>
                N° No conformidad
            </th>
            <th>
                Sistema de gestión
            </th>
            <th>
                Ciclo auditoría
            </th>
            <th>
                Fecha auditoría
            </th>
            <th>
                Lugar
            </th>
            <th>
                Fecha elaboración correctiva y/o mejora
            </th>
            <th>
                Fuente
            </th>
            <th>
                Proceso No Conforme
            </th>
            <th>
                Nombre del R de proceso que reporta la No Conformidad
            </th>
            <th>
                Cargo del R de proceso que reporta la No Conformidad
            </th>
            <th>
                Tipo
            </th>
            <th>
                Descripción de la(s) No Conformidad (es) y/o Observación
            </th>
            <th>
                Nombre del Responsable de la No Conformidad
            </th>
            <th>
                Cargo del Responsable de la No Conformidad
            </th>
            <th>
                Persona del equipo de trabajo
            </th>
            <th>
                Cargo de la persona del equipo de trabajo
            </th>
            <th>
                Impacto y Riesgo de la No Conformidad
            </th>
            <th>
                Mano de obra
            </th>
            <th>
                Maquinaria
            </th>
            <th>
                Método
            </th>
            <th>
                Materiales
            </th>
            <th>
                Medio Ambiente
            </th>
            <th>
                Otros Factores
            </th>
            <th>
                Plan Accion No.
            </th>
            <th>
                Plan Accion actividad/tarea
            </th>
            <th>
                Plan Accion responsable
            </th>
            <th>
                Plan Accion cargo responsable
            </th>
            <th>
                Plan Accion Fecha implementación
                de la actividad/tarea
            </th>
            <th>
                Seguimiento Fecha del seguimiento
            </th>
            <th>
                Seguimiento NO.
            </th>
            <th>
                Seguimiento actividad/tareas ejecutadas
            </th>
            <th>
                Seguimiento compromisos pendientes
            </th>
            <th>
                Responsable del seguimiento
            </th>
            <th>
                Cargo responsable del seguimiento
            </th>
            <th>
                Fecha de verificación
            </th>
            <th>
                Observaciones de verificación
            </th>
            <th>
                Nombre resposable de verificación
            </th>
            <th>
                Cargo resposable de verificación
            </th>
            <th>
                Programada para cerrar en fecha
            </th>
            <th>
                Responsable de cerrar
            </th>
            <th>
                Cargo de responsable de cerrar
            </th>
            <th>
                Cerrada realmente en fecha
            </th>
            <th>
                Responsable de cerrar realmente
            </th>
            <th>
                Cargo responsable de cerrar realmente
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reportes as $reporte)
            <tr>
                <td>{{ $reporte->id_reporte_conform }}</td>

                <td>{{ $reporte->sistema_de_gestion }}</td>

                <td>{{ $reporte->ciclo_auditoria }}</td>

                <td>{{ $reporte->fecha_auditoria }}</td>

                <td>{{ $reporte->lugar }}</td>

                <td>{{ $reporte->fecha_elaboracion }}</td>

                <td>{{ $reporte->fuente_no_conforme }}</td>

                <td>{{ $reporte->proceso_no_conforme }}</td>

                <td>{{ $reporte->nombre_reporte_proceso }}</td>

                <td>{{ $reporte->cargo_persona_reporte_proceso }}</td>

                <td>{{ $reporte->tipo_proceso_no_conforme }}</td>

                <td>{{ $reporte->descripcion_no_conformidad }}</td>

                <td>{{ $reporte->responsable_no_conformidad }}</td>

                <td>{{ $reporte->cargo_responsable_no_conformidad }}</td>

                <td>{{ $reporte->persona_equipo_trabajo }}</td>

                <td>{{ $reporte->cargo_persona_equipo_trabajo }}</td>

                <td>{{ $reporte->impacto_no_conformidad }}</td>

                <td>{{ $reporte->analisis_mano_de_obra }}</td>

                <td>{{ $reporte->analisis_maquinaria }}</td>

                <td>{{ $reporte->analisis_metodo }}</td>

                <td>{{ $reporte->analisis_materiales }}</td>

                <td>{{ $reporte->analisis_medio_ambiente }}</td>

                <td>{{ $reporte->analisis_otros_factores }}</td>

                <td>{{ $reporte->plan_accion_numero }}</td>

                <td>{{ $reporte->plan_accion_actividad }}</td>

                <td>{{ $reporte->plan_accion_responsable }}</td>

                <td>{{ $reporte->cargo_plan_accion_responsable }}</td>

                <td>{{ $reporte->plan_accion_fecha_tarea }}</td>

                <td>{{ $reporte->seguimiento_plan_fecha }}</td>

                <td>{{ $reporte->seguimiento_numero }}</td>

                <td>{{ $reporte->seguimiento_actividad_tarea }}</td>

                <td>{{ $reporte->seguimiento_compromisos }}</td>

                <td>{{ $reporte->seguimiento_responsable }}</td>

                <td>{{ $reporte->cargo_seguimiento_responsable }}</td>

                <td>{{ $reporte->verifica_implementacion_fecha }}</td>

                <td>{{ $reporte->verifica_implementacion_observa }}</td>

                <td>{{ $reporte->veri_imple_respon }}</td>

                <td>{{ $reporte->veri_imple_respon_cargo }}</td>

                <td>{{ $reporte->prog_cierre_fecha }}</td>

                <td>{{ $reporte->prog_cierre_responsable }}</td>

                <td>{{ $reporte->cargo_prog_cierre_responsable }}</td>

                <td>{{ $reporte->cierre_real_fecha }}</td>

                <td>{{ $reporte->cierre_real_responsable }}</td>

                <td>{{ $reporte->cargo_cierre_real_responsable }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
