{{ csrf_field() }}

<div class="form-group">
    <label for="first_name">Nombre</label>
    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Pedro" value="{{ old('first_name', $user->first_name) }}">
</div>

<div class="form-group">
    <label for="last_name">Apellido</label>
    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Perez" value="{{ old('last_name', $user->last_name) }}">
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" id="email" name="email" placeholder="pedro@example.com" value="{{ old('email', $user->email) }}">
</div>

<div class="form-group">
    <label for="password">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Mayor a 6 caracteres">
</div>

<div class="form-group">
    <label for="bio">Bio</label>
    <textarea class="form-control" rows="5" name="bio" id="bio">{{ old('bio', $user->profile->bio) }}</textarea>
</div>

<div class="form-group">
    <label for="twitter">Twitter</label>
    <input type="text" class="form-control" id="twitter" name="twitter" placeholder="https://twitter.com/pedrop" value="{{ old('twitter', $user->profile->twitter) }}">
    @if ($errors->has('password'))
        <p class="text-danger">{{ $errors->first('twitter') }}</p>
    @endif
</div>

<div class="form-group">
    <p>Habilidades</p>

    @foreach($skills as $skill)
        <div class="form-check form-check-inline">
            <input name="skills[{{ $skill->id }}]" class="form-check-input" type="checkbox" id="skill_{{ $skill->id }}" value="{{ $skill->id }}" {{ $errors->any() ? old("skills.{$skill->id}") : $user->skills->contains($skill) ? 'checked' : '' }}>
            <label class="form-check-label" for="skill_{{ $skill->id }}">{{ $skill->name }}</label>
        </div>
    @endforeach
</div>

<div class="form-group">
    <label for="profession_id">Profesión:</label>
    <select class="form-control" name="profession_id" id="profession_id">
        <option value="">Seleciona una profesión</option>
      @foreach ($professions as $profession)
        <option {{ $profession->id == old('profession_id', $user->profile->profession_id) ? 'selected' : '' }} value="{{ $profession->id }}">{{ $profession->title }}</option>
      @endforeach
    </select>
  </div>

  <div class="form-group">
    <label>Rol</label>
    @foreach($roles as $role => $name)
        <div class="form-check">
            <label class="form-check-label">
            <input type="radio" {{ old('role', $user->role) == $role ? 'checked' : '' }} class="form-check-input" value="{{ $role }}" id="role_{{ $role }}" name="role"> {{ $name }}
            </label>
        </div>
    @endforeach
</div>