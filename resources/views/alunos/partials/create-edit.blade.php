<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="name" id="inputNome" value="{{old('name', $aluno->user->name)}}" >
    @error('name')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input type="text" class="form-control" name="email" id="inputEmail" value="{{old('email', $aluno->user->email)}}" >
    @error('email')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div>Género</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="inputMasculino" name="genero" value="M" {{old('genero',  $aluno->user->genero) == 'M' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputMasculino"> Masculino </label>
        <input type="radio" class="form-check-input ml-4" id="inputFeminino" name="genero" value="F" {{old('genero',  $aluno->user->genero) == 'F' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputFeminino"> Feminino </label>
    </div>
    @error('genero')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputCurso">Curso</label>
    <select class="form-control" name="curso" id="inputCurso">
        @foreach ($cursos as $abr => $nome)
           <option value={{$abr}} {{$abr == old('curso', $aluno->curso) ? 'selected' : ''}}>{{$nome}}</option>
        @endforeach
    </select>
    @error('curso')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputGabinete">Numero</label>
    <input type="text" class="form-control" name="numero" id="inputNumero" value="{{old('numero', $aluno->numero)}}" >
    @error('numero')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
