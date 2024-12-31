<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Financial Dashboard</title>
  <!-- Import MaterializeCSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <!-- Import Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    body {
      background-color: #e3f2fd;
      padding-bottom: 70px; /* Tambahkan padding agar konten tidak tertutup navbar */
    }
    .header {
      background-color: #1976d2;
      color: white;
      padding: 20px;
      text-align: center;
    }
    .balance-card {
      background-color: #1e88e5;
      color: white;
      padding: 20px;
      border-radius: 8px;
      margin-top: 20px;
      text-align: center;
    }
    .menu-item {
      text-align: center;
      padding: 10px;
    }
    .menu-item i {
      font-size: 2rem;
      color: #1e88e5;
    }
    .menu-label {
      color: #1e88e5;
      font-size: 0.9rem;
    }
    .feature-item {
      text-align: center;
      color: #1e88e5;
      padding: 10px;
    }
    .bottom-nav {
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      z-index: 1000;
      background-color: white;
      border-top: 1px solid #e0e0e0;
    }
    .bottom-nav ul {
      margin: 0;
    }
    .bottom-nav li a {
      color: #fff;
    }
    .bottom-nav li a.active, .bottom-nav li a.active i {
      color: #1e88e5; /* Ubah warna ikon dan teks pada item aktif */
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="navbar-fixed">
    <nav>
      <div class="nav-wrapper">
        <a href="#!" class="brand-logo" style="font-size:20px">Asyahadah Store</a>
        <ul class="right hide-on-med-and-down">
          <li><a href="sass.html">Sass</a></li>
          <li><a href="badges.html">Components</a></li>
        </ul>
      </div>
    </nav>
  </div>

  <!-- Balance Section -->
  <div class="container">
    <div class="balance-card z-depth-2">
      <h6>Saldo Dompet</h6>
      <h4>Rp 611.312,00</h4>
      <h6>Saldo Pendapatan</h6>
      <h5>Rp. 10.611.312,00</h5>
    </div>

    <!-- Quick Access Menu -->
    <div class="row">
      <div class="col s3 menu-item">
        <i class="material-icons">compare_arrows</i>
        <p class="menu-label">Transfer</p>
      </div>
      <div class="col s3 menu-item">
        <i class="material-icons">account_balance_wallet</i>
        <p class="menu-label">BRIVA</p>
      </div>
      <div class="col s3 menu-item">
        <i class="material-icons">credit_card</i>
        <p class="menu-label">E Wallet</p>
      </div>
      <div class="col s3 menu-item">
        <i class="material-icons">phone_android</i>
        <p class="menu-label">Pulsa/Data</p>
      </div>
    </div>

    <!-- Search Feature -->
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">search</i>
        <input type="text" id="search-feature">
        <label for="search-feature">Cari Fitur</label>
      </div>
    </div>

    <!-- Feature Section -->
    <div class="row">
      <div class="col s3 feature-item">
        <i class="material-icons">add</i>
        <p>Top Up</p>
      </div>
      <div class="col s3 feature-item">
        <i class="material-icons">receipt</i>
        <p>Tagihan</p>
      </div>
      <div class="col s3 feature-item">
        <i class="material-icons">local_atm</i>
        <p>Setor & Tarik Tunai</p>
      </div>
      <div class="col s3 feature-item">
        <i class="material-icons">shopping_bag</i>
        <p>Lifestyle</p>
      </div>
    </div>
  </div>

  <!-- Bottom Navigation -->
  <div class="bottom-nav">
    <nav>
      <div class="nav-wrapper">
        <ul class="center-align row">
          <li class="col s4"><a href="#home" class='active'><i class="material-icons">home</i></a></li>
          <li class="col s4"><a href="#aktivitas"><i class="material-icons">shopping_bag</i></a></li>
          <li class="col s4"><a href="#akun"><i class="material-icons">person</i></a></li>
        </ul>
      </div>
    </nav>
  </div>

  <!-- Import Materialize JavaScript -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    $(document).ready(function(){
        $('.sidenav').sidenav();
    });
  </script>
</body>
</html>
