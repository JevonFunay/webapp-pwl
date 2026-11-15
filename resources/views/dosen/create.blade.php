<!doctype html>
<html lang="id">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Tambah Data Dosen</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    </head>
    <body class="bg-light">
        <main class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h1 class="h4 mb-0">Tambah Data Dosen</h1>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dosen.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="nik" class="form-label">NIK</label>
                                    <input
                                        type="text"
                                        id="nik"
                                        name="nik"
                                        class="form-control @error('nik') is-invalid @enderror"
                                        value="{{ old('nik') }}"
                                        placeholder="Masukkan NIK dosen"
                                        maxlength="7"
                                        aria-describedby="nik-help @error('nik') nik-error @enderror"
                                        @error('nik') aria-invalid="true" @enderror
                                        required
                                    >
                                    <div id="nik-help" class="form-text">Maksimal 7 karakter.</div>
                                    @error('nik')
                                        <div id="nik-error" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="namaDosen" class="form-label">Nama Dosen</label>
                                    <input
                                        type="text"
                                        id="namaDosen"
                                        name="namaDosen"
                                        class="form-control @error('namaDosen') is-invalid @enderror"
                                        value="{{ old('namaDosen') }}"
                                        placeholder="Masukkan nama dosen"
                                        maxlength="35"
                                        aria-describedby="namaDosen-help @error('namaDosen') namaDosen-error @enderror"
                                        @error('namaDosen') aria-invalid="true" @enderror
                                        required
                                    >
                                    <div id="namaDosen-help" class="form-text">Maksimal 35 karakter.</div>
                                    @error('namaDosen')
                                        <div id="namaDosen-error" class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('dosen.index') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
