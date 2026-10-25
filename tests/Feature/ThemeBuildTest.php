<?php

test('app css contains presensi theme tokens and compiles', function () {
    $css = file_get_contents(resource_path('css/app.css'));
    expect($css)->toContain('#0E5C56')
        ->toContain('#F6F4F1')
        ->toContain('tnum')
        ->toContain('--color-on-danger')
        ->toContain('--color-danger-hover')
        ->toContain('--color-on-success');
});
