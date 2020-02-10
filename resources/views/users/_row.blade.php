<tr>
    <td>{{ $user->id }}</td>
    <td>
        <h5>{{ $user->name }} @if ($user->isAdmin()) (Admin) @endif</h5>
        <p class="text-muted small">{{ $user->profile->profession->title }}</p>
    </td>
    <td class="text-muted">
        <p>{{ $user->email }}</p>
        <p class="small">{{ $user->skills->implode('name', ', ') ?: 'Sin habilidades' }}</p>
    </td>
    <td class="text-muted">{{ $user->created_at }}</td>
    <td>
        @if ($user->trashed())
            <div class="buttons">
                <form class="" action="{{ route('users.restore', $user) }}" method="POST">
                    @csrf
                    <button class="btn btn-success" type="submit"><i class="fas fa-trash-restore"></i></button>
                </form>
                <form class="" action="{{ route('users.destroy', $user) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit"><i class="fas fa-times-circle"></i></button>
                </form>
            </div>
        @else
            <form class="" action="{{ route('users.trash', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <a class="btn btn-primary" href="{{ route('users.show', ['user' => $user]) }}"><i class="fas fa-eye"></i></a>
                <a class="btn btn-primary" href="{{ route('users.edit', ['user' => $user]) }}"><i class="fas fa-edit"></i></a>
                <button class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
            </form>
        @endif
    </td>
</tr>