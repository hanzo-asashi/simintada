<?php

declare(strict_types=1);

namespace App\Utilities;

use App\Models\Instansi;
use Date;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Helpers
{
    public static function generateKodeSubSkpd($instansi_id, $prefix = 'SUB', $delimiter = '-', $length = 5, $pad = '0'): string
    {
        $instansi_id = $instansi_id ?? 0;
        $instansi_id = Instansi::query()->find($instansi_id);
        $instansi_id = $instansi_id->instansi_id ?? 0;
        $max = Instansi::query()->max('instansi_id') !== 0 ? Instansi::query()->max('instansi_id') + 1 : 1;
        $pad = Str::padLeft($max, (int) $length, $pad);

        return $prefix.$delimiter.$instansi_id.$pad;
    }

    public static function generateKode(string $prefix, $delimiter = '-', $length = 5, $pad = '0'): string
    {
        $prefix = $prefix ?? 'INS';
        $max = Instansi::query()->max('instansi_id') !== 0 ? Instansi::query()->max('instansi_id') + 1 : 1;
        $pad = Str::padLeft($max, (int) $length, $pad);
        return $prefix.$delimiter.$pad;
    }

    public static function format_indonesia($nilai, $koma = false): string
    {
        if ($koma) {
            return 'Rp. '.number_format($nilai, 2, ',', '.');
        }

        return 'Rp. '.number_format($nilai, 0, ',', '.');
    }

    public static function format_angka($angka, $empty_val = '0')
    {
        $angka = self::ribuan($angka);

        return empty($angka) ? $empty_val : $angka;
    }

    public static function ribuan($num = 0, $decimal = 'auto 2')
    {
        if (empty($num)) {
            return '0';
        }
        $auto = false;
        if (str_starts_with($decimal, 'auto')) {
            [, $decimal] = explode(' ', $decimal);
            $auto = true;
        }
        $num = number_format($num, $decimal, ',', '.');
        if ($auto) {
            $num = str_replace(',00', '', $num);
        }

        return $num;
    }

    public static function hitung_pajak($nilai, $pajak): float|int
    {
        $nilai = $nilai ?? 0;
        $pajak = $pajak ?? 0;

        return $nilai * ($pajak / 100) ?? 0.00;
    }

    public static function add_nol($str, $jumnol = 2)
    {
        if (strlen($str) > $jumnol) {
            return $str;
        } else {
            $res = '';
            $n = $jumnol - strlen($str);
            $res .= str_repeat('0', $n);

            return $res.$str;
        }
    }

    public static function jumlah_hari($date): int
    {
        $date = $date ?? now();

        return Carbon::parse($date)->daysInMonth;
    }

    public static function awal_bulan($date): Carbon
    {
        $date = $date ?? now();

        return Carbon::parse($date)->startOfMonth();
    }

    public static function akhir_bulan($date): Carbon
    {
        $date = $date ?? now();

        return Carbon::parse($date)->endOfMonth();
    }

    /**
     * Convert Number to Roman
     *
     * @param  integer  $integer
     *
     * @return string
     */
    public static function convertToRoman(int $integer): string
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = [
            'M'  => 1000,
            'CM' => 900,
            'D'  => 500,
            'CD' => 400,
            'C'  => 100,
            'XC' => 90,
            'L'  => 50,
            'XL' => 40,
            'X'  => 10,
            'IX' => 9,
            'V'  => 5,
            'IV' => 4,
            'I'  => 1,
        ];

        foreach ($lookup as $roman => $value) {
            // Determine the number of matches
            $matches = intval($integer / $value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman, $matches);

            // Set the integer to be the remainder of the integer and the value
            $integer %= $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }

    public static function getRomawi($bln): string
    {
        $huruf = '';


        switch ($bln) {
            case 1:
                $huruf = 'I';
                break;
            case 2:
                $huruf = 'II';
                break;
            case 3:
                $huruf = 'III';
                break;
            case 4:
                $huruf = 'IV';
                break;
            case 5:
                $huruf = 'V';
                break;
            case 6:
                $huruf = 'VI';
                break;
            case 7:
                $huruf = 'VII';
                break;
            case 8:
                $huruf = 'VIII';
                break;
            case 9:
                $huruf = 'IX';
                break;
            case 10:
                $huruf = 'X';
                break;
            case 11:
                $huruf = 'XI';
                break;
            case 12:
                $huruf = 'XII';
                break;
        }
        return $huruf;
    }

    public static function getAvatar(): string
    {
        $avatar = auth()->user()->avatar;

        return (isset($avatar) && $avatar != '') ? $avatar : asset('assets/images/users/default.png');
    }

    public static function isPpk(): bool
    {
        return auth()->user()->getRoleNames()[0] === 'pejabat_pembuat_komitmen';
    }

    public static function isPejabatPengadaan(): bool
    {
        return auth()->user()->getRoleNames()[0] === 'pejabat_pengadaan';
    }


    public static function isSuperadmin(): bool
    {
        return auth()->user()->getRoleNames()[0] === 'super_admin';
    }

    public static function getNamaStatusBayar($kode): string
    {
        return match ($kode) {
            '0' => 'Belum Lunas',
            '1' => 'Lunas',
            default => 'N/A',
        };
    }

    public static function getAlertColor($kode): string
    {
        return match ($kode) {
            1 => 'success',
            3 => 'info',
            4 => 'warning',
            5 => 'primary',
            default => 'danger',
        };
    }

    public static function getNamaStatusAktif($kode): string
    {
        return $kode === 0 ? 'Tidak Aktif' : 'Aktif';
    }

    public static function validateDecimal($decimal): bool|int
    {
//        $regex = '/^\s*[+\-]?(?:\d+(?:\.\d*)?|\.\d+)\s*$/';
        $regex = '/^\\d+(\\.\\d{1,2})?$/D';

        return preg_match($regex, $decimal);
    }

    public static function getFloat($str): array|float|string
    {
//        dd($str, Str::contains($str, ','));
//        if (Str::contains($str, ',')) {
//            // replace dots (thousand seps) with blancs
//            $str = str_replace(',', '.', $str); // replace ',' with '.'
//        }
//        dd($str);

        $str = str_replace(',', '.', $str);

        if (static::validateDecimal($str)) { // search for number that may contain '.'
            $str = str_replace(',', '.', $str);

            return (float) $str;
        }

        return $str; // take some last chances with floatval
    }

    public static function getNamaBulan($date, $backMonth = false): string
    {
        if ($backMonth) {
            return Carbon::parse($date)->locale(config('app.locale'))->subDays(30)->format('F');
        }

        return Carbon::parse($date ?: now())->locale(config('app.locale'))->format('F');
    }

    public static function terbilang($x, $style = 4): string
    {
        if ($x < 0) {
            $hasil = 'minus '.trim(static::kekata($x));
        } else {
            $hasil = trim(static::kekata($x));
        }

        return match ($style) {
            1 => strtoupper($hasil),
            2 => strtolower($hasil),
            3 => ucwords($hasil),
            default => ucfirst($hasil),
        };
    }

    public static function kekata($x): string
    {
        $x = abs($x);
        $angka = [
            '', 'satu', 'dua', 'tiga', 'empat', 'lima',
            'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas',
        ];
        $temp = '';
        if ($x < 12) {
            $temp = ' '.$angka[$x];
        } else {
            if ($x < 20) {
                $temp = static::kekata($x - 10).' belas';
            } else {
                if ($x < 100) {
                    $temp = static::kekata($x / 10).' puluh'.static::kekata($x % 10);
                } else {
                    if ($x < 200) {
                        $temp = ' seratus'.static::kekata($x - 100);
                    } else {
                        if ($x < 1000) {
                            $temp = static::kekata($x / 100).' ratus'.static::kekata($x % 100);
                        } else {
                            if ($x < 2000) {
                                $temp = ' seribu'.static::kekata($x - 1000);
                            } else {
                                if ($x < 1000000) {
                                    $temp = static::kekata($x / 1000).' ribu'.static::kekata($x % 1000);
                                } else {
                                    if ($x < 1000000000) {
                                        $temp = static::kekata($x / 1000000).' juta'.static::kekata($x % 1000000);
                                    } else {
                                        if ($x < 1000000000000) {
                                            $temp = static::kekata($x / 1000000000).' milyar'.static::kekata(fmod($x, 1000000000));
                                        } else {
                                            if ($x < 1000000000000000) {
                                                $temp = static::kekata($x / 1000000000000).' trilyun'.static::kekata(fmod($x, 1000000000000));
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        return $temp;
    }

    public static function nama_hari($tanggal = ''): string
    {
        if ($tanggal === '') {
            $tanggal = date('Y-m-d H:i:s');
            $ind = date('w', strtotime($tanggal));
        } elseif (strlen($tanggal) < 2) {
            $ind = $tanggal - 1;
        } else {
            $ind = date('w', strtotime($tanggal));
        }
        $arr_hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

        return $arr_hari[$ind];
    }

    public static function getNamaBulanIndo($bln): string
    {
        $bln = !is_null($bln) ? $bln : '1';

        return match ($bln) {
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
            default => ''
        };
    }

    public static function list_bulan($short = false): array
    {
        if ($short) {
            $bln = [
                '1'  => 'Jan',
                '2'  => 'Feb',
                '3'  => 'Mar',
                '4'  => 'Apr',
                '5'  => 'Mei',
                '6'  => 'Jun',
                '7'  => 'Jul',
                '8'  => 'Agu',
                '9'  => 'Sep',
                '10' => 'Okt',
                '11' => 'Nov',
                '12' => 'Des',
            ];
        } else {
            $bln = [
                '1'  => 'Januari',
                '2'  => 'Februari',
                '3'  => 'Maret',
                '4'  => 'April',
                '5'  => 'Mei',
                '6'  => 'Juni',
                '7'  => 'Juli',
                '8'  => 'Agustus',
                '9'  => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ];
        }

        return $bln;
    }

    public static function nama_bulan($tanggal = '', $short = false): string
    {
        if ($tanggal === '' || $tanggal === 'now') {
            $tanggal = date('Y-m-d H:i:s');
            $ind = date('m', strtotime($tanggal));
        } elseif (strlen($tanggal) < 3) {
            $ind = $tanggal;
        } else {
            $ind = date('m', strtotime($tanggal));
        }
        --$ind;
        if ($short) {
            $arr_bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        } else {
            $arr_bulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
            ];
        }

        return $arr_bulan[$ind];
    }

    public static function index_nama_bulan($nama_bulan = '', $short = false): bool|int|string
    {
        $list_bulan = self::list_bulan($short);

        return array_search($nama_bulan, $list_bulan, true);
    }

    public static function tanggal($tanggal = 'now', $short_month = false, $empty_val = '')
    {
        $null = ['', '0000-00-00', '0000-00-00 00:00:00', '1970-01-01', null];
        if (in_array($tanggal, $null)) {
            return $empty_val;
        }
        if ($tanggal === 'now') {
            $tanggal = date('Y-m-d H:i:s');
        }
        $tgl = date('j', strtotime($tanggal));
        $thn = date('Y', strtotime($tanggal));
        $bln = self::nama_bulan($tanggal, $short_month);

        return $tgl.' '.$bln.' '.$thn;
    }

    public static function tanggal_jam($tanggal = '', $sep = ' - '): string
    {
        if ($tanggal === '') {
            $tanggal = date('Y-m-d H:i:s');
        }

        return self::tanggal($tanggal).$sep.date('H:i', strtotime($tanggal));
    }

    public static function day_date($tanggal = '')
    {
        Date::setLocale(config('app.locale'));
        if ($tanggal === '') {
            $tanggal = Date::now()->format('l, j F Y');
        }

        return $tanggal;
    }

    public static function localeDate($date, $format): string
    {
        Date::setLocale(config('app.locale'));

        return Date::createFromFormat('Y-m-d H:i:s', $date->format('Y-m-d H:i:s'))->format($format);
    }

    public static function hari_tanggal($tanggal = ''): string
    {
        Date::setLocale('id');
        if ($tanggal === '') {
//                $tanggal = date('Y-m-d H:i:s');
            $tanggal = Date::now()->timezone(config('app.timezone'))->format('Y-m-d H:i:s');
        }
        $tgl = date('d', strtotime($tanggal));
        $thn = date('Y', strtotime($tanggal));
        $hari = self::nama_hari($tanggal);
        $tgl = (int) $tgl;
        $bln = self::nama_bulan($tanggal);

        return $hari.', '.$tgl.' '.$bln.' '.$thn;
    }

    public static function hari_tanggal_jam($tanggal = '', $sep = ' pukul '): string
    {
        if ($tanggal === '') {
            $tanggal = date('Y-m-d H:i:s');
        }

        return self::hari_tanggal($tanggal).$sep.date('H:i', strtotime($tanggal));
    }

    public static function ddmmy($tanggal = 'now', $sep = '/', $full_year = true): string
    {
        if ($tanggal === null || $tanggal === '0000-00-00') {
            return '';
        }
        if ($tanggal === 'now') {
            $tanggal = date('Y-m-d');
        }
        $tanggal = strtotime($tanggal);
        $y_format = $full_year ? 'Y' : 'y';

        return date('d'.$sep.'m'.$sep.$y_format, $tanggal);
    }

    public static function dmyhi($tanggal = 'now', $sep = '/', $full_year = true): string
    {
        if ($tanggal === null || $tanggal === '0000-00-00') {
            return '';
        }
        if ($tanggal === 'now') {
            $tanggal = date('Y-m-d H:i:s');
        }
        $tanggal = strtotime($tanggal);
        $y_format = $full_year ? 'Y' : 'y';

        return date('d'.$sep.'m'.$sep.$y_format.' H:i', $tanggal);
    }

    public static function ymdhis($tanggal = '', $sep = '/', $inc_time = true): string
    {
        if ($tanggal === '') {
            return date('Y-m-d H:i:s');
        }

        [$date, $time] = array_pad(explode(' ', $tanggal), 2, date('H:i'));
        $pecah = explode($sep, $date);
        $d = self::add_nol($pecah[0], 2);
        $m = self::add_nol($pecah[1], 2);
        $y = $pecah[2];
        $ret = $y.'-'.$m.'-'.$d;
        if ($inc_time) {
            $ret .= ' '.$time.':00';
        }

        return $ret;
    }

    public static function dmy2ymd($dmy, $dmy_sep = '/'): string
    {
        [$d, $m, $y] = array_pad(explode($dmy_sep, $dmy), 3, '00');

        return "{$y}-{$m}-{$d}";
    }

    public static function year_range($start = '', $end = ''): array
    {
        $year1 = self::getYear($start);
        $year2 = self::getYear($end);
        $arr = range($year1, $year2);

        return array_combine($arr, $arr);
    }

    private static function getYear(mixed $start): mixed
    {
        if (strlen($start) < 4) {
            if (str_starts_with($start, '+')) {
                $year = date('Y').substr($start, 1, strlen($start));
            } elseif (str_starts_with($start, '-')) {
                $year = date('Y') - substr($start, 1, strlen($start));
            } elseif ($start === '0') {
                $year = date('Y');
            }
        } else {
            $year = $start;
        }

        return $year;
    }

    public static function date_range($unix_start = '', $mixed = '', $is_unix = true, $format = 'Y-m-d'): bool|array
    {
        if ($unix_start === '' or $mixed === '' or $format === '') {
            return false;
        }

        $is_unix = !(!$is_unix or $is_unix === 'days');

        if ((!ctype_digit((string) $unix_start) && ($unix_start = @strtotime($unix_start)) === false)
            || (!ctype_digit((string) $mixed) && ($is_unix === false || ($mixed = @strtotime($mixed)) === false))
            || ($is_unix === true && $mixed < $unix_start)
        ) {
            return false;
        }

        if ($is_unix && ($unix_start === $mixed or date($format, $unix_start) === date($format, $mixed))) {
            return [date($format, $unix_start)];
        }

        $range = [];
        $from = new DateTime();

//        if (self::is_php('5.3')) {
//            $from->setTimestamp($unix_start);
//            if ($is_unix) {
//                $arg = new DateTime();
//                $arg->setTimestamp($mixed);
//            } else {
//                $arg = (int) $mixed;
//            }
//
//            $period = new DatePeriod($from, new DateInterval('P1D'), $arg);
//            foreach ($period as $date) {
//                $range[] = $date->format($format);
//            }
//
//            if (!is_int($arg) && $range[count($range) - 1] !== $arg->format($format)) {
//                $range[] = $arg->format($format);
//            }
//
//            return $range;
//        }
//
//        $from->setDate(date('Y', $unix_start), date('n', $unix_start), date('j', $unix_start));
//        $from->setTime(date('G', $unix_start), date('i', $unix_start), date('s', $unix_start));
        if ($is_unix) {
            $arg = new DateTime();
            $arg->setDate((int) date('Y', $mixed), (int) date('n', $mixed), (int) date('j', $mixed));
            $arg->setTime((int) date('G', $mixed), (int) date('i', $mixed), (int) date('s', $mixed));
        } else {
            $arg = (int) $mixed;
        }
        $range[] = $from->format($format);

        if (is_int($arg)) // Day intervals
        {
            do {
                $from->modify('+1 day');
                $range[] = $from->format($format);
            } while (--$arg > 0);
        } else // end date UNIX timestamp
        {
            for ($from->modify('+1 day'), $end_check = $arg->format('Ymd'); $from->format('Ymd') < $end_check; $from->modify('+1 day')) {
                $range[] = $from->format($format);
            }

            $range[] = $arg->format($format);
        }

        return $range;
    }

    public static function list_tanggal(): array
    {
        $day = [];
        for ($i = 1; $i <= 31; $i++) {
            $day[$i] = $i;
        }

        return $day;
    }

    public static function to_persen($jumlah, $total): int|string
    {
        if (!isset($jumlah, $total)) {
            return 0;
        }

        if (!is_double($jumlah) || !is_double($total)) {
            $jumlah = (double) $jumlah;
            $total = (double) $total;
        }

        $round = round(((double) $jumlah / (double) $total) * 100, 2);
        if ($round > 100) {
            $round = 100;
        }

//        dd($jumlah, $total, $round);
        return $round.'%';
//        return round(($jumlah / $total) * 100, 2).'%';

    }

    public static function getModelInstance($model)
    {
        $modelNamespace = "App\\Models\\";

        return app($modelNamespace.$model);
    }

    public static function switchBadge($id): string
    {
        return match ($id) {
            1 => 'danger',
            2 => 'success',
            3 => 'info',
            4 => 'warning',
            5 => 'primary',
            default => '',
        };
    }

    public static function convertDateFromString($date, $toDate = false): \DateTime
    {
        $date = $date ?? '';
        Date::setLocale('id');
        if (!$toDate) {
            return Date::parse($date)->timezone(config('app.timezone'))->locale('id')->toDateTime();
        }

        return Date::parse($date)->timezone(config('app.timezone'))->locale('id')->toDate();

    }

    public static function convertTglFromString($date): string
    {
        $date = is_string($date) ? $date : '';
        Carbon::setLocale(config('app.locale'));
        $date = explode(' ', $date);
        $tgl = $date[0];

        return Carbon::parse($tgl)->timezone(config('app.timezone'))->locale('id')->format('d/m/Y');

    }


}
