<?php

use Uit\Aofa\Models\Order;
use System\Models\File;

const ORDER_STATUS = [
    'PROCESSING' => 1,
    'PAYED' => 2,
    'INPROGRESS' => 3,
    'COMPLETED' => 4,
    'DECLINED' => 5,
];

const ORDER_TYPES = [
    'BUY_ACCOUNT' => 1,
    'RESTORE_ACCOUNT' => 2,
    'RENEW_ARENDA' => 3,
    'REGISTER_SESSION' => 4,
    'ADD_BALANCE' => 5,
    'ADMIN_SERVER' => 6,
];

/*
['id' => 1, 'name' => 'В обработке', 'color' => 'blue'],
    ['id' => 2, 'name' => 'Оплачено', 'color' => 'green'],
    ['id' => 3, 'name' => 'Исполняется', 'color' => 'orange'],
    ['id' => 4, 'name' => 'Успешно выполнен', 'color' => 'green'],
    ['id' => 5, 'name' => 'Отклонен', 'color' => 'red'],
*/

Route::get('checkbuy', function () {
    if (is_null(get('api_key')) || get('api_key') != config('app.api_key')) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order = Order::where('type_id', ORDER_TYPES['BUY_ACCOUNT'])
        ->where('status_id', ORDER_STATUS['PAYED'])
        ->orderBy('created_at', 'asc')
        ->first();

    if (is_null($order) || !$order->data['account_count']) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    } else {
        return response(
            'STATUS:OK:' . $order->data['account_count'],
            403
        )->header('Content-Type', 'text/plain');
    }
});

Route::post('checkbuy', function () {
    if (is_null(get('api_key')) || get('api_key') != config('app.api_key')) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $form = Input::all();

    $file = $form['accounts']->path();

    $linecount = 0;
    $handle = fopen($file, 'r');
    while (!feof($handle)) {
        $line = fgets($handle);
        $linecount++;
    }
    fclose($handle);

    $order = Order::where('type_id', ORDER_TYPES['BUY_ACCOUNT'])
        ->where('status_id', ORDER_STATUS['PAYED'])
        ->orderBy('created_at', 'asc')
        ->first();

    if (is_null($order) || !$order->data['account_count']) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order->status_id = ORDER_STATUS['INPROGRESS'];
    $order->save();

    if ($order->data['account_count'] == $linecount) {
        $file = (new File())->fromPost($form['accounts']);
        $file->save();
        $order->files()->add($file);
        $order->status_id = ORDER_STATUS['COMPLETED']; //Успешно выполнен
        $order->save();
        return response('STATUS:SUCCES', 200)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order->status_id = ORDER_STATUS['PAYED'];
    $order->save();

    return response('STATUS:BAD', 403)->header('Content-Type', 'text/plain');
});

Route::get('checkrecovery', function () {
    if (is_null(get('api_key')) || get('api_key') != config('app.api_key')) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order = Order::where('type_id', ORDER_TYPES['RESTORE_ACCOUNT'])
        ->where('status_id', ORDER_STATUS['PAYED'])
        ->orderBy('created_at', 'asc')
        ->first();

    if (is_null($order) || !$order->data['recover_file']) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    } else {
        $file = public_path(parse_url($order->data['recover_file'])['path']);

        $accountLines = '';
        $handle = fopen($file, 'r');
        while (!feof($handle)) {
            $line = fgets($handle);
            $accountLines .= $line;
        }

        fclose($handle);

        return response("STATUS:OK\n" . $accountLines, 403)->header(
            'Content-Type',
            'text/plain'
        );
    }
});

Route::post('checkrecovery', function () {
    if (is_null(get('api_key')) || get('api_key') != config('app.api_key')) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $form = Input::all();

    $file = $form['accounts']->path();

    $linecount = 0;
    $handle = fopen($file, 'r');
    while (!feof($handle)) {
        $line = fgets($handle);
        $linecount++;
    }
    fclose($handle);

    $order = Order::where('type_id', ORDER_TYPES['RESTORE_ACCOUNT'])
        ->where('status_id', ORDER_STATUS['PAYED'])
        ->orderBy('created_at', 'asc')
        ->first();

    if (is_null($order) || !$order->data['recover_file']) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order->status_id = ORDER_STATUS['INPROGRESS'];
    $order->save();

    $file = public_path(parse_url($order->data['recover_file'])['path']);

    $needAccountCount = 0;
    $handle = fopen($file, 'r');
    while (!feof($handle)) {
        $line = fgets($handle);
        $needAccountCount ++;
    }

    fclose($handle);

    $file = (new File())->fromPost($form['accounts']);
    $file->save();
    $order->files()->add($file);
    $order->status_id = ORDER_STATUS['COMPLETED']; //Успешно выполнен
    $order->save();
    return response('STATUS:SUCCES', 200)->header(
        'Content-Type',
        'text/plain'
    );

    $order->status_id = ORDER_STATUS['PAYED'];
    $order->save();

    return response('STATUS:BAD', 403)->header('Content-Type', 'text/plain');
});





Route::get('checkregistration', function () {
    if (is_null(get('api_key')) || get('api_key') != config('app.api_key')) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order = Order::where('type_id', ORDER_TYPES['REGISTER_SESSION'])
        ->where('status_id', ORDER_STATUS['PAYED'])
        ->orderBy('created_at', 'asc')
        ->first();

    if (is_null($order) || !$order->data['recover_file']) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    } else {
        $file = public_path(parse_url($order->data['recover_file'])['path']);

        $accountLines = '';
        $handle = fopen($file, 'r');
        while (!feof($handle)) {
            $line = fgets($handle);
            $accountLines .= $line;
        }

        fclose($handle);

        return response("STATUS:OK\n" . $accountLines, 403)->header(
            'Content-Type',
            'text/plain'
        );
    }
});

Route::post('checkregistration', function () {
    if (is_null(get('api_key')) || get('api_key') != config('app.api_key')) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $form = Input::all();

    $file = $form['accounts']->path();

    $linecount = 0;
    $handle = fopen($file, 'r');
    while (!feof($handle)) {
        $line = fgets($handle);
        $linecount++;
    }
    fclose($handle);

    $order = Order::where('type_id', ORDER_TYPES['REGISTER_SESSION'])
        ->where('status_id', ORDER_STATUS['PAYED'])
        ->orderBy('created_at', 'asc')
        ->first();

    if (is_null($order) || !$order->data['recover_file']) {
        return response('STATUS:BAD', 403)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order->status_id = ORDER_STATUS['INPROGRESS'];
    $order->save();

    $file = public_path(parse_url($order->data['recover_file'])['path']);

    $needAccountCount = 0;
    $handle = fopen($file, 'r');
    while (!feof($handle)) {
        $line = fgets($handle);
        $needAccountCount ++;
    }

    fclose($handle);

    if ($needAccountCount == $linecount) {
        $file = (new File())->fromPost($form['accounts']);
        $file->save();
        $order->files()->add($file);
        $order->status_id = ORDER_STATUS['COMPLETED']; //Успешно выполнен
        $order->save();
        return response('STATUS:SUCCES', 200)->header(
            'Content-Type',
            'text/plain'
        );
    }

    $order->status_id = ORDER_STATUS['PAYED'];
    $order->save();

    return response('STATUS:BAD', 403)->header('Content-Type', 'text/plain');
});

