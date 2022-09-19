<?php include 'header.php'?>
<div class="container">
    <h1>Forms:</h1>
    <form id="sign-up" name="sign-up" action="#" method="POST">
        <h2>Sign Up</h2>
        <div class="form-field">
            <label for="login">Login:</label>
            <input type="text" name="login">
        </div>
        <div class="form-field">
            <label for="password">Password:</label>
            <input type="password" name="password">
        </div>
        <div class="form-field">
            <label for="confirm-password">Confirm:</label>
            <input type="password" name="confirm-password">
        </div>
        <div class="form-field">
            <label for="email">Email:</label>
            <input type="text" name="email">
        </div>
        <div class="form-field">
            <label for="name">Name:</label>
            <input type="text" name="name">
        </div>
        
        <input type="submit" value="Sign Up" name="sign-up">
    </form>
    <form id="sign-in" name="sign-up" action="#" method="POST">
        <h2>Sign In</h2>
        <div class="form-field">
            <label for="login">Login:</label>
            <input type="text" name="login">
        </div>
        <div class="form-field">
            <label for="password">Password:</label>
            <input type="password" name="password">
        </div>
        <input type="submit" value="Sign In" name="sign-up">
    </form>
</div>
<script src="index.js" defer></script>
