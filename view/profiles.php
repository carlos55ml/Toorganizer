<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles - Toorganizer</title>
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <?php include __DIR__ . '/../modules/header.php'; ?>

    <main>
        <div class="cards">
            <?php
            $users = fetchAllUsers();

            foreach ($users as $user) { ?>
                <a class="link" href="/view/profile.php?id=<?php echo $user['user_id'] ?>">
                    <div class="card">
                        <!-- https://i.imgur.com/uS8FBRT.png -->
                        <img src="<?php echo $user['avatar_url'] ?>" alt="John">
                        <span class="title"><?php echo $user['username'] ?></span>
                    </div>
                </a>
            <?php } ?>
        </div>
    </main>
</body>

</html>