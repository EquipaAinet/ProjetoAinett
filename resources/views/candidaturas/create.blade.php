@extends('layout')

@section('content')

<h2>Candidatura</h2>
<form action="{{ route('candidaturas.store') }}" id="candidatura-form" method="post" novalidate>
    @csrf
    <div id="general-info" class="area-form">
        <div class="form-left-area">
            <div class="item-form">
                <label for="idNome">Nome:</label>
            <input type="text" name="nome" id="idNome" value="{{old('nome')}}">
                @error('nome')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="item-form">
                <label for="idEmail">Email:</label>
                <input type="email" name="email" id="idEmail" value="{{old('email')}}">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div id="telefones-area">
                <div class="item-form">
                    <label for="idTel1">Telefone 1:</label>
                    <input type="text" name="telefone1" id="idTel2" class="cx-small" value="{{old('telefone1')}}">
                    @error('telefone1')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
                <div class="item-form">
                    <label for="idTel2">Telefone 2:</label>
                    <input type="text" name="telefone2" id="idTel2" class="cx-small" value="{{old('telefone2')}}">
                    @error('telefone2')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="item-form">
                <label for="generos-area">Género:</label>
                <div id="generos-area">
                    <div class="item-form">
                        <input type="radio" name="genero" id="idGenM" value="M" {{old('genero')=='M'?'checked':''}}>
                        <label for="idGenM">Masculino</label>
                    </div>
                    <div class="item-form">
                        <input type="radio" name="genero" id="idGenF" value="F" {{old('genero')=='F'?'checked':''}}>
                        <label for="idGenF">Feminino</label>
                    </div>
                </div>
                @error('genero')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-right-area">
            <div id="origem-area">
                <div class="title-items">Origem:</div>
                <div class="item-form">
                    <input type="radio" name="origem" id="idOrigemP" value="P" {{old('origem')=='P'?'checked':''}}>
                    <label for="idOrigemP">Portugal</label>
                </div>
                <div class="item-form">
                    <input type="radio" name="origem" id="idOrigemUE" value="UE" {{old('origem')=='UE'?'checked':''}}>
                    <label for="idOrigemUE">União Europeia</label>
                </div>
                <div class="item-form">
                    <input type="radio" name="origem" id="idOrigemO" value="O" {{old('origem')=='O'?'checked':''}}>
                    <label for="idOrigemO">Outra</label>
                </div>
                @error('origem')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
    <div id="cand-dados-area" class="area-form">
        <div class="form-left-area">
            <div class="item-form">
                <label for="idCurso">Curso pretendido:</label>
                <select name="curso" id="idCurso">
                    @foreach($cursos as $abr => $nome)
                        <option value="{{$abr}}" {{old('curso')==$abr?'selected':''}}>{{$nome}}</option>
                    @endforeach
                </select>
                @error('curso')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="item-form">
                <label for="idMedia">Média de entrada:</label>
                <input type="number" name="media" id="idMedia" class="cx-small" value="{{old('media')}}">
                @error('media')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="item-form m23-item">
                <input type="hidden" name="m23" value="0">
                <label for="idM23">Maior que 23:</label>
                <input type="checkbox" name="m23" id="idM23" value="1" {{old('m23')=='1'?'checked':''}}>
                @error('m23')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="item-form">
                <label for="idObs">Observações: </label>
                <textarea name="obs" id="idObs" rows="5">{{old('obs')}}</textarea>
                @error('obs')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="form-right-area">
            <div id="estatutos-area">
                <div class="title-items"> Estatutos Pretendidos:</div>
                <div class="item-form">
                    <input type="checkbox" name="estatutos[]" id="idEstatutosTE" value="TE" {{ is_array(old('estatutos')) && in_array('TE',old('estatutos')) ?'checked':''}}>
                    <label for="idEstatutosTE">Trabalhador-Estudante</label>
                </div>
                <div class="item-form">
                    <input type="checkbox" name="estatutos[]" id="idEstatutosNE" value="NE" {{ is_array(old('estatutos')) && in_array('NE',old('estatutos')) ?'checked':''}}>
                    <label for="idEstatutosNE">Necessidades Especiais</label>
                </div>
                <div class="item-form">
                    <input type="checkbox" name="estatutos[]" id="idEstatutosE" value="E" {{ is_array(old('estatutos')) && in_array('E',old('estatutos')) ?'checked':''}}>
                    <label for="idEstatutosE">Erasmus</label>
                </div>
            </div>
            @error('estatutos')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="bt-area">
        <button type="submit" class="bt">Enviar candidatura</button>
        <button type="reset" class="bt">Limpar</button>
    </div>
</form>
@endsection
