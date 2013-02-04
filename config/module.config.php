<?php

return array(
    'nominet_epp' => array(
        'live'   => false,
        'secure' => true,
        'config' => array(
            'live' => array(
                'secure' => array(
                    'host' => 'epp.nominet.org.uk',
                    'port' => '700',
                ),
                'insecure' => array(
                    'host' => 'epp.nominet.org.uk',
                    'port' => '8700',
                ),
            ),
            'test' => array(
                'secure' => array(
                    'host' => 'testbed-epp.nominet.org.uk',
                    'port' => '700',
                ),
                'insecure' => array(
                    'host' => 'testbed-epp.nominet.org.uk',
                    'port' => '8700',
                ),
            ),
        ),
    ),
);
