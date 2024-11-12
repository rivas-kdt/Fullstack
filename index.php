<?php
include 'db.php';
$api_url = 'http://localhost/try/api/product.php';
$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if ($response === false) {
    $error = curl_error($ch);
    echo "cURL Error: $error";
} else {
    $response_data = json_decode($response, true);
}

curl_close($ch);
?>
<!DOCTYPE html>
<html>
<head>
    <link href="styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="flex flex-col justify-center items-center">
        <h1 class="text-4xl font-bold">TABLE</h1>
        <table class="border border-black">
            <tr class="h-8">
                <th class="bg-blue-300 w-16 border border-black">ID</th>
                <th class="bg-green-300 w-36 border border-black">Product</th>
                <th class="bg-green-300 w-36 border border-black">Category</th>
                <th class="bg-green-300 w-24 border border-black">Price</th>
                <th class="bg-green-300 w-16 border border-black">Stock</th>
                <th class="bg-green-300 w-16 border border-black">Action/s</th>
            </tr>
            <tbody>
            <?php
            if (isset($response_data) && is_array($response_data)) {
                foreach ($response_data as $row) {
                    echo "<tr>
                            <td class='border-l border-r border-black pl-2'>{$row['prod_id']}</td>
                            <td class='border-l border-r border-black pl-2'>{$row['prod_name']}</td>
                            <td class='border-l border-r border-black pl-2'>{$row['cat_name']}</td>
                            <td class='border-l border-r border-black pl-2 text-right'>{$row['prod_price']} Php</td>
                            <td class='border-l border-r border-black pl-2 text-right'>{$row['qty']} Pc/s</td>
                            <td class='text-center'><button class='openModalBtn px-4 bg-green-300 rounded-md hover:bg-green-500' data-id='{$row['prod_id']}' data-name='{$row['prod_name']}'>O</button></td>
                        </tr>";
                }
            }
            ?>
            </tbody>
        </table>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">×</span>
                <h2 class=" text-center font-bold text-2xl">PRODUCT</h2>
                <p class=" font-light">ID: <span id="modalId"></span></p>
                <div class=" flex justify-between">
                    <p class=" font-light text-lg">Name: <span id="modalName" class=" font-bold"></span></p>
                    <p class=" font-light">Category: <span id="modalCat" class=" font-normal"></span></p>
                </div>
                <p class=" font-light">Description: <span id="modalDesc"></span></p>
                <p class="text-right"><span id="modalPrc"></span> Php</p>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
