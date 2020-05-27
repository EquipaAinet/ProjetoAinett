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
  <select id="inputTipo" name="tipo" onchange="alterarTipo()">
    <option value="0">Selecione o tipo de movimento</option>
    <option value="R">Receita</option>
    <option value="D">Despesa</option>
  </select>
  @error('tipo')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>


<div class="form-group" id="categoria_tipoR" style="visibility:hidden;">
<label for="inputCategoria">Categorias</label>
<select class="form-control" name="categoria_id" id="inputCategorias">
@foreach($categoria_tipoR as $catR)
    <option value="{{$catR->id}}" selected="">{{$catR->nome}}</option>
@endforeach
</select>
</div>

<div class="form-group" id="categoria_tipoD" style="visibility:hidden;">
<label for="inputCategoria">Categorias</label>
<select class="form-control" name="categoria_id" id="inputCategorias">
@foreach($categoria_tipoD as $catD)
    <option value="{{$catD->id}}" selected="">{{$catD->nome}}</option>
@endforeach
</div>

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

@push('scripts')
    <script>

    function alterarTipo()
    {
        let select_cat = document.getElementById('selectCategoriasDespesas')
        let select_tipo = document.getElementById('inputTipo')
        let tipo_selecionado = select_tipo.options[select_tipo.selectedIndex].value
        alert(tipo_selecionado)
        if(tipo_selecionado == 'R')
        {
            document.getElementById('categoria_tipoR').style.visibility = 'visible';
            document.getElementById('categoria_tipoD').style.visibility = 'hidden';
        }
        else
        {
            document.getElementById('categoria_tipoR').style.visibility = 'hidden';
            document.getElementById('categoria_tipoD').style.visibility = 'visible';
        }
        select_cat.style.display = 'none'
        select_cat.style.display = 'block'

    }

    //alterarTipo()
    </script> 
@endpush

