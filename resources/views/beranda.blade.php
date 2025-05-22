@extends('welcome')

@section('title', 'Halaman Dashboard')

@section('content')

<!-- CSRF Token for AJAX -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container py-5">
    <h2 class="text-center mb-4">Riwayat Aktivitas Pegawai</h2>

    @php
        $logs = $logs ?? collect();

        $wilayahMapping = [
            'prov' => [
                    '11' => 'Aceh',
            '12' => 'Sumatera Utara',
            '13' => 'Sumatera Barat',
            '14' => 'Riau',
            '15' => 'Jambi',
            '16' => 'Sumatera Selatan',
            '17' => 'Bengkulu',
            '18' => 'Lampung',
            '19' => 'Kepulauan Bangka Belitung',
            '21' => 'Kepulauan Riau',
            '31' => 'DKI Jakarta',
            '32' => 'Jawa Barat',
            '33' => 'Jawa Tengah',
            '34' => 'DI Yogyakarta',
            '35' => 'Jawa Timur',
            '36' => 'Banten',
            '51' => 'Bali',
            '52' => 'Nusa Tenggara Barat',
            '53' => 'Nusa Tenggara Timur',
            '61' => 'Kalimantan Barat',
            '62' => 'Kalimantan Tengah',
            '63' => 'Kalimantan Selatan',
            '64' => 'Kalimantan Timur',
            '65' => 'Kalimantan Utara',
            '71' => 'Sulawesi Utara',
            '72' => 'Sulawesi Tengah',
            '73' => 'Sulawesi Selatan',
            '74' => 'Sulawesi Tenggara',
            '75' => 'Gorontalo',
            '76' => 'Sulawesi Barat',
            '81' => 'Maluku',
            '82' => 'Maluku Utara',
            '91' => 'Papua',
            '92' => 'Papua Barat',
            '93' => 'Papua Selatan',
            '94' => 'Papua Tengah',
            '95' => 'Papua Pegunungan',
            '96' => 'Papua Barat Daya',
                // Tambahkan sesuai kebutuhan
            ],
            'kab_kot' => [
                '1101' => 'Kabupaten Simeulue',
                '1102' => 'Kabupaten Aceh Singkil',
                '1103' => 'Kabupaten Aceh Selatan',
                '1104' => 'Kabupaten Aceh Tenggara',
                '1105' => 'Kabupaten Aceh Timur',
                '1106' => 'Kabupaten Aceh Tengah',
                '1107' => 'Kabupaten Aceh Barat',
                '1108' => 'Kabupaten Aceh Besar',
                '1109' => 'Kabupaten Pidie',
                '1110' => 'Kabupaten Bireuen',
                '1111' => 'Kabupaten Aceh Utara',
                '1112' => 'Kabupaten Aceh Barat Daya',
                '1113' => 'Kabupaten Gayo Lues',
                '1114' => 'Kabupaten Aceh Tamiang',
                '1115' => 'Kabupaten Nagan Raya',
                '1116' => 'Kabupaten Aceh Jaya',
                '1117' => 'Kabupaten Bener Meriah',
                '1118' => 'Kabupaten Pidie Jaya',
                '1171' => 'Kota Banda Aceh',
                '1172' => 'Kota Sabang',
                '1173' => 'Kota Langsa',
                '1174' => 'Kota Lhokseumawe',
                '1175' => 'Kota Subulussalam',
                '1201' => 'Kabupaten Nias',
                '1202' => 'Kabupaten Mandailing Natal',
                '1203' => 'Kabupaten Tapanuli Selatan',
                '1204' => 'Kabupaten Tapanuli Tengah',
                '1205' => 'Kabupaten Tapanuli Utara',
                '1206' => 'Kabupaten Nias Selatan',
                '1207' => 'Kabupaten Labuhan Batu',
                '1208' => 'Kabupaten Asahan',
                '1209' => 'Kabupaten Simalungun',
                '1210' => 'Kabupaten Dairi',
                '1211' => 'Kabupaten Karo',
                '1212' => 'Kabupaten Deli Serdang',
                '1213' => 'Kabupaten Langkat',
                '1214' => 'Kabupaten Nias Utara',
                '1215' => 'Kabupaten Humbang Hasundutan',
                '1216' => 'Kabupaten Pakpak Bharat',
                '1217' => 'Kabupaten Toba Samosir',
                '1218' => 'Kabupaten Samosir',
                '1219' => 'Kabupaten Serdang Bedagai',
                '1220' => 'Kabupaten Batu Bara',
                '1221' => 'Kabupaten Padang Lawas Utara',
                '1222' => 'Kabupaten Padang Lawas',
                '1223' => 'Kabupaten Labuhan Batu Selatan',
                '1224' => 'Kabupaten Labuhan Batu Utara',
                '1271' => 'Kota Sibolga',
                '1272' => 'Kota Tanjung Balai',
                '1273' => 'Kota Pematang Siantar',
                '1274' => 'Kota Tebing Tinggi',
                '1275' => 'Kota Padang Sidempuan',
                '1276' => 'Kota Gunungsitoli',
                '1301' => 'Kabupaten Kepulauan Mentawai',
                '1302' => 'Kabupaten Pesisir Selatan',
                '1303' => 'Kabupaten Solok',
                '1304' => 'Kabupaten Sijunjung',
                '1305' => 'Kabupaten Tanah Datar',
                '1306' => 'Kabupaten Padang Pariaman',
                '1307' => 'Kabupaten Agam',
                '1308' => 'Kabupaten Lima Puluh Kota',
                '1309' => 'Kabupaten Pasaman',
                '1310' => 'Kabupaten Solok Selatan',
                '1311' => 'Kabupaten Dharmasraya',
                '1312' => 'Kabupaten Pasaman Barat',
                '1371' => 'Kota Padang',
                '1372' => 'Kota Sawahlunto',
                '1373' => 'Kota Solok',
                '1374' => 'Kota Bukittinggi',
                '1375' => 'Kota Payakumbuh',
                '1376' => 'Kota Pariaman',
                 '1401' => 'Kabupaten Kuantan Singingi',
                '1402' => 'Kabupaten Indragiri Hulu',
                '1403' => 'Kabupaten Indragiri Hilir',
                '1404' => 'Kabupaten Pelalawan',
                '1405' => 'Kabupaten Siak',
                '1406' => 'Kabupaten Kampar',
                '1407' => 'Kabupaten Rokan Hulu',
                '1408' => 'Kabupaten Bengkalis',
                '1409' => 'Kabupaten Rokan Hilir',
                '1410' => 'Kabupaten Kepulauan Meranti',
                '1471' => 'Kota Pekanbaru',
                '1472' => 'Kota Dumai',
                '1501' => 'Kabupaten Kerinci',
                '1502' => 'Kabupaten Merangin',
                '1503' => 'Kabupaten Sarolangun',
                '1504' => 'Kabupaten Batanghari',
                '1505' => 'Kabupaten Muaro Jambi',
                '1506' => 'Kabupaten Tanjung Jabung Timur',
                '1507' => 'Kabupaten Tanjung Jabung Barat',
                '1508' => 'Kabupaten Bungo',
                '1509' => 'Kabupaten Tebo',
                '1571' => 'Kota Jambi',
                '1572' => 'Kota Sungai Penuh',
                '1601' => 'Kabupaten Ogan Komering Ulu',
                '1602' => 'Kabupaten Ogan Komering Ilir',
                '1603' => 'Kabupaten Muara Enim',
                '1604' => 'Kabupaten Lahat',
                '1605' => 'Kabupaten Musi Rawas',
                '1606' => 'Kabupaten Banyuasin',
                '1607' => 'Kabupaten Ogan Ilir',
                '1608' => 'Kabupaten Musi Banyuasin',
                '1609' => 'Kabupaten Empat Lawang',
                '1610' => 'Kabupaten Penukal Abab Lematang Ilir',
                '1611' => 'Kabupaten Pagar Alam',
                '1612' => 'Kota Lubuklinggau',
                '1671' => 'Kota Palembang',
                '1672' => 'Kota Pagar Alam',
                '1673' => 'Kota Lubuklinggau',
                '1674' => 'Kota Prabumulih',
                '1701' => 'Kabupaten Bengkulu Selatan',
                '1702' => 'Kabupaten Rejang Lebong',
                '1703' => 'Kabupaten Bengkulu Utara',
                '1704' => 'Kabupaten Kaur',
                '1705' => 'Kabupaten Seluma',
                '1706' => 'Kabupaten Mukomuko',
                '1707' => 'Kabupaten Lebong',
                '1708' => 'Kabupaten Kepahiang',
                '1720' => 'Kabupaten Bengkulu Tengah',
                '1771' => 'Kota Bengkulu',
                '1801' => 'Kabupaten Lampung Barat',
                '1802' => 'Kabupaten Tanggamus',
                '1803' => 'Kabupaten Lampung Selatan',
                '1804' => 'Kabupaten Lampung Timur',
                '1805' => 'Kabupaten Lampung Tengah',
                '1806' => 'Kabupaten Lampung Utara',
                '1807' => 'Kabupaten Way Kanan',
                '1808' => 'Kabupaten Tulangbawang',
                '1809' => 'Kabupaten Pesawaran',
                '1810' => 'Kabupaten Mesuji',
                '1811' => 'Kabupaten Tulang Bawang Barat',
                '1812' => 'Kabupaten Pesisir Barat',
                '1871' => 'Kota Bandar Lampung',
                '1872' => 'Kota Metro',
                '1901' => 'Kabupaten Bangka',
                '1902' => 'Kabupaten Belitung',
                '1903' => 'Kabupaten Bangka Selatan',
                '1904' => 'Kabupaten Bangka Tengah',
                '1905' => 'Kabupaten Bangka Barat',
                '1906' => 'Kabupaten Belitung Timur',
                '1971' => 'Kota Pangkal Pinang',
                '2101' => 'Kabupaten Bintan',
                '2102' => 'Kabupaten Karimun',
                '2103' => 'Kabupaten Lingga',
                '2104' => 'Kabupaten Natuna',
                '2105' => 'Kabupaten Kepulauan Anambas',
                '2171' => 'Kota Tanjung Pinang',
                '3171' => 'Kota Jakarta Selatan',
                '3172' => 'Kota Jakarta Timur',
                '3173' => 'Kota Jakarta Pusat',
                '3174' => 'Kota Jakarta Barat',
                '3175' => 'Kota Jakarta Utara',
                '3201' => 'Kabupaten Bogor',
                '3202' => 'Kabupaten Sukabumi',
                '3203' => 'Kabupaten Cianjur',
                '3204' => 'Kabupaten Bandung',
                '3205' => 'Kabupaten Garut',
                '3206' => 'Kabupaten Tasikmalaya',
                '3207' => 'Kabupaten Ciamis',
                '3208' => 'Kabupaten Kuningan',
                '3209' => 'Kabupaten Majalengka',
                '3210' => 'Kabupaten Cirebon',
                '3211' => 'Kabupaten Indramayu',
                '3212' => 'Kabupaten Subang',
                '3213' => 'Kabupaten Purwakarta',
                '3214' => 'Kabupaten Karawang',
                '3215' => 'Kabupaten Bekasi',
                '3216' => 'Kabupaten Bandung Barat',
                '3271' => 'Kota Bogor',
                '3272' => 'Kota Sukabumi',
                '3273' => 'Kota Bandung',
                '3274' => 'Kota Cirebon',
                '3275' => 'Kota Bekasi',
                '3276' => 'Kota Depok',
                '3277' => 'Kota Cimahi',
                '3278' => 'Kota Tasikmalaya',
                '3279' => 'Kota Banjar',
                 '3301' => 'Kabupaten Cilacap',
                '3302' => 'Kabupaten Banyumas',
                '3303' => 'Kabupaten Purbalingga',
                '3304' => 'Kabupaten Banjarnegara',
                '3305' => 'Kabupaten Kebumen',
                '3306' => 'Kabupaten Purworejo',
                '3307' => 'Kabupaten Wonosobo',
                '3308' => 'Kabupaten Magelang',
                '3309' => 'Kabupaten Boyolali',
                '3310' => 'Kabupaten Klaten',
                '3311' => 'Kabupaten Sukoharjo',
                '3312' => 'Kabupaten Wonogiri',
                '3313' => 'Kabupaten Karanganyar',
                '3314' => 'Kabupaten Sragen',
                '3315' => 'Kabupaten Grobogan',
                '3316' => 'Kabupaten Blora',
                '3317' => 'Kabupaten Rembang',
                '3318' => 'Kabupaten Pati',
                '3319' => 'Kabupaten Kudus',
                '3320' => 'Kabupaten Jepara',
                '3321' => 'Kabupaten Demak',
                '3322' => 'Kabupaten Semarang',
                '3323' => 'Kabupaten Temanggung',
                '3324' => 'Kabupaten Kendal',
                '3325' => 'Kabupaten Batang',
                '3326' => 'Kabupaten Pekalongan',
                '3327' => 'Kabupaten Pemalang',
                '3328' => 'Kabupaten Tegal',
                '3329' => 'Kabupaten Brebes',
                '3371' => 'Kota Magelang',
                '3372' => 'Kota Surakarta',
                '3373' => 'Kota Salatiga',
                '3374' => 'Kota Semarang',
                '3375' => 'Kota Pekalongan',
                '3376' => 'Kota Tegal',
                 '3401' => 'Kabupaten Kulon Progo',
                '3402' => 'Kabupaten Bantul',
                '3403' => 'Kabupaten Gunungkidul',
                '3404' => 'Kabupaten Sleman',
                '3471' => 'Kota Yogyakarta',
                 '3501' => 'Kabupaten Pacitan',
                '3502' => 'Kabupaten Ponorogo',
                '3503' => 'Kabupaten Trenggalek',
                '3504' => 'Kabupaten Tulungagung',
                '3505' => 'Kabupaten Blitar',
                '3506' => 'Kabupaten Kediri',
                '3507' => 'Kabupaten Malang',
                '3508' => 'Kabupaten Lumajang',
                '3509' => 'Kabupaten Jember',
                '3510' => 'Kabupaten Banyuwangi',
                '3511' => 'Kabupaten Bondowoso',
                '3512' => 'Kabupaten Situbondo',
                '3513' => 'Kabupaten Probolinggo',
                '3514' => 'Kabupaten Pasuruan',
                '3515' => 'Kabupaten Sidoarjo',
                '3516' => 'Kabupaten Mojokerto',
                '3517' => 'Kabupaten Jombang',
                '3518' => 'Kabupaten Nganjuk',
                '3519' => 'Kabupaten Madiun',
                '3520' => 'Kabupaten Magetan',
                '3521' => 'Kabupaten Ngawi',
                '3522' => 'Kabupaten Bojonegoro',
                '3523' => 'Kabupaten Tuban',
                '3524' => 'Kabupaten Lamongan',
                '3525' => 'Kabupaten Gresik',
                '3526' => 'Kabupaten Bangkalan',
                '3527' => 'Kabupaten Sampang',
                '3528' => 'Kabupaten Pamekasan',
                '3529' => 'Kabupaten Sumenep',
                '3571' => 'Kota Kediri',
                '3572' => 'Kota Blitar',
                '3573' => 'Kota Malang',
                '3574' => 'Kota Probolinggo',
                '3575' => 'Kota Pasuruan',
                '3576' => 'Kota Mojokerto',
                '3577' => 'Kota Madiun',
                '3578' => 'Kota Surabaya',
                '3579' => 'Kota Batu',
                  '3601' => 'Kabupaten Pandeglang',
                '3602' => 'Kabupaten Lebak',
                '3603' => 'Kabupaten Tangerang',
                '3604' => 'Kabupaten Serang',
                '3671' => 'Kota Tangerang',
                '3672' => 'Kota Cilegon',
                '3673' => 'Kota Serang',
                '3674' => 'Kota Tangerang Selatan',
                 '5101' => 'Kabupaten Jembrana',
                '5102' => 'Kabupaten Tabanan',
                '5103' => 'Kabupaten Badung',
                '5104' => 'Kabupaten Gianyar',
                '5105' => 'Kabupaten Klungkung',
                '5106' => 'Kabupaten Bangli',
                '5107' => 'Kabupaten Karangasem',
                '5108' => 'Kabupaten Buleleng',
                '5171' => 'Kota Denpasar',
                '5201' => 'Kabupaten Lombok Barat',
                '5202' => 'Kabupaten Lombok Tengah',
                '5203' => 'Kabupaten Lombok Timur',
                '5204' => 'Kabupaten Sumbawa',
                '5205' => 'Kabupaten Dompu',
                '5206' => 'Kabupaten Bima',
                '5207' => 'Kabupaten Sumbawa Barat',
                '5271' => 'Kota Mataram',
                '5272' => 'Kota Bima',
                  '5301' => 'Kabupaten Kupang',
                '5302' => 'Kabupaten Timor Tengah Selatan',
                '5303' => 'Kabupaten Timor Tengah Utara',
                '5304' => 'Kabupaten Belu',
                '5305' => 'Kabupaten Alor',
                '5306' => 'Kabupaten Flores Timur',
                '5307' => 'Kabupaten Sikka',
                '5308' => 'Kabupaten Ende',
                '5309' => 'Kabupaten Ngada',
                '5310' => 'Kabupaten Manggarai',
                '5311' => 'Kabupaten Manggarai Barat',
                '5312' => 'Kabupaten Nagekeo',
                '5313' => 'Kabupaten Manggarai Timur',
                '5314' => 'Kabupaten Sumba Barat',
                '5315' => 'Kabupaten Sumba Timur',
                '5316' => 'Kabupaten Lembata',
                '5317' => 'Kabupaten Rote Ndao',
                '5318' => 'Kabupaten Sabu Raijua',
                '5319' => 'Kabupaten Malaka',
                '5371' => 'Kota Kupang',
                 '6101' => 'Kabupaten Sambas',
                '6102' => 'Kabupaten Bengkayang',
                '6103' => 'Kabupaten Landak',
                '6104' => 'Kabupaten Melawi',
                '6105' => 'Kabupaten Sanggau',
                '6106' => 'Kabupaten Ketapang',
                '6107' => 'Kabupaten Sintang',
                '6108' => 'Kabupaten Kapuas Hulu',
                '6109' => 'Kabupaten Sekadau',
                '6110' => 'Kabupaten Melawi',
                '6111' => 'Kabupaten Kayong Utara',
                '6171' => 'Kota Pontianak',
                '6172' => 'Kota Singkawang',
                // Tambahkan sesuai kebutuhan
            ],
            'kec' => [
                '110101' => 'Bakongan',
    '110102' => 'Kluet Utara',
    '110103' => 'Kluet Selatan',
    '110104' => 'Labuhan Haji',
    '110105' => 'Meukek',
    '110106' => 'Samadua',
    '110107' => 'Sawang',
    '110108' => 'Tapaktuan',
    '110109' => 'Trumon',
    '110110' => 'Pasi Raja',
    '110111' => 'Labuhan Haji Timur',
    '110112' => 'Labuhan Haji Barat',
    '110113' => 'Kluet Tengah',
    '110114' => 'Kluet Timur',
    '110115' => 'Bakongan Timur',
    '110116' => 'Trumon Timur',
    '110117' => 'Kota Bahagia',
    '110118' => 'Trumon Tengah',
    '110201' => 'Lawe Alas',
    '110202' => 'Lawe Sigala-Gala',
    '110203' => 'Bambel',
    '110204' => 'Babussalam',
    '110205' => 'Badar',
    '110206' => 'Babul Makmur',
    '110207' => 'Darul Hasanah',
    '110208' => 'Lawe Bulan',
    '110209' => 'Bukit Tusam',
    '110210' => 'Semadam',
    '110211' => 'Babul Rahmah',
    '110212' => 'Ketambe',
    '110213' => 'Deleng Pokhkisen',
    '110214' => 'Lawe Sumur',
    '110215' => 'Tanoh Alas',
    '110216' => 'Leuser',
    '110301' => 'Darul Aman',
    '110302' => 'Julok',
    '110303' => 'Idi Rayeuk',
    '110304' => 'Birem Bayeun',
    '110305' => 'Serbajadi',
    '110306' => 'Nurussalam',
    '110307' => 'Peureulak',
    '110308' => 'Rantau Selamat',
    '110309' => 'Simpang Ulim',
    '110310' => 'Rantau Peureulak',
    '110311' => 'Pante Bidari',
    '110312' => 'Madat',
    '110313' => 'Indra Makmu',
    '110314' => 'Idi Tunong',
    '110315' => 'Banda Alam',
    '110316' => 'Peudawa',
    '110317' => 'Peureulak Timur',
    '110318' => 'Peureulak Barat',
    '110319' => 'Sungai Raya',
    '110320' => 'Simpang Jernih',
    '110321' => 'Darul Ihsan',
    '110322' => 'Darul Falah',
    '110323' => 'Idi Timur',
    '110324' => 'Peunaron',
    '110401' => 'Linge',
    '110402' => 'Silih Nara',
    '110403' => 'Bebesen',
    '110407' => 'Pegasing',
    '110408' => 'Bintang',
    '110410' => 'Ketol',
                // Tambahkan sesuai kebutuhan
            ],
            'des_kel' => [
                 '1101012001' => 'Keude Bakongan',
    '1101012002' => 'Ujung Mangki',
    '1101012003' => 'Ujung Padang',
    '1101012004' => 'Kampong Drien',
    '1101012015' => 'Darul Ikhsan',
    '1101012016' => 'Padang Berahan',
    '1101012017' => 'Gampong Baro',
    '1101022001' => 'Fajar Harapan',
    '1101022002' => 'Krueng Batee',
    '1101022003' => 'Pasi Kuala Asahan',
    '1101022004' => 'Gunung Pulo',
    '1101022005' => 'Pulo IE I',
    '1101022006' => 'Jambo Manyang',
    '1101022007' => 'Simpang Empat',
    '1101022008' => 'Limau Purut',
    '1101022009' => 'Pulo Kambing',
    '1101022010' => 'Kampung Paya',
    '1101022011' => 'Krueng Batu',
    '1101022012' => 'Krueng Kluet',
    '1101022013' => 'Alur Mas',
    '1101022014' => 'Simpang Dua',
    '1101022015' => 'Simpang Tiga',
    '1101022016' => 'Simpang Lhee',
    '1101022017' => 'Suag Geuringgeng',
    '1101022018' => 'Pasi Kuala Baku',
    '1101022019' => 'Kedai Padang',
    '1101022020' => 'Kotafajar',
    '1101022021' => 'Gunung Pudung',
    '1101032001' => 'Suaq Bakong',
    '1101032002' => 'Rantau Benuang',
    '1101032003' => 'Barat Daya',
    '1101032004' => 'Sialang',
    '1101032005' => 'Kapeh',
    '1101032006' => 'Pulo IE',
    '1101032007' => 'Kedai Runding',
    '1101032008' => 'Kedai Kandang',
    '1101032009' => 'Luar',
    '1101032010' => 'Ujong',
    '1101032011' => 'Jua',
    '1101032012' => 'Pasi Meurapat',
    '1101032013' => 'Ujung Pasir',
    '1101032014' => 'Geulumbuk',
    '1101032015' => 'Pasie Lambang',
    '1101032016' => 'Ujung Padang',
    '1101032017' => 'Indra Damai',
    '1101042001' => 'Bakau Hulu',
    '1101042002' => 'Padang Baku',
    '1101042003' => 'Manggis Harapan',
    '1101042004' => 'Pasar Lama',
    '1101042005' => 'Apha',
    '1101042006' => 'Ujung Batu',
    '1101042007' => 'Pawoh',
    '1101042008' => 'Dalam',
    '1101042009' => 'Kota Palak',
    '1101042010' => 'Cacang',
    '1101042011' => 'Tengoh Pisang',
    '1101042012' => 'Pisang',
    '1101042013' => 'Hulu Pisang',
    '1101042014' => 'Tengah Baru',
    '1101042015' => 'Lembah Baru',
    '1101042016' => 'Padang Baru',
    '1101052001' => 'Kuta Buloh II',
    '1101052002' => 'Kuta Buloh I',
    '1101052003' => 'IE Dingin',
    '1101052004' => 'Drien Jalo',
    '1101052005' => 'Jambo Papeun',
    '1101052006' => 'Buket Mas',
    '1101052007' => 'Blang Kuala',
    '1101052008' => 'Rot Teungoh',
    '1101052009' => 'Alue Baro',
    '1101052010' => 'Ladang Tuha',
    '1101052011' => 'Lhok Mamplam',
    '1101052012' => 'Aron Tunggai',
    '1101052013' => 'Blang Teungoh',
    '1101052014' => 'Blang Bladeh',
    '1101052015' => 'IE Buboh',
                // Tambahkan sesuai kebutuhan
            ],
        ];
    @endphp

    @if ($logs->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            Belum ada riwayat aktivitas yang tercatat.
        </div>
    @else
        <div class="log-feed">
            @php $seenCreatedAt = []; @endphp

            @foreach ($logs as $log)
                @php
                    if (in_array($log->created_at, $seenCreatedAt)) continue;
                    $seenCreatedAt[] = $log->created_at;

                    $oldData = is_string($log->old_data) ? json_decode($log->old_data, true) : ($log->old_data ?? []);
                    $newData = is_string($log->new_data) ? json_decode($log->new_data, true) : ($log->new_data ?? []);
                    $changes = [];

                    foreach ($newData as $key => $newValue) {
                        $oldValue = $oldData[$key] ?? null;

                        if ($oldValue === $newValue || (empty($oldValue) && empty($newValue))) continue;

                        switch (true) {
                            case $key === 'lamp_foto_karyawan':
                                $changes[] = "
                                    <strong>Foto Karyawan:</strong><br>
                                    <div class='photo-comparison'>
                                        <img src='/storage/{$oldValue}' alt='Foto Sebelum' class='employee-photo clickable' data-img='/storage/{$oldValue}'>
                                        <span>→</span>
                                        <img src='/storage/{$newValue}' alt='Foto Setelah' class='employee-photo clickable' data-img='/storage/{$newValue}'>
                                    </div>";
                                break;

                            case preg_match('/^(lamp_|avatar_karyawan)/', $key):
                                $lampiranFields = [
                                    'lamp_foto_karyawan' => 'Foto Karyawan',
                                    'lamp_ktp' => 'KTP',
                                    'lamp_sk_kartap' => 'SK Kartap',
                                    'lamp_sk_promut' => 'SK Promosi/Mutasi',
                                    'lamp_kontrak' => 'Kontrak Kerja',
                                    'lamp_buku_nikah' => 'Buku Nikah',
                                    'lamp_kk' => 'Kartu Keluarga',
                                    'lamp_ktp_pasangan' => 'KTP Pasangan',
                                    'lamp_akta_1' => 'Akta Anak 1',
                                    'lamp_akta_2' => 'Akta Anak 2',
                                    'lamp_akta_3' => 'Akta Anak 3',
                                    'lamp_bpjs_kes' => 'BPJS Kesehatan',
                                    'lamp_bpjs_tk' => 'BPJS Ketenagakerjaan',
                                    'lamp_kartu_npwp' => 'Kartu NPWP',
                                    'lamp_buku_rekening' => 'Buku Rekening',
                                    'avatar_karyawan' => 'Foto Profil',
                                ];

                                $oldFileName = $oldValue ? pathinfo($oldValue, PATHINFO_BASENAME) : null;
                                $newFileName = $newValue ? pathinfo($newValue, PATHINFO_BASENAME) : null;

                                $oldBtn = $oldValue
                                    ? "<button class='btn btn-outline-secondary btn-sm' data-bs-toggle='modal' data-bs-target='#fileModal' data-file='/storage/{$oldValue}' data-file-name='{$oldFileName}'>📄 Lampiran Sebelumnya</button>"
                                    : '';

                                $newBtn = $newValue
                                    ? "<button class='btn btn-outline-primary btn-sm' data-bs-toggle='modal' data-bs-target='#fileModal' data-file='/storage/{$newValue}' data-file-name='{$newFileName}'>🆕 Lampiran Baru</button>"
                                    : '';

                                $buttonGroup = ($oldBtn || $newBtn)
                                    ? "<div class='btn-group mt-2' role='group'>{$oldBtn}{$newBtn}</div>"
                                    : '';

                                $label = $lampiranFields[$key] ?? 'Lampiran';

                                $changes[] = "<strong>Lampiran {$label}:</strong><br>{$buttonGroup}";
                                break;

                            case in_array($key, ['prov', 'kab_kot', 'kec', 'des_kel']):
                                $label = match ($key) {
                                    'prov' => 'Provinsi',
                                    'kab_kot' => 'Kabupaten/Kota',
                                    'kec' => 'Kecamatan',
                                    'des_kel' => 'Desa/Kelurahan',
                                };

                                $oldLabel = $wilayahMapping[$key][$oldValue] ?? $oldValue;
                                $newLabel = $wilayahMapping[$key][$newValue] ?? $newValue;

                                $changes[] = "<strong>{$label}:</strong> 
                                    <span class='old-value'>{$oldLabel}</span> → 
                                    <span class='new-value'>{$newLabel}</span>";
                                break;

                            default:
                                $changes[] = "<strong>" . ucfirst(str_replace('_', ' ', $key)) . "</strong>: 
                                    <span class='old-value'>" . ($oldValue ?? '-') . "</span> → 
                                    <span class='new-value'>" . ($newValue ?? '-') . "</span>";
                        }
                    }
                @endphp

                <div class="card mb-4 shadow-sm rounded-lg" data-log-id="{{ $log->id }}">
                    <div class="card-header d-flex justify-content-between align-items-center p-3">
                        <div class="d-flex align-items-center">
                            <div class="ms-3">
                                <span class="fw-bold">{{ Auth::user()->name }}</span><br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}</small><br>
                                <span class="log-user">{{ $log->dataPegawai->nama_lengkap ?? 'Pegawai Tidak Diketahui' }}</span>
                            </div>
                        </div>

                        <div class="badge-group">
                            @if ($log->validation_status === 'approved')
                                <span class="badge bg-success text-white">✅ Diterima</span>
                            @elseif ($log->validation_status === 'rejected')
                                <span class="badge bg-danger text-white">❌ Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">⏳ Menunggu Validasi</span>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $log->name }}</h5>
                        <p class="card-text"><strong>Hobi:</strong> {{ $log->hobi }}</p>

                        @if ($log->lampiran && is_string($log->lampiran))
                            <div class="attachment mb-3">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#fileModal" data-file="{{ Storage::url($log->lampiran) }}" data-file-name="{{ pathinfo($log->lampiran, PATHINFO_BASENAME) }}">Lihat Lampiran</button>
                            </div>
                        @endif

                        @if (!empty($changes))
                            <ul class="list-unstyled mt-3">
                                @foreach ($changes as $change)
                                    <li class="log-item py-2 border-bottom">{!! $change !!}</li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Tidak ada perubahan signifikan yang tercatat.</p>
                        @endif

                        @if ($log->validation_status === 'pending' && Auth::user()->role === 'admin')
                            <div class="validation-actions mt-3">
                                <button class="btn btn-success btn-sm validate-btn" data-id="{{ $log->id }}" data-status="approved">✅ Approve</button>
                                <button class="btn btn-danger btn-sm validate-btn" data-id="{{ $log->id }}" data-status="rejected">❌ Reject</button>
                            </div>
                        @endif

                        <div class="like-section mt-3">
                            <button class="btn btn-outline-primary like-btn {{ ($log->likes && $log->likes->where('user_id', Auth::id())->isNotEmpty()) ? 'active' : '' }}" data-log-id="{{ $log->id }}">
                                ❤️ <span class="like-count">{{ $log->likes ? $log->likes->count() : 0 }}</span> {{ ($log->likes && $log->likes->where('user_id', Auth::id())->isNotEmpty()) ? 'Unlike' : 'Like' }}
                            </button>
                        </div>

                        <div class="comment-section mt-4">
                            <form action="{{ route('logs.comment', $log->id) }}" method="POST" id="comment-form-{{ $log->id }}">
                                @csrf
                                <div class="input-group">
                                    <input type="text" name="comment" class="form-control" placeholder="Tulis komentar..." required>
                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                </div>
                            </form>

                            <ul class="comments mt-3">
                                @foreach ($log->comments as $comment)
                                    <li class="comment-item mb-2">
                                        <strong>{{ $comment->user->dataPegawai->nama_lengkap ?? 'User Tidak Diketahui' }}:</strong>
                                        <span class="comment-text">{{ $comment->comment }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-center">
                {{ $logs->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>


<!-- Modal for Viewing Attachments -->
<div class="modal fade" id="fileModal" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">Lampiran File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div id="fileContent" class="text-center">
                    <!-- Akan diisi lewat JS -->
                </div>
            </div>
            <div class="modal-footer">
                <!-- Tombol download file akan muncul otomatis via JS -->
                <a href="#" id="downloadFileBtn" class="btn btn-primary" download target="_blank" style="display:none;">Download File</a>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Enlarged Images -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body p-0">
                <img src="" id="modalImage" class="img-fluid w-100" alt="Enlarged Image">
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap JS (Bootstrap 5) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // CSRF setup for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Handle file modal when clicking on attachment button
    $('#fileModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var fileUrl = button.data('file');
        var fileName = button.data('file-name');
        var fileExtension = fileName.split('.').pop().toLowerCase();

        var content = '';
        var downloadBtn = $('#downloadFileBtn');

        if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
            content = '<img src="' + fileUrl + '" class="img-fluid" alt="Lampiran Gambar">';
        } else if (fileExtension === 'pdf') {
            content = '<iframe src="' + fileUrl + '" class="w-100" style="height:500px;" frameborder="0"></iframe>';
        } else {
            content = '<p>Tidak dapat menampilkan preview file ini.</p>';
        }

        $('#fileContent').html(content);
        downloadBtn.attr('href', fileUrl);
        downloadBtn.attr('download', fileName);
        downloadBtn.show();
    });

    // Like functionality
    $(document).on('click', '.like-btn', function() {
        var button = $(this);
        var logId = button.data('log-id');

        $.ajax({
            url: '/logs/' + logId + '/like',
            type: 'POST',
            success: function(response) {
                let newLikes = response.likes;
                if (response.status === 'liked') {
                    button.addClass('active').html('❤️ Unlike <span class="like-count">' + newLikes + '</span>');
                } else {
                    button.removeClass('active').html('❤️ Like <span class="like-count">' + newLikes + '</span>');
                }
            },
            error: function() {
                alert("Gagal memperbarui like. Silakan coba lagi.");
            }
        });
    });

    // Validate logs (for admin)
    $(document).on('click', '.validate-btn', function() {
        var logId = $(this).data('id');
        var status = $(this).data('status');

        $.ajax({
            url: '/logs/' + logId + '/validate',
            type: 'POST',
            data: { status: status },
            success: function() {
                alert('Validasi berhasil: ' + status);
                location.reload();
            },
            error: function() {
                alert("Gagal memvalidasi. Coba lagi.");
            }
        });
    });

    // Comment submission
    $(document).on('submit', '.comment-section form', function(e) {
        e.preventDefault();
        var form = $(this);
        var formData = form.serialize();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            success: function() {
                form.find('input[name="comment"]').val('');
                location.reload();
            },
            error: function() {
                alert("Gagal menambahkan komentar. Coba lagi.");
            }
        });
    });

    // Tambahan: Tombol default "📎 Lihat Lampiran" dibungkus rapi
    $(document).on('click', '.attachment-button', function() {
        var fileUrl = $(this).data('file');
        var fileName = $(this).data('file-name');

        $('#fileModal').modal('show');
        $('#fileModal').on('shown.bs.modal', function () {
            var ext = fileName.split('.').pop().toLowerCase();
            let html = '';
            if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                html = `<img src="${fileUrl}" class="img-fluid" alt="${fileName}">`;
            } else if (ext === 'pdf') {
                html = `<iframe src="${fileUrl}" class="w-100" style="height:500px;" frameborder="0"></iframe>`;
            } else {
                html = `<p>Tidak dapat menampilkan preview file ini.</p>`;
            }

            $('#fileContent').html(html);
            $('#downloadFileBtn').attr('href', fileUrl).attr('download', fileName).show();
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const fileModal = document.getElementById('fileModal');
    fileModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const fileUrl = button.getAttribute('data-file');
        const fileName = button.getAttribute('data-file-name');
        const fileContent = document.getElementById('fileContent');
        const downloadBtn = document.getElementById('downloadFileBtn');

        if (/\.(jpg|jpeg|png|gif)$/i.test(fileUrl)) {
            fileContent.innerHTML = `<img src="${fileUrl}" class="img-fluid" alt="${fileName}">`;
        } else if (/\.pdf$/i.test(fileUrl)) {
            fileContent.innerHTML = `<iframe src="${fileUrl}" class="w-100" style="height:500px;" frameborder="0"></iframe>`;
        } else {
            fileContent.innerHTML = `<p>Tidak dapat menampilkan preview file ini.</p>`;
        }

        downloadBtn.href = fileUrl;
        downloadBtn.download = fileName;
        downloadBtn.style.display = 'inline-block';
    });

    // Zoomable image view
    document.querySelectorAll('.clickable').forEach(img => {
        img.addEventListener('click', function () {
            const src = this.getAttribute('data-img');
            const modalImg = document.getElementById('modalImage');
            modalImg.src = src;
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        });
    });
});
</script>



