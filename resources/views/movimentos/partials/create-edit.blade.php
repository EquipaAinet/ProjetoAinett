<input type="hidden" class="form-control" name="conta_id" id="inputContaID" value="{{old('conta_id', $movimento->conta_id)}}" >

<div class="form-group">
    <label for="inputData">Data</label>
    <input type="date" class="form-control" name="data" id="inputData" value="{{old('data', $movimento->data)}}" >
    @error('data')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputValor">Valor</label>
    <input type="number" class="form-control" name="valor" id="inputValor" value="{{old('valor', $movimento->valor)}}" >
    @error('valor')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputTipo">Tipo (R ou D)</label>
    <input type="text" class="form-control" name="tipo" id="inputTipo" value="{{old('tipo', $movimento->tipo)}}">
    @error('tipo')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>


<div class="form-group">
<label for="inputCategoria">Categorias</label>
<select class="form-control" name="categoria_id" id="inputCategorias">
@foreach($categorias as $cat)
    <option value="{{$cat->id}}" selected="">{{$cat->id}} - {{$cat->nome}}</option>
@endforeach
</select>
@error('categoria_id')
<div class="small text-danger">{{$message}}</div>
    @enderror
</div>


<div class="form-group">
    <label for="inputDesc">Descrição</label>
    <input type="text" class="form-control" name="descricao" id="inputDesc" value="{{old('descricao', $movimento->descricao)}}">
    @error('descricao')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

