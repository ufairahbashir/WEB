<?php
//koneksi database
$server = "localhost";
$user = "root";
$pass = "";
$database = "dbpertemuan12";

$koneksi = mysqli_connect($server, $user, $pass, $database) or die(mysqli_error($koneksi));

$nama_file = $_FILES['gambar']['name'];
$path = "images/".$nama_file;

//aktifkan tombol simpan
if (isset($_POST['bsimpan'])) {
    if ($_GET['hal'] == "edit") {
        $edit = mysqli_query($koneksi, "UPDATE tmhs set 
        nim='$_POST[tnim]',
        nama='$_POST[tnama]',
        alamat='$_POST[talamat]',
        prodi='$_POST[tprodi]'
        gambar='$_POST[tgambar]'
        WHERE id_mhs = '$_GET[id]'
        ");
        if ($edit) {
            echo "<script>
            alert('Edit data sukses!');
            document.location='index.php';
            </script>";
        } else {
            echo "<script>
            alert('Edit data gagal!');
            document.location='index.php';
            </script>";
        }
    } else {
        $simpan = mysqli_query($koneksi, "INSERT INTO tmhs (gambar, nim, nama, alamat, prodi)
        VALUES('$_POST[tgambar]','$_POST[tnim]','$_POST[tnama]','$_POST[talamat]','$_POST[tprodi]')");
        if ($simpan) {
            echo "<script>
            alert('Simpan data sukses');
            document.location='index.php';
            </script>";
        } else {
            echo "<script>
            alert('Simpan data gagal');
            document.location='index.php';
            </script>";
        }
    }
}

if (isset($_GET['hal'])) {
    if ($_GET['hal'] == "edit") {
        $tampil = mysqli_query($koneksi, "SELECT * FROM tmhs WHERE id_mhs = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            $vnim = $data['nim'];
            $vnama = $data['nama'];
            $valamat = $data['alamat'];
            $vprodi = $data['prodi'];
            $vgambar = $data['gambar'];
        }
    } else if ($_GET['hal'] == "hapus") {
        $hapus = mysqli_query($koneksi, "DELETE FROM tmhs WHERE id_mhs='$_GET[id]'");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>PERTEMUAN 12</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

    <style>
        body{
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container pt-5 pb-5">
        <div class="container bg-dark p-4 bg-opacity-50 mb-5 ">
            <h1 class="text-center display-3">PERTEMUAN 12</h1>
            <h2 class="text-center display-6"> <small class="text-muted">Pembuatan CRUD</small></h2>
        </div>
        

        <!--Awal card Form-->
        <div class="card border-info mt-3 bg-transparent">
            <div class="card-header display-6">Form Input Siswa</div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div class="container pb-3">
                            <div>
                                <label class = "p-1">NIM</label>
                                <input type="text" name="tnim" value="<?= @$vnim ?>" class="form-control bg-dark bg-opacity-50 border-0 text-white" placeholder="Input NIM Anda" required>
                            </div>

                            <div>
                                <label class = "pt-2 pb-1">Nama</label>
                                <input type="text" name="tnama" value="<?= @$vnama ?>" class="form-control bg-dark bg-opacity-50 border-0 text-white" placeholder="Input Nama Anda" required>
                            </div>

                            <div>
                                <label class = "pt-2 pb-1">Alamat</label>
                                <textarea name="talamat" class="form-control bg-dark bg-opacity-50 border-0 text-white" placeholder="Input Alamat Anda " required><?= @$valamat ?></textarea>
                            </div>

                            <div class="form-group ">
                                <label class = "pt-2 pb-1">Prodi</label>
                                <select class="form-control bg-dark border-0" style= "color:white" name="tprodi">
                                    <option value=""><?= @$vprodi ?></option>
                                    <option value="S1-MT">S1-MT</option>
                                    <option value="S1-SI">S1-SI</option>
                                    <option value="S1-AK">S1-AK</option>
                                </select>

                            </div>

                            <div class="p-3">
                                Input Foto
                                <br>
                                <form method="post" enctype="multipart/form-data" action="upload.php">
                                <input type="file" name="tgambar" value="<?= @$vgambar?>">
                            </div>

                        <div>
                            <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
                            <button type="reset" class="btn btn-danger" name="breset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--Akhir Card Form-->

        <!--Awal card Form-->
        <div class="card border-info mt-3 bg-transparent">
            <div class="card-header text-light display-6">Daftar Mahasiswa</div>
            <div class="card-body">
                <table class="table table-bordered table-striped text-light">
                    <tr>
                        <th  class="text-light text-center">No</th>
                        <th class="text-light text-center">Foto</th>
                        <th  class="text-light text-center">NIM</th>
                        <th  class="text-light text-center">NAMA</th>
                        <th  class="text-light col-3 text-center">ALAMAT</th>
                        <th  class="text-light text-center">Program Studi</th>
                        <th  class="text-light text-center">Aksi</th>
                    </tr>

                    <?php
                    $no = 1;
                    $tampil = mysqli_query($koneksi, "SELECT * from tmhs order by id_mhs desc");
                    while ($data = mysqli_fetch_array($tampil)) :
                    ?>
                        <tr >
                            <td class="text-light text-center"><?= $no++; ?></td>
                            <td><?= $data['gambar']; ?></td>
                            <td class="text-light text-center col-1"><?= $data['nim']; ?></td>
                            <td class="text-light"><?= $data['nama']; ?></td>
                            <td class="text-light"><?= $data['alamat']; ?></td>
                            <td class="text-light text-center"><?= $data['prodi']; ?></td>
                            <td class="text-center">
                                <a href="index.php?hal=edit&id=<?= $data['id_mhs'] ?>" class="btn btn-warning">Edit</a>
                                <a href="index.php?hal=hapus&id=<?= $data['id_mhs'] ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
        <!--Akhir Card Form-->


    </div>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>

</html>