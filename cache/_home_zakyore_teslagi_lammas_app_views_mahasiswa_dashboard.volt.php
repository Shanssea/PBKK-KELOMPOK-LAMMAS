<?php

if ($this->session->isAdmin == 0) {
    // Retrieve its value
    $nama = $this->session->nama_user;

    echo "Welcome, " . $nama . "!</br>";
    echo $this->tag->linkTo(["/pengguna/logout", "Logout", 'class' => 'btn btn-warning']);
    ?>
    <div>
        <h5>Menu</h5>
        <ul>
            <li><?php echo $this->tag->linkTo("/mahasiswa/reservasipcpage", "Reservasi PC"); ?>
            <li><?php echo $this->tag->linkTo("/mahasiswa/logout", "Mengatur reservasi PC"); ?>
        </ul>
        <ul>
            <li><?php echo $this->tag->linkTo("/mahasiswa/jadwalpemakaianruangan", "Melihat jadwal pemakaian lab"); ?>
        </ul>
    </div>

<?php    
}
else {
    echo "You must login to see this page";
    header("refresh:2;url=/pengguna/loginpage");
}