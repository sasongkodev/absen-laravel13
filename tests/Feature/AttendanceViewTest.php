<?php

test('attendance view has camera frame and required interactive elements', function () {
    $response = $this->get('/presensi');
    $response->assertStatus(200);
    $response->assertSee('webcam-video', false);
    $response->assertSee('snapshot-preview', false);
    $response->assertSee('btn-capture', false);
    $response->assertSee('btn-checkin', false);
    $response->assertSee('btn-checkout', false);
    $response->assertSee('btn-retake', false);
    $response->assertSee('toast-container', false);
});
