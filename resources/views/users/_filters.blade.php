<form method="get" action="{{ url('usuarios') }}" class="mt-3">
    <div class="row rpw-filters">
        <div class="col-12">
            @foreach(['' => 'Todos', 'with_team' => 'Con equipo', 'without_team' => 'Sin equipo'] as $value => $text)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="team" id="team_{{ $value ?: 'all' }}'" value="{{ $value }}" {{ $value === request('team', '') ? 'checked' :  ''}}>
                    <label class="form-check-label" for="{{ $value ?: 'all' }}">{{ $text }}</label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row row-filters">
        <div class="col-md-6">
            <div class="form-inline form-search">
                <div class="input-group">
                    <input type="search" name="search" value="{{ request('search') }}" class="form-control form-control-sm" placeholder="Buscar...">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>