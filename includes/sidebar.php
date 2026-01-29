<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link <?= ($page == "dashboard") ? 'active' : ''; ?>" href="/">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <div class="sb-sidenav-menu-heading">Manajemen</div>

                <!-- DATA SEPATU -->
                <a class="nav-link <?= in_array($page, ['daftar-sepatu','tambah-sepatu','ubah-sepatu']) ? 'active' : 'collapsed'; ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseSepatu">
                    <div class="sb-nav-link-icon"><i class="fas fa-shoe-prints"></i></div>
                    Data Sepatu
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= in_array($page, ['daftar-sepatu','tambah-sepatu','ubah-sepatu']) ? 'show' : ''; ?>" id="collapseSepatu">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= ($page == "daftar-sepatu") ? 'active' : ''; ?>" href="index.php?hal=daftar-sepatu">Daftar Sepatu</a>
                        <a class="nav-link <?= ($page == "tambah-sepatu") ? 'active' : ''; ?>" href="index.php?hal=tambah-sepatu">Tambah Sepatu</a>
                    </nav>
                </div>

                <!-- KATEGORI -->
                <a class="nav-link <?= in_array($page, ['daftar-kategori','tambah-kategori','ubah-kategori']) ? 'active' : 'collapsed'; ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseKategori">
                    <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                    Kategori
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= in_array($page, ['daftar-kategori','tambah-kategori','ubah-kategori']) ? 'show' : ''; ?>" id="collapseKategori">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= ($page == "daftar-kategori") ? 'active' : ''; ?>" href="index.php?hal=daftar-kategori">Daftar Kategori</a>
                        <a class="nav-link <?= ($page == "tambah-kategori") ? 'active' : ''; ?>" href="index.php?hal=tambah-kategori">Tambah Kategori</a>
                    </nav>
                </div>

                <!-- USER -->
                <a class="nav-link <?= in_array($page, ['daftar-user','tambah-user','ubah-user','reset-password']) ? 'active' : 'collapsed'; ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseUser">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Daftar User
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= in_array($page, ['daftar-user','tambah-user','ubah-user','reset-password']) ? 'show' : ''; ?>" id="collapseUser">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= ($page == "daftar-user") ? 'active' : ''; ?>" href="index.php?hal=daftar-user">Daftar User</a>
                        <a class="nav-link <?= ($page == "tambah-user") ? 'active' : ''; ?>" href="index.php?hal=tambah-user">Tambah User</a>
                    </nav>
                </div>

                <div class="sb-sidenav-menu-heading">Transaksi</div>

                <!-- TRANSAKSI -->
                <a class="nav-link <?= in_array($page, ['daftar-transaksi','tambah-transaksi','ubah-transaksi']) ? 'active' : 'collapsed'; ?>"
                   href="#" data-bs-toggle="collapse" data-bs-target="#collapseTransaksi">
                    <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
                    Transaksi
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse <?= in_array($page, ['daftar-transaksi','tambah-transaksi','ubah-transaksi']) ? 'show' : ''; ?>" id="collapseTransaksi">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link <?= ($page == "daftar-transaksi") ? 'active' : ''; ?>" href="index.php?hal=daftar-transaksi">Daftar Transaksi</a>
                        <a class="nav-link <?= ($page == "tambah-transaksi") ? 'active' : ''; ?>" href="index.php?hal=tambah-transaksi">Tambah Transaksi</a>
                    </nav>
                </div>

                <a class="nav-link" href="logout.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-sign-out-alt"></i></div>
                    Logout
                </a>

            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <?= $_SESSION['nama_lengkap']; ?>
        </div>
    </nav>
</div>
