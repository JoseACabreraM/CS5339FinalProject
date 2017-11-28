<section>
    <div>

        <h2>Search</h2>

        <?php
        if(isset($_SESSION['user_id'])){
            echo "SEARCH PAGE <br><br>";
            if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'admin' ) {
                //echo '<img src="utep.png" alt="Utep Logo">';
            }
            else{
               // echo '<img src="utep_miners.png" alt="Miners">';
            }
        }
        ?>
        <form name="form1" method="post" action="searchResult.php">
            <input name="search" type="text" size="40" maxlength="70">
            <input name="submit" type="Submit" value="Search">
        </form>
    </div>
</section>