<style>
/* ===================================
   RESET & BASE STYLES
=================================== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    color: #2c3e50;
    line-height: 1.7;
    font-size: 18px;
}

/* ===================================
   CONTAINER & GENERAL LAYOUT
=================================== */
.container {
    max-width: 1200px;
    margin: 50px auto;
    padding: 50px;
    background-color: #ffffff;
    border-radius: 20px;
    box-shadow: 0 15px 60px rgba(0, 0, 0, 0.05);
}

/* ===================================
   HEADINGS & TITLES
=================================== */
.heading-primary {
    text-align: center;
    font-size: 3rem;
    font-weight: 800;
    color: #2c3e50;
    margin-bottom: 50px;
}

/* ===================================
   LOG FEED
=================================== */
.log-feed {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

/* ===================================
   LOG CARD
=================================== */
.log-card {
    background: #ffffff;
    padding: 35px;
    border-radius: 16px;
    box-shadow: 0 6px 30px rgba(0, 0, 0, 0.07);
    transition: all 0.3s ease;
}

.log-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
}

/* ===================================
   LOG HEADER
=================================== */
.log-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.log-info {
    display: flex;
    align-items: center;
    gap: 20px;
}

.profile-photo {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
}

.log-user-info {
    display: flex;
    flex-direction: column;
}

