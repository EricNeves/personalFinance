<?php

use App\Infrasctructure\Database\Postgres;

it('connect to postgres database', function () {
    $postgres = Postgres::connect();

    expect($postgres)->toBeInstanceOf(PDO::class);
});