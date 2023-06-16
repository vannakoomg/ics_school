<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4-L',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('temp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => base_path('resources/fonts/'),
	'margin_left'			=> '2',
	'margin_right'			=> '2',
	'margin_top'			=> '2',
	'margin_bottom'			=> '2',
	'isRemoteEnabled'		=> true,
	'font_data' => [
		"khmerosmoul" => [/* Khmer */
		'R' => "KhmerOSMuol.ttf",
		'useOTL' => 0xFF,
		],
		"khmerosmoullight" => [/* Khmer */
		'R' => "KhmerOSmuollight.ttf",
		'useOTL' => 0xFF,
		],
		"khmerosbokor" => [/* Khmer */
		'R' => "KhmerOSBokor.ttf",
		'useOTL' => 0xFF,
		],
		"khmeros" =>  [
		'R' => "KhmerOS.ttf",
		'useOTL' => 0xFF,
		],
		"khmerosbattambong" => [/* Khmer */
			'R' => "KhmerOS_battambang.ttf",
			'useOTL' => 0xFF,
			],
		"khmerosmoulpali" => [/* Khmer */
		'R' => "KhmerOSmuolpali.ttf",
		'useOTL' => 0xFF,
		'useKashida' => 75
		],
		"centuryschoolbookbold" => [/* Khmer */
			'B' => "CenturySchoolbookBold.ttf",
			'useOTL' => 0xFF,
			'useKashida' => 75
			]
		
  ]
];


