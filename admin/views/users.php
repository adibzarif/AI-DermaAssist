<div class="ml-64 p-6">
<h1 class="text-2xl mb-5">Users</h1>

<?php while($u = $users->fetch_assoc()): ?>
<div class="bg-white p-3 mb-2 flex justify-between">
    <?= $u['name'] ?>
    <a href="index.php?action=deleteUser&id=<?= $u['id'] ?>"
       class="text-red-500">Delete</a>
</div>
<?php endwhile; ?>

</div>