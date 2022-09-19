<?php 
include 'header.php';
session_start(); 
?>
<div class="container">
    <div class="wrapeper">
<?php if(isset($_SESSION['user'])): ?>
    <h1> Hello, <?php echo $_SESSION['user']['name']; ?></h1>
    <a href="./logout.php">Sign out</a>
<?php else: ?>

<?php if(isset($_COOKIE['user'])): ?>
    <?php 
        $data = json_decode($_COOKIE['user']);
    ?>
    <h1><?php echo $data->name; ?>, Hello</h1>
    <a href="./logout.php">Sign out</a>
<?php endif; ?>
<?php endif; ?>
    </div>
</div>