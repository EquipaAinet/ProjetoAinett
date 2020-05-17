@extends('layout_admin')
@section('content')
<h3>{{ __('Editar Perfil') }}</h3>
    <form method="POST" action="{{route('user.update', ['user' => $user])}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name',$user->name)}}" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                 </div>
        </div>
        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email',$user->email) }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                 </div>
         </div>
         <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('NIF') }}</label>

            <div class="col-md-6">
                                <input id="NIF" type="text" class="form-control @error('NIF') is-invalid @enderror" name="NIF" value="{{ old('NIF',$user->NIF)}}">

                                @error('NIF')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>

                        <div class="col-md-6">
                                <input id="telefone" type="text" class="form-control @error('telefone') is-invalid @enderror" name="telefone" value="{{ old('telefone',$user->telefone)}}">

                                @error('telefone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="inputFoto" class="col-md-4 col-form-label text-md-right">{{ __('Foto(Optional)') }}</label>

                        <div class="col-md-6">
                                <input id="foto" type="file" class="form-control @error('Foto') is-invalid @enderror" name="foto">

                                @error('Foto')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="inputpassword" class="col-md-4 col-form-label text-md-right">{{ __('Password(Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="current-password" type="password" class="form-control" name="current_password" required>

                                @if ($errors->has('current-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('current-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputpassword" class="col-md-4 col-form-label text-md-right">{{ __('Nova Password(Optional)') }}</label>

                            <div class="col-md-6">
                                <input id="new-password" type="password" class="form-control" name="new-password" required>

                                @if ($errors->has('new-password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputpassword" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Nova Password(Optional)') }}</label>
                            <div class="col-md-6">
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                            </div>
                        </div>

                       
         

        
        <div class="form-group text-right">
                <button type="submit" class="btn btn-success" name="ok">Save</button>
                <a href="{{route('pages.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

@endsection