<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-B/GM4XqrwHnWXNOWMbloTmrYXZg10cakYGmpfsR/bbzQ6JAJI4ihuyADKLnBgrCe" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/3.1.5/css/dataTables.dataTables.min.css">
  </head>
  <body>        
    <div class="container-fluid">
        <h1>Data Dosen</h1>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
            
        @endif
        <div class="card">
            <div class="header"><a href="{{ route('dosen.create') }}" class="btn-solid theme-primary">Tambah Data</a>
            </div>
            <div class="body">
                <table id="example" class="display">
		<thead>
			<tr>
				<th>NIK</th>
				<th>Nama Dosen</th>
				<th>Aksi</th>

			</tr>
		</thead>
		<tbody>
			@foreach ($data as $dosen)
				<tr>
					<td>{{ $dosen->nik }}</td>
					<td>{{ $dosen->namaDosen }}</td>
                    <td>
                        <a href="{{ route('dosen.edit', $dosen->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('dosen.destroy', $dosen->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                        </form>
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>    
            </div>
        </div>
    </div>

    <script type="module" src="https://cdn.jsdelivr.net/npm/bootstrap@6.0.0-alpha.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-1a/pXj49ZQ1aHEmrJ+gMw1otqoVsYwlEnlD8mIfY2TV03r20Y0CN7uqx1tQogjPL" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/3.1.5/js/dataTables.min.js" crossorigin="anonymous"></script>
    <script> 
        new DataTable('#example');
    </script>
    
  </body>
</html>