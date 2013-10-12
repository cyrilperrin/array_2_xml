<?php

// Require
require ('../src/array_2_xml.php');

// HTTP header
header("content-type: text/xml");

// Display XML
echo array_2_xml(
    'person',
    array(
        '@firstname' => 'James',
        '@lastname' => 'Bond',
        'cars' => array(
            array('car', '@model' => 'Vanquish', '@brand' => 'Aston Martin'),
            array('car', '@model' => 'Esprit', '@brand' => 'Lotus'),
            array('car', '@model' => 'Fastback', '@brand' => 'Mustang')
        )
    )
);