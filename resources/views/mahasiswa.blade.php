<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/proses" method="POST">
    
    <label>NIM:</label>
    <input type="number" name="nim"><br>

    <label>Nama:</label>
    <input type="text" name="nama"><br>

    <label>Gender:</label>
    <input type="radio" name="gender" value="Laki-laki"> Laki-laki
    <input type="radio" name="gender" value="Perempuan"> Perempuan<br>

    <label>Prodi:</label>
    <select name="prodi">
        <option value="Informatika">Informatika</option>
        <option value="Sistem Informasi">Sistem Informasi</option>
    </select><br>

    <label>Pakar:</label>
    <input type="checkbox" name="pakar[]" value="AI & Cloud"> AI & Cloud
    <input type="checkbox" name="pakar[]" value="Jaringan"> Jaringan
    <input type="checkbox" name="pakar[]" value="UI/UX"> UI/UX<br>

    <button type="submit">Kirim</button>
    </form>
</body>
</html>