<?php

function gravatarUrl($email, $size=60)
{
    $email = md5($email);

    return "https://gravatar.com/avatar/{$email}?" . http_build_query([
        's' => $size,
        'd' => 'https://reznor.tech/img/reznorganizer_default_avatar.png'
    ]);
}