<?php

it('can get a response limit 60 per min', function () {
    $iterations = 100;
    $success = 0;
    for ($i = 0; $i < $iterations; $i++) {
        $response = $this->call('GET', '/api');
        if ($response->getStatusCode() === 200) {
            $success++;
        }
    }
    $expected = 60;
    expect($success)->toBe($expected);
});
