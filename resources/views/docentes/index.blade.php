@extends('layout')

@section('content')

<h2>Docentes</h2>
<form class="disc-search" action="#" method="GET">
    <div class="search-item">
        <label for="idDisc">Disc:</label>
            <select name="disc" id="idDisc">
                @foreach ($listaDisciplinas as $disc)
                    <option value="{{$disc->id}}" {{$disciplina->id == $disc->id ? 'selected' : ''}}>
                        {{$disc->curso}} - {{$disc->nome}}
                    </option>
                @endforeach
            </select>
    </div>
    <div class="search-item">
        <button type="submit" class="bt" id="btn-filter">Filtrar</button>
    </div>
</form>
<div class="docentes-area">
    @foreach($docentes as $docente)
    <div class="docente">
        <div class="docente-imagem">
            <img src="{{$docente->user->url_foto ? asset('storage/fotos/' . $docente->user->url_foto) : asset('img/default_img.png') }}" alt="Imagem do docente">
        </div>
        <div class="docente-info-area">
        <div class="docente-name">{{$docente->user->name}}</div>
            <div class="docente-dep">{{$docente->departamentoRef->nome}}</div>
            <div class="docente-info">
                <span class="docente-label"><i class="fas fa-envelope"></i></span>
                <span class="docente-info-desc"><a href="mailto:{{$docente->user->email}}">{{$docente->user->email}}</a>
                </span>
            </div>
            <div class="docente-info">
                <span class="docente-label"><i class="fas fa-map-marker-alt"></i></span>
                <span class="docente-info-desc">{{$docente->gabinete}}</span>
            </div>
            <div class="docente-info">
                <span class="docente-label"><i class="fas fa-phone"></i></span>
                <span class="docente-info-desc">{{$docente->extensao}}</span>
            </div>
            <div class="docente-info">
                <span class="docente-label"><i class="fas fa-archive"></i></span>
                <span class="docente-info-desc">{{$docente->cacifo}}</span>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection
