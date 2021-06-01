@extends('layout.main')

@section('title', 'Nilai UAS')



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col md-4">
                        <h1 class="text-bold text-center">Masukkan Nilai Ujian Akhirh Semester</h1>
                        <div class="card card-success card-outline mt-4">
                            <div class="card-body">
                                <form class="col" method="POST" action="/datanilaisiswa/ujianakhirsemester">
                                    @csrf
                                    <table class="table mt-3 table-sm table-responsive-sm text-center">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col" class="col-sm-auto">NO</th>
                                                <th scope="col" class="col-sm-5">NAMA</th>
                                                <th scope="col" class="col-sm-3">MATA PELAJARAN</th>
                                                <th scope="col" class="col-sm-2">UAS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($siswa as $item)
                                                <tr class="text-sm-center">
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>
                                                        <input class="form-control text-sm-center" type="text" name="nis"
                                                            readonly value={{ $item->nis }}>
                                                    </td>
                                                    @foreach ($mapel as $item)
                                                        <td>
                                                            <input class="form-control text-sm-center" type="text"
                                                                name="kodemapel" readonly value={{ $item->kodemapel }}>
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <input class="form-control-range text-sm-center" type="text"
                                                            name="uas">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="submit" class="btn btn-primary mt-4">SIMPAN</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
    </div>
    <!-- /.content-wrapper -->

@endsection
