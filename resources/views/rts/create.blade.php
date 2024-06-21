@extends('layouts.app')

@section('content')
<div class="container position-relative">
    <div class="row justify-content-center">
        <div class="col-md-8">
                @if ($errors->any())
                <div class="d-flex justify-content-center my-3">
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm rounded-pill mb-5" role="alert" style="max-width: 600px;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div>
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        var alert = document.querySelector('.alert');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                            setTimeout(function() {
                                alert.remove();
                            }, 500);
                        }
                    }, 5000);
                </script>
                @endif
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Buat RT Baru') }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('rts.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_rt" class="form-label">{{ __('RT') }}</label>
                            <input type="text" id="nama_rt" name="nama_rt" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">{{ __('Alamat') }}</label>
                            <input type="text" id="alamat" name="alamat" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="ketua_rt" class="form-label">{{ __('Ketua RT') }}</label>
                            <input type="text" id="ketua_rt" name="ketua_rt" class="form-control" required>
                        </div>

                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('rts.index') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
