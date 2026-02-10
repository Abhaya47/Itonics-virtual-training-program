<?php

require_once "../middleware/auth.php";
require_once "../config/db.php";

$user_id = $_SESSION['user_id'];
$todos = mysqli_query($conn, "SELECT * FROM todos WHERE user_id = $user_id");
?>

<h2>Your To-Do List</h2>
<form method ="POST" action="store.php">
    <input name="title" placeholder="New Task">
    <button>Add</button>
</form>

<ul>
    <?php while ($todo = mysqli_fetch_assoc($todos)) { ?>
        <li>
        <?= htmlspecialchars($todo['title']) ?>
            <a href="delete.php?id=<?php echo $todo['id']; ?>">Delete</a>
        </li>
    <?php } ?>
</ul>

<a href="/auth/logout.php">Logout</a>