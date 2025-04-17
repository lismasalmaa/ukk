@extends('template.layout')

@section('container')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 d-flex align-items-center">
                            <li class="breadcrumb-item"><a href="index.html" class="link"><i
                                        class="mdi mdi-home-outline fs-4"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">User</li>
                        </ol>
                    </nav>
                    <h1 class="mb-0 fw-bold">User</h1>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.user.update', $users->id) }}" method="POST"
                                enctype="multipart/form-data" class="form-horizontal form-material mx-2">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">Email</label>
                                            <div class="col-md-12">
                                                <input type="email" id="email" name="email"
                                                    value="{{ $users->email }}" required
                                                    class="form-control form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Role</label>
                                            <div class="col-md-12">
                                                <select name="role" class="form-control form-control-line">
                                                    <option value="admin" {{ $users->role == 'admin' ? 'selected' : '' }}>
                                                        Admin</option>
                                                    <option value="employee"
                                                        {{ $users->role == 'employee' ? 'selected' : '' }}>Employee</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-12">
                                        <div class="form-group">
                                            <label class="col-md-12">Nama</label>
                                            <div class="col-md-12">
                                                <input type="text" name="name" value="{{ $users->name }}" required
                                                    class="form-control form-control-line">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Password</label>
                                            <div class="col-md-12">
                                                <input type="text" name="password"
                                                    class="form-control form-control-line">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-end">
                                        <div class="col-sm-12">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