.log-user {
    font-size: 20px;
    font-weight: 700;
    color: #3498db;
}

.log-time {
    font-size: 16px;
    color: #7f8c8d;
}

.log-action {
    font-size: 18px;
    font-weight: 700;
    color: #27ae60;
}

/* ===================================
   LOG CONTENT
=================================== */
.log-body {
    margin-top: 25px;
}

.log-description {
    font-size: 18px;
    color: #444;
}

.log-changes {
    margin-top: 25px;
    padding: 25px;
    background-color: #f4f6f8;
    border-radius: 12px;
    list-style: none;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
}

.log-item {
    margin-bottom: 16px;
    font-size: 17px;
    color: #2c3e50;
}

.old-value {
    color: #e74c3c;
}

.new-value {
    color: #2ecc71;
}

/* ===================================
   BUTTONS
=================================== */
.btn,
.like-btn,
.page-btn,
.validate-btn,
.comment-section button,
.input-group button,
.toggle-attachment-btn {
    display: inline-block;
    padding: 14px 28px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.like-btn {
    background-color: #ff5722;
    color: #fff;
}

.like-btn.liked {
    background-color: #e74c3c;
}

.page-btn {
    background-color: #2980b9;
    color: #fff;
    margin: 0 6px;
}

.page-btn.active {
    background-color: #2ecc71;
}

.comment-section button,
.input-group button {
    background-color: #27ae60;
    color: #fff;
}

.validate-btn.approve {
    background-color: #2ecc71;
    color: white;
}

.validate-btn.reject {
    background-color: #e74c3c;
    color: white;
}

.toggle-attachment-btn {
    background-color: #8e44ad;
    color: white;
    margin-bottom: 10px;
}

.btn:hover,
.page-btn:hover,
.like-btn:hover,
.validate-btn:hover,
.comment-section button:hover,
.input-group button:hover,
.toggle-attachment-btn:hover {
    opacity: 0.9;
}

/* ===================================
   PAGINATION
=================================== */
.pagination-container {
    margin-top: 50px;
    text-align: center;
}

/* ===================================
   COMMENT SECTION
=================================== */
.comment-section {
    margin-top: 35px;
}

.comment-section form {
    display: flex;
    gap: 15px;
}

.comment-section input,
.input-group input {
    flex: 1;
    padding: 16px;
    border: 1px solid #ccc;
    border-radius: 10px;
    font-size: 16px;
    color: #333;
    background-color: #fff;
}

.comment-section ul {
    margin-top: 25px;
    list-style: none;
    padding: 0;
}

.comment-item {
    background-color: #f9f9f9;
    padding: 18px;
    border-radius: 10px;
    margin-bottom: 18px;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
}

.comment-item strong {
    color: #2980b9;
}

/* ===================================
   BADGES & LABELS
=================================== */
.badge-group {
    display: flex;
    gap: 10px;
    font-size: 14px;
}

.badge-group span {
    padding: 8px 18px;
    border-radius: 25px;
    color: #fff;
    font-weight: 600;
}

.badge-success {
    background-color: #2ecc71;
}

.badge-danger {
    background-color: #e74c3c;
}

.badge-warning {
    background-color: #f39c12;
}

/* ===================================
   ATTACHMENTS with TOGGLE BUTTON
=================================== */
.attachment {
    margin-top: 20px;
    padding: 0;
    background-color: #f4f6f8;
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    transition: max-height 0.4s ease, padding 0.4s ease;
}

.attachment-content {
    padding: 20px;
    display: none;
}

/* Active state */
.attachment.open .attachment-content {
    display: block;
}

/* ===================================
   MODAL
=================================== */
.modal-content {
    border-radius: 12px;
    border: 2px solid #2980b9;
}

.modal-header {
    background-color: #2980b9;
    color: white;
    font-weight: 700;
    padding: 20px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.modal-body {
    padding: 25px;
    font-size: 18px;
}

.modal-footer {
    border-top: 1px solid #ddd;
    padding: 15px;
}

/* ===================================
   PHOTOS & COMPARISONS
=================================== */
.employee-photo {
    width: 110px;
    height: 110px;
    object-fit: cover;
    border-radius: 12px;
    cursor: pointer;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.1);
}

.photo-comparison {
    display: flex;
    gap: 20px;
    align-items: center;
}

/* ===================================
   TOOLTIP
=================================== */
.tooltip {
    position: absolute;
    background-color: #333;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 13px;
    z-index: 1000;
}
.tooltip::after {
    content: '';
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #333 transparent transparent transparent;
}
</style>


<!-- sosial media -->
<!-- <div class="container py-5">
    <div class="row">
        <div class="col-md-9"> -->

    <!-- Layanan Unggulan untuk Pegawai
    @if(Auth::user()->role == 'user')
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4 text-center">Layanan Unggulan untuk Pegawai</h3>
        </div>

        Manajemen Data Pegawai -->
        <!-- <div class="col-md-6 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-file-earmark-person p-3" style="font-size: 3rem; color: #17a2b8;"></i>
                <div class="card-body">
                    <h5 class="card-title">Manajemen Data Pegawai</h5>
                    <p class="card-text">Kelola data pegawai dengan lebih efektif dan efisien.</p>
                    <a href="/data-pegawai" class="btn btn-primary btn-sm">Lihat Data</a>
                </div>
            </div>
        </div> -->

        <!-- Penyusunan Rencana -->
        <!-- <div class="col-md-6 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-card-checklist p-3" style="font-size: 3rem; color: #6610f2;"></i>
                <div class="card-body">
                    <h5 class="card-title">Penyusunan Rencana</h5>
                    <p class="card-text">Rencanakan proyek Anda dengan lebih terstruktur dan efisien.</p>
                    <a href="{{ route('plans.index') }}" class="btn btn-primary btn-sm">Baca Selengkapnya</a>
                </div>
            </div>
        </div> -->

        <!-- Kantor Telkom Property dan Performance Tracking -->
        <!-- <div class="row mb-5">
            <div class="col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <i class="bi bi-building p-3" style="font-size: 3rem; color: #ffc107;"></i>
                    <div class="card-body">
                        <h5 class="card-title">Kantor Telkom Property</h5>
                        <p class="card-text">Akses informasi terkait properti dan fasilitas kantor Telkom.</p>
                        <a href="{{ route('property.index') }}" class="btn btn-success btn-sm">Lihat Properti</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm">
                    <i class="bi bi-bar-chart-line p-3" style="font-size: 3rem; color: #28a745;"></i>
                    <div class="card-body">
                        <h5 class="card-title">Pelacakan Kinerja</h5>
                        <p class="card-text">Pantau kinerja dan progres pekerjaan Anda dan tim.</p>
                        <a href="{{ route('performance.index') }}" class="btn btn-success btn-sm">Lihat Laporan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif -->

    <!-- Layanan Unggulan untuk Admin -->
    <!-- @if(Auth::user()->role == 'admin')
    <div class="row mb-5">
        <div class="col-12">
            <h3 class="mb-4 text-center">Layanan Unggulan untuk Admin</h3>
        </div> -->

        <!-- User Management -->
        <!-- <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-person-check p-3" style="font-size: 3rem; color: #17a2b8;"></i>
                <div class="card-body">
                    <h5 class="card-title">Manajemen Pengguna</h5>
                    <p class="card-text">Kelola pengguna dan role untuk memastikan akses yang tepat.</p>
                    <a href="register" class="btn btn-primary btn-sm">Kelola Pengguna</a>
                </div>
            </div>
        </div> -->

        <!-- Performance Tracking for Admin -->
        <!-- <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-bar-chart-line p-3" style="font-size: 3rem; color: #28a745;"></i>
                <div class="card-body">
                    <h5 class="card-title">Pelacakan Kinerja Pegawai</h5>
                    <p class="card-text">Pantau kinerja seluruh pegawai dan ambil tindakan berdasarkan data.</p>
                    <a href="{{ route('admin.performance.index') }}" class="btn btn-success btn-sm">Lihat Laporan</a>
                </div>
            </div>
        </div> -->

        <!-- Kantor Telkom Property -->
        <!-- <div class="col-md-4 mb-4">
            <div class="card text-center border-0 shadow-sm">
                <i class="bi bi-building p-3" style="font-size: 3rem; color: #ffc107;"></i>
                <div class="card-body">
                    <h5 class="card-title">Kantor Telkom Property</h5>
                    <p class="card-text">Akses informasi terkait properti dan fasilitas kantor Telkom.</p>
                    <a href="{{ route('property.index') }}" class="btn btn-success btn-sm">Lihat Properti</a>
                </div>
            </div>
        </div>
    </div>
    @endif -->


        <!-- Data Pegawai Fitur Tambahan -->
    <!-- <div class="row mt-5">
        <div class="col-12">


<div class="container py-5">
    <div class="row justify-content-center"> -->
<!-- Informasi Telkom Property -->
<!-- <div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10"> -->
            <!-- Heading Section -->
            <!-- <h2 class="text-center mb-4 font-weight-bold animate-on-scroll">Informasi Telkom Property</h2>
            <p class="text-center text-muted animate-on-scroll">
                <strong>Telkom Property</strong> adalah unit strategis dari PT Telkom Indonesia yang berfokus pada pengelolaan, pengembangan, dan optimalisasi properti perusahaan. Kami memiliki pengalaman bertahun-tahun untuk menyediakan solusi properti terbaik untuk mendukung bisnis Anda, mulai dari manajemen aset hingga pengembangan infrastruktur modern dan ramah lingkungan.
            </p> -->

            <!-- Features Section -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Fitur Utama Telkom Property</h4>
                <ul class="list-group list-group-flush animate-on-scroll">
                    <li class="list-group-item">
                        <strong>Penyewaan Ruang Kantor:</strong> Ruang kantor fleksibel dan modern yang dilengkapi dengan teknologi terkini dan fasilitas pendukung.
                    </li>
                    <li class="list-group-item">
                        <strong>Pengelolaan Properti:</strong> Layanan komprehensif untuk menjaga properti Anda dalam kondisi optimal, termasuk keamanan, kebersihan, dan manajemen operasional.
                    </li>
                    <li class="list-group-item">
                        <strong>Pengembangan Infrastruktur:</strong> Solusi pembangunan infrastruktur berstandar tinggi untuk memenuhi kebutuhan bisnis Anda.
                    </li>
                    <li class="list-group-item">
                        <strong>Properti Komersial:</strong> Properti strategis untuk sektor bisnis dan retail dengan desain modern dan lokasi premium.
                    </li>
                    <li class="list-group-item">
                        <strong>Manajemen Aset:</strong> Optimalisasi penggunaan aset untuk memberikan nilai tambah maksimal dengan pendekatan yang efisien.
                    </li>
                    <li class="list-group-item">
                        <strong>Solusi Smart Building:</strong> Teknologi pintar yang menciptakan lingkungan kerja yang hemat energi, aman, dan produktif.
                    </li>
                    <li class="list-group-item">
                        <strong>Layanan Custom:</strong> Paket layanan yang dapat disesuaikan untuk memenuhi kebutuhan unik klien kami.
                    </li>
                </ul>
            </div> -->

            <!-- Why Choose Us Section -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Kenapa Memilih Telkom Property?</h4>
                <div class="row text-center">
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-geo-alt-fill text-danger" style="font-size: 3rem;"></i>
                        <p><strong>Lokasi Strategis</strong><br>Properti di pusat bisnis utama Indonesia.</p>
                    </div>
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-building text-primary" style="font-size: 3rem;"></i>
                        <p><strong>Fasilitas Modern</strong><br>Fasilitas lengkap untuk mendukung produktivitas.</p>
                    </div>
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-people-fill text-success" style="font-size: 3rem;"></i>
                        <p><strong>Tim Profesional</strong><br>Dukungan ahli terbaik di bidangnya.</p>
                    </div>
                    <div class="col-md-3 animate-on-scroll">
                        <i class="bi bi-tree-fill text-warning" style="font-size: 3rem;"></i>
                        <p><strong>Keberlanjutan</strong><br>Komitmen pada pengelolaan ramah lingkungan.</p>
                    </div>
                </div>
            </div> -->

            <!-- Additional Benefits -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Keunggulan Lainnya</h4>
                <ul class="list-group list-group-flush animate-on-scroll">
                    <li class="list-group-item">
                        <strong>Jaringan Nasional:</strong> Cakupan layanan di berbagai kota besar Indonesia.
                    </li>
                    <li class="list-group-item">
                        <strong>Harga Kompetitif:</strong> Solusi properti berkualitas dengan harga terbaik.
                    </li>
                    <li class="list-group-item">
                        <strong>Inovasi Teknologi:</strong> Pemanfaatan teknologi terkini untuk efisiensi maksimal.
                    </li>
                    <li class="list-group-item">
                        <strong>Komitmen pada Keamanan:</strong> Penggunaan sistem keamanan berteknologi tinggi untuk melindungi properti dan penghuninya.
                    </li>
                    <li class="list-group-item">
                        <strong>Penyewaan Fleksibel:</strong> Kami menawarkan pilihan penyewaan jangka panjang dan jangka pendek untuk memenuhi kebutuhan Anda.
                    </li>
                </ul>
            </div> -->

            <!-- Contact Section -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Hubungi Kami</h4>
                <p class="text-center animate-on-scroll">
                    Dapatkan informasi lebih lanjut dan diskusikan kebutuhan Anda:
                    <br>
                    <strong>Email:</strong> info@telkomproperty.co.id<br>
                    <strong>Telepon:</strong> (021) 1234 5678<br>
                    <strong>Website:</strong> <a href="https://telkomproperty.co.id" target="_blank">www.telkomproperty.co.id</a>
                </p>
            </div> -->

            <!-- Location Section -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Lokasi Kami</h4>
                <p class="text-center text-muted animate-on-scroll">Kantor Pusat: Jl. Jendral Gatot Subroto No. 52, Jakarta Selatan, Indonesia.</p>
                <div id="map" style="height: 400px; border-radius: 10px; overflow: hidden;" class="animate-on-scroll"> -->
                    <!-- Integrate Google Maps -->
                    <!-- <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1980.6922719579117!2d106.8189658!3d-6.2157426!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e431d07dbd%3A0x57b218aef1c89614!2sTelkom%20Indonesia!5e0!3m2!1sen!2sid!4v1610635732436!5m2!1sen!2sid" 
                        width="100%" 
                        height="400" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div> -->

            <!-- Contact Form Section -->
            <!-- <div class="mt-5">
                <h4 class="text-center mb-4 font-weight-bold animate-on-scroll">Ajukan Pertanyaan atau Permintaan Informasi</h4>
                <form class="animate-on-scroll">
                    <div class="form-group">
                        <label for="name">Nama Lengkap:</label>
                        <input type="text" class="form-control" id="name" placeholder="Masukkan nama Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" placeholder="Masukkan email Anda" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Pesan:</label>
                        <textarea class="form-control" id="message" rows="5" placeholder="Tuliskan pesan atau pertanyaan Anda" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div> -->

<!-- Animasi Scroll -->
<!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const scrollElements = document.querySelectorAll(".animate-on-scroll");

        const elementInView = (el, dividend = 1) => {
            const elementTop = el.getBoundingClientRect().top;
            return (
                elementTop <=
                (window.innerHeight || document.documentElement.clientHeight) / dividend
            );
        };

        const displayScrollElements = () => {
            scrollElements.forEach((el) => {
                if (elementInView(el, 1.25)) {
                    el.classList.add("visible");
                }
            });
        };

        window.addEventListener("scroll", displayScrollElements);
        displayScrollElements();
    });
