<?php
$host = "localhost";
$username = "root";
$password = "";
$dbname = "product_db";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$message = "";
$popupType = ""; 
$showPopup = false;

if (isset($_POST["submit"])) {
    $product_name = $_POST["product_name"];
    $category = $_POST["category"];
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $supplier = $_POST["supplier"];
    $detail = $_POST["detail"];

    if (empty($product_name) || empty($category) || empty($price) || empty($stock) || empty($supplier) || empty($detail)) {
        $message = "Please fill in all fields.";
        $popupType = "error";
        $showPopup = true;
    } elseif (!is_numeric($price)) {
        $message = "
        <p>I know you put the name of the number but I can't just prove it.</p>
        <img src='https://media1.tenor.com/m/x-YvNUa0UPQAAAAd/james-doakes-james-doakes-sus-face.gif'
             alt='GIF' width='220'>";
        $popupType = "error";
        $showPopup = true;
    } else {
        try {
            $sql = "INSERT INTO products (product_name, category, price, stock, supplier, detail)
                    VALUES (:product_name, :category, :price, :stock, :supplier, :detail)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_name', $product_name);
            $stmt->bindParam(':category', $category);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':stock', $stock);
            $stmt->bindParam(':supplier', $supplier);
            $stmt->bindParam(':detail', $detail);
            $stmt->execute();

            $message = "<h3>Product added successfully!</h3>
            <img src='https://tiermaker.com/images/template_images/2022/782255/all-genshin-impact-emotes-stickers-40-782255/110praise.png'
                alt='IMG' width='250'>
";
            
            $popupType = "success";
            $showPopup = true;
        } catch (PDOException $e) {
            $message = "Error: " . $e->getMessage();
            $popupType = "error";
            $showPopup = true;
        }
    }
}

$students = [];
try {
    $result = $conn->query("SELECT * FROM products");
    $products = $result->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Error loading records: " . $e->getMessage();
    $popupType = "error";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Page</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f6f7;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 30px;
        }

        .form-container {
            background: #fff;
            width: 400px;
            margin: 30px auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        select {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            height: 35px;
            width: 400px;
            text-align: center;
        }

        input {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 15px;
            padding: 10px;
            width: 100%;
            background-color: #243ed1ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        table {
            border-collapse: collapse;
            width: 80%;
            margin: 30px auto;
            background: #fff;
            box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .popup {
            background: #fff;
            padding: 20px;
            width: 350px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s ease;
        }

        .popup.success {
            border: 3px solid #ffffffff;
            color: #155724;
            font-weight: bold;
        }

        .popup.error {
            border: 3px solid #fdfdfdff;
            color: #910412ff;
            font-weight: bold;
        }

        .popup img {
            margin-top: 10px;
            border-radius: 8px;
        }

        .close-btn {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            margin-top: 10px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: #0056b3;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body>

<h2>Product List</h2>

<div class="form-container">
    <form method="POST">
        <label>Product Name:</label>
        <input type="text" name="product_name">

        <label>Category:</label>
        <select name="category" class="drop-down">
            <option value="">Select a Category</option>
            <option value="Electronic">Electronic</option>
            <option value="Clothing">Clothing</option>
            <option value="Home & Kitchen">Home & Kitchen</option>
            <option value="Sports">Sports</option>
            <option value="Books">Books</option>
            <option value="Essential">Essential</option>
        </select>

        <label>Price:</label>
        <input type="text" name="price">

        <label>Stock:</label>
        <input type="text" name="stock">

        <label>Supplier:</label>
        <input type="text" name="supplier">

        <label>Description:</label>
        <input type="text" name="detail">

        <button type="submit" name="submit">Add Product</button>
    </form>
</div>

<h2>List of Products</h2>

<?php if (count($products) > 0): ?>
<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Category</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Supplier</th>
        <th>Details</th>
        <th>Created At</th>
    </tr>
    <?php foreach ($products as $row): ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
        <td><?php echo htmlspecialchars($row['category']); ?></td>
        <td><?php echo $row['price']; ?></td>
        <td><?php echo $row['stock']; ?></td>
        <td><?php echo htmlspecialchars($row['supplier']); ?></td>
        <td><?php echo htmlspecialchars($row['detail']); ?></td>
        <td><?php echo htmlspecialchars($row['created_at']); ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php else: ?>
<p style="text-align:center;">No products found.</p>
<?php endif; ?>

<div class="overlay" id="popupOverlay">
    <div class="popup <?php echo $popupType; ?>">
        <?php echo $message; ?>
        <button class="close-btn" onclick="closePopup()">Close</button>
    </div>
</div>

<script>
function closePopup() {
    document.getElementById("popupOverlay").style.display = "none";
}
<?php if ($showPopup): ?>
document.getElementById("popupOverlay").style.display = "flex";
<?php endif; ?>
</script>

</body>
</html>