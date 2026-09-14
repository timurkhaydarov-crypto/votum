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

$vtm_5000_rsp = require __DIR__ . '/specifications/vtm_5000_rsp.php';
$vtm_5000_or = require __DIR__ . '/specifications/vtm_5000_or.php';
$vtm_5000_rd = require __DIR__ . '/specifications/vtm_5000_rd.php';
$vtm_5000_pv = require __DIR__ . '/specifications/vtm_5000_pv.php';
$vtm_5000_composite = require __DIR__ . '/specifications/vtm_5000_composite.php';
$tomographic_5m = require __DIR__ . '/specifications/tomographic_5m.php';
$trak = require __DIR__ . '/specifications/trak.php';
$videoscaner = require __DIR__ . '/specifications/videoscaner.php';

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
        'article' => 'VTM-5000-RSP',
        'specifications' => $vtm_5000_rsp,
    ],
    [
        'article' => 'VTM-5000-OR',
        'specifications' => $vtm_5000_or,
    ],
    [
        'article' => 'VTM-5000-RD',
        'specifications' => $vtm_5000_rd,
    ],
    [
        'article' => 'VTM-5000-PV',
        'specifications' => $vtm_5000_pv,
    ],
    [
        'article' => 'VTM-5000-COMPOSITE',
        'specifications' => $vtm_5000_composite,
    ],
    [
        'article' => 'TOMOGRAPHIC-5M',
        'specifications' => $tomographic_5m,
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
    [
        'article' => 'TRAK',
        'specifications' => $trak,
    ],
    [
        'article' => 'VIDEOSCANER',
        'specifications' => $videoscaner,
    ],
];