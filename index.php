<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.min.css">
    <title>TEST</title>
</head>
<body>
    <main class="main">
        <div class="main__container">
            <form method="POST" action="index.php" class="main__search">
                <span class="text">Поиск по названию:</span>
                <input type="text" name="search" class="main__search-text">
                <input type="submit" value="Выборка" class="main__search-button">
            </form>
            <div class="data__title">
                <div class="data__line-id"></div>
                <div class="data__title-brand">Марка</div>
                <div class="data__title-provider">Поставщик</div>
                <div class="data__title-name">Наименование</div>
                <div class="data__title-buyer">Покупатель</div>
            </div>

            <?php
                require('php/connect_db.php');

                file_put_contents('csv/result.csv', null);

                if (!empty($_POST['search'])) { 

                    $query = "SELECT * FROM Товары";       
                    $result = mysqli_query($link, $query) or die(mysqli_query($link));
                    
                    for ($data = []; $row = mysqli_fetch_assoc($result); $data[] = $row);
                    $result = '';
                    $id = 0;

                    foreach ($data as $item) {
                        $pos_brand = strpos(mb_strtolower($item['марка']), $_POST['search']);
                        $pos_name = strpos(mb_strtolower($item['наименование']), $_POST['search']);
                        $pos_buyer = strpos(mb_strtolower($item['покупатель']), $_POST['search']);

                        if ($pos_brand !== false || $pos_name !== false || $pos_buyer !== false) {
                            $id++;
                            echo    '<div class="data__line">
                                        <div class="data__line-id">'.$id.'</div>
                                        <div class="data__line-brand">'.$item['марка'].'</div>
                                        <div class="data__line-provider">'.$item['поставщик'].'</div>
                                        <div class="data__line-name">'.$item['наименование'].'</div>
                                        <div class="data__line-buyer">'.$item['покупатель'].'</div>
                                    </div>';
                            $file = 'csv/result.csv';
                            $tofile = $id.';'.$item['марка'].';'.$item['поставщик'].';'.$item['наименование'].';'.$item['покупатель'].'\n';
                            file_put_contents($file, $tofile, FILE_APPEND);
                        }                        
                    }

                    if ($id === 0) {
                        echo '<div class="error">По вашему заросу ничего не найдено</div>';
                    } else {
                        echo '<a href="csv/result.csv" class="get__file">Скачать данные</a>'; 
                    }
                }   
            ?>
        </div>
    </main>
</body>
</html>