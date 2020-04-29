<table>
    <tr>
        <th>Abr.</th>
        <th>Nome</th>
        <th>ECTS</th>
        <th>Horas</th>
        <th></th>
    </tr>
    @foreach ($disciplinas as $disc)
        <tr>
            <td>{{$disc->abreviatura}}</td>
            <td>{{$disc->nome}}</td>
            <td>{{$disc->ECTS}}</td>
            <td>{{$disc->horas}}</td>
            <td class="add-disc">
                <form action="#" method="GET">
                    <button type="submit">
                        <i class="fas fa-plus-square"></i>
                    </button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
