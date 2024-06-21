<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $dashboard->title ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- <link rel="stylesheet" href="assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="http://localhost:8080/template/plugins/datatables/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost:8080/template/plugins/datatables/bootstrap5/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="http://localhost:8080/template/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="http://localhost:8080/template/plugins/select2/css/select2-bootstrap4.min.css">

    <link rel="stylesheet" href="http://localhost:8080/template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="http://localhost:8080/template/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="http://localhost:8080/template/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="http://localhost:8080/template/assets/css/template.css">

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="dashboard" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Documentation</a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="dashboard" class="brand-link">
                <img src="http://localhost:8080/template/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>

            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="http://localhost:8080/template/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Carollous Dachi</a>
                    </div>
                </div>

                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-header">DATA MASTER</li>
                        <li class="nav-item">
                            <a href="<?= base_url() . 'user' ?>" class="nav-link">
                                <i class="nav-icon fas fa-user"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() . 'role' ?>" class="nav-link">
                                <i class="nav-icon fas fa-lock"></i>
                                <p>Role</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Data <?= $path ?></h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="<?= base_url() . 'dashboard' ?>">Home</a></li>
                                <li class="breadcrumb-item active"><?= $path ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>