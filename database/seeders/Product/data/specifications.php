<?php
$dami_c09 = require __DIR__ . '/specifications/dami_c09.php';
$chameleon_32_64 = require __DIR__ . '/specifications/chameleon_32_64.php';
$chameleon_32 = require __DIR__ . '/specifications/chameleon_32.php';
$foton_1200 = require __DIR__ . '/specifications/foton_1200.php';
$kalmar_32 = require __DIR__ . '/specifications/kalmar_32.php';
$vtm_5000_frame = require __DIR__ . '/specifications/vtm_5000_frame.php';
$vtm_5000_faust = require __DIR__ . '/specifications/vtm_5000_faust.php';
$vtm_5000_kp = require __DIR__ . '/specifications/vtm_5000_kp.php';
$vtm_5000_rt = require __DIR__ . '/specifications/vtm_5000_rt.php';
$teri = require __DIR__ . '/specifications/teri.php';
$tomographic_ud4_tm_269 = require __DIR__ . '/specifications/tomographic_ud4_tm_269.php';
$vihr_2k = require __DIR__ . '/specifications/vihr_2k.php';



return [
    [
        'article' => 'FOTON-1200',
        'specifications' => $foton_1200,
    ],
    [
        'article' => 'VTM-5000-KP',
        'specifications' => $vtm_5000_kp,
    ],
    [
        'article' => 'DAMI-C09',
        'specifications' => $dami_c09,
    ],
    [
        'article' => 'TERI',
        'specifications' => $teri,
    ],
    [
        'article' => 'CHAMELEON-32-64',
        'specifications' => $chameleon_32_64,
    ],
    [
        'article' => 'VTM-5000-FRAME',
        'specifications' => $vtm_5000_frame,
    ],
    [
        'article' => 'VTM-5000-FAUST',
        'specifications' => $vtm_5000_faust,
    ],
    [
        'article' => 'VIHR-2K',
        'specifications' => $vihr_2k,
    ],
    [
        'article' => 'VTM-5000-RT',
        'specifications' => $vtm_5000_rt,
    ],
    [
        'article' => 'KALMAR-32',
        'specifications' => $kalmar_32,
    ],
    [
        'article' => 'CHAMELEON-32',
        'specifications' => $chameleon_32,
    ],
    [
        'article' => 'TOMOGRAPHIC-UD4-TM-269',
        'specifications' => $tomographic_ud4_tm_269,
    ],
];
