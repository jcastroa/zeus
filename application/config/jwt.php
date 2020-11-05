<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------
| JWT Secure Key
|--------------------------------------------------------------------------
*/
$config['jwt_key'] = 'RzvV-ZUuj8LyPKRQ-Cpl0X9lZRyDguDGErHQduq3AqgGXzMQ0yv8_NDnYCNVlC0Lebfs-NfGCuIhRG-oV7es38ySTtLkvSy3gKz15OgSAF33_ZvBJKLMCEU0L6IbyjwipRAg5aXj89HCxgRgAIXlMEIpoUkHxrrSVOjf65DXH0gulBhCQAiswlfcFauJfqQalbAYw2AdzHklVnVw52w2te_y8fxULVwx2O0NdvzUQ_peGcG9WLW8y4T73F8_Rf0mx25qex0waOC-xRkzjYSk-8fRPmSpuoZyIcYb_TX0PfhOaxhHEbjbAaxQckE7P5LeDWVneLUc4u0OrYVV_yjxSw';


/*
|-----------------------
| JWT Algorithm Type
|--------------------------------------------------------------------------
*/
$config['jwt_algorithm'] = 'HS256';


/*
|-----------------------
| Token Request Header Name
|--------------------------------------------------------------------------
*/
$config['token_header'] = 'authorization';


/*
|-----------------------
| Token Expire Time

| https://www.tools4noobs.com/online_tools/hh_mm_ss_to_seconds/
|--------------------------------------------------------------------------
| ( 1 Day ) : 60 * 60 * 24 = 86400
| ( 1 Hour ) : 60 * 60     = 3600
| ( 1 Minute ) : 60        = 60
*/
$config['token_expire_time'] = 3600;