@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if ($errors->any())
            <div class="d-flex justify-content-center my-3">
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm rounded-pill mb-4" role="alert" style="max-width: 600px;">
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
                    <h3 class="fw-bold my-4">{{ __('Edit Pembayaran') }}</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('pembayarans.update', $pembayaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="id_warga" class="form-label">{{ __('Nama Warga') }}</label>
                            <select name="id_warga" id="id_warga" class="form-select" required>
                                @foreach($wargas as $warga)
                                    <option value="{{ $warga->id }}" {{ $pembayaran->id_warga == $warga->id ? 'selected' : '' }}>{{ $warga->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_dibayar" class="form-label">{{ __('Jumlah Dibayar') }}</label>
                            <input type="text" class="form-control" name="jumlah_dibayar" id="jumlah_dibayar" value="{{ $pembayaran->jumlah_dibayar }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_bayar" class="form-label">{{ __('Tanggal Bayar') }}</label>
                            <input type="date" class="form-control" name="tanggal_bayar" id="tanggal_bayar" value="{{ $pembayaran->tanggal_bayar }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="metode_pembayaran" class="form-label">{{ __('Metode Pembayaran') }}</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
                                <option value="tunai" {{ $pembayaran->metode_pembayaran == 'tunai' ? 'selected' : '' }}>{{ __('Tunai') }}</option>
                                <option value="transfer" {{ $pembayaran->metode_pembayaran == 'transfer' ? 'selected' : '' }}>{{ __('Transfer') }}</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="bulan" class="form-label">{{ __('Bulan') }}</label>
                            <select name="bulan" id="bulan" class="form-select" required>
                                @foreach(range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}" {{ $pembayaran->bulan == $bulan ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $bulan, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary w-100">{{ __('Update Pembayaran') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-3 text-center">
                <a href="{{ route('pembayarans.perbulan') }}" class="btn btn-primary"><i class="bi bi-arrow-left"></i> {{ __('Batal') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
