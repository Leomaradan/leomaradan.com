<?php

return [
        'user_id'         => function_exists('env') ? env('FLICKR_USERID', '') : '',
];
