<html>
<head>
    <meta charset='utf-8'>
    <title>Tp3 php</title>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <!-- <script src='main.js'></script> -->
</head>
<body>
<h1 style="text-align:center; font-style: italic;">TP3</h1>
    <!-- Ex2 -->
    <FORM ENCTYPE="multipart/form-data" ACTION="upload.php" METHOD="POST">
    <input type=hidden name=nbphotos value=<?=$_GET['NBPHOTOS']?>>
    <?php
        // Ex2
        if (isset($_GET['submit'])) {
            for ($i=1; $i <= $_GET['NBPHOTOS']; $i++) {
                $balise = "<input type=file name='photo" . $i . "'><BR><BR>";
                print "Photo" . $i . "\t";
                echo $balise;
            }
        }
    ?>
    <input type=submit value="Télécharger Photos">
    </FORM>

    <?php
    ?>

    <!-- <script src='main.js'>
        for (let index = 0; index < ?=$_GET['NBPHOTOS']?>; index++) {
            ajouterPhotoAUpload(index);
        }
    </script> -->
</body>
</html>