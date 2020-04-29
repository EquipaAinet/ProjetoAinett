<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="name" id="inputNome" value="{{old('name', $docente->user->name)}}" >
    @error('name')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="text" class="form-control" name="email" id="inputEmail" value="{{old('email', $docente->user->email)}}" >
    @error('email')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div class="form-check form-check-inline">
        <input type="hidden" name="admin" value="0">
        <input type="checkbox" class="form-check-input" id="inputAdmin" name="admin" value="1" {{old('admin', $docente->user->admin) == '1' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputAdmin">
            Administrador
        </label>
    </div>
    @error('admin')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div>Género</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="inputMasculino" name="genero" value="M" {{old('genero',  $docente->user->genero) == 'M' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputMasculino"> Masculino </label>
        <input type="radio" class="form-check-input ml-4" id="inputFeminino" name="genero" value="F" {{old('genero',  $docente->user->genero) == 'F' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputFeminino"> Feminino </label>
    </div>
    @error('genero')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputDepartamento">Departamento</label>
    <select class="form-control" name="departamento" id="inputDepartamento">
        @foreach ($departamentos as $abr => $nome)
           <option value={{$abr}} {{$abr == old('departamento', $docente->departamento) ? 'selected' : ''}}>{{$nome}}</option>
        @endforeach
    </select>
    @error('departamento')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputGabinete">Gabinete</label>
    <input type="text" class="form-control" name="gabinete" id="inputGabinete" value="{{old('gabinete', $docente->gabinete)}}" >
    @error('gabinete')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputExtensao">Extensão</label>
    <input type="text" class="form-control" name="extensao" id="inputExtensao" value="{{old('extensao', $docente->extensao)}}" >
    @error('extensao')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputCacifo">Cacifo</label>
    <input type="text" class="form-control" name="cacifo" id="inputCacifo" value="{{old('cacifo', $docente->cacifo)}}" >
    @error('cacifo')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
