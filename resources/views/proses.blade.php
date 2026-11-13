<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
        NIM: {{ $nim }} <br>
    Nama: {{ $nama }} <br>
    Gender: {{ $gender }} <br>
    Prodi: {{ $prodi }} <br>
    Pakar: 
    <ul>
        @if($pakar)
            @foreach($pakar as $p)
                <li>{{ $p }}</li>
            @endforeach
        @else
            Belum ada pakar yang dipilih.
        @endif
    </ul>
</body>
</html>