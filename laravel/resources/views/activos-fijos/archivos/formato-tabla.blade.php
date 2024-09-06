<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre Completo</th>
            <th>Identificacion</th>
            <th>Empresa</th>
            <th>Descripcion</th>
            <th>Codigo Interno</th>
            <th>Activo Fijo</th>
            <th>Color</th>
            <th>Observaciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $u = 1; ?>
        @foreach ($activos as $activo)
            <tr>
                <td><?php
                print $u;
                $u++;
                ?></td>
                <td>{{ $activo->nombre }}</td>
                <td>{{ $activo->identificacion }}</td>
                <td>{{ $activo->empresa }}</td>
                <td>{{ $activo->descripcion }}</td>
                <td>{{ $activo->cod_interno }}</td>
                <td>{{ $activo->activo_fijo }}</td>
                <td>{{ $activo->color }}</td>
                <td>{{ $activo->observaciones }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
