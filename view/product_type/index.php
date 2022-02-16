<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../../assets/img/logo.png" type="image/x-icon">
    <?php require_once("../template/linkheader.php") ?>
    <title>Admin</title>
</head>

<body>

    <?php require_once("../template/navbar.php") ?>
    <!-- content -->

    <div class="card">
        <div class="card-header bg-success text-white">
            <h3> ประเภทสินค้า </h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table " id="data">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>test</th>
                            <th>test</th>
                            <th>test</th>
                            <th>test</th>
                            <th>test</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i = 1; $i < 20; $i++) { ?>
                            <tr>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                                <td>test</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- content -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>
    <script>
        $(function() {
            $('#data').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>