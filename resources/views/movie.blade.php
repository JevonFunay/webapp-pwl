@extends('main.parent')
@section('title', '.:Movie:.')
@section('Article')
    <h1>MOVIE</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-info">
            <tr>
                <th>No</th>
                <th>ID Movie</th>
                <th>Judul Movie</th>
                <th>Genre</th>
                <th>Year</th>
                <th>Poster</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $movie->id_movie }}</td>
                    <td>{{ $movie->judul_movie }}</td>
                    <td>{{ $movie->genre->nama_genre }}</td>
                    <td>{{ $movie->year }}</td>
                    <td>{{ $movie->poster }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1 class="mt-4">GENRE</h1>
    <table class="table table-bordered table-striped">
        <thead class="table-info">
            <tr>
                <th>ID Genre</th>
                <th>Nama Genre</th>
                <th>Jumlah Movie</th>
                <th>Daftar Movie</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($genres as $genre)
                <tr>
                    <td>{{ $genre->id_gendre }}</td>
                    <td>{{ $genre->nama_genre }}</td>
                    <td>{{ $genre->movies->count() }}</td>
                    <td>{{ $genre->movies->pluck('judul_movie')->implode(', ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
