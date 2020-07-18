<!-- <?php include __DIR__ . '/../header.php'; ?>
    <h1><?= $article->getName() ?></h1>
    <p><?= $article->getText() ?></p>
    <p>Автор: <?= $article->getAuthor()->getNickname() ?></p>
<?php include __DIR__ . '/../footer.php'; ?> -->

<?php
    // $authorization = "Authorization: Bearer 080042cad6356ad5dc0a720c18b53b8e53d4c274";
    // curl_setopt($article, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
    // curl_setopt($article, CURLOPT_CUSTOMREQUEST, "POST");
    // curl_setopt($article, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($article, CURLOPT_POSTFIELDS,$post);
    // curl_setopt($article, CURLOPT_FOLLOWLOCATION, 1);
    // $result = curl_exec($article);
    // curl_close($article);
    // echo json_decode($result);
    foreach (getallheaders() as $name => $value) {
        echo "$name: $value\n";
    }
    echo json_encode($article);
?>