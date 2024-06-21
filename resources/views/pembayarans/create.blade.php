@extends('layouts.app')

@section('content')
<div class="container">
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
            <div class="d-flex justify-content-center align-items-center mb-3">
                @if (Auth::user()->role == 'admin')
                    <a href="{{ route('dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="btn btn-primary"><i class="bi bi-house-door"></i> Kembali ke Dashboard</a>
                @endif
            </div>
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-header bg-primary text-white text-center">
                    <h3 class="fw-bold my-4">{{ __('Pembayaran') }}</h3>
                </div>

                <div class="card-body">

                    <form action="{{ route('pembayarans.store') }}" method="POST">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="id_warga">Pilih Warga</label>
                            <select class="form-control" id="id_warga" name="id_warga" required>
                                <option value="">Pilih Warga</option>
                                @foreach($wargasWithTagihan as $warga)
                                    <option value="{{ $warga->id }}">{{ $warga->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_bayar" class="form-label">Jumlah Pembayaran:</label>
                            <input type="number" class="form-control" id="jumlah_bayar" name="jumlah_dibayar" step="0.01" required>
                        </div>

                        <div class="mb-3">
                            <label for="bulan" class="form-label">Pembayaran untuk Bulan:</label>
                            <select class="form-control" id="bulan" name="bulan" required>
                                @foreach(range(1, 12) as $month)
                                    <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_bayar" class="form-label">Tanggal Pembayaran:</label>
                            <input type="date" class="form-control" id="tanggal_bayar" name="tanggal_bayar" required>
                        </div>

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran:</label>
                            <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                        
                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