</script> -->

<!-- Styling -->
<!-- <style>
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style> -->

<!-- Social Media Links -->
<div class="container mt-5">
    <h5 class="text-center font-weight-bold mb-4">Media Sosial Telkom Property Regional VII</h5>
    <div class="d-flex justify-content-center flex-wrap gap-4">
        <!-- Facebook -->
        <a href="https://www.facebook.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://1.bp.blogspot.com/-E7Q8QGQi8jU/WImcvZPvYQI/AAAAAAAACTw/0Er2C5lpPrkRx_JMFTMU0ifRdjS3e4XJQCLcB/s1600/VEKTOR+ICON7.png" 
                alt="Facebook" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">Facebook</p>
        </a>

        <!-- Instagram -->
        <a href="https://www.instagram.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.oXKWfypMEAC8DMHWoHgo_wHaEK?rs=1&pid=ImgDetMain" 
                alt="Instagram" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">Instagram</p>
        </a>

        <!-- Twitter -->
        <a href="https://twitter.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.2sCQHLnz7YjsueYw8eZkVAHaHa?rs=1&pid=ImgDetMain" 
                alt="Twitter" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">Twitter</p>
        </a>

        <!-- LinkedIn -->
        <a href="https://linkedin.com/company/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.2yeDXMP6_FIR2c2fpGRBXQHaHa?pid=ImgDet&rs=1" 
                alt="LinkedIn" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">LinkedIn</p>
        </a>

        <!-- YouTube -->
        <a href="https://www.youtube.com/telkomproperty" target="_blank" class="social-link text-decoration-none text-center mx-3 animate-on-scroll">
            <img src="https://th.bing.com/th/id/OIP.Bd3xtstXKpDH3jIlXyqN3AHaHa?pid=ImgDet&rs=1" 
                alt="YouTube" 
                class="social-icon rounded-circle border border-3">
            <p class="mt-2 text-dark fw-bold">YouTube</p>
        </a>
    </div>
