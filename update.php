<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$namaBarang = $ketBarang = $namaPeminjam = $nimPeminjam = $tanggalPeminjaman = $tanggalPengembalian = "";

// Processing form data when form is submitted
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];


    $namaBarang = trim($_POST["namaBarang"]);
    $ketBarang = trim($_POST["ketBarang"]);
    $namaPeminjam = trim($_POST["namaPeminjam"]);
    $nimPeminjam = trim($_POST["nimPeminjam"]);
    $tanggalPeminjaman = trim($_POST["tanggalPeminjaman"]);
    $tanggalPengembalian = trim($_POST["tanggalPengembalian"]);


    // Prepare an update statement
    $sql = "UPDATE permohonan SET namaBarang=?, ketBarang=?, namaPeminjam=?, nimPeminjam=?, tanggalPeminjaman=?, tanggalPengembalian=? WHERE id=?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssssssi", $param_namaBarang, $param_ketBarang, $param_namaPeminjam, $param_nimPeminjam, $param_tanggalPeminjaman, $param_tanggalPengembalian, $param_id);

        // Set parameters
        $param_namaBarang = $namaBarang;
        $param_ketBarang = $ketBarang;
        $param_namaPeminjam = $namaPeminjam;
        $param_nimPeminjam = $nimPeminjam;
        $param_tanggalPeminjaman = $tanggalPeminjaman;
        $param_tanggalPengembalian = $tanggalPengembalian;
        $param_id = $id;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Records updated successfully. Redirect to landing page
            header("location: index.php");
            exit();
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);


    // Close connection
    mysqli_close($link);
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id = trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM permohonan WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $namaBarang = $row["namaBarang"];
                    $ketBarang = $row["ketBarang"];
                    $namaPeminjam = $row["namaPeminjam"];
                    $nimPeminjam = $row["nimPeminjam"];
                    $tanggalPeminjaman = $row["tanggalPeminjaman"];
                    $tanggalPengembalian = $row["tanggalPengembalian"];

                } else {
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($link);
    } else {
        header("location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="namaBarang" class="form-control"
                                value="<?php echo $namaBarang; ?>">
                        </div>
                        <div class="form-group">
                            <label>Keterangan Barang</label>
                            <input type="text" name="ketBarang" class="form-control" value="<?php echo $ketBarang; ?>">
                            </input>
                        </div>
                        <div class="form-group">
                            <label>Nama Peminjam</label>
                            <input type="text" name="namaPeminjam" class="form-control"
                                value="<?php echo $namaPeminjam; ?>">
                            </input>
                        </div>
                        <div class="form-group">
                            <label>NIM Peminjam</label>
                            <input type="text" name="nimPeminjam" class="form-control"
                                value="<?php echo $nimPeminjam; ?>">
                            </input>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Peminjaman</label>
                            <input type="date" name="tanggalPeminjaman" class="form-control"
                                value="<?php echo $tanggalPeminjaman; ?>">
                            </input>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pengembalian</label>
                            <input type="date" name="tanggalPengembalian" class="form-control"
                                value="<?php echo $tanggalPengembalian; ?>">
                            </input>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>" />
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>