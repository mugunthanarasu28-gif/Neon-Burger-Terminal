<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>NEONBURGER | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root { --neon-pink: #ff00ff; --neon-cyan: #00ffff; }
        body { background-color: #0a0a12; color: var(--neon-cyan); font-family: 'Orbitron', sans-serif; margin: 0; padding: 20px; }
        h1 { text-align: center; text-shadow: 0 0 10px var(--neon-pink); color: var(--neon-pink); }
        
        .admin-panel { display: flex; gap: 20px; }
        
        /* Form Styling */
        form { background: #000; border: 2px solid var(--neon-cyan); padding: 20px; box-shadow: 0 0 15px var(--neon-cyan); width: 300px; }
        input, select, textarea { width: 90%; background: #111; border: 1px solid var(--neon-pink); color: #fff; margin-bottom: 10px; padding: 10px; }
        button { width: 100%; background: var(--neon-pink); color: #000; border: none; padding: 10px; font-weight: bold; cursor: pointer; text-transform: uppercase; box-shadow: 0 0 10px var(--neon-pink); }

        /* Grid Styling */
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; flex-grow: 1; }
        .card { border: 2px solid var(--neon-pink); background: #000; padding: 15px; position: relative; box-shadow: 5px 5px 0px var(--neon-cyan); }
        .price { color: var(--neon-pink); font-size: 1.5rem; font-weight: bold; }
        .delete-btn { color: red; text-decoration: none; position: absolute; right: 10px; top: 10px; }
    </style>
</head>
<body>
    <h1>NEONBURGER ADMIN TERMINAL</h1>
    
    <div class="admin-panel">
        <form action="process.php" method="POST" id="menuForm">
            <h3>Add New Item</h3>
            <input type="text" name="item_name" placeholder="Item Name" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="number" step="0.01" name="price" placeholder="Price (0.00)" id="price" required>
            <select name="category" id="category">
                <option value="Burger">Burger</option>
                <option value="Drink">Drink</option>
                <option value="Side">Side</option>
            </select>
            <input type="number" name="spicy_level" placeholder="Spicy Level (1-5)" id="spicy" min="1" max="5">
            <button type="submit" name="add_item">Launch Item</button>
        </form>

        <div class="menu-grid">
            <?php
            $result = $conn->query("SELECT * FROM menu_items");
            while($row = $result->fetch_assoc()):
            ?>
                <div class="card">
                    <a href="process.php?delete=<?php echo $row['id']; ?>" class="delete-btn">🗑️</a>
                    <h3><?php 
                        echo $row['item_name']; 
                        if($row['spicy_level'] >= 4) echo " 🔥";
                    ?></h3>
                    <p><?php echo $row['description']; ?></p>
                    <div class="price">$<?php echo number_format($row['price'], 2); ?></div>
                    <small>Category: <?php echo $row['category']; ?></small>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        // Client Side Validation
        const categorySelect = document.getElementById('category');
        const spicyInput = document.getElementById('spicy');

        categorySelect.addEventListener('change', () => {
            if(categorySelect.value === 'Drink') {
                spicyInput.value = 0;
                spicyInput.disabled = true;
            } else {
                spicyInput.disabled = false;
            }
        });
    </script>
</body>
</html>