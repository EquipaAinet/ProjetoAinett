<div class="form-group">
    <label for="inputAbr">Abreviatura</label>
    <input type="text" class="form-control" name="abreviatura" id="inputAbr" value="{{old('abreviatura', $disciplina->abreviatura)}}" >
    @error('abreviatura')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="nome" id="inputNome" value="{{old('nome', $disciplina->nome)}}" >
    @error('nome')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputCurso">Curso</label>
    <select class="form-control" name="curso" id="inputCurso">
        @foreach ($cursos as $abr => $nome)
           <option value={{$abr}} {{$abr == old('curso', $disciplina->curso) ? 'selected' : ''}}>{{$nome}}</option>
        @endforeach
    </select>
    @error('curso')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div>Ano</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="inputAno1" name="ano" value="1" {{old('ano', $disciplina->ano) == '1' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputAno1"> 1 </label>
        <input type="radio" class="form-check-input ml-4" id="inputAno2" name="ano" value="2" {{old('ano', $disciplina->ano) == '2' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputAno2"> 2 </label>
        <input type="radio" class="form-check-input ml-4" id="inputAno3" name="ano" value="3" {{old('ano', $disciplina->ano) == '3' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputAno3"> 3 </label>
    </div>
    @error('ano')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div>Semestre</div>
    <div class="form-check form-check-inline">
        <input type="radio" class="form-check-input" id="inputSemestre1" name="semestre" value="1" {{old('semestre', $disciplina->semestre) == '1' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputSemestre1"> 1 </label>

        <input type="radio" class="form-check-input ml-4" id="inputSemestre2" name="semestre" value="2" {{old('semestre', $disciplina->semestre) == '2' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputSemestre2"> 2 </label>

        <input type="radio" class="form-check-input ml-4" id="inputSemestre0" name="semestre" value="0" {{old('semestre') == '0' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputSemestre0"> Anual </label>
    </div>
    @error('semestre')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputECTS">ECTS</label>
    <input type="text" class="form-control" name="ECTS" id="inputECTS" value="{{old('ECTS', $disciplina->ECTS)}}">
    @error('ECTS')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputHoras">Horas</label>
    <input type="text" class="form-control" name="horas" id="inputHoras" value="{{old('horas', $disciplina->horas)}}">
    @error('horas')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <div class="form-check form-check-inline">
        <input type="hidden" name="opcional" value="0">
        <input type="checkbox" class="form-check-input" id="inputOpcional" name="opcional" value="1" {{old('opcional', $disciplina->opcional) == '1' ? 'checked' : ''}}>
        <label class="form-check-label" for="inputOpcional">
            Opcional
        </label>
    </div>
    @error('opcional')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
