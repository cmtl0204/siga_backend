<h1 style="color: red">Usuarios:</h1>
<table>
    <tr>
        <th>Cédula</th>
        <th>Correo</th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>
                {{ $user->identification }}
            </td>
            <td>
                {{ $user->email }}
            </td>
        </tr>
    @endforeach
</table>

