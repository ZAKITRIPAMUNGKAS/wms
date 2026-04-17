<?php

return [
    'name'         => env('COMPANY_NAME', 'CV. Listrindo Jaya Elektrik'),
    'legal_name'   => env('COMPANY_LEGAL_NAME', 'CV. Listrindo Jaya Elektrik'),
    'short_name'   => env('COMPANY_SHORT_NAME', 'Listrindo Jaya'),
    'tagline'      => env('COMPANY_TAGLINE', ''),
    
    'address' => [
        'street'      => 'Jl. Tebet Raya No.11G 1',
        'rt_rw'       => 'RT.20/RW.2',
        'kelurahan'   => 'Tebet Barat',
        'kecamatan'   => 'Kec. Tebet',
        'kota'        => 'Kota Jakarta Selatan',
        'provinsi'    => 'DKI Jakarta',
        'kode_pos'    => '12810',
        'full'        => 'Jl. Tebet Raya No.11G 1, RT.20/RW.2, Tebet Barat, Kec. Tebet, Kota Jakarta Selatan, DKI Jakarta 12810',
    ],
    
    'contact' => [
        'phone_1'  => '0812-2507-9988',
        'phone_2'  => '0856-7224-975',
        'email'    => env('COMPANY_EMAIL', ''),
        'website'  => env('COMPANY_WEBSITE', ''),
    ],
    
    'logo' => [
        'path'    => 'images/logo.png',
        'icon'    => 'ph-lightning',  // phosphor icon sementara (listrik)
    ],
    
    'branding' => [
        'primary_color'   => '#4f46e5',
        'secondary_color' => '#1e293b',
    ],
];
