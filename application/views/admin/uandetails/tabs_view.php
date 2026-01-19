<!DOCTYPE html>
<html>
<head>
    <title>Tabbed Interface with Bootstrap</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="table1-tab" data-toggle="tab" href="#table1" role="tab" aria-controls="table1" aria-selected="true">Table 1</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="table2-tab" data-toggle="tab" href="#table2" role="tab" aria-controls="table2" aria-selected="false">Table 2</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="table3-tab" data-toggle="tab" href="#table3" role="tab" aria-controls="table3" aria-selected="false">Table 3</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="table1" role="tabpanel" aria-labelledby="table1-tab">
            <h2 class="mt-3">Table 1</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($table1 as $row): ?>
                    <tr>
                    <td><?php echo $row['comp_id']; ?></td>
                    <td><?php echo $row['company_name']; ?></td>
                    <td><?php echo $row['company_code']; ?></td>                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="table2" role="tabpanel" aria-labelledby="table2-tab">
            <h2 class="mt-3">Table 2</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($table2 as $row): ?>
                    <tr>
                    <td><?php echo $row['state_id']; ?></td>
                    <td><?php echo $row['state_name']; ?></td>
                    <td><?php echo $row['state_code']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="table3" role="tabpanel" aria-labelledby="table3-tab">
            <h2 class="mt-3">Table 3</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($table3 as $row): ?>
                    <tr>
                    <td><?php echo $row['status_id']; ?></td>
                    <td><?php echo $row['status_name']; ?></td>
                    <td><?php echo $row['store']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