</div>

<!-- Styling -->
<style>
    .social-link {
        text-decoration: none;
        display: inline-block;
        width: 100px; /* Fixed width for uniformity */
    }

    .social-icon {
        width: 60px;
        height: 60px;
        object-fit: contain;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .social-icon:hover {
        transform: scale(1.2); /* Zoom effect */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow on hover */
    }

    .gap-4 {
        gap: 20px; /* Spacing between social media icons */
    }

    .d-flex {
        display: flex;
    }

    .justify-content-center {
        justify-content: center;
    }

    .flex-wrap {
        flex-wrap: wrap;
    }

    .text-decoration-none {
        text-decoration: none !important;
    }

    .fw-bold {
        font-weight: bold;
    }

    .text-dark {
        color: #333;
    }

    /* Animations */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: opacity 0.6s ease, transform 0.6s ease;
    }

    .animate-on-scroll.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<!-- Script -->
<script>
    // Add scroll event listener
    document.addEventListener("DOMContentLoaded", function () {
        const items = document.querySelectorAll(".animate-on-scroll");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");
                        observer.unobserve(entry.target); // Stop observing once animated
                    }
                });
            },
            {
                threshold: 0.1, // Trigger when 10% of the element is visible
            }
        );

        items.forEach((item) => observer.observe(item));
    });
