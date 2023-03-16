
<div class="content">

    <div class="top-title"> <?= LANG[''] ?? "Connexion" ?> </div>

    <form action="" method="post">

        <br>
        <!-- <label for=""> <?= LANG[''] ?? "Connexion" ?> </label> -->
        <input type="text" name="USER" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Identifiant" ?>"><br>
        <input type="text" name="PASSWORD" required id="" onkeyup="input_text(this)" placeholder="<?= LANG[''] ?? "Mot de passe" ?>"><br>
        <br>
        
        <button type="submit"> <?= LANG[''] ?? "Se connecter" ?> </button>

    </form>

</div>