<table>
    <thead>
        <tr>
            <th>Tratamiento</th>
            <th>Fecha diligenciamiento</th>
            <th>Planta</th>
            <th>Proceso Relacionado</th>
            <th>No conformidad</th>
            <th>Descripcion</th>
            <th>Detectado por</th>
            <th>Cargo</th>
            <th>Fecha del evento</th>
            <th>Responsable de dar tratamiento</th>
            <th>Cargo</th>
            <th>Fecha estimada del tratamiento</th>
            <th>Tratamiento al producto o servicio no conforme</th>
            <th>Descripcion del tratamiento dado</th>
            <th>Responsable tratamiento</th>
            <th>Cargo</th>
            <th>Caracterizacion de la no conformidad</th>
            <th>Fecha de seguimiento y cierre</th>
            <th>Seguimiento realizado por</th>
            <th>Cargo</th>
            <th>Tratamiento eficaz</th>
            <th>Conclusion final</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($tratamientos as $tratamiento)
            <tr>
                <td>{{ $tratamiento->id_tratamiento }}</td>
                <td>{{ $tratamiento->fecha_diligencia_trata }}</td>
                <td>{{ $tratamiento->lugar_trata }}</td>
                <td>{{ $tratamiento->proceso_rela_trata }}</td>
                <td>{{ $tratamiento->inconfor_trata }}</td>
                <td>{{ $tratamiento->descripcion_trata }}</td>
                <td>{{ $tratamiento->detectado_persona }}</td>
                <td>{{ $tratamiento->cargo_detectado }}</td>
                <td>{{ $tratamiento->fecha_evento_trata }}</td>
                <td>{{ $tratamiento->responsable_trata }}</td>
                <td>{{ $tratamiento->cargo_responsable_trata }}</td>
                <td>{{ $tratamiento->fecha_esti_trata }}</td>
                <td>{{ $tratamiento->tratamiento }}</td>
                <td>{{ $tratamiento->descripcion_inme_trata }}</td>
                <td>{{ $tratamiento->persona_trata_inme }}</td>
                <td>{{ $tratamiento->cargo_persona_trata_inme }}</td>
                <td>{{ $tratamiento->caracte_no_conformidad }}</td>
                <td>{{ $tratamiento->fecha_veri_cierre }}</td>
                <td>{{ $tratamiento->veri_cierre_responsable }}</td>
                <td>{{ $tratamiento->cargo_veri_cierre_responsable }}</td>
                <td>{{ $tratamiento->eficaz_tratamiento }}</td>
                <td>{{ $tratamiento->conclusion_final }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