</script>



<script>
    // Initialize Google Maps
    function initMap() {
        const telkomPropertyLocation = { lat: -6.200000, lng: 106.816666 }; // Ganti dengan koordinat lokasi Telkom Property yang tepat
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 12,
            center: telkomPropertyLocation,
        });
        const marker = new google.maps.Marker({
            position: telkomPropertyLocation,
            map: map,
            title: "Telkom Property",
        });
    }

    // Google Maps API
    const googleMapsApiKey = 'YOUR_API_KEY'; // Ganti dengan kunci API Google Maps Anda
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${googleMapsApiKey}&callback=initMap`;
    script.async = true;
    script.defer = true;
    document.head.appendChild(script);

    // Weather API integration
    async function fetchWeather() {
        const city = 'Jakarta';
        const apiKey = 'YOUR_API_KEY'; // Ganti dengan kunci API cuaca Anda
        const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;

        try {
            const response = await fetch(apiUrl);
            const weatherData = await response.json();
            document.getElementById('weather-city').innerText = weatherData.name;
            document.getElementById('weather-description').innerText = weatherData.weather[0].description;
            document.getElementById('weather-temp').innerText = `${weatherData.main.temp}°C`;
        } catch (error) {
            console.error('Error fetching weather:', error);
        }
    }

    // Fetch employee data for additional features
    async function fetchEmployeeData() {
        try {
            const response = await fetch('/api/employee-count');
            const data = await response.json();
            if (data && data.count !== undefined) {
                document.getElementById('employee-count').innerText = data.count;
            } else {
                console.error('Data jumlah pegawai tidak valid');
            }
        } catch (error) {
            console.error('Gagal mengambil data jumlah pegawai:', error);
        }
    }

    // Handle click event to update employee
    document.getElementById('update-employee-count')?.addEventListener('click', async function() {
        const newCount = document.getElementById('employee-count-input')?.value;
        if (newCount === "" || isNaN(newCount)) {
            alert("Masukkan jumlah pegawai yang valid.");
            return;
        }

        try {
            const response = await fetch('/api/employee-count', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ count: newCount })
            });

            if (response.ok) {
                document.getElementById('employee-count').innerText = newCount;
                alert('Sukses memperbarui jumlah pegawai!');
            } else {
                const result = await response.json();
                alert(result.message || 'Gagal memperbarui jumlah pegawai.');
            }
        } catch (error) {
            alert('Gagal memperbarui jumlah pegawai.');
        }
    });

    // Call the fetch function when the page loads
    window.onload = function() {
        fetchWeather();
        fetchEmployeeData();
    };

    // Service Pie Chart
    const ctx = document.getElementById('serviceChart').getContext('2d');
    const serviceChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Penyusunan Rencana', 'Manajemen Data Pegawai', 'Kolaborasi Tim', 'Kantor Telkom Property'],
            datasets: [{
                label: 'Layanan Populer',
                data: [30, 20, 25, 25],
                backgroundColor: ['#6610f2', '#17a2b8', '#007bff', '#ffc107'],
                borderColor: ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                borderWidth: 2
            }]
        }
    });

    // Toggle comment form visibility
    function toggleCommentForm(postId) {
        const commentForm = document.getElementById('comment-form-' + postId);
        commentForm.style.display = commentForm.style.display === 'none' ? 'block' : 'none';
    }
</script>

@endsection

@section('styles')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
    /* Card Layout Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-body {
        background-color: #ffffff;
        border-radius: 10px;
        padding: 15px;
    }

    .card-header {
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
        margin-bottom: 15px;
        background: none;
    }

    .card-footer {
        background: none;
        border-top: 1px solid #f0f0f0;
        padding-top: 10px;
        margin-top: 15px;
    }

    /* Profile Picture and User Info Styling */
    .card-body img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }

    .d-flex {
        display: flex;
        align-items: center;
    }

    .me-3 {
        margin-right: 1rem;
    }

    .user-info {
        flex-grow: 1;
    }

    .username {
        font-size: 14px;
        font-weight: bold;
        color: #000;
        margin-bottom: 0;
    }

    .text-muted {
        font-size: 12px;
        color: #6c757d;
    }

    /* Post Content and Image Styling */
    .post-text {
        font-size: 14px;
        color: #343a40;
        margin-top: 10px;
        line-height: 1.5;
    }

    .post-image img {
        width: 100%;
        height: auto;
        max-height: 400px;
        border-radius: 10px;
        object-fit: cover;
        margin-top: 10px;
    }

    /* Input and Button Styling */
    textarea.form-control {
        border-radius: 15px;
        border: 1px solid #e0e0e0;
        box-shadow: none;
        font-size: 14px;
        padding: 10px 15px;
        resize: none;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        border-radius: 30px;
        padding: 8px 20px;
        font-size: 14px;
        background-color: #007bff;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Comment Section Styling */
    .comment-section {
        margin-top: 20px;
    }

    .comment {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }

    .comment img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 10px;
    }

    .comment-body {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 10px 15px;
        flex-grow: 1;
    }

    .comment-text {
        font-size: 14px;
        margin: 0;
        color: #495057;
    }

    .comment-meta {
        font-size: 12px;
        color: #6c757d;
        margin-top: 5px;
    }

    /* Responsive Design */
    @media (max-width: 576px) {
        .card {
            margin-bottom: 15px;
        }

        .post-image img {
            max-height: 300px;
        }

        .comment img {
            width: 35px;
            height: 35px;
        }

        .btn-primary {
            font-size: 12px;
            padding: 6px 15px;
        }
    }
</style>
@endsection
