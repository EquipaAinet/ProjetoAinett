@extends('layout')

@section('content')

<h2>Disciplinas</h2>
                    <form class="disc-search" action="#" method="GET">
                        <div class="search-item">
                            <label for="idCurso">Curso:</label>
                            <select name="curso" id="idCurso">
                                @foreach($cursos as $abr => $nome)
                                    <option value="{{$abr}}" {{$abr == $curso ? 'selected' : ''}}>{{$nome}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search-item">
                            <label for="idAno">Ano:</label>
                            <div id="anos-group">
                                <input type="radio" name="ano" id="idA1" value="1" {{$ano == 1 ? 'checked' : ''}}>
                                <label for="idA1">1</label>
                                <input type="radio" name="ano" id="idA2" value="2" {{$ano == 2 ? 'checked' : ''}}>
                                <label for="idA2">2</label>
                                <input type="radio" name="ano" id="idA3" value="3" {{$ano == 3 ? 'checked' : ''}}>
                                <label for="idA3">3</label>
                            </div>
                        </div>
                        <div class="search-item">
                            <button type="submit" class="bt" id="btn-filter">Filtrar</button>
                        </div>
                    </form>
                    <div class="semestres-area">
                        <div class="semestre">
                            <h3>Semestre: 1</h3>
                            @include('partials.disc_semestre', ['disciplinas' => $discSem1])
                        </div>
                        <div class="semestre">
                            <h3>Semestre: 2</h3>
                            @include('partials.disc_semestre', ['disciplinas' => $discSem2])
                        </div>
                    </div>
@endsection
