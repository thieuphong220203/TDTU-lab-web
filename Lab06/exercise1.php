<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            text-transform: uppercase;
            
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <th colspan="10"><b> Bảng Cửu Chương</b></th>
        </tr>
        <?php
        // Generating table rows
        for ($i = 1; $i <= 10; $i++) {
            echo "<tr>";
            
            for ($j = 1; $j <= 10; $j++) {
                echo "<td> $j x $i = " . ($i * $j) . "</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>