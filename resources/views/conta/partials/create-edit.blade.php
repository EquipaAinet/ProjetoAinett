<input type="hidden" class="form-control" name="user_id" id="inputUserID" value="{{Auth::user()->id}}" >

<div class="form-group">
    <label for="inputNome">Nome</label>
    <input type="text" class="form-control" name="nome" id="inputNome" value="{{old('nome', $conta->nome)}}" >
    @error('nome')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
<div class="form-group">
    <label for="inputDesc">Descricao</label>
    <input type="text" class="form-control" name="descricao" id="inputDesc" value="{{old('descricao', $conta->descricao)}}" >
    @error('descricao')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputSaldoAb">Saldo Abertura</label>
    <input type="text" class="form-control" name="saldo_abertura" id="inputSaldoAb" value="{{old('saldo_abertura', $conta->saldo_abertura)}}">
    @error('SaldoAb')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
