    <?php
        $host = 'localhost';
        $user = 'root';
        $password = 'root';
        $db_name = 'борей';
        
        $link = mysqli_connect($host, $user, $password, $db_name);
        mysqli_query($link, "SET NAMES 'utf8'");
    ?>