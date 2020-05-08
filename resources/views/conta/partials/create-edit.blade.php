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
    <input type="text" class="form-control" name="SaldoAb" id="inputSaldoAb" value="{{old('saldo_abertura', $conta->saldo_abertura)}}">
    @error('ECTS')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>

<div class="form-group">
    <label for="inputSaldoAt">Saldo Atual</label>
    <input type="text" class="form-control" name="SaldoAt" id="inputSaldoAt" value="{{old('saldo_atual', $conta->saldo_atual)}}">
    @error('ECTS')
        <div class="small text-danger">{{$message}}</div>
    @enderror
</div>
