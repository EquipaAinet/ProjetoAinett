@extends('layout_admin')
@section('title','Perfil de Utilizador' )
@section('content')

    @if($user->foto==null)
        <img class="img-profile rounded-circle" src="/img/default_img.png" width="250px" height="250px" >
    @else
        <img class="img-profile rounded-circle" src="{{asset('storage/fotos/'.$user->foto)}}" width="250px" height="250px" >
    @endif

    <h2>{{$user->id}}</h2>
    <h2>{{$user->name}}</h2>
    <h2>{{$user->email}}</h2>

    @if(Auth::user()->adm==1 && $user->id!=Auth::user()->id)
        <a href="#" class="btn btn-success" role="button" aria-pressed="true" data-toggle="modal" data-target="#alterarModal" >Alterar</a>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary">Voltar</a>

    <!-- Logout Modal-->
    <div class="modal fade" id="alterarModal" tabindex="-1" role="dialog" aria-labelledby="Alterar tipo de utilizador" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar tipo de utilizador?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{route('utilizadores.view.update.type', ['id' => $user->id]) }}" method="POST" class="form-group">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <span>Selecione as opções:</span>
                        <br />
                        <div class="form-check form-check-inline">
                            <input type="hidden" name="adm" value="0">
                            <input type="checkbox" class="form-check-input" id="inputADM" name="adm" value="1" {{old('adm', $user->adm ?? '')=='1'?'checked':''}}>
                            <label class="form-check-label" for="inputADM">
                                Utilizador ADM
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="hidden" name="bloqueado" value="0">
                            <input type="checkbox" class="form-check-input" id="inputBloqueado" name="bloqueado" value="1" {{old('bloqueado', $user->bloqueado ?? '')=='1'?'checked':''}}>
                            <label class="form-check-label" for="inputBloqueado">
                                Bloquear utilizador
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success"  value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
