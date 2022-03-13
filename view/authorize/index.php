<?php
require_once("../../server/connect.php");
checkModule(@$_SESSION["user_no"], basename(dirname(__FILE__)), $conn);
try {
    $slqSelect = "SELECT
        u.id,
        t.title_name,
        u.user_name,
        u.user_last,
        u.user_login,
        GROUP_CONCAT(z.module_no) AS module
        FROM 
        users as u
        LEFT JOIN authorize as z
        ON z.user_no = u.id
        INNER JOIN title_name as t
        ON u.user_title = t.id
        GROUP BY u.id
        ";
    $querySelect = $conn->prepare($slqSelect);
    $querySelect->execute();
    $row = $querySelect->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Dashboard</title>
    <?php require_once("../template/linkheader.php") ?>
</head>

<body>
    <?php require_once("../template/navbar.php") ?>
    <!-- เนื้อหา -->
    <div class="">
        <div class="card">
            <div class="card-header">
                <h1>List Authorize</h1>
                <a href="./form.php" class="btn btn-success my-3">Add</a>
            </div>
            <div class="card-body">
                <table id="table" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>user_name</th>
                            <th>user_login</th>
                            <th>module_no</th>
                            <th>edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($row as $item) :  ?>
                            <tr>
                                <td> <?php echo $item["title_name"] . $item["user_name"] . " " . $item["user_last"]  ?> </td>
                                <td> <?php echo $item["user_login"] ?> </td>
                                <td> <?php echo $item["module"] ?> </td>
                                <td>
                                    <?php if ($item["module"] != "") { ?>
                                        <a href="./edit.php?id=<?php echo $item["id"] ?>" class="btn btn-warning">Edit</a>
                                    <?php   }  ?>

                                </td>

                            </tr>
                        <?php endforeach  ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- เนื้อหา -->
    <?php require_once("../template/footer.php") ?>
    <?php require_once("../template/linkfooter.php") ?>
    <script>
        $(function() {
            $('#table').DataTable({
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