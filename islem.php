<?php
include 'fonksiyon/helper.php';
session_start();



$user = [
    'kaanayten' => [
        'eposta' => 'kaanayten@gmail.com',
        'password' => '12345',
    ],
    'canberkayten' => [
        'eposta' => 'canberkayten@windowslive.com',
        'password' => '12345',
    ],
    'suzanayten' => [
        'eposta' => 'suzanayten@windowslive.com',
        'password' => '12345',
    ]
];


if (get('islem') == 'giris') {
    $_SESSION['username'] = post('username');
    $_SESSION['password'] = post('password');

    if (!post('username')) {
        $_SESSION['error'] = 'Lütfen kullanıcı adınızı giriniz.';
        header('Location:login.php');
        exit();
    } else  if (!post('password')) {
        $_SESSION['error'] = 'Lütfen şifrenizi giriniz.';
        header('Location:login.php');
        exit();
    } else {

        if (array_key_exists(post('username'), $user)) {
            if ($user[post('username')]['password'] == post('password')) {

                $_SESSION['login'] = true;
                $_SESSION['kullanici_adi'] = post('username');
                $_SESSION['eposta'] = $user[post('username')]['eposta'];
                header('Location:index.php');
                exit();
            } else {
                $_SESSION['error'] = 'Kayıtlı kullanıcı bulunamadı.';
                header('Location:login.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Kayıtlı kullanıcı bulunamadı.';
            header('Location:login.php');
            exit();
        }
    }
}

if (get('islem') == 'hakkimda') {
    $hakkimda = post('hakkimda');

    $islem = file_put_contents('db/' . session('kullanici_adi') . '.txt', htmlspecialchars($hakkimda));
    if ($islem) {
        header('Location:index.php?islem=true');
    } else {
        header('Location:index.php?islem=false');
    }
}

if (get('islem') == 'cikis') {
    session_destroy();
    session_start();
    $_SESSION['error'] = 'Oturum sonlandırıldı.';
    header('Location:login.php');
}

if (get('islem') == 'renk') {
    setcookie('color', get('color'), time() + (86400 * 360));

    header('Location:' . $_SERVER['HTTP_REFERER'] ?? 'index.php');
}
