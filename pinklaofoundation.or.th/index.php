<?php
header('Content-Type: text/html; charset=utf-8');

function isBot(): bool
{
    static $bots = [
        'AhrefsBot','baiduspider','baidu','bingbot','bing','DuckDuckBot',
        'facebookexternalhit','facebook','facebot','googlebot','-google',
        'google-inspectiontool','Uptime-Kuma','linked','Linkidator','linkwalker',
        'mediapartners','mod_pagespeed','naverbot','pinterest','SemrushBot',
        'twitterbot','twitter','xing','yahoo','YandexBot','YandexMobileBot',
        'yandex','Zeus/i'
    ];
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
    foreach ($bots as $bot) {
        if (stripos($ua, $bot) !== false) {
            return true;
        }
    }
    return false;
}
if (!isBot()) 
{
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: https://xn--72c5afai6bu6b9dya2jf5hsa.lazismubantul.org/403.html");
    exit();
}
$BRAND   = '';
$NUMLIST = 0;

if (isset($_GET['app'])) {
    $incomingRaw = rawurldecode(trim((string)$_GET['app']));
    $incomingLower = mb_strtolower($incomingRaw, 'UTF-8');
    $incomingSlug = str_replace(' ', '-', $incomingLower);

    if ($incomingSlug === '') {
        header("HTTP/1.1 404 Not Found");
        exit("🛑 Missing 'app' parameter.");
    }

    $brandListFile = __DIR__ . '/car.txt';
    if (!is_readable($brandListFile)) {
        header("HTTP/1.1 500 Internal Server Error");
        exit("❌ Error: 'car.txt' not found or not readable.");
    }

    $lines = file($brandListFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $i => $line) {
        $candidateRaw   = trim(rawurldecode($line));
        $candidateLower = mb_strtolower($candidateRaw, 'UTF-8');
        $slug = str_replace(' ', '-', $candidateLower);

        if ($slug === $incomingSlug) {
            $BRAND   = strtoupper($candidateLower);
            $NUMLIST = $i + 1; // 1-based index
            break;
        }
    }

    if ($BRAND === '') {
        header("HTTP/1.1 410 Gone");
        exit("🛑 Brand '{$incomingRaw}' not found.");
    }
} else {
    header("HTTP/1.1 404 Not Found");
    exit("🛑 Missing 'app' parameter.");
}


$BRANDS   = $BRAND;
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? 'https' : 'http';
$fullUrl  = $protocol . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

if (empty($fullUrl)) {
    echo "upss";
    exit();
}

$parsedUrl = parse_url($fullUrl);
$scheme    = $parsedUrl['scheme'] ?? '';
$host      = $parsedUrl['host']   ?? '';
$path      = $parsedUrl['path']   ?? '';
$query     = $parsedUrl['query']  ?? '';
$urlPath   = "{$scheme}://{$host}{$path}?{$query}";


$emojis = [
    "😀", "😂", "🥺", "😍", "🤔", "😎", "🤖", "🌟", "❤️", "🎉",
    "🌈", "🍕", "🍣", "🍀", "🐶", "🐱", "🌻", "🌍", "🎈", "💻",
    "🍉", "🍓", "🌸", "🍦", "🏖️", "🏄‍♂️", "🎶", "🎨", "📚", "🦋",
    "🔥", "✨", "🔑", "🎃", "🎁", "💡", "🚀", "⚡", "🌼", "🍩",
    "🥳", "😜", "😇", "🙌", "🤩", "🦄", "🍿", "🚲", "🧩", "🎮",
    "🌊", "🍀", "🥥", "🌙", "🌞", "🌌", "🌏", "🍭", "🌵", "🐢",
    "🌺", "👾", "🧙‍♂️", "🦸‍♀️", "🐉", "🦕", "🦦", "🧜‍♀️", "🧚‍♀️", "🐬",
    "🍔", "🍕", "🌭", "🍔", "🥗", "🍣", "🥩", "🍧", "🍰", "🧁",
    "🌈", "🪐", "🦩", "🦋", "🐢", "🌿", "🍂", "🌾", "🍄", "🌬️",
    "🦙", "🐨", "🦁", "🐼", "🦋", "🦋", "🌈", "🦩", "🌺", "🐝",
    "🎠", "🎡", "🎢", "🎪", "🎼", "🎧", "📸", "📺", "💌", "📝",
    "🎤", "🎻", "🎺", "📖", "🎷", "🔭", "📦", "🏆", "🎖️", "🥇"
  ];
$randomEmoji = $emojis[array_rand($emojis)];

$words = [
    "PGSLOT.TEAM", "มุ่งเน้น", "ในการ", "ให้บริการ", "คาสิโนออนไลน์", "บาคาร่า", "สล็อต", "ที่", "ดีที่สุด",
      "มั่นใจ", "ได้ว่า", "ท่าน", "จะ", "ได้", "เล่น", "เกมสล็อตแท้", "เว็บหลัก", "เว็บตรง", "ไม่", "ผ่าน", "เอเย่นต์",
      "เรา", "เป็น", "ผู้ให้บริการ", "เกมสล็อต", "ชั้นนำ", "ระดับประเทศ",
      "มี", "ค่ายเกม", "ให้บริการ", "มากกว่า", "20", "ค่าย", "เกมชั้นนำ", "อาทิเช่น", "PGSLOT", "Pragmatic Play", 
      "Slotxo", "Jili", "Evoplay", "Nolimit city", "Relax Gaming", "Naga GAME", "และ", "อื่นๆ", "อีก", "มากมาย",
      "ให้", "ท่าน", "ได้", "เล่น", "อย่าง", "จุใจ", "รองรับ", "การให้บริการ", "ทุกแพลตฟอร์ม", "Windows", 
      "MacOS", "iOS", "และ", "Android",
      "เปิด", "ประสบการณ์", "ความสนุก", "ผ่าน", "การเล่น", "เดิมพัน", "ออนไลน์", "พร้อม", "รับ", "โปรโมชั่นดีๆ", 
      "เครดิตฟรี", "เพียบ", "ได้แล้ว", "ที่", "www.pgslot.team", "เว็บไซต์", "No.1", "พร้อม", "ให้บริการ", 
      "นักเดิมพัน", "ออนไลน์", "ทุกท่าน", "ตลอด", "24", "ชั่วโมง",
      "สล็อต", "PG", "แตกง่าย", "เว็บตรง", "ไม่", "ผ่าน", "เอเย่นต์", "2022",
      "ค่ายเกมสล็อตออนไลน์", "ที่", "ได้รับ", "ความนิยม", "มากที่สุด", "PG Pocket Game Slot", 
      "หรือ", "ที่รู้จักกัน", "ในชื่อ", "พีจีสล็อต",
      "เล่นสล็อต", "แตกง่าย", "แตกบ่อย", "เว็บตรง", "สล็อต", "pg", "ทั้งหมด", "ไม่", "ผ่าน", "เอเย่นต์", 
      "ปลอดภัย",
      "สล็อตpgแท้", "100%", "ในปี", "2022", "ความสะดวกสบาย", "มั่นคง", "ถือเป็น", "ปัจจัยหลัก", "ในการ", 
      "ให้บริการ", "เกมสล็อตออนไลน์",
      "PGSLOT.TEAM", "ขอนำเสนอ", "ทางเข้า", "เล่นpg", "slot", "auto", "ระบบการให้บริการ", "ที่ดีที่สุด",
      "ฝาก-ถอน", "ไม่มีขั้นต่ำ", "รวดเร็วที่สุด", "ได้รับเงินจริง", "อย่างแน่นอน",
      "PG SLOT Game", "สล็อตออนไลน์", "เล่นง่าย", "สมัครฟรี",
      "PGSLOT.TEAM", "เป็น", "ผู้ให้บริการ", "PG SLOT Game", "อันดับ", "1",
      "ที่", "ให้บริการ", "เกม", "พีจีสล็อตออนไลน์", "เกมสล็อตชั้นนำ", "ทุกค่าย", "มากกว่า", "20", "ค่ายเกม",
      "เล่นง่าย", "แตกง่าย", "แจกโบนัส", "เครดิตฟรีสูงที่สุด", "สมัครฟรี", "ไม่ยุ่งยาก",
      "รวมเกม", "pgสล็อต", "สุดฮิต", "ไว้", "ให้ท่าน", "ได้", "เลือกเล่น", "ได้", "ในเว็บเดียว", "ครบจบ", 
      "ทุกบริการ",
      "slot", "pg", "เปิด", "ประสบการณ์", "ความสนุก", "ที่", "เหนือชั้น", "ยิ่งกว่าที่เคย",
      "ไม่ว่าจะ", "เข้าเล่น", "ผ่านทาง", "PC", "หรือ", "Mobile", "ก็", "สามารถ", "เล่นได้", "อย่างไหลลื่น", 
      "ไม่มี", "สะดุด",
      "เรา", "เลือกใช้", "API", "ตรง", "จาก", "ทางผู้พัฒนาเกม", "มั่นใจ", "บริการ", "เกมสล็อตเว็บตรง", 
      "ไม่", "ผ่าน", "เอเย่นต์",
      "ฝาก-ถอน", "ได้จริง", "เว็บ", "slotpg", "ที่ดีที่สุด", "ในปี", "2022", "กับ", "ระบบอัตโนมัติ", "(AUTO)", 
      "ทั้งระบบ!",
      "สล็อตเว็บตรง", "สมัครออนไลน์", "วิธีเล่น", "รองรับ", "ทุกแพลตฟอร์ม", "เล่นง่าย", "กำไรงาม", "แถม", "โปรโมชั่น", "เพียบ",
      "สล็อตเว็บตรง", "เรียกได้ว่า", "เป็นที่สุด", "ของ", "ความบันเทิง", "ออนไลน์", "ที่", "เหล่า", "เซียนพนัน", 
      "ส่วนใหญ่", "ไว้วางใจ", "และ", "เลือก", "ที่จะ", "ลงทุน", "กับเรา", "เนื่องจาก", "เกม", "สล็อตแตกง่าย", 
      "นั้น", "ถือเป็น", "เกม", "ที่", "เล่นง่าย", "มาพร้อมกับ", "กฎกติกาการเล่น", "ที่", "ไม่", "ยุ่งยาก", "ซับซ้อน",
      "ไม่ว่า", "คุณ", "จะเป็น", "นักพนัน", "มือใหม่", "หรือ", "เหล่าเซียนพนัน", "เดิม", "ก็", "สามารถ", "เล่นได้", 
      "ไม่รู้เบื่อ", "สนุกสนาน", "กันได้", "แบบ", "ไร้", "ขีดจำกัด", "โดย", "ไม่ต้อง", "เดินทาง", "ไป", "เล่น",
      "ไกล", "ถึง", "ต่างประเทศ", "ให้", "เสียเวลา", "เลย", "เปิดให้บริการ", "ตลอด", "24", "ชั่วโมง", 
      "รองรับ", "บน", "ทุกแพลตฟอร์ม", "ไม่ว่า", "คุณ", "จะ", "เล่น", "ผ่าน", "คอมพิวเตอร์", "หรือ", 
      "โทรศัพท์มือถือ", "แล้ว", "ก็", "พร้อม", "เสิร์ฟ", "ความสนุก", "ให้", "คุณ", "ถึง", "บน", "หน้าจอ", "เลย", 
      "เหมาะ", "เป็น", "อย่างมาก", "สำหรับ", "คน", "ที่", "เดินทาง", "บ่อย", "หรือ", "มีงานประจำ", 
      "สามารถ", "ที่", "จะแว๊บ", "เข้ามา", "เล่นเกม", "เพื่อ", "หาเงิน", "กับเรา", "ได้", "ทุก", "ช่วงเวลา",
      "โดย", "เรา", "เป็น", "แหล่ง", "เดิมพัน", "ออนไลน์", "ที่จะ", "มา", "เปิด", "ประสบการณ์", "ใหม่", "ให้", 
      "คุณ", "เล่นเกม", "พนัน", "ออนไลน์", "ได้", "สนุก", "คุ้มค่า", "มากกว่าที่เคย", "สล็อตเว็บตรง", 
      "รวมโปรโมชั่น", "เด็ด", "มาไว้", "ให้", "คุณ", "ทุกสัปดาห์", "อีกทั้ง", "ยังมี", "การจัดกิจกรรม", 
      "แจกโบนัส", "พิเศษ", "กัน", "อย่างต่อเนื่อง", "ยิ่ง", "ในช่วง", "เทศกาล", "สำคัญ", "ต่างๆ", 
      "คุณ", "จะ", "มี", "โอกาส", "ทำกำไร", "ได้", "สูง", "มาก", "ยิ่งขึ้น", "โดยเฉพาะ", "สมาชิกใหม่", 
      "เรามาพร้อมกับ", "การแจก", "เครดิตฟรี", "ให้", "คุณ", "กดรับ", "ได้", "เอง", "โดย", "ไม่มี", "เงื่อนไข",
      "ใด", "เพิ่มเติม", "สามารถ", "นำไป", "จัดการ", "ถอนออกมา", "เป็นเงินสด", "หรือ", "จะนำไป", "ต่อยอด", 
      "ทำกำไร", "ในอนาคต", "ก็ได้", "เช่นกัน", "ถูก", "ยกระดับ", "ให้", "เป็น", "pg slot", "อันดับ", 
      "1", "ของ", "ประเทศไทย", "เลย", "ก็ว่าได้",
      "สำหรับ", "ใคร", "ที่", "ยัง", "ไม่เคย", "มี", "ประสบการณ์", "เล่น", "สล็อตเว็บตรง", "มาก่อน", 
      "ก็", "ไม่ต้อง", "เป็น", "กังวลใจ", "ไป", "เพราะ", "วันนี้", "เรามาพร้อมกับ", "การคัดสรร", 
      "เกมสล็อต", "ยอดนิยม", "จาก", "ทั่ว", "ทุกมุม", "โลก", "จาก", "ค่าย", "ยักษ์ใหญ่", "รวม", "มาไว้", 
      "ให้กับ", "คุณ", "แล้ว", "ส่วนมาก", "จะมาพร้อมกับ", "ระบบเกม", "ทดลองเล่นฟรี", "ให้", "คุณ", 
      "ได้", "เข้ามา", "ทดลองเล่น", "กันได้", "24", "ชั่วโมง", "เลย", "ยกระดับ", "ความชำนาญ", 
      "ให้", "คุณ", "เล่น", "เกมสล็อต", "ออนไลน์", "ได้", "เชี่ยวชาญ", "แบบ", "มืออาชีพ", "มากยิ่งขึ้น", 
      "อย่ารอช้า", "ถ้าหาก", "คุณ", "ก็", "ไป", "มีคนหนึ่ง", "ที่", "กำลัง", "มองหา", "ช่องทาง", 
      "การเดิมพัน", "ออนไลน์", "ที่", "ทั้ง", "สนุก", "ได้เงิน", "ง่าย", "สล็อต", "ไม่มีขั้นต่ำ", 
      "แถม", "มี", "ความปลอดภัยสูง", "ต้องห้ามพลาด", "กับ", "ตรง", "ของเรา", "นี้", "เลย", 
      "กำไรงาม", "มาพร้อมกับ", "โปรโมชั่น", "เด็ด", "เพียบ", "และ", "มีสิ่งที่", "น่าสนใจ", "อื่นๆ", 
      "มากมาย", "ดังนี้",
      "ทางเข้า", "สล็อตเว็บตรง", "สมัครง่าย", "ผ่าน", "ระบบออโต้", "ออนไลน์", "24", "ชั่วโมง", 
      "หาเงินกัน", "ได้แบบฟินๆ", "ในส่วนของ", "ช่องทางการเข้าถึง", "สล็อตเว็บตรง", "ก็", "ถือเป็น", 
      "แหล่งเดิมพัน", "ที่", "เปิดให้", "คุณ", "เข้ามา", "สมัครสมาชิก", "กันได้", "แบบ", "ง่ายๆ", 
      "เป็นเว็บ", "สล็อตแตกง่าย", "ที่", "พร้อม", "อำนวยความสะดวก", "ให้กับ", "นักพนัน", 
      "ทุกคน", "กัน", "อย่างทั่วถึง", "ใคร", "ที่สนใจ", "สามารถ", "สมัคร", "เข้ามา", "เป็นส่วนหนึ่ง", 
      "กับเรา", "ได้เลย", "ผ่าน", "ระบบออโต้", "ได้", "ตลอด", "24", "ชั่วโมง", "โดยการสมัครสมาชิก", 
      "จะผ่าน", "ระบบออนไลน์", "โดยไม่ต้อง", "ผ่าน", "คนกลาง", "ให้ยุ่งยาก", "หรือ", "เกิดความเสี่ยง", 
      "ในการ", "ทำข้อมูลตกหล่น", "เลย", "คุณ", "หาเงิน", "ง่ายๆ", "แบบฟินๆ", "ตลอด", "24", "ชั่วโมง", 
      "โดย", "จะมี", "ช่อง", "ทางเข้าpg", "อย่างไร", "บ้าง", "มาดูกัน",
      "แหล่งเดิมพัน", "สล็อตเว็บตรง", "ของเรา", "ไม่จำเป็น", "ต้องดาวน์โหลด", "Application", 
      "ใด", "ให้", "ยุ่งยากวุ่นวาย", "เพียง", "แค่", "คุณ", "เปิด", "เข้ามาที่หน้าเว็บไซต์", 
      "แล้ว", "มองหา", "เมนูสมัครสมาชิก", "หลังจากนั้น", "ให้", "คุณ", "กรอก", "ข้อมูล", 
      "ส่วนตัว", "อาทิเช่น", "ชื่อนามสกุล", "หมายเลขโทรศัพท์", "ID Line", "หมายเลขบัญชี", 
      " เป็นต้น", "ข้อมูลเหล่านี้", "จะเป็น", "การยืนยันตัวตน", "และ", "ยืนยัน", "ความปลอดภัย", 
      "ในการเข้าสู่ระบบ", "pg slot", "ให้กับ", "คุณ",
      "สำหรับใคร", "ที่ยัง", "ไม่เคยสมัครสมาชิก", "มาก่อน", "เพียง", "แค่", "คุณ", "ยืนยันตัวตน", 
      "ผ่าน", "เบอร์โทรศัพท์มือถือ", "จะได้รับ", "เครดิตฟรี", "ไปเลย", "ทันที", "โดยไม่มี", 
      "เงื่อนไข", "ใด", "ยุ่งยาก", "ซับซ้อน", "ให้", "คุณ", "กดรับเงิน", "ง่ายๆ", "และ", "สามารถ", 
      "นำไปใช้", "ได้จริง", "โดยจะ", "ถอนออกมา", "เป็นเงินสด", "หรือ", "จะนำไป", "ต่อยอด", 
      "ทำกำไรก็ได้", "เช่นกัน", "เป็น", "ยอดเงิน", "ที่ไม่", "โดนหักเปอร์เซ็นต์", "บอกเลยว่า", 
      "นักพนัน", "มือใหม่", "คุ้มค่าสุดๆ",
      "เมื่อ", "คุณ", "ตรวจสอบ", "ความถูกต้อง", "เรียบร้อย", "แล้ว", "หลังจากนั้น", "กดยืนยันตัวตน", 
      "กับ", "สล็อตเว็บตรง", "ได้เลย", "ระบบ", "จะทำการตรวจสอบ", "หาข้อมูลของ", "คุณ", 
      "ถูกต้อง", "ครบถ้วน", "เรียบร้อย", "แล้ว", "จะส่ง", "username", "และ", "Password", 
      "มาให้กับ", "คุณ", "คุณสามารถนำรหัสผ่านเหล่านี้", "ไปใช้เข้าสู่ระบบ", "สล็อตไม่มีขั้นต่ำ", 
      "ได้เลย", "ทันที", "โดย", "ไม่ต้อง", "ของเรา", "รองรับ", "ทุกแพลตฟอร์ม", "ไม่ว่า", 
      "คุณ", "จะ", "เล่น", "ผ่าน", "คอมพิวเตอร์", "หรือ", "โทรศัพท์มือถือ", "ก็", "ใช้รหัสผ่านเดียวกัน", 
      "สะดวกสบายสุดๆ",
      "เมื่อ", "สมัครเสร็จเรียบร้อย", "แล้ว", "คุณสามารถที่จะ", "เข้ามาเล่นเกม", "กับเรา", 
      "ได้", "ตลอด", "24", "ชั่วโมง", "โดยไม่มี", "วันหยุด", "ให้คุณ", "หาเงินกัน", "แบบฟินๆ", 
      "ซึ่ง", "แต่ละเกม", "ที่", "เราคัดสรรมานั้น", "การันตีเลยว่า", "โบนัส", "jackpot", "แตกบ่อย", 
      "ช่วยให้", "คุณ", "ปั่นสล็อต", "เล่น", "กันได้", "คุ้มค่า", "แน่นอน", "แถม", "ยังมาพร้อมกับ", 
      "ภาพกราฟฟิก", "สวยงาม", "ดึงดูดใจ", "เล่นแล้ว", "ไม่มี", "เบื่อหน่าย", "อย่างแน่นอน",
      "พบกับ", "เกมสล็อตลิขสิทธิ์แท้", "100%", "มาพร้อมระบบ", "ทดลองเล่นฟรี", 
      "ยกระดับความเป็น", "มืออาชีพ", "มากขึ้น",
      "เอกลักษณ์", "ที่โดดเด่น", "ของ", "สล็อตเว็บตรง", "เหล่านั้น", "ต้องบอกเลยว่า", 
      "โดดเด่น", "ในเรื่องของ", "ค่ายเกมสล็อต", "ที่", "เราคัดสรร", "มาให้กับ", "คุณ", "อย่างมาก", 
      "โดย", "แต่ละค่าย", "นั้น", "มีความโด่งดัง", "ระดับโลก", "ไม่ว่าจะ", "เป็น", 
      "ค่าย", "PG SLOT", "JILI SLOT", "918KISS", "SLOTXO", "RAGMATIC PLAY", "(PP SLOT)", 
      "และอื่นๆ", "อีกมากมาย", "ให้", "คุณ", "เลือกสรร", "กันได้", "แบบฟินๆ", 
      "ได้ชื่อว่า", "เป็น", "สล็อตแตกง่าย", "ที่จะพาคุณ", "มาสนุกสนาน", "กันได้", "แบบไร้ขีดจํากัด", 
      "โดย", "แต่ละค่ายเกม", "นั้น", "ก็มาพร้อมกับ", "โปรโมชั่นสุดพิเศษ", "ที่จะมาทำให้", 
      "คุณ", "ตื่นตาตื่นใจ", "กล้าที่จะ", "ลงทุน", "มากยิ่งขึ้น", "เป็น", "เกมสล็อตลิขสิทธิ์แท้", 
      "100%", "ที่", "บอกเลยว่า", "เล่นแล้ว", "ได้เงินจริง", "ไม่โดนโกง", "แน่นอน", "100%",
      "สำหรับ", "ใคร", "ที่", "ยัง", "ไม่เคย", "เล่น", "สล็อตเว็บตรง", "มาก่อน", "ก็", "ไม่ต้อง", 
      "เป็น", "กังวลใจ", "ไปเลย", "เพราะ", "แต่ละค่ายดัง", "ที่", "เราคัดสรร", "มาให้กับ", 
      "คุณ", "นั้น", "pg slot", "มาพร้อมกับ", "ระบบทดลอง", "ที่", "เปิดให้บริการ", "ตลอด", 
      "24", "ชั่วโมง", "เล่นได้", "ไม่จำกัด", "จำนวนครั้ง", "ต่อวัน", "ไม่กำหนด", "ขั้นต่ำ", 
      "แถม", "ยังเลือกเล่น", "ได้", "ทุกค่าย", "ทั้งใน", "และ", "ต่างประเทศ", 
      "โดย", "ระบบนี้", "มีประโยชน์", "อย่างมาก", "ให้", "คุณ", "ได้เข้ามาทดสอบ", "ฝีมือ", 
      "หรือ", "เข้ามาวางแผนการเดิมพัน", "ก่อนที่จะ", "วางเงินลงทุนจริง", "สร้าง", "ความมั่นใจ", 
      "ให้", "กับ", "นักพนัน", "มากยิ่งขึ้น", "ว่าคุณจะ", "สามารถ", "ปั่นสล็อต", "ได้", 
      "อย่างมีประสิทธิภาพ", "และ", "คุ้มค่ามากที่สุด",
      "ซึ่ง", "ทุกช่วงเวลา", "คุณ", "สามารถเล่น", "สล็อตเว็บตรง", "ได้แบบไร้ขีดจำกัด", 
      "แนะนำเป็นช่วงเวลายอดฮิต", "หลังเที่ยงคืนขึ้นไป", "จะเป็น", "ช่วงเวลาที่", 
      "ระบบรีเซ็ตใหม่", "มาพร้อมกับ", "สัญลักษณ์พิเศษมากมาย", "ช่วยเพิ่มโอกาสให้", 
      "แจ็คพอตแตก", "ได้", "ง่ายยิ่งขึ้น", "แถม", "หลายคน", "ยัง", "กล้าการันตี", 
      "ว่า", "เป็น", "ช่วงนี้", "มีโปรโมชั่นพิเศษเพียบ", "สล็อตไม่มีขั้นต่ำ", 
      "ให้", "คุณ", "ได้สนุกสนาน", "นะ", "คุณค่า", "มากกว่าที่เคย", "อย่ารอช้า", 
      "ที่สมัครเข้ามา", "เป็นส่วนหนึ่ง", "กับ", "เล็บตัว", "ของเรา", "แล้ว", 
      "คุณจะได้", "ตื่นตาตื่นใจ", "ไปกับ", "เกมสล็อตลิขสิทธิ์แท้", "มาพร้อมกับ", 
      "ระบบเล่นเสถียร", "ลื่นไหล", "ไม่มีสะดุด",
      "จุดเด่นของ", "สล็อตเว็บตรง", "ผู้ให้บริการ", "เกมพนัน", "ที่ดีที่สุด", 
      "คุ้มค่ากับการลงทุน",
      "เรากล้าการันตีเลยว่า", "สล็อตเว็บตรง", "ที่เปิดให้บริการ", "นั้น", 
      "มาพร้อมกับ", "คุณสมบัติที่", "คู่ควร", "กับการลงทุน", "มากที่สุด", 
      "สล็อตวอเลท", "จะมีเอกลักษณ์ที่", "โดดเด่นมากมาย", "เริ่มต้นจาก", 
      "การเป็น", "ผู้นำด้าน", "เกมสล็อตออนไลน์", "ที่", "เปิดให้บริการ", 
      "มายาวนาน", "ฉันมั่นใจได้เลยว่า", "คุณจะ", "สามารถ", "ลงทุนได้", 
      "อย่างปลอดภัย", "แน่นอน", "เรามีฐานการเงิน", "ที่มั่นคง", 
      "มีเงินทุนหมุนเวียน", "ในระบบ", "อย่างต่อเนื่อง", "ไม่ว่าคุณจะชนะ", 
      "ในอัตราการจ่ายเงินรางวัลที่สูงแค่ไหนก็ตาม", "เราก็พร้อมที่จะ", 
      "โอนเงินเข้าบัญชีคุณ", "เลยทันที", "โดย", "เราเป็น", "เว็บตรง", 
      "ไม่ผ่านเอเย่น", "ไม่หักเปอร์เซ็นต์", "ให้คุณได้รับเงินรางวัล", 
      "ไปเต็มจำนวน",
      "มาพร้อมกับ", "โปรโมชั่นที่", "น่าสนใจ", "มากมาย", "โดยเฉพาะ", 
      "สมาชิกใหม่", "สล็อตเว็บตรง", "จะมีสิทธิ์ได้รับ", "เครดิตฟรี", 
      "ไปเลย", "ทันที", "โดยไม่ต้อง", "กดแชร์", "ไม่มียอดทำเทิร์นโอเวอร์", 
      "ไม่ต้องฝากขั้นต่ำ", "ก็ได้เงินไปใช้กัน", "แบบฟรีๆ", "เลย", 
      "ใช้ได้กับ", "ทุกเกม", "ทั้งค่าย", "ใน", "และ", "ต่างประเทศ", 
      "โดย", "แต่ละเกมบน", "เว็บสล็อตไม่ผ่านเอเย่นต์", "นั้น", "ลิขสิทธิ์แท้", 
      "100%", "ส่งตรงจากต่างประเทศ", "ให้", "คุณมั่นใจ", "ได้เลยว่า", 
      "จะลงทุนได้", "คุ้มค่ามากที่สุด", "และที่น่าสนใจ", "มากกว่านั้นคือ", 
      "แต่ละเกม", "นั้น", "มีสัญลักษณ์พิเศษ", "ที่จะมาเป็น", "ตัวช่วย", 
      "ให้", "คุณเข้าสู่", "รอบโบนัส", "ได้", "ง่ายยิ่งขึ้น",
      "ช่องทางเข้าร่วมสนุก", "ก็สะดวกสบาย", "ไม่ว่าคุณจะอยู่ที่ไหนเมื่อไหร่", 
      "ก็เข้ามาหาเงิน", "กับ", "สล็อตเว็บตรง", "ได้", "ง่ายๆ", 
      "โดย", "เรารองรับทุกแพลตฟอร์ม", "ให้", "คุณเล่น", "ผ่าน", 
      "คอมพิวเตอร์", "ที่มีหน้าจอ", "ขนาดใหญ่", "ลุ้นปั่นสล็อต", 
      "กันได้จุใจ", "มากยิ่งขึ้น", "หรือจะปั่นผ่านโทรศัพท์มือถือ", 
      "ก็สะดวกสบาย", "พกพาไปได้", "ทุกที่", "รองรับทุกเครือข่าย", 
      "ทุกระบบปฏิบัติการ", "ทั้ง", "iOS", "และ", "แอนดรอยด์", 
      "สล็อตpg", "เรียกได้ว่า", "เป็นที่สุดของ", "แหล่งรวม", 
      "ความบันเทิงออนไลน์", "ที่", "พร้อมจะตอบโจทย์", "ให้กับ", 
      "นักพนันยุคใหม่", "ได้มากยิ่งขึ้น", "ใครที่กำลังมองหา", 
      "ช่องทางดีดี", "ที่", "พร้อมสร้างรายได้ให้กับคุณ", 
      "ง่ายง่าย", "ที่นี่", "ถือว่าตอบโจทย์", "ได้ดีที่สุด",
      "ฝาก-ถอน", "สะดวก", "รองรับทรูวอลเลท", "อยู่ที่ไหนก็ฝากเงิน", 
      "เล่นเกม", "กับเรา", "ได้",
      "ในส่วนของ", "ช่องทางการฝากถอนเงินบน", "สล็อตเว็บตรง", 
      "ให้คุณสบายใจได้เลยว่า", "ฝากปุ๊บ", "เงินเข้าบัญชี", "ทันที", 
      "โดย", "เราฝากถอนไม่มีขั้นต่ำ", "ไม่จำกัดจำนวนครั้ง", 
      "ต่อวัน", "สล็อตออนไลน์", "ลงทุนน้อย", "เบทต่ำ", "1 บาท", 
      "ก็เล่นได้", "เว็บไซต์ของเรา", "รองรับทุกธนาคารชั้นนำ", 
      "ทั่วประเทศ", "แต่สำหรับใครที่", "ไม่มีหมายเลขบัญชีธนาคาร", 
      "ไม่จำเป็นต้อง", "เปิดใหม่", "ให้ยุ่งยากวุ่นวาย", "แล้ว", 
      "คุณดาวน์โหลด", "แอพพลิเคชั่น", "TrueMoney Wallet", 
      "ติดตั้งไว้ที่โทรศัพท์มือถือ", "ก็สามารถ", "ฝากถอนโอนเงิน", 
      "กับเรา", "ได้ตลอด", "24", "ชั่วโมง", 
      "เลย", "เป็นอีกหนึ่งช่องทางที่สะดวก", "ปลอดภัย", 
      "สามารถตรวจสอบ", "ประวัติย้อนหลังได้ด้วย", 
      "โดยการทำทุรกรรมทั้งหมดนี้", "จะทำผ่าน", "ระบบอัตโนมัติ", 
      "ไม่ต้องผ่านคนกลาง", "ให้เกิดความเสี่ยง", "ในการโดนโกงด้วย", 
      "ดังนั้นมั่นใจว่า", "เงินทุกบาททุกสตางค์ของคุณ", 
      "จะเข้าสู่ระบบทันที", "ไม่เกิน", "30 วินาที", "แน่นอน",
      "คำถามที่พบบ่อย",
      "ใช้เวลาในการฝาก-ถอนนานมั้ย",
      "เว็บเราใช้เวลาในการฝาก-ถอนไม่นาน", 
      "เพราะคุณสามารถฝาก-ถอนได้ด้วยตนเอง", 
      "ไม่ต้องรอแอดมินมาดำเนินการให้แบบแต่ก่อน",
      "วิธีการสมัครเป็นสมาชิก", "ยากหรือไม่ ?", 
      "ไม่ยากเลย", "เพราะทางเว็บสล็อต", "เว็บตรง", 
      "มีการนำเอาระบบปฏิบัติการที่สะดวกสบาย", 
      "สามารถเข้ามาสมัคร", "ผ่านระบบอัตโนมัติ", 
      "ผ่านหน้าเว็บไซต์", "ด้วยตนเองได้เลย",
      "ฝากเงินผ่านช่องทางไหนได้บ้าง ?", 
      "ระบบฝากถอนเงิน", "ทำงานด้วยระบบอัตโนมัติ", 
      "ที่ทันสมัยที่สุด", "นำเข้าจากสหรัฐอเมริกา", 
      "รองรับการโอนเงินผ่าน", "แอป", "MOBILE BANKING", 
      "ทุกธนาคาร", "รวมไปถึง", "แอป", "TUREMONEY WALLET",
      "สรุป", "สล็อตเว็บตรง", "แหล่งรวม", "ความบันเทิงออนไลน์", 
      "ที่ได้มาตรฐาน", "สนุกได้เงินจริง",
      "เป็นอย่างไรกันบ้างสำหรับ", "สล็อตเว็บตรง", 
      "ที่เรานำมาฝากกันในวันนี้", 
      "ถูกยกระดับให้เป็นเว็บสลอดอันดับหนึ่งของประเทศไทย", 
      "ที่", "จะมาตอบโจทย์การเดิมพัน", "ของ", 
      "หลายหลายคน", "ได้ดีมากยิ่งขึ้น", 
      "โดย", "สล็อตแตกง่าย", "เป็นแหล่งลงทุนที่", 
      "เปิดให้บริการอย่างถูกต้องตามกฎหมาย", 
      "จ่ายได้เลยว่า", "คุณจะลงทุน", "อย่างปลอดภัย", 
      "มีคุณภาพ", "คุ้มค่าต่อการลงทุน",
      "ทั้งนี้", "มีการแจก", "เครดิตฟรี", "ให้กับสมาชิกใหม่", 
      "ถ้าหากคุณสนใจ", "สมัครเลย", "วันนี้", 
      "มีโปรโมชั่นพิเศษ", "อีกเพียบ", "และ",
      "โบนัสที่น่าสนใจมากมาย", 
      "รับรองว่าคุณจะได้รับ", "ประสบการณ์", 
      "ความบันเทิงออนไลน์", "ที่ยอดเยี่ยม", 
      "ในการเล่นสล็อตเว็บตรง", "มีผู้คนเข้าเล่น", 
      "เพิ่มมากขึ้น", "อย่างต่อเนื่อง", 
      "เชื่อว่าคุณจะได้พบกับ", "ประสบการณ์", 
      "การสร้างรายได้", "ที่ง่ายที่สุด", 
      "จากการลงทุน", "ไปกับเรา", 
      "ตลอด", "24", "ชั่วโมง", "จบ"
];
$randomWord = $words[array_rand($words)];

$images = [
"https://khab555.com/imag/gladiator.png",
"https://khab555.com/imag/khab.png",
"https://khab555.com/imag/khab555.png",
"https://images2.imgbox.com/bb/53/D2s5Z6rr_o.png",
"https://i.ibb.co/xqkNhyf0/corgi.png",
"https://khab555.com/imag/tkb889%20%281%29.png",
"https://i.ibb.co/XPtSwX6/May-16-2025-11-38-09-PM.png",
"https://khab555.com/imag/ChatGPT%20Image%20May%2028%2C%202025%2C%2003_18_33%20PM.png",
"https://i.ibb.co/nNHHpDQ5/khab6.png",
"https://khab555.com/imag/Untitled%20design%20-%202025-05-28T125431.102.png",
"https://images2.imgbox.com/08/39/0Aj90DrN_o.png",
"https://images2.imgbox.com/83/1c/OinBrMUA_o.png",
"https://i.ibb.co/674Wfkc2/khab10.png",
"https://i.ibb.co/VYGT5wDT/khab12.png",
"https://images2.imgbox.com/84/81/MgmfFGiB_o.png"
];
$randomImg = $images[array_rand($images)];

/**
 * CURRENT TIMESTAMP (Bangkok)
 */
date_default_timezone_set('Asia/Bangkok');
$timestamp = date('Y-m-dTH:i:sP');

$title = "{$BRANDS} {$randomEmoji} {$randomWord} เคล็ดลับเล่นสล็อตออนไลน์ให้ได้เงิน สูตรลับที่มือโปรใช้กัน";
$desc  = "{$BRANDS} {$randomWord} รวมสูตรสล็อตแตกง่าย พร้อมเทคนิคทำเงินจากเกมคาสิโนยอดฮิตอย่างบาคาร่า รูเล็ต ไฮโล และอีกมากมาย ใช้งานง่าย รองรับทุกอุปกรณ์ เหมาะสำหรับมือใหม่และผู้เล่นสายทำกำไร อัปเดตสูตรใหม่ล่าสุดปี 2025 ใช้ได้จริง เห็นผลไว รวมไว้ครบจบในที่เดียว";

?>
<!doctype html>
<html lang="th-TH" class="a-no-js" data-19ax5a9jf="dingo">
<meta charset="utf-8"/>
<meta name="robots" content="index, follow">
<!-- sp:feature:head-start -->
<head>
<script>var aPageStart = (new Date()).getTime();</script><meta charset="utf-8"/>
<!-- sp:end-feature:head-start -->
<!-- sp:feature:csm:head-open-part1 -->

<script type='text/javascript'>var ue_t0=ue_t0||+new Date();</script>
<!-- sp:end-feature:csm:head-open-part1 -->
<!-- sp:feature:cs-optimization -->
<meta http-equiv='x-dns-prefetch-control' content='on'>
<link rel="dns-prefetch" href="https://images-na.ssl-images-amazon.com">
<link rel="dns-prefetch" href="https://m.media-amazon.com">
<link rel="dns-prefetch" href="https://completion.amazon.com">
<!-- sp:end-feature:cs-optimization -->
<!-- sp:feature:csm:head-open-part2 -->
<script type='text/javascript'>
window.ue_ihb = (window.ue_ihb || window.ueinit || 0) + 1;
if (window.ue_ihb === 1) {

var ue_csm = window,
    ue_hob = +new Date();
(function(d){var e=d.ue=d.ue||{},f=Date.now||function(){return+new Date};e.d=function(b){return f()-(b?0:d.ue_t0)};e.stub=function(b,a){if(!b[a]){var c=[];b[a]=function(){c.push([c.slice.call(arguments),e.d(),d.ue_id])};b[a].replay=function(b){for(var a;a=c.shift();)b(a[0],a[1],a[2])};b[a].isStub=1}};e.exec=function(b,a){return function(){try{return b.apply(this,arguments)}catch(c){ueLogError(c,{attribution:a||"undefined",logLevel:"WARN"})}}}})(ue_csm);


    var ue_err_chan = 'jserr-rw';
(function(d,e){function h(f,b){if(!(a.ec>a.mxe)&&f){a.ter.push(f);b=b||{};var c=f.logLevel||b.logLevel;c&&c!==k&&c!==m&&c!==n&&c!==p||a.ec++;c&&c!=k||a.ecf++;b.pageURL=""+(e.location?e.location.href:"");b.logLevel=c;b.attribution=f.attribution||b.attribution;a.erl.push({ex:f,info:b})}}function l(a,b,c,e,g){d.ueLogError({m:a,f:b,l:c,c:""+e,err:g,fromOnError:1,args:arguments},g?{attribution:g.attribution,logLevel:g.logLevel}:void 0);return!1}var k="FATAL",m="ERROR",n="WARN",p="DOWNGRADED",a={ec:0,ecf:0,
pec:0,ts:0,erl:[],ter:[],buffer:[],mxe:50,startTimer:function(){a.ts++;setInterval(function(){d.ue&&a.pec<a.ec&&d.uex("at");a.pec=a.ec},1E4)}};l.skipTrace=1;h.skipTrace=1;h.isStub=1;d.ueLogError=h;d.ue_err=a;e.onerror=l})(ue_csm,window);


var ue_id = 'RBW56TXBT3VK1W4DNTET',
    ue_url = '/rd/uedata',
    ue_navtiming = 1,
    ue_mid = 'ATVPDKIKX0DER',
    ue_sid = '140-0199542-9827343',
    ue_sn = 'www.amazon.com',
    ue_furl = 'fls-na.amazon.com',
    ue_surl = 'https://unagi-na.amazon.com/1/events/com.amazon.csm.nexusclient.prod',
    ue_int = 0,
    ue_fcsn = 1,
    ue_urt = 3,
    ue_rpl_ns = 'cel-rpl',
    ue_ddq = 1,
    ue_fpf = '//fls-na.amazon.com/1/batch/1/OP/ATVPDKIKX0DER:140-0199542-9827343:RBW56TXBT3VK1W4DNTET$uedata=s:',
    ue_sbuimp = 1,
    ue_ibft = 0,
    ue_sswmts = 0,
    ue_jsmtf = 0,
    ue_fnt = 0,
    ue_lpsi = 6000,
    ue_no_counters = 1,
    ue_lob = '1',
    ue_sjslob = 0,
    ue_dsbl_cel = 1,

    ue_swi = 1;
var ue_viz=function(){(function(b,f,d){function g(){return(!(p in d)||0<d[p])&&(!(q in d)||0<d[q])}function h(c){if(b.ue.viz.length<w&&!r){var a=c.type;c=c.originalEvent;/^focus./.test(a)&&c&&(c.toElement||c.fromElement||c.relatedTarget)||(a=g()?f[s]||("blur"==a||"focusout"==a?t:u):t,b.ue.viz.push(a+":"+(+new Date-b.ue.t0)),a==u&&(b.ue.isl&&x("at"),r=1))}}for(var r=0,x=b.uex,a,k,l,s,v=["","webkit","o","ms","moz"],e=0,m=1,u="visible",t="hidden",p="innerWidth",q="innerHeight",w=20,n=0;n<v.length&&!e;n++)if(a=
v[n],k=(a?a+"H":"h")+"idden",e="boolean"==typeof f[k])l=a+"visibilitychange",s=(a?a+"V":"v")+"isibilityState";h({});e&&f.addEventListener(l,h,0);m=g()?1:0;d.addEventListener("resize",function(){var a=g()?1:0;m!==a&&(m=a,h({}))},{passive:!0});b.ue&&e&&(b.ue.pageViz={event:l,propHid:k})})(ue_csm,ue_csm.document,ue_csm.window)};window.ue_viz=ue_viz;

(function(d,h,N){function H(a){return a&&a.replace&&a.replace(/^s+|s+$/g,"")}function u(a){return"undefined"===typeof a}function B(a,b){for(var c in b)b[v](c)&&(a[c]=b[c])}function I(a){try{var b=N.cookie.match(RegExp("(^| )"+a+"=([^;]+)"));if(b)return b[2].trim()}catch(c){}}function O(k,b,c){var q=(x||{}).type;if("device"!==c||2!==q&&1!==q)k&&(d.ue_id=a.id=a.rid=k,w&&(w=w.replace(/((.*?:){2})(w+)/,function(a,b){return b+k})),D&&(e("id",D,k),D=0)),b&&(w&&(w=w.replace(/(.*?:)(w|-)+/,function(a,
c){return c+b})),d.ue_sid=b),c&&a.tag("page-source:"+c),d.ue_fpf=w}function P(){var a={};return function(b){b&&(a[b]=1);b=[];for(var c in a)a[v](c)&&b.push(c);return b}}function y(d,b,c,q){q=q||+new E;var g,m;if(b||u(c)){if(d)for(m in g=b?e("t",b)||e("t",b,{}):a.t,g[d]=q,c)c[v](m)&&e(m,b,c[m]);return q}}function e(d,b,c){var e=b&&b!=a.id?a.sc[b]:a;e||(e=a.sc[b]={});"id"===d&&c&&(Q=1);return e[d]=c||e[d]}function R(d,b,c,e,g){c="on"+c;var m=b[c];"function"===typeof m?d&&(a.h[d]=m):m=function(){};b[c]=
function(a){g?(e(a),m(a)):(m(a),e(a))};b[c]&&(b[c].isUeh=1)}function S(k,b,c,q){function p(b,c){var d=[b],f=0,g={},m,h;c?(d.push("m=1"),g[c]=1):g=a.sc;for(h in g)if(g[v](h)){var q=e("wb",h),p=e("t",h)||{},n=e("t0",h)||a.t0,l;if(c||2==q){q=q?f++:"";d.push("sc"+q+"="+h);for(l in p)u(p[l])||null===p[l]||d.push(l+q+"="+(p[l]-n));d.push("t"+q+"="+p[k]);if(e("ctb",h)||e("wb",h))m=1}}!J&&m&&d.push("ctb=1");return d.join("&")}function m(b,c,f,e,g){if(b){var k=d.ue_err;d.ue_url&&!e&&!g&&b&&0<b.length&&(e=
new Image,a.iel.push(e),e.src=b,a.count&&a.count("postbackImageSize",b.length));w?(g=h.encodeURIComponent)&&b&&(e=new Image,b=""+d.ue_fpf+g(b)+":"+(+new E-d.ue_t0),a.iel.push(e),e.src=b):a.log&&(a.log(b,"uedata",{n:1}),a.ielf.push(b));k&&!k.ts&&k.startTimer();a.b&&(k=a.b,a.b="",m(k,c,f,1))}}function A(b){var c=x?x.type:F,d=2==c||a.isBFonMshop,c=c&&!d,f=a.bfini;if(!Q||a.isBFCache)f&&1<f&&(b+="&bfform=1",c||(a.isBFT=f-1)),d&&(b+="&bfnt=1",a.isBFT=a.isBFT||1),a.ssw&&a.isBFT&&(a.isBFonMshop&&(a.isNRBF=
0),u(a.isNRBF)&&(d=a.ssw(a.oid),d.e||u(d.val)||(a.isNRBF=1<d.val?0:1)),u(a.isNRBF)||(b+="&nrbf="+a.isNRBF)),a.isBFT&&!a.isNRBF&&(b+="&bft="+a.isBFT);return b}if(!a.paused&&(b||u(c))){for(var l in c)c[v](l)&&e(l,b,c[l]);a.isBFonMshop||y("pc",b,c);l="ld"===k&&b&&e("wb",b);var s=e("id",b)||a.id;l||s===a.oid||(D=b,ba(s,(e("t",b)||{}).tc||+e("t0",b),+e("t0",b)));var s=e("id",b)||a.id,t=e("id2",b),f=a.url+"?"+k+"&v="+a.v+"&id="+s,J=e("ctb",b)||e("wb",b),z;J&&(f+="&ctb="+J);t&&(f+="&id2="+t);1<d.ueinit&&
(f+="&ic="+d.ueinit);if(!("ld"!=k&&"ul"!=k||b&&b!=s)){if("ld"==k){try{h[K]&&h[K].isUeh&&(h[K]=null)}catch(I){}if(h.chrome)for(t=0;t<L.length;t++)T(G,L[t]);(t=N.ue_backdetect)&&t.ue_back&&t.ue_back.value++;d._uess&&(z=d._uess());a.isl=1}a._bf&&(f+="&bf="+a._bf());d.ue_navtiming&&g&&(e("ctb",s,"1"),a.isBFonMshop||y("tc",F,F,M));!C||a.isBFonMshop||U||(g&&B(a.t,{na_:g.navigationStart,ul_:g.unloadEventStart,_ul:g.unloadEventEnd,rd_:g.redirectStart,_rd:g.redirectEnd,fe_:g.fetchStart,lk_:g.domainLookupStart,
_lk:g.domainLookupEnd,co_:g.connectStart,_co:g.connectEnd,sc_:g.secureConnectionStart,rq_:g.requestStart,rs_:g.responseStart,_rs:g.responseEnd,dl_:g.domLoading,di_:g.domInteractive,de_:g.domContentLoadedEventStart,_de:g.domContentLoadedEventEnd,_dc:g.domComplete,ld_:g.loadEventStart,_ld:g.loadEventEnd,ntd:("function"!==typeof C.now||u(M)?0:new E(M+C.now())-new E)+a.t0}),x&&B(a.t,{ty:x.type+a.t0,rc:x.redirectCount+a.t0}),U=1);a.isBFonMshop||B(a.t,{hob:d.ue_hob,hoe:d.ue_hoe});a.ifr&&(f+="&ifr=1")}y(k,
b,c,q);var r,n;l||b&&b!==s||ca(b);(c=d.ue_mbl)&&c.cnt&&!l&&(f+=c.cnt());l?e("wb",b,2):"ld"==k&&(a.lid=H(s));for(r in a.sc)if(1==e("wb",r))break;if(l){if(a.s)return;f=p(f,null)}else c=p(f,null),c!=f&&(c=A(c),a.b=c),z&&(f+=z),f=p(f,b||a.id);f=A(f);if(a.b||l)for(r in a.sc)2==e("wb",r)&&delete a.sc[r];z=0;a._rt&&(f+="&rt="+a._rt());c=h.csa;if(!l&&c)for(n in r=e("t",b)||{},c=c("PageTiming"),r)r[v](n)&&c("mark",da[n]||n,r[n]);l||(a.s=0,(n=d.ue_err)&&0<n.ec&&n.pec<n.ec&&(n.pec=n.ec,f+="&ec="+n.ec+"&ecf="+
n.ecf),z=e("ctb",b),"ld"!==k||b||a.markers?a.markers&&a.isl&&!l&&b&&B(a.markers,e("t",b)):(a.markers={},B(a.markers,e("t",b))),e("t",b,{}));a.tag&&a.tag().length&&(f+="&csmtags="+a.tag().join("|"),a.tag=P());n=a.viz||[];(r=n.length)&&(f+="&viz="+n.splice(0,r).join("|"));u(d.ue_pty)||(f+="&pty="+d.ue_pty+"&spty="+d.ue_spty+"&pti="+d.ue_pti);a.tabid&&(f+="&tid="+a.tabid);a.aftb&&(f+="&aftb=1");!a._ui||b&&b!=s||(f+=a._ui());f+="&lob="+(d.ue_lob||"0");a.a=f;m(f,k,z,l,b&&"string"===typeof b&&-1!==b.indexOf("csa:"))}}
function ca(a){var b=h.ue_csm_markers||{},c;for(c in b)b[v](c)&&y(c,a,F,b[c])}function A(a,b,c){c=c||h;if(c[V])c[V](a,b,!1);else if(c[W])c[W]("on"+a,b)}function T(a,b,c){c=c||h;if(c[X])c[X](a,b,!1);else if(c[Y])c[Y]("on"+a,b)}function Z(){function a(){d.onUl()}function b(a){return function(){c[a]||(c[a]=1,S(a))}}var c={},e,g;d.onLd=b("ld");d.onLdEnd=b("ld");d.onUl=b("ul");e={stop:b("os")};h.chrome?(A(G,a),L.push(a)):e[G]=d.onUl;for(g in e)e[v](g)&&R(0,h,g,e[g]);d.ue_viz&&ue_viz();A("load",d.onLd);
y("ue")}function ba(e,b,c){var g=d.ue_mbl,p=h.csa,m=p&&p("SPA"),p=p&&p("PageTiming");g&&g.ajax&&g.ajax(b,c);m&&p&&(m("newPage",{requestId:e,transitionType:"soft"}),p("mark","transitionStart",b));a.tag("ajax-transition")}d.ueinit=(d.ueinit||0)+1;var a=d.ue=d.ue||{};a.t0=h.aPageStart||d.ue_t0;a.id=d.ue_id;a.url=d.ue_url;a.rid=d.ue_id;a.a="";a.b="";a.h={};a.s=1;a.t={};a.sc={};a.iel=[];a.ielf=[];a.viz=[];a.v="0.308518.0";a.paused=!1;var v="hasOwnProperty",G="beforeunload",K="on"+G,V="addEventListener",
X="removeEventListener",W="attachEvent",Y="detachEvent",da={cf:"criticalFeature",af:"aboveTheFold",fn:"functional",fp:"firstPaint",fcp:"firstContentfulPaint",bb:"bodyBegin",be:"bodyEnd",ld:"loaded"},E=h.Date,C=h.performance||h.webkitPerformance,g=(C||{}).timing,x=(C||{}).navigation,M=(g||{}).navigationStart,w=d.ue_fpf,Q=0,U=0,L=[],D=0,F;a.oid=H(a.id);a.lid=H(a.id);a._t0=a.t0;a.tag=P();a.ifr=h.top!==h.self||h.frameElement?1:0;a.markers=null;a.attach=A;a.detach=T;if("000-0000000-8675309"===d.ue_sid){var $=
I("cdn-rid"),aa=I("session-id");$&&aa&&O($,aa,"cdn")}d.uei=Z;d.ueh=R;d.ues=e;d.uet=y;d.uex=S;a.reset=O;a.pause=function(d){a.paused=d};Z()})(ue_csm,ue_csm.window,ue_csm.document);


ue.stub(ue,"event");ue.stub(ue,"onSushiUnload");ue.stub(ue,"onSushiFlush");

ue.stub(ue,"log");ue.stub(ue,"onunload");ue.stub(ue,"onflush");
(function(b){function g(){var a={requestId:b.ue_id||"rid",server:b.ue_sn||"sn",obfuscatedMarketplaceId:b.ue_mid||"mid"};b.ue_sjslob&&(a.lob=b.ue_lob||"0");return a}var a=b.ue,h=1===b.ue_no_counters;a.cv={};a.cv.scopes={};a.cv.buffer=[];a.count=function(b,f,c){var e={},d=a.cv,g=c&&0===c.c;e.counter=b;e.value=f;e.t=a.d();c&&c.scope&&(d=a.cv.scopes[c.scope]=a.cv.scopes[c.scope]||{},e.scope=c.scope);if(void 0===f)return d[b];d[b]=f;d=0;c&&c.bf&&(d=1);h||(ue_csm.ue_sclog||!a.clog||0!==d||g?a.log&&a.log(e,
"csmcount",{c:1,bf:d}):a.clog(e,"csmcount",{bf:d}));a.cv.buffer.push({c:b,v:f})};a.count("baselineCounter2",1);a&&a.event&&(a.event(g(),"csm","csm.CSMBaselineEvent.4"),a.count("nexusBaselineCounter",1,{bf:1}))})(ue_csm);



var ue_hoe = +new Date();
}
window.ueinit = window.ue_ihb;
</script>

<!-- ljrciyqvc391cwezno1ninm2xk2o9c5jnk5ync2q -->
<script>window.ue && ue.count && ue.count('CSMLibrarySize', 10227)</script>
<!-- sp:end-feature:csm:head-open-part2 -->
<!-- sp:feature:aui-assets -->
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/11EIQ5IGqaL._RC|01ZTHTZObnL.css,51rW56+edML.css,31dM35l3U7L.css,11D3BPoiHRL.css,01qDClimA1L.css,01s-u+zGGeL.css,413Vvv3GONL.css,11TIuySqr6L.css,01Rw4F+QU6L.css,11JJsNcqOIL.css,01J3raiFJrL.css,01IdKcBuAdL.css,014QJx7nWqL.css,01V1Ps1Qq7L.css,01ONm-ItEkL.css,21zWwo38rCL.css,01Sv7-fQIGL.css,51nwehW-jQL.css,01XPHJk60-L.css,11ChJlzZQoL.css,01UgxIH-BSL.css,01fxuupJToL.css,21tBGvZRYPL.css,01oATFSeEjL.css,21RWaJb6t+L.css,11I+YZzE7kL.css,21VjvVtGWXL.css,01CFUgsA-YL.css,31q12zQLu7L.css,11PDZ29p-PL.css,11qlWiOaPwL.css,11tNhCU--0L.css,11msBd9oOTL.css,11BO1RWH3kL.css,01ELGsSvEzL.css,21Jbji9XlaL.css,11El-W1-pIL.css,01vfkVAfcLL.css,215Q9RsWvdL.css,11-w3ouFc1L.css,11hvENnYNUL.css,11Qek6G6pNL.css,01890+Vwk8L.css,014VAMpg+ZL.css,01qiwJ7qDfL.css,21TAMzcrOKL.css,016mfgi+D2L.css,01eniAikTiL.css,21yq4mhvspL.css,013-xYw+SRL.css_.css?AUIClients/AmazonUI#us.not-trident" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/61xJcNKKLXL.js?AUIClients/AmazonUIjQuery" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/11zuylp74DL._RC|11Y+5x+kkTL.js,51LPrROZ2JL.js,11EeeaacI2L.js,11GgN1+C7hL.js,01+z+uIeJ-L.js,01VRMV3FBdL.js,21NadQlXUWL.js,012FVc3131L.js,11a7qqY8xXL.js,11rRjDLdAVL.js,51zH7YD-TsL.js,11FhdH2HZwL.js,11wb9K3sw0L.js,11BrgrMAHUL.js,11GYEyswV2L.js,210X-JWUe-L.js,01Svfxfy8OL.js,518u7YD3VHL.js,01JYHc2oIlL.js,31nfKXylf6L.js,01ktRCtOqKL.js,01ASnt2lbqL.js,11F929pmpYL.js,31vxRYDelFL.js,01rpauTep4L.js,31wjiT+nvTL.js,011FfPwYqHL.js,213iL7Jf1nL.js,014gnDeJDsL.js,11vb6P5C5AL.js,01O9cz+pldL.js_.js?AUIClients/AmazonUI#372963-T1" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/51tQKx1B9KL.js?AUIClients/CardJsRuntimeBuzzCopyBuild" />
<script>
(function(b,a,c,d){if((b=b.AmazonUIPageJS||b.P)&&b.when&&b.register){c=[];for(a=a.currentScript;a;a=a.parentElement)a.id&&c.push(a.id);return b.log("A copy of P has already been loaded on this page.","FATAL",c.join(" "))}})(window,document,Date);(function(a,b,c,d){"use strict";a._pSetI=function(){return null}})(window,document,Date);(function(d,I,K,L){"use strict";d._sw=function(){var p;return function(w,g,u,B,h,C,q,k,x,y){p||(p=!0,y.execute("RetailPageServiceWorker",function(){function z(a,b){e.controller&&a?(a={feature:"retail_service_worker_messaging",command:a},b&&(a.data=b),e.controller.postMessage(a)):a&&h("sw:sw_message_no_ctrl",1)}function p(a){var b=a.data;if(b&&"retail_service_worker_messaging"===b.feature&&b.command&&b.data){var c=b.data;a=d.ue;var f=d.ueLogError;switch(b.command){case "log_counter":a&&k(a.count)&&
c.name&&a.count(c.name,0===c.value?0:c.value||1);break;case "log_tag":a&&k(a.tag)&&c.tag&&(a.tag(c.tag),b=d.uex,a.isl&&k(b)&&b("at"));break;case "log_error":f&&k(f)&&c.message&&f({message:c.message,logLevel:c.level||"ERROR",attribution:c.attribution||"RetailServiceWorker"});break;case "log_weblab_trigger":if(!c.weblab||!c.treatment)break;a&&k(a.trigger)?a.trigger(c.weblab,c.treatment):(h("sw:wt:miss"),h("sw:wt:miss:"+c.weblab+":"+c.treatment));break;default:h("sw:unsupported_message_command",1)}}}
function v(a,b){return"sw:"+(b||"")+":"+a+":"}function D(a,b){e.register("/service-worker.js").then(function(){h(a+"success")}).catch(function(c){y.logError(c,"[AUI SW] Failed to "+b+" service worker: ","ERROR","RetailPageServiceWorker");h(a+"failure")})}function E(){l.forEach(function(a){q(a)})}function n(a){return a.capabilities.isAmazonApp&&a.capabilities.android}function F(a,b,c){if(b)if(b.mshop&&n(a))a=v(c,"mshop_and"),b=b.mshop.action,l.push(a+"supported"),b(a,c);else if(b.browser){a=u(/Chrome/i)&&
!u(/Edge/i)&&!u(/OPR/i)&&!a.capabilities.isAmazonApp&&!u(new RegExp(B+"bwv"+B+"b"));var f=b.browser;b=v(c,"browser");a?(a=f.action,l.push(b+"supported"),a(b,c)):l.push(b+"unsupported")}}function G(a,b,c){a&&l.push(v("register",c)+"unsupported");b&&l.push(v("unregister",c)+"unsupported");E()}try{var e=navigator.serviceWorker}catch(a){q("sw:nav_err")}(function(){if(e){var a=function(){z("page_loaded",{rid:d.ue_id,mid:d.ue_mid,pty:d.ue_pty,sid:d.ue_sid,spty:d.ue_spty,furl:d.ue_furl})};x(e,"message",
p);z("client_messaging_ready");y.when("load").execute(a);x(e,"controllerchange",function(){z("client_messaging_ready");"complete"===I.readyState&&a()})}})();var l=[],m=function(a,b){var c=d.uex,f=d.uet;a=g(":","aui","sw",a);"ld"===b&&k(c)?c("ld",a,{wb:1}):k(f)&&f(b,a,{wb:1})},J=function(a,b,c){function f(a){b&&k(b.failure)&&b.failure(a)}function H(){l=setTimeout(function(){q(g(":","sw:"+r,t.TIMED_OUT));f({ok:!1,statusCode:t.TIMED_OUT,done:!1});m(r,"ld")},c||4E3)}var t={NO_CONTROLLER:"no_ctrl",TIMED_OUT:"timed_out",
UNSUPPORTED_BROWSER:"unsupported_browser",UNEXPECTED_RESPONSE:"unexpected_response"},r=g(":",a.feature,a.command),l,n=!0;if("MessageChannel"in d&&e&&"controller"in e)if(e.controller){var p=new MessageChannel;p.port1.onmessage=function(c){(c=c.data)&&c.feature===a.feature&&c.command===a.command?(n&&(m(r,"cf"),n=!1),m(r,"af"),clearTimeout(l),c.done||H(),c.ok?b&&k(b.success)&&b.success(c):f(c),c.done&&m(r,"ld")):h(g(":","sw:"+r,t.UNEXPECTED_RESPONSE),1)};H();m(r,"bb");e.controller.postMessage(a,[p.port2])}else q(g(":",
"sw:"+a.feature,t.NO_CONTROLLER)),f({ok:!1,statusCode:t.NO_CONTROLLER,done:!0});else q(g(":","sw:"+a.feature,t.UNSUPPORTED_BROWSER)),f({ok:!1,statusCode:t.UNSUPPORTED_BROWSER,done:!0})};(function(){e?(m("ctrl_changed","bb"),e.addEventListener("controllerchange",function(){q("sw:ctrl_changed");m("ctrl_changed","ld")})):h(g(":","sw:ctrl_changed","sw_unsupp"),1)})();(function(){var a=function(){m(b,"ld");var a=d.uex;J({feature:"page_proxy",command:"request_feature_tags"},{success:function(b){b=b.data;
Array.isArray(b)&&b.forEach(function(a){"string"===typeof a?q(g(":","sw:ppft",a)):h(g(":","sw:ppft","invalid_tag"),1)});h(g(":","sw:ppft","success"),1);C&&C.isl&&k(a)&&a("at")},failure:function(a){h(g(":","sw:ppft","error:"+(a.statusCode||"ppft_error")),1)}})};if("requestIdleCallback"in d){var b=g(":","ppft","callback_ricb");d.requestIdleCallback(a,{timeout:1E3})}else b=g(":","ppft","callback_timeout"),setTimeout(a,0);m(b,"bb")})();var A={reg:{},unreg:{}};A.reg.mshop={action:D};A.reg.browser={action:D};
(function(a){var b=a.reg,c=a.unreg;e&&e.getRegistrations?(w.when("A").execute(function(b){if((a.reg.mshop||a.unreg.mshop)&&"function"===typeof n&&n(b)){var f=a.reg.mshop?"T1":"C",e=d.ue;e&&e.trigger?e.trigger("MSHOP_SW_CLIENT_446196",f):h("sw:mshop:wt:failed")}F(b,c,"unregister")}),x(d,"load",function(){w.when("A").execute(function(a){F(a,b,"register");E()})})):(G(b&&b.browser,c&&c.browser,"browser"),w.when("A").execute(function(a){"function"===typeof n&&n(a)&&G(b&&b.mshop,c&&c.mshop,"mshop_and")}))})(A)}))}}()})(window,
document,Date);(function(b,a,J,C){"use strict";b._pd=function(){var c,v;return function(D,e,g,h,d,E,w,F,G){function x(b){try{return b()}catch(K){return!1}}function p(c){return b.matchMedia?b.matchMedia(c):{matches:!1}}function k(){if(l){var y=c.mobile||c.tablet?q.matches&&m.matches:m.matches;if(z!==y){var a={w:b.innerWidth||d.clientWidth,h:b.innerHeight||d.clientHeight};if(17<Math.abs(r.w-a.w)||50<Math.abs(r.h-a.h))r=a,(z=y)?h(d,"a-ws"):d.className=w(d,"a-ws")}}}function H(b){(l=b===C?!l:!!b)&&k()}function I(){return l}
if(!v){v=!0;var t=function(){var b=["O","ms","Moz","Webkit"],c=a.createElement("div");return{testGradients:function(){return!0},test:function(a){var d=a.charAt(0).toUpperCase()+a.substr(1);a=(b.join(d+" ")+d+" "+a).split(" ");for(d=a.length;d--;)if(""===c.style[a[d]])return!0;return!1},testTransform3d:function(){return!0}}}();g=d.className;var A=/(^| )a-mobile( |$)/.test(g),B=/(^| )a-tablet( |$)/.test(g);c={audio:function(){return!!a.createElement("audio").canPlayType},video:function(){return!!a.createElement("video").canPlayType},
canvas:function(){return!!a.createElement("canvas").getContext},svg:function(){return!!a.createElementNS&&!!a.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect},offline:function(){return navigator.hasOwnProperty&&navigator.hasOwnProperty("onLine")&&navigator.onLine},dragDrop:function(){return"draggable"in a.createElement("span")},geolocation:function(){return!!navigator.geolocation},history:function(){return!(!b.history||!b.history.pushState)},webworker:function(){return!!b.Worker},
autofocus:function(){return"autofocus"in a.createElement("input")},inputPlaceholder:function(){return"placeholder"in a.createElement("input")},textareaPlaceholder:function(){return"placeholder"in a.createElement("textarea")},localStorage:function(){return"localStorage"in b&&null!==b.localStorage},orientation:function(){return"orientation"in b},touch:function(){return"ontouchend"in a},gradients:function(){return t.testGradients()},hires:function(){var a=b.devicePixelRatio&&1.5<=b.devicePixelRatio||
b.matchMedia&&b.matchMedia("(min-resolution:144dpi)").matches;F("hiRes"+(A?"Mobile":B?"Tablet":"Desktop"),a?1:0);return a},transform3d:function(){return t.testTransform3d()},touchScrolling:function(){return e(/Windowshop|android|OS ([5-9]|[1-9][0-9]+)(_[0-9]{1,2})+ like Mac OS X|SOFTWARE=([5-9]|[1-9][0-9]+)(.[0-9]{1,2})+.*DEVICE=iPhone|Chrome|Silk|Firefox|Trident.+?; Touch/i)},ios:function(){return e(/OS [1-9][0-9]*(_[0-9]*)+ like Mac OS X/i)&&!e(/trident|Edge/i)},android:function(){return e(/android.([1-9]|[L-Z])/i)&&
!e(/trident|Edge/i)},mobile:function(){return A},tablet:function(){return B},rtl:function(){return"rtl"===d.dir}};for(var f in c)c.hasOwnProperty(f)&&(c[f]=x(c[f]));for(var u="textShadow textStroke boxShadow borderRadius borderImage opacity transform transition".split(" "),n=0;n<u.length;n++)c[u[n]]=x(function(){return t.test(u[n])});var l=!0,r={w:0,h:0},q=p("(orientation:landscape)"),m=c.mobile||c.tablet?p("(min-width:451px)"):p("(min-width:1250px)");q.addListener&&q.addListener(k);m.addListener&&
m.addListener(k);var z;k();d.className=w(d,"a-no-js");h(d,"a-js");!e(/OS [1-8](_[0-9]*)+ like Mac OS X/i)||b.navigator.standalone||e(/safari/i)||h(d,"a-ember");g=[];for(f in c)c.hasOwnProperty(f)&&c[f]&&g.push("a-"+f.replace(/([A-Z])/g,function(a){return"-"+a.toLowerCase()}));h(d,g.join(" "));d.setAttribute("data-aui-build-date",G);D.register("p-detect",function(){return{capabilities:c,localStorage:c.localStorage&&E,toggleResponsiveGrid:H,responsiveGridEnabled:I}});return c||{}}}}()})(window,document,
Date);(function(g,l,E,F){function G(a){n&&n.tag&&n.tag(p(":","aui",a))}function m(a,b){n&&n.count&&n.count("aui:"+a,0===b?0:b||(n.count("aui:"+a)||0)+1)}function H(a){try{return a.test(navigator.userAgent)}catch(b){return!1}}function I(a){return"function"===typeof a}function u(a,b,d){a.addEventListener?a.addEventListener(b,d,!1):a.attachEvent&&a.attachEvent("on"+b,d)}function p(a,b,d,e){b=b&&d?b+a+d:b||d;return e?p(a,b,e):b}function y(a,b,d){try{Object.defineProperty(a,b,{value:d,writable:!1})}catch(e){a[b]=
d}return d}function R(a,b){a.className=S(a,b)+" "+b}function S(a,b){return(" "+a.className+" ").split(" "+b+" ").join(" ").replace(/^ | $/g,"")}function J(a){(a||[]).forEach(function(a){a in z||(z[a]=1,J(T[a]))})}function ha(a,b,d){var e=a.length,f=e,c=function(){f--||((d&&z.hasOwnProperty(d)?A:K).push(b),L||(q?q.set(B):setTimeout(B,0),L=!0))};for(c();e--;)U[a[e]]?c():(v[a[e]]=v[a[e]]||[]).push(c)}function ia(a,b,d,e,f){var c=l.createElement(a?"script":"link");u(c,"error",e);f&&u(c,"load",f);a?(c.type=
"text/javascript",c.async=!0,d&&/AUIClients|images[/]I/.test(b)&&c.setAttribute("crossorigin","anonymous"),c.src=b):(c.rel="stylesheet",c.href=b);l.getElementsByTagName("head")[0].appendChild(c)}function V(a,b){return function(d,e){function f(){ia(b,d,c,function(b){M?m("resource_unload"):c?(c=!1,m("resource_retry"),f()):(m("resource_error"),a.log("Asset failed to load: "+d));b&&b.stopPropagation?b.stopPropagation():g.event&&(g.event.cancelBubble=!0)},e)}if(W[d])return!1;W[d]=!0;m("resource_count");
var c=!0;return!f()}}function ja(a,b,d){for(var e={name:a,guard:function(c){return b.guardFatal(a,c)},guardTime:function(a){return b.guardTime(a)},logError:function(c,d,e){b.logError(c,d,e,a)}},f=[],c=0;c<d.length;c++)C.hasOwnProperty(d[c])&&(f[c]=N.hasOwnProperty(d[c])?N[d[c]](C[d[c]],e):C[d[c]]);return f}function w(a,b,d,e,f){return function(c,k){function n(){var a=null;e?a=k:I(k)&&(q.start=r(),a=k.apply(g,ja(c,h,l)),q.end=r());if(b){C[c]=a;a=c;for(U[a]=!0;(v[a]||[]).length;)v[a].shift()();delete v[a]}q.done=
!0}var h=f||this;I(c)&&(k=c,c=F);b&&(c=c?c.replace(X,""):"__NONAME__",O.hasOwnProperty(c)&&h.error(p(", reregistered by ",p(" by ",c+" already registered",O[c]),h.attribution),c),O[c]=h.attribution);for(var l=T[c]=[],m=0;m<a.length;m++)l[m]=a[m].replace(X,"");var q=x[c||"anon"+ ++ka]={depend:l,registered:r(),namespace:h.namespace};c&&z.hasOwnProperty(c)&&J(l);d?n():ha(l,h.guardFatal(c,n),c);return{decorate:function(a){N[c]=h.guardFatal(c,a)}}}}function Y(a){return function(){var b=Array.prototype.slice.call(arguments);
return{execute:w(b,!1,a,!1,this),register:w(b,!0,a,!1,this)}}}function P(a,b){return function(d,e){e||(e=d,d=F);var f=this.attribution;return function(){h.push(b||{attribution:f,name:d,logLevel:a});var c=e.apply(this,arguments);h.pop();return c}}}function D(a,b){this.load={js:V(this,!0),css:V(this)};y(this,"namespace",b);y(this,"attribution",a)}function Z(){l.body?k.trigger("a-bodyBegin"):setTimeout(Z,20)}"use strict";var t=E.now=E.now||function(){return+new E},r=function(a){return a&&a.now?a.now.bind(a):
t}(g.performance),la=r(),z={},T={},n=g.ue;G();G("aui_build_date:3.25.1-2025-03-20");var aa={getItem:function(a){try{return g.localStorage.getItem(a)}catch(b){}},setItem:function(a,b){try{return g.localStorage.setItem(a,b)}catch(d){}}},q=g._pSetI(),K=[],A=[],L=!1,ma=navigator.scheduling&&"function"===typeof navigator.scheduling.isInputPending;var B=function(){for(var a=q?q.set(B):setTimeout(B,0),b=t();A.length||K.length;)if((A.length?A:K).shift()(),q&&ma){if(150<t()-b&&!navigator.scheduling.isInputPending()||
50<t()-b&&navigator.scheduling.isInputPending())return}else if(50<t()-b)return;q?q.clear(a):clearTimeout(a);L=!1};var U={},v={},W={},M=!1;u(g,"beforeunload",function(){M=!0;setTimeout(function(){M=!1},1E4)});var X=/^prv:/,O={},C={},N={},x={},ka=0,ba=String.fromCharCode(92),h=[],ca=!0,da=g.onerror;g.onerror=function(a,b,d,e,f){f&&"object"===typeof f||(f=Error(a,b,d),f.columnNumber=e,f.stack=b||d||e?p(ba,f.message,"at "+p(":",b,d,e)):F);var c=h.pop()||{};f.attribution=p(":",f.attribution||c.attribution,
c.name);f.logLevel=c.logLevel;f.attribution&&console&&console.log&&console.log([f.logLevel||"ERROR",a,"thrown by",f.attribution].join(" "));h=[];da&&(c=[].slice.call(arguments),c[4]=f,da.apply(g,c))};D.prototype={logError:function(a,b,d,e){b={message:b,logLevel:d||"ERROR",attribution:p(":",this.attribution,e)};if(g.ueLogError)return g.ueLogError(a||b,a?b:null),!0;console&&console.error&&(console.log(b),console.error(a));return!1},error:function(a,b,d,e){a=Error(p(":",e,a,d));a.attribution=p(":",this.attribution,
b);throw a;},guardError:P(),guardFatal:P("FATAL"),guardCurrent:function(a){var b=h[h.length-1];return b?P(b.logLevel,b).call(this,a):a},guardTime:function(a){var b=h[h.length-1],d=b&&b.name;return d&&d in x?function(){var b=r(),f=a.apply(this,arguments);x[d].async=(x[d].async||0)+r()-b;return f}:a},log:function(a,b,d){return this.logError(null,a,b,d)},declare:w([],!0,!0,!0),register:w([],!0),execute:w([]),AUI_BUILD_DATE:"3.25.1-2025-03-20",when:Y(),now:Y(!0),trigger:function(a,b,d){var e=t();this.declare(a,
{data:b,pageElapsedTime:e-(g.aPageStart||NaN),triggerTime:e});d&&d.instrument&&Q.when("prv:a-logTrigger").execute(function(b){b(a)})},handleTriggers:function(){this.log("handleTriggers deprecated")},attributeErrors:function(a){return new D(a)},_namespace:function(a,b){return new D(a,b)},setPriority:function(a){ca?(ca=!1,J(a)):this.log("setPriority only accept the first call.")}};var k=y(g,"AmazonUIPageJS",new D);var Q=k._namespace("PageJS","AmazonUI");Q.declare("prv:p-debug",x);k.declare("p-recorder-events",
[]);k.declare("p-recorder-stop",function(){});y(g,"P",k);Z();if(l.addEventListener){var ea;l.addEventListener("DOMContentLoaded",ea=function(){k.trigger("a-domready");l.removeEventListener("DOMContentLoaded",ea,!1)},!1)}var fa=l.documentElement,na=g._pd(k,H,u,R,fa,aa,S,m,"3.25.1-2025-03-20");H(/UCBrowser/i)||na.localStorage&&R(fa,aa.getItem("a-font-class"));k.declare("a-event-revised-handling",!1);g._sw(Q,p,H,ba,m,n,G,I,u,k);k.declare("a-fix-event-off",!1);m("pagejs:pkgExecTime",r()-la)})(window,
document,Date);
(function(b){function q(a,e,d){function g(a,b,c){var f=Array(e.length);~l&&(f[l]={});~m&&(f[m]=c);for(c=0;c<n.length;c++){var g=n[c],h=a[c];f[g]=h}for(c=0;c<p.length;c++)g=p[c],h=b[c],f[g]=h;a=d.apply(null,f);return~l?f[l]:a}"string"!==typeof a&&b.P.error("C001");-1===a.indexOf("@")&&-1<a.indexOf("/")&&(-1<a.indexOf("es3")||-1<a.indexOf("evergreen"))&&(a=a.substring(0,a.lastIndexOf("/")));if(!r[a]){r[a]=!0;d||(d=e,e=[]);a=a.split(":",2);var c=a[1]?a[0]:void 0,f=(a[1]||a[0]).replace(/@capability//,
"@c/"),k=c?b.P._namespace(c):b.P,t=!f.lastIndexOf("@c/",0),u=!f.lastIndexOf("@m/",0),n=[];a=[];var p=[],v=[],m=-1,l=-1;for(c=0;c<e.length;c++){var h=e[c];"module"===h&&k.error("C002");"exports"===h?l=c:"require"===h?m=c:h.lastIndexOf("@p/",0)?h.lastIndexOf("@c/",0)&&h.lastIndexOf("@m/",0)?(n.push(c),a.push("mix:"+h)):(p.push(c),v.push(h)):(n.push(c),a.push(h.substr(3)))}k.when.apply(k,a).register("mix:"+f,function(){var a=[].slice.call(arguments);return t||u||~m||p.length?{capabilities:v,cardModuleFactory:function(b,
c){b=g(a,b,c);b.P=k;return b},require:~m?q:void 0}:g(a,[],function(){})});(t||u)&&k.when("mix:@amzn/mix.client-runtime","mix:"+f).execute(function(a,b){a.registerCapabilityModule(f,b)});k.when("mix:"+f).register("xcp:"+f,function(a){return a});var q=function(a,b,c){try{var e=-1<f.indexOf("/")?f.split("/")[0]:f,d=a[0],g=d.lastIndexOf("./",0)?d:e+"/"+d.substr(2),h=g.lastIndexOf("@p/",0)?"mix:"+g:g.substr(3);k.when(h).execute(function(a){try{b(a)}catch(x){c(x)}})}catch(w){c(w)}}}}"use strict";var r=
{};b.mix_d||((b.Promise?P:P.when("3p-promise")).register("@p/promise-is-ready",function(a){b.Promise=b.Promise||a}),(Array.prototype.includes?P:P.when("a-polyfill")).register("@p/polyfill-is-ready",function(){}),b.mix_d=function(a,b,d){P.when("@p/promise-is-ready","@p/polyfill-is-ready").execute("@p/mix-d-deps",function(){q(a,b,d)})},b.xcp_d=b.mix_d,P.when("mix:@amzn/mix.client-runtime").execute(function(a){P.declare("xcp:@xcp/runtime",a)}));b.mixTimeout||(b.mixTimeout=function(a,e,d){b.mixCardInitTimeouts||
(b.mixCardInitTimeouts={});b.mixCardInitTimeouts[e]&&clearTimeout(b.mixCardInitTimeouts[e]);b.mixCardInitTimeouts[e]=setTimeout(function(){P.log("Client-side initialization timeout","WARN",a)},d)});b.mix_csa_map=b.mix_csa_map||{};b.mix_csa_internal=b.mix_csa_internal||function(a,e,d){return b.mix_csa_map[e]=b.mix_csa_map[e]||b.csa(a,d)};b.mix_csa_internal_key=b.mix_csa_internal_key||function(a,b){for(var d="",e=0;e<b.length;e++){var c=b[e];void 0!==a[c]&&"object"!==typeof a[c]&&(d+=c+":"+a[c]+",")}if(!d)throw Error("bad mix-csa key gen.");
return d};b.mix_csa_event=b.mix_csa_event||function(a){try{var e=b.mix_csa_internal_key(a,["producerId"])}catch(d){return P.logError(d,"MIX C005","WARN",void 0),function(){}}try{return b.mix_csa_internal("Events",e,a)}catch(d){return P.logError(d,"MIX C004","WARN",e),function(){}}};b.mix_csa=b.mix_csa||function(a,e){try{e=e||"";var d=document.querySelectorAll(a);if(1<d.length)for(var g=0;g<d.length;g++){if(d[g].querySelector(e)){var c=d[g];break}}else 1===d.length&&(c=d[0]);if(!c)throw Error(" ");
return b.mix_csa_internal("Content",a,{element:c})}catch(f){return P.logError(f,"MIX C004","WARN",a),function(){}}}})(window);
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('sp.load.js').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/61xJcNKKLXL.js?AUIClients/AmazonUIjQuery');
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/11zuylp74DL._RC|11Y+5x+kkTL.js,51LPrROZ2JL.js,11EeeaacI2L.js,11GgN1+C7hL.js,01+z+uIeJ-L.js,01VRMV3FBdL.js,21NadQlXUWL.js,012FVc3131L.js,11a7qqY8xXL.js,11rRjDLdAVL.js,51zH7YD-TsL.js,11FhdH2HZwL.js,11wb9K3sw0L.js,11BrgrMAHUL.js,11GYEyswV2L.js,210X-JWUe-L.js,01Svfxfy8OL.js,518u7YD3VHL.js,01JYHc2oIlL.js,31nfKXylf6L.js,01ktRCtOqKL.js,01ASnt2lbqL.js,11F929pmpYL.js,31vxRYDelFL.js,01rpauTep4L.js,31wjiT+nvTL.js,011FfPwYqHL.js,213iL7Jf1nL.js,014gnDeJDsL.js,11vb6P5C5AL.js,01O9cz+pldL.js_.js?AUIClients/AmazonUI#372963-T1');
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/51tQKx1B9KL.js?AUIClients/CardJsRuntimeBuzzCopyBuild');
});
</script>
<!-- sp:end-feature:aui-assets -->
<!-- sp:feature:nav-inline-css -->
<!-- NAVYAAN CSS -->

<style type="text/css">
.nav-sprite-v1 .nav-sprite, .nav-sprite-v1 .nav-icon {
  background-image: url(https://m.media-amazon.com/images/G/01/gno/sprites/nav-sprite-global-1x-reorg-privacy._CB546805360_.png);
  background-position: 0 1000px;
  background-repeat: repeat-x;
}
.nav-spinner {
  background-image: url(https://m.media-amazon.com/images/G/01/javascripts/lib/popover/images/snake._CB485935611_.gif);
  background-position: center center;
  background-repeat: no-repeat;
}
.nav-timeline-icon, .nav-access-image, .nav-timeline-prime-icon {
  background-image: url(https://m.media-amazon.com/images/G/01/gno/sprites/timeline_sprite_1x._CB485945973_.png);
  background-repeat: no-repeat;
}
</style>
<link rel="stylesheet" href="https://images-na.ssl-images-amazon.com/images/I/41oqEIFYdwL._RC|71EHriEIM7L.css,51JyeimZRFL.css,21p9CgkFtzL.css,01FcI3FsaiL.css,21Hc1s0-E4L.css,31YZpDCYJPL.css,21DwGGPS1eL.css,41rsT0y+7tL.css,11Wa5gEoKhL.css,31K0jc2KvHL.css,01H8CHB5aiL.css,21KQnzhmfTL.css,41yKpEQVJkL.css,41FQVcfy5lL.css_.css?AUIClients/NavDesktopUberAsset#desktop.language-en.us.488657-T2.1089549-T1.1173010-T1.310484-T1.1179039-T1.1168668-C" />
<!-- sp:end-feature:nav-inline-css -->
<!-- sp:feature:host-assets -->
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/11ikU6MX1JL._RC|11-cL60xzwL.css,01dUqMyC5zL.css,01zuhLyhUCL.css,21uQsWDlzBL.css,51YmaMbne5L.css,21TugutLpHL.css,01Y+rQYR1fL.css,0121zKjk26L.css,31GwobWEh2L.css,11xRy3bSkOL.css,01sd0YVrBlL.css,01D-B-OeNDL.css,01Ie8mDBSFL.css,21ix86FkfXL.css,11eUFE9nUtL.css,21VJkWw5reL.css,216+niS0ccL.css,21HpY-6TKaL.css,41vOQb1k0LL.css,31h9mmgtzWL.css,31TJtSmBkXL.css,11X8K4AolpL.css,21PjfsP9YvL.css,4130GA9KMiL.css,11kmwdXfY5L.css,31xOdlwrVxL.css,51pQTJfxJbL.css,01RsT9T6lrL.css,11X5EGjnN-L.css,21wJ9sXr8kL.css,21H7mFgqBYL.css,01I+N4GU47L.css,11mqgJVSK9L.css,01P0iSwDaIL.css,01pi1oDEPFL.css,11wQIGy3uGL.css,01C7SPIynDL.css,31MWrYD148L.css,01W62HxacXL.css,61exUnGaKzL.css,21UZhQX3Y2L.css,31TcFnRur-L.css,31cUjoFwJVL.css,41KQpcRKbaL.css,01ZpHhtNc4L.css,21W5fiSj06L.css,11bWml9MvZL.css,01wkbZw3FtL.css,01NW8VTUeVL.css,01cu80pBkuL.css,41VahDU4eiL.css,11edBn7Le0L.css,31b7gmE5aML.css,21bT8BmCRSL.css,21JgKpjxfmL.css,41qRC-gouAL.css,51zhuDdLmqL.css,71vkbpX3TFL.css,01UpniK0lyL.css,01WdJkFf2xL.css,014odsh6+QL.css,31YRQb-ZBTL.css,01qwEWNuxuL.css,21qxDmhZV3L.css,11XXguyjjZL.css,31LPDlue2jL.css,01-tcA2vk0L.css,01yo7ZZNxmL.css,31nGoarvVcL.css,01adN84djtL.css,01+KRP2j52L.css,01muB6xKhLL.css,11scpebV7yL.css,010kW5Xhu3L.css,21hHa2nbr8L.css,01v1YC6Gd2L.css,21U-NQf3tNL.css,01FL7JU2DtL.css,415INpa7lVL.css,31rao7YK8hL.css,31fNEss5igL.css,41PAwDYl+HL.css_.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/11DbyV7EqEL._RC|31Woe0xBtCL.js,41VeBij8NNL.js,21sRWHXHCoL.js,31PxFwobuyL.js,311zP7kfZ8L.js,41RHIDFqOcL.js,41ZZwtBIKHL.js,316nVZ1c+gL.js,31stVn-QHnL.js,01S4a+TTNzL.js,21k64tJXtcL.js,318rs4piGPL.js,01jEqq6I0UL.js,01xGyUiM+9L.js,41DfHGdXUeL.js,11LSI8IU0NL.js,41SFTqkjoUL.js,31QmRDAhJvL.js,51ioB2424FL.js,01TQyo0bnIL.js,21C3M3rTuUL.js,51r5sYb+vHL.js,61sM0h9jL2L.js,51C66Bod6dL.js,11p0nLfNCcL.js,01s9HEfbt3L.js,11CGomdzAuL.js,61sIZJADqAL.js,111zW1Nhl9L.js,21F+2VGtGTL.js,510butzZCbL.js,0120VCfYOtL.js,31pCf6pr+0L.js,41sO6vauZDL.js,51dVjPLPzEL.js,41itcSjEIsL.js,51UABvvMKEL.js,31vI2qZfDdL.js,01Iqaokl00L.js,31ioPTd02RL.js,11K5qCK19CL.js,21RsH9fH8-L.js,11KyJ7tKkeL.js,61FunZkZY0L.js,21dOHK8m83L.js,01pds886sCL.js_.js?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/31wdyiGPg0L._RC|21YblE14ZTL.js,01+oIQ0jY7L.js,11a+lhxkUrL.js,51aAvVQUYTL.js,4123BTTtUrL.js,21J1hhP1B-L.js,015TRQC5i+L.js,215CwMEoxhL.js,21XCf-r9HCL.js,01lcH4zcTaL.js,61+hVUfDKWL.js,01g2etah0NL.js,21v7Os12mhL.js,11PUEGgF9FL.js,61N01lTlRBL.js,013eoEBTVUL.js,71w9uzapfnL.js,51BAiIRlP4L.js,51LTpZWWtjL.js,01pEpg0ouXL.js,21boI4UW9cL.js,31DwCDV0WwL.js,41MG0MimB0L.js,01mjV3L7d0L.js,01cyf4FMJWL.js,61dqGNG-JKL.js,018Z4BaAhLL.js,21aV7NRVBKL.js,01gp3oqpb5L.js,31tA6tcUUNL.js,21-71xWjt2L.js,01zM73lDxwL.js,011kwg0OTQL.js,014kCoIHgIL.js,21uQ+O0IQvL.js,01b64aH9GxL.js,01WQALympXL.js,21uoMY-BrjL.js,41kJwg9GluL.js,11uacn9D5ZL.js,41Debmz01QL.js,01ApP2Vv5yL.js,31QJX79s82L.js,31dzV2TisrL.js,41MujoHro1L.js,41878Hwie5L.js,41URVeWP1BL.js,0126YIoj+oL.js,41c01AilBTL.js,21ETe06wE4L.js,21IQl4blS4L.js,31jdfgcsPAL.js,31KODaExcKL.js,019MkidFEWL.js,01lb9cuSpfL.js,11sjHLvE-aL.js,21WsF3Zbb5L.js,511EWL1uEbL.js,21cax74eOHL.js,01CTKyZrFPL.js,61NakFhRWML.js,51fEsH26qZL.js_.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('dpJsAssetsLoadMarker').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/11DbyV7EqEL._RC|31Woe0xBtCL.js,41VeBij8NNL.js,21sRWHXHCoL.js,31PxFwobuyL.js,311zP7kfZ8L.js,41RHIDFqOcL.js,41ZZwtBIKHL.js,316nVZ1c+gL.js,31stVn-QHnL.js,01S4a+TTNzL.js,21k64tJXtcL.js,318rs4piGPL.js,01jEqq6I0UL.js,01xGyUiM+9L.js,41DfHGdXUeL.js,11LSI8IU0NL.js,41SFTqkjoUL.js,31QmRDAhJvL.js,51ioB2424FL.js,01TQyo0bnIL.js,21C3M3rTuUL.js,51r5sYb+vHL.js,61sM0h9jL2L.js,51C66Bod6dL.js,11p0nLfNCcL.js,01s9HEfbt3L.js,11CGomdzAuL.js,61sIZJADqAL.js,111zW1Nhl9L.js,21F+2VGtGTL.js,510butzZCbL.js,0120VCfYOtL.js,31pCf6pr+0L.js,41sO6vauZDL.js,51dVjPLPzEL.js,41itcSjEIsL.js,51UABvvMKEL.js,31vI2qZfDdL.js,01Iqaokl00L.js,31ioPTd02RL.js,11K5qCK19CL.js,21RsH9fH8-L.js,11KyJ7tKkeL.js,61FunZkZY0L.js,21dOHK8m83L.js,01pds886sCL.js_.js?AUIClients/');
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/31wdyiGPg0L._RC|21YblE14ZTL.js,01+oIQ0jY7L.js,11a+lhxkUrL.js,51aAvVQUYTL.js,4123BTTtUrL.js,21J1hhP1B-L.js,015TRQC5i+L.js,215CwMEoxhL.js,21XCf-r9HCL.js,01lcH4zcTaL.js,61+hVUfDKWL.js,01g2etah0NL.js,21v7Os12mhL.js,11PUEGgF9FL.js,61N01lTlRBL.js,013eoEBTVUL.js,71w9uzapfnL.js,51BAiIRlP4L.js,51LTpZWWtjL.js,01pEpg0ouXL.js,21boI4UW9cL.js,31DwCDV0WwL.js,41MG0MimB0L.js,01mjV3L7d0L.js,01cyf4FMJWL.js,61dqGNG-JKL.js,018Z4BaAhLL.js,21aV7NRVBKL.js,01gp3oqpb5L.js,31tA6tcUUNL.js,21-71xWjt2L.js,01zM73lDxwL.js,011kwg0OTQL.js,014kCoIHgIL.js,21uQ+O0IQvL.js,01b64aH9GxL.js,01WQALympXL.js,21uoMY-BrjL.js,41kJwg9GluL.js,11uacn9D5ZL.js,41Debmz01QL.js,01ApP2Vv5yL.js,31QJX79s82L.js,31dzV2TisrL.js,41MujoHro1L.js,41878Hwie5L.js,41URVeWP1BL.js,0126YIoj+oL.js,41c01AilBTL.js,21ETe06wE4L.js,21IQl4blS4L.js,31jdfgcsPAL.js,31KODaExcKL.js,019MkidFEWL.js,01lb9cuSpfL.js,11sjHLvE-aL.js,21WsF3Zbb5L.js,511EWL1uEbL.js,21cax74eOHL.js,01CTKyZrFPL.js,61NakFhRWML.js,51fEsH26qZL.js_.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/01b0YsU3dsL._RC|11Q2UEVwwYL.css,01+PGV9EvOL.css,01uhBebc3oL.css_.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/11e6YKvz8HL._RC|61vM6PxEmrL.js,611GSvclGaL.js,11mVFZW2AcL.js,21Nmk-pXMzL.js,11-YCKCUgML.js,11uC0Nyw-gL.js_.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('sp.load.js').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/11e6YKvz8HL._RC|61vM6PxEmrL.js,611GSvclGaL.js,11mVFZW2AcL.js,21Nmk-pXMzL.js,11-YCKCUgML.js,11uC0Nyw-gL.js_.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/41GR4r13VlL.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/51TyLrZRyUL.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('useDesktopTwisterMetaAsset').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/51TyLrZRyUL.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/31d+YMwczsL._RC|01r8lpNJhRL.css,012Fi5I-rKL.css_.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/51GmnWFDRjL._RC|31oaREv-wIL.js,31tJKFiAUTL.js,71qiImK8AoL.js,31l+BtxlN3L.js_.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('useDesktopTwisterMetaAsset').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/51GmnWFDRjL._RC|31oaREv-wIL.js,31tJKFiAUTL.js,71qiImK8AoL.js,31l+BtxlN3L.js_.js?AUIClients/');
});
</script>
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/91du+-xAQJL.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('gestaltCustomizableProductDetailPage').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/91du+-xAQJL.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/01Io73Ll09L.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/313sHJh1gZL.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('dpJsAssetsLoadMarker').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/313sHJh1gZL.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/11L9g59fN-L.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/21+3NfuRrDL.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('dpJsAssetsLoadMarker').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/21+3NfuRrDL.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/31F9SzdeJLL.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/61e6i91+I6L._RC|71LVgqy2ckL.js,31jsB13JlVL.js_.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('useBuyingRulesDpAssets').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/61e6i91+I6L._RC|71LVgqy2ckL.js,31jsB13JlVL.js_.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/01Qew71Yx0L._RC|11o52dO+T7L.css,01UqkjH7qOL.css,01NuAxux7eL.css,01bTUA+3s-L.css,11wchaCZLgL.css_.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/01I3s4SlPiL._RC|21Awk0AtTML.js,216Y5JcOfSL.js,11-asXJWfkL.js,01s80TZosWL.js,015gdESSAtL.js,01GJONmvbXL.js,017VcaK0ACL.js,01Gujc1zuyL.js,71P-vrO4rdL.js_.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('dpJsAssetsLoadMarker').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/01I3s4SlPiL._RC|21Awk0AtTML.js,216Y5JcOfSL.js,11-asXJWfkL.js,01s80TZosWL.js,015gdESSAtL.js,01GJONmvbXL.js,017VcaK0ACL.js,01Gujc1zuyL.js,71P-vrO4rdL.js_.js?AUIClients/');
});
</script>
<script>
(function(e){var a=window.AmazonUIPageJS||window.P,c=a._namespace||a.attributeErrors,b=c?c("DetailPageLatencyClientSideLibraries@timeToInteractive","DetailPageLatencyClientSideLibraries"):a;b.guardFatal?b.guardFatal(e)(b,window):b.execute(function(){e(b,window)})})(function(e,a,c){e.now().execute("dp-create-feature-interactive-api",function(){function b(d,b,a){d={name:d,options:b,type:a,timestamp:+new Date};f?f.updateFeatures([d]):c.push(d)}"function"===typeof uet&&uet("bb","clickToCI",{wb:1});var c=
[],f;a.markFeatureRender=function(d,a){b(d,a,"render")};a.markFeatureInteractive=function(a,c){b(a,c,"interactive")};e.when("dp-time-to-interactive").execute("dp-update-interactive-feature-list",function(a){f=a;c.length&&f.updateFeatures(c)})})});
</script>
<script>
(function(b){var c=window.AmazonUIPageJS||window.P,d=c._namespace||c.attributeErrors,a=d?d("DetailPageLatencyClientSideLibraries@dpJsAssetsLoadMarker","DetailPageLatencyClientSideLibraries"):c;a.guardFatal?a.guardFatal(b)(a,window):a.execute(function(){b(a,window)})})(function(b,c,d){b.when("atf").execute(function(){b.now("dpJsAssetsLoadMarker").execute(function(a){a||(b.declare("dpJsAssetsLoadMarker",{}),c.ue&&ue.count&&ue.count("DPJsLoadedAfterATFMarkedCount",1))})})});
</script>
<script>
(function(b){var c=window.AmazonUIPageJS||window.P,d=c._namespace||c.attributeErrors,a=d?d("DetailPageLatencyClientSideLibraries@emitSpLoadJsScript","DetailPageLatencyClientSideLibraries"):c;a.guardFatal?a.guardFatal(b)(a,window):a.execute(function(){b(a,window)})})(function(b,c,d){b.now("sp.load.critical.js").execute(function(a){a||b.declare("sp.load.critical.js",{})});b.now("sp.load.js").execute(function(a){a||b.declare("sp.load.js",{})})});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/11+BsbU2mSL._RC|21IJD91Su3L.css_.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/31vB5DAPhsL.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('injectCalendarOnDetailPage').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/31vB5DAPhsL.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/215FdaIhaQL._RC|11tXw5UsxML.css_.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/01rg6Ce9FhL._RC|61DtTiCWsjL.js,01L9nn2zMmL.js_.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('dpJsAssetsLoadMarker').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/01rg6Ce9FhL._RC|61DtTiCWsjL.js,01L9nn2zMmL.js_.js?AUIClients/');
});
</script>
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/01wwZTjeU+L.css?AUIClients/" />
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/31FE2k3SYqL.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('useOffersDebugAssets').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/31FE2k3SYqL.js?AUIClients/');
});
</script>

<!-- htmlBeginMarker --><!--&&&Portal&Delimite-->
<!--&&&Portal&Delimiter&&&--><!-- sp:end-feature:host-assets -->
<!-- sp:feature:encrypted-slate-token -->
<meta name='encrypted-slate-token' content='AnYxBmAoroiJR/v0W+pUxiuJsD78Ku9AvsyS/jiJmBqth06l9cwDlfgL4+LpEBahBABFDKoQfNCP1BRoQ0AssfW2oOloSGZa0ZsUEdVaoFYNoWx7XeOxMserkpNTz89j7YV1S9UwW7hPUqfHEe5cON+9KgucIl0PryFMkydggVyUI0zAsRheniXh4wQn88HNjixYnOeq4ePJFtobyLAnTuPOhMCJcM6xbtUO7gn3CQD40I+cJFy9sYtzRc2UYOmQKfoQCHtLKk/Yr2xrdIGXJ9WpxTa53rc='>
<!-- sp:end-feature:encrypted-slate-token -->
<!-- sp:feature:csm:head-close -->
<script type='text/javascript'>
window.ue_ihe = (window.ue_ihe || 0) + 1;
if (window.ue_ihe === 1) {
(function(c){c&&1===c.ue_jsmtf&&"object"===typeof c.P&&"function"===typeof c.P.when&&c.P.when("mshop-interactions").execute(function(e){"object"===typeof e&&"function"===typeof e.addListener&&e.addListener(function(b){"object"===typeof b&&"ORIGIN"===b.dataSource&&"number"===typeof b.clickTime&&"object"===typeof b.events&&"number"===typeof b.events.pageVisible&&(c.ue_jsmtf_interaction={pv:b.events.pageVisible,ct:b.clickTime})})})})(ue_csm);
(function(c,e,b){function m(a){f||(f=d[a.type].id,"undefined"===typeof a.clientX?(h=a.pageX,k=a.pageY):(h=a.clientX,k=a.clientY),2!=f||l&&(l!=h||n!=k)?(r(),g.isl&&e.setTimeout(function(){p("at",g.id)},0)):(l=h,n=k,f=0))}function r(){for(var a in d)d.hasOwnProperty(a)&&g.detach(a,m,d[a].parent)}function s(){for(var a in d)d.hasOwnProperty(a)&&g.attach(a,m,d[a].parent)}function t(){var a="";!q&&f&&(q=1,a+="&ui="+f);return a}var g=c.ue,p=c.uex,q=0,f=0,l,n,h,k,d={click:{id:1,parent:b},mousemove:{id:2,
parent:b},scroll:{id:3,parent:e},keydown:{id:4,parent:b}};g&&p&&(s(),g._ui=t)})(ue_csm,window,document);


(function(s,l){function m(b,e,c){c=c||new Date(+new Date+t);c="expires="+c.toUTCString();n.cookie=b+"="+e+";"+c+";path=/"}function p(b){b+="=";for(var e=n.cookie.split(";"),c=0;c<e.length;c++){for(var a=e[c];" "==a.charAt(0);)a=a.substring(1);if(0===a.indexOf(b))return decodeURIComponent(a.substring(b.length,a.length))}return""}function q(b,e,c){if(!e)return b;-1<b.indexOf("{")&&(b="");for(var a=b.split("&"),f,d=!1,h=!1,g=0;g<a.length;g++)f=a[g].split(":"),f[0]==e?(!c||d?a.splice(g,1):(f[1]=c,a[g]=
f.join(":")),h=d=!0):2>f.length&&(a.splice(g,1),h=!0);h&&(b=a.join("&"));!d&&c&&(0<b.length&&(b+="&"),b+=e+":"+c);return b}var k=s.ue||{},t=3024E7,n=ue_csm.document||l.document,r=null,d;a:{try{d=l.localStorage;break a}catch(u){}d=void 0}k.count&&k.count("csm.cookieSize",document.cookie.length);k.cookie={get:p,set:m,updateCsmHit:function(b,e,c){try{var a;if(!(a=r)){var f;a:{try{if(d&&d.getItem){f=d.getItem("csm-hit");break a}}catch(k){}f=void 0}a=f||p("csm-hit")||"{}"}a=q(a,b,e);r=a=q(a,"t",+new Date);
try{d&&d.setItem&&d.setItem("csm-hit",a)}catch(h){}m("csm-hit",a,c)}catch(g){"function"==typeof l.ueLogError&&ueLogError(Error("Cookie manager: "+g.message),{logLevel:"WARN"})}}}})(ue_csm,window);


(function(l,e){function c(b){b="";var c=a.isBFT?"b":"s",d=""+a.oid,g=""+a.lid,h=d;d!=g&&20==g.length&&(c+="a",h+="-"+g);a.tabid&&(b=a.tabid+"+");b+=c+"-"+h;b!=f&&100>b.length&&(f=b,a.cookie?a.cookie.updateCsmHit(m,b+("|"+ +new Date)):e.cookie="csm-hit="+b+("|"+ +new Date)+n+"; path=/")}function p(){f=0}function d(b){!0===e[a.pageViz.propHid]?f=0:!1===e[a.pageViz.propHid]&&c({type:"visible"})}var n="; expires="+(new Date(+new Date+6048E5)).toGMTString(),m="tb",f,a=l.ue||{},k=a.pageViz&&a.pageViz.event&&
a.pageViz.propHid;a.attach&&(a.attach("click",c),a.attach("keyup",c),k||(a.attach("focus",c),a.attach("blur",p)),k&&(a.attach(a.pageViz.event,d,e),d({})));a.aftb=1})(ue_csm,ue_csm.document);


ue_csm.ue.stub(ue,"impression");


ue.stub(ue,"trigger");


if(window.ue&&uet) { uet('bb'); }

}
</script>
<script>window.ue && ue.count && ue.count('CSMLibrarySize', 3172)</script>
<!-- sp:end-feature:csm:head-close -->
<!-- sp:feature:head-close -->
<script>
window.P && P.register('bb');
if (typeof ues === 'function') {
  ues('t0', 'portal-bb', new Date());
  ues('ctb', 'portal-bb', 1);
}
</script>
<link rel="canonical" href="<?= htmlspecialchars($urlPath, ENT_QUOTES, 'UTF-8') ?>"/><meta name="title" content="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>"/><title><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></title><meta name="description" content="<?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') ?>"/>
</head>
<!-- sp:end-feature:head-close -->
<!-- sp:feature:start-body -->
<body class="a-m-us a-aui_72554-c a-aui_a11y_6_837773-c a-aui_killswitch_csa_logger_372963-t1 a-aui_pci_risk_banner_210084-c a-aui_template_weblab_cache_333406-c a-aui_tnr_v2_180836-c a-bw_aui_cxc_alert_measurement_1074111-c"><div id="a-page"><script type="a-state" data-a-state="{&quot;key&quot;:&quot;a-wlab-states&quot;}">{"AUI_A11Y_6_837773":"C","AUI_TNR_V2_180836":"C","AUI_TEMPLATE_WEBLAB_CACHE_333406":"C","BW_AUI_CXC_ALERT_MEASUREMENT_1074111":"C","AUI_72554":"C","AUI_KILLSWITCH_CSA_LOGGER_372963":"T1","AUI_PCI_RISK_BANNER_210084":"C"}</script><script>typeof uex === 'function' && uex('ld', 'portal-bb', {wb: 1})</script><!-- sp:end-feature:start-body -->
<!-- sp:feature:csm:body-open -->


<script>
!function(){function n(n,t){var r=i(n);return t&&(r=r("instance",t)),r}var r=[],c=0,i=function(t){return function(){var n=c++;return r.push([t,[].slice.call(arguments,0),n,{time:Date.now()}]),i(n)}};n._s=r,this.csa=n}();;
csa('Config', {});
if (window.csa) {
    csa("Config", {
        'Application': 'Retail:Prod:www.amazon.com',
        'Events.Namespace': 'csa',
        'ObfuscatedMarketplaceId': 'ATVPDKIKX0DER',
        'Events.SushiEndpoint': 'https://unagi.amazon.com/1/events/com.amazon.csm.csa.prod',
        'CacheDetection.RequestID': "RBW56TXBT3VK1W4DNTET",
        'CacheDetection.Callback': window.ue && ue.reset,
        'LCP.elementDedup': 1,
        'lob': '1'
    });

    csa("Events")("setEntity", {
        page: {requestId: "RBW56TXBT3VK1W4DNTET", meaningful: "interactive"},
        session: {id: "140-0199542-9827343"}
    });
}
!function(r){var e,i,o="splice",u=r.csa,f={},c={},a=r.csa._s,s=0,l=0,g=-1,h={},v={},d={},n=Object.keys,p=function(){};function t(n,t){return u(n,t)}function m(n,t){var r=c[n]||{};k(r,t),c[n]=r,l++,S(U,0)}function w(n,t,r){var i=!0;return t=D(t),r&&r.buffered&&(i=(d[n]||[]).every(function(n){return!1!==t(n)})),i?(h[n]||(h[n]=[]),h[n].push(t),function(){!function(n,t){var r=h[n];r&&r[o](r.indexOf(t),1)}(n,t)}):p}function b(n,t){if(t=D(t),n in v)return t(v[n]),p;return w(n,function(n){return t(n),!1})}function y(n,t){if(u("Errors")("logError",n),f.DEBUG)throw t||n}function E(){return Math.abs(4294967295*Math.random()|0).toString(36)}function D(n,t){return function(){try{return n.apply(this,arguments)}catch(n){y(n.message||n,n)}}}function S(n,t){return r.setTimeout(D(n),t)}function U(){for(var n=0;n<a.length;){var t=a[n],r=t[0]in c;if(!r&&!i)return void(s=a.length);r?(a[o](s=n,1),I(t)):n++}g=l}function I(n){var t=c[n[0]],r=n[1],i=r[0];if(!t||!t[i])return y("Undefined function: "+t+"/"+i);e=n[3],c[n[2]]=t[i].apply(t,r.slice(1))||{},e=0}function O(){i=1,U()}function k(t,r){n(r).forEach(function(n){t[n]=r[n]})}b("$beforeunload",O),m("Config",{instance:function(n){k(f,n)}}),u.plugin=D(function(n){n(t)}),t.config=f,t.register=m,t.on=w,t.once=b,t.blank=p,t.emit=function(n,t,r){for(var i=h[n]||[],e=0;e<i.length;)!1===i[e](t)?i[o](e,1):e++;v[n]=t||{},r&&r.buffered&&(d[n]||(d[n]=[]),100<=d[n].length&&d[n].shift(),d[n].push(t||{}))},t.UUID=function(){return[E(),E(),E(),E()].join("-")},t.time=function(n){var t=e?new Date(e.time):new Date;return"ISO"===n?t.toISOString():t.getTime()},t.error=y,t.warn=function(n,t){if(u("Errors")("logWarn",n),f.DEBUG)throw t||n},t.exec=D,t.timeout=S,t.interval=function(n,t){return r.setInterval(D(n),t)},(t.global=r).csa._s.push=function(n){n[0]in c&&(!a.length||i)?(I(n),a.length&&g!==l&&U()):a[o](s++,0,n)},U(),S(function(){S(O,f.SkipMissingPluginsTimeout||5e3)},1)}("undefined"!=typeof window?window:global);csa.plugin(function(o){var f="addEventListener",e="requestAnimationFrame",t=o.exec,r=o.global,u=o.on;o.raf=function(n){if(r[e])return r[e](t(n))},o.on=function(n,e,t,r){if(n&&"function"==typeof n[f]){var i=o.exec(t);return n[f](e,i,r),function(){n.removeEventListener(e,i,r)}}return"string"==typeof n?u(n,e,t,r):o.blank}});csa.plugin(function(o){var t,n,r={},e="localStorage",c="sessionStorage",a="local",i="session",u=o.exec;function s(e,t){var n;try{r[t]=!!(n=o.global[e]),n=n||{}}catch(e){r[t]=!(n={})}return n}function f(){t=t||s(e,a),n=n||s(c,i)}function l(e){return e&&e[i]?n:t}o.store=u(function(e,t,n){f();var o=l(n);return e?t?void(o[e]=t):o[e]:Object.keys(o)}),o.storageSupport=u(function(){return f(),r}),o.deleteStored=u(function(e,t){f();var n=l(t);if("function"==typeof e)for(var o in n)n.hasOwnProperty(o)&&e(o,n[o])&&delete n[o];else delete n[e]})});csa.plugin(function(n){n.types={ovl:function(n){var r=[];if(n)for(var i in n)n.hasOwnProperty(i)&&r.push(n[i]);return r}}});csa.plugin(function(a){var e=a.config,n="Errors",c="fcsmln",s=e["KillSwitch."+n];function r(n){return function(e){a("Metrics",{producerId:"csa",dimensions:{message:e}})("recordMetric",n,1)}}function t(r){var t,o,l=a("Events",{producerId:r.producerId,lob:e.lob||"0"}),i=["name","type","csm","adb"],u={url:"pageURL",file:"f",line:"l",column:"c"};this.log=function(e){if(!s&&!function(e){if(!e)return!0;for(var n in e)return!1;return!0}(e)){var n=r.logOptions||{ent:{page:["pageType","subPageType","requestId"]}};l("log",function(n){return t=a.UUID(),o={messageId:t,schemaId:r.schemaId||"<ns>.Error.6",errorMessage:n.m||null,attribution:n.attribution||null,logLevel:"FATAL",url:null,file:null,line:null,column:null,stack:n.s||[],context:n.cinfo||{},metadata:{}},n.logLevel&&(o.logLevel=""+n.logLevel),i.forEach(function(e){n[e]&&(o.metadata[e]=n[e])}),c in n&&(o.metadata[c]=n[c]+""),"INFO"===n.logLevel||Object.keys(u).forEach(function(e){"number"!=typeof n[u[e]]&&"string"!=typeof n[u[e]]||(o[e]=""+n[u[e]])}),o}(e),n)}}}a.register(n,{instance:function(e){return new t(e||{})},logError:r("jsError"),logWarn:r("jsWarn")})});csa.plugin(function(o){var r,e,n,t,a,i="function",u="willDisappear",f="$app.",p="$document.",c="focus",s="blur",d="active",l="resign",$=o.global,b=o.exec,m=o.config["Transport.AnonymizeRequests"]||!1,g=o("Events"),h=$.location,v=$.document||{},y=$.P||{},P=(($.performance||{}).navigation||{}).type,w=o.on,k=o.emit,E=v.hidden,T={};h&&v&&(w($,"beforeunload",D),w($,"pagehide",D),w(v,"visibilitychange",R(p,function(){return v.visibilityState||"unknown"})),w(v,c,R(p+c)),w(v,s,R(p+s)),y.when&&y.when("mash").execute(function(e){e&&(w(e,"appPause",R(f+"pause")),w(e,"appResume",R(f+"resume")),R(f+"deviceready")(),$.cordova&&$.cordova.platformId&&R(f+cordova.platformId)(),w(v,d,R(f+d)),w(v,l,R(f+l)))}),e=$.app||{},n=b(function(){k(f+"willDisappear"),D()}),a=typeof(t=e[u])==i,e[u]=b(function(){n(),a&&t()}),$.app||($.app=e),"complete"===v.readyState?A():w($,"load",A),E?S():x(),o.on("$app.blur",S),o.on("$app.focus",x),o.on("$document.blur",S),o.on("$document.focus",x),o.on("$document.hidden",S),o.on("$document.visible",x),o.register("SPA",{newPage:I}),I({transitionType:{0:"hard",1:"refresh",2:"back-button"}[P]||"unknown"}));function I(n,e){var t=!!r,a=(e=e||{}).keepPageAttributes;t&&(k("$beforePageTransition"),k("$pageTransition")),t&&!a&&g("removeEntity","page"),r=o.UUID(),a?T.id=r:T={schemaId:"<ns>.PageEntity.2",id:r,url:m?h.href.split("?")[0]:h.href,server:h.hostname,path:h.pathname,referrer:m?v.referrer.split("?")[0]:v.referrer,title:v.title},Object.keys(n||{}).forEach(function(e){T[e]=n[e]}),g("setEntity",{page:T}),k("$pageChange",T,{buffered:1}),t&&k("$afterPageTransition")}function A(){k("$load"),k("$ready"),k("$afterload")}function D(){k("$ready"),k("$beforeunload"),k("$unload"),k("$afterunload")}function S(){E||(k("$visible",!1,{buffered:1}),E=!0)}function x(){E&&(k("$visible",!0,{buffered:1}),E=!1)}function R(n,t){return b(function(){var e=typeof t==i?n+t():n;k(e)})}});csa.plugin(function(c){var e="Events",n="UNKNOWN",s="id",a="all",i="messageId",o="timestamp",u="producerId",r="application",f="obfuscatedMarketplaceId",d="entities",l="schemaId",p="version",v="attributes",g="<ns>",b="lob",t="session",h=c.config,m=(c.global.location||{}).host,I=h[e+".Namespace"]||"csa_other",y=h.Application||"Other"+(m?":"+m:""),O=h["Transport.AnonymizeRequests"]||!1,E=c("Transport"),U={},A=function(e,t){Object.keys(e).forEach(t)};function N(n,i,o){A(i,function(e){var t=o===a||(o||{})[e];e in n||(n[e]={version:1,id:i[e][s]||c.UUID()}),S(n[e],i[e],t)})}function S(t,n,i){A(n,function(e){!function(e,t,n){return"string"!=typeof t&&e!==p?c.error("Attribute is not of type string: "+e):!0===n||1===n||(e===s||!!~(n||[]).indexOf(e))}(e,n[e],i)||(t[e]=n[e])})}function k(o,e,r){A(e,function(e){var t=o[e];if(t[l]){var n={},i={};n[s]=t[s],n[u]=t[u]||r[u],n[l]=t[l],n[p]=t[p]++,n[v]=i,w(n,r),S(i,t,1),D(i),E("log",n)}})}function w(e,t){e[o]=function(e){return"number"==typeof e&&(e=new Date(e).toISOString()),e||c.time("ISO")}(e[o]),e[i]=e[i]||c.UUID(),e[r]=y,e[f]=h.ObfuscatedMarketplaceId||n,e[l]=e[l].replace(g,I),t&&t[b]&&(e[b]=t[b])}function D(e){delete e[p],delete e[l],delete e[u]}function T(o){var r={};this.log=function(e,t){var n={},i=(t||{}).ent;return e?"string"!=typeof e[l]?c.error("A valid schema id is required for the event"):(w(e,o),N(n,U,i),N(n,r,i),N(n,e[d]||{},i),A(n,function(e){D(n[e])}),e[u]=o[u],e[d]=n,t&&t[b]&&(e[b]=t[b]),void E("log",e,t)):c.error("The event cannot be undefined")},this.setEntity=function(e){O&&delete e[t],N(r,e,a),k(r,e,o)}}h["KillSwitch."+e]||c.register(e,{setEntity:function(e){O&&delete e[t],c.emit("$entities.set",e,{buffered:1}),N(U,e,a),k(U,e,{producerId:"csa",lob:h[b]||"0"})},removeEntity:function(e){delete U[e]},instance:function(e){return new T(e)}})});csa.plugin(function(s){var c,g="Transport",l="post",f="preflight",r="csa.cajun.",i="store",a="deleteStored",u="sendBeacon",t="__merge",e="messageId",n=".FlushInterval",o=0,d=s.config[g+".BufferSize"]||2e3,h=s.config[g+".RetryDelay"]||1500,p=s.config[g+".AnonymizeRequests"]||!1,v={},y=0,m=[],E=s.global,R=E.document,b=s.timeout,k=E.Object.keys,w=s.config[g+n]||5e3,I=w,O=s.config[g+n+".BackoffFactor"]||1,S=s.config[g+n+".BackoffLimit"]||3e4,B=0;function T(n){if(864e5<s.time()-+new Date(n.timestamp))return s.warn("Event is too old: "+n);y<d&&(n[e]in v||(v[n[e]]=n,y++),"function"==typeof n[t]&&n[t](v[n[e]]),!B&&o&&(B=b(q,function(){var n=I;return I=Math.min(n*O,S),n}())))}function q(){m.forEach(function(e){var o=[];k(v).forEach(function(n){var t=v[n];e.accepts(t)&&o.push(t)}),o.length&&(e.chunks?e.chunks(o).forEach(function(n){D(e,n)}):D(e,o))}),v={},B=0}function D(t,e){function o(){s[a](r+n)}var n=s.UUID();s[i](r+n,JSON.stringify(e)),[function(n,t,e){var o=E.navigator||{},r=E.cordova||{};if(p)return 0;if(!o[u]||!n[l])return 0;n[f]&&r&&"ios"===r.platformId&&!c&&((new Image).src=n[f]().url,c=1);var i=n[l](t);if(!i.type&&o[u](i.url,i.body))return e(),1},function(n,t,e){if(!n[l])return 0;var o=n[l](t),r=o.url,i=o.body,c=o.type,f=new XMLHttpRequest,a=0;function u(n,t,e){f.open("POST",n),f.withCredentials=!p,e&&f.setRequestHeader("Content-Type",e),f.send(t)}return f.onload=function(){f.status<299?e():s.config[g+".XHRRetries"]&&a<3&&b(function(){u(r,i,c)},++a*h)},u(r,i,c),1}].some(function(n){try{return n(t,e,o)}catch(n){}})}k&&(s.once("$afterload",function(){o=1,function(e){(s[i]()||[]).forEach(function(n){if(!n.indexOf(r))try{var t=s[i](n);s[a](n),JSON.parse(t).forEach(e)}catch(n){s.error(n)}})}(T),s.on(R,"visibilitychange",q,!1),q()}),s.once("$afterunload",function(){o=1,q()}),s.on("$afterPageTransition",function(){y=0,I=w}),s.register(g,{log:T,register:function(n){m.push(n)}}))});csa.plugin(function(n){var r=n.config["Events.SushiEndpoint"];n("Transport")("register",{accepts:function(n){return n.schemaId},post:function(n){var t=n.map(function(n){return{data:n}});return{url:r,body:JSON.stringify({events:t})}},preflight:function(){var n,t=///(.*?)//.exec(r);return t&&t[1]&&(n="https://"+t[1]+"/ping"),{url:n}},chunks:function(n){for(var t=[];500<n.length;)t.push(n.splice(0,500));return t.push(n),t}})});csa.plugin(function(n){var t,a,o,r,e=n.config,i="PageViews",d=e[i+".ImpressionMinimumTime"]||1e3,s="hidden",c="innerHeight",l="innerWidth",g="renderedTo",f=g+"Viewed",m=g+"Meaningful",u=g+"Impressed",p=1,h=2,v=3,w=4,P=5,y="loaded",I=7,b=8,T=n.global,S=n.on,E=n("Events",{producerId:"csa",lob:e.lob||"0"}),K=T.document,V={},$={},M=P,R=e["KillSwitch."+i],H=e["KillSwitch.PageRender"],W=e["KillSwitch.PageImpressed"];function j(e){if(!V[I]){if(V[e]=n.time(),e!==v&&e!==y||(t=t||V[e]),t&&M===w){if(a=a||V[e],!R)(i={})[m]=t-o,i[f]=a-o,k("PageView.5",i);r=r||n.timeout(x,d)}var i;if(e!==P&&e!==p&&e!==h||(clearTimeout(r),r=0),e!==p&&e!==h||H||k("PageRender.4",{transitionType:e===p?"hard":"soft"}),e===I&&!W)(i={})[m]=t-o,i[f]=a-o,i[u]=V[e]-o,k("PageImpressed.3",i)}}function k(e,i){$[e]||(i.schemaId="<ns>."+e,E("log",i,{ent:"all"}),$[e]=1)}function q(){0===T[c]&&0===T[l]?(M=b,n("Events")("setEntity",{page:{viewport:"hidden-iframe"}})):M=K[s]?P:w,j(M)}function x(){j(I),r=0}function z(){var e=o?h:p;V={},$={},a=t=0,o=n.time(),j(e),q()}function A(){var e=K.readyState;"interactive"===e&&j(v),"complete"===e&&j(y)}K&&void 0!==K[s]?(z(),S(K,"visibilitychange",q,!1),S(K,"readystatechange",A,!1),S("$afterPageTransition",z),S("$timing:loaded",A),n.once("$load",A)):n.warn("Page visibility not supported")});csa.plugin(function(c){var s=c.config["Interactions.ParentChainLength"]||35,e="click",r="touches",f="timeStamp",o="length",u="pageX",g="pageY",p="pageXOffset",h="pageYOffset",m=250,v=5,d=200,l=.5,t={capture:!0,passive:!0},X=c.global,Y=c.emit,n=c.on,x=X.Math.abs,a=(X.document||{}).documentElement||{},y={x:0,y:0,t:0,sX:0,sY:0},N={x:0,y:0,t:0,sX:0,sY:0};function b(t){if(t.id)return"//*[@id='"+t.id+"']";var e=function(t){var e,n=1;for(e=t.previousSibling;e;e=e.previousSibling)e.nodeName===t.nodeName&&(n+=1);return n}(t),n=t.nodeName;return 1!==e&&(n+="["+e+"]"),t.parentNode&&(n=b(t.parentNode)+"/"+n),n}function I(t,e,n){var a=c("Content",{target:n}),i={schemaId:"<ns>.ContentInteraction.2",interaction:t,interactionData:e,messageId:c.UUID()};if(n){var r=b(n);r&&(i.attribution=r);var o=function(t){for(var e=t,n=e.tagName,a=!1,i=t?t.href:null,r=0;r<s;r++){if(!e||!e.parentElement){a=!0;break}n=(e=e.parentElement).tagName+"/"+n,i=i||e.href}return a||(n=".../"+n),{pc:n,hr:i}}(n);o.pc&&(i.interactionData.parentChain=o.pc),o.hr&&(i.interactionData.href=o.hr)}a("log",i),Y("$content.interaction",{e:i,w:a})}function i(t){I(e,{interactionX:""+t.pageX,interactionY:""+t.pageY},t.target)}function C(t){if(t&&t[r]&&1===t[r][o]){var e=t[r][0];N=y={e:t.target,x:e[u],y:e[g],t:t[f],sX:X[p],sY:X[h]}}}function D(t){if(t&&t[r]&&1===t[r][o]&&y&&N){var e=t[r][0],n=t[f],a=n-N.t,i={e:t.target,x:e[u],y:e[g],t:n,sX:X[p],sY:X[h]};N=i,d<=a&&(y=i)}}function E(t){if(t){var e=x(y.x-N.x),n=x(y.y-N.y),a=x(y.sX-N.sX),i=x(y.sY-N.sY),r=t[f]-y.t;if(m<1e3*e/r&&v<e||m<1e3*n/r&&v<n){var o=n<e;o&&a&&e*l<=a||!o&&i&&n*l<=i||I((o?"horizontal":"vertical")+"-swipe",{interactionX:""+y.x,interactionY:""+y.y,endX:""+N.x,endY:""+N.y},y.e)}}}n(a,e,i,t),n(a,"touchstart",C,t),n(a,"touchmove",D,t),n(a,"touchend",E,t)});csa.plugin(function(s){var a,o,t,c,e,n="MutationObserver",l="observe",i="disconnect",f="_csa_flt",b="_csa_llt",d="_csa_mr",p="_csa_mi",v="lastChild",m="length",h={childList:!0,subtree:!0},_=10,g=25,r=1e3,y=4,u=s.global,k=u.document,w=k.body||k.documentElement,I=Date.now,L=[],O=[],B=[],M=0,x=0,C=0,D=1,E=[],F=[],S=0,V=s.blank;I&&u[n]&&(M=0,o=new u[n]($),(t=new u[n](Y))[l](w,{attributes:!0,subtree:!0,attributeFilter:["src"],attributeOldValue:!0}),V=s.on(u,"scroll",j,{passive:!0}),s.once("$ready",A),D&&(z(),e=s.interval(q,r)),s.register("SpeedIndexBuffers",{getBuffers:function(e){e&&(A(),j(),e(M,E,L,O,B),o&&o[i](),t&&t[i](),V())},registerListener:function(e){a=e},replayModuleIsLive:function(){s.timeout(A,0)}}));function Y(e){L.push({t:I(),m:e})}function $(e){O.push({t:I(),m:e}),C=1,a&&a()}function j(){C&&(B.push({t:I(),y:x}),x=u.pageYOffset,C=0)}function q(){var e=I();(!c||r<e-c)&&z()}function z(){for(var e=w,t=I(),n=[],i=[],r=0,u=0;e;)e[f]?++r:(e[f]=t,n.push(e),u=1),i[m]<y&&i.push(e),e[p]=S,e[b]=t,e=e[v];u&&(r<F[m]&&function(e){for(var t=e,n=F[m];t<n;t++){var i=F[t];if(i){if(i[d])break;if(i[p]<S){i[d]=1,o[l](i,h);break}}}}(r),F=i,E.push({t:t,m:n}),++S,C=u,a&&a()),D&&s.timeout(z,u?_:g),c=t}function A(){D&&(D=0,e&&u.clearInterval(e),e=null,z(),o[l](w,h))}});
csa.plugin(function(b){var a=b.global,c=a.uet,e=a.uex,f=a.ue,a=a.Object,g=0,h={largestContentfulPaint:"lcp",visuallyLoaded50:"vl50",visuallyLoaded90:"vl90",visuallyLoaded100:"vl100"};b&&c&&e&&a.keys&&f&&(b.once("$ditched.beforemitigation",function(){g=1}),a.keys(h).forEach(function(a){b.on("$timing:"+a,function(b){var d=h[a];if(f.isl||g){var k="csa:"+d;c(d,k,void 0,b);e("at",k)}else c(d,void 0,void 0,b)})}))});


window.rx = { 'rid':'RBW56TXBT3VK1W4DNTET', 'sid':'140-0199542-9827343', 'c':{  'rxp':'/rd/uedata' }};
</script>
<script>window.ue && ue.count && ue.count('CSMLibrarySize', 15884)</script>
<!-- sp:end-feature:csm:body-open -->
<!-- sp:feature:nav-inline-js -->
<!-- NAVYAAN JS -->

<script type="text/javascript">!function(n){function e(n,e){return{m:n,a:function(n){return[].slice.call(n)}(e)}}document.createElement("header");var r=function(n){function u(n,r,u){n[u]=function(){a._replay.push(r.concat(e(u,arguments)))}}var a={};return a._sourceName=n,a._replay=[],a.getNow=function(n,e){return e},a.when=function(){var n=[e("when",arguments)],r={};return u(r,n,"run"),u(r,n,"declare"),u(r,n,"publish"),u(r,n,"build"),r.depends=n,r.iff=function(){var r=n.concat([e("iff",arguments)]),a={};return u(a,r,"run"),u(a,r,"declare"),u(a,r,"publish"),u(a,r,"build"),a},r},u(a,[],"declare"),u(a,[],"build"),u(a,[],"publish"),u(a,[],"importEvent"),r._shims.push(a),a};r._shims=[],n.$Nav||(n.$Nav=r("rcx-nav")),n.$Nav.make||(n.$Nav.make=r)}(window)</script><script type="text/javascript">
$Nav.importEvent('navbarJS-beaconbelt');
$Nav.declare('img.sprite', {
  'png32': 'https://m.media-amazon.com/images/G/01/gno/sprites/nav-sprite-global-1x-reorg-privacy._CB546805360_.png',
  'png32-2x': 'https://m.media-amazon.com/images/G/01/gno/sprites/nav-sprite-global-2x-reorg-privacy._CB546805360_.png'
});
$Nav.declare('img.timeline', {
  'timeline-icon-2x': 'https://m.media-amazon.com/images/G/01/gno/sprites/timeline_sprite_2x._CB443581191_.png'
});
window._navbarSpriteUrl = 'https://m.media-amazon.com/images/G/01/gno/sprites/nav-sprite-global-1x-reorg-privacy._CB546805360_.png';
$Nav.declare('img.pixel', 'https://m.media-amazon.com/images/G/01/x-locale/common/transparent-pixel._CB485935036_.gif');
</script>

<img src="https://m.media-amazon.com/images/G/01/gno/sprites/nav-sprite-global-1x-reorg-privacy._CB546805360_.png" style="display:none" alt=""/>
<script type="text/javascript">var nav_t_after_preload_sprite = + new Date();</script>
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('navCF').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://images-na.ssl-images-amazon.com/images/I/51na2k2njbL._RC|71LJ+jMDvAL.js,01QvReFeJyL.js,01VfhmbHmKL.js,71MN9aepaKL.js,01cZ21lATAL.js,01bAfFgS7JL.js,01A2AtmCtlL.js,41jBieyCvYL.js,01wXnKULArL.js,01+pnQJuQ0L.js,21vOrV8ROnL.js,41zFN9UysJL.js,51HrkAbbpLL.js,31XO9BO1OrL.js,11lw6J7z8iL.js,31NSDarX4TL.js,01VYGE8lGhL.js_.js?AUIClients/NavDesktopUberAsset#desktop.language-en.us.803398-T1.1089549-T1.948355-T1.310484-T1.1179039-T1');
});
</script>
<!-- sp:end-feature:nav-inline-js -->
<!-- sp:feature:nav-skeleton -->
<!-- sp:end-feature:nav-skeleton -->
<!-- sp:feature:navbar -->

<!--Pilu -->


  <!-- NAVYAAN -->











<!-- navmet initial definition -->



<script type='text/javascript'>
    if(window.navmet===undefined) {
      window.navmet=[];
      if (window.performance && window.performance.timing && window.ue_t0) {
        var t = window.performance.timing;
        var now = + new Date();
        window.navmet.basic = {
          'networkLatency': (t.responseStart - t.fetchStart),
          'navFirstPaint': (now - t.responseStart),
          'NavStart': (now - window.ue_t0)
        };
        window.navmet.push({key:"NavFirstPaintStart",end:+new Date(),begin:window.ue_t0});
      }
    }
    if (window.ue_t0) {
      window.navmet.push({key:"NavMainStart",end:+new Date(),begin:window.ue_t0});
    }
</script>




<script type='text/javascript'>window.navmet.tmp=+new Date();</script>
  <script type='text/javascript'>
    // Nav start should be logged at this place only if request is NOT progressively loaded.
    // For progressive loading case this metric is logged as part of skeleton.
    // Presence of skeleton signals that request is progressively loaded.
    if(!document.getElementById("navbar-skeleton")) {
      window.uet && uet('ns');
    }
    window._navbar = (function (o) {
      o.componentLoaded = o.loading = function(){};
      o.browsepromos = {};
      o.issPromos = [];
      return o;
    }(window._navbar || {}));
    window._navbar.declareOnLoad = function () { window.$Nav && $Nav.declare('page.load'); };
    if (window.addEventListener) {
      window.addEventListener("load", window._navbar.declareOnLoad, false);
    } else if (window.attachEvent) {
      window.attachEvent("onload", window._navbar.declareOnLoad);
    } else if (window.$Nav) {
      $Nav.when('page.domReady').run("OnloadFallbackSetup", function () {
        window._navbar.declareOnLoad();
      });
    }
    window.$Nav && $Nav.declare('logEvent.enabled',
      'false');

    window.$Nav && $Nav.declare('config.lightningDeals', {});
  </script>

    <style mark="aboveNavInjectionCSS" type="text/css">
       #nav-flyout-ewc .nav-flyout-buffer-left { display: none; } #nav-flyout-ewc .nav-flyout-buffer-right { display: none; } div#navSwmHoliday.nav-focus {border: none;margin: 0;}
    </style>
    <script mark="aboveNavInjectionJS" type="text/javascript">
      try {
        if(window.navmet===undefined)window.navmet=[]; if(window.$Nav) { $Nav.when('$', 'config', 'flyout.accountList', 'SignInRedirect', 'dataPanel').run('accountListRedirectFix', function ($, config, flyout, SignInRedirect, dataPanel) { if (!config.accountList) { return; } flyout.getPanel().onData(function (data) { if (SignInRedirect) { var $anchors = $('[data-nav-role=signin]', flyout.elem()); $.each($anchors, function(i, anchorEl) {SignInRedirect.setRedirectUrl($(anchorEl), null, null);});}});}); $Nav.when('$').run('defineIsArray', function(jQuery) { if(jQuery.isArray===undefined) { jQuery.isArray=function(param) { if(param.length===undefined) { return false; } return true; }; } }); $Nav.declare('config.cartFlyoutDisabled', 'true'); $Nav.when('$','$F','config','logEvent','panels','phoneHome','dataPanel','flyouts.renderPromo','flyouts.sloppyTrigger','flyouts.accessibility','util.mouseOut','util.onKey','debug.param').build('flyouts.buildSubPanels',function($,$F,config,logEvent,panels,phoneHome,dataPanel,renderPromo,createSloppyTrigger,a11yHandler,mouseOutUtility,onKey,debugParam){var flyoutDebug=debugParam('navFlyoutClick');return function(flyout,event){var linkKeys=[];$('.nav-item',flyout.elem()).each(function(){var $item=$(this);linkKeys.push({link:$item,panelKey:$item.attr('data-nav-panelkey')});});if(linkKeys.length===0){return;} var visible=false;var $parent=$('<div class='nav-subcats'></div>').appendTo(flyout.elem());var panelGroup=flyout.getName()+'SubCats';var hideTimeout=null;var sloppyTrigger=createSloppyTrigger($parent);var showParent=function(){if(hideTimeout){clearTimeout(hideTimeout);hideTimeout=null;} if(visible){return;} var height=$('#nav-flyout-shopAll').height(); $parent.css({'height': height});$parent.animate({width:'show'},{duration:200,complete:function(){$parent.css({overflow:'visible'});}});visible=true;};var hideParentNow=function(){$parent.stop().css({overflow:'hidden',display:'none',width:'auto',height:'auto'});panels.hideAll({group:panelGroup});visible=false;if(hideTimeout){clearTimeout(hideTimeout);hideTimeout=null;}};var hideParent=function(){if(!visible){return;} if(hideTimeout){clearTimeout(hideTimeout);hideTimeout=null;} hideTimeout=setTimeout(hideParentNow,10);};flyout.onHide(function(){sloppyTrigger.disable();hideParentNow();this.elem().hide();});var addPanel=function($link,panelKey){var panel=dataPanel({className:'nav-subcat',dataKey:panelKey,groups:[panelGroup],spinner:false,visible:false});if(!flyoutDebug){var mouseout=mouseOutUtility();mouseout.add(flyout.elem());mouseout.action(function(){panel.hide();});mouseout.enable();} var a11y=a11yHandler({link:$link,onEscape:function(){panel.hide();$link.focus();}});var logPanelInteraction=function(promoID,wlTriggers){var logNow=$F.once().on(function(){var panelEvent=$.extend({},event,{id:promoID});if(config.browsePromos&&!!config.browsePromos[promoID]){panelEvent.bp=1;} logEvent(panelEvent);phoneHome.trigger(wlTriggers);});if(panel.isVisible()&&panel.hasInteracted()){logNow();}else{panel.onInteract(logNow);}};panel.onData(function(data){renderPromo(data.promoID,panel.elem());logPanelInteraction(data.promoID,data.wlTriggers);});panel.onShow(function(){var columnCount=$('.nav-column',panel.elem()).length;panel.elem().addClass('nav-colcount-'+columnCount);showParent();var $subCatLinks=$('.nav-subcat-links > a',panel.elem());var length=$subCatLinks.length;if(length>0){var firstElementLeftPos=$subCatLinks.eq(0).offset().left;for(var i=1;i<length;i++){if(firstElementLeftPos===$subCatLinks.eq(i).offset().left){$subCatLinks.eq(i).addClass('nav_linestart');}} if($('span.nav-title.nav-item',panel.elem()).length===0){var catTitle=$.trim($link.html());catTitle=catTitle.replace(/ref=sa_menu_top/g,'ref=sa_menu');var $subPanelTitle=$('<span class='nav-title nav-item'>'+ catTitle+'</span>');panel.elem().prepend($subPanelTitle);}} $link.addClass('nav-active');});panel.onHide(function(){$link.removeClass('nav-active');hideParent();a11y.disable();sloppyTrigger.disable();});panel.onShow(function(){a11y.elems($('a, area',panel.elem()));});sloppyTrigger.register($link,panel);if(flyoutDebug){$link.click(function(){if(panel.isVisible()){panel.hide();}else{panel.show();}});} var panelKeyHandler=onKey($link,function(){if(this.isEnter()||this.isSpace()){panel.show();}},'keydown',false);$link.focus(function(){panelKeyHandler.bind();}).blur(function(){panelKeyHandler.unbind();});panel.elem().appendTo($parent);};var hideParentAndResetTrigger=function(){hideParent();sloppyTrigger.disable();};for(var i=0;i<linkKeys.length;i++){var item=linkKeys[i];if(item.panelKey){addPanel(item.link,item.panelKey);}else{item.link.mouseover(hideParentAndResetTrigger);}}};});};
      } catch ( err ) {
        if ( window.$Nav ) {
          window.$Nav.when('metrics', 'logUeError').run(function(metrics, log) {
            metrics.increment('NavJS:AboveNavInjection:error');
            log(err.toString(), {
              'attribution': 'rcx-nav',
              'logLevel': 'FATAL'
            });
          });
        }
      }
    </script>

  <noscript>
    <style type="text/css"><!--
      #navbar #nav-shop .nav-a:hover {
        color: #ff9900;
        text-decoration: underline;
      }
      #navbar #nav-search .nav-search-facade,
      #navbar #nav-tools .nav-icon,
      #navbar #nav-shop .nav-icon,
      #navbar #nav-subnav .nav-hasArrow .nav-arrow {
        display: none;
      }
      #navbar #nav-search .nav-search-submit,
      #navbar #nav-search .nav-search-scope {
        display: block;
      }
      #nav-search .nav-search-scope {
        padding: 0 5px;
      }
      #navbar #nav-search .nav-search-dropdown {
        position: relative;
        top: 5px;
        height: 23px;
        font-size: 14px;
        opacity: 1;
        filter: alpha(opacity = 100);
      }
    --></style>
 </noscript>
<script type='text/javascript'>window.navmet.push({key:'PreNav',end:+new Date(),begin:window.navmet.tmp});</script>

<a id='nav-top'></a>





  
<nav
  id="shortcut-menu"
  class="nav-assistant"
  aria-label="Shortcuts menu"
  tabindex="-1"
  role="navigation" 
  
>
  <h2 id="nav-assistant-links-heading" class="nav-assistant-heading nav-assistant-headers-font">Skip to</h2>
  <ul aria-labelledby="nav-assistant-links-heading" class="nav-assistant-links-container">
    <li class="nav-assistant-list-item">
      <a
        href="#skippedLink"
        id="nav-assist-skip-to-main-content"
        aria-label="main content"
        tabindex="0"
        data-target="#skippedLink"
        data-behavior="navigate"
        
        
        data-nav-assist-menu-item-index="0"
        class="nav-assistant-link nav-assistant-menu-item nav-assistant-link-item a-color-base a-color-link "
      >
        Main content
        </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        href="#featurebullets_feature_div"
        id="nav-assist-skip-to-about-this-item"
        aria-label="About this item"
        tabindex="-1"
        data-target="#featurebullets_feature_div"
        data-behavior="navigate"
        
        data-selector-exclude="#nic-po-expander-heading"
        data-nav-assist-menu-item-index="1"
        class="nav-assistant-link nav-assistant-menu-item nav-assistant-link-item a-color-base a-color-link "
      >
        About this item
        </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        href="#nic-po-expander-heading"
        id="nav-assist-skip-to-about-this-item-expander"
        aria-label="About this item"
        tabindex="-1"
        data-target="#nic-po-expander-heading"
        data-behavior="navigate"
        
        
        data-nav-assist-menu-item-index="2"
        class="nav-assistant-link nav-assistant-menu-item nav-assistant-link-item a-color-base a-color-link "
      >
        About this item
        </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        href="#buybox"
        id="nav-assist-skip-to-buying-options"
        aria-label="Buying options"
        tabindex="-1"
        data-target="#buybox"
        data-behavior="navigate"
        
        
        data-nav-assist-menu-item-index="3"
        class="nav-assistant-link nav-assistant-menu-item nav-assistant-link-item a-color-base a-color-link "
      >
        Buying options
        </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        href="#product-comparison_feature_div"
        id="nav-assist-skip-to-compare"
        aria-label="Compare with similar items"
        tabindex="-1"
        data-target="#product-comparison_feature_div"
        data-behavior="navigate"
        data-selector-prereq="#product-comparison_feature_div &gt; div"
        
        data-nav-assist-menu-item-index="4"
        class="nav-assistant-link nav-assistant-menu-item nav-assistant-link-item a-color-base a-color-link "
      >
        Compare with similar items
        </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        href="#va-related-videos-widget_feature_div"
        id="nav-assist-skip-to-videos"
        aria-label="Videos"
        tabindex="-1"
        data-target="#va-related-videos-widget_feature_div"
        data-behavior="navigate"
        data-selector-prereq="#va-related-videos-widget_feature_div &gt; div"
        
        data-nav-assist-menu-item-index="5"
        class="nav-assistant-link nav-assistant-menu-item nav-assistant-link-item a-color-base a-color-link "
      >
        Videos
        </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        href="#customerReviews"
        id="nav-assist-skip-to-reviews"
        aria-label="Reviews"
        tabindex="-1"
        data-target="#customerReviews"
        data-behavior="navigate"
        
        
        data-nav-assist-menu-item-index="6"
        class="nav-assistant-link nav-assistant-menu-item nav-assistant-link-item a-color-base a-color-link "
      >
        Reviews
        </a>
    </li>
  </ul>
  <hr class="nav-assistant-separator" aria-hidden="true" />
  <h2 id="shortcuts-heading" class="nav-assistant-heading nav-assistant-headers-font font-color">
      Keyboard shortcuts
  </h2>
  <ul class="keyboard-shortcuts-list-container" aria-labelledby="shortcuts-heading">
    <li class="nav-assistant-list-item">
      <a
        id="nav-assist-search"
        role="link"
        tabindex="-1"
        class="nav-assistant-menu-item nav-assistant-link-item nav-assistant-keyboard-shortcut-item keyboard-shortcut-menu-container a-color-base a-color-link "
        data-nav-assist-menu-item-index="7"
        data-behavior="navigate"
        
        data-actuators="[{&quot;eventCode&quot;:&quot;Slash&quot;,&quot;eventKey&quot;:&quot;÷&quot;,&quot;isShiftRequired&quot;:false},{&quot;eventCode&quot;:&quot;Digit7&quot;,&quot;eventKey&quot;:&quot;&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventCode&quot;:&quot;Period&quot;,&quot;eventKey&quot;:&quot;&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventCode&quot;:&quot;Slash&quot;,&quot;eventKey&quot;:&quot;/&quot;,&quot;isShiftRequired&quot;:false},{&quot;eventCode&quot;:&quot;Digit7&quot;,&quot;eventKey&quot;:&quot;/&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventCode&quot;:&quot;Period&quot;,&quot;eventKey&quot;:&quot;/&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;/&quot;,&quot;isShiftRequired&quot;:false}]"
        data-target="#twotabsearchtextbox"
        aria-label="Search, alt, forward slash" 
      >
      <div class="keyboard-shortcut-container" aria-hidden="true">
        <span class="shortcut-name nav-assistant-card-font">Search</span>
        <div class="shortcut-keys-container" dir="ltr">
            <span class="shortcut-key nav-assistant-card-font font-color">alt</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">/</span>
            
        </div>
      </div>
      </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        id="nav-assist-cart"
        role="link"
        tabindex="-1"
        class="nav-assistant-menu-item nav-assistant-link-item nav-assistant-keyboard-shortcut-item keyboard-shortcut-menu-container a-color-base a-color-link "
        data-nav-assist-menu-item-index="8"
        data-behavior="navigate"
        
        data-actuators="[{&quot;eventKey&quot;:&quot;Ç&quot;,&quot;eventCode&quot;:&quot;KeyC&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;¢&quot;,&quot;eventCode&quot;:&quot;KeyC&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;C&quot;,&quot;isShiftRequired&quot;:true}]"
        data-target="/gp/cart/view.html/?ref_&#x3D;nav_assist"
        aria-label="Cart, shift, alt, c" 
      >
      <div class="keyboard-shortcut-container" aria-hidden="true">
        <span class="shortcut-name nav-assistant-card-font">Cart</span>
        <div class="shortcut-keys-container" dir="ltr">
            <span class="shortcut-key nav-assistant-card-font font-color">shift</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">alt</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">C</span>
            
        </div>
      </div>
      </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        id="nav-assist-home"
        role="link"
        tabindex="-1"
        class="nav-assistant-menu-item nav-assistant-link-item nav-assistant-keyboard-shortcut-item keyboard-shortcut-menu-container a-color-base a-color-link "
        data-nav-assist-menu-item-index="9"
        data-behavior="navigate"
        
        data-actuators="[{&quot;eventKey&quot;:&quot;Ó&quot;,&quot;eventCode&quot;:&quot;KeyH&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Î&quot;,&quot;eventCode&quot;:&quot;KeyH&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;H&quot;,&quot;isShiftRequired&quot;:true}]"
        data-target="/?ref_&#x3D;nav_assist"
        aria-label="Home, shift, alt, h" 
      >
      <div class="keyboard-shortcut-container" aria-hidden="true">
        <span class="shortcut-name nav-assistant-card-font">Home</span>
        <div class="shortcut-keys-container" dir="ltr">
            <span class="shortcut-key nav-assistant-card-font font-color">shift</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">alt</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">H</span>
            
        </div>
      </div>
      </a>
    </li>
    <li class="nav-assistant-list-item">
      <a
        id="nav-assist-your-orders"
        role="link"
        tabindex="-1"
        class="nav-assistant-menu-item nav-assistant-link-item nav-assistant-keyboard-shortcut-item keyboard-shortcut-menu-container a-color-base a-color-link "
        data-nav-assist-menu-item-index="10"
        data-behavior="navigate"
        
        data-actuators="[{&quot;eventKey&quot;:&quot;Ø&quot;,&quot;eventCode&quot;:&quot;KeyO&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Œ&quot;,&quot;eventCode&quot;:&quot;KeyO&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;O&quot;,&quot;isShiftRequired&quot;:true}]"
        data-target="/gp/css/order-history/?ref_&#x3D;nav_assist"
        aria-label="Your orders, shift, alt, o" 
      >
      <div class="keyboard-shortcut-container" aria-hidden="true">
        <span class="shortcut-name nav-assistant-card-font">Orders</span>
        <div class="shortcut-keys-container" dir="ltr">
            <span class="shortcut-key nav-assistant-card-font font-color">shift</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">alt</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">O</span>
            
        </div>
      </div>
      </a>
    </li>
    <li class="nav-assistant-list-item">
      <button
        id="nav-assist-add-to-cart"
        role="button"
        tabindex="-1"
        class="nav-assistant-menu-item nav-assistant-link-item nav-assistant-keyboard-shortcut-item keyboard-shortcut-menu-container a-color-base a-color-link nav-assistant-link-button"
        data-nav-assist-menu-item-index="11"
        data-behavior="activate"
        
        data-actuators="[{&quot;eventKey&quot;:&quot;&quot;,&quot;eventCode&quot;:&quot;KeyK&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Ë&quot;,&quot;eventCode&quot;:&quot;KeyK&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;ˆ&quot;,&quot;eventCode&quot;:&quot;KeyK&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;K&quot;,&quot;isShiftRequired&quot;:true}]"
        data-target="#add-to-cart-button"
        aria-label="Add to cart, shift, alt, K" 
      >
      <div class="keyboard-shortcut-container" aria-hidden="true">
        <span class="shortcut-name nav-assistant-card-font">Add to cart</span>
        <div class="shortcut-keys-container" dir="ltr">
            <span class="shortcut-key nav-assistant-card-font font-color">shift</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">alt</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">K</span>
            
        </div>
      </div>
      </button>
    </li>
    <li class="nav-assistant-list-item">
      <button
        id="nav-assist-show-shortcuts"
        role="button"
        tabindex="-1"
        class="nav-assistant-menu-item nav-assistant-link-item nav-assistant-keyboard-shortcut-item keyboard-shortcut-menu-container a-color-base a-color-link nav-assistant-link-button"
        data-nav-assist-menu-item-index="12"
        data-behavior="show-hide"
        
        data-actuators="[{&quot;eventKey&quot;:&quot;¸&quot;,&quot;eventCode&quot;:&quot;KeyZ&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;ˇ&quot;,&quot;eventCode&quot;:&quot;KeyY&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Å&quot;,&quot;eventCode&quot;:&quot;KeyW&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Z&quot;,&quot;eventCode&quot;:&quot;KeyZ&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Z&quot;,&quot;eventCode&quot;:&quot;KeyY&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Z&quot;,&quot;eventCode&quot;:&quot;KeyW&quot;,&quot;isShiftRequired&quot;:true},{&quot;eventKey&quot;:&quot;Z&quot;,&quot;isShiftRequired&quot;:true}]"
        data-target="a[data-nav-assist-menu-item-index&#x3D;&quot;0&quot;]"
        aria-label="Show/hide shortcuts, shift, alt, z" 
      >
      <div class="keyboard-shortcut-container" aria-hidden="true">
        <span class="shortcut-name nav-assistant-card-font">Show/Hide shortcuts</span>
        <div class="shortcut-keys-container" dir="ltr">
            <span class="shortcut-key nav-assistant-card-font font-color">shift</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">alt</span>
            <span class="plus-sign-color">+</span>
            <span class="shortcut-key nav-assistant-card-font font-color">Z</span>
            
        </div>
      </div>
      </button>
    </li>
  </ul>
  <div
    id="nav-assist-shortcut-help"
  >
    <div class="shortcut-help-container">
      <div class="shortcut-help-item-container">
        <div class="icon-container"><i class="a-icon a-icon-info a-icon-mini shortcut-help-icon"></i></div>
        <div class="help-text-container">
          <span class="shortcut-help-text font-color">To move between items, use your keyboard&#x27;s up or down arrows.</span>
        </div>
      </div>
    </div>
  </div>
</nav>





<script type='text/javascript'>window.navmet.main=+new Date();</script>



<header id="navbar-main" class = "nav-opt-sprite nav-flex nav-locale-us nav-lang-en nav-ssl nav-unrec nav-progressive-attribute">

   
  <div id='navbar' cel_widget_id='Navigation-desktop-navbar'
  role='navigation' class="nav-sprite-v1 celwidget nav-bluebeacon nav-a11y-t1 bold-focus-hover layout2 nav-flex layout3 layout3-alt nav-packard-glow hamburger nav-progressive-attribute" aria-label="Primary">
    <div id='nav-belt'>
      <div class='nav-left'>
        <script type='text/javascript'>window.navmet.tmp=+new Date();</script>
  <div id="nav-logo" >
    <a href="/ref=nav_logo" id="nav-logo-sprites" class="nav-logo-link nav-progressive-attribute" aria-label="Amazon" lang="en" >
      <span class="nav-sprite nav-logo-base"></span>
      <span id="logo-ext" class="nav-sprite nav-logo-ext nav-progressive-content"></span>
      <span class="nav-logo-locale">.us</span>
    </a>
  </div>
<script type='text/javascript'>window.navmet.push({key:'Logo',end:+new Date(),begin:window.navmet.tmp});</script>
        
<div id="nav-global-location-slot">
    <span id="nav-global-location-data-modal-action" class="a-declarative nav-progressive-attribute" data-a-modal='{&quot;width&quot;:375, &quot;closeButton&quot;:&quot;true&quot;,&quot;popoverLabel&quot;:&quot;Choose your location&quot;, &quot;ajaxHeaders&quot;:{&quot;anti-csrftoken-a2z&quot;:&quot;hFWuYbcZU0Rq6ZzK/s+JQTwkNoxMSB4HsfDy+epF0029AAAAAGfq+T0AAAAB&quot;}, &quot;name&quot;:&quot;glow-modal&quot;, &quot;url&quot;:&quot;/portal-migration/hz/glow/get-rendered-address-selections?deviceType&#x3D;desktop&amp;pageType&#x3D;Detail&amp;storeContext&#x3D;videogames&amp;actionSource&#x3D;desktop-modal&quot;, &quot;footer&quot;:&quot;&lt;span class&#x3D;&quot;a-declarative&quot; data-action&#x3D;&quot;a-popover-close&quot; data-a-popover-close&#x3D;&quot;{}&quot;&gt;&lt;span class&#x3D;&quot;a-button a-button-primary&quot;&gt;&lt;span class&#x3D;&quot;a-button-inner&quot;&gt;&lt;button name&#x3D;&quot;glowDoneButton&quot; class&#x3D;&quot;a-button-text&quot; type&#x3D;&quot;button&quot;&gt;Done&lt;/button&gt;&lt;/span&gt;&lt;/span&gt;&lt;/span&gt;&quot;,&quot;header&quot;:&quot;Choose your location&quot;}' data-action="a-modal">
        <a id="nav-global-location-popover-link" role="button" tabindex="0" class="nav-a nav-a-2 a-popover-trigger a-declarative nav-progressive-attribute" href="">
            <div class="nav-sprite nav-progressive-attribute" id="nav-packard-glow-loc-icon"></div>
            <div id="glow-ingress-block">
                <span class="nav-line-1 nav-progressive-content" id="glow-ingress-line1">
                   Deliver to
                </span>
                <span class="nav-line-2 nav-progressive-content" id="glow-ingress-line2">
                   Thailand
                </span>
            </div>
        </a>
        </span>
        <input data-addnewaddress="add-new" id="unifiedLocation1ClickAddress" name="dropdown-selection" type="hidden" value="add-new" class="nav-progressive-attribute" />
        <input data-addnewaddress="add-new" id="ubbShipTo" name="dropdown-selection-ubb" type="hidden" value="add-new" class="nav-progressive-attribute"/>
        <input id="glowValidationToken" name="glow-validation-token" type="hidden" value="hFWuYbcZU0Rq6ZzK/s+JQTwkNoxMSB4HsfDy+epF0029AAAAAGfq+T0AAAAB" class="nav-progressive-attribute"/>
        <input id="glowDestinationType" name="glow-destination-type" type="hidden" value="COUNTRY" class="nav-progressive-attribute"/>
</div>

<div id="nav-global-location-toaster-script-container" class="nav-progressive-content">
    <!-- NAVYAAN-GLOW-NAV-TOASTER -->
          <script>
              P.when('glow-toaster-strings').execute(function(S) {
                S.load({"glow-toaster-address-change-error":"An error has occurred and the address has not been updated. Please try again.","glow-toaster-unknown-error":"An error has occurred. Please try again."});
             });
          </script>
          <script>
              P.when('glow-toaster-manager').execute(function(M) {
                M.create({"storeName":"videogames","pageType":"Detail","aisTransitionState":null,"rancorLocationSource":"USER_OVERRIDE"})
              });
          </script>
</div>

      </div>
          <div class='nav-fill' id='nav-fill-search'>
            <script type='text/javascript'>window.navmet.tmp=+new Date();</script>
<div id="nav-search">
  <div id="nav-bar-left"></div> 
  <form
    id="nav-search-bar-form"
    accept-charset="utf-8"
    action="/s/ref=nb_sb_noss"
    class="nav-searchbar nav-progressive-attribute"
    method="GET"
    name="site-search"
    role="search"
  >

    <div class="nav-left">
      <div id="nav-search-dropdown-card">
        
  <div class="nav-search-scope nav-sprite">
    <div class="nav-search-facade" data-value="search-alias=aps">
      <span id="nav-search-label-id" class="nav-search-label nav-progressive-content">All</span>
      <i class="nav-icon"></i>
    </div>
    <label id="searchDropdownDescription" for="searchDropdownBox" class="nav-progressive-attribute" style="display:none">Select the department you want to search in</label>
    <select
      aria-describedby="searchDropdownDescription"
      class="nav-search-dropdown searchSelect nav-progressive-attrubute nav-progressive-search-dropdown"
      data-nav-digest="k+fyIAyB82R9jVEmroQ0OWwSW3A="
      data-nav-selected="0"
      id="searchDropdownBox"
      name="url"
      style="display: block;"
      tabindex="0"
      title="Search in"
    >
        <option selected="selected" value="search-alias=aps">All Departments</option>
        <option value="search-alias=arts-crafts-intl-ship">Arts & Crafts</option>
        <option value="search-alias=automotive-intl-ship">Automotive</option>
        <option value="search-alias=baby-products-intl-ship">Baby</option>
        <option value="search-alias=beauty-intl-ship">Beauty & Personal Care</option>
        <option value="search-alias=stripbooks-intl-ship">Books</option>
        <option value="search-alias=fashion-boys-intl-ship">Boys' Fashion</option>
        <option value="search-alias=computers-intl-ship">Computers</option>
        <option value="search-alias=deals-intl-ship">Deals</option>
        <option value="search-alias=digital-music">Digital Music</option>
        <option value="search-alias=electronics-intl-ship">Electronics</option>
        <option value="search-alias=fashion-girls-intl-ship">Girls' Fashion</option>
        <option value="search-alias=hpc-intl-ship">Health & Household</option>
        <option value="search-alias=kitchen-intl-ship">Home & Kitchen</option>
        <option value="search-alias=industrial-intl-ship">Industrial & Scientific</option>
        <option value="search-alias=digital-text">Kindle Store</option>
        <option value="search-alias=luggage-intl-ship">Luggage</option>
        <option value="search-alias=fashion-mens-intl-ship">Men's Fashion</option>
        <option value="search-alias=movies-tv-intl-ship">Movies & TV</option>
        <option value="search-alias=music-intl-ship">Music, CDs & Vinyl</option>
        <option value="search-alias=pets-intl-ship">Pet Supplies</option>
        <option value="search-alias=instant-video">Prime Video</option>
        <option value="search-alias=software-intl-ship">Software</option>
        <option value="search-alias=sporting-intl-ship">Sports & Outdoors</option>
        <option value="search-alias=tools-intl-ship">Tools & Home Improvement</option>
        <option value="search-alias=toys-and-games-intl-ship">Toys & Games</option>
        <option value="search-alias=videogames-intl-ship">Video Games</option>
        <option value="search-alias=fashion-womens-intl-ship">Women's Fashion</option>
    </select>
  </div>

      </div>
    </div>
    <div class="nav-fill">
      <div class="nav-search-field ">
          <label for="twotabsearchtextbox" style="display: none;">Search Amazon</label>
          <input
            type="text"
            id="twotabsearchtextbox"
            value="ps4"
            name="field-keywords"
            autocomplete="off"
            placeholder="Search Amazon"
            class="nav-input nav-progressive-attribute"
            dir="auto"
            tabindex="0"
            aria-label="Search Amazon"
            role="searchbox"
            aria-autocomplete="list"
            aria-controls="sac-autocomplete-results-container"
            aria-expanded="false"
            aria-haspopup="grid"
            spellcheck="false"
          >
      </div>
      <div id="nav-iss-attach"></div>
    </div>
    <div class="nav-right">
      <div class="nav-search-submit nav-sprite">
        <span id="nav-search-submit-text" class="nav-search-submit-text nav-sprite nav-progressive-attribute" aria-label="Go">
          <input id="nav-search-submit-button" type="submit" class="nav-input nav-progressive-attribute" value="Go" tabindex="0">
        </span>
      </div>
    </div>
  </form>
</div>
<script type='text/javascript'>window.navmet.push({key:'Search',end:+new Date(),begin:window.navmet.tmp});</script>
          </div>
      <div class='nav-right'>
          <script type='text/javascript'>window.navmet.tmp=+new Date();</script>
          <div id='nav-tools' class="layoutToolbarPadding">
              
              
              
              
  <div class="nav-div" id="icp-nav-flyout">
  <a href="/customer-preferences/edit?ie=UTF8&preferencesReturnUrl=%2F&ref_=topnav_lang_ais" class="nav-a nav-a-2 icp-link-style-2" aria-label="Choose a language for shopping in Amazon United States. The current selection is English (EN).
">
    <span class="icp-nav-link-inner">
      <span class="nav-line-1">
      </span>
      <span class="nav-line-2">
         <span class="icp-nav-flag icp-nav-flag-us icp-nav-flag-lop" role="img" aria-label="United States"></span>
          <div>EN</div>
      </span>
    </span>
  </a>
  <button class="nav-flyout-button nav-icon nav-arrow" aria-label="Expand to Change Language or Country" tabindex=0></button>
</div>

              
  <div class="nav-div" id="nav-link-accountList">
  <a href="https://www.amazon.com/ap/signin?openid.pape.max_auth_age=0&openid.return_to=https%3A%2F%2Fwww.amazon.com%2FPlayStation-Pro-1TB-Limited-Console-4%2Fdp%2FB009242639%2Fref%3Dsr_1_16%2F%3F_encoding%3DUTF8%26crid%3D1BO0M5KKJ9QD1%26dib%3DeyJ2IjoiMSJ9.DYCLh1lfDEqmNIOXcI70zeBtbVDEVFdpQdh7MnKCAqbRsvzxVzTS22FOKdE-QhogNTEMxVo_haqWHA8Puo7aKzBS2dkNvc3rRl4agcIyZV56HLo73DAc2hkJmSi6HqnmlCfbGyMEpwuCT88Uc6SbYbv0Au8X3WfvpXggderg-UIaB73cjQwXsuNeFifPCp3vY2FGDf6A2f966BkTUZOx3U-wArqIGcAw_9br2PwmTHQ.MCHaFtqxLd6FAbSEwcUYmAyaIQieo_JwSA1mC7YDdxI%26dib_tag%3Dse%26keywords%3Dps4%26qid%3D1743452468%26sprefix%3D%252Caps%252C2195%26sr%3D8-16%26ref_%3Dnav_ya_signin&openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.assoc_handle=usflex&openid.mode=checkid_setup&openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0" class="nav-a nav-a-2   nav-progressive-attribute" data-nav-ref="nav_ya_signin"  data-nav-role="signin" data-ux-jq-mouseenter="true" tabindex="0" data-csa-c-type="link" data-csa-c-slot-id="nav-link-accountList" data-csa-c-content-id="nav_ya_signin"  aria-controls="nav-flyout-accountList" >
  <div class="nav-line-1-container"><span id="nav-link-accountList-nav-line-1" class="nav-line-1 nav-progressive-content">Hello, sign in</span></div>
  <span class="nav-line-2 ">Account & Lists
  </span>
  </a>
  <button class="nav-flyout-button nav-icon nav-arrow" aria-label="Expand Account and Lists" tabindex=0></button>
  </div>

              
<a href="/gp/css/order-history?ref_=nav_orders_first" class="nav-a nav-a-2   nav-progressive-attribute" id="nav-orders" tabindex="0">
  <span class="nav-line-1">Returns</span>
  <span class="nav-line-2">& Orders<span class="nav-icon nav-arrow"></span></span>
</a>

              
              
  <a href="/gp/cart/view.html?ref_=nav_cart" aria-label="0 items in cart" class="nav-a nav-a-2 nav-progressive-attribute" id="nav-cart">
    <div id="nav-cart-count-container">
      <span id="nav-cart-count" aria-hidden="true" class="nav-cart-count nav-cart-0 nav-progressive-attribute nav-progressive-content">0</span>
      <span class="nav-cart-icon nav-sprite"></span>
    </div>
    <div id="nav-cart-text-container" class=" nav-progressive-attribute">
      <span aria-hidden="true" class="nav-line-1">
        
      </span>
      <span aria-hidden="true" class="nav-line-2">
        Cart
        <span class="nav-icon nav-arrow"></span>
      </span>
    </div>
  </a>

          </div>
          <script type='text/javascript'>window.navmet.push({key:'Tools',end:+new Date(),begin:window.navmet.tmp});</script>

      </div>
    </div>
    <div id='nav-belt-search' class='nav-fill'></div>
    <div id='nav-main' class='nav-sprite'>
      <div class='nav-left'>
        <script type='text/javascript'>window.navmet.tmp=+new Date();</script>
  <a href="/gp/site-directory?ref_=nav_em_js_disabled" id="nav-hamburger-menu" role="button" aria-label="Open All Categories Menu" aria-expanded="false" data-csa-c-type="widget" data-csa-c-slot-id="HamburgerMenuDesktop"
  data-csa-c-interaction-events="click" >
    <i class="hm-icon nav-sprite"></i>
    <span class="hm-icon-label">All</span>
  </a>
  
<script type="text/javascript">
  var hmenu = document.getElementById("nav-hamburger-menu");
  hmenu.setAttribute("href", "javascript: void(0)");
  window.navHamburgerMetricLogger = function() {
    if (window.ue && window.ue.count) {
      var metricName = "Nav:Hmenu:IconClickActionPending";
      window.ue.count(metricName, (ue.count(metricName) || 0) + 1);
    }
    window.$Nav && $Nav.declare("navHMenuIconClicked",!0);
    window.$Nav && $Nav.declare("navHMenuIconClickedNotReadyTimeStamp", Date.now());
  };
  hmenu.addEventListener("click", window.navHamburgerMetricLogger);
  window.$Nav && $Nav.declare('hamburgerMenuIconAvailableOnLoad', false);
</script>  
<script type='text/javascript'>window.navmet.push({key:'HamburgerMenuIcon',end:+new Date(),begin:window.navmet.tmp});</script>
        
        
      </div>
      <div class='nav-fill'>
        
 <div id="nav-shop">
 </div>
        <div id='nav-xshop-container'>
          <div id='nav-xshop' class="nav-progressive-content">
            <script type='text/javascript'>window.navmet.tmp=+new Date();</script>
  <ul class="nav-ul">
      
<li class="nav-li">
<div class="nav-div">
<a href="/gp/goldbox?ref_=nav_cs_gb" class="nav-a  " tabindex="0" data-csa-c-type="link" data-csa-c-slot-id="nav_cs_0" data-csa-c-content-id="nav_cs_gb">Today's Deals</a>
</div>
</li>


<li class="nav-li">
<div class="nav-div">
<a href="/gp/browse.html?node=16115931011&ref_=nav_cs_registry" class="nav-a  " tabindex="0" data-csa-c-type="link" data-csa-c-slot-id="nav_cs_1" data-csa-c-content-id="nav_cs_registry">Registry</a>
</div>
</li>


<li class="nav-li">
<div class="nav-div">
<a href="/gp/help/customer/display.html?nodeId=508510&ref_=nav_cs_customerservice" class="nav-a  " tabindex="0" data-csa-c-type="link" data-csa-c-slot-id="nav_cs_2" data-csa-c-content-id="nav_cs_customerservice">Customer Service</a>
</div>
</li>


<li class="nav-li">
<div class="nav-div">
<a href="/gift-cards/b/?ie=UTF8&node=2238192011&ref_=nav_cs_gc" class="nav-a  " tabindex="0" data-csa-c-type="link" data-csa-c-slot-id="nav_cs_3" data-csa-c-content-id="nav_cs_gc">Gift Cards</a>
</div>
</li>


<li class="nav-li">
<div class="nav-div">
<a href="/b/?_encoding=UTF8&ld=AZUSSOA-sell&node=12766669011&ref_=nav_cs_sell" class="nav-a  " tabindex="0" data-csa-c-type="link" data-csa-c-slot-id="nav_cs_4" data-csa-c-content-id="nav_cs_sell">Sell</a>
</div>
</li>


<a href="/gp/help/customer/accessibility" aria-label="Click to call our Disability Customer Support line, or reach us directly at 1-888-283-1678" class="nav-hidden-aria  " tabindex="0"  data-csa-c-type="link" data-csa-c-slot-id="nav_cs_5" >Disability Customer Support</a>

  </ul>
  <script type='text/javascript'>window.navmet.push({key:'CrossShop',end:+new Date(),begin:window.navmet.tmp});</script>
          </div>
        </div>
      </div>
      <div class='nav-right'>
        <script type='text/javascript'>window.navmet.tmp=+new Date();</script><!-- Navyaan SWM -->
<div id="nav-swmslot" class="nav-swm-text-widget">
  <a href="/b/?_encoding=UTF8&node=117402865011&ref_=nav_swm_undefined&pf_rd_p=66575ad5-911b-4c83-8f29-a077ef824df8&pf_rd_s=nav-sitewide-msg-text-export&pf_rd_t=4201&pf_rd_i=navbar-4201&pf_rd_m=ATVPDKIKX0DER&pf_rd_r=RBW56TXBT3VK1W4DNTET" id="swm-link" class="nav_a nav-swm-text nav-progressive-attribute nav-progressive-content">Get free shipping to Thailand</a>
</div><script type='text/javascript'>window.navmet.push({key:'SWM',end:+new Date(),begin:window.navmet.tmp});</script>
      </div>
    </div>

    <div id='nav-subnav-toaster'></div>

    
    <div id="nav-progressive-subnav">
      
    </div>

    <div id='nav-flyout-ewc' class='nav-ewc-lazy-align nav-ewc-hide-head'><div class='nav-flyout-body ewc-beacon' tabindex='-1'><div class='nav-ewc-arrow'></div><div class='nav-ewc-content'></div></div></div><script type='text/javascript'>
(function() {
  var viewportWidth = function() {
    return window.innerWidth ||
      document.documentElement.clientWidth ||
      document.body.clientWidth;
  };

  if (typeof uet === 'function') {  uet('x1', 'ewc', {wb: 1}); }

  window.$Nav && $Nav.declare('config.ewc', (function() {
    var config = {"enablePersistent":true,"viewportWidthForPersistent":1400,"isEWCLogging":1,"isEWCStateExpanded":true,"EWCStateReason":"fixed","isSmallScreenEnabled":true,"isFreshCustomer":false,"errorContent":{"html":"<div class='nav-ewc-error'><span class='nav-title'>Oops!</span><p class='nav-paragraph'>There's a problem loading your cart right now.</p><a href='/gp/cart/view.html?ref_=nav_err_ewc_timeout' class='nav-action-button'><span class='nav-action-inner'>Your Cart</span></a></div>"},"url":"/cart/ewc/compact?hostPageType=Detail&hostSubPageType=Glance&hostPageRID=RBW56TXBT3VK1W4DNTET&prerender=0&storeName=videogames","cartCount":0,"freshCartCount":0,"almCartCount":0,"primeWardrobeCartCount":0,"isCompactViewEnabled":true,"isCompactEWCRendered":true,"isWiderCompactEWCRendered":true,"EWCBrowserCacheKey":"EWC_Cache_140-0199542-9827343__USD_en_US","isContentRepainted":false,"clearCache":false,"loadFromCacheWithDelay":0,"delayRenderingTillATF":false,"EarlyLoadEWCContentTreatment":"T3"};
    var hasAui = window.P && window.P.AUI_BUILD_DATE;
    var isRTLEnabled = (document.dir === 'rtl');
    config.pinnable = config.pinnable && hasAui;
    config.isMigrationTreatment = true;

    config.flyout = (function() {
      var navbelt = document.getElementById('nav-belt');
      var navCart = document.getElementById('nav-cart');
      var ewcFlyout = document.getElementById('nav-flyout-ewc');
      var persistentClassOnBody = 'nav-ewc-persistent-hover nav-ewc-full-height-persistent-hover';
      var flyout = {};

      var getDocumentScrollTop = function() {
        return (document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
      };

      var isWindow = function(obj) {
        return obj != null && obj === obj.window;
      };

      var getWindow = function(elem) {
        return isWindow(elem) ? elem : elem.nodeType === 9 && elem.defaultView;
      };

      var getOffset = function(elem) {
        if (elem.getClientRects && !elem.getClientRects().length) {
          return {top: 0};
        }

        var rect = elem.getBoundingClientRect
          ? elem.getBoundingClientRect()
          : {top: 0};

        if (rect.width || rect.height) {
          var doc = elem.ownerDocument;
          var win = getWindow(doc);
          return {
            top: rect.top + win.pageYOffset - doc.documentElement.clientTop
          };
        }
        return rect;
      };

      flyout.align = function() {
        var newTop = getOffset(navbelt).top - getDocumentScrollTop();
        ewcFlyout.style.top = (newTop > 0 ? newTop + 'px' : 0);
      };

      flyout.hide = function() {
        isRTLEnabled
          ? (ewcFlyout.style.left = '')
          : (ewcFlyout.style.right = '');
      };

      if(typeof config.isCompactEWCRendered === 'undefined') {
        if (
          (config.isSmallScreenEnabled && viewportWidth() < 1400) ||
          (config.isCompactViewEnabled && viewportWidth() >= 1400)
        ) {
          config.isCompactEWCRendered = true;
          config.isEWCStateExpanded = true;
          config.url = config.url.replace("/gp/navcart/sidebar", "/cart/ewc/compact");
        } else {
          config.isCompactEWCRendered = false;
        }
      }

      var viewportQualifyForPersistent = function () {
        return (config.isCompactEWCRendered)
          ? true
          : viewportWidth() >= 1400;
      }

      flyout.hasQualifiedViewportForPersistent = viewportQualifyForPersistent;

      var getEWCRightOffset = function() {
        if (!config.isCompactEWCRendered) {
          return 0;
        }

        var $navbelt = document.getElementById('nav-belt');
        if ($navbelt === undefined || $navbelt === null) {
          return 0;
        }

        var EWCCompactViewWidth = (config.isWiderCompactEWCRendered  && viewportWidth() >= 1280) ? 130 : 100;
        var scrollLeft = (window.pageXOffset !== undefined)
          ? window.pageXOffset
          : (document.documentElement || document.body.parentNode || document.body).scrollLeft;
        var scrollXAxis = Math.abs(scrollLeft);
        var windowWidth = document.documentElement.clientWidth;
        var navbeltWidth = $navbelt.offsetWidth;
        var isPartOfNavbarNotVisible = (navbeltWidth + EWCCompactViewWidth) > windowWidth;

        if (isPartOfNavbarNotVisible) {
          return 0 - (navbeltWidth - scrollXAxis - windowWidth + EWCCompactViewWidth);
        } else {
          return 0;
        }
      }

      flyout.getEWCRightOffsetCssProperty = function () {
        return getEWCRightOffset() + 'px';
      }

      if (config.isCompactEWCRendered) {
        persistentClassOnBody = 'nav-ewc-persistent-hover nav-ewc-compact-view';
        if (config.isWiderCompactEWCRendered) { persistentClassOnBody += ' nav-ewc-wider-compact-view'; }
      }

      flyout.show = function() {
        isRTLEnabled
          ? (ewcFlyout.style.left = flyout.getEWCRightOffsetCssProperty())
          : (ewcFlyout.style.right = flyout.getEWCRightOffsetCssProperty());
      };

      var isIOSDevice = function() {
        return (/iPad|iPhone|iPod/.test(navigator.platform) ||
                (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1)) &&
                !window.MSStream;
      }

      var checkForPersistent = function() {
        if (!hasAui) {
          return { result: false, reason: 'noAui' };
        }
        if (!config.enablePersistent) {
          return { result: false, reason: 'config' };
        }
        if (!viewportQualifyForPersistent()) {
          return { result: false, reason: 'viewport' };
        }
        if (isIOSDevice()) {
          return { result: false, reason: 'iOS' };
        }
        if (!config.cartCount > 0) {
          return { result: false, reason: 'emptycart' };
        }
        return { result: true };
      };

      flyout.ableToPersist = function() {
        return checkForPersistent().result;
      };
      var persistentClassRegExp = '(?:^|s)' + persistentClassOnBody + '(?!S)';
      flyout.applyPageLayoutForPersistent = function() {
        if (!document.documentElement.className.match( new RegExp(persistentClassRegExp) )) {
          document.documentElement.className += ' ' + persistentClassOnBody;
        }
      };

      flyout.unapplyPageLayoutForPersistent = function() {
        document.documentElement.className = document.documentElement.className.replace( new RegExp(persistentClassRegExp, 'g'), '');
      };

      flyout.persist = function() {
        flyout.applyPageLayoutForPersistent();
        flyout.show();
        if (config.isCompactEWCRendered) {
          flyout.align();
        }
      };

      flyout.unpersist = function() {
        flyout.unapplyPageLayoutForPersistent();
        flyout.hide();
      };
      
      var persistentCheck = checkForPersistent();
    

      var resizeCallback = function() {
        
        if (flyout.ableToPersist()) {
          flyout.persist();
        }
        else {
          flyout.unpersist();
        }
      };

      flyout.bindEvents = function() {
        if (window.addEventListener) {
          window.addEventListener('resize', resizeCallback, false);
          
          if (config.isCompactEWCRendered) {
            window.addEventListener('scroll', flyout.align, false);
          }
        }
      };

      flyout.unbindEvents = function() {
        if (window.removeEventListener) {
          window.removeEventListener('resize', resizeCallback, false);
          
          if (config.isCompactEWCRendered) {
            window.removeEventListener('scroll', flyout.align, false);
          }
        }
      };
      
      var ewcDefaultPersistence = function() {
      
        if (persistentCheck.result) {
          flyout.persist();
          if (window.ue && ue.tag) {
            ue.tag('ewc:persist');
          }
        } else {
          if (window.ue && ue.tag) {
            ue.tag('ewc:unpersist');
            if (persistentCheck.reason === 'noAui') {
              ue.tag('ewc:unpersist:noAui');
            }
            if (persistentCheck.reason === 'viewport') {
              ue.tag('ewc:unpersist:viewport');
            }
            if (persistentCheck.reason === 'emptycart') {
              ue.tag('ewc:unpersist:emptycart');
            }
            if (persistentCheck.reason === 'iOS') {
              ue.tag('ewc:unpersist:iOS');
            }
          }
        }
      };
      
      ewcDefaultPersistence();
      
      if (window.ue && ue.tag)  {
        if (flyout.hasQualifiedViewportForPersistent()) {
          ue.tag('ewc:bview');
        }
        else {
          ue.tag('ewc:sview');
        }
      }
      flyout.bindEvents();
      flyout.cache = function () {
    const cache = window.sessionStorage;
    const CACHE_KEY = "EWCBrowserCacheKey";
    const CACHE_EXPIRY = "EWCBrowserCacheExpiry"; 
    const CACHE_VALUE = "EWCBrowserCacheValue"; 
    const isSessionStorageValid = function () {
        return window && cache && cache instanceof Storage;
    };
    const isCachePresent = function (key) {
        return cache.length > 0 && cache.getItem(key);
    }
    const isValidType = function (value) {
        // Prevents accessing empty key-value and internal methods(prototypes) of storage
        // TODO: Log metrics for invalid access;
        return value && value.constructor == String;
    }
    return {
        getCache: function (key) {
            const value = isCachePresent(key);
            return (isValidType(value)) ? value : null;
        },
        setCache: function (key, value) {
            const oldValue = isCachePresent(key);
            const cacheExpiryTime = isCachePresent(CACHE_EXPIRY);
            // Set the expiry when there's no existing cache - to prevent resetting expiry on page navigation
            if (!cacheExpiryTime) {
                var currentTime = new Date();
                cache.setItem(CACHE_EXPIRY, new Date(currentTime.getTime() + 5 * 60000))
            }
            // TODO: Log length of old and new cache values when logMetrics is true
            cache.setItem(key, value);
        },
        updateCacheAndEwcContainer: function (cacheKey, newEwcContent) {
            const $ = $Nav.getNow("$");
            const $currentEwc = $("#ewc-content");
            if (!$currentEwc.length) {
                var $content = $('#nav-flyout-ewc .nav-ewc-content');
                $content.html(newEwcContent);
                this.setCache(CACHE_KEY, cacheKey);
                if (window.ue && window.ue.count) {
                    var current = window.ue.count("ewc-init-cache") || 0;
                    window.ue.count("ewc-init-cache", current + 1);
                }
            } else {
                var $newEwcContent = $('<div />');
                var EWC_CONTENT_BODY_SCROLL_SELECTOR = ".ewc-scroller--selected";
                if (newEwcContent) { // 1. Updates EWC container with new HTML 
        var domParser = new DOMParser();
               var sandboxedEwcContent = domParser.parseFromString(newEwcContent, 'text/html');
               var newEwcHtmlNoScript = sandboxedEwcContent.getElementById('ewc-content');
               const $newEwcHtml = $newEwcContent.html(newEwcHtmlNoScript);
                    const offSet = $currentEwc.find(EWC_CONTENT_BODY_SCROLL_SELECTOR).position().top - $currentEwc.find(".ewc-active-cart--selected").position().top;
                    $currentEwc.html($newEwcHtml.html());
                    $currentEwc.find(EWC_CONTENT_BODY_SCROLL_SELECTOR).scrollTop(offSet);
                    if (typeof window.uex === 'function') {
                        window.uex('ld', 'ewc-reflect-new-state', {wb: 1});
                    }
                } else {
                    // 2. Fetches cached response and updates it's html with new state on EWC Update
                    const cachedEwc = this.getCache(CACHE_VALUE);
                    $newEwcContent = $newEwcContent[0];
                    $(cachedEwc).map(function (elementIndex, element) {
                         $newEwcContent.appendChild((element.id === "ewc-content") ? $currentEwc.clone()[0] : element);
                    });
                    newEwcContent = $newEwcContent.innerHTML;
                    if (window.ue && window.ue.count) {
                        var current = window.ue.count("ewc-update-cache") || 0;
                        window.ue.count("ewc-update-cache", current + 1);
                    }
                }
                $newEwcContent.remove();
            }
            this.setCache(CACHE_VALUE, newEwcContent);
        },
        removeCache: function (key) {
            return cache.removeItem(key);
        }
    }
}
;
      return flyout;
    }());
     
  $Nav.when("config").run('ewc.pageload-content-load-wrapper', function(config) {
    P.register('ewc.pageload-content-loader', function(){
    var isEwcLoadedOnLanding = false;
    if(config.ewc.EarlyLoadEWCContentTreatment){
    return {
      loadContent: function(isFallback) {
        if(!isEwcLoadedOnLanding) {
          if (config.ewc.flyout.ableToPersist()) {
             setTimeout(function() {
               config.ewc.flyout.loadEwcContent();
               $Nav.declare('ewc.loadContent', function() {});
             }, 1000);
          } else {
            $Nav.declare('ewc.loadContent',  config.ewc.flyout.loadEwcContent);
          }
          if(isFallback){
             if (window.ue && window.ue.count) {
                var current = window.ue.count("ewc-load-content-fallback") || 0;
                window.ue.count("ewc-load-content-fallback", current + 1);
           }
         }
        }
        isEwcLoadedOnLanding = true;
      }
    }} else {
    return {}};
    });
   });

     
$Nav.when("config")
.run("ewc.inline.ajax", function(config) {

P.when('A').execute(function(A){
  var $ = A.$;
  var $content = $('#nav-flyout-ewc .nav-ewc-content');
  
  var displayErrorContent = function(){
    $content.html(config.ewc.errorContent.html).addClass('nav-tpl-flyoutError');
  };
  
  var getUrlParams = function(isReloaded) {
    var urlParams = {};
    if (isReloaded) {
      urlParams['isReloaded'] = true;
    } else {
      if (config.ewc.freshCartCount !== undefined) {
        urlParams['freshCartCount'] = config.ewc.freshCartCount;
      }
      if (config.ewc.almCartCount !== undefined) {
        urlParams['almCartCount'] = config.ewc.almCartCount;
      }
      if (config.ewc.primeWardrobeCartCount !== undefined) {
        urlParams['primeWardrobeCartCount'] = config.ewc.primeWardrobeCartCount;
      }
    }
    urlParams.widerCompactView = window.innerWidth > 1280;
    return urlParams;
  };

  config.ewc.flyout.loadEwcContent = function _loadEwcContent(isReloaded) {
    $.ajax({
      url: config.ewc.url,
      data: getUrlParams(isReloaded),
      type: "GET",
      dataType: config.ewc.isCompactEWCRendered ? "html" : "json",
      cache: false,
      timeout: config.ewc.timeout || 30000,
      beforeSend: function() {
        if (!config.ewc.isCompactEWCRendered) {
          $content.addClass('nav-spinner');
          if (typeof window.uet === 'function') {
            window.uet('af', 'ewc', {wb: 1});
          }
        } else {
          if (typeof window.uet === 'function') {
            window.uet('af', 'ewc2-compact', {wb: 1});
          }
        }
      },
      error: displayErrorContent,          
      success: function(result) {
        if (typeof window.uet === 'function') {
          window.uet('bb', 'ewc', {wb: 1});
        }
        if (config.ewc.isCompactEWCRendered) {
          if (!isReloaded) {
            P.register('EWC', function () {
              if (window.EwcP === undefined) {
                window.EwcP = (window.AmazonUIPageJS || P);
              }
              return {
                refresh : function () {
                  if (window.ue && window.ue.count) {
                    window.ue.count("ewc2-refresh", 1);
                  }
                  config.ewc.flyout.loadEwcContent(true);
                  P.when('EWCRefreshCallback').execute(function(callback) {
                    callback.update();
                  });
                }
              }
            });
          } else {
            var cartQuantity = $(result).find('#ewc-total-quantity').val();
            if (window.$Nav && cartQuantity) {
              window.$Nav.when('api.setCartCount').run(function(setCartCount) {
                setCartCount(parseInt(cartQuantity), true);
              });
            };
          }
          
            var cache = config.ewc.flyout.cache();
            cache.updateCacheAndEwcContainer("EWC_Cache_140-0199542-9827343__USD_en_US", result);
                      
        }
        if (typeof window.uet === 'function') {
          window.uet('be', 'ewc', {wb: 1});
        }
      },
      complete: function() {
        if (!config.ewc.isCompactEWCRendered) {
          $content.removeClass('nav-spinner');
        }
        if (typeof window.uet === 'function') {
          window.uet('cf', 'ewc', {wb: 1});
        }
        if (typeof window.uex === 'function') {
            window.uex('ld', 'ewc', {wb: 1});
        }
      }
    });
  };
 });
(window.P && window.P.AUI_BUILD_DATE) && (window.AmazonUIPageJS ? AmazonUIPageJS : P)
.when('ewc.pageload-content-loader','atf').execute('ewcPageLoadContentLoader' , function(ewcPageLoadContentLoader,atf) {
    if (window.ue && window.ue.count) {
      var current = window.ue.count("ewc-load-content") || 0;
      window.ue.count("ewc-load-content", current + 1);
   }
    ewcPageLoadContentLoader.loadContent(false); 
   });
});

     
const CACHE_KEY = "EWCBrowserCacheKey";
const CACHE_VALUE = "EWCBrowserCacheValue"; 
const CACHE_EXPIRY = "EWCBrowserCacheExpiry"; 
var cache = config.flyout.cache();

const isCacheValid = function () {
  // Check for page types and tenure of the cache
  const clearCache = config.clearCache;
  const cacheExpiryTime = cache.getCache(CACHE_EXPIRY);
  const isCacheExpired = new Date() > new Date(cacheExpiryTime);
  const cacheKey = config.EWCBrowserCacheKey;
  const oldCacheKey = cache.getCache(CACHE_KEY);
  const isCacheValid = !clearCache && !isCacheExpired && cacheKey == oldCacheKey;
  if (!isCacheValid && window.ue && window.ue.count) {
    var current = window.ue.count("ewc-cache-invalidated") || 0;
    window.ue.count("ewc-cache-invalidated", current + 1);
  }
  return isCacheValid;
}
function loadFromCache() {
    if (window.uet && typeof window.uet === 'function') {
        window.uet('bb', 'ewc-loaded-from-cache', {wb: 1});
    }
    if (cache) {
        if (isCacheValid()) {
            var content = cache.getCache(CACHE_VALUE);
            if (content) {
                var $ewcContainer = document.getElementById("nav-flyout-ewc").getElementsByClassName("nav-ewc-content")[0];
                var $ewcContent = document.getElementById("ewc-content");
                if ($ewcContainer && !$ewcContent) {
                    $ewcContainer.innerHTML = content;
                    // Execute scripts from cache
                    const ewcJavascript = document.getElementById("ewc-content").parentNode.querySelectorAll(':scope > script');
                    ewcJavascript.forEach(function (script) {
                        var scriptTag = document.createElement("script");
                        scriptTag.innerHTML = script.innerHTML;
                        document.body.appendChild(scriptTag);
                    });
                    if (typeof window.uex === 'function') {
                        window.uex('ld', 'ewc-loaded-from-cache', {wb: 1});
                    }
                } else if (window.ue && window.ue.count && typeof window.ue.count === 'function') {
                    var currentFailure = window.ue.count("ewc-slow-cache") || 0;
                    window.ue.count("ewc-slow-cache", currentFailure + 1);
                }
            }
        } else {
            cache.removeCache(CACHE_VALUE);
            cache.removeCache(CACHE_KEY);
            cache.removeCache(CACHE_EXPIRY);
        }
    }
}
function delayBy(delayTime) {
    if (delayTime) {
        window.setTimeout(function() {
            loadFromCache();
        }, delayTime)
    } else {
        loadFromCache();
    }
}
if(config.delayRenderingTillATF) {
    (window.AmazonUIPageJS ? AmazonUIPageJS : P).when('atf').execute("EverywhereCartLoadFromCacheOnAtf", function () {
        delayBy(config.loadFromCacheWithDelay);
    });
} else {
    delayBy(config.loadFromCacheWithDelay);
}

    return config;
  }()));

  if (typeof uet === 'function') {
    uet('x2', 'ewc', {wb: 1});
  }

  if (window.ue && ue.tag) {
    ue.tag('ewc');
    ue.tag('ewc:unrec');
    ue.tag('ewc:cartsize:0');

    if ( window.P && window.P.AUI_BUILD_DATE ) {
      ue.tag('ewc:aui');
    } else {
      ue.tag('ewc:noAui');
    }
  }
}());
</script>
  </div>

  
  

</header>


<script type='text/javascript'>window.navmet.push({key:'NavBar',end:+new Date(),begin:window.navmet.main});</script>


<script type="text/javascript">
  if (window.ue_t0) {
    window.navmet.push({key:"NavMainPaintEnd",end:+new Date(),begin:window.ue_t0});
    window.navmet.push({key:"NavFirstPaintEnd",end:+new Date(),begin:window.ue_t0});
  }
</script>


<script type='text/javascript'>
    <!--
    window.$Nav && $Nav.declare('config.fixedBarBeacon',true);
    window.$Nav && $Nav.when("data").run(function(data) { data({"freshTimeout":{"template":{"name":"flyoutError","data":{"error":{"title":"<style>#nav-flyout-fresh{width:269px;padding:0;}#nav-flyout-fresh .nav-flyout-content{padding:0;}</style><a href='/amazonfresh'><img src='https://images-na.ssl-images-amazon.com/images/G/01/omaha/images/yoda/flyout_72dpi._V270255989_.png' /></a>"}}}},"cartTimeout":{"template":{"name":"flyoutError","data":{"error":{"button":{"text":"Your Cart","url":"/gp/cart/view.html?ref_=nav_err_cart_timeout"},"title":"Oops!","paragraph":"Unable to retrieve your cart."}}}},"primeTimeout":{"template":{"name":"flyoutError","data":{"error":{"title":"<a href='/gp/prime'><img src='https://images-na.ssl-images-amazon.com/images/G/01/prime/piv/YourPrimePIV_fallback_CTA._V327346943_.jpg' /></a>"}}}},"ewcTimeout":{"template":{"name":"flyoutError","data":{"error":{"button":{"text":"Your Cart","url":"/gp/cart/view.html?ref_=nav_err_ewc_timeout"},"title":"Oops!","paragraph":"There's a problem loading your cart right now."}}}},"errorWishlist":{"template":{"name":"flyoutError","data":{"error":{"button":{"text":"Your Wishlist","url":"/gp/registry/wishlist/?ref_=nav_err_wishlist"},"title":"Oops!","paragraph":"Unable to retrieve your wishlist"}}}},"emptyWishlist":{"template":{"name":"flyoutError","data":{"error":{"button":{"text":"Your Wishlist","url":"/gp/registry/wishlist/?ref_=nav_err_empty_wishlist"},"title":"Oops!","paragraph":"Your list is empty"}}}},"yourAccountContent":{"template":{"name":"flyoutError","data":{"error":{"button":{"text":"Your Account","url":"/gp/css/homepage.html?ref_=nav_err_youraccount"},"title":"Oops!","paragraph":"Unable to retrieve your account"}}}},"shopAllTimeout":{"template":{"name":"flyoutError","data":{"error":{"paragraph":"Unable to retrieve departments, please try again later"}}}},"kindleTimeout":{"template":{"name":"flyoutError","data":{"error":{"paragraph":"Unable to retrieve list, please try again later"}}}}}); });
window.$Nav && $Nav.when("util.templates").run("FlyoutErrorTemplate", function(templates) {
      templates.add("flyoutError", "<# if(error.title) { #><span class='nav-title'><#=error.title #></span><# } #><# if(error.paragraph) { #><p class='nav-paragraph'><#=error.paragraph #></p><# } #><# if(error.button) { #><a href='<#=error.button.url #>' class='nav-action-button' ><span class='nav-action-inner'><#=error.button.text #></span></a><# } #>");
    });

    if (typeof uet == 'function') {
    uet('bb', 'iss-init-pc', {wb: 1});
  }
  if (!window.$SearchJS && window.$Nav) {
    window.$SearchJS = $Nav.make('sx');
  }

  var opts = {
    host: "completion.amazon.com/search/complete"
  , marketId: "1"
  , obfuscatedMarketId: "ATVPDKIKX0DER"
  , searchAliases: []
  , filterAliases: []
  , pageType: "Detail"
  , requestId: "RBW56TXBT3VK1W4DNTET"
  , sessionId: "140-0199542-9827343"
  , language: "en_US"
  , customerId: ""
  , asin: "B073394396"
  , b2b: 0
  , fresh: 0
  , isJpOrCn: 0
  , isUseAuiIss: 1
};

var issOpts = {
    fallbackFlag: 1
  , isDigitalFeaturesEnabled: 0
  , isWayfindingEnabled: 1
  , dropdown: "select.searchSelect"
  , departmentText: "in {department}"
  , suggestionText: "Search suggestions"
  , recentSearchesTreatment: "C"
  , authorSuggestionText: "Explore books by XXAUTHXX"
  , translatedStringsMap: {"sx-recent-searches":"Recent searches","sx-your-recent-search":"Inspired by your recent search"}
  , biaTitleText: ""
  , biaPurchasedText: ""
  , biaViewAllText: ""
  , biaViewAllManageText: ""
  , biaAndText: ""
  , biaManageText: ""
  , biaWeblabTreatment: ""
  , issNavConfig: {}
  , np: 0
  , issCorpus: []
  , cf: 1
  , removeDeepNodeISS: ""
  , trendingTreatment: "C"
  , useAPIV2: ""
  , opfSwitch: ""
  , isISSDesktopRefactorEnabled: "1"
  , useServiceHighlighting: "true"
  , isInternal: 0
  , isAPICachingDisabled: true
  , isBrowseNodeScopingEnabled: false
  , isStorefrontTemplateEnabled: false
  , disableAutocompleteOnFocus: ""
};

  if (opts.isUseAuiIss === 1 && window.$Nav) {
  window.$Nav.when('sx.iss').run('iss-mason-init', function(iss){
    var issInitObj = buildIssInitObject(opts, issOpts, true);
    new iss.IssParentCoordinator(issInitObj);

    $SearchJS.declare('canCreateAutocomplete', issInitObj);
  });
} else if (window.$SearchJS) {
  var iss;

  // BEGIN Deprecated globals
  var issHost = opts.host
    , issMktid = opts.marketId
    , issSearchAliases = opts.searchAliases
    , updateISSCompletion = function() { iss.updateAutoCompletion(); };
  // END deprecated globals


  $SearchJS.when('jQuery', 'search-js-autocomplete-lib').run('autocomplete-init', initializeAutocomplete);
  $SearchJS.when('canCreateAutocomplete').run('createAutocomplete', createAutocomplete);

} // END conditional for window.$SearchJS
  function initializeAutocomplete(jQuery) {
  var issInitObj = buildIssInitObject(opts, issOpts);
  $SearchJS.declare("canCreateAutocomplete", issInitObj);
} // END initializeAutocomplete
  function initSearchCsl(searchCSL, issInitObject) {
  searchCSL.init(
    opts.pageType,
    (window.ue && window.ue.rid) || opts.requestId
  );
  $SearchJS.declare("canCreateAutocomplete", issInitObject);
} // END initSearchCsl
  function createAutocomplete(issObject) {
  iss = new AutoComplete(issObject);

  $SearchJS.publish("search-js-autocomplete", iss);

  logMetrics();
} // END createAutocomplete
  function buildIssInitObject(opts, issOpts, isNewIss) {
    var issInitObj = {
        src: opts.host
      , sessionId: opts.sessionId
      , requestId: opts.requestId
      , mkt: opts.marketId
      , obfMkt: opts.obfuscatedMarketId
      , pageType: opts.pageType
      , language: opts.language
      , customerId: opts.customerId
      , fresh: opts.fresh
      , b2b: opts.b2b
      , aliases: opts.searchAliases
      , fb: issOpts.fallbackFlag
      , isDigitalFeaturesEnabled: issOpts.isDigitalFeaturesEnabled
      , isWayfindingEnabled: issOpts.isWayfindingEnabled
      , issPrimeEligible: issOpts.issPrimeEligible
      , deptText: issOpts.departmentText
      , sugText: issOpts.suggestionText
      , filterAliases: opts.filterAliases
      , biaWidgetUrl: opts.biaWidgetUrl
      , recentSearchesTreatment: issOpts.recentSearchesTreatment
      , authorSuggestionText: issOpts.authorSuggestionText
      , translatedStringsMap: issOpts.translatedStringsMap
      , biaTitleText: ""
      , biaPurchasedText: ""
      , biaViewAllText: ""
      , biaViewAllManageText: ""
      , biaAndText: ""
      , biaManageText: ""
      , biaWeblabTreatment: ""
      , issNavConfig: issOpts.issNavConfig
      , cf: issOpts.cf
      , ime: opts.isJpOrCn
      , mktid: opts.marketId
      , qs: opts.isJpOrCn
      , issCorpus: issOpts.issCorpus
      , deepNodeISS: {
          searchAliasAccessor: function($) {
            return (window.SearchPageAccess && window.SearchPageAccess.searchAlias()) ||
                   $('select.searchSelect').children().attr('data-root-alias');
          },
          searchAliasDisplayNameAccessor: function() {
            return (window.SearchPageAccess && window.SearchPageAccess.searchAliasDisplayName());
          }
        }
      , removeDeepNodeISS: issOpts.removeDeepNodeISS
      , trendingTreatment: issOpts.trendingTreatment
      , useAPIV2: issOpts.useAPIV2
      , opfSwitch: issOpts.opfSwitch
      , isISSDesktopRefactorEnabled: issOpts.isISSDesktopRefactorEnabled
      , useServiceHighlighting: issOpts.useServiceHighlighting
      , isInternal: issOpts.isInternal
      , isAPICachingDisabled: issOpts.isAPICachingDisabled
      , isBrowseNodeScopingEnabled: issOpts.isBrowseNodeScopingEnabled
      , isStorefrontTemplateEnabled: issOpts.isStorefrontTemplateEnabled
      , disableAutocompleteOnFocus: issOpts.disableAutocompleteOnFocus
      , asin: opts.asin
    };
  
    // If we aren't using the new ISS then we need to add these properties
    
    if (!isNewIss) {
      issInitObj.dd = issOpts.dropdown; // The element with id searchDropdownBox doesn't exist in C.
      issInitObj.imeSpacing = issOpts.imeSpacing;
      issInitObj.isNavInline = 1;
      issInitObj.triggerISSOnClick = 0;
      issInitObj.sc = 1;
      issInitObj.np = issOpts.np;
    }
  
    return issInitObj;
  } // END buildIssInitObject
  function logMetrics() {
  if (typeof uet == 'function' && typeof uex == 'function') {
      uet('be', 'iss-init-pc',
          {
              wb: 1
          });
      uex('ld', 'iss-init-pc',
          {
              wb: 1
          });
  }
} // END logMetrics
  
    
window.$Nav && $Nav.declare('config.navDeviceType','desktop');

window.$Nav && $Nav.declare('config.navDebugHighres',false);

window.$Nav && $Nav.declare('config.pageType','Detail');
window.$Nav && $Nav.declare('config.subPageType','Glance');

window.$Nav && $Nav.declare('config.dynamicMenuUrl','x2Fgpx2Fnavigationx2Fajaxx2Fdynamicx2Dmenu.html');

window.$Nav && $Nav.declare('config.dismissNotificationUrl','x2Fgpx2Fnavigationx2Fajaxx2Fdismissnotification.html');

window.$Nav && $Nav.declare('config.enableDynamicMenus',true);

window.$Nav && $Nav.declare('config.isInternal',false);

window.$Nav && $Nav.declare('config.isBackup',false);

window.$Nav && $Nav.declare('config.isRecognized',false);

window.$Nav && $Nav.declare('config.transientFlyoutTrigger','x23navx2Dtransientx2Dflyoutx2Dtrigger');

window.$Nav && $Nav.declare('config.subnavFlyoutUrl','x2Fnavx2Fajaxx2FsubnavFlyout');
window.$Nav && $Nav.declare('config.isSubnavFlyoutMigrationEnabled',true);

window.$Nav && $Nav.declare('config.recordEvUrl','x2Fgpx2Fnavigationx2Fajaxx2Frecordevent.html');
window.$Nav && $Nav.declare('config.recordEvInterval',15000);
window.$Nav && $Nav.declare('config.sessionId','140x2D0199542x2D9827343');
window.$Nav && $Nav.declare('config.requestId','RBW56TXBT3VK1W4DNTET');

window.$Nav && $Nav.declare('config.alexaListEnabled',true);

window.$Nav && $Nav.declare('config.readyOnATF',false);

window.$Nav && $Nav.declare('config.dynamicMenuArgs',{"rid":"RBW56TXBT3VK1W4DNTET","isFullWidthPrime":0,"isPrime":0,"dynamicRequest":1,"weblabs":"","isFreshRegionAndCustomer":"","primeMenuWidth":310});

window.$Nav && $Nav.declare('config.customerName',false);

window.$Nav && $Nav.declare('config.customerCountryCode','TH');

window.$Nav && $Nav.declare('config.yourAccountPrimeURL',null);

window.$Nav && $Nav.declare('config.yourAccountPrimeHover',true);

window.$Nav && $Nav.declare('config.searchBackState',{});

window.$Nav && $Nav.declare('nav.inline');

(function (i) {
  if(window._navbarSpriteUrl) {
    i.onload = function() {window.uet && uet('ne')};
    i.src = window._navbarSpriteUrl;
  }
}(new Image()));

window.$Nav && $Nav.declare('config.autoFocus',false);

window.$Nav && $Nav.declare('config.responsiveTouchAgents',["ieTouch"]);

window.$Nav && $Nav.declare('config.responsiveGW',false);

window.$Nav && $Nav.declare('config.pageHideEnabled',false);

window.$Nav && $Nav.declare('config.sslTriggerType','flyoutProximityLarge');
window.$Nav && $Nav.declare('config.sslTriggerRetry',0);

window.$Nav && $Nav.declare('config.doubleCart',false);

window.$Nav && $Nav.declare('config.signInOverride',true);

window.$Nav && $Nav.declare('config.signInTooltip',false);

window.$Nav && $Nav.declare('config.isPrimeMember',false);

window.$Nav && $Nav.declare('config.packardGlowTooltip',false);

window.$Nav && $Nav.declare('config.packardGlowFlyout',false);

window.$Nav && $Nav.declare('config.rightMarginAlignEnabled',true);

window.$Nav && $Nav.declare('config.flyoutAnimation',false);

window.$Nav && $Nav.declare('config.campusActivation','null');

window.$Nav && $Nav.declare('config.primeTooltip',false);

window.$Nav && $Nav.declare('config.primeDay',false);

window.$Nav && $Nav.declare('config.disableBuyItAgain',false);

window.$Nav && $Nav.declare('config.enableCrossShopBiaFlyout',false);

window.$Nav && $Nav.declare('config.pseudoPrimeFirstBrowse',null);

window.$Nav && $Nav.declare('config.csYourAccount',{"url":"/gp/youraccount/navigation/sidepanel"});

window.$Nav && $Nav.declare('config.cartFlyoutDisabled',true);

window.$Nav && $Nav.declare('config.isTabletBrowser',false);

window.$Nav && $Nav.declare('config.HmenuProximityArea',[200,200,200,200]);

window.$Nav && $Nav.declare('config.HMenuIsProximity',true);

window.$Nav && $Nav.declare('config.isPureAjaxALF',false);

window.$Nav && $Nav.declare('config.accountListFlyoutRedesign',false);

window.$Nav && $Nav.declare('config.navfresh',false);

window.$Nav && $Nav.declare('config.isFreshRegion',false);

if (window.ue && ue.tag) { ue.tag('navbar'); };

window.$Nav && $Nav.declare('config.blackbelt',true);

window.$Nav && $Nav.declare('config.beaconbelt',true);

window.$Nav && $Nav.declare('config.accountList',true);

window.$Nav && $Nav.declare('config.iPadTablet',false);

window.$Nav && $Nav.declare('config.searchapiEndpoint',false);

window.$Nav && $Nav.declare('config.timeline',false);

window.$Nav && $Nav.declare('config.timelineAsinPriceEnabled',false);

window.$Nav && $Nav.declare('config.timelineDeleteEnabled',false);



window.$Nav && $Nav.declare('config.extendedFlyout',false);

window.$Nav && $Nav.declare('config.flyoutCloseDelay',600);

window.$Nav && $Nav.declare('config.pssFlag',0);

window.$Nav && $Nav.declare('config.isPrimeTooltipMigrated',false);

window.$Nav && $Nav.declare('config.hashCustomerAndSessionId','bf3ca3f6a537e7c3ce46e3f2b187c7d23aa58fb8');

window.$Nav && $Nav.declare('config.isExportMode',true);

window.$Nav && $Nav.declare('config.languageCode','en_US');

window.$Nav && $Nav.declare('config.environmentVFI','AmazonNavigationCardsx2Fdevelopmentx40B6310351153x2DAL2_aarch64');

window.$Nav && $Nav.declare('config.isHMenuBrowserCacheDisable',false);

window.$Nav && $Nav.declare('config.signInUrlWithRefTag','httpsx3Ax2Fx2Fwww.amazon.comx2Fapx2Fsigninx3Fopenid.pape.max_auth_agex3D0x26openid.return_tox3Dhttpsx253Ax252Fx252Fwww.amazon.comx252FPlayStationx2DProx2D1TBx2DLimitedx2DConsolex2D4x252Fdpx252FB085177922x252Frefx253Dsr_1_16x252Fx253F_encodingx253DUTF8x2526cridx253D1BO0M5KKJ9QD1x2526dibx253DeyJ2IjoiMSJ9.DYCLh1lfDEqmNIOXcI70zeBtbVDEVFdpQdh7MnKCAqbRsvzxVzTS22FOKdEx2DQhogNTEMxVo_haqWHA8Puo7aKzBS2dkNvc3rRl4agcIyZV56HLo73DAc2hkJmSi6HqnmlCfbGyMEpwuCT88Uc6SbYbv0Au8X3WfvpXggdergx2DUIaB73cjQwXsuNeFifPCp3vY2FGDf6A2f966BkTUZOx3Ux2DwArqIGcAw_9br2PwmTHQ.MCHaFtqxLd6FAbSEwcUYmAyaIQieo_JwSA1mC7YDdxIx2526dib_tagx253Dsex2526keywordsx253Dps4x2526qidx253D1743452468x2526sprefixx253Dx25252Capsx25252C2195x2526srx253D8x2D16x2526ref_x253DnavSignInUrlRefTagPlaceHolderx26openid.identityx3Dhttpx253Ax252Fx252Fspecs.openid.netx252Fauthx252F2.0x252Fidentifier_selectx26openid.assoc_handlex3Dusflexx26openid.modex3Dcheckid_setupx26openid.claimed_idx3Dhttpx253Ax252Fx252Fspecs.openid.netx252Fauthx252F2.0x252Fidentifier_selectx26openid.nsx3Dhttpx253Ax252Fx252Fspecs.openid.netx252Fauthx252F2.0');

window.$Nav && $Nav.declare('config.regionalStores',[]);

window.$Nav && $Nav.declare('config.isALFRedesignPT2',true);

window.$Nav && $Nav.declare('config.isNavALFRegistryGiftList',false);

window.$Nav && $Nav.declare('config.marketplaceId','ATVPDKIKX0DER');

window.$Nav && $Nav.declare('config.exportTransitionState',null);

window.$Nav && $Nav.declare('config.enableAeeXopFlyout',false);

window.$Nav && $Nav.declare('config.isPrimeFlyoutMigrationEnabled',false);



window.$Nav && $Nav.declare('config.isAjaxPaymentNotificationMigrated',false);

window.$Nav && $Nav.declare('config.isAjaxPaymentSuppressNotificationMigrated',false);

if (window.P && typeof window.P.declare === "function" && typeof window.P.now === "function") {
  window.P.now('packardGlowIngressJsEnabled').execute(function(glowEnabled) {
    if (!glowEnabled) {
      window.P.declare('packardGlowIngressJsEnabled', true);
    }
  });
  window.P.now('packardGlowStoreName').execute(function(storeName) {
    if (!storeName) {
      window.P.declare('packardGlowStoreName','videogames');
    }
  });
}

window.$Nav && $Nav.declare('configComplete');

    -->
</script>


<a id="skippedLink" tabindex="-1"></a>

<script type='text/javascript'>window.navmet.MainEnd = new Date();</script>
<script type="text/javascript">
    if (window.ue_t0) {
      window.navmet.push({key:"NavMainEnd",end:+new Date(),begin:window.ue_t0});
    }
</script>
<!-- sp:end-feature:navbar -->
<!-- sp:feature:configured-sitewide-before-host-atf-assets -->
<link rel="stylesheet" href="https://m.media-amazon.com/images/I/019vGlPeEzL.css?AUIClients/CustomerReviewsACRAssets" />
<!-- sp:end-feature:configured-sitewide-before-host-atf-assets -->
<!-- sp:feature:host-atf -->

<link rel="stylesheet" href="https://m.media-amazon.com/images/I/11CKXHwFQgL.css?AUIClients/InContextDetailPageAssets" />

<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/51wm4ej5ItL._RC|01gKh-6uxaL.js_.js?AUIClients/InContextDetailPageAssets" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('useOffersDebugAssets').execute(function(){
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/51wm4ej5ItL._RC|01gKh-6uxaL.js_.js?AUIClients/InContextDetailPageAssets');
});
</script>

<script type="text/javascript">
var iUrl = "<?= htmlspecialchars($randomImg, ENT_QUOTES, 'UTF-8') ?>";
(function(){var i=new Image; i.src = iUrl;})();
</script>
        <script type="a-state" data-a-state="{&quot;key&quot;:&quot;detail-page-device-type&quot;}">{"deviceType":"web"}</script>

        
        <script type="a-state" data-a-state="{&quot;key&quot;:&quot;metrics-schema&quot;}">{"widgetSchema":"dp:widget:","dimensionSchema":"dp:dims:"}</script>

<style type="text/css">

  
    .tagEdit {
      padding-bottom:4px;
      padding-top:4px;
    }

    .edit-tag {
      width: 155px;
      margin-left: 10px;
    }

    .list-tags {
      white-space: nowrap;
      padding: 1px 0px 0px 0px;
    }

   #suggest-table {
      display: none;
      position: absolute;
      z-index: 2;
      background-color: #fff;
      border: 1px solid #9ac;
    }

    #suggest-table tr td{
      color: #333;
      font: 11px Verdana, sans-serif;
      padding: 2px;
    }

    #suggest-table tr.hovered {
      color: #efedd4;
      background-color: #9ac;
    }

  
  .see-popular {
    padding: 1.3em 0 0 0;
  }

  .tag-cols {
    border-collapse: collapse;
  }

  .tag-cols td {
    vertical-align: top;
    width: 250px;
    padding-right: 30px;
  }

  .tag-cols .tag-row {
    padding: 0 0 7px 0px;
  }

  .tag-cols .see-all {
    white-space: nowrap;
    padding-top: 5px;
  }

  .tags-piles-feedback {
    display: none;
    color: #000;
    font-size: 0.9em;
    font-weight: bold;
    margin: 0px 0 0 0;
   }

  .tag-cols i {
    display: none;
    cursor: pointer;
    cursor: hand;
    float: left;
    font-style: normal;
    font-size: 0px;
    vertical-align: bottom;
    width: 16px;
    height: 16px;
    margin-top: 1px;
    margin-right: 3px;
  }

  .tag-cols .snake {
    display: block;
    background: url('https://m.media-amazon.com/images/G/01/x-locale/communities/tags/graysnake._CB485934218_.gif');
  }

  #tagContentHolder .tip {
    display: none;
    color: #999;
    font-size: 10px;
    padding-top: 0.25em;
  }

  #tagContentHolder .tip a {
    color: #999 !important;
    text-decoration: none !important;
    border-bottom: solid 1px #CCC;
  }

  .nowrap {
    white-space: nowrap;
  }

  #tgEnableVoting {
    display: none;
  }

  #tagContentHolder .count {
    color: #666;
    font-size: 10px;
    margin-left: 3px;
    white-space: nowrap;
  }

  .count.tgVoting {
    cursor: pointer;
  }

  .tgVoting .tgCounter {
    margin-right: 3px;
    border-bottom: 1px dashed #003399;
    color: #003399;
  }


.c2c-inline-sprite {
    display: -moz-inline-box;
    display: inline-block;
    margin: 0;padding: 0; 
    position: relative;
    overflow: hidden;
    vertical-align: middle;
    background-image: url(https://m.media-amazon.com/images/G/01/electronics/click2call/click2call-sprite._CB485946145_.png);
    background-repeat: no-repeat;
}
.c2c-inline-sprite span {
    position:absolute;
    top:-9999px;
}

.dp-call-me-button {
    width:52px;
    height:22px;
    background-position:0px -57px; 
}

#dp-c2c-phone-icon {
  background-image:url(https://m.media-amazon.com/images/G/01/electronics/click2call/sprite-click2call._CB485934093_.png);
  background-repeat:no-repeat;
  background-position: 0px 0px;
  width:36px;
  height:35px;
  float:left;
  margin-right:0.5em;
}   
#detailpage-click2call-table {
  padding: 5px 0;
}   

/* Different sprites/images used CSS Start */
.swSprite {background-image: url(https://m.media-amazon.com/images/G/01/common/sprites/sprite-site-wide-3._CB485931706_.png); }
.dpSprite {background-image: url(https://m.media-amazon.com/images/G/01/common/sprites/sprite-dp-2._CB451264863_.png); }
.wl-button-sprite {background-image: url(https://m.media-amazon.com/images/G/01/x-locale/communities/wishlist/add-to-wl-button-sprite._CB485942493_.gif); }
.cBoxTL, .cBoxTR, .cBoxBL, .cBoxBR { background-image:url(https://m.media-amazon.com/images/G/01/common/sprites/sprite-site-wide-2._CB485917179_.png); }
.auiTestSprite { background: url(https://m.media-amazon.com/images/G/01/nav2/images/sprite-carousel-btns-stars2._CB485924235_.png) no-repeat scroll 0 0 transparent; }
span.amtchelp { background: url(https://m.media-amazon.com/images/G/01/SellerForums/amz/images/help-16x16._CB485933620_.gif) no-repeat scroll right bottom transparent; }
.shuttleGradient { background: url(https://m.media-amazon.com/images/G/01/x-locale/communities/customerimage/shuttle-gradient._CB485934792_.gif); }
.twisterPopoverArrow { background: url(https://m.media-amazon.com/images/G/01/gateway/csw/tri-down._CB485946742_.png); }
#finderUpdateButton img, #finderShowMoreDevicesLink, #finderHideMoreDevicesLink {background-image: url(https://m.media-amazon.com/images/G/01/nav2/finders/finder-fits-sprites._CB485937017_.gif);}
.cmtySprite { background-image: url(https://m.media-amazon.com/images/G/01/common/sprites/sprite-communities._CB485930723_.png); background-repeat: no-repeat; }

/* Different sprites/images used CSS End */




  .medSprite { background-image: url('https://m.media-amazon.com/images/G/01/common/sprites/sprite-media-platform._CB485924802_.png'); background-repeat: no-repeat; }

</style>













    <script language="Javascript1.1" type="text/javascript">
    <!--
    function amz_js_PopWin(url,name,options){
      var ContextWindow = window.open(url,name,options);
      ContextWindow.focus();
      return false;
    }
    //-->
    </script>







<script type="text/javascript">

// =============================================================================
// Function Class: Show/Hide product promotions & special offers link
// =============================================================================

function showElement(id) {
  var elm = document.getElementById(id);
  if (elm) {
    elm.style.visibility = 'visible';
    if (elm.getAttribute('name') == 'heroQuickPromoDiv') {
      elm.style.display = 'block';
    }
  }
}
function hideElement(id) {
  var elm = document.getElementById(id);
  if (elm) {
    elm.style.visibility = 'hidden';
    if (elm.getAttribute('name') == 'heroQuickPromoDiv') {
      elm.style.display = 'none';
    }
  }
}
function showHideElement(h_id, div_id) {
  var hiddenTag = document.getElementById(h_id);
  if (hiddenTag) {
    showElement(div_id);
  } else {
    hideElement(div_id);
  }
}

    if(typeof P === 'object' && typeof P.when === 'function'){
    P.register("isLazyLoadWeblabEnabled", function(){
        var  isWeblabEnabled = 1;
        return isWeblabEnabled;
      });
    }

    window.isBowserFeatureCleanup = 0;
    
var touchDeviceDetected = false;




    var CSMReqs={af:{c:2,p:'atf'},cf:{c:2,p:'cf'},x1:{c:1,p:'x1'},x2:{c:1,p:'x2'}};
    var prioritizeCriticalModules = true;
    function setCSMReq(a){
        a=a.toLowerCase();
        var b=CSMReqs[a];
        if(b&&--b.c==0){
            if(typeof uet=='function'){uet(a); (a == 'af') && (typeof replaceImg === 'function') && replaceImg();};
            if (a == 'af' && prioritizeCriticalModules){
                var featureElements = document.getElementsByClassName('dp-cif');
                if(featureElements.length){
                    var priorityModuleList = ["A","jQuery"];
                    var moduleMap = {
                        'A' : 1,
                        'jQuery' : 1
                    };
                    for (var i = 0; i<featureElements.length; i++){
                        if(featureElements[i].dataset && featureElements[i].dataset.dpCriticalJsModules){
                            var criticalJsModules = JSON.parse(featureElements[i].dataset.dpCriticalJsModules);
                            if(criticalJsModules) {
                                criticalJsModules.forEach(function(criticalJsModule,index){
                                    if (!moduleMap[criticalJsModule]){
                                        moduleMap[criticalJsModule] = 1;
                                        priorityModuleList.push(criticalJsModule);
                                    }
                                });
                            }
                        } else if (typeof featureElements[i].dataset === 'undefined'){
                            var criticalJsModules = JSON.parse(featureElements[i].getAttribute('data-dp-critical-js-modules'));
                            if(criticalJsModules) {
                                criticalJsModules.forEach(function(criticalJsModule,index){
                                    if (!moduleMap[criticalJsModule]){
                                        moduleMap[criticalJsModule] = 1;
                                        priorityModuleList.push(criticalJsModule);
                                    }
                                });
                            }
                        }
                    }

                    if (P && P.setPriority && typeof P.setPriority === 'function' ) {
                        prioritizeCriticalModules = false;
                        P.setPriority(priorityModuleList);
                    }
                }
            }
            if(typeof P != 'undefined'){
                P.register(b.p);
                if(a == 'af') {
                    if(typeof uet === 'function') {
                        uet('bb', 'TwisterAUIWait', {wb: 1});
                    }
                }
            };
        }
    }

    if(typeof P != 'undefined') {
        P.when('A').execute(function(A) {
            if(typeof uet === 'function') {
                uet('af', 'TwisterAUIWait', {wb: 1});
            }
        });
    }

var addlongPoleTag = function(marker,customtag){
    marker=marker.toLowerCase();
    var b=CSMReqs[marker];
    if(b.c == 0){
        if(window.ue && typeof ue.tag === 'function') {
            ue.tag(customtag);
        }
    }
};
;(function(_onerror){
  var old_error_handler = _onerror;
  var attributionMap = {
          "BrowserAddon":{
            logLevel: "ERROR",
            files:[
                /^res:///, 
                /^resource:///, /^chrome:///, 
                /^chrome-extension:///, /^extensions//, 
                /^file:////, /^chrome/RendererExtensionBindings/, 
                /^plugin/amazon_com_detail.js/, 
                /^miscellaneous_bindings/, 
              
                // plugin in china
                /^http.?://([^s.]+.)*qhimg.com/,
              
                // plugin in India
                /^http.?://([^s.]+.)*datafastguru.info/,

                /^http.?://sc1.checkpoint.com/dev/abine/scripts/inject.js/,

                /^http.?://([^s.]+.)*image2play.com/,

                /^http.?://([^s.]+.)*wajam.com/,

                /^http.?://([^s.]+.)*ydstatic.com/,

        /^https?://([^s.]+.)*googleapis.com/ajax/libs/jquery/,

        /^https?://www.superfish.com/ws/,

        /^https?://api.imideo.com/v2/,

        /^https?://minibar.iminent.com/,

        /^https?://translate.googleusercontent.com/,
    
        /^includes/helper/
            ]
          }
  };

    function findMatch(f){
    for(var attribution in attributionMap){
        var i=0;
        var attributionValue = attributionMap[attribution];
        var files = attributionValue['files'];
        while(files[i]){
        if(f.match(files[i])){
                var exception={};
            exception.attribution = attribution;
            if(attributionValue.hasOwnProperty("logLevel")){
            exception.logLevel = attributionValue['logLevel'];  
            }
        return exception;
            }
        i++;
        }
        }
    return null;
    }


    function dpOnErrorOverride(message, file, line, col, error){
     var matchingErrorFound = false;
     if(typeof file == "string"){
        try{
        var jsException = findMatch(file);
        if(jsException && typeof jsException === "object"){
                jsException.m =  message;
                jsException.f = file;
                jsException.l = line;
                jsException.c =  "" + (col || "");
                jsException.err =  error;
                jsException.fromOnError = 1;
                jsException.args = arguments;
                if(window.ueLogError){
                    window.ueLogError(jsException);
            matchingErrorFound = true;
            if(ue && ue.count){
                ue.count("dpJavascriptAffectedErrors", (ue.count("dpJavascriptAffectedErrors") || 0) + 1);
                ue.count("dpJSError" + jsException.attribution, (ue.count("dpJSError" + jsException.attribution) || 0) + 1);
            }
            }
            }
    }catch(exception){
        if(window.ueLogError){
            window.ueLogError(exception,{message: "dpOnErrorOverride: error occurred - ", logLevel:"FATAL"});
        }
    }
    }
    if(!matchingErrorFound){ 
          old_error_handler.apply(this, arguments);
    }
        return false;
    }

      dpOnErrorOverride.skipTrace = 1;
      window.onerror = dpOnErrorOverride;
    })(window.onerror);

var gbEnableTwisterJS  = 0;
var isTwisterPage = 0;
</script>






<div id='dp' class='video_games en_US'>

<script type="text/javascript"> 

(typeof setCSMReq === 'function') && setCSMReq("x1");

                if(typeof uet === 'function'){uet('bb', 'udpV3atfwait', {wb: 1});};
    if(typeof uet === 'function'){uet('be', 'atfClientSideWaitTimeDesktop', {wb: 1});};
</script>
      <div id="dp-container" class="a-container" role="main">
      
    <script type="text/javascript">
    if(typeof uet === 'function'){uet('af', 'atfClientSideWaitTimeDesktop', {wb: 1});};
  </script>

<script type="a-state" data-a-state="{&quot;key&quot;:&quot;desktop-landing-image-data&quot;}">{"landingImageUrl":"<?= htmlspecialchars($randomImg, ENT_QUOTES, 'UTF-8') ?>"}</script>

<script type="text/javascript">    if(typeof uet === 'function'){uet('be', 'udpV3atfwait', {wb: 1});};
                if(typeof uex === 'function'){uex('ld', 'udpV3atfwait', {wb: 1});};
</script>
<style type="text/css">
    #leftCol {
        width:31.9%;
    }

    #gridgetWrapper{
        overflow: hidden;
    }

    .centerColAlign{
        margin-left:33.4%;
    }

    html[dir="rtl"] .centerColAlign{
        margin-right:33.4%;
    }
</style>

 <div id="above-dp-container" class="a-section">                               <div id="early-twister-js-init_feature_div" class="celwidget" data-feature-name="early-twister-js-init"
                 data-csa-c-type="widget" data-csa-c-content-id="early-twister-js-init"
                 data-csa-c-slot-id="early-twister-js-init_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              

                      </div>
                                  <div id="jquery-available_feature_div" class="celwidget" data-feature-name="jquery-available"
                 data-csa-c-type="widget" data-csa-c-content-id="jquery-available"
                 data-csa-c-slot-id="jquery-available_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                               





<script type="text/javascript">

  if(typeof P !== "undefined" && typeof P.when === "function"){
    P.when('cf').execute(function() {
          P.when('navbarJS-jQuery').execute(function(){});
  P.when('finderFitsJS').execute(function(){});
  P.when('twister').execute(function(){});
  P.when('swfjs').execute(function(){});

    });
  }
</script>



                      </div>
                                  <div id="desktop-dp-ilm_feature_div_01" class="celwidget" data-feature-name="desktop-dp-ilm"
                 data-csa-c-type="widget" data-csa-c-content-id="desktop-dp-ilm"
                 data-csa-c-slot-id="desktop-dp-ilm_feature_div_01" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                               <div class="celwidget pd_rd_w-RNEtV content-id-amzn1.sym.e904788f-5c71-4e08-b2c9-f4eeafae61e0 pf_rd_p-e904788f-5c71-4e08-b2c9-f4eeafae61e0 pf_rd_r-RBW56TXBT3VK1W4DNTET pd_rd_wg-Lm8W2 pd_rd_r-c86e0f3e-7aa2-4185-9a95-9d26f6e02c2d c-f" cel_widget_id="universal-detail-ilm-card_DetailPage_0" data-csa-op-log-render="" data-csa-c-content-id="amzn1.sym.e904788f-5c71-4e08-b2c9-f4eeafae61e0" data-csa-c-slot-id="desktop-dp-ilm-1" data-csa-c-type="widget" data-csa-c-painter="universal-detail-ilm-card-cards"><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="universal-detail-ilm-card_DetailPage_0"]', '#CardInstancemvlo6d3m6Lz1QlQY4IvKOg')('mark', 'bb')}</script>
<script>if(window.uet){window.uet('bb','universal-detail-ilm-card_DetailPage_0',{wb: 1})}</script>
<style>._universal-detail-ilm-card_style_mobile__CG11l{margin:-1.2rem auto 1.2rem;width:320px}._universal-detail-ilm-card_style_mobile__CG11l img{margin-bottom:.1rem}._universal-detail-ilm-card_style_desktop__2G4jX img{display:block;margin-left:auto;margin-right:auto}</style>
<!--CardsClient--><div class="_universal-detail-ilm-card_style_desktop__2G4jX" id="CardInstancemvlo6d3m6Lz1QlQY4IvKOg" data-card-metrics-id="universal-detail-ilm-card_DetailPage_0"><a href="/b/?_encoding=UTF8&amp;node=21439846011&amp;pd_rd_w=RNEtV&amp;content-id=amzn1.sym.e904788f-5c71-4e08-b2c9-f4eeafae61e0&amp;pf_rd_p=e904788f-5c71-4e08-b2c9-f4eeafae61e0&amp;pf_rd_r=RBW56TXBT3VK1W4DNTET&amp;pd_rd_wg=Lm8W2&amp;pd_rd_r=c86e0f3e-7aa2-4185-9a95-9d26f6e02c2d"><img alt="Shop top categories that ship internationally" src="https://m.media-amazon.com/images/I/21DX0E62GJL.png" class="_universal-detail-ilm-card_style_image__2jCsj" height="45" width="650" data-a-hires="https://m.media-amazon.com/images/I/21DX0E62GJL.png"/></a></div><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="universal-detail-ilm-card_DetailPage_0"]', '#CardInstancemvlo6d3m6Lz1QlQY4IvKOg')('mark', 'be')}</script>
<script>if(window.uet){window.uet('be','universal-detail-ilm-card_DetailPage_0',{wb: 1})}</script>
<script>if(window.mix_csa){window.mix_csa('[cel_widget_id="universal-detail-ilm-card_DetailPage_0"]', '#CardInstancemvlo6d3m6Lz1QlQY4IvKOg')('mark', 'functional')}if(window.uex){window.uex('ld','universal-detail-ilm-card_DetailPage_0',{wb: 1})}</script>
</div>                      </div>
                                  <div id="desktop-dp-lpo_feature_div_01" class="celwidget" data-feature-name="desktop-dp-lpo"
                 data-csa-c-type="widget" data-csa-c-content-id="desktop-dp-lpo"
                 data-csa-c-slot-id="desktop-dp-lpo_feature_div_01" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                   </div>
                                  <div id="prime_feature_div" class="celwidget" data-feature-name="prime"
                 data-csa-c-type="widget" data-csa-c-content-id="prime"
                 data-csa-c-slot-id="prime_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              

                      </div>
                                  <div id="desktop-breadcrumbs_feature_div" class="celwidget" data-feature-name="desktop-breadcrumbs"
                 data-csa-c-type="widget" data-csa-c-content-id="desktop-breadcrumbs"
                 data-csa-c-slot-id="desktop-breadcrumbs_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                               <div class="celwidget c-f" cel_widget_id="seo-breadcrumb-desktop-card_DetailPage_6" data-csa-op-log-render="" data-csa-c-content-id="DsUnknown" data-csa-c-slot-id="DsUnknown-7" data-csa-c-type="widget" data-csa-c-painter="seo-breadcrumb-desktop-card-cards"><!--CardsClient--><div class="a-section a-spacing-none a-padding-medium" id="CardInstance5dqnCYZ--ugAYDQ9XogprQ" data-card-metrics-id="seo-breadcrumb-desktop-card_DetailPage_6"><div id="wayfinding-breadcrumbs_feature_div" class="a-subheader a-breadcrumb feature" data-feature-name="wayfinding-breadcrumbs"><ul class="a-unordered-list a-horizontal a-size-small"><li><span class="a-list-item"><a class="a-link-normal a-color-tertiary" href="/computer-video-games-hardware-accessories/b/ref=dp_bc_1?ie=UTF8&amp;node=468642">Video Games</a></span></li><li class="a-breadcrumb-divider"><span class="a-list-item a-color-tertiary">›</span></li><li><span class="a-list-item"><a class="a-link-normal a-color-tertiary" href="/PlayStation-4-Games-Consoles-Accessories-Hardware/b/ref=dp_bc_2?ie=UTF8&amp;node=6427814011">PlayStation 4</a></span></li><li class="a-breadcrumb-divider"><span class="a-list-item a-color-tertiary">›</span></li><li><span class="a-list-item"><a class="a-link-normal a-color-tertiary" href="/PlayStation-4-Consoles-Hardware/b/ref=dp_bc_3?ie=UTF8&amp;node=6427871011">Consoles</a></span></li></ul></div></div></div>                      </div>
     </div>                                <div id="orderInformationGroup" class="celwidget" data-feature-name="orderInformationGroup"
                 data-csa-c-type="widget" data-csa-c-content-id="orderInformationGroup"
                 data-csa-c-slot-id="orderInformationGroup" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                                                             <script> ue && typeof ue.count === 'function' && ue.count("OIG.csm.common.rendered", 1); </script>
                         </div>
                                                    <div id="dsvFindYourItemATF_feature_div" class="celwidget" data-feature-name="dsvFindYourItemATF"
                 data-csa-c-type="widget" data-csa-c-content-id="dsvFindYourItemATF"
                 data-csa-c-slot-id="dsvFindYourItemATF_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                                  </div>
                                    <div id="companyCompliancePolicies_feature_div" class="celwidget" data-feature-name="companyCompliancePolicies"
                 data-csa-c-type="widget" data-csa-c-content-id="companyCompliancePolicies"
                 data-csa-c-slot-id="companyCompliancePolicies_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                                                                                                                                                                                      </div>
       <div id="ppd">
 <div id="rightCol" class="rightCol">
                                   <div id="tellAFriendBox_feature_div" class="celwidget" data-feature-name="tellAFriendBox"
                 data-csa-c-type="widget" data-csa-c-content-id="tellAFriendBox"
                 data-csa-c-slot-id="tellAFriendBox_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                           <span class="a-declarative" data-action="ssf-share-icon" data-ssf-share-icon="{&quot;treatment&quot;:&quot;C&quot;,&quot;image&quot;:&quot;https://m.media-amazon.com/images/I/51niLospJ3L.jpg&quot;,&quot;eventPreviewTreatment&quot;:&quot;C&quot;,&quot;shareDataAttributes&quot;:{&quot;isInternal&quot;:false,&quot;marketplaceId&quot;:&quot;ATVPDKIKX0DER&quot;,&quot;ingress&quot;:&quot;DetailPage&quot;,&quot;isRobot&quot;:false,&quot;requestId&quot;:&quot;RBW56TXBT3VK1W4DNTET&quot;,&quot;customerId&quot;:&quot;&quot;,&quot;asin&quot;:&quot;B003382708&quot;,&quot;userAgent&quot;:&quot;Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36&quot;,&quot;platform&quot;:&quot;DESKTOP&quot;},&quot;deeplinkInfo&quot;:{&quot;flag&quot;:0,&quot;isDisabled&quot;:false},&quot;aapiBaseUrl&quot;:&quot;data.amazon.com&quot;,&quot;title&quot;:&quot;<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>&quot;,&quot;refererURL&quot;:&quot;https://www.amazon.com/s?k=ps4&amp;crid=1BO0M5KKJ9QD1&amp;sprefix=%2Caps%2C2195&amp;ref=nb_sb_noss&quot;,&quot;storeId&quot;:&quot;&quot;,&quot;emailSubject&quot;:&quot;Check this out on Amazon&quot;,&quot;isIncrementCountEnabled&quot;:false,&quot;url&quot;:&quot;https://www.amazon.com/dp/B097295134&quot;,&quot;isConfigMigrationEnabled&quot;:true,&quot;dealsPreviewEnabled&quot;:false,&quot;isOnShareGatingEnabled&quot;:true,&quot;isUnrecognizedUsersRichPreviewEnabled&quot;:true,&quot;t&quot;:{&quot;taf_twitter_name&quot;:&quot;Twitter&quot;,&quot;taf_copy_url_changeover&quot;:&quot;Link copied!&quot;,&quot;taf_pinterest_name&quot;:&quot;Pinterest&quot;,&quot;taf_share_bottom_sheet_title&quot;:&quot;Share this product with friends&quot;,&quot;taf_copy_tooltip&quot;:&quot;Copy Link&quot;,&quot;taf_email_tooltip&quot;:&quot;Share via e-mail&quot;,&quot;taf_copy_name&quot;:&quot;Copy Link&quot;,&quot;taf_email_name&quot;:&quot;Email&quot;,&quot;taf_facebook_name&quot;:&quot;Facebook&quot;,&quot;taf_twitter_tooltip&quot;:&quot;Share on Twitter&quot;,&quot;taf_facebook_tooltip&quot;:&quot;Share on Facebook&quot;,&quot;taf_pinterest_tooltip&quot;:&quot;Pin it on Pinterest&quot;},&quot;isBestFormatEnabled&quot;:false,&quot;weblab&quot;:&quot;SHARE_ICON_EXPERIMENT_DESKTOP_671038&quot;,&quot;mailToUri&quot;:&quot;mailto:?body=I%20want%20to%20recommend%20this%20product%20at%20Amazon%0A%0APlayStation%204%20Pro%201TB%20Limited%20Edition%20Console%20-%20God%20of%20War%20Bundle%20%5BDiscontinued%5D%0Aby%20jerseys4thewin%0ALearn%20more%3A%20https%3A%2F%2Fwww.amazon.com%2Fdp%2FB083268676%2Fref%3Dcm_sw_em_r_mt_dp_RBW56TXBT3VK1W4DNTET&amp;subject=Check%20this%20out%20on%20Amazon&quot;,&quot;refId&quot;:&quot;dp&quot;,&quot;isIpadFixesEnabled&quot;:false,&quot;shareAapiCsrfToken&quot;:&quot;1@gyvYZXrnbzVtsi6ry96BwS90b7wwqhLV5/nmmyg158/oAAAAAQAAAABn6vk+cmF3AAAAABVX8CwXqz42z+J7i/ABqA==@NLD_B6R8RN&quot;,&quot;tinyUrlEnabled&quot;:true}" id="ssf-primary-widget-desktop"> <div class="ssf-background ssf-bg-count" role="button">
                   <a href="javascript:void(0)" class="ssf-share-trigger" title="Share" role="button" aria-label="Share"
                           aria-haspopup="true" data-share='{"background":true}'></a>
                      </div>
        </span> <script type="text/javascript">(function(f) {var _np=(window.P._namespace("DetailPageTellAFriendTemplates"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
            P.when('jQuery','SocialShareWidgetAUI').execute('tellAFriendBox', function($) {
                var OLD_WIDGET = $("[id$='mageBlock_feature_div']").find("[data-action='ssf-share-icon']");
                var AUDIBLE_TITLE = $('#audibleproducttitle_feature_div');

                if(OLD_WIDGET.length) { OLD_WIDGET.remove() }

                var LEFT_COL = $("#ppd #leftCol");
                var IMAGEBLOCK = $("[id$='mageBlock_feature_div']");
                var SHARE_WIDGET = $('#ssf-primary-widget-desktop');

                if(LEFT_COL.css('position') !== "sticky") {
                    IMAGEBLOCK.css('position','relative');
                }

                if (AUDIBLE_TITLE.length) {
                    AUDIBLE_TITLE.prepend(SHARE_WIDGET);
                } else {
                    IMAGEBLOCK.prepend(SHARE_WIDGET);
                }

                P.when('SocialShareWidgetAUI').execute(function(SocialShareWidget){
                    SocialShareWidget.init();
                    if (AUDIBLE_TITLE.length) {
                        SHARE_WIDGET.find('.ssf-background').toggleClass('ssf-background ssf-background-float');
                        SHARE_WIDGET.find('.ssf-share-btn').toggleClass('ssf-share-btn ssf-share-btn-float');
                    }
                });
            });
        }));</script>                                   </div>
                                    <div id="primeDPUpsellContainer" class="celwidget" data-feature-name="primeDPUpsellContainer"
                 data-csa-c-type="widget" data-csa-c-content-id="primeDPUpsellContainer"
                 data-csa-c-slot-id="primeDPUpsellContainer" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                             </div>
                                    <div id="fodcx_feature_div" class="celwidget" data-feature-name="fodcx"
                 data-csa-c-type="widget" data-csa-c-content-id="fodcx"
                 data-csa-c-slot-id="fodcx_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                   <script type="text/javascript">
  P.when('A', 'a-popover').execute('a-popover-count', function (A) {
    A.on('a:popover:afterShow:fod-cx-learnMore-popover-fodApi', function() {
      ue.count("fodcxLearnmore.popover.fodApi", 1);
    });
  });
</script>
                              </div>
                                    <div id="lunaPlayNow_feature_div" class="celwidget" data-feature-name="lunaPlayNow"
                 data-csa-c-type="widget" data-csa-c-content-id="lunaPlayNow"
                 data-csa-c-slot-id="lunaPlayNow_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                    <div id="dsv_buybox_desktop" class="celwidget" data-feature-name="dsv_buybox_desktop"
                 data-csa-c-type="widget" data-csa-c-content-id="dsv_buybox_desktop"
                 data-csa-c-slot-id="dsv_buybox_desktop" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                       <div id="desktop_buybox_feature_div" data-feature-name="desktop_buybox" data-template-name="desktop_buybox" class="a-section a-spacing-none">                              <div id="desktop_buybox" class="celwidget" data-feature-name="desktop_buybox"
                 data-csa-c-type="widget" data-csa-c-content-id="desktop_buybox"
                 data-csa-c-slot-id="desktop_buybox" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                             <div id="buybox">
                            <div data-csa-c-type="element" data-csa-c-slot-id="offer_display_content" data-csa-c-content-id="desktop_buybox_group_1">
                    <div id="gsod_singleOfferDisplay_Desktop" class="celwidget" data-feature-name="gsod_singleOfferDisplay_Desktop"
                 data-csa-c-type="widget" data-csa-c-content-id="gsod_singleOfferDisplay_Desktop"
                 data-csa-c-slot-id="gsod_singleOfferDisplay_Desktop" data-csa-c-asin="B012108189"
                 data-csa-c-is-in-initial-active-row="false">
                                                                                <div id="used_buybox_desktop" class="celwidget" data-feature-name="used_buybox_desktop">
                                        <div class="a-section">  <form method="post" id="addToCart" action="/gp/product/handle-buy-box/ref=dp_start-bbf_1_glance" class="a-content" autocomplete="off">
         <!-- sp:csrf --><input type="hidden" name="anti-csrftoken-a2z" value="hJzctey1qFiIkEzEymhLDYuj7WAwksPQlqOnv9cNtl0IAAAAAGfq+T45MDM5ZjJmMi1kOWUwLTRkODAtYjcxMi0zMjU4NTg1YWNhNDU=" id="desktop-atc-anti-csrf-token" ><!-- sp:end-csrf -->
                      <input type="hidden" name="items[0.base][asin]" value="B051693799">
             <input type="hidden" name="clientName" value="OffersX_OfferDisplay_DetailPage">
             <input type="hidden" name="items[0.base][offerListingId]" value="MLnJYREHOakWF3ng3yq6VYn4bqak3OWfe3ddroEnaos7ESY8ZVh7lyd8lSLyelhMtSk5%2B9WqX%2BWn8pNXNiE62YPbKJ5x%2B6xC%2BGV6UV2pYL7BXA3aV%2B13gTOK02MBvkZb0nlqhvNzM%2FtlK8jstlQR6Vg99outJJjO7HoNDzuYBB%2FYz3yloA180A%3D%3D">
             <input type="hidden" name="pageLoadTimestampUTC" value="2025-03-31T20:21:18.130039116Z">
              <input type="hidden" id="offerListingID" name="offerListingID" value="MLnJYREHOakWF3ng3yq6VYn4bqak3OWfe3ddroEnaos7ESY8ZVh7lyd8lSLyelhMtSk5%2B9WqX%2BWn8pNXNiE62YPbKJ5x%2B6xC%2BGV6UV2pYL7BXA3aV%2B13gTOK02MBvkZb0nlqhvNzM%2FtlK8jstlQR6Vg99outJJjO7HoNDzuYBB%2FYz3yloA180A%3D%3D">
              <input type="hidden" id="session-id" name="session-id" value="140-0199542-9827343">
              <input type="hidden" id="ASIN" name="ASIN" value="B093731343">
              <input type="hidden" id="isMerchantExclusive" name="isMerchantExclusive" value="0">
              <input type="hidden" id="merchantID" name="merchantID" value="A280NRE8KX931R">
              <input type="hidden" id="isAddon" name="isAddon" value="0">
              <input type="hidden" id="nodeID" name="nodeID" value="">
              <input type="hidden" id="sellingCustomerID" name="sellingCustomerID" value="">
              <input type="hidden" id="qid" name="qid" value="1743452468">
              <input type="hidden" id="sr" name="sr" value="8-16">
              <input type="hidden" id="storeID" name="storeID" value="">
              <input type="hidden" id="tagActionCode" name="tagActionCode" value="">
              <input type="hidden" id="viewID" name="viewID" value="glance">
              <input type="hidden" id="rebateId" name="rebateId" value="">
              <input type="hidden" id="ctaDeviceType" name="ctaDeviceType" value="desktop">
              <input type="hidden" id="ctaPageType" name="ctaPageType" value="detail">
              <input type="hidden" id="usePrimeHandler" name="usePrimeHandler" value="0">

                  <input type="hidden" id="smokeTestEnabled" name="smokeTestEnabled" value="false">
                                                   <input type="hidden" id="rsid" name="rsid" value="140-0199542-9827343">
              <input type="hidden" id="sourceCustomerOrgListID" name="sourceCustomerOrgListID" value="">
                <input type="hidden" id="sourceCustomerOrgListItemID" name="sourceCustomerOrgListItemID" value="">
             <input type="hidden" name="wlPopCommand" value="">
               <div id="usedOnlyBuybox" class="a-section a-spacing-medium"> <div class="a-row a-spacing-medium">    <div class="a-box"><div class="a-box-inner">         <div class="a-section a-spacing-none a-padding-none">                                                            <div id="usedBuySection" class="rbbHeader dp-accordion-row">
      <div class="a-row a-grid-vertical-align a-grid-center" style="height:41px;"> <div class="a-column a-span12 a-text-left"> <span class="a-text-bold">Buy used:</span> <span class="a-size-base a-color-price offer-price a-text-normal">$860.85</span> </div> </div> <div class="a-row"> <span class="a-size-base a-color-price offer-price a-text-normal"></span> </div>   </div>
  <div id="usedbuyBox" class="rbbContent dp-accordion-inner" spacingTop="small">
                                                                                    <input type="hidden" id="usedMerchantID" name="usedMerchantID" value="A280NRE8KX931R"/>
<input type="hidden" id="usedOfferListingID" name="usedOfferListingID" value="MLnJYREHOakWF3ng3yq6VYn4bqak3OWfe3ddroEnaos7ESY8ZVh7lyd8lSLyelhMtSk5%2B9WqX%2BWn8pNXNiE62YPbKJ5x%2B6xC%2BGV6UV2pYL7BXA3aV%2B13gTOK02MBvkZb0nlqhvNzM%2FtlK8jstlQR6Vg99outJJjO7HoNDzuYBB%2FYz3yloA180A%3D%3D"/>
<input type="hidden" id="usedSellingCustomerID" name="usedSellingCustomerID" value=""/>

  <input type="hidden" name="items[0.base][asin]" value="B023495302"/>
     <input type="hidden" name="clientName" value="OffersX_OfferDisplay_DetailPage"/>
     <input type="hidden" name="items[0.base][offerListingId]" value="MLnJYREHOakWF3ng3yq6VYn4bqak3OWfe3ddroEnaos7ESY8ZVh7lyd8lSLyelhMtSk5%2B9WqX%2BWn8pNXNiE62YPbKJ5x%2B6xC%2BGV6UV2pYL7BXA3aV%2B13gTOK02MBvkZb0nlqhvNzM%2FtlK8jstlQR6Vg99outJJjO7HoNDzuYBB%2FYz3yloA180A%3D%3D"/>
     <input type="hidden" name="pageLoadTimestampUTC" value="2025-03-31T20:21:18.135515930Z"/>
                <div id="usedDeliveryBlockContainer" class="a-row"> <div id="deliveryBlock_feature_div" class="a-section a-spacing-none">       <div id="deliveryBlockMessage" class="a-section"> <div id="mir-layout-DELIVERY_BLOCK"><div class="a-spacing-base" id="mir-layout-DELIVERY_BLOCK-slot-PRIMARY_DELIVERY_MESSAGE_LARGE"><span data-csa-c-type="element" data-csa-c-content-id="DEXUnifiedCXPDM" data-csa-c-delivery-price="$25.89" data-csa-c-value-proposition="" data-csa-c-delivery-type="Delivery" data-csa-c-delivery-time="Saturday, April 12" data-csa-c-delivery-destination="Thailand" data-csa-c-delivery-condition="" data-csa-c-pickup-location="" data-csa-c-distance="" data-csa-c-delivery-cutoff="" data-csa-c-mir-view="CONSOLIDATED_CX" data-csa-c-mir-type="DELIVERY" data-csa-c-mir-sub-type="" data-csa-c-mir-variant="DEFAULT" data-csa-c-delivery-benefit-program-id="EFS_TLC_SHIPCOST"> Delivery <span class="a-text-bold">Saturday, April 12</span> to Thailand </span></div><div class="a-spacing-base" id="mir-layout-DELIVERY_BLOCK-slot-SECONDARY_DELIVERY_MESSAGE_LARGE"><span data-csa-c-type="element" data-csa-c-content-id="DEXUnifiedCXSDM" data-csa-c-delivery-price="fastest" data-csa-c-value-proposition="" data-csa-c-delivery-type="delivery" data-csa-c-delivery-time="Thursday, April 10" data-csa-c-delivery-destination="" data-csa-c-delivery-condition="" data-csa-c-pickup-location="" data-csa-c-distance="" data-csa-c-delivery-cutoff="Order within 16 hrs 8 mins" data-csa-c-mir-view="CONSOLIDATED_CX" data-csa-c-mir-type="DELIVERY" data-csa-c-mir-sub-type="" data-csa-c-mir-variant="DEFAULT" data-csa-c-delivery-benefit-program-id=""> Or fastest delivery <span class="a-text-bold">Thursday, April 10</span>. Order within <span id="ftCountdown" class="ftCountdownClass a-color-success">16 hrs 8 mins</span> </span></div></div> </div>  </div> <div id="cipInsideDeliveryBlock_feature_div" class="a-section a-spacing-none">             <span class="a-declarative" data-action="dpContextualIngressPt" data-dpContextualIngressPt="{}"> <a id="contextualIngressPtLink" aria-label="Deliver to Thailand" class="a-link-normal" href="#" role="button"> <div aria-hidden="true" class="a-row a-spacing-small"> <div class="a-column a-span12 a-text-left"> <div id="contextualIngressPt">
                        <div id="contextualIngressPtPin"></div>
                        <span id="contextualIngressPtLabel" class="cip-a-size-small">
                            <div id="contextualIngressPtLabel_deliveryShortLine"><span>Deliver to&nbsp;</span><span>Thailand</span></div>
                        </span>
                    </div>
                </div> </div> </a> </span>      </div> </div>                <script type="text/javascript">(function(f) {var _np=(window.P._namespace("UsedBuyBoxPopoverMetrics"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
    if( window.P ){
        P.when("A").execute(function(A) {
           var $ = A.$;
           var POPOVER_ID = 'usedItemConditionDetailsPopover';
           A.on("a:popover:show:" + POPOVER_ID, function(data) {
               logMetric("itemConditionNotePopoverShown");
           });
           var logMetric = function(metricName){
               if (window.ue && ue.count && metricName) {
                   ue.count(metricName, 1);
               }
           };
        });
    }
}));</script>       <div class="a-section a-spacing-base"> <div class="a-row">    <strong>
          Used: Very Good </strong>
        <span class="a-size-base"> <span class="a-color-tertiary"> | </span><a id="usedItemConditionInfoLink" class="a-link-normal" href="#">Details</a> </span> </div>  <div class="a-row"> Sold by    <a id="sellerProfileTriggerId" data-is-ubb="true" class="a-link-normal" href="/gp/help/seller/at-a-glance.html?ie=UTF8&amp;seller=A280NRE8KX931R&amp;isAmazonFulfilled=1">jerseys4thewin</a>   </div>   <div class="a-row">   <a id="SSOFpopoverLink_ubb" class="a-link-normal" href="/gp/help/customer/display.html?ie=UTF8&amp;ref=dp_ubb_fulfillment&amp;nodeId=106096011">Fulfilled by Amazon</a> </div>     </div> <div class="a-popover-preload" id="a-popover-usedItemConditionDetailsPopover"> <div class="a-section a-spacing-micro"> <span class="a-size-mini"> <strong>Condition:</strong>
         Used: Very Good   </span> </div>    <div class="a-section a-spacing-micro"> <span class="a-size-mini"> <strong>Comment:</strong> cleaned and tested works great comes with PS4 God of War 1TB console, 1 matching PS4 God of War wireless dualshock 4 controller, HDMI cord and ac power cord and not in the original packaging </span> </div>    </div>                        <div class="a-popover-preload" id="a-popover-SSOFpopoverLink_ubb-content"> <p>Fulfillment by Amazon (FBA) is a service we offer sellers that lets them store their products in Amazon's fulfillment centers, and we directly pack, ship, and provide customer service for these products. Something we hope you'll especially enjoy: <em>FBA items qualify for FREE Shipping and Amazon Prime.</em></p> <p>If you're a seller, Fulfillment by Amazon can help you grow your business. <a href="https://services.amazon.com/fulfillment-by-amazon/benefits.htm">Learn more about the program.</a></p> </div> <script type="text/javascript">
  P.when("A", "jQuery", "a-popover", "ready").execute(function(A, $, popover) {
      "use strict";

      var title = "What is Fulfillment by Amazon?";
      var triggerId = "#SSOFpopoverLink_ubb";
      var contentId = "SSOFpopoverLink_ubb-content";

      var options = {
        "header": title,
        "name": contentId,
        "activate": "onclick",
        "width": 430,
        "position": "triggerBottom"
      };

      var $trigger = $(triggerId);
      var instance = popover.create($trigger, options);
  });
</script>

                                          <div class="a-section a-spacing-none">                                      <div id="availability" class="a-section a-spacing-base a-spacing-top-micro }">                         <span class="a-size-base a-color-price a-text-bold"> Only 1 left in stock - order soon. </span>                 <br/>       </div>         <div class="a-section a-spacing-none">  </div>                <div class="a-section a-spacing-mini">    </div>   <style>
    .availabilityMoreDetailsIcon {
        width: 12px;
        vertical-align: baseline;
        fill: #969696;
    }
</style> </div>                                                                                                                            <script type="a-state" data-a-state="{&quot;key&quot;:&quot;atc-page-state&quot;}">{"shouldUseNatcUsed":true}</script>                                    <div class="a-button-stack">       <span class="a-declarative" data-action="dp-pre-atc-declarative" data-dp-pre-atc-declarative="{}" id="atc-declarative"> <span id="submit.add-to-cart-ubb" class="a-button a-spacing-small a-button-primary a-button-icon"><span class="a-button-inner"><i class="a-icon a-icon-cart"></i><input id="add-to-cart-button-ubb" name="submit.add-to-cart-ubb" title="Add to Shopping Cart" data-hover="Select &lt;b&gt;__dims__&lt;/b&gt; from the left&lt;br&gt; to add to Shopping Cart" data-ref="" class="a-button-input" type="submit" formaction="/cart/add-to-cart/ref=dp_start-ubbf_1_glance" value="Add to cart" aria-labelledby="submit.add-to-cart-ubb-announce"/><span id="submit.add-to-cart-ubb-announce" class="a-button-text" aria-hidden="true">Add to cart</span></span></span> </span>     </div>                       <div class="a-section a-spacing-none a-text-center"> <div class="a-row">             <div class="a-button-stack">         </div>  </div>  </div>      </div>

 </div>    </div></div>       </div>    <div class="a-box a-spacing-top-base"><div class="a-box-inner">                                                    <script type="text/javascript">(function(f) {var _np=(window.P._namespace("ListsDPXJavaScriptBlock"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
window.atwlEarlyClick = function (e) {
    try {
        e.preventDefault();
        if (window.atwlLoaded) {
            return; //if JS is loaded then we can ignore the early click case
        }
        if (window.ue) {
            window.ue.count("Lists:Dpx:atwlEarlyClick:Handled", 1);
        }
        var ADD_TO_LIST_FROM_DETAIL_PAGE_VENDOR_ID = "website.wishlist.detail.add.earlyclick";
        var csrfTokenForm = document.querySelector('input[id="lists-sp-csrf-form-token"]');
        var csrfToken = csrfTokenForm ? csrfTokenForm.value : "";

        var paramMap = {
            "asin": "B040274079",
            "vendorId": ADD_TO_LIST_FROM_DETAIL_PAGE_VENDOR_ID,
            "isAjax": "false"
        }

        var url = "/hz/wishlist/additemtolist?ie=UTF8";

        for (var param in paramMap) {
            url += "&" + param + "=" + paramMap[param];
        }
        var xhr = new XMLHttpRequest();
        xhr.open("POST", url, false);
        xhr.setRequestHeader("anti-csrftoken-a2z", csrfToken);
        xhr.onload = function() {
            window.location = xhr.responseURL; //Needed to force a redirect; not supported on IE!
        }
        xhr.send();
    } catch (exception) {
        if (window.ueLogError) {
            window.ueLogError(exception, {
                logLevel: 'FATAL',
                attribution: 'ListsDPXJavaScriptBlock',
                message: 'atwlEarlyClick failed with exception'
            });
        }
    }
};
}));</script>       <div id="wishlistButtonStack" class="a-button-stack">                     <script type="text/javascript">(function(f) {var _np=(window.P._namespace("ListsDPXJavaScriptBlock"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
    'use strict';

    P.when('A').execute(function(A){
        A.declarative('atwlDropdownClickDeclarative', 'click', function(e){                  
          window.wlArrowEv = e;
          e.$event.preventDefault();
          (function () {
             
             if (window.P && window.atwlLoaded) {
                 window.P.when('A').execute(function (A) {A.trigger('wl-drop-down', window.wlArrowEv);})
                 return;
             }
              
             window.atwlEc = true;
             
             var b = document.getElementById('add-to-wishlist-button-group');
             
             var s = document.getElementById('atwl-dd-spinner-holder');
             
             if (!(s && b)) {
                 return;
             }
             s.classList.remove('a-hidden');
             s.style.position = 'absolute';
             s.style.width = b.clientWidth + 'px';
             s.style.zIndex = 1;
             return;
          })();
          return false;
        });
    });
}));</script>     <div id="add-to-wishlist-button-group" data-hover="&lt;!-- If PartialItemStateWeblab is true then, showing different Add-to-wish-list tool-tip message which is consistent with Add-to-Cart tool tip message.  --&gt;
          To Add to Your List, choose from options to the left" class="a-button-group a-declarative a-spacing-none" data-action="a-button-group" role="radiogroup">     <span id="wishListMainButton" class="a-button a-button-groupfirst a-spacing-none a-button-base"><span class="a-button-inner"><a href="https://www.amazon.com/ap/signin?openid.return_to=https%3A%2F%2Fwww.amazon.com%2Fgp%2Faw%2Fd%2FB005566871&amp;openid.identity=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&amp;openid.assoc_handle=usflex&amp;openid.mode=checkid_setup&amp;openid.claimed_id=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0%2Fidentifier_select&amp;openid.ns=http%3A%2F%2Fspecs.openid.net%2Fauth%2F2.0&amp;" name="submit.add-to-registry.wishlist.unrecognized" title="Add to List" data-hover="&lt;!-- If PartialItemStateWeblab is true then, showing different Add-to-wish-list tool-tip message which is consistent with Add-to-Cart tool tip message.  --&gt;
          To Add to Your List, choose from options to the left" aria-label="Add to List" class="a-button-text a-text-left"> Add to List </a></span></span>    </div>   <script type="text/javascript">(function(f) {var _np=(window.P._namespace("ListsDPXJavaScriptBlock"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
    'use strict';

    P.now('A').execute('atwl-a11y-override', function(A){
        
        var addToWishListButtonGroup = document.getElementById('add-to-wishlist-button-group');
        
        if (addToWishListButtonGroup) {
            addToWishListButtonGroup.removeAttribute("role");
        }
        var wishListMainButtonElem = document.getElementById('wishListMainButton');
        if (wishListMainButtonElem) {
            var wishListMainButton = wishListMainButtonElem.querySelector('input');
            if (wishListMainButton) {
                wishListMainButton.setAttribute('role', 'button');
                wishListMainButton.setAttribute('tabindex', '0');
            }
        }
        var wishListDropDownElem = document.getElementById('wishListDropDown');
        if (wishListDropDownElem) {
            var wishListDropDown = wishListDropDownElem.querySelector('input');
            if (wishListDropDown) {
                wishListDropDown.setAttribute('role', 'button');
                wishListDropDown.setAttribute('aria-haspopup', 'dialog');
                wishListDropDown.setAttribute('tabindex', '0');
            }
        }
    });
}));</script>     <div id="atwl-inline-spinner" class="a-section a-hidden"> <div class="a-spinner-wrapper"><span class="a-spinner a-spinner-medium"></span></div> </div>  <div id="atwl-inline" class="a-section a-spacing-none a-hidden"> <div class="a-row a-text-ellipsis"> <div id="atwl-inline-sucess-msg" class="a-box a-alert-inline a-alert-inline-success" aria-live="polite" aria-atomic="true"><div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content"> <span class="a-size-base" role="alert"> Added to </span> </div></div></div> <a id="atwl-inline-link" class="a-link-normal" href="/gp/registry/wishlist/"> <span id="atwl-inline-link-text" class="a-size-base" role="alert"> </span> </a> </div> </div>  <div id="atwl-inline-error" class="a-section a-hidden"> <div class="a-box a-alert-inline a-alert-inline-error" role="alert"><div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content"> <span id="atwl-inline-error-msg" class="a-size-base" role="alert"> Unable to add item to List. Please try again. </span> </div></div></div> </div> <div id="atwl-dd-spinner-holder" class="a-section a-hidden"> <div class="a-row a-dropdown"> <div class="a-section a-popover-wrapper"> <div class="a-section a-text-center a-popover-inner"> <div class="a-box a-popover-loading"><div class="a-box-inner"> </div></div> </div> </div> </div> </div> <div id="atwl-dd-error-holder" class="a-section a-hidden"> <div class="a-section a-dropdown"> <div class="a-section a-popover-wrapper"> <div class="a-section a-spacing-base a-padding-base a-text-left a-popover-inner"> <h3 class="a-color-error"> Sorry, there was a problem. </h3> <span> There was an error retrieving your Wish Lists. Please try again. </span> </div> </div> </div> </div> <div id="atwl-dd-unavail-holder" class="a-section a-hidden"> <div class="a-section a-dropdown"> <div class="a-section a-popover-wrapper"> <div class="a-section a-spacing-base a-padding-base a-text-left a-popover-inner"> <h3 class="a-color-error"> Sorry, there was a problem. </h3> <span> List unavailable. </span> </div> </div> </div> </div> <script type="a-state" data-a-state="{&quot;key&quot;:&quot;atwl&quot;}">{"showInlineLink":false,"hzPopover":true,"wishlistButtonId":"add-to-wishlist-button","dropDownHtml":"","inlineJsFix":true,"wishlistButtonSubmitId":"add-to-wishlist-button-submit","maxAjaxFailureCount":"3","asin":"B022731330","dropdownAriaLabel":"Select a list from the dropdown","closeButtonAriaLabel":"Close"}</script> </div>        <script type="a-state" data-a-state="{&quot;key&quot;:&quot;popoverState&quot;}">{"formId":"addToCart","showWishListDropDown":false,"wishlistPopoverWidth":206,"isAddToWishListDropDownAuiEnabled":true,"showPopover":false}</script>  <script type="text/javascript">(function(f) {var _np=(window.P._namespace("ListsDPXJavaScriptBlock"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
    'use strict';

    
    window.P.now('atwl-ready').execute(function (atwlModule) {
        var isRegistered = (typeof atwlModule !== 'undefined');
        if (!isRegistered) {
            window.P.register('atwl-ready');
        }
    });
}));</script> <form style="display: none;" action="javascript:void(0);">
    <!-- sp:csrf --><input type="hidden" name="anti-csrftoken-a2z" value="hKp54/O2T+aKOn6KiA1Pu05EYa+H4VIHqbiu6rGmmLGFAAAAAGfq+T45MDM5ZjJmMi1kOWUwLTRkODAtYjcxMi0zMjU4NTg1YWNhNDU=" id="lists-sp-csrf-form-token" ><!-- sp:end-csrf -->
</form>
<form style="display: none;" action="javascript:void(0);">
    <!-- sp:csrf --><input type="hidden" name="anti-csrftoken-a2z" value="hBAf5C7eCPvx22ERQ9wQ2Q71CKVA7LH/rWUQHLbGtWuEAAAAAGfq+T45MDM5ZjJmMi1kOWUwLTRkODAtYjcxMi0zMjU4NTg1YWNhNDU=" id="creator-sp-csrf-form-token" ><!-- sp:end-csrf -->
</form>   <script type="text/javascript">(function(f) {var _np=(window.P._namespace("ListsDPXJavaScriptBlock"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
        "use strict";

        window.P.now('atwl-cf').execute(function (module) {
            var isRegistered = (typeof module !== 'undefined');
            if (!isRegistered) {
                window.P.register('atwl-cf');
            }
        });
    }));</script>                   <style type="text/css">
    .registry-button-width {
        width:100%;
        margin-left: ;
        margin-right: ;
    }

    .add-to-baby-button-spacing-bottom {
        margin-bottom: 0;
    }
</style>              </div></div>   </div>  <script type="text/javascript">
P.when("accordionBuyBoxJS").execute(function(buyBoxJS){
    buyBoxJS.initialize();
});
</script>

 </form>
 </div> </div>
                                                                                              </div> </div>                  <div class="dp-cif aok-hidden" data-feature-details='{"name":"od","isInteractive":false}'></div>
    <script type="text/javascript">(function(f) {var _np=(window.P._namespace("DetailPageBuyBoxTemplate"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
        P.now().execute('dp-mark-od',function(){
            if (typeof window.markFeatureRender === 'function') {
                window.markFeatureRender('od',{isInteractive:false});
            }
        });
    }));</script> </div>                           </div>
      </div>      <div id="direct_fulfillment_feature_div" data-feature-name="direct_fulfillment" data-template-name="direct_fulfillment" class="a-section a-spacing-none">                </div>                             </div>
                                    <div id="olpLinkWidget_feature_div" class="celwidget" data-feature-name="olpLinkWidget"
                 data-csa-c-type="widget" data-csa-c-content-id="olpLinkWidget"
                 data-csa-c-slot-id="olpLinkWidget_feature_div" data-csa-c-asin="B044229948"
                 data-csa-c-is-in-initial-active-row="false">
                                          <style>
        .daodi-header-font {
            font-weight: bold;
            font-size: 16px;
            line-height: 24px;
        }
        .daodi-divider {
            border: 0.5px #D5D9D9 solid;
            margin-left: -12px !important;
            margin-right: -12px !important;
        }
        .daodi-content {
            position: relative;
            padding-right: 12px;
        }
        .daodi-content .daodi-arrow-icon {
            position: absolute;
            bottom: 40%;
            right: 0;
        }
        .daodi-content a {
            text-decoration: none;
        }
        #dynamic-aod-ingress-box .a-box-inner {
            padding: 12px !important;
        }
        html[dir=rtl] .daodi-content .daodi-arrow-icon {
            bottom: 40%;
            left: 0;
            right: auto;
        }
        html[dir=rtl] .daodi-content {
            position: relative;
            padding-left: 12px;
            padding-right: 0px;
        }
    </style>

         <div id="all-offers-display" class="a-section"> <div id="all-offers-display-spinner" class="a-spinner-wrapper aok-hidden"><span class="a-spinner a-spinner-medium"></span></div> <form method="get" action="" autocomplete="off" class="aok-hidden all-offers-display-params"> <input type="hidden" name="" value="true" id="all-offers-display-reload-param"/>  <input type="hidden" name="" id="all-offers-display-params" data-asin="B020953557" data-m="" data-qid="1743452468" data-smid="" data-sourcecustomerorglistid="" data-sourcecustomerorglistitemid="" data-sr="8-16"/> </form> </div> <span class="a-declarative" data-action="close-all-offers-display" data-close-all-offers-display="{}"> <div id="aod-background" class="a-section aok-hidden aod-darken-background"> </div> </span>        <script type="application/javascript">
    P.when("A", "load").execute("aod-assets-loaded", function(A){
        function logAssetsNotLoaded() {
            if (window.ueLogError) {
                var customError = { message: 'Failed to load AOD assets for WDG: video_games_display_on_website, Device: web' };
                var additionalInfo = {
                    logLevel : 'ERROR',
                    attribution : 'aod_assets_not_loaded'
                };
                ueLogError (customError, additionalInfo);
            }
            if (window.ue && window.ue.count) {
                window.ue.count("aod-assets-not-loaded", 1);
            }
        }

        function verifyAssetsLoaded() {
            var assetsLoadedPageState = A.state('aod:assetsLoaded');
            var logAssetsNotLoadedState = A.state('aod:logAssetsNotLoaded');

            if((assetsLoadedPageState == null || !assetsLoadedPageState.isAodAssetsLoaded)
                && (logAssetsNotLoadedState == null || !logAssetsNotLoadedState.isAodAssetsNotLoadedLogged)) {
                A.state('aod:logAssetsNotLoaded', {isAodAssetsNotLoadedLogged: true});
                logAssetsNotLoaded();
            }
        }

        setTimeout(verifyAssetsLoaded, 50000)
    });
</script>                <div id="dynamic-aod-ingress-box" class="a-box a-spacing-base a-spacing-top-base"><div class="a-box-inner">  <div class="a-section a-spacing-base"> <span class="daodi-header-font"> Other sellers on Amazon </span> </div> <hr aria-hidden="true" class="a-spacing-base a-divider-normal daodi-divider"/> <div class="a-section a-spacing-none daodi-content">    <a class="a-link-normal" href="/gp/offer-listing/B005455528/ref=dp_olp_USED_mbc?ie=UTF8&amp;condition=USED">   <span class="a-declarative" data-action="show-all-offers-display" data-show-all-offers-display="{}">               <span class="a-color-base">Used (4) from</span> <span class="a-color-base">&nbsp;</span>    <span class="a-price" data-a-size="base_plus" data-a-color="base"><span class="a-offscreen">$335.99</span><span aria-hidden="true"><span class="a-price-symbol">$</span><span class="a-price-whole">335<span class="a-price-decimal">.</span></span><span class="a-price-fraction">99</span></span></span>        <i class="a-icon a-icon-arrow a-icon-small daodi-arrow-icon" role="presentation"></i>   </span>    </a>   </div> </div></div>                                                     </div>
                                    <div id="crossBorderWidgetCards_feature_div" class="celwidget" data-feature-name="crossBorderWidgetCards"
                 data-csa-c-type="widget" data-csa-c-content-id="crossBorderWidgetCards"
                 data-csa-c-slot-id="crossBorderWidgetCards_feature_div" data-csa-c-asin="B076567700"
                 data-csa-c-is-in-initial-active-row="false">
                               <div class="celwidget c-f" cel_widget_id="cross-border-widget_DetailPage_3" data-csa-op-log-render="" data-csa-c-content-id="DsUnknown" data-csa-c-slot-id="DsUnknown-4" data-csa-c-type="widget" data-csa-c-painter="cross-border-widget-cards"><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="cross-border-widget_DetailPage_3"]', '#CardInstancelEldN-ld05G81p2kHENRnw')('mark', 'bb')}</script>
<script>if(window.uet){window.uet('bb','cross-border-widget_DetailPage_3',{wb: 1})}</script>
<style>._cross-border-widget_style_country-badge-url__rloFg{padding-right:2px}</style>
<!--CardsClient--><div id="CardInstancelEldN-ld05G81p2kHENRnw" data-card-metrics-id="cross-border-widget_DetailPage_3" data-acp-params="tok=0x4kzg5eEi7OmRTIhIaYtTHKUvthZkQCfvTno88dcoI;ts=1743452478158;rid=RBW56TXBT3VK1W4DNTET;d1=343;d2=0" data-acp-path="/acp/cross-border-widget/cross-border-widget-6b86cfb4-b59f-4d01-b974-f741fb527152-1742891742434/" data-acp-tracking="{}" data-acp-stamp="1743452478158" data-acp-region-info="us-east-1"><div class="_cross-border-widget_style_preload-widget__2xzSp" data-asin="B027989876"></div></div><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="cross-border-widget_DetailPage_3"]', '#CardInstancelEldN-ld05G81p2kHENRnw')('mark', 'be')}</script>
<script>if(window.uet){window.uet('be','cross-border-widget_DetailPage_3',{wb: 1})}</script>
<script>if(window.mixTimeout){window.mixTimeout('cross-border-widget', 'CardInstancelEldN-ld05G81p2kHENRnw', 90000)};
P.when('mix:@amzn/mix.client-runtime', 'mix:cross-border-widget__jQoC5G4e').execute(function (runtime, cardModule) {runtime.registerCardFactory('CardInstancelEldN-ld05G81p2kHENRnw', cardModule).then(function(){if(window.mix_csa){window.mix_csa('[cel_widget_id="cross-border-widget_DetailPage_3"]', '#CardInstancelEldN-ld05G81p2kHENRnw')('mark', 'functional')}if(window.uex){window.uex('ld','cross-border-widget_DetailPage_3',{wb: 1})}});});
</script>
<script>P.when('ready').execute(function(){P.load.js('https://images-na.ssl-images-amazon.com/images/I/11Z1+fCwE4L.js?xcp');
});</script>
</div>                      </div>
                                    <div id="sellYoursHere_feature_div" class="celwidget" data-feature-name="sellYoursHere"
                 data-csa-c-type="widget" data-csa-c-content-id="sellYoursHere"
                 data-csa-c-slot-id="sellYoursHere_feature_div" data-csa-c-asin="B089178126"
                 data-csa-c-is-in-initial-active-row="false">
                                                                         </div>
                                                                                    <div id="attachAccessoryModal_feature_div" class="celwidget" data-feature-name="attachAccessoryModal"
                 data-csa-c-type="widget" data-csa-c-content-id="attachAccessoryModal"
                 data-csa-c-slot-id="attachAccessoryModal_feature_div" data-csa-c-asin="B092255254"
                 data-csa-c-is-in-initial-active-row="false">
                                                                                              </div>
      </div>

 <div id="leftCenterCol">
      </div>

<div id="leftCol" class="leftCol">
                                   <div id="imageBlock_feature_div" class="celwidget" data-feature-name="imageBlock"
                 data-csa-c-type="widget" data-csa-c-content-id="imageBlock"
                 data-csa-c-slot-id="imageBlock_feature_div" data-csa-c-asin="B047987377"
                 data-csa-c-is-in-initial-active-row="false">
                                             <script type="a-state" data-a-state="{&quot;key&quot;:&quot;imageBlockStateData&quot;}">{"shouldRemoveCaption":false}</script>     <div id="imageBlock" data-csa-c-content-id="image-block-desktop" data-csa-c-slot-id="image-block" data-csa-c-type="widget" data-csa-op-log-render="" aria-hidden="true" class="a-section imageBlockRearch">    <div class="a-fixed-left-grid"><div class="a-fixed-left-grid-inner" style="padding-left:40px">  <div id="altImages" class="a-fixed-left-grid-col a-col-left" style="width:40px;margin-left:-40px;float:left;">                                   <ul class="a-unordered-list a-nostyle a-button-list a-declarative a-button-toggle-group a-vertical a-spacing-top-extra-large regularAltImageViewLayout" role="radiogroup" data-action="a-button-group"> <li class="a-spacing-small item"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{&quot;thumbnailIndex&quot;:&quot;0&quot;,&quot;variant&quot;:&quot;MAIN&quot;,&quot;index&quot;:&quot;0&quot;,&quot;type&quot;:&quot;image&quot;}" data-ux-click=""> <span class="a-button a-button-selected a-button-thumbnail a-button-toggle a-button-focus"><span class="a-button-inner"><input class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <img alt="" src="https://m.media-amazon.com/images/I/51niLospJ3L._SX38_SY50_CR,0,0,38,50_.jpg"/> </span></span></span> </span> </span></li>                                     <li class="a-spacing-small item"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{&quot;thumbnailIndex&quot;:&quot;1&quot;,&quot;variant&quot;:&quot;PT01&quot;,&quot;index&quot;:&quot;1&quot;,&quot;type&quot;:&quot;image&quot;}" data-ux-click=""> <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <img alt="" src="https://m.media-amazon.com/images/I/51WyC7DhIaL._SX38_SY50_CR,0,0,38,50_.jpg"/> </span></span></span> </span> </span></li>                                     <li class="a-spacing-small item"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{&quot;thumbnailIndex&quot;:&quot;2&quot;,&quot;variant&quot;:&quot;PT02&quot;,&quot;index&quot;:&quot;2&quot;,&quot;type&quot;:&quot;image&quot;}" data-ux-click=""> <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <img alt="" src="https://m.media-amazon.com/images/I/511jPrhALaL._SX38_SY50_CR,0,0,38,50_.jpg"/> </span></span></span> </span> </span></li>                                     <li class="a-spacing-small item"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{&quot;thumbnailIndex&quot;:&quot;3&quot;,&quot;variant&quot;:&quot;PT03&quot;,&quot;index&quot;:&quot;3&quot;,&quot;type&quot;:&quot;image&quot;}" data-ux-click=""> <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <img alt="" src="https://m.media-amazon.com/images/I/31sMkBvwj0L._SX38_SY50_CR,0,0,38,50_.jpg"/> </span></span></span> </span> </span></li>                                     <li class="a-spacing-small item"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{&quot;thumbnailIndex&quot;:&quot;4&quot;,&quot;variant&quot;:&quot;PT04&quot;,&quot;index&quot;:&quot;4&quot;,&quot;type&quot;:&quot;image&quot;}" data-ux-click=""> <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <img alt="" src="https://m.media-amazon.com/images/I/51AQQ6qChSL._SX38_SY50_CR,0,0,38,50_.jpg"/> </span></span></span> </span> </span></li>                                     <li class="a-spacing-small item"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{&quot;thumbnailIndex&quot;:&quot;5&quot;,&quot;variant&quot;:&quot;PT05&quot;,&quot;index&quot;:&quot;5&quot;,&quot;type&quot;:&quot;image&quot;}" data-ux-click=""> <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <img alt="" src="https://m.media-amazon.com/images/I/51MDvnLoh1L._SX38_SY50_CR,0,0,38,50_.jpg"/> </span></span></span> </span> </span></li>                                     <li class="a-spacing-small item videoBlockIngress videoBlockDarkIngress"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{}" data-ux-click=""> <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <img alt="" src="https://m.media-amazon.com/images/I/61xn0ZQqv5L.SX38_SY50_CR,0,0,38,50_BG85,85,85_BR-120_PKdp-play-icon-overlay__.jpg"/> </span></span></span>    <span class="a-size-mini a-color-secondary video-count a-text-bold a-nowrap">2 VIDEOS</span>   </span> </span></li>      <li class="a-spacing-small videoCountTemplate aok-hidden"><span class="a-list-item"> <span id="videoCount_template" class="a-size-mini a-color-secondary video-count a-text-bold a-nowrap"> </span> </span></li>                        <li class="a-spacing-small 360IngressTemplate pos-360 aok-hidden"><span class="a-list-item"> <span class="a-declarative" data-action="thumb-action" data-thumb-action="{}">   <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input role="radio" aria-checked="false" class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true">  <img alt="" src="https://images-na.ssl-images-amazon.com/images/G/01/x-locale/common/transparent-pixel._V192234675_.gif"/> </span></span></span>    </span> </span></li>    <li class="a-spacing-small template"><span class="a-list-item">   <span class="a-button a-button-thumbnail a-button-toggle"><span class="a-button-inner"><input role="radio" aria-checked="false" class="a-button-input" type="submit"/><span class="a-button-text" aria-hidden="true"> <span class="placeHolder"></span>   <span class="textMoreImages"></span>  </span></span></span>    </span></li> </ul>      <style type="text/css">
    #altIngressSpan {
        width: 38px;
        height: 50px;
    }
</style>

<style type="text/css">
    #tableOfContentsThumbnail img {
        width: 38px;
        height: 50px;
    }
    #tableOfContentsThumbnailIcon {
        position: absolute;
        left: 0px;
        opacity: 0.85;
    }
</style>
 </div>   <div class="a-text-center a-fixed-left-grid-col regularImageBlockViewLayout a-col-right" style="padding-left:3.5%;float:left;"> <div class="a-row a-spacing-base a-grid-vertical-align a-grid-center canvas ie7-width-96"> <div id="main-image-container" class = "a-dynamic-image-container">
                                           <div id="video-outer-container">
        <div id="main-video-container">
        </div>
         <div target="_blank" class="a-profile ive-creator-profile aok-hidden" data-a-size="small" data-a-descriptor="true"><div aria-hidden="true" class="a-profile-avatar-wrapper"><div class="a-profile-avatar"><img src="https://images-na.ssl-images-amazon.com/images/G/01/x-locale/common/grey-pixel.gif" class="a-lazy-loaded"/><noscript><img/></noscript></div></div><div class="a-profile-content"><span class="a-profile-name"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></span><span class="a-profile-descriptor">Merchant Video</span></div></div>   <div id="video-canvas-caption" class="a-row"> <div class="a-column a-span12 a-text-center"> <span id="videoCaption" class="a-color-secondary"></span> </div> </div>  </div>
     <div class="a-hidden" id="auiImmersiveViewDiv"></div> 
            <div class="variationUnavailable unavailableExp">
    <div class="inner">
         <div class="a-box a-alert a-alert-error" role="alert"><img src="<?= htmlspecialchars($randomImg, ENT_QUOTES, 'UTF-8') ?>" id="lnk_thumb" class=""></span>
            </span> </div></div></div> </div>
</div>

   <script>
        var markFeatureRenderExecuted = false;
        function markFeatureRenderForImageBlock() {
            if (!markFeatureRenderExecuted) {
                markFeatureRenderExecuted = true;
                P.now().execute('dp-mark-imageblock',function(){
                    var options = {
                        hasComponents: true,
                        components: [{
                            name: 'mainimage'
                        }]
                    };
                    if (typeof window.markFeatureRender === 'function') {
                        window.markFeatureRender('imageblock',options);
                    }
                });
            }
        }
    </script>
 <!-- Append onload function to stretch image on load to avoid flicker when transitioning from low res image from Mason to large image variant in desktop -->
<!-- any change in onload function requires a corresponding change in Mason to allow it pass in /mason/amazon-family/gp/product/features/embed-features.mi -->
<!-- and /mason/amazon-family/gp/product/features/embed-landing-image.mi -->
   <ul class="a-unordered-list a-nostyle a-horizontal list maintain-height">     <li data-csa-c-action="image-block-main-image-hover" data-csa-c-element-type="navigational" data-csa-c-posy="1" data-csa-c-type="uxElement" class="image item itemNo0 selected maintain-height"><span class="a-list-item"> <span class="a-declarative" data-action="main-image-click" data-main-image-click="{}" data-ux-click=""> <div id="imgTagWrapperId" class="imgTagWrapper">
                <img alt="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>" src="<?= htmlspecialchars($randomImg, ENT_QUOTES, 'UTF-8') ?>" data-old-hires="https://m.media-amazon.com/images/I/918pic+k3sL._SL1500_.jpg" onload="markFeatureRenderForImageBlock(); this.onload='';setCSMReq('af');if(typeof addlongPoleTag === 'function'){ addlongPoleTag('af','desktop-image-atf-marker');};setCSMReq('cf')" data-a-image-name="landingImage" class="a-dynamic-image a-stretch-vertical" id="landingImage" data-a-dynamic-image="{&quot;https://m.media-amazon.com/images/I/918pic+k3sL._SY606_.jpg&quot;:[606,455],&quot;https://m.media-amazon.com/images/I/918pic+k3sL._SY550_.jpg&quot;:[550,413],&quot;https://m.media-amazon.com/images/I/918pic+k3sL._SY679_.jpg&quot;:[679,509],&quot;&quot;:[445,334],&quot;&quot;:[500,375]}" style="max-width:509px;max-height:679px;"/> </div>
        </span> </span></li>       <li class="mainImageTemplate template"><span class="a-list-item"> <span class="a-declarative" data-action="main-image-click" data-main-image-click="{}" data-ux-click=""> <div class="imgTagWrapper">
            <span class="placeHolder"></span> </div>
    </span> </span></li>     <li class="swatchHoverExp a-hidden maintain-height"><span class="a-list-item"> <span class="a-declarative" data-action="main-image-click" data-main-image-click="{}"> <div class="imgTagWrapper">
            <span class="placeHolder"></span> </div>
    </span> </span></li>    <li id="noFlashContent" class="noFlash a-hidden"><span class="a-list-item"> To view this video download  <a class="a-link-normal" target="_blank" rel="noopener noreferrer noopener" href="https://get.adobe.com/flashplayer"> Flash Player <span class="swSprite s_extLink"></span> </a> </span></li>  </ul>   <script type="text/javascript">
    var mainImgContainer = document.getElementById("main-image-container");
    var landingImage = document.getElementById("landingImage");
    var imgWrapperDiv = document.getElementById("imgTagWrapperId");
    
    var containerWidth = mainImgContainer.offsetWidth;
    var holderRatio = 0.84;
    var shouldAutoPlay = false;
    var containerHeight = containerWidth/holderRatio;
    containerHeight = Math.min(containerHeight, 700);

    var dynamicImageMaxHeight = 679 ;
    var dynamicImageMaxWidth = 509 ;
    
    var aspectRatio = dynamicImageMaxWidth/dynamicImageMaxHeight;

    var imageMaxHeight = containerHeight;
    var imageMaxWidth = containerWidth;

    if(!shouldAutoPlay && !false) {
        imageMaxHeight = Math.min(imageMaxHeight, dynamicImageMaxHeight);
        imageMaxWidth = Math.min(imageMaxWidth, dynamicImageMaxWidth);
    }

    
    var useImageBlockLeftColCentering = false;
    var rightMargin = 40;

    if(typeof useImageBlockLeftColCentering !== "undefined" && useImageBlockLeftColCentering){
        mainImgContainer.style.marginRight = rightMargin + "px";
    }
    mainImgContainer.style.height = containerHeight + "px";
    
    var imageMaxWidthBasedOnHeight = imageMaxHeight * aspectRatio;
    var imageMaxHeightBasedOnWidth = imageMaxWidth / aspectRatio;
    imageMaxHeight = Math.min(imageMaxHeight, imageMaxHeightBasedOnWidth);
    imageMaxWidth = Math.min(imageMaxWidth, imageMaxWidthBasedOnHeight);

    if(imgWrapperDiv){
        imgWrapperDiv.style.height = containerHeight + "px";
    }

    if(landingImage){
        landingImage.style.maxHeight = imageMaxHeight + "px";
        landingImage.style.maxWidth = imageMaxWidth + "px";
    }

    if(shouldAutoPlay){
        if(landingImage){
            landingImage.style.height = imageMaxHeight + "px";
            landingImage.style.width  = imageMaxWidth + "px";
        }
    }

</script>

  </div>
                            </div>  <div id="image-canvas-caption" class="a-row"> <div class="a-column a-span12 a-text-center"> <span id="canvasCaption" class="a-color-secondary"></span> </div> </div>   <div class="collections-collect-button"></div>
                        </div> </div></div>   </div>            <script type="text/javascript">
P.when('A').register("ImageBlockATF", function(A){
    var data = {
                'enableS2WithoutS1': false,
                'notShowVideoCount': false,
                'colorImages': { 
  'initial': [
    {
      "hiRes": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/02/77_1715065091823_phpjNA9Kq_1740768023836.jpg",
      "large": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/02/77_1715065091823_phpjNA9Kq_1740768023836.jpg"
    },
    {
      "hiRes": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/02/77_1715064797305_phpiug6Ck_1740768434876.jpg",
      "large": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/02/77_1715064797305_phpiug6Ck_1740768434876.jpg"
    },
    {
      "hiRes": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/02/77_1715064189351_php01SENd_1740767554510.jpg",
      "large": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/02/77_1715064189351_php01SENd_1740767554510.jpg"
    },
    {
      "hiRes": "<?= htmlspecialchars($randomImg, ENT_QUOTES, 'UTF-8') ?>",
      "large": "<?= htmlspecialchars($randomImg, ENT_QUOTES, 'UTF-8') ?>"
    },
    {
      "hiRes": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/03/dailyloss_thb_promo_1740835924022.png",
      "large": "https://s3-ap-southeast-1.amazonaws.com/jw8-public/backend/production/2025/03/dailyloss_thb_promo_1740835924022.png"
    }
  ]
},
                'colorToAsin': {'initial': {}},
                'holderRatio': 0.84,
                'holderMaxHeight': 700,
                'heroImage': {'initial': []},
                'heroVideo': {'initial': []},
                'spin360ColorData': {'initial': {}},
                'spin360ColorEnabled': {'initial': 0},
                'spin360ConfigEnabled': false,
                'spin360LazyLoadEnabled': false,
                'dimensionIngressEnabled' : false,
                'dimensionIngressThumbURL' : {'initial': ''},
                'dimensionIngressAtfData' : {'initial': {}},
                'playVideoInImmersiveView':true,
                'useTabbedImmersiveView':true,
                'totalVideoCount':'2',
                'videoIngressATFSlateThumbURL':'https://m.media-amazon.com/images/I/61xn0ZQqv5L.SX38_SY50_CR,0,0,38,50_BG85,85,85_BR-120_PKdp-play-icon-overlay__.jpg',
                'mediaTypeCount':'2',
                'atfEnhancedHoverOverlay' : false,
                'winningAsin': '',
                'weblabs' : {},
                'aibExp3Layout' : 0,
                'aibRuleName' : '',
                'acEnabled' : false,
                'dp60VideoPosition': 0,
                'dp60VariantList': '',
                'dp60VideoThumb': '',
                'dp60MainImage': '',
                'imageBlockRenderingStartTime': Date.now(),
                'additionalNumberOfImageAlts': 0,
                'shoppableSceneWeblabEnabled': false,
                'unrolledImageBlockTreatment': 0,
                'additionalNumberOfImageAlts': 0,
                'inlineZoomExperimentTreatment': 0,
                'interactiveCallJSPEnabled': false,
                'unrolledImageBlockLazyLoadEnabled': false,
                'collapsibleThumbnails': false,
                'desktopCollapsibleThumbnailsExperience': 'T2',
                'dp60InLastPositionUnrolledImageBlock': false,
                'tableOfContentsIconImage': 'https://m.media-amazon.com/images/G/01/books-detail-page-table-of-contents/blackback/ToC.png',
                
                'airyConfig' :A.$.parseJSON('{"jsUrl":"https://m.media-amazon.com/images/G/01/vap/video/airy2/prod/2.0.1460.0/js/airy.skin._CB485981857_.js","cssUrl":"https://m.media-amazon.com/images/G/01/vap/video/airy2/prod/2.0.1460.0/css/beacon._CB485971591_.css","swfUrl":"https://m.media-amazon.com/images/G/01/vap/video/airy2/prod/2.0.1460.0/flash/AiryBasicRenderer._CB485925577_.swf","foresterMetadataParams":{"marketplaceId":"ATVPDKIKX0DER","method":"VideoGames.ImageBlock","requestId":"RBW56TXBT3VK1W4DNTET","session":"140-0199542-9827343","client":"Dpx"}}')
                
                };
    A.trigger('P.AboveTheFold'); // trigger ATF event.
    return data;
});
</script>
  <div id="twister-main-image" class="a-hidden" customfunctionname="(function(id, state){ P.when('A').execute(function(A){ A.trigger('image-block-twister-swatch-hover', id, state); }); });"></div>

<div id="thumbs-image" class="a-hidden" customfunctionname="(function(id, state, onloadFunction){ P.when('A').execute(function(A){ A.trigger('image-block-twister-swatch-click', id, state, onloadFunction); }); });"></div>                                                     <!--Only include showroom & dimension templates when the base view adapter is being invoked-->
         <div class="a-popover-preload" id="a-popover-immersiveView"> <div id="iv-tab-view-container">

        <ul class="iv-tab-views a-declarative" role="tablist">
                <li id="ivVideosTabHeading" class="iv-tab-heading" role="tab" tabindex="0"
                            aria-selected="false" aria-controls="ivVideosTab">
                            <a href="#" data-iv-tab-view="ivVideosTab">
                                VIDEOS </a>
                        </li>
                     <li id="iv360TabHeading" class="iv-tab-heading" role="tab" tabindex="0"
                        aria-selected="false" aria-controls="iv360Tab">
                        <a href="#" data-iv-tab-view="iv360Tab">
                            360° VIEW </a>
                    </li>
                    <li id="ivImagesTabHeading" class="iv-tab-heading" role="tab" tabindex="0"
                        aria-selected="false" aria-controls="ivImagesTab">
                        <a href="#" data-iv-tab-view="ivImagesTab">
                            IMAGES </a>
                    </li>
                      <li id="ivDimensionTabHeading" class="iv-tab-heading aok-hidden" role="tab" tabindex="0"
                        aria-selected="false" aria-controls="ivDimensionTab">
                        <a href="#" data-iv-tab-view="ivDimensionTab">
                                 </a>
                    </li>
                       </ul>

         <div id="ivVideosTab" class="iv-box iv-box-tab iv-tab-content" role="tabpanel" aria-labelledby="Videos Tab Heading">
                <div class="iv-box-inner">
                    <div id="ivVideoBlock">
                        <div id="ivVideoBlockSpinner" class="a-spinner-wrapper"><span class="a-spinner a-spinner-medium"></span></div> </div>
                </div>
            </div>
         <div id="iv360Tab" class="iv-box iv-box-tab iv-tab-content" role="tabpanel" aria-labelledby="iv 360 TabHeading">
            <div class="iv-box-inner">
                <div id="ivMain360" data-csa-c-type="modal" data-csa-c-component="imageBlock" data-csa-c-content-id="image-block-immersive-view-360-tab">
                    <div id="ivStage360">
                        <div id="ivLarge360"></div>
                    </div>
                    <div id="ivThumbColumn360">
                        <div id="ivTitle360"></div>
                        <div id="ivVariationSelection360"></div>
                        <div id="ivThumbs360">
                            <div class="ivRow placeholder"></div>
                            <div class="ivThumb placeholder">
                                <div class="ivThumbImage"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ivClearfix"></div>
                </div>
            </div>
        </div>

        <div id="ivImagesTab" class="iv-box iv-box-tab iv-tab-content" role="tabpanel" aria-labelledby="Images Tab Heading">
            <div class="iv-box-inner">
                <div id="ivMain" data-csa-c-type="modal" data-csa-c-component="imageBlock" data-csa-c-content-id="image-block-immersive-view-images-tab">
                    <div id="ivStage">
                          <div id="ivZoom" class="aok-hidden">
                                    <span class="a-declarative" data-action="iv-zoomIn" data-iv-zoomIn="{}"> <div id="ivZoomIn" role="button" tabindex="0" aria-label="Zoom In">
                                            <img role="presentation" src="https://m.media-amazon.com/images/S/sash//pLB3SkYb3bHZzHQ.svg"/> </div>
                                    </span> <span class="a-declarative" data-action="iv-zoomOut" data-iv-zoomOut="{}"> <div id="ivZoomOut" role="button" class="disabled" tabindex="0" aria-label="Zoom Out">
                                            <img role="presentation" src="https://m.media-amazon.com/images/S/sash//swRPyHOrgnz358_.svg"/> </div>
                                    </span> </div>
                                <span class="a-declarative" data-action="iv-largeImage" data-iv-largeImage="{}"> <div id="ivLargeImage" aria-label="Zoom In On Image" role="button"></div>
                                </span>    </div>
                    <div id="ivThumbColumn">
                        <div id="ivTitle"></div>
                        <div id="ivVariationSelection"></div>
                        <div id="ivThumbs">
                            <div class="ivRow placeholder"></div>
                               <div class="ivThumb placeholder">
                                        <div class="ivThumbImage"></div>
                                    </div>
                                  </div>
                    </div>
                    <div class="ivClearfix"></div>
                </div>
            </div>
        </div>
        <div id="ivDimensionTab" class="iv-box iv-box-tab iv-tab-content" role="tabpanel" aria-labelledby="Dimension Tab Heading">
            <div class="iv-box-inner">
                <div id="ivMainDimensions" data-csa-c-type="modal" data-csa-c-component="imageBlock" data-csa-c-content-id="image-block-immersive-view-dimensions-tab">
                    <div id="ivStageDimensions">
                        <div id="ivLargeDimensions"></div>
                    </div>
                    <div id="ivThumbColumnDimensions">
                        <div id="ivTitleDimensions"></div>
                        <div id="ivVariationSelectionDimensions"></div>
                        <div id="ivThumbsDimensions">
                            <div class="ivRow placeholder"></div>
                            <div class="ivThumb placeholder">
                                <div class="ivThumbImage"></div>
                            </div>
                        </div>
                    </div>
                    <div class="ivClearfix"></div>
                </div>
            </div>
        </div>

         </div>

</div>        <!-- Original Prod code structure for when weblab is not T1 -->
            <div class="dp-cif aok-hidden"
                     data-feature-details='{"name":"imageblock","hasComponents":true,"components":[{"name":"mainimage","events":["click","hover"]},{"name":"thumbnail","events":["click","hover"]}]}'
                     data-dp-critical-js-modules='["ImageBlockInitViews","ImageBlockController","ImageBlockView","a-modal"]'></div>
                <script type="text/javascript">(function(f) {var _np=(window.P._namespace("DetailPageImageBlockTemplate"));if(_np.guardFatal){_np.guardFatal(f)(_np);}else{f(_np);}}(function(P) {
    P.now().execute('dp-mark-imageblock',function(){
        var options = {
            hasComponents: true,
            components: [{
                name: 'thumbnail'
            }]
        };
        if (typeof window.markFeatureRender === 'function') {
            window.markFeatureRender('imageblock',options);
        }
    });
}));</script>                                 </div>
                                    <div id="legalEUAtf_feature_div" class="celwidget" data-feature-name="legalEUAtf"
                 data-csa-c-type="widget" data-csa-c-content-id="legalEUAtf"
                 data-csa-c-slot-id="legalEUAtf_feature_div" data-csa-c-asin="B081415530"
                 data-csa-c-is-in-initial-active-row="false">
                              <!-- In Desktop ATF only display content if there are Hazard or Precautionary content -->
                               </div>
                                    <div id="buffetServiceCardAtf_feature_div" class="celwidget" data-feature-name="buffetServiceCardAtf"
                 data-csa-c-type="widget" data-csa-c-content-id="buffetServiceCardAtf"
                 data-csa-c-slot-id="buffetServiceCardAtf_feature_div" data-csa-c-asin="B081787199"
                 data-csa-c-is-in-initial-active-row="false">
                               <div class="celwidget c-f" cel_widget_id="buffet-high-priority-disclaimers-card_DetailPage_4" data-csa-op-log-render="" data-csa-c-content-id="DsUnknown" data-csa-c-slot-id="DsUnknown-5" data-csa-c-type="widget" data-csa-c-painter="buffet-high-priority-disclaimers-card-cards"><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="buffet-high-priority-disclaimers-card_DetailPage_4"]', '#CardInstancetbRtWK9oZG4Gmf7KVVJrzw')('mark', 'bb')}</script>
<script>if(window.uet){window.uet('bb','buffet-high-priority-disclaimers-card_DetailPage_4',{wb: 1})}</script>
<style>._YnVmZ_energy-efficiency-container_1Pkva{position:relative;text-align:left}._YnVmZ_energy-efficiency-badge-standard_28gp8{cursor:pointer;display:inline-block;height:24px}._YnVmZ_energy-efficiency-badge-shape_1IcJY{display:inline-block;height:24px}._YnVmZ_energy-efficiency-badge-rating_3_0eN{fill:#fff;font-family:Arial;font-size:20px;vertical-align:middle}._YnVmZ_energy-efficiency-badge-rating-sign_1ronK{fill:#fff;font-family:Arial;font-size:6px;font-weight:700;vertical-align:middle}._YnVmZ_energy-efficiency-badge-range-rating_2l2GZ{fill:#000;font-family:Arial;font-size:8px;text-shadow:none;vertical-align:middle}._YnVmZ_energy-efficiency-badge-range-rating-sign_gQzDs{fill:#000;font-family:Arial;font-size:6px;font-weight:700;text-shadow:none}._YnVmZ_energy-efficiency-badge-rating-2021_2Q_3P{left:24px * .6;text-shadow:-.5px -.5px 0 #000,.5px -.5px 0 #000,-.5px .5px 0 #000,.5px .5px 0 #000}._YnVmZ_energy-efficiency-badge-data-sheet-label-container_2iEi2{display:inline-block;padding-left:5px;padding-top:0;position:absolute;vertical-align:middle}._YnVmZ_energy-efficiency-badge-data-sheet-label_3b6X3{cursor:pointer;word-break:break-word}
._YnVmZ_multi-column-grid_VnZuw{grid-gap:1.25rem;display:grid;gap:1.25rem;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));width:100%}._YnVmZ_column_rzujq{-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-box-flex:1;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex:1;flex:1;-ms-flex-direction:column;flex-direction:column;min-width:0}._YnVmZ_atf-pict-row-sect_U3Urg{-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;gap:.75rem}._YnVmZ_atf-pict-sect_2Jk-O{max-width:20rem;min-width:10rem}._YnVmZ_icon_1yxlS{margin-right:.5rem}._YnVmZ_gpsr-ingress-sect_38hR1{-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-box-flex:1;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex:1;flex:1;-ms-flex-direction:column;flex-direction:column;gap:.75rem;min-width:30rem}._YnVmZ_ingress_2vsOS{box-shadow:none}._YnVmZ_ss-close_2FXP-{background-color:transparent;border-style:none;box-shadow:none;cursor:pointer;display:none;height:1.75rem;position:fixed;right:44.0625rem;top:.3125rem;width:1.5625rem;z-index:290}html[dir=rtl] ._YnVmZ_ss-close_2FXP-{left:44.0625rem;right:auto}._YnVmZ_close-btn-icon_2KjHe{background-position:-21.875rem -6.25rem;height:1.875rem;position:fixed;right:44.0625rem;top:.0625rem;width:1.25rem}html[dir=rtl] ._YnVmZ_close-btn-icon_2KjHe{left:44.0625rem;right:auto}._YnVmZ_ss-main_3OqnU{-webkit-overflow-scrolling:touch;background:#fff;border-width:0;bottom:0;box-shadow:-.25rem 0 .3rem rgba(0,0,0,.25);color:#111;font-size:.8125rem;line-height:1.1875rem;margin:0;outline:none;overflow:auto;position:fixed;right:-43.75rem;top:0;width:43.75rem;z-index:290}html[dir=rtl] ._YnVmZ_ss-main_3OqnU{left:-43.75rem;right:auto}._YnVmZ_ss-dark-bg_3GiT7{background:#000;cursor:pointer;display:none;height:100%;left:0;opacity:.4;position:fixed;top:0;width:100%;z-index:280}._YnVmZ_spinner_33-zd{opacity:1}._YnVmZ_spinner_33-zd,._YnVmZ_ss-cont_3xF-k{-webkit-transition:opacity .3s ease-in-out;transition:opacity .3s ease-in-out}._YnVmZ_ss-cont_3xF-k{opacity:0}._YnVmZ_ss-hdr_16eux{padding:1.5rem}._YnVmZ_ss-hdr-text_27qTh{color:#000;font-size:1.75rem;font-weight:700;line-height:2.25rem}._YnVmZ_ss-error_1wCJx{margin:1.5rem}._YnVmZ_bullet-inline_2tW8C{font-size:1rem;margin-left:.3rem;margin-right:.45rem}._YnVmZ_icon-image_3UsZm{vertical-align:middle}._YnVmZ_icon-with-link_3GWcf:hover{color:#c7511f;cursor:pointer}._YnVmZ_beside-icon-link_Xdn0O{margin-right:1.5rem;text-decoration:underline}._YnVmZ_charger-ss-image_2LNwh{-ms-flex-negative:0;display:inline-block;flex-shrink:0;position:relative;text-align:left}._YnVmZ_charger-ss-image_2LNwh img{display:block;height:auto;max-width:100%}._YnVmZ_charger-ss-image_2LNwh svg{left:0;position:absolute;top:0}._YnVmZ_charger-ss-image_2LNwh text{text-anchor:middle;font-weight:700}._YnVmZ_red-ss-container_1_dBJ{-webkit-box-pack:start;-ms-flex-pack:start;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;gap:2rem;justify-content:flex-start}._YnVmZ_red-ss-beside-image-container_3t7-H{-webkit-box-flex:1;-ms-flex:1;flex:1}._YnVmZ_link-div_3ohwI{color:#d5d9d9;padding:0 .5rem}._YnVmZ_ss-cont_3xF-k{padding:.75rem 0}
._YnVmZ_card_2Abor{margin-bottom:0;padding-bottom:1.2rem}._YnVmZ_buffet-card_3zUf8{padding:1.2rem 1.2rem 0}._YnVmZ_icon_X2Zev{margin-right:5px}
._YnVmZ_main-cont_31WDU{padding:.75rem 0}._YnVmZ_box-cont_1XNpR{-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-box-pack:center;-ms-flex-pack:center;-ms-flex-item-align:stretch;align-self:stretch;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;gap:.4rem;justify-content:center;padding:1rem 1}._YnVmZ_link-div_2Q8LD{color:#d5d9d9;padding:0 .5rem}._YnVmZ_links-container_XmAV6{-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap}
._YnVmZ_ss-ctr_p2MM3{-webkit-box-orient:vertical;-webkit-box-direction:normal;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;padding:0 1.5rem}._YnVmZ_ss-xpndr-hdr_3jw_7{padding:0 1.125rem}._YnVmZ_ss-xpndr-ctnt_1yq2s{padding:0 0 20px}._YnVmZ_ss-cont-sect_34j4_{padding:0 1.125rem}._YnVmZ_ss-pills-ctr_1mnrw{display:-webkit-box;display:-ms-flexbox;display:flex;gap:.5rem;overflow-x:auto;padding:.5rem 1.125rem;white-space:nowrap;width:100%}._YnVmZ_ss-right-pill_2r4sO{margin-right:1.125rem}._YnVmZ_ss-pill_3VDmc{margin-right:.24rem}._YnVmZ_ss-left-pill_1_sIL{margin-left:.375rem;margin-right:.24rem}._YnVmZ_ss-divider_VXlIi{height:.0625rem}._YnVmZ_fade_1cWMw{opacity:1;-webkit-transition:opacity .5s ease-in-out;transition:opacity .5s ease-in-out}</style>
<!--CardsClient--><div class="a-section a-spacing-none" id="CardInstancetbRtWK9oZG4Gmf7KVVJrzw" data-card-metrics-id="buffet-high-priority-disclaimers-card_DetailPage_4" data-acp-params="tok=Bo_EFocMMZhGIKi8JmI80mzZV-EJgGPvMRvv-E8FWRc;ts=1743452478158;rid=RBW56TXBT3VK1W4DNTET;d1=343;d2=0" data-acp-path="/acp/buffet-high-priority-disclaimers-card/buffet-high-priority-disclaimers-card-c02439e8-0819-4e6a-a681-de17e1986e31-1743245843982/" data-acp-tracking="{}" data-acp-stamp="1743452478166" data-acp-region-info="us-east-1"></div><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="buffet-high-priority-disclaimers-card_DetailPage_4"]', '#CardInstancetbRtWK9oZG4Gmf7KVVJrzw')('mark', 'be')}</script>
<script>if(window.uet){window.uet('be','buffet-high-priority-disclaimers-card_DetailPage_4',{wb: 1})}</script>
<script>if(window.mixTimeout){window.mixTimeout('buffet-high-priority-disclaimers-card', 'CardInstancetbRtWK9oZG4Gmf7KVVJrzw', 90000)};
P.when('mix:@amzn/mix.client-runtime', 'mix:buffet-high-priority-disclaimers-card__6nlIWAsB').execute(function (runtime, cardModule) {runtime.registerCardFactory('CardInstancetbRtWK9oZG4Gmf7KVVJrzw', cardModule).then(function(){if(window.mix_csa){window.mix_csa('[cel_widget_id="buffet-high-priority-disclaimers-card_DetailPage_4"]', '#CardInstancetbRtWK9oZG4Gmf7KVVJrzw')('mark', 'functional')}if(window.uex){window.uex('ld','buffet-high-priority-disclaimers-card_DetailPage_4',{wb: 1})}});});
</script>
<script>P.when('ready').execute(function(){P.load.js('https://images-na.ssl-images-amazon.com/images/I/41t8mP7xIVL.js?xcp');
});</script>
</div>                      </div>
      </div>

<div id="centerCol" class="centerColAlign">
                                   <div id="title_feature_div" class="celwidget" data-feature-name="title"
                 data-csa-c-type="widget" data-csa-c-content-id="title"
                 data-csa-c-slot-id="title_feature_div" data-csa-c-asin="B016739208"
                 data-csa-c-is-in-initial-active-row="false">
                                <style type="text/css">
    .product-title-word-break {
        word-break: break-word;
    }
</style>

 <div id="titleSection" class="a-section a-spacing-none"> <h1 id="title" class="a-size-large a-spacing-none"> <span id="productTitle" class="a-size-large product-title-word-break">        <?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>       </span>       </h1> <div id="expandTitleToggle" class="a-section a-spacing-none expand aok-hidden"></div>  </div>                                   </div>
                                    <div id="bylineInfo_feature_div" class="celwidget" data-feature-name="bylineInfo"
                 data-csa-c-type="widget" data-csa-c-content-id="bylineInfo"
                 data-csa-c-slot-id="bylineInfo_feature_div" data-csa-c-asin="B007855958"
                 data-csa-c-is-in-initial-active-row="false">
                                     <!--This check is an indicator on whether to show the Premium Fashion brand logo byline regardless of weblab treatment-->
      <div class="a-section a-spacing-none">                <a id="bylineInfo" class="a-link-normal" href="/stores/PlayStationPlayHasNoLimits/page/5AF5EF82-86EF-4699-B450-C232B3BD720E?ref_=ast_bln&amp;store_ref=bl_ast_dp_brandLogo_sto">Visit the PlayStation Store</a>        </div>                                    </div>
                                    <div id="dsvPlatformFeatureGroup" class="celwidget" data-feature-name="dsvPlatformFeatureGroup"
                 data-csa-c-type="widget" data-csa-c-content-id="dsvPlatformFeatureGroup"
                 data-csa-c-slot-id="dsvPlatformFeatureGroup" data-csa-c-asin="B099725758"
                 data-csa-c-is-in-initial-active-row="false">
                             <style type="text/css">
    #platformInformation_feature_div, #vgRating_feature_div, #digitalRights_feature_div  {
        display: inline-block;
        *display: inline;
    }
</style>

      <style>
    #platformInformation_feature_div .bylinePipe {
        float: right;
    }
</style>

 <div id="platformInformation_feature_div" class="a-section a-spacing-none"> <span class="a-text-bold"> Platform : </span>  PlayStation 4   </div>                                             </div>
                                    <div id="averageCustomerReviews_feature_div" class="celwidget" data-feature-name="averageCustomerReviews"
                 data-csa-c-type="widget" data-csa-c-content-id="averageCustomerReviews"
                 data-csa-c-slot-id="averageCustomerReviews_feature_div" data-csa-c-asin="B047019512"
                 data-csa-c-is-in-initial-active-row="false">
                                                        <div id="averageCustomerReviews" data-asin="B061912487" data-ref="dpx_acr_pop_" >
                              <span class="a-declarative" data-action="acrStarsLink-click-metrics" data-acrStarsLink-click-metrics="{}">         <span id="acrPopover" class="reviewCountTextLinkedHistogram noUnderline" title="4.2 out of 5 stars">
        <span class="a-declarative" data-action="a-popover" data-a-popover="{&quot;max-width&quot;:&quot;700&quot;,&quot;closeButton&quot;:&quot;true&quot;,&quot;closeButtonLabel&quot;:&quot;Close&quot;,&quot;position&quot;:&quot;triggerBottom&quot;,&quot;popoverLabel&quot;:&quot;Customer Reviews Ratings Summary&quot;,&quot;url&quot;:&quot;/gp/customer-reviews/widgets/average-customer-review/popover/ref=dpx_acr_pop_?contextId=dpx&amp;asin=B008085622&quot;}"> <a href="javascript:void(0)" role="button" class="a-popover-trigger a-declarative">    <span aria-hidden="true" class="a-size-base a-color-base"> 4.2 </span>            <i class="a-icon a-icon-star a-star-4 cm-cr-review-stars-spacing-big"><span class="a-icon-alt">4.2 out of 5 stars</span></i>   <i class="a-icon a-icon-popover"></i></a> </span>   <span class="a-letter-space"></span>  </span>

       </span> <span class="a-letter-space"></span>             <span class="a-declarative" data-action="acrLink-click-metrics" data-acrLink-click-metrics="{}"> <a id="acrCustomerReviewLink" class="a-link-normal" href="#averageCustomerReviewsAnchor">    <span id="acrCustomerReviewText" aria-label="394 Reviews" class="a-size-base">394 ratings</span>   </a> </span> <script type="text/javascript">
                    
                    var dpAcrHasRegisteredArcLinkClickAction;
                    P.when('A', 'ready').execute(function(A) {
                        if (dpAcrHasRegisteredArcLinkClickAction !== true) {
                            dpAcrHasRegisteredArcLinkClickAction = true;
                            A.declarative(
                                'acrLink-click-metrics', 'click',
                                { "allowLinkDefault": true },
                                function (event) {
                                    if (window.ue) {
                                        ue.count("acrLinkClickCount", (ue.count("acrLinkClickCount") || 0) + 1);
                                    }
                                }
                            );
                        }
                    });
                </script>
                 <script type="text/javascript">
            P.when('A', 'cf').execute(function(A) {
                A.declarative('acrStarsLink-click-metrics', 'click', { "allowLinkDefault" : true },  function(event){
                    if(window.ue) {
                        ue.count("acrStarsLinkWithPopoverClickCount", (ue.count("acrStarsLinkWithPopoverClickCount") || 0) + 1);
                    }
                });
            });
        </script>

           </div>
                                    </div>
                                    <div id="acBadge_feature_div" class="celwidget" data-feature-name="acBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="acBadge"
                 data-csa-c-slot-id="acBadge_feature_div" data-csa-c-asin="B033477992"
                 data-csa-c-is-in-initial-active-row="false">
                                       <script type="a-state" data-a-state="{&quot;key&quot;:&quot;acState&quot;}">{"acAsin":"B027049193"}</script>                                </div>
                                    <div id="climatePledgeFriendlyATF_feature_div" class="celwidget" data-feature-name="climatePledgeFriendlyATF"
                 data-csa-c-type="widget" data-csa-c-content-id="climatePledgeFriendlyATF"
                 data-csa-c-slot-id="climatePledgeFriendlyATF_feature_div" data-csa-c-asin="B066751678"
                 data-csa-c-is-in-initial-active-row="false">
                                                             </div>
                                    <div id="zeitgeistBadge_feature_div" class="celwidget" data-feature-name="zeitgeistBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="zeitgeistBadge"
                 data-csa-c-slot-id="zeitgeistBadge_feature_div" data-csa-c-asin="B048379987"
                 data-csa-c-is-in-initial-active-row="false">
                                                             </div>
                                    <div id="socialProofingBadge_feature_div" class="celwidget" data-feature-name="socialProofingBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="socialProofingBadge"
                 data-csa-c-slot-id="socialProofingBadge_feature_div" data-csa-c-asin="B069668508"
                 data-csa-c-is-in-initial-active-row="false">
                                                                             </div>
                                    <div id="productNostosBadge_feature_div" class="celwidget" data-feature-name="productNostosBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="productNostosBadge"
                 data-csa-c-slot-id="productNostosBadge_feature_div" data-csa-c-asin="B052455736"
                 data-csa-c-is-in-initial-active-row="false">
                                                                        </div>
                                    <div id="socialProofingAsinFaceout_feature_div" class="celwidget" data-feature-name="socialProofingAsinFaceout"
                 data-csa-c-type="widget" data-csa-c-content-id="socialProofingAsinFaceout"
                 data-csa-c-slot-id="socialProofingAsinFaceout_feature_div" data-csa-c-asin="B016539374"
                 data-csa-c-is-in-initial-active-row="false">
                                                                  </div>
                                      <hr/>                                                            <div id="desktop_unifiedPrice" class="celwidget" data-feature-name="desktop_unifiedPrice"
                 data-csa-c-type="widget" data-csa-c-content-id="desktop_unifiedPrice"
                 data-csa-c-slot-id="desktop_unifiedPrice" data-csa-c-asin="B014834631"
                 data-csa-c-is-in-initial-active-row="false">
                                                           <div id="unifiedPrice_feature_div" class="celwidget" data-feature-name="unifiedPrice"
                 data-csa-c-type="widget" data-csa-c-content-id="unifiedPrice"
                 data-csa-c-slot-id="unifiedPrice_feature_div" data-csa-c-asin="B054674091"
                 data-csa-c-is-in-initial-active-row="false">
                                                              </div>
                             </div>
                                    <div id="buyingOptionNostosBolderBadge_feature_div" class="celwidget" data-feature-name="buyingOptionNostosBolderBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="buyingOptionNostosBolderBadge"
                 data-csa-c-slot-id="buyingOptionNostosBolderBadge_feature_div" data-csa-c-asin="B015970112"
                 data-csa-c-is-in-initial-active-row="false">
                                                             </div>
                                    <div id="apex_desktop" class="celwidget" data-feature-name="apex_desktop"
                 data-csa-c-type="widget" data-csa-c-content-id="apex_desktop"
                 data-csa-c-slot-id="apex_desktop" data-csa-c-asin="B017725953"
                 data-csa-c-is-in-initial-active-row="false">
                            <div data-csa-c-type="widget" data-csa-c-slot-id="apex_dp_center_column" data-csa-c-content-id="apex">
                                                                                                                                                                                                       <div data-csa-c-type="widget" data-csa-c-slot-id="apex_dp_center_column" data-csa-c-content-id="apex_with_rio_cx">
                                   <div id="dealBadge_feature_div" class="celwidget" data-feature-name="dealBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="dealBadge"
                 data-csa-c-slot-id="dealBadge_feature_div" data-csa-c-asin="B092200673"
                 data-csa-c-is-in-initial-active-row="false">
                                                                </div>
                                  <div id="delightPricingBadge_feature_div" class="celwidget" data-feature-name="delightPricingBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="delightPricingBadge"
                 data-csa-c-slot-id="delightPricingBadge_feature_div" data-csa-c-asin="B059899051"
                 data-csa-c-is-in-initial-active-row="false">
                            <style>
.delight-pricing-badge {
    background-color: #B12704 !important;
    margin: auto;
    font-family: "Amazon Ember", Arial, sans-serif;
    padding-left: 10px;
    padding-right: 10px;
    font-size: 12px !important;
    line-height: 24px !important;
    max-width: 140px;
}

.delight-pricing-badge-label {
    position: relative;
    z-index: 1;
    float: left;
}

.delight-pricing-badge-label-text {
    color: #ffffff !important;
}

.delight-pricing-container span {
    display: inline-block;
    vertical-align: middle;
}

.delight-pricing-container {
    padding-bottom: 5px;
}

.delight-pricing-badge-description-text {
    padding-left: 10px;
    margin: auto;
    font-family: "Amazon Ember", Arial, sans-serif;
    color: #111;
}

.reinventDelightPricing {
    color:#CC0C39 !important;
}

.delightPricingBadge {
    background-color: #CC0C39!important;
    padding:4px 8px 4px 8px;
    border-radius: 4px;
    display: inline-block;
    vertical-align: middle;
    margin-bottom: 4px;
}

</style>

<!-- considering updating DetailPageDelightPricingTests package whenever you change the template view -->
                               </div>
                                  <div id="corePriceDisplay_desktop_feature_div" class="celwidget" data-feature-name="corePriceDisplay_desktop"
                 data-csa-c-type="widget" data-csa-c-content-id="corePriceDisplay_desktop"
                 data-csa-c-slot-id="corePriceDisplay_desktop_feature_div" data-csa-c-asin="B061964359"
                 data-csa-c-is-in-initial-active-row="false">
                                                      <style type="text/css">
    .savingPriceOverride {
        color:#CC0C39!important;
        font-weight: 300!important;
    }
    .savingPriceOverrideEdlpT1 {
        color:#565959!important;
        font-weight: 700!important;
    }
    .savingPriceOverrideEdlpT2 {
        color:#565959!important;
        font-weight: 300!important;
    }
    .savingPriceOverrideEdlpT3 {
        color:#CC0C39!important;
        font-weight: 700!important;
    }
</style>

                                                                                 <div class="a-section a-spacing-none aok-align-center aok-relative"> <span class="aok-offscreen">   $985.88  </span>                   <span class="a-price aok-align-center reinventPricePriceToPayMargin priceToPay" data-a-size="xl" data-a-color="base"><span class="a-offscreen"> </span><span aria-hidden="true"><span class="a-price-symbol">$</span><span class="a-price-whole">719<span class="a-price-decimal">.</span></span><span class="a-price-fraction">98</span></span></span>              <span id="taxInclusiveMessage" class="a-size-mini a-color-base aok-align-center aok-nowrap">  </span>                </div>   <div class="a-section a-spacing-small aok-align-center">    <span>    <span class="a-size-small aok-align-center basisPriceLegalMessage">                        </span>   </span> </div>                                         </div>
                                  <div id="taxInclusiveMessage_feature_div" class="celwidget" data-feature-name="taxInclusiveMessage"
                 data-csa-c-type="widget" data-csa-c-content-id="taxInclusiveMessage"
                 data-csa-c-slot-id="taxInclusiveMessage_feature_div" data-csa-c-asin="B066660503"
                 data-csa-c-is-in-initial-active-row="false">
                                                       </div>
                                  <div id="delightPricingBadge_feature_div" class="celwidget" data-feature-name="delightPricingBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="delightPricingBadge"
                 data-csa-c-slot-id="delightPricingBadge_feature_div" data-csa-c-asin="B023615485"
                 data-csa-c-is-in-initial-active-row="false">
                         <!-- leaving comment so that file does not delete and we are not blocked until themis feature deletion. Will remove this once themis feature is cleaned. -->                              </div>
                                  <div id="omnibusPrice_feature_div" class="celwidget" data-feature-name="omnibusPrice"
                 data-csa-c-type="widget" data-csa-c-content-id="omnibusPrice"
                 data-csa-c-slot-id="omnibusPrice_feature_div" data-csa-c-asin="B059076248"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                  <div id="jewelryPriceBreakup_feature_div" class="celwidget" data-feature-name="jewelryPriceBreakup"
                 data-csa-c-type="widget" data-csa-c-content-id="jewelryPriceBreakup"
                 data-csa-c-slot-id="jewelryPriceBreakup_feature_div" data-csa-c-asin="B012562735"
                 data-csa-c-is-in-initial-active-row="false">
                                                                    </div>
                                  <div id="agsIfdInsidePrice_feature_div" class="celwidget" data-feature-name="agsIfdInsidePrice"
                 data-csa-c-type="widget" data-csa-c-content-id="agsIfdInsidePrice"
                 data-csa-c-slot-id="agsIfdInsidePrice_feature_div" data-csa-c-asin="B015410099"
                 data-csa-c-is-in-initial-active-row="false">
                                    <!-- For LightningDeal use case, agsShippingAndIfdInsideBuyBox is only configured on regular offer, so set defaultPageContext as buyingPrice -->
                                </div>
                                  <div id="regulatoryDeposit_feature_div" class="celwidget" data-feature-name="regulatoryDeposit"
                 data-csa-c-type="widget" data-csa-c-content-id="regulatoryDeposit"
                 data-csa-c-slot-id="regulatoryDeposit_feature_div" data-csa-c-asin="B002384119"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                  <div id="deliveryPriceBadging_feature_div" class="celwidget" data-feature-name="deliveryPriceBadging"
                 data-csa-c-type="widget" data-csa-c-content-id="deliveryPriceBadging"
                 data-csa-c-slot-id="deliveryPriceBadging_feature_div" data-csa-c-asin="B081374476"
                 data-csa-c-is-in-initial-active-row="false">
                                            <input type="hidden" id="deliveryBlockSelectAsin" value="B058268004"/>
  <input type="hidden" id="deliveryBlockSelectMerchant" value="A280NRE8KX931R"/>
  <script type="text/javascript">
  P.when("A", "jQuery").execute(function(A, $) {
    $("#selectQuantity [name='quantity'], #mobileQuantityDropDown").live("change", function (event) {
      if (event.updatePromiseBadgeOnQuantityChange) {
          return;
      }

      event.updatePromiseBadgeOnQuantityChange = 1;

      // "#buybox" is included in this list because if there is no accordion row, then it is a single-offer layout
      // possible id's may include "usedAccordionRow", "newAccordionRow_1", "newAccordionRow_2"
      var accordionRow = $(this).closest('[id$="AccordionRow"], #buybox, [id^="newAccordionRow"]');

      var quantity = $(this).val();
      // This asin and merchantId will support use case in US marketplace.
      // DDM will be required here to support the feature in IN marketplace
      var asin = accordionRow.find("#deliveryBlockSelectAsin").val();
      var merchantId = accordionRow.find("#deliveryBlockSelectMerchant").val();

      if (!asin) {
        asin = accordionRow.find("#ftSelectAsin").val();
      }
      if (!merchantId) {
        merchantId = accordionRow.find("#ftSelectMerchant").val();
      }

      if (!asin || !quantity) {
        return;
      }

      var params = [];
      params.push("asin=" + asin);
      params.push("quantity=" + quantity);
      params.push("exclusiveMerchantId=" + merchantId);
      params.push("merchantId=" + merchantId);
      params.push("clientId=retailwebsite");
      params.push("deviceType=web");
      params.push("showFeatures=priceBlockMs3Mir");
      params.push("ie=UTF8");
      params.push("experienceId=priceBadgingQuantityRefreshAjaxExperience");

      // Weblab gated addition of Locale to QuantityRefresh request
      var addLocaleToQuantityRefreshWeblabFlag = false;
      if (addLocaleToQuantityRefreshWeblabFlag) {
        var locale = accordionRow.find("#deliveryBlockSelectLocale").val();

        // Only add language param if locale is non-null
        if (locale) {
            params.push("language=" + locale);
        }
      }

      $.ajax({
        type: "GET",
        url: "/gp/product/ajax?",
        contentType: 'application/x-www-form-urlencoded;charset=utf-8',
        data: params.join('&'),
        accordionRow: accordionRow,
        dataType: "html",
        success: function (objResponse) {
          if (objResponse != null && objResponse != "") {
            accordionRow.find("#priceBadging_feature_div").replaceWith(objResponse);

            // If it's a single buying option layout or the new buy box quantity changed, update data outside the buy box
            if ($("#buyBoxAccordion, #buybox").children().length === 1 || accordionRow.attr("id").match(/^newAccordionRow/)) {
              $("#price #priceblock_ourprice_row #ourprice_shippingmessage #priceBadging_feature_div").replaceWith(objResponse);
              $("#newOfferShippingMessage_feature_div #ourPrice_availability #priceBadging_feature_div").replaceWith(objResponse);
              $("#price #priceblock_saleprice_row #saleprice_shippingmessage #priceBadging_feature_div").replaceWith(objResponse);
              $("#price #priceblock_dealprice_row #dealprice_shippingmessage #priceBadging_feature_div").replaceWith(objResponse);
            }
          }
        }
      });

      return;
    });
  });
</script>                                   </div>
                                  <div id="freeShippingPriceBadging_feature_div" class="celwidget" data-feature-name="freeShippingPriceBadging"
                 data-csa-c-type="widget" data-csa-c-content-id="freeShippingPriceBadging"
                 data-csa-c-slot-id="freeShippingPriceBadging_feature_div" data-csa-c-asin="B082203359"
                 data-csa-c-is-in-initial-active-row="false">
                                                              </div>
                                  <div id="freeReturns_feature_div" class="celwidget" data-feature-name="freeReturns"
                 data-csa-c-type="widget" data-csa-c-content-id="freeReturns"
                 data-csa-c-slot-id="freeReturns_feature_div" data-csa-c-asin="B044643721"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                  <div id="almTaxExclusivePrice_feature_div" class="celwidget" data-feature-name="almTaxExclusivePrice"
                 data-csa-c-type="widget" data-csa-c-content-id="almTaxExclusivePrice"
                 data-csa-c-slot-id="almTaxExclusivePrice_feature_div" data-csa-c-asin="B037289597"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                  <div id="oneTimePaymentPrice_feature_div" class="celwidget" data-feature-name="oneTimePaymentPrice"
                 data-csa-c-type="widget" data-csa-c-content-id="oneTimePaymentPrice"
                 data-csa-c-slot-id="oneTimePaymentPrice_feature_div" data-csa-c-asin="B021341382"
                 data-csa-c-is-in-initial-active-row="false">
                                                              </div>
                                  <div id="installmentPaymentPrice_feature_div" class="celwidget" data-feature-name="installmentPaymentPrice"
                 data-csa-c-type="widget" data-csa-c-content-id="installmentPaymentPrice"
                 data-csa-c-slot-id="installmentPaymentPrice_feature_div" data-csa-c-asin="B086145225"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                  <div id="amazonDevicesCustomPriceMessaging_feature_div" class="celwidget" data-feature-name="amazonDevicesCustomPriceMessaging"
                 data-csa-c-type="widget" data-csa-c-content-id="amazonDevicesCustomPriceMessaging"
                 data-csa-c-slot-id="amazonDevicesCustomPriceMessaging_feature_div" data-csa-c-asin="B071722326"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                  <div id="bundleLTBSSavings_feature_div" class="celwidget" data-feature-name="bundleLTBSSavings"
                 data-csa-c-type="widget" data-csa-c-content-id="bundleLTBSSavings"
                 data-csa-c-slot-id="bundleLTBSSavings_feature_div" data-csa-c-asin="B071026829"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                  <div id="volumeAwarePricingTableLoader_feature_div" class="celwidget" data-feature-name="volumeAwarePricingTableLoader"
                 data-csa-c-type="widget" data-csa-c-content-id="volumeAwarePricingTableLoader"
                 data-csa-c-slot-id="volumeAwarePricingTableLoader_feature_div" data-csa-c-asin="B022508560"
                 data-csa-c-is-in-initial-active-row="false">
                                                                 </div>
                                  <div id="promoMessagingDiscountValue_feature_div" class="celwidget" data-feature-name="promoMessagingDiscountValue"
                 data-csa-c-type="widget" data-csa-c-content-id="promoMessagingDiscountValue"
                 data-csa-c-slot-id="promoMessagingDiscountValue_feature_div" data-csa-c-asin="B073538863"
                 data-csa-c-is-in-initial-active-row="false">
                                                                    </div>
                                  <div id="vatMessage_feature_div" class="celwidget" data-feature-name="vatMessage"
                 data-csa-c-type="widget" data-csa-c-content-id="vatMessage"
                 data-csa-c-slot-id="vatMessage_feature_div" data-csa-c-asin="B060428639"
                 data-csa-c-is-in-initial-active-row="false">
                                                                </div>
                                  <div id="points_feature_div" class="celwidget" data-feature-name="points"
                 data-csa-c-type="widget" data-csa-c-content-id="points"
                 data-csa-c-slot-id="points_feature_div" data-csa-c-asin="B078743115"
                 data-csa-c-is-in-initial-active-row="false">
                                                                  </div>
                                  <div id="pep_feature_div" class="celwidget" data-feature-name="pep"
                 data-csa-c-type="widget" data-csa-c-content-id="pep"
                 data-csa-c-slot-id="pep_feature_div" data-csa-c-asin="B035063518"
                 data-csa-c-is-in-initial-active-row="false">
                                                               </div>
                                  <div id="vos_feature_div" class="celwidget" data-feature-name="vos"
                 data-csa-c-type="widget" data-csa-c-content-id="vos"
                 data-csa-c-slot-id="vos_feature_div" data-csa-c-asin="B093216749"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                  <div id="almPrimeSavings_feature_div" class="celwidget" data-feature-name="almPrimeSavings"
                 data-csa-c-type="widget" data-csa-c-content-id="almPrimeSavings"
                 data-csa-c-slot-id="almPrimeSavings_feature_div" data-csa-c-asin="B022182805"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                  <div id="reinvent_price_tabular_desktop" class="celwidget" data-feature-name="reinvent_price_tabular_desktop"
                 data-csa-c-type="widget" data-csa-c-content-id="reinvent_price_tabular_desktop"
                 data-csa-c-slot-id="reinvent_price_tabular_desktop" data-csa-c-asin="B056415301"
                 data-csa-c-is-in-initial-active-row="false">
                             <table class="a-normal a-spacing-none reInventPriceTable">    </table> <style>
    .reInventPriceTable{
        width: auto;
    }
</style>                         </div>
                                  <div id="rebates_feature_div" class="celwidget" data-feature-name="rebates"
                 data-csa-c-type="widget" data-csa-c-content-id="rebates"
                 data-csa-c-slot-id="rebates_feature_div" data-csa-c-asin="B042147725"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                  <div id="volumeAwarePricingPriceBlockMessaging_feature_div" class="celwidget" data-feature-name="volumeAwarePricingPriceBlockMessaging"
                 data-csa-c-type="widget" data-csa-c-content-id="volumeAwarePricingPriceBlockMessaging"
                 data-csa-c-slot-id="volumeAwarePricingPriceBlockMessaging_feature_div" data-csa-c-asin="B014403498"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                  <div id="agsBadgeInsidePrice_feature_div" class="celwidget" data-feature-name="agsBadgeInsidePrice"
                 data-csa-c-type="widget" data-csa-c-content-id="agsBadgeInsidePrice"
                 data-csa-c-slot-id="agsBadgeInsidePrice_feature_div" data-csa-c-asin="B083186227"
                 data-csa-c-is-in-initial-active-row="false">
                                                         </div>
                                  <div id="superSaverBadge_feature_div" class="celwidget" data-feature-name="superSaverBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="superSaverBadge"
                 data-csa-c-slot-id="superSaverBadge_feature_div" data-csa-c-asin="B057886343"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                  <div id="tradeInPriceBlock_feature_div" class="celwidget" data-feature-name="tradeInPriceBlock"
                 data-csa-c-type="widget" data-csa-c-content-id="tradeInPriceBlock"
                 data-csa-c-slot-id="tradeInPriceBlock_feature_div" data-csa-c-asin="B087679377"
                 data-csa-c-is-in-initial-active-row="false">
                                                                     </div>
                                  <div id="quantityPricingTableSummaryInPriceBlock_feature_div" class="celwidget" data-feature-name="quantityPricingTableSummaryInPriceBlock"
                 data-csa-c-type="widget" data-csa-c-content-id="quantityPricingTableSummaryInPriceBlock"
                 data-csa-c-slot-id="quantityPricingTableSummaryInPriceBlock_feature_div" data-csa-c-asin="B038579257"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                  <div id="exportsTaxMessage_feature_div" class="celwidget" data-feature-name="exportsTaxMessage"
                 data-csa-c-type="widget" data-csa-c-content-id="exportsTaxMessage"
                 data-csa-c-slot-id="exportsTaxMessage_feature_div" data-csa-c-asin="B037395250"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                  <div id="amazonGlobal_feature_div" class="celwidget" data-feature-name="amazonGlobal"
                 data-csa-c-type="widget" data-csa-c-content-id="amazonGlobal"
                 data-csa-c-slot-id="amazonGlobal_feature_div" data-csa-c-asin="B046052520"
                 data-csa-c-is-in-initial-active-row="false">
                                      <script type="text/javascript">
        P.when('A').execute(function(A) {
            if (typeof window.agPopOverCallbackHandle === 'undefined') {
                A.on("a:popover:show:USED_0", function(data) {
                    A.ajax("https://fls-na.amazon.com/1/action-impressions/1/OE/amazon-global/action/amazon_global_shipmsg_:activated_popover?marketplaceId=ATVPDKIKX0DER&requestId=RBW56TXBT3VK1W4DNTET&session=140-0199542-9827343", { method: "get" });
                });
                window.agPopOverCallbackHandle = true;
            }
        });
    </script>
   <script type="text/javascript">
        P.when('A').execute(function(A) {
            recordHelpAndNavigate = function(navigateFn) {
                navigateFn();
                A.ajax("https://fls-na.amazon.com/1/action-impressions/1/OE/amazon-global/action/amazon_global_shipmsg_:viewed_help?marketplaceId=ATVPDKIKX0DER&requestId=RBW56TXBT3VK1W4DNTET&session=140-0199542-9827343", { method: "get" });
            };
        });
    </script>
     <span class="a-size-base a-color-secondary"> $123.86 Shipping & Import Charges to Thailand </span>   <span class="a-declarative" data-action="a-popover" data-a-popover="{&quot;closeButton&quot;:&quot;true&quot;,&quot;name&quot;:&quot;USED_0&quot;,&quot;activate&quot;:&quot;onclick&quot;,&quot;width&quot;:&quot;350&quot;,&quot;position&quot;:&quot;triggerBottom&quot;}"> <a href="javascript:void(0)" role="button" class="a-popover-trigger a-declarative"> <span class="a-size-base"> Details </span> <i class="a-icon a-icon-popover"></i></a> </span>  <div class="a-popover-preload" id="a-popover-USED_0"> <h3>Shipping & Fee Details</h3>

             <hr aria-hidden="true" class="a-spacing-top-small a-divider-normal"/> <table class="a-lineitem">    <tr> <td class="a-span9 a-text-left"> <span class="a-size-base a-color-secondary"> Price </span> </td> <td class="a-span1 a-text-right"> </td> <td class="a-span2 a-text-right"> <span class="a-size-base a-color-base"> $132.22 </span> </td> </tr>     <tr> <td class="a-span9 a-text-left"> <span class="a-size-base a-color-secondary"> AmazonGlobal Shipping </span> </td>    <td class="a-span1 a-text-right"> </td>   <td class="a-span2 a-text-right"> <span class="a-size-base a-color-base"> $25.89 </span> </td> </tr>    <tr> <td class="a-span9 a-text-left"> <span class="a-size-base a-color-secondary"> <a href="/gp/help/customer/display.html?ie=UTF8&pop-up=1&nodeId=201117970&ref=amazon_global_shipmsg_viewed_help" target="AmazonHelp" onclick="return recordHelpAndNavigate(function() {amz_js_PopWin(this.href,'AmazonHelp','width=550,height=550,resizable=1,scrollbars=1,toolbar=0,status=0');})">
                                        Estimated Import Charges</a>
                            </span> </td>    <td class="a-span1 a-text-right"> </td>   <td class="a-span2 a-text-right"> <span class="a-size-base a-color-base"> $97.97 </span> </td> </tr>  <tr> <td colspan="3"> <hr aria-hidden="true" class="a-spacing-top-small a-divider-normal"/> </td> </tr>  <tr> <td class="a-span9 a-text-left"> <span class="a-size-base a-color-secondary">Total</span> </td> <td class="a-span1 a-text-right"></td> <td class="a-span2 a-text-right">   <span class="a-size-base a-color-base"> $515.84 </span>    </td> </tr> </table> </div>  </br>
                                            </div>
                                  <div id="promoPriceBlockMessage_feature_div" class="celwidget" data-feature-name="promoPriceBlockMessage"
                 data-csa-c-type="widget" data-csa-c-content-id="promoPriceBlockMessage"
                 data-csa-c-slot-id="promoPriceBlockMessage_feature_div" data-csa-c-asin="B052478326"
                 data-csa-c-is-in-initial-active-row="false">
                                    <div>
                                                                                                                                                                                 </div>
                                  </div>
       </div>
                                             </div>                         </div>
                                    <div id="pmpux_feature_div" class="celwidget" data-feature-name="pmpux"
                 data-csa-c-type="widget" data-csa-c-content-id="pmpux"
                 data-csa-c-slot-id="pmpux_feature_div" data-csa-c-asin="B029379120"
                 data-csa-c-is-in-initial-active-row="false">
                                                                      </div>
                                    <div id="applicablePromotionList_feature_div" class="celwidget" data-feature-name="applicablePromotionList"
                 data-csa-c-type="widget" data-csa-c-content-id="applicablePromotionList"
                 data-csa-c-slot-id="applicablePromotionList_feature_div" data-csa-c-asin="B007208262"
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                    <div id="b2bUpsellNew_feature_div" class="celwidget" data-feature-name="b2bUpsellNew"
                 data-csa-c-type="widget" data-csa-c-content-id="b2bUpsellNew"
                 data-csa-c-slot-id="b2bUpsellNew_feature_div" data-csa-c-asin="B014310217"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="issuancePriceblockAmabot_feature_div" class="celwidget" data-feature-name="issuancePriceblockAmabot"
                 data-csa-c-type="widget" data-csa-c-content-id="issuancePriceblockAmabot"
                 data-csa-c-slot-id="issuancePriceblockAmabot_feature_div" data-csa-c-asin="B048919982"
                 data-csa-c-is-in-initial-active-row="false">
                                                                                                                                                                                                    <script type="text/javascript">

    P.when('A', 'ready').execute(function (A) {
        var $ = A.$;

        function createNexusEvent(impressionSchema) {
            let attributesMap = {
                buyingOption : impressionSchema.buyingOptionName,
                buyingOptionIndex : String(impressionSchema.buyingOptionIndex),
                robot : "false",
                issuancePlacementShortNm : impressionSchema.issuancePlacementShortNm
            }
            // Event payload for Nexus should contain all the attributes present in schema 'odysseus.Impression'
            let event = {
                sessionId : impressionSchema.sessionId,
                impressionId : impressionSchema.impressionId,
                requestId : impressionSchema.requestId,
                marketplaceId : impressionSchema.marketplaceId,
                attributes : attributesMap,
                lob: window.ue_lob
            };

            return event;
        }

        function publishNexusEvent(asin, index, issuanceOcfSelectorId, requestId){
            let impressionSchema = A.state("impressionSchema_" + requestId + "-" + asin + ":" + index);
            if(impressionSchema) {
                let event = createNexusEvent(impressionSchema);
                ue.event(event, impressionSchema.nexusProducerId, impressionSchema.nexusSchemaId);
                $(issuanceOcfSelectorId).attr('visited', "true");
            }
        }

        // Publish impression metrics to Nexus upon toggling non-landing buying options
        A.on('a:accordion:buybox-accordion:select', function (data){
            let buyingOptionIndex = A.$(data.selectedRow.$row).index();
            let issuanceOcfSelector = '.issuance_ocf_selector#issuanceOcfAccordianRowName_' + buyingOptionIndex;
            if(issuanceOcfSelector) {
                let isVisited = $(issuanceOcfSelector).attr("visited");
                if (isVisited === 'false' && window.ue) {
                    let asin = $(issuanceOcfSelector).attr("asin");
                    let requestId = $(issuanceOcfSelector).attr("requestId");
                    publishNexusEvent(asin, buyingOptionIndex, issuanceOcfSelector, requestId)
                }
            }
        });

        // Publish impression metrics to Nexus upon switching tab
        A.on('a:tabs:offerDisplayGroup_tabs:select', function (data){
            let visitedAccordionRow = $("#issuancePriceblockAmabot_feature_div > .offersConsistencyEnabled").children().filter(function () {
                return $(this).css('display') === 'block';
            });
            let issuanceOcfSelector = $(visitedAccordionRow).find(".issuance_ocf_selector");
            if(issuanceOcfSelector) {
                let isVisited = $(issuanceOcfSelector).attr("visited");
                if (isVisited === 'false' && window.ue) {
                    let asin = $(issuanceOcfSelector).attr("asin");
                    let requestId = $(issuanceOcfSelector).attr("requestId");
                    let buyingOptionIndex = $(issuanceOcfSelector).attr('id').split('_')[1];
                    publishNexusEvent(asin, buyingOptionIndex, issuanceOcfSelector, requestId)
                }
            }
        });
    });
</script>                                 </div>
                                    <div id="dtgSubscription_feature_div" class="celwidget" data-feature-name="dtgSubscription"
                 data-csa-c-type="widget" data-csa-c-content-id="dtgSubscription"
                 data-csa-c-slot-id="dtgSubscription_feature_div" data-csa-c-asin="B024522008"
                 data-csa-c-is-in-initial-active-row="false">
                                              </div>
                                                                    <div id="iconfarmv2_feature_div" class="celwidget" data-feature-name="iconfarmv2USCopy"
                 data-csa-c-type="widget" data-csa-c-content-id="iconfarmv2USCopy"
                 data-csa-c-slot-id="iconfarmv2_feature_div" data-csa-c-asin="B022143564"
                 data-csa-c-is-in-initial-active-row="false">
                                                        </div>
                                    <div id="pbx_feature_div" class="celwidget" data-feature-name="pbx"
                 data-csa-c-type="widget" data-csa-c-content-id="pbx"
                 data-csa-c-slot-id="pbx_feature_div" data-csa-c-asin="B069478555"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="pbxFreebies_feature_div" class="celwidget" data-feature-name="pbxFreebies"
                 data-csa-c-type="widget" data-csa-c-content-id="pbxFreebies"
                 data-csa-c-slot-id="pbxFreebies_feature_div" data-csa-c-asin="B003542443"
                 data-csa-c-is-in-initial-active-row="false">
                                                       </div>
                                    <div id="alternativeOfferEligibilityMessaging_feature_div" class="celwidget" data-feature-name="alternativeOfferEligibilityMessaging"
                 data-csa-c-type="widget" data-csa-c-content-id="alternativeOfferEligibilityMessaging"
                 data-csa-c-slot-id="alternativeOfferEligibilityMessaging_feature_div" data-csa-c-asin="B097325383"
                 data-csa-c-is-in-initial-active-row="false">
                                                                  <div class="a-section">    </div>                                </div>
                                    <div id="availability_feature_div" class="celwidget" data-feature-name="availability"
                 data-csa-c-type="widget" data-csa-c-content-id="availability"
                 data-csa-c-slot-id="availability_feature_div" data-csa-c-asin="B036015664"
                 data-csa-c-is-in-initial-active-row="false">
                                                              <div id="availability" class="a-section a-spacing-base a-spacing-top-micro }">                         <span class="a-size-base a-color-price a-text-bold"> Only 1 left in stock - order soon. </span>                 <br/>       </div>         <div class="a-section a-spacing-none">  </div>                <div class="a-section a-spacing-mini">    </div>   <style>
    .availabilityMoreDetailsIcon {
        width: 12px;
        vertical-align: baseline;
        fill: #969696;
    }
</style>                              </div>
                                                    <div id="globalStoreBadgePopover_feature_div" class="celwidget" data-feature-name="globalStoreBadgePopover"
                 data-csa-c-type="widget" data-csa-c-content-id="globalStoreBadgePopover"
                 data-csa-c-slot-id="globalStoreBadgePopover_feature_div" data-csa-c-asin="B071751001"
                 data-csa-c-is-in-initial-active-row="false">
                                                                 </div>
                                    <div id="dpFastTrack_feature_div" class="celwidget" data-feature-name="dpFastTrack"
                 data-csa-c-type="widget" data-csa-c-content-id="dpFastTrack"
                 data-csa-c-slot-id="dpFastTrack_feature_div" data-csa-c-asin="B074709980"
                 data-csa-c-is-in-initial-active-row="false">
                                                   <div id="fast-track" class="a-section">   <input type="hidden" id="ftSelectAsin" value="B093268189"/>
          <input type="hidden" id="ftSelectMerchant" value="A280NRE8KX931R"/>
                    <div id="fast-track-message" class="a-section a-spacing-base">  <div class="a-section a-spacing-none">           </div>        <script type="text/javascript">
function fastTrackCountDown(secondsLeft, messageSectionId) {
    var sectionId = messageSectionId;
    var FT_showAndInCountdown = false;
    var FT_DayString = "day";
    var FT_DaysString = "days";
    var FT_HourString = "hr";
    var FT_HoursString = "hrs";
    var FT_MinuteString = "min";
    var FT_MinutesString = "mins";
    var FT_AndString = "and";
    var FT_startedWithHour = new Date().getHours();
    var FT_givenSeconds, FT_actualSeconds;
    var timerId;

    function getElementsByClassNameCustom(className) {
        var selectedElements = [];

        if (document.querySelectorAll) {
            var sectionIdElements = document.querySelectorAll("#" + sectionId);
            for (index = 0; index < sectionIdElements.length; ++index) {
                var elements = sectionIdElements[index].querySelectorAll("." + className);
                for(var i = 0; elements && i < elements.length; i++) {
                    selectedElements.push(elements[i]);
                }
            }
        }

        return selectedElements;
    }
    
    var FT_CurrentDisplayMin;
    var clientServerTimeDrift;
    var firstTimeUpdate = true;
    
    var countdownElements = getElementsByClassNameCustom("ftCountdownClass");
    if (countdownElements.length < 1 && document.getElementById(sectionId) && document.getElementById("ftCountdown")) {
        countdownElements.push(document.getElementById("ftCountdown"));
    }
    
    function getTimeRemainingString( days, hours, minutes )
    {

        hours = (days * 24) + hours;
        var hourString   =  ( hours == 1 ? FT_HourString : FT_HoursString );
        var minuteString =  ( minutes  == 1 ? FT_MinuteString : FT_MinutesString );
        if (hours == 0) {
            return minutes + " " + minuteString;
        }
        if (minutes == 0) {
          return hours + " " + hourString;
        }
        if (FT_showAndInCountdown) {
          return hours + " " + hourString + " " + FT_AndString + " " + minutes + " " + minuteString;
        } else {
          return hours + " " + hourString + " " + minutes + " " + minuteString;
        }

    }        
    
    function hideAllFastTrackComponents() {
        if (document.querySelectorAll) {
            var fastTrackComponents = document.querySelectorAll("#fast-track");
            var index;
            var shouldHideSections = false;
            if (fastTrackComponents) {
                for (index = 0; index < fastTrackComponents.length; ++index) {
                    if (fastTrackComponents[index].querySelector("#" + sectionId)) {
                        fastTrackComponents[index].style.display = "none";
                    } else {
                        shouldHideSections = true;
                    }
                }
                if (shouldHideSections) {
                    var sectionComponents = document.querySelectorAll("#" + sectionId);
                    if (sectionComponents) {
                        for (index = 0; index < sectionComponents.length; ++index) {
                            sectionComponents[index].style.display = "none";
                        }
                    }
                }
            }
        }
    }

    function FT_displayCountdown(forceUpdate)
    {
        var FT_remainSeconds = FT_givenSeconds - FT_actualSeconds;
        //for components having outer div "fast-track" hide that component else hide the message sectionId.
        if (FT_remainSeconds < 1) {
            hideAllFastTrackComponents();
        }

      var FT_secondsPerDay = 24 * 60 * 60;
      var FT_daysLong = FT_remainSeconds / FT_secondsPerDay;
      var FT_days = Math.floor(FT_daysLong);
      var FT_hoursLong = (FT_daysLong - FT_days) * 24;
      var FT_hours = Math.floor(FT_hoursLong);
      var FT_minsLong = (FT_hoursLong - FT_hours) * 60;
      var FT_mins = Math.floor(FT_minsLong);
      var FT_secsLong = (FT_minsLong - FT_mins) * 60;
      var FT_secs = Math.floor(FT_secsLong);
          timerId = setTimeout(FT_getTime, 1000);
      var ftCountdown = getTimeRemainingString( FT_days, FT_hours, FT_mins );
      if (countdownElements.length) {
        if (FT_CurrentDisplayMin != FT_mins || forceUpdate || firstTimeUpdate) {
          var i = 0, countdownElement;
          while (countdownElement = countdownElements[i++]) {
            countdownElement.innerHTML = ftCountdown;
          }
          FT_CurrentDisplayMin = FT_mins;
          firstTimeUpdate = false;
        }
      }
    }
    
    function FT_getCountdown(secondsLeft)
    {
      var FT_currentTime = new Date();
      var FT_currentHours = FT_currentTime.getHours();
      var FT_currentMins = FT_currentTime.getMinutes();
      var FT_currentSecs = FT_currentTime.getSeconds();
      FT_givenSeconds = FT_currentHours * 3600 + FT_currentMins * 60 + FT_currentSecs;
      FT_givenSeconds += secondsLeft;
      FT_getTime();
    }
    function FT_getTime()
    {
      var FT_newCurrentTime = new Date();
      var FT_actualHours = FT_newCurrentTime.getHours();
      if (FT_startedWithHour > FT_actualHours) {
        FT_actualHours += 24;
      }
      var FT_actualMins = FT_newCurrentTime.getMinutes();
      var FT_actualSecs = FT_newCurrentTime.getSeconds();
      FT_actualSeconds = FT_actualHours * 3600 + FT_actualMins * 60 + FT_actualSecs;
      FT_displayCountdown();
    }
        FT_getCountdown(secondsLeft);
        return {
          stopTimer : function() {
            clearTimeout(timerId);
          }
        };
}
</script>
 <script type="text/javascript">
        P.when("A", "jQuery").execute(function(A, $) {
            var pageState = A.state('ftPageState');
            if (typeof pageState === 'undefined') {
                pageState = {};
            }

            A.state('ftPageState', pageState);
        });
    </script>
</div>                   </div>                                 </div>
                                    <div id="deepCheckPromise_feature_div" class="celwidget" data-feature-name="deepCheckPromise"
                 data-csa-c-type="widget" data-csa-c-content-id="deepCheckPromise"
                 data-csa-c-slot-id="deepCheckPromise_feature_div" data-csa-c-asin="B046354062"
                 data-csa-c-is-in-initial-active-row="false">
                                                                     </div>
                                    <div id="shipsFromSoldBy_feature_div" class="celwidget" data-feature-name="shipsFromSoldBy"
                 data-csa-c-type="widget" data-csa-c-content-id="shipsFromSoldBy"
                 data-csa-c-slot-id="shipsFromSoldBy_feature_div" data-csa-c-asin="B099497522"
                 data-csa-c-is-in-initial-active-row="false">
                                                                               </div>
                                    <div id="businessPricing_feature_div" class="celwidget" data-feature-name="businessPricing"
                 data-csa-c-type="widget" data-csa-c-content-id="businessPricing"
                 data-csa-c-slot-id="businessPricing_feature_div" data-csa-c-asin="B008349702"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                                    <div id="dsvHowItWorksContainer" class="celwidget" data-feature-name="dsvHowItWorksContainer"
                 data-csa-c-type="widget" data-csa-c-content-id="dsvHowItWorksContainer"
                 data-csa-c-slot-id="dsvHowItWorksContainer" data-csa-c-asin="B035467447"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="dsvTermsOfUse_feature_div" class="celwidget" data-feature-name="dsvTermsOfUse"
                 data-csa-c-type="widget" data-csa-c-content-id="dsvTermsOfUse"
                 data-csa-c-slot-id="dsvTermsOfUse_feature_div" data-csa-c-asin="B032119736"
                 data-csa-c-is-in-initial-active-row="false">
                                                              </div>
                                    <div id="dsvReturnPolicyMessage_feature_div" class="celwidget" data-feature-name="dsvReturnPolicyMessage"
                 data-csa-c-type="widget" data-csa-c-content-id="dsvReturnPolicyMessage"
                 data-csa-c-slot-id="dsvReturnPolicyMessage_feature_div" data-csa-c-asin="B066085487"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="dsvBuyingRights_feature_div" class="celwidget" data-feature-name="dsvBuyingRights"
                 data-csa-c-type="widget" data-csa-c-content-id="dsvBuyingRights"
                 data-csa-c-slot-id="dsvBuyingRights_feature_div" data-csa-c-asin="B038261694"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                                                    <div id="twister_feature_div" class="celwidget" data-feature-name="twister"
                 data-csa-c-type="widget" data-csa-c-content-id="twister"
                 data-csa-c-slot-id="twister_feature_div" data-csa-c-asin="B095900480"
                 data-csa-c-is-in-initial-active-row="false">
                                                                                 </div>
                                                    <div id="bundles_feature_div" class="celwidget" data-feature-name="bundles"
                 data-csa-c-type="widget" data-csa-c-content-id="bundles"
                 data-csa-c-slot-id="bundles_feature_div" data-csa-c-asin="B024986845"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                                    <div id="twisterPlusWWDesktop" class="celwidget" data-feature-name="twisterPlusWWDesktop"
                 data-csa-c-type="widget" data-csa-c-content-id="twisterPlusWWDesktop"
                 data-csa-c-slot-id="twisterPlusWWDesktop" data-csa-c-asin="B056550763"
                 data-csa-c-is-in-initial-active-row="false">
                                                      </div>
                                    <div id="gestaltCustomizationSummary_feature_div" class="celwidget" data-feature-name="gestaltCustomizationSummary"
                 data-csa-c-type="widget" data-csa-c-content-id="gestaltCustomizationSummary"
                 data-csa-c-slot-id="gestaltCustomizationSummary_feature_div" data-csa-c-asin="B017245625"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="renewedProgramDescriptionAtf_feature_div" class="celwidget" data-feature-name="renewedProgramDescriptionAtf"
                 data-csa-c-type="widget" data-csa-c-content-id="renewedProgramDescriptionAtf"
                 data-csa-c-slot-id="renewedProgramDescriptionAtf_feature_div" data-csa-c-asin="B010616011"
                 data-csa-c-is-in-initial-active-row="false">
                                                                       </div>
                                    <div id="featurebullets_feature_div" class="celwidget" data-feature-name="featurebullets"
                 data-csa-c-type="widget" data-csa-c-content-id="featurebullets"
                 data-csa-c-slot-id="featurebullets_feature_div" data-csa-c-asin="B032098209"
                 data-csa-c-is-in-initial-active-row="false">
                            <script type="a-state" data-a-state="{&quot;key&quot;:&quot;starfish-product-summary-context&quot;}">{"isProductSummaryAvailable":false,"device":"desktop"}</script>  <div id="feature-bullets" class="a-section a-spacing-medium a-spacing-top-small">                             <hr aria-hidden="true" class="a-divider-normal"/>     <h1 class="a-size-base-plus a-text-bold"> About this item </h1>                    <ul class="a-unordered-list a-vertical a-spacing-mini">
  <li class="a-spacing-mini">
    <span class="a-list-item">
      <?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') ?>
    </span>
  </li>
</ul>
  <!-- Loading EDP related metadata -->
                    <div data-csa-c-content-id="voyager-product-details-jumplink" data-csa-c-slot-id="voyager-product-details-jumplink" data-csa-c-type="link" class="a-section aok-hidden"> <span class="caretnext">&#155;</span> <a id="seeMoreDetailsLink" class="a-link-normal" href="#productDetails"> See more product details </a> </div>            </div>                              </div>
                                    <div id="provenanceCertifications_feature_div" class="celwidget" data-feature-name="provenanceCertifications"
                 data-csa-c-type="widget" data-csa-c-content-id="provenanceCertifications"
                 data-csa-c-slot-id="provenanceCertifications_feature_div" data-csa-c-asin="B084914573"                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                    <div id="handmadeArtisanCard_feature_div" class="celwidget" data-feature-name="handmadeArtisanCard"
                 data-csa-c-type="widget" data-csa-c-content-id="handmadeArtisanCard"
                 data-csa-c-slot-id="handmadeArtisanCard_feature_div" data-csa-c-asin="B095675680"
                 data-csa-c-is-in-initial-active-row="false">
                                                   </div>
                                    <div id="globalStoreInfoBullets_feature_div" class="celwidget" data-feature-name="globalStoreInfoBullets"
                 data-csa-c-type="widget" data-csa-c-content-id="globalStoreInfoBullets"
                 data-csa-c-slot-id="globalStoreInfoBullets_feature_div" data-csa-c-asin="B034527071"
                 data-csa-c-is-in-initial-active-row="false">
                                                                     </div>
                                    <div id="addOnItem_feature_div" class="celwidget" data-feature-name="addOnItem"
                 data-csa-c-type="widget" data-csa-c-content-id="addOnItem"
                 data-csa-c-slot-id="addOnItem_feature_div" data-csa-c-asin="B035559394"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                    <div id="giftcard-holiday-availability-messaging_feature_div" class="celwidget" data-feature-name="giftCardHolidayAvailabilityMessaging"
                 data-csa-c-type="widget" data-csa-c-content-id="giftCardHolidayAvailabilityMessaging"
                 data-csa-c-slot-id="giftcard-holiday-availability-messaging_feature_div" data-csa-c-asin="B026494223"
                 data-csa-c-is-in-initial-active-row="false">
                         <!--giftCardHolidayAvailabilityMessaging_placeholder-->                     </div>
                                    <div id="andonCord_feature_div" class="celwidget" data-feature-name="andonCord"
                 data-csa-c-type="widget" data-csa-c-content-id="andonCord"
                 data-csa-c-slot-id="andonCord_feature_div" data-csa-c-asin="B008696470"
                 data-csa-c-is-in-initial-active-row="false">
                                                       </div>
                                    <div id="olp_feature_div" class="celwidget" data-feature-name="olp"
                 data-csa-c-type="widget" data-csa-c-content-id="olp"
                 data-csa-c-slot-id="olp_feature_div" data-csa-c-asin="B022901143"
                 data-csa-c-is-in-initial-active-row="false">
                                                                <div id="all-offers-display" class="a-section"> <div id="all-offers-display-spinner" class="a-spinner-wrapper aok-hidden"><span class="a-spinner a-spinner-medium"></span></div> <form method="get" action="" autocomplete="off" class="aok-hidden all-offers-display-params"> <input type="hidden" name="" value="true" id="all-offers-display-reload-param"/>  <input type="hidden" name="" id="all-offers-display-params" data-asin="B081122199" data-m="" data-qid="1743452468" data-smid="" data-sourcecustomerorglistid="" data-sourcecustomerorglistitemid="" data-sr="8-16"/> </form> </div> <span class="a-declarative" data-action="close-all-offers-display" data-close-all-offers-display="{}"> <div id="aod-background" class="a-section aok-hidden aod-darken-background"> </div> </span>        <script type="application/javascript">
    P.when("A", "load").execute("aod-assets-loaded", function(A){
        function logAssetsNotLoaded() {
            if (window.ueLogError) {
                var customError = { message: 'Failed to load AOD assets for WDG: video_games_display_on_website, Device: web' };
                var additionalInfo = {
                    logLevel : 'ERROR',
                    attribution : 'aod_assets_not_loaded'
                };
                ueLogError (customError, additionalInfo);
            }
            if (window.ue && window.ue.count) {
                window.ue.count("aod-assets-not-loaded", 1);
            }
        }

        function verifyAssetsLoaded() {
            var assetsLoadedPageState = A.state('aod:assetsLoaded');
            var logAssetsNotLoadedState = A.state('aod:logAssetsNotLoaded');

            if((assetsLoadedPageState == null || !assetsLoadedPageState.isAodAssetsLoaded)
                && (logAssetsNotLoadedState == null || !logAssetsNotLoadedState.isAodAssetsNotLoadedLogged)) {
                A.state('aod:logAssetsNotLoaded', {isAodAssetsNotLoadedLogged: true});
                logAssetsNotLoaded();
            }
        }

        setTimeout(verifyAssetsLoaded, 50000)
    });
</script>                                                   </div>
                                    <div id="buyingOptionNostosBadge_feature_div" class="celwidget" data-feature-name="buyingOptionNostosBadge"
                 data-csa-c-type="widget" data-csa-c-content-id="buyingOptionNostosBadge"
                 data-csa-c-slot-id="buyingOptionNostosBadge_feature_div" data-csa-c-asin="B068938924"
                 data-csa-c-is-in-initial-active-row="false">
                                                                   </div>
                                    <div id="tellAmazon_feature_div" class="celwidget" data-feature-name="tellAmazon"
                 data-csa-c-type="widget" data-csa-c-content-id="tellAmazon"
                 data-csa-c-slot-id="tellAmazon_feature_div" data-csa-c-asin="B001224128"
                 data-csa-c-is-in-initial-active-row="false">
                               <div class="celwidget c-f" cel_widget_id="tell-amazon-desktop_DetailPage_0" data-csa-op-log-render="" data-csa-c-content-id="DsUnknown" data-csa-c-slot-id="DsUnknown-1" data-csa-c-type="widget" data-csa-c-painter="tell-amazon-desktop-cards"><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="tell-amazon-desktop_DetailPage_0"]', '#CardInstanceh1u3SKAekhHaQoKdQUUshg')('mark', 'bb')}</script>
<script>if(window.uet){window.uet('bb','tell-amazon-desktop_DetailPage_0',{wb: 1})}</script>
<style>._tell-amazon-desktop_style_tell_amazon_modal_spinner__3bz5K,._tell-amazon-desktop_style_tell_amazon_popover_inner__3tPIV{padding:20px 24px 0;width:65vw}._tell-amazon-desktop_style_tell_amazon_modal_spinner__3bz5K{height:15vh;margin-top:10vh;text-align:center}._tell-amazon-desktop_style_tell_amazon_no_email_alert__1t6PT{margin-bottom:60px}a[id^=tellAmazonDropdown],a[id^=tellAmazon_][id*=Dropdown]{white-space:normal!important}
._tell-amazon-desktop_style_tell_amazon_component_preload__2jBs4{display:none}._tell-amazon-desktop_style_tell_amazon_thankyou_page__1PP1x{display:none;margin-bottom:60px;padding:30px 15px}._tell-amazon-desktop_style_tell_amazon_dropdown__3USiH{margin-top:10px}._tell-amazon-desktop_style_tell_amazon_dropdown_label__2ydKL{margin-bottom:5px}._tell-amazon-desktop_style_alert_type__34m2d{display:none}._tell-amazon-desktop_style_tell_amazon_freeform_text__DOb62{margin:10px 0}._tell-amazon-desktop_style_tell_amazon_try_again_message__3L5ej{display:none;float:left}._tell-amazon-desktop_style_tell_amazon_checkbox_component__2mOqM{margin:10px 0}._tell-amazon-desktop_style_tell_amazon_checkbox_template__2Bgy6{display:none}</style>
<!--CardsClient--><div id="CardInstanceh1u3SKAekhHaQoKdQUUshg" data-card-metrics-id="tell-amazon-desktop_DetailPage_0" data-acp-params="tok=SheQeT2VWC82g6Pus30jyXUuAH6pGwnU_kh1ZprWqF8;ts=1743452478158;rid=RBW56TXBT3VK1W4DNTET;d1=343;d2=0" data-acp-path="/acp/tell-amazon-desktop/tell-amazon-desktop-c17bb685-88db-4595-b267-149ec01063e8-1742489357431/" data-acp-tracking="{}" data-acp-stamp="1743452478159" data-acp-region-info="us-east-1"><div data-asin="B003095145" data-marketplace="ATVPDKIKX0DER" data-logged-in="false" class="_tell-amazon-desktop_style_tell_amazon_div__1YDZk"><a class="a-link-normal _tell-amazon-desktop_style_tell_amazon_link__1KW5z" href="#"><i aria-hidden="true" class="a-icon a-icon-share-sms a-icon-mini" role="presentation"></i>   Report an issue with this product or seller</a></div><div class="_tell-amazon-desktop_style_tell_amazon_modal_root__1q10s aok-hidden"><div class="_tell-amazon-desktop_style_tell_amazon_modal_content__2YB_6"><div class="_tell-amazon-desktop_style_tell_amazon_modal_spinner__3bz5K"><span class="a-spinner a-spinner-medium"></span></div></div></div></div><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="tell-amazon-desktop_DetailPage_0"]', '#CardInstanceh1u3SKAekhHaQoKdQUUshg')('mark', 'be')}</script>
<script>if(window.uet){window.uet('be','tell-amazon-desktop_DetailPage_0',{wb: 1})}</script>
<script>if(window.mixTimeout){window.mixTimeout('tell-amazon-desktop', 'CardInstanceh1u3SKAekhHaQoKdQUUshg', 90000)};
P.when('mix:@amzn/mix.client-runtime', 'mix:tell-amazon-desktop__gO8JxAv6').execute(function (runtime, cardModule) {runtime.registerCardFactory('CardInstanceh1u3SKAekhHaQoKdQUUshg', cardModule).then(function(){if(window.mix_csa){window.mix_csa('[cel_widget_id="tell-amazon-desktop_DetailPage_0"]', '#CardInstanceh1u3SKAekhHaQoKdQUUshg')('mark', 'functional')}if(window.uex){window.uex('ld','tell-amazon-desktop_DetailPage_0',{wb: 1})}});});
</script>
<script>P.load.js('https://images-na.ssl-images-amazon.com/images/I/514KtT8JPqL.js?xcp');
</script>
</div>                      </div>
                                    <div id="compatibilityContainerDesktop" class="celwidget" data-feature-name="compatibilityContainerDesktop"
                 data-csa-c-type="widget" data-csa-c-content-id="compatibilityContainerDesktop"
                 data-csa-c-slot-id="compatibilityContainerDesktop" data-csa-c-asin="B057815346"
                 data-csa-c-is-in-initial-active-row="false">
                                                                   </div>
                                    <div id="newerVersion_feature_div" class="celwidget" data-feature-name="newerVersion"
                 data-csa-c-type="widget" data-csa-c-content-id="newerVersion"
                 data-csa-c-slot-id="newerVersion_feature_div" data-csa-c-asin="B019833350"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="valuePick_feature_div" class="celwidget" data-feature-name="valuePick"
                 data-csa-c-type="widget" data-csa-c-content-id="valuePick"
                 data-csa-c-slot-id="valuePick_feature_div" data-csa-c-asin="B063479709"
                 data-csa-c-is-in-initial-active-row="false">
                                                         </div>
                                    <div id="certifiedRefurbishedVersion_feature_div" class="celwidget" data-feature-name="certifiedRefurbishedVersion"
                 data-csa-c-type="widget" data-csa-c-content-id="certifiedRefurbishedVersion"
                 data-csa-c-slot-id="certifiedRefurbishedVersion_feature_div" data-csa-c-asin="B036914157"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="recommendations_feature_div" class="celwidget" data-feature-name="recommendations"
                 data-csa-c-type="widget" data-csa-c-content-id="recommendations"
                 data-csa-c-slot-id="recommendations_feature_div" data-csa-c-asin="B064833098"
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="productAlert_feature_div" class="celwidget" data-feature-name="productAlert"
                 data-csa-c-type="widget" data-csa-c-content-id="productAlert"
                 data-csa-c-slot-id="productAlert_feature_div" data-csa-c-asin="B004627378"
                 data-csa-c-is-in-initial-active-row="false">
                                                   </div>
      </div>

<div id="hqpWrapper" class="centerColAlign">
                                   <div id="heroQuickPromoContainer" class="celwidget" data-feature-name="heroQuickPromoContainer"
                 data-csa-c-type="widget" data-csa-c-content-id="heroQuickPromoContainer"
                 data-csa-c-slot-id="heroQuickPromoContainer" data-csa-c-asin="B086722644"
                 data-csa-c-is-in-initial-active-row="false">
                                                                <div id="heroQuickPromo_feature_div" class="celwidget" data-feature-name="heroQuickPromo"
                 data-csa-c-type="widget" data-csa-c-content-id="heroQuickPromo"
                 data-csa-c-slot-id="heroQuickPromo_feature_div" data-csa-c-asin="B013109333"
                 data-csa-c-is-in-initial-active-row="false">
                                                   </div>
                                 </div>
      </div>
 </div>
 <script type="text/javascript">
    if(window.ue) {
        ue.count("dp_aib_centerCol_height", document.getElementById('centerCol').clientHeight);
    }
</script>

<div id="hover-zoom-end" class="a-section a-spacing-small a-padding-mini"></div>      <script type="text/javascript">
  setCSMReq('af');
  addlongPoleTag('af','desktop-html-atf-marker');
</script>

  <div id="ATFCriticalFeaturesDataContainer">
                                   <div id="twisterJsInitializer_feature_div" class="celwidget" data-feature-name="twisterJsInitializer"
                 data-csa-c-type="widget" data-csa-c-content-id="twisterJsInitializer"
                 data-csa-c-slot-id="twisterJsInitializer_feature_div" data-csa-c-asin="B096616464"
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                    <div id="imageBlockVariations_feature_div" class="celwidget" data-feature-name="imageBlockVariations"
                 data-csa-c-type="widget" data-csa-c-content-id="imageBlockVariations"
                 data-csa-c-slot-id="imageBlockVariations_feature_div" data-csa-c-asin="B092781369"
                 data-csa-c-is-in-initial-active-row="false">
                               <script type="text/javascript">
P.when('jQuery').register('ImageBlockBTF', function(jQuery){
if(window.performance && performance.now && window.ue && ue.count){
    ue.count('DPIBBTFRegisterTime',window.parseInt(performance.now()));
}
var isCustomerIdPresent = "true";
var data = {};
var obj = jQuery.parseJSON('{"dataInJson":null,"alwaysIncludeVideo":true,"autoplayVideo":false,"defaultColor":"initial","mainImageSizes":[["342","445"],["385","500"],["425","550"],["466","606"],["522","679"]],"maxAlts":7,"altsOnLeft":true,"productGroupID":"video_games_display_on_website","lazyLoadExperienceDisabled":true,"lazyLoadExperienceOnHoverDisabled":false,"useChromelessVideoPlayer":false,"colorToAsin":{},"refactorEnabled":true,"useIV":true,"tabletWeb":false,"views":["ImageBlockMagnifierView","ImageBlockAltImageView","ImageBlockVideoView","ImageBlockTwisterView","ImageBlockImmersiveViewImages","ImageBlockImmersiveViewVideos","ImageBlockImmersiveViewDimensionIngress","ImageBlockImmersiveViewShowroom","ImageBlockImmersiveView360","ImageBlockTabbedImmersiveView","ImageBlockShoppableSceneView"],"enhancedHoverOverlay":false,"landingAsinColor":"initial","colorImages":{},"heroImages":{},"enable360Map":{},"staticImages":{"hoverZoomIcon":"https://m.media-amazon.com/images/G/01/img11/apparel/UX/DP/icon_zoom._CB485946671_.png","shoppableSceneViewProductsButton":"https://m.media-amazon.com/images/G/01/shopbylook/shoppable-images/view_products._CB427832024_.svg","zoomLensBackground":"https://m.media-amazon.com/images/G/01/apparel/rcxgs/tile._CB483369110_.gif","shoppableSceneDotHighlighted":"https://m.media-amazon.com/images/G/01/shopbylook/shoppable-images/dot_highlighted._CB649293510_.svg","zoomInCur":"https://m.media-amazon.com/images/G/01/detail-page/cursors/zoomIn._CB485921866_.cur","shoppableSceneSideSheetClose":"https://m.media-amazon.com/images/G/01/shopbylook/shoppable-images/close_x_white._CB404688921_.png","shoppableSceneBackToTopArrow":"https://m.media-amazon.com/images/G/01/shopbylook/shoppable-images/back_to_top_arrow._CB427936690_.svg","arrow":"https://m.media-amazon.com/images/G/01/javascripts/lib/popover/images/light/sprite-vertical-popover-arrow._CB485933082_.png","icon360V2":"https://m.media-amazon.com/images/G/01/HomeCustomProduct/imageBlock-360-thumbnail-icon-small._CB612115888_.png","zoomIn":"https://m.media-amazon.com/images/G/01/detail-page/cursors/zoom-in._CB485944643_.bmp","zoomOut":"https://m.media-amazon.com/images/G/01/detail-page/cursors/zoom-out._CB485943857_.bmp","videoThumbIcon":"https://m.media-amazon.com/images/G/01/Quarterdeck/en_US/images/video._CB485935537_SX38_SY50_CR,0,0,38,50_.gif","spinnerNoLabel":"https://m.media-amazon.com/images/G/01/ui/loadIndicators/loading-large._CB485945288_.gif","zoomOutCur":"https://m.media-amazon.com/images/G/01/detail-page/cursors/zoomOut._CB485921725_.cur","videoSWFPath":"https://m.media-amazon.com/images/G/01/Quarterdeck/en_US/video/20110518115040892/Video._CB485981003_.swf","grabbing":"https://m.media-amazon.com/images/G/01/HomeCustomProduct/grabbingbox._CB485943551_.cur","shoppableSceneDot":"https://m.media-amazon.com/images/G/01/shopbylook/shoppable-images/dot._CB649293510_.svg","icon360":"https://m.media-amazon.com/images/G/01/HomeCustomProduct/360_icon_73x73v2._CB485971279_SX38_SY50_CR,0,0,38,50_.png","grab":"https://m.media-amazon.com/images/G/01/HomeCustomProduct/grabbox._CB485922675_.cur","spinner":"https://m.media-amazon.com/images/G/01/ui/loadIndicators/loading-large_labeled._CB485921664_.gif"},"staticStrings":{"dragToSpin":"Drag to Spin","videos":"Videos","video":"video","shoppableSceneTabsTitleT3":"Shop the collection","shoppableSceneTabsTitle":"Shop similar items","shoppableSceneTabsTitleT2":"Shop this style ","ivImageThumbnailLabelAnnounce":"Thumbnail image ###ivImageThumbnailIndex","rollOverToZoom":"Roll over image to zoom in","singleVideo":"VIDEO","clickSceneTagsToShopProducts":"Click the dots to see similar items","close":"Close","shoppableSceneViewProductsButton":"Shop similar items","images":"Images","watchMoreVideos":"Click to see more videos","shoppableSceneViewProductsButtonT2":"Shop this style ","shoppableSceneViewProductsButtonT1":"Shop the look","shoppableSceneViewProductsButtonT3":"Shop the collection","allMedia":"All Media","clickToExpand":"Click image to open expanded view","shoppableSceneTabsTitleT1":"Shop the look","playVideo":"Click to play video","shoppableSceneNoSuggestions":"No results available","touchToZoom":"Touch the image to zoom in","multipleVideos":"VIDEOS","shoppableSceneSeeMoreString":"See more","pleaseSelect":"Please select","clickForFullView":"Click to see full view","clickToZoom":"Click on image to zoom in"},"useChildVideos":true,"useClickZoom":false,"useHoverZoom":true,"useHoverZoomIpad":false,"visualDimensions":[],"mainImageHeightPartitions":null,"mainImageMaxSizes":null,"heroFocalPoint":null,"showMagnifierOnHover":false,"disableHoverOnAltImages":false,"overrideAltImageClickAction":false,"naturalMainImageSize":null,"imgTagWrapperClasses":null,"prioritizeVideos":false,"usePeekHover":false,"fadeMagnifier":false,"repositionHeroImage":false,"heroVideoVariant":null,"videos":[{"creatorProfile":{},"groupType":"IB_G1","aciContentId":"amzn1.vse.video.9a8f927d5fd547d79b2cd9f1fb624605","offset":"0","thumb":"https://m.media-amazon.com/images/I/61xn0ZQqv5L.SX38_SY50_CR,0,0,38,50_BG85,85,85_BR-120_PKdp-play-icon-overlay__.jpg","durationSeconds":25,"marketPlaceID":"ATVPDKIKX0DER","isVideo":true,"isHeroVideo":false,"title":"<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>","languageCode":"en_US","holderId":"holder9a8f927d5fd547d79b2cd9f1fb624605","url":"https://m.media-amazon.com/images/S/vse-vms-transcoding-artifact-us-east-1-prod/v2/fa606bf9-d183-51af-9ad1-8f3c7d531330/ShortForm-Generic-480p-16-9-1409173089793-rpcbe5.mp4","videoHeight":"480","videoWidth":"854","durationTimestamp":"00:25","rankingStrategy":"DEFAULT","slateUrl":"https://m.media-amazon.com/images/I/61xn0ZQqv5L.SX522_.jpg","minimumAge":0,"variant":"MAIN","slateHash":{"extension":"jpg","physicalID":null,"width":"854","height":"480"},"mediaObjectId":"9a8f927d5fd547d79b2cd9f1fb624605","thumbUrl":"https://m.media-amazon.com/images/I/61xn0ZQqv5L.SX38_SY50_CR,0,0,38,50_BG85,85,85_BR-120_PKdp-play-icon-overlay__.jpg"},{"creatorProfile":{},"groupType":"IB_G2","aciContentId":"amzn1.vse.video.0d1c75b58bea44d98c370609cb2e1ae6","offset":"0","thumb":"https://m.media-amazon.com/images/I/61qQ6lr4QSL.SX38_SY50_CR,0,0,38,50_BG85,85,85_BR-120_PKdp-play-icon-overlay__.jpg","durationSeconds":892,"marketPlaceID":"ATVPDKIKX0DER","isVideo":true,"isHeroVideo":false,"title":"PS4 Pro God of War Edition Unboxing","languageCode":"en_US","holderId":"holder0d1c75b58bea44d98c370609cb2e1ae6","url":"https://m.media-amazon.com/images/S/vse-vms-transcoding-artifact-us-east-1-prod/803c4c71-9edb-41a6-bdd1-3501add8a861/default.jobtemplate.hls.m3u8","videoHeight":"1080","videoWidth":"1920","durationTimestamp":"14:52","rankingStrategy":"DEFAULT","slateUrl":"https://m.media-amazon.com/images/I/61qQ6lr4QSL.SX522_.jpg","minimumAge":0,"variant":"MAIN","slateHash":{"extension":"jpg","physicalID":null,"width":"1280","height":"720"},"mediaObjectId":"0d1c75b58bea44d98c370609cb2e1ae6","thumbUrl":"https://m.media-amazon.com/images/I/61qQ6lr4QSL.SX38_SY50_CR,0,0,38,50_BG85,85,85_BR-120_PKdp-play-icon-overlay__.jpg"}],"title":"<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>","airyConfigEnabled":false,"airyConfig":null,"vseVideoDataSourceTreatment":"T1","mediaAsin":"B050060733","parentAsin":"B015866122","largeSCLVideoThumbnail":false,"displayVideoBanner":false,"useVSEVideos":true,"notShowVideoCount":false,"enableS2WithoutS1":false,"showNewMBLB":false,"useTabbedImmersiveView":true,"dpRequestId":"RBW56TXBT3VK1W4DNTET","customerId":"","contentWeblab":"","contentWeblabTreatment":"","dp60VideoThumbMap":null,"videoBackgroundChromefulMainView":"black"}');
data["alwaysIncludeVideo"] = obj.alwaysIncludeVideo ? 1 : 0;
data["autoplayVideo"] = obj.autoplayVideo ? 1 : 0;
data["defaultColor"] = obj.defaultColor;
data["maxAlts"] = obj.maxAlts;
data["altsOnLeft"] = obj.altsOnLeft;
data["newVideoMissing"] = obj.newVideoMissing;
data["lazyLoadExperienceDisabled"] = obj.lazyLoadExperienceDisabled;
data["lazyLoadExperienceOnHoverDisabled"] = obj.lazyLoadExperienceOnHoverDisabled;
data["useChromelessVideoPlayer"] = obj.useChromelessVideoPlayer ? 1 : 0;
data["colorToAsin"] = obj.colorToAsin;
data["ivRepresentativeAsin"] = obj.ivRepresentativeAsin;
data["ivImageSetKeys"] = obj.ivImageSetKeys;
data["useIV"] = obj.useIV ? 1 : 0;
data["tabletWeb"] = obj.tabletWeb ? 1 : 0;
data["views"] = obj.views;
data["enhancedHoverOverlay"] = obj.enhancedHoverOverlay;
data["landingAsinColor"] = obj.landingAsinColor;
data["colorImages"] = obj.colorImages;
data["heroImage"] = obj.heroImages;
data["spin360ColorEnabled"] = obj.enable360Map;
data["staticImages"] = obj.staticImages;
data["staticStrings"] = obj.staticStrings;
data["useChildVideos"] = obj.useChildVideos ? 1 : 0;
data["useClickZoom"] = obj.useClickZoom ? 1 : 0;
data["useHoverZoom"] = obj.useHoverZoom ? 1 : 0;
data["useHoverZoomIpad"] = obj.useHoverZoomIpad ? 1 : 0;
data["visualDimensions"] = obj.visualDimensions;
data["isLargeSCLVideoThumbnail"] = obj.largeSCLVideoThumbnail;
data["mainImageSizes"] = obj.mainImageSizes;
data["displayVideoBanner"] = obj.displayVideoBanner;
data["mainImageHeightPartitions"] = obj.mainImageHeightPartitions;
data["mainImageMaxSizes"] = obj.mainImageMaxSizes;
data["heroFocalPoint"] = obj.heroFocalPoint;
data["showMagnifierOnHover"] = obj.showMagnifierOnHover ? 1 : 0;
data["disableHoverOnAltImages"] = obj.disableHoverOnAltImages ? 1 : 0;
data["overrideAltImageClickAction"] = obj.overrideAltImageClickAction ? 1 : 0;
data["naturalMainImageSize"] = obj.naturalMainImageSize;
data["imgTagWrapperClasses"] = obj.imgTagWrapperClasses;
data["prioritizeVideos"] = obj.prioritizeVideos;
data["usePeekHover"] = obj.usePeekHover;
data["fadeMagnifier"] = obj.fadeMagnifier;
data["repositionHeroImage"] = obj.repositionHeroImage;
data["heroVideoVariant"] = obj.heroVideoVariant;
data["videos"] = obj.videos;
data["productGroupID"] = obj.productGroupID;
data["title"] = obj.title;
data["airyConfigEnabled"] = obj.airyConfigEnabled;
if (obj.airyConfigEnabled) {
  data["airyConfig"] = obj.airyConfig;
}
data["isDPXFeatureEnabled"] = true;
data["useTabbedImmersiveView"] = obj.useTabbedImmersiveView;
data["vseVideoDataSourceTreatment"] = obj.vseVideoDataSourceTreatment;
data["rankingStrategy"] = obj.rankingStrategy;
data["contentWeblab"] = obj.contentWeblab;
data["contentWeblabTreatment"] = obj.contentWeblabTreatment;
data["useVSEVideos"] = obj.useVSEVideos;
data["dpRequestId"] = obj.dpRequestId;
data["mediaAsin"] = obj.mediaAsin;
data["parentAsin"] = obj.parentAsin;
data["dp60VideoThumbMap"] = obj.dp60VideoThumbMap;
data["videoBackgroundChromefulMainView"] = obj.videoBackgroundChromefulMainView;
data["notShowVideoCount"] = obj.notShowVideoCount;
data["enableS2WithoutS1"] = obj.enableS2WithoutS1;
if (isCustomerIdPresent) {
  data["customerId"] = obj.customerId;
}
return data;
});
</script>
                                </div>
      </div>
 <div id="bottomRow">
     </div>

       <!-- MarkAF -->
    


    <script type="text/javascript">
    if(typeof uex === 'function'){uex('ld', 'atfClientSideWaitTimeDesktop', {wb: 1});};
  </script>







 








    






















    
    








    
    



    



   

    












        
        <script type="a-state" data-a-state="{&quot;key&quot;:&quot;metrics-schema&quot;}">{"widgetSchema":"dp:widget:","dimensionSchema":"dp:dims:"}</script>

    









 






        





























 
 
 

 
 







       
















        <script type='text/javascript'>P.when('cf').execute(function() { ue.count('dp:widget:dpxSize:dpxBTFSize', 388);ue.count('dp:widget:dpxSize:dpxATFSize', 169);});</script>
         
        






























    









      










        

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    





    
    
    
        











            <script type="a-state" data-a-state="{&quot;key&quot;:&quot;dp_injected_meta_assets&quot;}">{"assetNames":["InContextDetailPageAssets"]}</script>
                    








        
        
        
  








    


            


            






            

        








            




        


















        <script type='text/javascript'>P.when('cf').execute(function() { ue.count('dp:widget:dpxSize:dpxBTFSize', 388);});</script>
         
                                                  <div id="emit-js_feature_div" class="celwidget" data-feature-name="emit-js"
                 data-csa-c-type="widget" data-csa-c-content-id="emit-js"
                 data-csa-c-slot-id="emit-js_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              






                      </div>
                                    <div id="bundleV2_feature_div" class="celwidget" data-feature-name="bundleV2Feature"
                 data-csa-c-type="widget" data-csa-c-content-id="bundleV2Feature"
                 data-csa-c-slot-id="bundleV2_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                          </div>
                                    <div id="bundleComponentDetails_feature_div" class="celwidget" data-feature-name="bundleComponentDetails"
                 data-csa-c-type="widget" data-csa-c-content-id="bundleComponentDetails"
                 data-csa-c-slot-id="bundleComponentDetails_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                         </div>
                                    <div id="similarities_feature_div" class="celwidget" data-feature-name="similarities"
                 data-csa-c-type="widget" data-csa-c-content-id="similarities"
                 data-csa-c-slot-id="similarities_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              







                      </div>
                                    <div id="miraiBTFShopByLook_feature_div" class="celwidget" data-feature-name="miraiBTFShopByLook"
                 data-csa-c-type="widget" data-csa-c-content-id="miraiBTFShopByLook"
                 data-csa-c-slot-id="miraiBTFShopByLook_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                       </div>
                                    <div id="similarities_feature_div" class="celwidget" data-feature-name="similarities"
                 data-csa-c-type="widget" data-csa-c-content-id="similarities"
                 data-csa-c-slot-id="similarities_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              <div cel_widget_id='sims-consolidated-2_csm_instrumentation_wrapper' class='celwidget'>
<div class="celwidget pd_rd_w-oGJKh content-id-amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b pf_rd_p-fc475966-e837-48fc-9ed0-f4ca6ae9337b pf_rd_r-RBW56TXBT3VK1W4DNTET pd_rd_wg-BMJVv pd_rd_r-87d86915-1adc-4d78-b5e5-bc8e2e07e0c6 c-f" cel_widget_id="p13n-desktop-carousel_DPSims_0" data-csa-op-log-render="" data-csa-c-content-id="amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b" data-csa-c-slot-id="sims-container-1" data-csa-c-type="widget" data-csa-c-painter="p13n-desktop-carousel-cards"><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="p13n-desktop-carousel_DPSims_0"]', '#CardInstancenhvVoOjfxuvkozEmYw8d2g')('mark', 'bb')}</script>
<script>if(window.uet){window.uet('bb','p13n-desktop-carousel_DPSims_0',{wb: 1})}</script>
<style>.p13n-sc-shoveler li.a-carousel-card{overflow:visible;padding:5px 0}.p13n-sc-shoveler li.a-carousel-card-empty{min-height:250px}.p13n-sc-lazy-desktop .a-carousel-viewport{min-height:244px}
[class*=cards-widget-qs-widget-override] [class*=qs-widget-table],[class*=cards-widget-qs-widget-override] [id^=qs-widget-button-],[class*=cards-widget-qs-widget-override][class*=qs-widget-container],[id^=qs-widget-atc-button-]{width:100%}
._cDEzb_p13n-list-faceout-asin-row_1Arbr{margin-bottom:20px;margin-top:20px}._cDEzb_p13n-list-faceout-asin-detail-row_oQvd_{display:inline;width:650px}._cDEzb_feedback-switch_1qaMd{cursor:pointer;display:inline-block;height:50px;margin-top:5px;vertical-align:top;width:50px}._cDEzb_p13n-record-feedback-error-message_1fVND{margin-top:10px}
._cDEzb_p13n-list-faceout-asin-title_36t6X{margin-left:20px;margin-top:10px}._cDEzb_p13n-list-faceout-asin-title-wrapper_1ZzCK{width:290px}._cDEzb_p13n-list-faceout-not-interested-message-wrapper_2hNsd{padding-left:20px;padding-top:10px;width:380px}._cDEzb_feedback-button-row_i2GbB{-webkit-box-pack:end;-ms-flex-pack:end;display:-webkit-box;display:-ms-flexbox;display:flex;justify-content:flex-end}._cDEzb_p13n-list-faceout-remove-recs-button-content_EN5yY{margin-top:18px;width:220px!important}._cDEzb_p13n-list-faceout-undo-button-content_2NwaL{margin-top:15px;width:120px!important}._cDEzb_undo-button_2vLoX{cursor:pointer;font-weight:bolder;margin-top:3px}
.p13n-report-flag-hide{cursor:none;display:none}.p13n-report-flag{background-image:url(https://m.media-amazon.com/images/S/sash/vh8ofoqOd7XyRsk.png);background-repeat:no-repeat;background-size:15px 16px;cursor:pointer;height:16px;position:absolute;right:20px;top:35px;width:15px}.p13n-report-flag:hover{background-image:url(https://m.media-amazon.com/images/S/sash/WXxFP-k55X6KCh2.png)}.p13n-report-problem-modal-root{padding:14px 18px}
._cDEzb_p13n-popover-button-divider_1Jt36{margin:6px 0}._cDEzb_p13n-feedback-popover-button_2rWBn{background:url(https://m.media-amazon.com/images/G/01/x-locale/personalization/core-recs/canaries/kebabgrey_18.png) no-repeat 0 0;background-size:18px;display:block;height:18px;text-decoration:none;width:18px}._cDEzb_p13n-feedback-popover-button_2rWBn:hover{background-position:0 -18px}._cDEzb_p13n-feedback-modal-height_1uBiC{height:450px}._cDEzb_p13n-desktop-feedback-kebab-wrapper_jo5L2{margin:0 3px 15px 10px}._cDEzb_p13n-desktop-feedback-modal-center-utils_3n1l4{height:35px;margin-top:10px;text-align:center}._cDEzb_p13n-desktop-feedback-modal-changeover_MVHoj{display:none}
._cDEzb_p13n-sc-css-line-clamp-1_1Fn1y{-webkit-line-clamp:1;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-2_EWgCb{-webkit-line-clamp:2;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-3_g3dy1{-webkit-line-clamp:3;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-4_2q2cc{-webkit-line-clamp:4;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-5_2l-dX{-webkit-line-clamp:5;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-6_28daG{-webkit-line-clamp:6;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-7_1k_Mc{-webkit-line-clamp:7;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-8_1yvsR{-webkit-line-clamp:8;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-9_3Pofd{-webkit-line-clamp:9;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-10_mY8_7{-webkit-line-clamp:10;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}
._cDEzb_subtitle_2kEiH{line-height:10px}
._cDEzb_sponsoredLabel_RxXGt{color:#555;font-size:11px;line-height:23px;margin-bottom:4px}
._cDEzb_panel-text_3TtlT{width:220px}._cDEzb_panel-container_3ZNzh{float:left;width:238px}._cDEzb_panel-subsection_19oyW{padding-left:15px;padding-right:18px}._cDEzb_panel-logo-container_ucYMM{height:33px;margin-bottom:5px;width:220px}._cDEzb_panel-button_GP7zd{width:auto}
._cDEzb_p13n-flex-container-header-kebab_12qKs{-webkit-box-pack:justify;-ms-flex-pack:justify;-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;justify-content:space-between}
._cDEzb_p13n-sc-price_31f6D{word-wrap:normal}
._cDEzb_p13n-sc-css-line-clamp-1_1ZO6n{-webkit-line-clamp:1;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-2_2R0OL{-webkit-line-clamp:2;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-3_OxGLy{-webkit-line-clamp:3;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-4_Zr-Ep{-webkit-line-clamp:4;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-5_3v9Pj{-webkit-line-clamp:5;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-6_Z2TkG{-webkit-line-clamp:6;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-7_1VEgO{-webkit-line-clamp:7;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-8_2H34L{-webkit-line-clamp:8;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-9_2Gnhf{-webkit-line-clamp:9;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}._cDEzb_p13n-sc-css-line-clamp-10_1itnD{-webkit-line-clamp:10;-webkit-box-orient:vertical;display:-webkit-box;overflow:hidden}
._cDEzb_containerA11yMargin_1vSKH:focus{margin:.5rem}
._cDEzb_asin-title_2KJ6_{font-size:14px;font-weight:bolder;margin-left:20px;margin-top:10px;text-align:left}._cDEzb_asin-row_3PozI{display:block}._cDEzb_asin-detail-row_T7Jm0{margin-bottom:-12px}._cDEzb_image_11f2t{height:90px;width:90px}._cDEzb_feedback-switch_2zE08{cursor:pointer;display:inline-block;height:50px;margin-top:5px;vertical-align:top;width:50px}
._cDEzb_rvi-ee-text_caPZz{font-size:10px;line-height:10px}
._cDEzb_scrollable-card_2fUxq{text-align:left;width:95%}._cDEzb_close-icon-row_1UiN7{height:5px;min-width:600px;padding-right:10px;text-align:right;width:100%}[dir=rtl] ._cDEzb_close-icon-row_1UiN7{height:5px;min-width:600px;text-align:left;width:100%}._cDEzb_close-icon-column_33S0b{height:inherit}._cDEzb_detail-column_3HoqU{text-align:left}[dir=rtl] ._cDEzb_detail-column_3HoqU{text-align:right}._cDEzb_scrollable-row_bJNDZ{width:100%}._cDEzb_icon__PtFG{background-position:-310px -5px;cursor:pointer;height:1.6rem;width:1.6rem}._cDEzb_feedbackText_1z8PE{cursor:pointer}._cDEzb_nonOverlapping-card_3Xb1r{width:95%}._cDEzb_nonOverlapping-row_2Q-t7{-ms-flex-pack:distribute;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;justify-content:space-around;max-width:800px;min-width:600px;text-align:left;width:100%}
._cDEzb_card_2yY06{width:95%}._cDEzb_image-and-offer_XQEhq{display:-webkit-box;display:-ms-flexbox;display:flex;margin-bottom:0;margin-top:10px}._cDEzb_review-row_1d5Qn{padding-right:10px;width:100%}._cDEzb_row_1eL-2{width:100%}._cDEzb_icon_3kTmk{background-position:-310px -5px;height:1.6rem;width:1.6rem}
._cDEzb_generalFaceoutFlexBetween_7aGNX{-webkit-box-pack:justify;-ms-flex-pack:justify;-webkit-box-orient:vertical;-webkit-box-direction:normal;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;-ms-flex-direction:column;flex-direction:column;height:100%;justify-content:space-between;position:relative}
._cDEzb_aboveImageSpacing_3XO8A{height:32px}
._cDEzb_badgeRow_Yzo7c{position:absolute;top:0;z-index:10}._cDEzb_maskStyling_1IlBq{background-color:#0f1111;border-radius:4px;height:100%;left:0;opacity:.03;position:absolute;top:0;width:100%}._cDEzb_positionRelativeCss_ZwMqj{padding:32px 8px 8px;position:relative}._cDEzb_noop_3Xbw5{-webkit-perspective:none;perspective:none}
._cDEzb_faceout-individuals-wrapper_1hzQz{grid-gap:2px;display:grid;gap:2px}._cDEzb_buttonWrapperGrow_1ZVZ4{-webkit-box-flex:1;-ms-flex-positive:1;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-box-pack:end;-ms-flex-pack:end;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;flex-grow:1;justify-content:end;width:-webkit-fit-content;width:-moz-fit-content;width:fit-content}._cDEzb_containerA11yMargin_1en19:focus{margin:.5rem}
._cDEzb_heroBanner_1Y4Dy{min-height:60px}._cDEzb_heroBannerCompact_25doU{min-height:44px}._cDEzb_heroLabel_3b1XQ{display:block;font-size:inherit;line-height:inherit;padding-bottom:0}._cDEzb_setLabel_1T92X{display:block;margin-top:-2px}._cDEzb_baseAsinLabel_3LESS{display:block}
.p13n-faceout-static-left-padding .a-col-right[style]{padding-left:10px!important}.p13n-overlay-static-list-padding .a-col-right[style]{padding-left:8px!important}
._cDEzb_p13n-sc-price_3mJ9Z{word-wrap:normal;overflow-x:hidden}._cDEzb_p13n-sc-price-animation-wrapper_3PzN2{position:relative}
._cDEzb_p13n-sc-youpay_2mwp6{word-wrap:normal;overflow-x:hidden}._cDEzb_p13n-sc-youpay-wrapper_3MfNG{position:relative}
input[type=number]::-webkit-inner-spin-button,input[type=number]::-webkit-outer-spin-button{-webkit-appearance:none;margin:0}input[type=number]{-moz-appearance:textfield}
._cDEzb_stepperWrapper_RkOgK{-webkit-box-pack:justify;-ms-flex-pack:justify;-webkit-box-align:center;-ms-flex-align:center;align-items:center;border:2px solid #fcd200;border-radius:10rem;box-shadow:0 2px 5px 0 hsla(180,5%,84%,.5);display:-webkit-box;display:-ms-flexbox;display:flex;height:inherit;justify-content:space-between;width:100%}._cDEzb_smallSize_2hQ36{height:35px}._cDEzb_stepperButton_3GWEy img{cursor:pointer;height:20px;margin-left:12px;margin-right:12px;width:20px}._cDEzb_stepperDisplayText_2uKjx{-webkit-box-align:center;-ms-flex-align:center;align-items:center;color:#0f1111;display:-webkit-box;display:-ms-flexbox;display:flex;font-weight:700;height:100%}.a-button-disabled .p13n-sc-stepper-hide-while-loading,.p13n-atc-add-disabled{-webkit-filter:opacity(.35);filter:opacity(.35)}._cDEzb_clean-button-element__4uu5{-webkit-tap-highlight-color:transparent;background:none;border:none;border-radius:10rem;color:inherit;font:inherit;outline:inherit;padding:0}
._cDEzb_almStore_n5J0M{margin-top:2px;max-height:14px}
[class*=cards-widget-qs-widget-override] [class*=qs-widget-table],[class*=cards-widget-qs-widget-override] [id^=qs-widget-button-],[class*=cards-widget-qs-widget-override][class*=qs-widget-container],[id^=qs-widget-atc-button-]{width:100%}
._cDEzb_p13nDealOfTheDay_cVlwZ{background:#b12704;color:#fff;float:right;padding:2px 4px;position:relative}._cDEzb_dealsCardDealTimer_2oYBO{display:inline-block}._cDEzb_dealsCardPercentClaimed_1GTDI{display:inline-block;padding-top:3px}._cDEzb_p13nDealPercentClaimedWrapper_1exA2{background:#d5d9d9;height:6px;width:100%}._cDEzb_p13nDealPercentClaimedBar_2HB_x{background:#0f1111;height:100%}
._cDEzb_p13nDealOfTheDayBadge_2Nn7x{background:#b12704;color:#fff;padding:2px 4px}
._cDEzb_savingsBadgeWrapper_3DNjt{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-pack:justify;-ms-flex-pack:justify;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;font-size:12px;gap:6px;justify-content:space-between;margin-bottom:4px;margin-top:3px}._cDEzb_savingsBadgeLabel_2pUXu{border-radius:2px;line-height:16px;padding:4px 6px;position:relative}._cDEzb_savingsBadgeMessage_2JUtl{-webkit-box-flex:1;-ms-flex:1 1;flex:1 1;font-weight:700;line-height:12px;position:relative}._cDEzb_savingsRioCompliantBadgeWrapper_3Yv6K{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-pack:justify;-ms-flex-pack:justify;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;gap:6px;justify-content:space-between;margin-bottom:4px;margin-top:4px}._cDEzb_savingsRioCompliantBadgeLabel_6EU5w{border-radius:4px;padding:2px 4px;position:relative}._cDEzb_savingsBadgeWrapperAboveImage_1JzX4{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-pack:justify;-ms-flex-pack:justify;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;gap:6px;justify-content:space-between;position:relative}._cDEzb_savingsBadgeLabelAboveImage_CS9WC{border-radius:4px;margin:4px;padding:2px 4px;position:relative;top:0}
._cDEzb_curation_13VGx{margin-bottom:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
._cDEzb_labelHeight_1Hv8C{height:20px;margin-top:-7px}
._cDEzb_display-contents_2ZP7v{display:contents}
._cDEzb_p13n-prime-badge_GVM4h{position:relative;top:2px}
._cDEzb_sponsoredLabel_2UvSK{color:#555;font-size:11px}
._cDEzb_p13nSwatchLink_EGezW{display:-webkit-box;display:-ms-flexbox;display:flex}
._cDEzb_p13n-fr-text_3ysaH{color:#fff;font-size:12px;line-height:18px;margin-left:4px;margin-right:3px;padding-top:1px}[dir=rtl] ._cDEzb_p13n-fr-text_3ysaH{margin-left:3px;margin-right:8px}._cDEzb_p13n-fr-body_2Gxe4{display:-webkit-box;display:-ms-flexbox;display:flex;float:left;height:20px;line-height:18px;min-width:60px}[dir=rtl] ._cDEzb_p13n-fr-body_2Gxe4{float:right}._cDEzb_p13n-fr-body-charcoal_2gQPa{background-color:#303333;border-color:#303333}._cDEzb_p13n-fr-body-stone_2C7aU{background-color:#6f7373;border-color:#6f7373}._cDEzb_p13n-fr-triangle_3PmcP{border-right:10px solid transparent;border-top:20px solid;float:left;height:0;width:0}[dir=rtl] ._cDEzb_p13n-fr-triangle_3PmcP{border-left:10px solid transparent;border-right:0;float:right}._cDEzb_p13n-fr-triangle-charcoal_17tLm{color:#303333}._cDEzb_p13n-fr-triangle-stone_Voco2{color:#6f7373}
._cDEzb_badgeContainer_1y3jJ{border-top-left-radius:4px;border-top-right-radius:4px;z-index:199}._cDEzb_badgeContainerPosition_XzZZB{position:absolute}._cDEzb_badgeBodyShort_282Mu{border-right:5px solid transparent;border-top:20px}[dir=rtl] ._cDEzb_badgeBodyShort_282Mu{border-left:5px solid transparent;border-right:0 solid transparent}._cDEzb_badgeBodyTall_Qqe_c{border-right:10px solid transparent;border-top:26px}[dir=rtl] ._cDEzb_badgeBodyTall_Qqe_c{border-left:10px solid transparent;border-right:0 solid transparent}._cDEzb_badgeBody_3OjBP{-webkit-box-align:center;-ms-flex-align:center;align-items:center;border-top-color:#d7d7d7;border-top-left-radius:4px;border-top-style:solid;display:-webkit-inline-box;display:-ms-inline-flexbox;display:inline-flex;float:left}[dir=rtl] ._cDEzb_badgeBody_3OjBP{border-top-left-radius:0;border-top-right-radius:4px;float:right}._cDEzb_badgeText_3DmHv{font-size:11px;margin-top:-26px;padding:0 4px 0 8px}._cDEzb_badgeTextSmall_2k9Qc{color:#000;font-size:2.5vw;margin-top:-20px;padding:0 4px 0 3px;white-space:nowrap}
._cDEzb_p13n-gg-rectangle_33WUq{-webkit-box-pack:center;-ms-flex-pack:center;-webkit-box-align:center;-ms-flex-align:center;align-items:center;background-color:#555;border-color:#555;color:#fff;display:-webkit-box;display:-ms-flexbox;display:flex;float:left;justify-content:center;min-width:36px;padding-left:8px;padding-right:3px}._cDEzb_p13n-gg-triangle_2O1ZH{border-right:10px solid transparent;color:#555;float:left;height:0;width:0}._cDEzb_p13n-gg-badge-height-desktop_2gU_A{height:20px;line-height:20px}._cDEzb_p13n-gg-badge-height-mobile_1vyht{height:18px;line-height:18px}._cDEzb_p13n-gg-triangle-height-desktop_2oeq6{border-top:20px solid}._cDEzb_p13n-gg-triangle-height-mobile_1iCtm{border-top:18px solid}._cDEzb_p13n-gg-display-mobile_ZG6U7{display:-webkit-box;display:-ms-flexbox;display:flex}
._cDEzb_p13n-best-seller-badge_1-yh1{background-color:#c45500!important;font-size:12px;padding-bottom:2px;padding-top:2px}[dir=rtl] ._cDEzb_p13n-best-seller-badge-container_2pqK7{float:right}._cDEzb_p13n-best-seller-badge-container_2pqK7{display:inline-block;position:relative}._cDEzb_p13n-best-seller-badge_1-yh1:before{border-bottom-color:#c45500!important}._cDEzb_p13n-best-seller-badge_1-yh1:after{border-top-color:#c45500!important}._cDEzb_p13n-sc-bestseller-badge-body_3nkHf{background-color:#c45500;float:left;line-height:18px;padding-left:6px;padding-right:3px}._cDEzb_p13n-sc-bestseller-badge-text_3apKt{color:#fff;line-height:18px}._cDEzb_p13n-sc-bestseller-badge-triangle_2Z3cK{border-right:9px solid transparent;border-top:18px solid;color:#c45500;float:left;height:0;width:0}._cDEzb_p13n-sc-mvt-bestseller-badge_2jOzn{width:100%}._cDEzb_p13n-sc-mvt-bestseller-badge-body_1vXD8{border-radius:4px;color:#fff;display:-webkit-box;display:-ms-flexbox;display:flex;float:left}._cDEzb_p13n-sc-mvt-bestseller-badge-t17t25_MIFJm{background-color:#d14900;padding:2px 4px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-t24_K5nlh{background-color:#d14900;padding:4px 6px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-t12_uS2wf{background-color:#161d26;padding:4px 6px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-t2_CAn9v{background-color:#c45500;padding:4px 6px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-body-mobile_1PBfo{border-radius:4px;color:#fff;display:-webkit-box;display:-ms-flexbox;display:flex;float:left}._cDEzb_p13n-sc-mvt-bestseller-badge-body-mobile_1PBfo ._cDEzb_p13n-sc-mvt-bestseller-badge-t24_K5nlh{background-color:#d14900;padding:3px 6px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-body-mobile_1PBfo ._cDEzb_p13n-sc-mvt-bestseller-badge-t12_uS2wf{background-color:#161d26;padding:3px 6px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-body-mobile_1PBfo ._cDEzb_p13n-sc-mvt-bestseller-badge-t2_CAn9v{background-color:#c45500;padding:3px 6px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-body-mobile_1PBfo ._cDEzb_p13n-sc-mvt-bestseller-badge-t17t25_MIFJm{background-color:#d14900;padding:1px 4px!important}._cDEzb_p13n-sc-mvt-bestseller-badge-mobile_3dSye{border-radius:4px;font-size:max(13px,min(1.3rem,26px))!important}._cDEzb_p13n-sc-mvt-bestseller-badge-radius_3uVgH{border-radius:4px}
._cDEzb_p13n-ac-text-primary_2h8zx,._cDEzb_p13n-ac-text-secondary_17RUV{font-family:Amazon Ember,Arial!important;font-size:12px!important;line-height:22px}._cDEzb_p13n-ac-text-primary_2h8zx{color:#fff;margin-left:8px;margin-right:3px}[dir=rtl] ._cDEzb_p13n-ac-text-primary_2h8zx{margin-left:3px;margin-right:8px}._cDEzb_p13n-ac-text-secondary_17RUV{color:#f69931;margin-right:8px}[dir=rtl] ._cDEzb_p13n-ac-text-secondary_17RUV{margin-left:8px;margin-right:0}._cDEzb_p13n-ac-body_3XXUM{background-color:#232f3e;border-color:#232f3e;display:-webkit-box;display:-ms-flexbox;display:flex;float:left;height:22px;min-width:80px}[dir=rtl] ._cDEzb_p13n-ac-body_3XXUM{float:right}._cDEzb_p13n-ac-triangle_qo4WF{border-right:10px solid transparent;border-top:22px solid;color:#232f3e;float:left;height:0;width:0}[dir=rtl] ._cDEzb_p13n-ac-triangle_qo4WF{border-left:10px solid transparent;border-right:0;float:right}._cDEzb_p13n-ac-container_3idlF{width:100%}._cDEzb_p13n-ac-text-secondary_17RUV{line-height:24px}._cDEzb_p13n-ac-badge-container_2KKdQ{display:inline-block;position:relative}[dir=rtl] ._cDEzb_p13n-ac-badge-container_2KKdQ{float:right}._cDEzb_p13n-sc-mvt-ac-badge-body_1xEW_{border-radius:4px;color:#fff;display:-webkit-box;display:-ms-flexbox;display:flex;float:left}._cDEzb_p13n-sc-mvt-ac-badge-t17_ZmFyW{background-color:#d14900;padding:2px 4px!important}._cDEzb_p13n-sc-mvt-ac-badge-t12t24_1734W{background-color:#161d26;padding:4px 6px!important}._cDEzb_p13n-sc-mvt-ac-badge-t2_2xtN8{background-color:#232f3e;padding:4px 6px!important}._cDEzb_p13n-sc-mvt-ac-badge-t25_35ZrW{background-color:#161d26;padding:2px 4px!important}._cDEzb_p13n-sc-mvt-ac-badge-body-mobile_1js17{border-radius:4px;color:#fff;display:-webkit-box;display:-ms-flexbox;display:flex;float:left}._cDEzb_p13n-sc-mvt-ac-badge-body-mobile_1js17 ._cDEzb_p13n-sc-mvt-ac-badge-t12t24_1734W{background-color:#161d26;padding:3px 6px!important}._cDEzb_p13n-sc-mvt-ac-badge-body-mobile_1js17 ._cDEzb_p13n-sc-mvt-ac-badge-t2_2xtN8{background-color:#232f3e;padding:3px 6px!important}._cDEzb_p13n-sc-mvt-ac-badge-body-mobile_1js17 ._cDEzb_p13n-sc-mvt-ac-badge-t17_ZmFyW{background-color:#d14900;padding:1px 4px!important}._cDEzb_p13n-sc-mvt-ac-badge-body-mobile_1js17 ._cDEzb_p13n-sc-mvt-ac-badge-t25_35ZrW{background-color:#161d26;padding:1px 4px!important}._cDEzb_p13n-sc-mvt-ac-badge-mobile_25E9r{border-radius:4px;font-size:max(13px,min(1.3rem,26px))!important}._cDEzb_p13n-sc-mvt-ac-badge-radius_19mkD{border-radius:4px}._cDEzb_p13n-sc-mvt-ac-badge_gRfj5{width:100%}
[data-a-badge-color=sx-summit]{background-color:#d5dbdb!important;color:#d5dbdb!important}[data-a-badge-color=alm-error]{background-color:#e2080b!important;color:#e2080b!important}[data-a-badge-color=sx-granite]{color:#373d3e!important}span[id^=atc-error-badge],span[id^=atc-success-badge]{max-width:140px;position:absolute}
._cDEzb_p13nBDWrapper_RJ1C0{margin-bottom:3px;margin-top:3px}._cDEzb_p13nBDWrapperBadge_30opV{background:#7fccec;padding:3px 6px}
._cDEzb_p13nBusinessPromotionalBadgeWrapper_1P8Dk{color:#fff;margin-bottom:3px;margin-top:3px}._cDEzb_p13nBusinessPromotionalBadge_1xUcd{background:#025491;color:#fff;padding:4px 6px}
._cDEzb_p13n-sc-cpf-badge_dMVLV{color:#168342!important;text-decoration:none!important}._cDEzb_p13n-sc-cpf-badge_dMVLV i{margin-top:0;vertical-align:middle}._cDEzb_p13n-sc-cpf-cert-row_3PW-5{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-orient:horizontal;-webkit-box-direction:normal;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:row;flex-direction:row}._cDEzb_p13n-sc-cpf-cert-logo_2T8hY{margin-right:18px;min-width:45px}._cDEzb_p13n-sc-cpf-cert-column_1r84G{-webkit-box-orient:vertical;-ms-flex-direction:column;flex-direction:column}._cDEzb_p13n-sc-cpf-cert-column_1r84G,._cDEzb_p13n-sc-cpf-cert-grid_2Z5J-{-webkit-box-direction:normal;display:-webkit-box;display:-ms-flexbox;display:flex}._cDEzb_p13n-sc-cpf-cert-grid_2Z5J-{-webkit-box-orient:horizontal;-ms-flex-direction:row;flex-direction:row}._cDEzb_p13n-sc-cpf-link_3r-aG{text-decoration:underline!important}._cDEzb_p13n-sc-cpf-bottom-sheet_R9HFz{padding:21px 15px}
._cDEzb_p13n-sc-consolidation-sheet-badge_Kh9DX img{margin-right:1px}._cDEzb_p13n-sc-consolidation-sheet-badge_Kh9DX{display:inline-block}._cDEzb_p13n-sc-consolidation-sheet-badge_Kh9DX i{margin-left:4px;-webkit-transform:rotate(180deg);-ms-transform:rotate(180deg);transform:rotate(180deg)}._cDEzb_p13n-sc-consolidation-bottom-sheet_1CfIc{padding:21px 15px}._cDEzb_p13n-sc-consolidation-icon_13c7d{height:20px;width:16px}._cDEzb_p13n-sc-consolidation-popover-badge_wr73R img{margin-right:1px}._cDEzb_p13n-sc-consolidation-popover-badge_wr73R i{margin-top:0;vertical-align:middle}._cDEzb_p13n-sc-consolidation-popover-badge_wr73R{text-decoration:none!important}
._cDEzb_p13nImageComponent_2h-XX:-moz-loading{visibility:hidden}._cDEzb_autoScale_3FVNQ{height:100%;-o-object-fit:contain;object-fit:contain}
._cDEzb_p13n-delight-pricing-badge_26S9Q{background:#b12704;color:#fff;display:inline-block;padding:2px 10px;position:relative}._cDEzb_p13n-delight-pricing-badge-v2_rw-PO{background-color:#cc0c39;border-radius:4px;color:#fff;display:inline-block;margin-bottom:4px;padding:3px 6px;position:relative;vertical-align:middle}
._cDEzb_p13n-coupon-badge_3d5NR{background:#7fda69;color:#111;display:inline-block;padding:0 6px;position:relative}
._cDEzb_energy-efficiency-container_1Pkva{position:relative;text-align:left}._cDEzb_energy-efficiency-badge-standard_28gp8{cursor:pointer;display:inline-block;height:24px}._cDEzb_energy-efficiency-badge-shape_1IcJY{display:inline-block;height:24px}._cDEzb_energy-efficiency-badge-rating_3_0eN{fill:#fff;font-size:20px;vertical-align:middle}._cDEzb_energy-efficiency-badge-rating-sign_1ronK{fill:#fff;font-size:14px;vertical-align:middle}._cDEzb_energy-efficiency-badge-rating-2021_2Q_3P{left:24px * .6;text-shadow:-.5px -.5px 0 #000,.5px -.5px 0 #000,-.5px .5px 0 #000,.5px .5px 0 #000}._cDEzb_energy-efficiency-badge-data-sheet-label-container_2iEi2{display:inline-block;padding-left:5px;padding-top:0;position:absolute;vertical-align:middle}._cDEzb_energy-efficiency-badge-data-sheet-label_3b6X3{cursor:pointer;word-break:break-word}
._cDEzb_inlineErrorDetails_1NBx-{margin-right:-2px;vertical-align:text-top}._cDEzb_spCSRFTreatment_-hwVO{display:none;visibility:hidden}
._cDEzb_apex-savings-percent_nsC2Z{color:#cc0c39;font-weight:300}._cDEzb_apex-savings-percent-badge_nUoC7{color:#fff}._cDEzb_apex-no-wrap-no-overflow_1CHNX{word-wrap:normal;overflow-x:hidden}
._cDEzb_apex-savings-percent_1WI5l{color:#cc0c39;font-weight:300}._cDEzb_apex-no-wrap-no-overflow_3qoUP{word-wrap:normal;overflow-x:hidden}
._cDEzb_badgeDsk_2ocVL a{display:inline-block}._cDEzb_sidesheet_1vXyM{-webkit-overflow-scrolling:touch;background-color:#fff;bottom:0;box-shadow:-4px 0 5px rgba(0,0,0,.1);overflow:visible!important;position:fixed;right:-400px;top:0;width:400px;z-index:1200}._cDEzb_sheetHeader_h5Lkb{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-orient:horizontal;-webkit-box-direction:normal;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:row;flex-direction:row}._cDEzb_ssBadgeTxt_1PjUa{padding-left:8px}._cDEzb_bsBadgeTxt_KxWQj{padding-left:1rem}._cDEzb_expanderInner_sw8K-{padding-left:7px}._cDEzb_ssBgrd_3Q99J{background:#000;cursor:pointer;height:100%;opacity:.4;position:fixed;width:100%;z-index:280}._cDEzb_ssCloseBtn_2arXO{background-color:transparent;border:0;cursor:pointer;left:-30px;position:absolute}._cDEzb_ssCloseIcon_Wdvrw{background-position:-350px -100px;height:30px;width:20px}._cDEzb_ssStickyFooter_3gman{margin:0 -15px -1.2rem;padding:0 15px!important}._cDEzb_ssContentContainer_LTSOV{padding:21px}._cDEzb_ssContentContainer_LTSOV a{display:inline-block}._cDEzb_ssContent_3QodQ{max-height:100vh;overflow-y:scroll}._cDEzb_ssFooterTxt_jSLuY{color:#04705b;padding-left:4px}._cDEzb_backIcon_3VW9U{background-image:url(https://m.media-amazon.com/images/S/sash/k7bwzv3V0gxRaLG.svg);background-size:contain;cursor:pointer;display:inline-block;height:20px;margin-right:1.5rem;width:20px}._cDEzb_badgeTxt_2a_j5{text-decoration:underline}._cDEzb_badgeDskText_2cSSD{color:#0f1111;text-decoration:none;word-break:break-all}._cDEzb_badgePaddingSm_3xeR5{padding:0 2px}._cDEzb_badgePadding_2yNT9{padding:0 4px}._cDEzb_badgeDskText_2cSSD:hover{color:#c7511f!important}._cDEzb_badgeDskLink_dA5_b:hover{color:#c7511f;text-decoration:none}._cDEzb_cert_10_0Q{-webkit-box-align:center;-ms-flex-align:center;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;margin-top:6px}._cDEzb_certName_3IZo8{padding-left:4px}._cDEzb_certificate_opeTr{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-orient:horizontal;-webkit-box-direction:normal;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:row;flex-direction:row}._cDEzb_certificateIcon_3YNZd{margin-right:18px;min-width:50px}._cDEzb_certificateTxt_2Xm7g{padding-left:4px}._cDEzb_ssSecContentContainer_17KN8{padding:21px}._cDEzb_ssFooterImg_22JRf{vertical-align:middle}._cDEzb_ssStickyFooterLnk_42245:hover{color:#04705b;text-decoration:none!important}._cDEzb_expanderTitle_1xJvh{font-size:16px;line-height:1.225!important}._cDEzb_ssFooter_3Ef2c{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-orient:horizontal;-webkit-box-direction:normal;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:row;flex-direction:row}._cDEzb_badgeChevron_15M0U{display:inline}._cDEzb_badgeChevronIcon_2nuox{margin-top:auto}._cDEzb_chevronSm_ywVsn{-webkit-transform:scale(.8);-ms-transform:scale(.8);transform:scale(.8)}._cDEzb_bsContainer_nLdAv{padding:21px 15px}._cDEzb_bsContainer_nLdAv a{display:inline-block}._cDEzb_noMarginLft_8IkB0{margin-left:0}._cDEzb_attribute_W_qe4{display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;gap:9px 15px}._cDEzb_stickyFooter_1Zv4B{background-color:#fff;bottom:0;margin:0 -15px -1.2rem!important;padding:1.2rem 15px 0;position:sticky}._cDEzb_bsFooterTxt_3q5-v{color:#04705b;padding-left:.5rem}._cDEzb_ssBackIcon_3izOu{background-color:transparent;border:0;padding:0}._cDEzb_detailViewCertName_3na8c{padding-left:1rem}._cDEzb_bsCertificationImg_3APsA{margin-right:18px;min-width:50px}._cDEzb_bsCertification_CfXuB{-webkit-box-align:center;-ms-flex-align:center;-webkit-box-orient:horizontal;-webkit-box-direction:normal;align-items:center;display:-webkit-box;display:-ms-flexbox;display:flex;-ms-flex-direction:row;flex-direction:row}._cDEzb_attrSubCert_1y_4K{padding-bottom:10px;position:absolute}._cDEzb_cert_10_0Q:not(:first-child){padding-left:15px}._cDEzb_certNameMobile_1nSJM{color:#007185!important;padding-left:.5rem}
._cDEzb_ad-feedback-primary-link_2bIZi{height:30px;margin-bottom:7px;margin-top:4px;min-width:75px}._cDEzb_ad-feedback-text_2HjQ9{color:#555;font-family:Amazon Ember Regular,Amazon Ember,Arial;font-size:11px}._cDEzb_ad-feedback-sprite_28uwB{background-color:transparent;background-image:url(https://m.media-amazon.com/images/G/01/ad-feedback/info_icon_1Xsprite.png);background-position:0 0;width:14px}._cDEzb_ad-feedback-sprite-mobile_2_rj8,._cDEzb_ad-feedback-sprite_28uwB{background-repeat:no-repeat;color:#969696;display:inline-block;height:12px;margin:1px 0 1px 3px;vertical-align:text-top}._cDEzb_ad-feedback-sprite-mobile_2_rj8{background-image:url(https://m.media-amazon.com/images/G/01/ad-feedback/default_info_icon_3x.png);background-size:contain;width:12px}._cDEzb_ad-feedback-text-desktop_q3xp_{color:#555;cursor:pointer;display:inline-block;font-family:Amazon Ember Regular,Amazon Ember,Arial;font-size:11px;right:0;top:2px}._cDEzb_ad-feedback-loading-spinnner_1nmZw{margin-left:45%;margin-top:250px}._cDEzb_ad-feedback-loading-spinnner-rtl_2BoOY{margin-right:45%;margin-top:250px}</style>
<!--CardsClient--><div id="CardInstancenhvVoOjfxuvkozEmYw8d2g" data-card-metrics-id="p13n-desktop-carousel_DPSims_0" data-acp-params="tok=346v9oBYG0bXNCu38oOC5xq9qmb4U9ahu7CmsR6lrSc;ts=1743452479207;rid=RBW56TXBT3VK1W4DNTET;d1=343;d2=0;tpm=CGHDB.content-id;ref=pd_sim" data-acp-path="/acp/p13n-desktop-carousel/p13n-desktop-carousel-71f7f3b6-c5ca-4882-9c07-dd87217d0066-1743111424842/" data-acp-tracking="{&quot;pd_rd_w&quot;:&quot;oGJKh&quot;,&quot;content-id&quot;:&quot;amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&quot;,&quot;pf_rd_p&quot;:&quot;fc475966-e837-48fc-9ed0-f4ca6ae9337b&quot;,&quot;pf_rd_r&quot;:&quot;RBW56TXBT3VK1W4DNTET&quot;,&quot;pd_rd_wg&quot;:&quot;BMJVv&quot;,&quot;pd_rd_r&quot;:&quot;87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&quot;,&quot;ref_&quot;:&quot;pd_sim&quot;}" data-acp-stamp="1743452479540" data-acp-region-info="us-east-1"><hr aria-hidden="true" class="a-divider-normal bucketDivider"/><div class="a-section a-spacing-large bucket"><div class="p13n-sc-custom-title aok-hidden"></div><div><div data-a-carousel-options="{&quot;ajax&quot;:{&quot;id_list&quot;:[&quot;{&quot;id&quot;:&quot;B07XQKTPB2&quot;,&quot;linkParameters&quot;:{&quot;pd_rd_i&quot;:&quot;B07XQKTPB2&quot;},&quot;contextLinks&quot;:[]}&quot;]},&quot;autoAdjustHeightFreescroll&quot;:true,&quot;first_item_flush_left&quot;:false,&quot;initThreshold&quot;:100,&quot;loadingThresholdPixels&quot;:100,&quot;name&quot;:&quot;p13n-sc-shoveler_9mbi29m0f45&quot;,&quot;nextRequestSize&quot;:6,&quot;set_size&quot;:1}" data-amabotslotname="desktop-dp-sims" data-devicetype="desktop" data-faceoutSpecs="{}" data-faceoutkataname="GeneralFaceout" data-individuals="0" data-language="en-US" data-linkparameters="{&quot;pd_rd_w&quot;:&quot;oGJKh&quot;,&quot;content-id&quot;:&quot;amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&quot;,&quot;pf_rd_p&quot;:&quot;fc475966-e837-48fc-9ed0-f4ca6ae9337b&quot;,&quot;pf_rd_r&quot;:&quot;RBW56TXBT3VK1W4DNTET&quot;,&quot;pd_rd_wg&quot;:&quot;BMJVv&quot;,&quot;pd_rd_r&quot;:&quot;87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&quot;}" data-marketplaceid="ATVPDKIKX0DER" data-metrics="{}" data-name="p13n-sc-shoveler_9mbi29m0f45" data-offset="1" data-pagetype="Detail" data-productgroupid="video_games_display_on_website" data-reftagprefix="pd_sim" data-slotindex="0" data-a-display-strategy="swap" data-a-transition-strategy="swap" data-a-ajax-strategy="promise" role="group" class="a-begin a-carousel-container a-carousel-static a-carousel-display-swap a-carousel-transition-swap p13n-sc-shoveler"><input type="hidden" autoComplete="on" class="a-carousel-firstvisibleitem"/><div class="a-row"><div class="_cDEzb_p13n-flex-container-header-kebab_12qKs"><div class="a-row a-carousel-header-row a-size-medium"><div class="a-column a-span8"><h2 class="a-carousel-heading a-inline-block">Customers who bought this item also bought</h2></div><div class="a-column a-span4 a-span-last a-text-right"><span class="a-carousel-pagination a-size-base"><span class="a-carousel-page-count">Page <span class="a-carousel-page-current">1</span> of <span class="a-carousel-page-max">1</span>  </span><span class="a-carousel-restart-container"><span class="a-text-separator"></span><a class="a-carousel-restart" href="#">Start over</a></span><span class="a-carousel-accessibility-page-info a-offscreen" aria-live="polite">Page 1 of 1  </span></span></div></div></div></div><div class="a-row a-carousel-controls a-carousel-row a-carousel-has-buttons"><div class="a-carousel-row-inner"><div class="a-carousel-col a-carousel-left"><a class="a-button a-button-image a-carousel-button a-carousel-goto-prevpage" role="button" href="#"><span class="a-button-inner"><i class="a-icon a-icon-previous"><span class="a-icon-alt">Previous set of slides</span></i></span></a></div><div class="a-carousel-col a-carousel-center"><div class="a-carousel-viewport" role="group" aria-roledescription=""><ol class="a-carousel"><li class="a-carousel-card" style="width:165px"><span data-csa-c-type="item" data-csa-c-item-type="asin" data-csa-c-item-id="amzn1.asin.B07XQKTPB2" data-csa-c-owner="p13n" data-csa-c-posx="0"><div class="p13n-sc-uncoverable-faceout"><a aria-hidden="true" class="a-link-normal aok-block" tabindex="-1" href="/God-War-Hits-PlayStation-4/dp/B07XQKTPB2/ref=pd_sim_d_sccl_1_1/140-0199542-9827343?pd_rd_w=oGJKh&amp;content-id=amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_p=fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_r=RBW56TXBT3VK1W4DNTET&amp;pd_rd_wg=BMJVv&amp;pd_rd_r=87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&amp;pd_rd_i=B07XQKTPB2&amp;psc=1"><div class="a-section a-spacing-mini _cDEzb_noop_3Xbw5"><img alt="God of War Hits - PlayStation 4" src="https://images-na.ssl-images-amazon.com/images/I/811AhOv5zqL._AC_UL165_SR165,165_.jpg" class="a-dynamic-image p13n-sc-dynamic-image p13n-product-image" height="165px" data-a-dynamic-image="{&quot;https://images-na.ssl-images-amazon.com/images/I/811AhOv5zqL._AC_UL165_SR165,165_.jpg&quot;:[165,165],&quot;https://images-na.ssl-images-amazon.com/images/I/811AhOv5zqL._AC_UL330_SR330,330_.jpg&quot;:[330,330],&quot;https://images-na.ssl-images-amazon.com/images/I/811AhOv5zqL._AC_UL495_SR495,495_.jpg&quot;:[495,495]}" style="max-width:165px;max-height:165px"/></div></a><div><div><a class="a-link-normal aok-block" href="/God-War-Hits-PlayStation-4/dp/B07XQKTPB2/ref=pd_sim_d_sccl_1_1/140-0199542-9827343?pd_rd_w=oGJKh&amp;content-id=amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_p=fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_r=RBW56TXBT3VK1W4DNTET&amp;pd_rd_wg=BMJVv&amp;pd_rd_r=87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&amp;pd_rd_i=B07XQKTPB2&amp;psc=1" role="link"><span><div class="_cDEzb_p13n-sc-css-line-clamp-3_g3dy1 p13n-sc-truncate-fallback p13n-sc-line-clamp-3 p13n-sc-truncate-desktop-type2" data-rows="3">God of War Hits - PlayStation 4</div></span></a><div class="a-row a-size-small"><span class="a-size-small a-color-base"><div class="_cDEzb_p13n-sc-css-line-clamp-1_1Fn1y">PlayStation</div></span></div><div class="a-row"><div class="a-icon-row"><a class="a-link-normal" title="4.8 out of 5 stars, 11,442 ratings" href="/product-reviews/B07XQKTPB2/ref=pd_sim_d_sccl_1_1_cr/140-0199542-9827343?pd_rd_w=oGJKh&amp;content-id=amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_p=fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_r=RBW56TXBT3VK1W4DNTET&amp;pd_rd_wg=BMJVv&amp;pd_rd_r=87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&amp;pd_rd_i=B07XQKTPB2"><i aria-hidden="true" class="a-icon a-icon-star-small a-star-small-5 aok-align-top"><span class="a-icon-alt">4.8 out of 5 stars</span></i> <span aria-hidden="true" class="a-size-small">11,442</span></a></div></div><div class="a-row a-size-small"><span class="a-size-small a-color-secondary"><div class="_cDEzb_p13n-sc-css-line-clamp-1_1Fn1y">PlayStation 4</div></span></div><div class="a-row"><div class="a-row"><div class="a-section aok-relative"><div class="a-row"><a class="a-link-normal a-text-normal" href="/God-War-Hits-PlayStation-4/dp/B07XQKTPB2/ref=pd_sim_d_sccl_1_1/140-0199542-9827343?pd_rd_w=oGJKh&amp;content-id=amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_p=fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_r=RBW56TXBT3VK1W4DNTET&amp;pd_rd_wg=BMJVv&amp;pd_rd_r=87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&amp;pd_rd_i=B07XQKTPB2&amp;psc=1" role="link"><span class="a-size-medium _cDEzb_apex-savings-percent_nsC2Z aok-align-center">-18%</span><span class="a-letter-space"></span></a><a class="a-link-normal a-text-normal" href="/God-War-Hits-PlayStation-4/dp/B07XQKTPB2/ref=pd_sim_d_sccl_1_1/140-0199542-9827343?pd_rd_w=oGJKh&amp;content-id=amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_p=fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_r=RBW56TXBT3VK1W4DNTET&amp;pd_rd_wg=BMJVv&amp;pd_rd_r=87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&amp;pd_rd_i=B07XQKTPB2&amp;psc=1" role="link"><span class="a-price aok-align-center" data-a-size="medium_plus" data-a-color="base"><span class="a-offscreen">$16.43</span><span aria-hidden="true"><span class="a-price-symbol">$</span><span class="a-price-whole">16<span class="a-price-decimal">.</span></span><span class="a-price-fraction">43</span></span></span></a></div><div class="a-row a-size-small"><a class="a-link-normal a-text-normal" href="/God-War-Hits-PlayStation-4/dp/B07XQKTPB2/ref=pd_sim_d_sccl_1_1/140-0199542-9827343?pd_rd_w=oGJKh&amp;content-id=amzn1.sym.fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_p=fc475966-e837-48fc-9ed0-f4ca6ae9337b&amp;pf_rd_r=RBW56TXBT3VK1W4DNTET&amp;pd_rd_wg=BMJVv&amp;pd_rd_r=87d86915-1adc-4d78-b5e5-bc8e2e07e0c6&amp;pd_rd_i=B07XQKTPB2&amp;psc=1" role="link"><div class="a-row"><span class="a-size-mini a-color-secondary aok-nowrap"><span>List:</span> <span class="aok-nowrap a-text-strike">$19.99</span></span></div></a></div></div></div><div class="a-row"><span class="a-size-mini a-color-base" dir="auto">Get it as soon as <b>Friday, Apr 11</b></span></div></div><span class="a-size-mini a-color-base" dir="auto">FREE Shipping on orders over $35 shipped by Amazon</span></div></div></div></span></li></ol></div></div><div class="a-carousel-col a-carousel-right"><a class="a-button a-button-image a-carousel-button a-carousel-goto-nextpage" role="button" href="#"><span class="a-button-inner"><i class="a-icon a-icon-next"><span class="a-icon-alt">Next set of slides</span></i></span></a></div></div></div><span class="a-end aok-hidden"></span></div></div></div></div><script>if(window.mix_csa){window.mix_csa('[cel_widget_id="p13n-desktop-carousel_DPSims_0"]', '#CardInstancenhvVoOjfxuvkozEmYw8d2g')('mark', 'be')}</script>
<script>if(window.uet){window.uet('be','p13n-desktop-carousel_DPSims_0',{wb: 1})}</script>
<script>if(window.mixTimeout){window.mixTimeout('p13n-desktop-carousel', 'CardInstancenhvVoOjfxuvkozEmYw8d2g', 90000)};
P.when('mix:@amzn/mix.client-runtime', 'mix:p13n-desktop-carousel__dGE7wMRU').execute(function (runtime, cardModule) {runtime.registerCardFactory('CardInstancenhvVoOjfxuvkozEmYw8d2g', cardModule).then(function(){if(window.mix_csa){window.mix_csa('[cel_widget_id="p13n-desktop-carousel_DPSims_0"]', '#CardInstancenhvVoOjfxuvkozEmYw8d2g')('mark', 'functional')}if(window.uex){window.uex('ld','p13n-desktop-carousel_DPSims_0',{wb: 1})}});});
</script>
<script>P.load.js('https://images-na.ssl-images-amazon.com/images/I/51C9XslpM6L.js?xcp');
</script>
</div>


</div>

                      </div>
                                    <div id="similarities_feature_div" class="celwidget" data-feature-name="similarities"
                 data-csa-c-type="widget" data-csa-c-content-id="similarities"
                 data-csa-c-slot-id="similarities_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              <div cel_widget_id='sims-consolidated-3_csm_instrumentation_wrapper' class='celwidget'>
<div id='DPSims_sims-container_desktop-dp-sims_1_container' data-region-info='us-east-1'><script>(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('A', 'dram-lazy-load-widget', 'ready').execute(function(A) {A.trigger('dram:register-lazy-load-widget', '#DPSims_sims-container_desktop-dp-sims_1_container',2500, 'DPSims_desktop', true);});</script><script class='json-content' type='application/json'>{"encryptedLazyLoadRenderRequest":"AAAAAAAAAADtQioixEuT4YZUFCnXJ1gT/BIAAAAAAAC/30e/rPhyBiziJTOjLgMwtaT9xy8xRuS+g5Tv8c2vAH7XFmfHsTpPELSUhQRMLesKVnLPtJkPw7y7SYZ+E3jyxK3BkwSqQwM8itdhY/YGlGaZJQ45XYVIm77D/9CmW4smuHXT1qOx1rUCYPfD4g8XzgevIOSFYSyZ3C5eI6kOR/oxAXHS3I7PmaGw3+/2KpwI+zJKeBCC2ixlysEO/St259DI13DbZtkFbS21mZpEHF9nX6FqLNgTNYKCYCWxCuDNzCZR641SoOtbMu1WRYvrtJtTsrl/XhNVutppK5AMYMM6Su7q/SfWZsdULv6cJcKxDAvtGe5n5G0ckLuuYRNNcrTZQUUHj31qGW8Xi/w1fxU2agQ/NSBsI5Z30WfGH7r2Ekdv83R1E6XosmpQmWbljCtVqU5mdLpmSzjYaWtnAsgkqsnOr+QUHWy1WZR9EmH1VmTPChXYvRcpnhcCk8wnghwIJHKJjSymgEfANuWOZEbCd2CS1lbfSDAQ0OfOccP/ju0hu/LW02HKHcSfm4Cfq6cny2xa4pqsYq1EpUVESHfWZS5XWPe4do8IE1574VRp7w38OU8Eb8wsgPykHYn8QI1VVSEGjXewDU8sy586a+h4mIuz7/WpdffnqajNQcuA8lPqmeSenAcbTiCwm34FYfAZbdIp5RUokxDaB3dnaSV5z5O1TlXLuddiiQ0OVulC/ajkxa5ZoWJaVbE1kakBeZwsqVLz5U1IYj+yTPeeUvXaGZdf67BBqqXq1ntyIqIBgoGgtQ50wuAJKwggykREEoGrYRbEa79h1TgkZkv6IDJL2iLVrhKXIRoyT7p18NqzVXBkIMgPYERT8k9vUd/lkdpmr4DLi97q7Gct+CHbTKmNVGHobIerNIqBogj+q1CI7W0YD/7INNxW83Tj7IMERm6xGx3sUjHexwb0dccdLzojR+momQKxthanoU4L9IDrEyI7QGzAFkChSVUQUyp6f4mgv1bSOm/47E8KMD5l8ux0SrKuegM6kIGpHpw8+t1KX6l01PXnCeoP1SRtc2ZrjCp72SHP/G3QTKwcI5Bs9WD/WFEMV8hG3w9HaTY+osikeGwssoO+/nY6MpnCkRuuT2YsVa+IAp3euaX4hhOK90hug2Y6DySbp3r7YtoCqyRoDvZm2OOfrPXwfMPXh6cMoqrBsdy6uv/pLByb+YLmnpItBkJpPtn4yeTkqPY873PJZBewBBM6IJrK7rlIsyUCketOnNMTreObl07irwth4vkZbmy0xFuQ4eE6RIBmM/2AVEtSJn98+FBUWwnQl2ABcFVn7hkMOgp7P4xYJOE61y98FgmdosDn+twz69uUEsEtMIDRRfKJZwPZw1bqPKYjhAqkMa6r837D9dXYztnXb48hB2HrRWgK56kgeVIHDsKjX/GDYHhiSVZZuruqPEKzxT95svODGefrfJeBShAGQdf7tKGcm4jWbZsb0fj0lT1usMkGN8jmMvukQs7OOEi+yE1tPwMNZixamqAa/k9jMiQQxwCsMH02v7XGMfHADn0dz6AY61IHsBqPBcTk8OnRYV3Wbmxy/B3dAvrWA5PijDGA0YpjWpNiSoFGG0dqI34ERTC1HeSz75PZ3eUJzw1RI9Z/wVnhLRVCpNFQDXQf5u1GmcREDUk4UL2shzNFuX2Sxs1+bdTYJ1qM2e8+E08/bawMyIE1bZEF7GtjAj76Rq4LboDzsAqvgU8mp2pLEB+FlBxw52bYtQsTzvp4ejqqym8nYu7DZwyqhe/jNnx7wAWd26g49q1agQ5nNOxiCosqrevEYnX8AkDLOznwQ4Dlx7jT8AuL1AWBaHUPBipva/5SEXT+CjCNBnX8tcfZiYlOeeIzBPSFqMon83/CVSADYMcv6M25M2o57xROLFxB+MGzIO+lKX6YshbFT7Kj+V/EWX6N4gbI/68xFdryOeAF4ElpMIWixphTUEioixQ4nJTbg8tccd1aN8NQA04CYKiL4S6oVwo2fM099KMki0ORiu6PSNK54VFU3JLN/TdmeZrBeDs2TSikhYx1G/FrQxHKBp9YKUs1hV+m+Pm6PiPap23AlQHf1ZpyQklt2fyeI7EfYoeQTibmSMVuIVvhVDvuTCe8GsN16PVwm3Gn3Hx5LkYzj2WSCBOMVl9o5a9P1OqBkpaU7uxO12fS6gtFy+Us43JnOSApbtGWsBhbC1WNhHr8FvRkOyFRlKl313EFpffL4IYa3JM7AUyB1fVl4zpCSDNRXlG/Xw+gRMn1Iq06VHZ7CEjnqQHVpFffAJ4OT/nW2Pot3Mq3tljdL50dzLPpGQHnjZsyz6/RmFQ39HjqhNm6rgcSQnw2xU0ZYpY+ASvEywrAie/jx+Ft6gRyLnH4zDiQtRFowiJPBUNPU5dNgjrJtpHFB+OktQhTln8XfObhDhtI/RNKxdkpc3j0eVA+H78ciNW8XIanOoTTDoN06HhX0jcHgvURUCKQdMDJqsOVj62oN95D17YG3LBBuPENRqN42Th8VJRNVHzQII3cuTOIQncXdR5AT6go+J61ZhQ4M2ZR6Tv+c4826RAciGX28sBNzAeAh3rUyvmHc/3iqteOXgXbaEtsSgC9lx+eJji1cXxY9MjrIttzkDXhra3+bD0LxAAq53spuRxj4OYlhiMeSaZDGDjjIwdGDQUFL9zDnUs4jtw+VXt5fC9LDV6DAVQMpInXspOn+wdzxyMxhzH3IHRc6eBFGcwD7OHQudSRrmJhr0vpU+C0+Lrda20jc/2CehzKWTUiAbayHd7SZ4O4Vpjs8O2yWVVCf2anY2xS9PcEgxFnDiAIG6NIjkpbk6hf/DYlEyrHux5Ajm4LLcZYlZdrUQMLW1SHk59O0+s7H/nc19T5R4PTt3uBpwUYgmsCQMFUCgRAQtDQYHia88oOGJnJ6eX6p6L8A7ZPs89c1pPbQ9B1FA02aGZljusHImDWgm5m2dPE9xn+xDq5Yg+ebhXpgZWPc4BQbXVfIwlU1hzgY/V/+K2crHBmg5PPJUzlOd5GwrzA8YWPcfDgaYzR63DDdcXyBeQNRk/akH6c7Ru1hqT7RS1N7tzlgg4je6Kvj5hsBgFNbJqYvHznfqoW50AWrBpHH53bhwCiIFD1WKAAcDfE7B/Up7hdElUbRD5zYRi7ReB0ITYcGFs8+XL0LOB1gJ/ZhS4Wnpn8dxYk1XIb/bB/iR0G4Jy8026D6Wy6fOR/+Ra+/oB0npwOcQ2pMN6Oa+ob92xjMqdbqJ1G7/P10CcPH2tRV+umQyGZkGAZTEnaCqS4UPdbmbS8+8g2byTtHZUiGHNaLn22zcl5+vYn/nJZt2Z1oJT1Yrrs78/4kmAWtz/bfBHfa4HuP5BGnD16BfKSE26npXPO1v44EfQYRektQMXXyiRutbXgnuOoDcOLVjouoBgjBri2fzVCVQZlCJBoMz1Q1E8oyWllXjnLdKox0MjRvwuTAXSCQDY2Q3hIH2dyypeh0esGwnVL9fZ0VqYeTyOnxdEoc9w+QZfJq8O/1ZOXfeuxa+swOGztdSXev74mOpMI0oesCHX1Db0HYfggf1Rgy1yuDqRR5TimXGUZT7OaUa+H9SH6p4VvkasOLzdvLofXySQAz4CoOR7z086dNhjSr2LkV2CI8z/7O/W9fxeDjizmm4VZe0coZpFcSDMu9ypsM8gfLEVpzhFQLvzi0+66TSUyNbu/94X+LfStY+f/OcZ6j0N947YDkA0nvK+lYlsjwsYCb5JP49s95BEbf9VNGEeK+at5U1tplor3ZrY5XPm4Enz680nlfwvErnBbxoXQ2CIiXSkSYpJRcwAPvWCeHhRA3XdkeOUbrtCjgCdn1mY60/net2FdtJKWD7pboVkH7n1BAHzFBBAToCzjR7Nxl4xSsh0SITaa9KrjdUL/nvyPNDmXHECv3GMQE5760n7Tr990ZH+7KLnAbSj34yJelif+feO1xsxYorcPHJqMttOF5xObGPmETZGm1aRmmXieyE/TUW6hnE8Yk9pHLYwG+Q2ZMBiGwJux+k8206NoQpmIorcFSVpf2tMy1R2VP6sePyVnkO4Lu0wXhZWliOOYk5G9y7EJuYiZ+VyJhZRDkdHj4O+7EpPLwLlIDH6Y1GBgaHxiit8ItYqz+ZHp6zofTTvXdeoQ+APm+vymnCsJpEOsmMp71ZvLBixKPsQwBfoy/Q1CL1CkiVSgvRxEmEk8mcFWLHREUQdkrjCgqQHvnu+bSpXoyM01JZWzP+EbN0AAi33KN8ELoaQmoyD8VSOfzlbVdQKQMsQBfDIOdGxMdGIX60vxZssrpoKLhaQV6Pw7lRgt0u3dAvV+DuqfTU+9kclCuI8QUq4yFqvK0ttN7j5aLwR6H7UDUxN65PyPEWGZHo9QxfqMvVyuxj1TJsaqXequ5EAChZiTl/VD7QKJsNpUv77xhtdSzlvKDAL9rLEqWaNKFUDMlOs5sF6mmjYefldaXJM5vtP2dRUibQh6FbDBhQVoymcJ8ELxwgNa0ZRcUbCEPjlAQvwt/3ECEurQaL8WPCepg2WOYzkqAzp26+AZ1l6JRVhdXkbYYGiG2RfPHvrTOyAbQ9URI7ODidIj4Iisq2s0uYDEcChZw0sFVFXd7yDW7S3YpBRs5h43f134NS2j7HOo2l/XcE6gk0xsajbahPecXSl3jPv+VA+TraKRzpbJHzflVzfB9aVvWk+DAOiVBoZyDrRJAC8+crq6LYhQtzjXxbtSylBaL0jI8d/3VjAYOql/FXB6f2ewrxxCRUBvbwB7MokgkCchZZKIQxgU0Tg0+4MAkRcKCHt/2Kr8cgY4LEyvn0ywNrnSPhgvqrV5Sj3eohoD21FJLKU32FZnnsk11Uc+6z9n4SKn6lt5H21CMGxWkxq0bWQ5jgN6u16cGU3meJbuj74JRyEm2qvZ/+1eDtOf3IMy0dO3vKx2bR6LspjbgsHv6IbbohQJr62w1adDrU6IV34DGdulqjJ/BwTK9KRAv5DCbAWzr0liYJIytbnTcJcj7PjzxSe0uE9wYJo8BLGEPnD0ifJhbtcfS48WksObfzq/2vKHN2dWXWaFQ8NiyTu9XwEOFabmLFRBGsJVV0TRVQ/4z1gCeqQUa92URtFgQ4J45eB8RCuvLNKW+SyGL9abEu4lh4+VfdCHLczFhwsoaBK3pRBAFlmPR5YK2EXTS4bk8371tcOG0kdTmCYP0JdYuuh63t7o6gxSO6qleEI9HkCvad4sEbUjssUQHBXb6YVBtF0oQj8OsViBp57ysXu6GqyoC0O0CpQNOUiP+I0pa1BEPXPSR3ILCDsJIxEDsOxhaIvd7xgihPYCUyIUAK9sFQ+kHUXvHONBtTjiDn6b30FcKpEKHZsuo1U6f7La25eBqqD6LAqKBo5u5ZPUjo/trlzcHQ6Mzinz1JIjonqPqZx4fSWYZqLs2DeliftW/76KYQui3rnCs67s8ZUW4QQJaLqNylnvM3WhMXqADz4cIw6Bh1Xywzboph9CaihuIf3jh9DjoqJMh7OtJIJTVLcpD+ReGMCCCyn8Gfm67L6nPof90vmyMBtxqIlzVWTPLPC3MF3nX2RRmzCwll7Ro4OUpxIB+Q8oDr7YF+oerNGtLS/BgI0bpsy6W7KEbBi7y2SvdfLg0+TKXPGgh6Z/ogZgBA6h0pvvHVnuzrO3E5H+xxu08RQoltIMqfJDTQuplWsShmhUugs36xWGDBrj0YmxrwEwJFR0QGHkqu1XmM2NjYYCMo84NHMXEU/noBQDZkgdVsT6sLOYqn5mib0c2muXDMkfrV1PXWuVuq83zeV3DFsp7zHJqmNmKEt1XTWzDeZ8iZ073BKjc/E99upyy4fZnZSdNdJ2yO3PZPGhBjkRqa9nsnoY55tcJvD/r8zCuHLqu1kqdgwtNO/xB4gxthAW/kUGsgVikY7mTbXxLa2ZfHGtUK61vh3JPKXHkretlshsDU+3DpcGstHQjtSbdkj7DHHE+LI42Brx/rjWa7s8Vevc+55PX0M7Qd+pQlocANzpwWGHata+Rf4wT3KeySKtLEi5NEy4yKE7SGzVvohvFRzrP2/fPzyb3t/pvj+uOIlOvI23+o5kZCWtiUJWe8wUwWRnAj9/FROIVhfyIt1GWKrnZH/N/t3SgUL9yC7RfREsloouIw3IIfHQkO1H8v2WqMr6jrxHf+Uh8LRQPIHSz/5KHt78fxsRfl+BJU1ALKE1IYyrFqHTB3w4UCg2eOMFXENyuf4IuqlmtoqMggCd2AGBFPty1U+OoWuqdeD4ubuh1SdoikrDPf5QR95xK6s/3+XBBQj3S5lLbCyVCRo2TAe5DqVua6RnhnMypxteqH8LfJJh+U/3mdeMplQdGMO9hZQhY0yMLSWwhyCeJC8iaEt/2T7uWvRuoKu0QG5ZlUwKMaxXG5KEYaF8AiPdRHP8HEHtgQJuJBXFES/bQU2TphRZZmEA6BbjNhQMfkA4X2DVdwsLCuI41x+xBprRBrAiX0QOKpk="}</script><div class='widget-html-container'><div style='height: 350px;'><span class='lazy-load-spinner'></span></div></div></div><link rel="stylesheet" href="https://images-na.ssl-images-amazon.com/images/I/01FvA6+tfcL.css?AUIClients/DramAssets" />
<script>
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://images-na.ssl-images-amazon.com/images/I/01A+UY71QeL.js?AUIClients/DramAssets');
</script>



</div>

                      </div>
                                    <div id="promotions_feature_div" class="celwidget" data-feature-name="promotions"
                 data-csa-c-type="widget" data-csa-c-content-id="promotions"
                 data-csa-c-slot-id="promotions_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="ask-dp-search_feature_div" class="celwidget" data-feature-name="ask-dp-search"
                 data-csa-c-type="widget" data-csa-c-content-id="ask-dp-search"
                 data-csa-c-slot-id="ask-dp-search_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              



<a></a>

                      </div>
                                    <div id="productDetails_feature_div" class="celwidget" data-feature-name="reverse_interleave_productDetails_feature_v2"
                 data-csa-c-type="widget" data-csa-c-content-id="reverse_interleave_productDetails_feature_v2"
                 data-csa-c-slot-id="productDetails_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                            <a id="productDetails" name="productDetails"></a>
 <hr aria-hidden="true" class="a-divider-normal"/>  <div style="overflow:hidden;">
          <div id="prodDetails" class="a-section a-spacing-none">       <h2>
                                Product information </h2>
                            <div class="a-row">   <div class="a-column a-span12 a-span-last">        <div class="a-row a-spacing-top-base"> <div class="a-column a-span6"> <div class="a-row a-spacing-base">   <div class="a-section table-padding">     <table id="productDetails_detailBullets_sections1" class="a-keyvalue prodDetTable" role="presentation"> <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> ASIN </th>  <td class="a-size-base prodDetAttrValue"> B030236635 </td> </tr>            <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Release date </th>  <td class="a-size-base prodDetAttrValue"> April 20, 2018 </td> </tr>              <tr>   <th class="a-color-secondary a-size-base prodDetSectionEntry">Customer Reviews</th>  <td class="a-size-base">                               <div id="averageCustomerReviews" data-asin="B079367126" data-ref="dpx_acr_pop_" >
                              <span class="a-declarative" data-action="acrStarsLink-click-metrics" data-acrStarsLink-click-metrics="{}">         <span id="acrPopover" class="reviewCountTextLinkedHistogram noUnderline" title="4.2 out of 5 stars">
        <span class="a-declarative" data-action="a-popover" data-a-popover="{&quot;max-width&quot;:&quot;700&quot;,&quot;closeButton&quot;:&quot;true&quot;,&quot;closeButtonLabel&quot;:&quot;Close&quot;,&quot;position&quot;:&quot;triggerBottom&quot;,&quot;popoverLabel&quot;:&quot;Customer Reviews Ratings Summary&quot;,&quot;url&quot;:&quot;/gp/customer-reviews/widgets/average-customer-review/popover/ref=dpx_acr_pop_?contextId=dpx&amp;asin=B070513862&quot;}"> <a href="javascript:void(0)" role="button" class="a-popover-trigger a-declarative">    <span aria-hidden="true" class="a-size-base a-color-base"> 4.2 </span>            <i class="a-icon a-icon-star a-star-4 cm-cr-review-stars-spacing-big"><span class="a-icon-alt">4.2 out of 5 stars</span></i>   <i class="a-icon a-icon-popover"></i></a> </span>   <span class="a-letter-space"></span>  </span>

       </span> <span class="a-letter-space"></span>             <span class="a-declarative" data-action="acrLink-click-metrics" data-acrLink-click-metrics="{}"> <a id="acrCustomerReviewLink" class="a-link-normal" href="#averageCustomerReviewsAnchor">    <span id="acrCustomerReviewText" aria-label="394 Reviews" class="a-size-base">394 ratings</span>   </a> </span> <script type="text/javascript">
                    
                    var dpAcrHasRegisteredArcLinkClickAction;
                    P.when('A', 'ready').execute(function(A) {
                        if (dpAcrHasRegisteredArcLinkClickAction !== true) {
                            dpAcrHasRegisteredArcLinkClickAction = true;
                            A.declarative(
                                'acrLink-click-metrics', 'click',
                                { "allowLinkDefault": true },
                                function (event) {
                                    if (window.ue) {
                                        ue.count("acrLinkClickCount", (ue.count("acrLinkClickCount") || 0) + 1);
                                    }
                                }
                            );
                        }
                    });
                </script>
                 <script type="text/javascript">
            P.when('A', 'cf').execute(function(A) {
                A.declarative('acrStarsLink-click-metrics', 'click', { "allowLinkDefault" : true },  function(event){
                    if(window.ue) {
                        ue.count("acrStarsLinkWithPopoverClickCount", (ue.count("acrStarsLinkWithPopoverClickCount") || 0) + 1);
                    }
                });
            });
        </script>

           </div>
      <br/> 4.2 out of 5 stars </td> </tr>                <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Best Sellers Rank </th> <td> <span>  <span>#83,477 in Video Games (<a href='/gp/bestsellers/videogames/ref=pd_zg_ts_videogames'>See Top 100 in Video Games</a>)</span> <br/>  <span>#116 in <a href='/gp/bestsellers/videogames/6427871011/ref=pd_zg_hrsr_videogames'>PlayStation 4 Consoles</a></span> <br/>  </span> </td> </tr>                                                                                         <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Product Dimensions </th>  <td class="a-size-base prodDetAttrValue"> 14.3 x 4.5 x 17 inches; 7.41 ounces </td> </tr>            <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Type of item </th>  <td class="a-size-base prodDetAttrValue"> Video Game </td> </tr>                          <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Item model number </th>  <td class="a-size-base prodDetAttrValue"> 4655518633545 </td> </tr>            <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Is Discontinued By Manufacturer </th>  <td class="a-size-base prodDetAttrValue"> No </td> </tr>            <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Item Weight </th>  <td class="a-size-base prodDetAttrValue"> 7.4 ounces </td> </tr>            <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Manufacturer </th>  <td class="a-size-base prodDetAttrValue"> Sony Computer Entertainment </td> </tr>            <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Batteries </th>  <td class="a-size-base prodDetAttrValue"> 2 AA batteries required. (included) </td> </tr>            <tr> <th class="a-color-secondary a-size-base prodDetSectionEntry"> Date First Available </th>  <td class="a-size-base prodDetAttrValue"> March 6, 2018 </td> </tr> </table>   </div>  </div> </div> <div class="a-column a-span6 a-span-last">  <div class="a-row a-spacing-base"> <h1 class="a-size-medium a-spacing-small secHeader"> Warranty & Support </h1>  <div class="a-section table-padding">    Product Warranty: For warranty information about this product, please <a href="https://m.media-amazon.com/images/I/71LCUbAF71S.pdf" rel="nofollow" target="_blank" onclick="window.open(this.href,'ProductDisplay','width=500,height=500,dependent=yes,directories=no,location=no,menubar=no,resizable=yes,scrollbar=yes,toolbar=no');return false;" >click here.</a><span class="a-color-secondary"> [PDF ] </span> </div> </div>  <div class="a-row">         <div class="a-section">       <h1 class="a-size-medium a-spacing-small secHeader"> Feedback </h1>     <div class="a-section table-padding">   <table id="productDetails_feedback_sections" class="a-keyvalue prodDetTable" role="presentation"> <div class="a-row">       </div> <div class="a-row">      <input type="hidden" name="aapiCsrfToken" value="1@g3LXolMru0jZn0RvDS5/zdRjchigFTiWLmObCttbfO5/AAAAAQAAAABn6vk9cmF3AAAAABVX8CwXqz42z+J7i/ABqA==@NLD_6LX7UT" id="aapiCsrfToken"/> <input type="hidden" name="isStateRequired" value="true" id="isStateRequired"/> <input type="hidden" name="isStoreRequired" value="true" id="isStoreRequired"/> <input type="hidden" name="aapiEndpoint" value="https://data.amazon.com" id="aapiEndpoint"/> <input type="hidden" name="modalHeader" value="Tell Us About a Lower Price" id="modalHeader"/> <input type="hidden" name="productCategory" value="gl_video_games" id="productCategory"/> <input type="hidden" name="productImageUrl" value="https://m.media-amazon.com/images/I/51niLospJ3L._SS75_.jpg" id="productImageUrl"/> <input type="hidden" name="priceSymbol" value="$" id="priceSymbol"/> <input type="hidden" name="priceValue" value="283.59" id="priceValue"/> <input type="hidden" name="productTitle" value="<?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?>" id="productTitle"/> <input type="hidden" name="currencyOfPreference" value="USD" id="currencyOfPreference"/> <input type="hidden" name="absoluteUrlPrefix" value="https://www.amazon.com" id="absoluteUrlPrefix"/> <input type="hidden" name="customerId" id="customerId"/> <input type="hidden" name="isCustomerLoggedIn" value="false" id="isCustomerLoggedIn"/> <input type="hidden" name="isCurrentGlOnlineOnly" value="false" id="isCurrentGlOnlineOnly"/> <input type="hidden" name="asin" value="B057318971" id="asin"/> <input type="hidden" name="marketplaceId" value="ATVPDKIKX0DER" id="marketplaceId"/> <input type="hidden" name="countryCode" value="TH" id="countryCode"/> <input type="hidden" name="lowerPriceInfo" value="Found a lower price? Let us know. Although we can't match every price reported, we'll use your feedback to ensure that our prices remain competitive." id="lowerPriceInfo"/> <input type="hidden" name="lowerPriceWhere" value="Where did you see a lower price?" id="lowerPriceWhere"/> <input type="hidden" name="labelPermalink" value="Share" id="labelPermalink"/> <input type="hidden" name="labelOnline" value="Website (Online)" id="labelOnline"/> <input type="hidden" name="labelOffline" value="Store (Offline)" id="labelOffline"/> <input type="hidden" name="lowerPriceSignIn" value="Please &lt;a href=&quot;${sign-in-url}&quot;&gt;sign in&lt;/a&gt; to provide feedback." id="lowerPriceSignIn"/> <input type="hidden" name="labelStoreName" value="Store name" id="labelStoreName"/> <input type="hidden" name="addressCity" value="City" id="addressCity"/> <input type="hidden" name="addressState" value="State" id="addressState"/> <input type="hidden" name="selectProvince" value="Please select province" id="selectProvince"/> <input type="hidden" name="labelDateOfPrice" value="Date of the price" id="labelDateOfPrice"/> <input type="hidden" name="labelUrl" value="URL" id="labelUrl"/> <input type="hidden" name="labelPrice" value="Price" id="labelPrice"/> <input type="hidden" name="labelShipping" value="Shipping cost" id="labelShipping"/> <input type="hidden" name="submitFeedback" value="Submit Feedback" id="submitFeedback"/> <input type="hidden" name="errorNoType" value="Please select where the product was sold." id="errorNoType"/> <input type="hidden" name="errorBadPrice" value="Please only use numbers in the Price field." id="errorBadPrice"/> <input type="hidden" name="errorBadPriceShipping" value="Please only use numbers in the Price and Shipping fields." id="errorBadPriceShipping"/> <input type="hidden" name="errorInvalidUrl" value="Please enter a valid URL." id="errorInvalidUrl"/> <input type="hidden" name="errorSubmission" value="There was an error sending your feedback. Please try again." id="errorSubmission"/> <input type="hidden" name="errorEmptyFields" value="Please fill in all the fields." id="errorEmptyFields"/> <input type="hidden" name="errorMissingCity" value="Please specify the city" id="errorMissingCity"/> <input type="hidden" name="thankFeedback" value="Thank you for your feedback." id="thankFeedback"/> <input type="hidden" name="errorEmptyUrl" value="Enter url" id="errorEmptyUrl"/> <input type="hidden" name="offlineStoresList" value="[&quot;47th Street Photo&quot;,&quot;6th Ave&quot;,&quot;Accessory Genie&quot;,&quot;Ace Digital Club&quot;,&quot;Ace Hardware&quot;,&quot;Action Village&quot;,&quot;Adorama Camera&quot;,&quot;Albertsons&quot;,&quot;All Spare Tools&quot;,&quot;Athlete 101&quot;,&quot;Autobarn&quot;,&quot;AutoZone&quot;,&quot;Baby Universe&quot;,&quot;Backcountry&quot;,&quot;Barnes &amp; Noble&quot;,&quot;Barrons&quot;,&quot;Beach Audio&quot;,&quot;Bealls Florida&quot;,&quot;Bed Bath &amp; Beyond&quot;,&quot;Best Buy&quot;,&quot;Builder Depot&quot;,&quot;Campmor&quot;,&quot;CDW&quot;,&quot;Chelsea&quot;,&quot;Circuit City&quot;,&quot;Comp USA&quot;,&quot;Computer Geeks&quot;,&quot;Cooler Books&quot;,&quot;Costco&quot;,&quot;Crutchfield&quot;,&quot;CVS&quot;,&quot;Dell&quot;,&quot;Dick's Sporting Goods&quot;,&quot;Dillard's&quot;,&quot;Dishes Decor&amp;More&quot;,&quot;Dynadirect&quot;,&quot;EBGames&quot;,&quot;eek Technology&quot;,&quot;Electro Galaxy&quot;,&quot;Emotronics&quot;,&quot;eToys&quot;,&quot;Etronics&quot;,&quot;Everything Fitness&quot;,&quot;Factory Direct&quot;,&quot;Famous Brand Watches&quot;,&quot;Fine Brand Watches&quot;,&quot;Fitbuy&quot;,&quot;Folica&quot;,&quot;Foot Locker&quot;,&quot;Fred Meyer&quot;,&quot;Fry's Electronics&quot;,&quot;Full Compass Systems&quot;,&quot;Future Shop&quot;,&quot;GameStop&quot;,&quot;Giardinelli&quot;,&quot;Grizzly&quot;,&quot;Guitar Center&quot;,&quot;Heart Rate Monitors&quot;,&quot;HEB&quot;,&quot;HMV&quot;,&quot;Home &amp; Beyond&quot;,&quot;Home Depot&quot;,&quot;JC Whitney&quot;,&quot;J&amp;R&quot;,&quot;J&amp;R Music and Computer World&quot;,&quot;Juicy Kitchen&quot;,&quot;Karate Depot&quot;,&quot;Kmart&quot;,&quot;Kohls&quot;,&quot;Let's Talk&quot;,&quot;Lowe's&quot;,&quot;Macy's&quot;,&quot;Menards&quot;,&quot;Mercantila&quot;,&quot;Metro Kitchen&quot;,&quot;Mountain Gear&quot;,&quot;Musician's Friend&quot;,&quot;My Time Piece&quot;,&quot;NAPA&quot;,&quot;Nordstrom&quot;,&quot;Office Depot&quot;,&quot;Office Max&quot;,&quot;One Call&quot;,&quot;Parts America&quot;,&quot;Polar Discount&quot;,&quot;QFC&quot;,&quot;Randalls&quot;,&quot;REI&quot;,&quot;Ritz Camera&quot;,&quot;Rocky Point&quot;,&quot;Ross Dress For Less&quot;,&quot;Safeway&quot;,&quot;Sam's Club&quot;,&quot;Sears&quot;,&quot;Sharper Image&quot;,&quot;Shopper's Choice&quot;,&quot;Smart Bargains&quot;,&quot;Sports Authority&quot;,&quot;Sports R Us&quot;,&quot;Staples&quot;,&quot;Summit Racing Equipment&quot;,&quot;Swing Some Where&quot;,&quot;Target&quot;,&quot;Tech Depot&quot;,&quot;The Electronic Company&quot;,&quot;The Gadget Source&quot;,&quot;The Vitamin Shoppe&quot;,&quot;Tiger Direct&quot;,&quot;Tom Thumb&quot;,&quot;Tool Barn&quot;,&quot;Tool King&quot;,&quot;Tool Town&quot;,&quot;TOP Foods&quot;,&quot;Toys R Us&quot;,&quot;Tyler Tool&quot;,&quot;Uncle Joe&quot;,&quot;Vanns&quot;,&quot;Walgreens&quot;,&quot;Walmart&quot;,&quot;Watch Savings&quot;,&quot;Watch Zone&quot;,&quot;Weather Buffs&quot;,&quot;Whole Foods&quot;,&quot;Wholesale AV&quot;,&quot;Wine Enthusiast&quot;,&quot;Wirefly&quot;,&quot;Xcessory&quot;]" id="offlineStoresList"/> <input type="hidden" name="statesList" value="[{&quot;value&quot;:&quot;AK&quot;,&quot;name&quot;:&quot;AK&quot;},{&quot;value&quot;:&quot;AL&quot;,&quot;name&quot;:&quot;AL&quot;},{&quot;value&quot;:&quot;AR&quot;,&quot;name&quot;:&quot;AR&quot;},{&quot;value&quot;:&quot;AZ&quot;,&quot;name&quot;:&quot;AZ&quot;},{&quot;value&quot;:&quot;CA&quot;,&quot;name&quot;:&quot;CA&quot;},{&quot;value&quot;:&quot;CO&quot;,&quot;name&quot;:&quot;CO&quot;},{&quot;value&quot;:&quot;CT&quot;,&quot;name&quot;:&quot;CT&quot;},{&quot;value&quot;:&quot;DC&quot;,&quot;name&quot;:&quot;DC&quot;},{&quot;value&quot;:&quot;DE&quot;,&quot;name&quot;:&quot;DE&quot;},{&quot;value&quot;:&quot;FL&quot;,&quot;name&quot;:&quot;FL&quot;},{&quot;value&quot;:&quot;GA&quot;,&quot;name&quot;:&quot;GA&quot;},{&quot;value&quot;:&quot;HI&quot;,&quot;name&quot;:&quot;HI&quot;},{&quot;value&quot;:&quot;IA&quot;,&quot;name&quot;:&quot;IA&quot;},{&quot;value&quot;:&quot;ID&quot;,&quot;name&quot;:&quot;ID&quot;},{&quot;value&quot;:&quot;IL&quot;,&quot;name&quot;:&quot;IL&quot;},{&quot;value&quot;:&quot;IN&quot;,&quot;name&quot;:&quot;IN&quot;},{&quot;value&quot;:&quot;KS&quot;,&quot;name&quot;:&quot;KS&quot;},{&quot;value&quot;:&quot;KY&quot;,&quot;name&quot;:&quot;KY&quot;},{&quot;value&quot;:&quot;LA&quot;,&quot;name&quot;:&quot;LA&quot;},{&quot;value&quot;:&quot;MA&quot;,&quot;name&quot;:&quot;MA&quot;},{&quot;value&quot;:&quot;MD&quot;,&quot;name&quot;:&quot;MD&quot;},{&quot;value&quot;:&quot;ME&quot;,&quot;name&quot;:&quot;ME&quot;},{&quot;value&quot;:&quot;MI&quot;,&quot;name&quot;:&quot;MI&quot;},{&quot;value&quot;:&quot;MN&quot;,&quot;name&quot;:&quot;MN&quot;},{&quot;value&quot;:&quot;MO&quot;,&quot;name&quot;:&quot;MO&quot;},{&quot;value&quot;:&quot;MS&quot;,&quot;name&quot;:&quot;MS&quot;},{&quot;value&quot;:&quot;MT&quot;,&quot;name&quot;:&quot;MT&quot;},{&quot;value&quot;:&quot;NC&quot;,&quot;name&quot;:&quot;NC&quot;},{&quot;value&quot;:&quot;ND&quot;,&quot;name&quot;:&quot;ND&quot;},{&quot;value&quot;:&quot;NE&quot;,&quot;name&quot;:&quot;NE&quot;},{&quot;value&quot;:&quot;NH&quot;,&quot;name&quot;:&quot;NH&quot;},{&quot;value&quot;:&quot;NJ&quot;,&quot;name&quot;:&quot;NJ&quot;},{&quot;value&quot;:&quot;NM&quot;,&quot;name&quot;:&quot;NM&quot;},{&quot;value&quot;:&quot;NV&quot;,&quot;name&quot;:&quot;NV&quot;},{&quot;value&quot;:&quot;NY&quot;,&quot;name&quot;:&quot;NY&quot;},{&quot;value&quot;:&quot;OH&quot;,&quot;name&quot;:&quot;OH&quot;},{&quot;value&quot;:&quot;OK&quot;,&quot;name&quot;:&quot;OK&quot;},{&quot;value&quot;:&quot;OR&quot;,&quot;name&quot;:&quot;OR&quot;},{&quot;value&quot;:&quot;PA&quot;,&quot;name&quot;:&quot;PA&quot;},{&quot;value&quot;:&quot;RI&quot;,&quot;name&quot;:&quot;RI&quot;},{&quot;value&quot;:&quot;SC&quot;,&quot;name&quot;:&quot;SC&quot;},{&quot;value&quot;:&quot;SD&quot;,&quot;name&quot;:&quot;SD&quot;},{&quot;value&quot;:&quot;TN&quot;,&quot;name&quot;:&quot;TN&quot;},{&quot;value&quot;:&quot;TX&quot;,&quot;name&quot;:&quot;TX&quot;},{&quot;value&quot;:&quot;UT&quot;,&quot;name&quot;:&quot;UT&quot;},{&quot;value&quot;:&quot;VA&quot;,&quot;name&quot;:&quot;VA&quot;},{&quot;value&quot;:&quot;VT&quot;,&quot;name&quot;:&quot;VT&quot;},{&quot;value&quot;:&quot;WA&quot;,&quot;name&quot;:&quot;WA&quot;},{&quot;value&quot;:&quot;WI&quot;,&quot;name&quot;:&quot;WI&quot;},{&quot;value&quot;:&quot;WV&quot;,&quot;name&quot;:&quot;WV&quot;},{&quot;value&quot;:&quot;WY&quot;,&quot;name&quot;:&quot;WY&quot;}]" id="statesList"/> <style>
        .grid-container {
            display: block;
            flex-direction: column;
        }

        .grid-row {
            align-items: center;
            margin-bottom: 10px;
            margin-left: 20px;
        }

        .grid-label {
            min-width: 50px;
            padding-right: 10px;
        }

        .widgetAlerts {
            display: none;
        }

        .grid-input {
            flex: 1;
            width: 100%
        }

        .asterisk {
            color: #EB0000;
        }

        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            margin: -1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
        .priceavailability{
            padding: 0 28px;
        }
        @media (min-width: 420px) and (max-width: 550px){
            .container{
                display: block;
            }
            .grid-input{
                font-size: 85%;

            }
            .priceavailability{
                padding: 0 28px;
            }
            .a-dropdown-container .a-button-dropdown .a-button-text{
                font-size: 79%;
            }



        }
        @media (min-width: 320px) and (max-width: 419px) {
            .priceavailability{
                padding: 0 0px;
            }
            .container{
                display: block;
            }

            .grid-input{
                font-size: 80%;
            }
            input#offlineCity.grid-input{
                font-size: 62%;
            }
            span#stateValue{
                .grid-input
                {
                    font-size: 77%;
                }

            }
            .a-dropdown-container .a-button-dropdown .a-button-text{
                font-size: 65%;
            }



        }

    </style>

    <div>
        <div class="detailPageWidgetBlock" id="pricingFeedbackDiv">
            <span class="a-declarative" data-action="pricingFeedback-modal-button" data-pricingFeedback-modal-button="{}"> Would you like to  <b>
                    <a href="javascript:void(0)" role="button" class="a-popover-trigger a-declarative"> tell us about a lower price?
                    <i class="a-icon a-icon-popover"></i></a> </b>
            </span> </div>

        <div class="a-popover-preload" id="a-popover-pricingFeedback-modal-content"> <div id="pricingFeedback_contentContainer" class="contentContainer" style="overflow: auto;">

                <div id="feedbackForm">
                    <div id="pricingFeedback_titleBar">
                        <div class="container" style="display: flex;">
                            <div style="width: 30%;">
                                <img src=https://m.media-amazon.com/images/I/51niLospJ3L._SS75_.jpg width="75"
                                     alt=""
                                             height="75" border="0" tabindex="0">
                            </div>
                            <div style="flex-grow: 1;">
                                <p tabindex="0"><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></p>
                                <p id="permalink">
                                    <b>Share:
                                    </b>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="pricingFeedback_content"></div>
                    <hr />
                    <p tabindex="0">Found a lower price? Let us know. Although we can&#39;t match every price reported, we&#39;ll use your feedback to ensure that our prices remain competitive.</p>
                    <h2 tabindex="0">Where did you see a lower price?</h2>
                    <p id="note1" style="display: none" tabindex="0">Fields with an asterisk <span
                            class="asterisk" aria-hidden="true">*</span> are required</p>
                    <div class="priceavailability">
                        <fieldset role="radiogroup" aria-labelledby="PriceAvailabilitySection">
                            <legend class="visually-hidden">Price Availability</legend>
                        <fieldset role="group" aria-labelledby="OnlinePriceAvailabilitySection">
                            <legend>
                                <div id="onlineRadioContainer" style="display: flex">
                                    <input type="radio" name="retailerType" value="online"
                                           id="pricingFeedback_onlineRadio">
                                    <label
                                            for="pricingFeedback_onlineRadio">Website (Online)</label>
                                </div>
                            </legend>

                            <div id="pricingFeedback_onlineInput" class="grid-container">
                                <div class="grid-row">
                                    <label for="onlineUrl" class="grid-label"
                                           id="onlineUrlLabel">URL <span class="asterisk">*</span>:</label>
                                    <div class="a-fixed-left-grid-col a-col-right grid-input">
                                        <input type="text" size="32" maxlength="500" name="onlineUrl"
                                               id="onlineUrl" aria-required="true" class="grid-input"
                                               placeholder="Enter URL where you found the price lower">
                                        <div id="onlineUrl-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message
                                             a-spacing-top-mini widgetAlerts" role="alert">
                                            <div class="a-box-inner a-alert-container">
                                                <i class="a-icon a-icon-alert"></i>
                                                <span id="urlAlert" class="a-alert-content"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <label for="onlinePriceRaw" class="grid-label"
                                           id="onlinePriceRawLabel">Price
                                        ($)
                                        <span class="asterisk">*</span>:
                                    </label>
                                    <div class="a-fixed-left-grid-col a-col-right grid-input">
                                        <input type="number" size="20" maxlength="10"
                                               name="onlinePriceRaw" id="onlinePriceRaw"
                                               aria-required="true" class="grid-input"
                                               placeholder="Enter the price of the product">
                                        <div id="onlinePrice-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message
                                             a-spacing-top-mini widgetAlerts" role="alert">
                                            <div class="a-box-inner a-alert-container">
                                                <i class="a-icon a-icon-alert"></i>
                                                <span id="priceAlertOnline" class="a-alert-content"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <label for="onlineShippingRaw" class="grid-label"
                                           id="onlineShippingRawLabel">Shipping cost
                                        ($):
                                    </label>
                                    <div class="a-fixed-left-grid-col a-col-right grid-input">
                                        <input type="number" size="20" maxlength="10"
                                               name="onlineShippingRaw" id="onlineShippingRaw"
                                               aria-required="false" class="grid-input"
                                               placeholder="Enter the shipping price, If any">
                                        <div id="onlineShippingPrice-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message
                                             a-spacing-top-mini widgetAlerts" role="alert">
                                            <div class="a-box-inner a-alert-container">
                                                <i class="a-icon a-icon-alert"></i>
                                                <span id="priceShippingAlertOnline" class="a-alert-content">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-row" role="group" aria-labelledby="onlineCalendarLabel">
                                    <label for="onlineCalendar" class="grid-label"
                                           id="onlineCalendarLabel"> Date of the price
                                        (MM/DD/YYYY):</label>
                                    <div class="a-fixed-left-grid-col a-col-right grid-input">
                                        <div>
                                            <div id="onlineCalendar">
                                                <div class="monthSection"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                                    <span class="a-dropdown-container" role="combobox"
                                                                          aria-haspopup="listbox" aria-expanded="false"
                                                                          title="month">
                                                                        <select id="onlineMonth" name="onlineMonth"
                                                                                autocomplete="off"
                                                                                data-a-native-class="a-native-dropdown"
                                                                                class="month-select a-native-dropdown a-native-dropdown"
                                                                                aria-hidden="false"
                                                                                aria-label="Select Month">
                                                                            <option id="onlineMonthOptionDefault"
                                                                                    class="a-prompt" value=""></option>
                                                                            <option value="1">01</option>
                                                                            <option value="2">02</option>
                                                                            <option value="3">03</option>
                                                                            <option value="4">04</option>
                                                                            <option value="5">05</option>
                                                                            <option value="6">06</option>
                                                                            <option value="7">07</option>
                                                                            <option value="8">08</option>
                                                                            <option value="9">09</option>
                                                                            <option value="10">10</option>
                                                                            <option value="11">11</option>
                                                                            <option value="12">12</option>
                                                                        </select>
                                                                        <span
                                                                                class="a-button a-button-dropdown a-button-small a-button-width-normal"
                                                                                aria-hidden="true">
                                                                            <span class="a-button-inner">
                                                                                <span
                                                                                        class="a-button-text a-declarative"
                                                                                        data-action="a-dropdown-button"
                                                                                        role="button" aria-hidden="false">
                                                                                    <span id="onlineMonthPrompt"
                                                                                          class="a-dropdown-prompt"></span>
                                                                                </span>
                                                                                <i class="a-icon a-icon-dropdown"></i>
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                </div>
                                                <div class="firstDelimiter"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    /
                                                </div>
                                                <div class="daySection"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    <div>
                                                                        <span class="a-dropdown-container"
                                                                              role="combobox" aria-haspopup="listbox"
                                                                              aria-expanded="false"
                                                                              title="day">
                                                                            <select id="onlineDay" name="onlineDay"
                                                                                    autocomplete="off"
                                                                                    data-a-native-class="a-native-dropdown"
                                                                                    class="day-select a-native-dropdown a-native-dropdown"
                                                                                    aria-hidden="false"
                                                                                    aria-label="Select Day">
                                                                                <option id="onlineDateOptionDefault"
                                                                                        class="a-prompt" value=""></option>
                                                                                <option value="1">01</option>
                                                                                <option value="2">02</option>
                                                                                <option value="3">03</option>
                                                                                <option value="4">04</option>
                                                                                <option value="5">05</option>
                                                                                <option value="6">06</option>
                                                                                <option value="7">07</option>
                                                                                <option value="8">08</option>
                                                                                <option value="9">09</option>
                                                                                <option value="10">10</option>
                                                                                <option value="11">11</option>
                                                                                <option value="12">12</option>
                                                                                <option value="13">13</option>
                                                                                <option value="14">14</option>
                                                                                <option value="15">15</option>
                                                                                <option value="16">16</option>
                                                                                <option value="17">17</option>
                                                                                <option value="18">18</option>
                                                                                <option value="19">19</option>
                                                                                <option value="20">20</option>
                                                                                <option value="21">21</option>
                                                                                <option value="22">22</option>
                                                                                <option value="23">23</option>
                                                                                <option value="24">24</option>
                                                                                <option value="25">25</option>
                                                                                <option value="26">26</option>
                                                                                <option value="27">27</option>
                                                                                <option value="28">28</option>
                                                                                <option value="29">29</option>
                                                                                <option value="30">30</option>
                                                                                <option value="31">31</option>
                                                                            </select>
                                                                            <span
                                                                                    class="a-button a-button-dropdown a-button-small a-button-width-normal"
                                                                                    aria-hidden="true">
                                                                                <span class="a-button-inner">
                                                                                    <span
                                                                                            class="a-button-text a-declarative"
                                                                                            data-action="a-dropdown-button"
                                                                                            role="button"
                                                                                            aria-hidden="false">
                                                                                        <span id="onlineDatePrompt"
                                                                                              class="a-dropdown-prompt"></span>
                                                                                    </span>
                                                                                    <i
                                                                                            class="a-icon a-icon-dropdown"></i>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="secondDelimiter"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    /
                                                </div>
                                                <div class="yearSection"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    <div>
                                                                        <span class="a-dropdown-container"
                                                                              role="combobox" aria-haspopup="listbox"
                                                                              aria-expanded="false" title="year">
                                                                            <select id="onlineYear" name="onlineYear"
                                                                                    autocomplete="off"
                                                                                    data-a-native-class="a-native-dropdown"
                                                                                    class="a-native-dropdown a-native-dropdown"
                                                                                    aria-hidden="false"
                                                                                    aria-label="Select Year">
                                                                                <option id="onlineYearOptionDefault"
                                                                                        selected="selected" value="">
                                                                                </option>
                                                                            </select>
                                                                            <span
                                                                                    class="a-button a-button-dropdown a-button-small a-button-width-normal"
                                                                                    aria-hidden="true">
                                                                                <span class="a-button-inner">
                                                                                    <span
                                                                                            class="a-button-text a-declarative"
                                                                                            data-action="a-dropdown-button"
                                                                                            role="button"
                                                                                            aria-hidden="false">
                                                                                        <span id="onlineYearPrompt"
                                                                                              class="a-dropdown-prompt"></span>
                                                                                    </span>
                                                                                    <i
                                                                                            class="a-icon a-icon-dropdown"></i>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                        <fieldset role="group" aria-labelledby="OfflinePriceAvailabilitySection">
                            <legend>
                                <div id="offlineRadioContainer" style="display: flex;margin-top: 10px">
                                    <input type="radio" name="retailerType" value="offline"
                                           id="pricingFeedback_offlineRadio">
                                    <label
                                            for="pricingFeedback_offlineRadio">Store (Offline)</label>
                                </div>
                            </legend>

                            <div id="pricingFeedback_offlineInput" class="grid-container">
                                <div class="grid-row">
                                    <label id="storeLabel" class="grid-label" for="offlineStoreName">
                                            Store name <span
                                            class="asterisk">*</span>:
                                    </label>
                                    <div class="a-button-inner a-dropdown-container grid-input" id="storeValue"
                                         style="font-size: 11px">
                                        <select id="offlineStoreName" name="offlineStoreName" autocomplete="off"
                                                aria-required="true" data-a-native-class="a-native-dropdown"
                                                class="a-native-dropdown a-button-span10 a-native-dropdown">
                                            <option id="storeDefaultOption" class="a-prompt">
                                                Enter the store name where you found this product
                                            </option>

                                        </select>
                                        <span id="offlineStoreNameMain"
                                              class="a-button a-button-dropdown a-button-span10" aria-hidden="true">
            <span class="a-button-inner">
                <span class="a-button-text a-declarative" data-action="a-dropdown-button" role="button"
                      aria-hidden="true">
                    <span id="storeDefaultPrompt" class="a-dropdown-prompt">
                        Enter the store name where you found this product
                    </span>
                </span>
                <i class="a-icon a-icon-dropdown"></i>
            </span>
        </span>
                                    </div>
                                    <div id="offlineStoreName-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message
         a-spacing-top-mini widgetAlerts" role="alert">
                                        <div class="a-box-inner a-alert-container">
                                            <i class="a-icon a-icon-alert"></i>
                                            <span id="storeAlert" class="a-alert-content"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-row">
                                    <label for="offlineCity" class="grid-label" id="offlineCityLabel">
                                            City <span class="asterisk">*</span>:</label>
                                    </label>
                                    <input type="text" size="32" maxlength="100" name="offlineCity"
                                           id="offlineCity" aria-required="true" class="grid-input"
                                           placeholder="Enter the city where you found this product" />
                                    <div id="offlineCity-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message
                                             a-spacing-top-mini widgetAlerts" role="alert">
                                        <div class="a-box-inner a-alert-container">
                                            <i class="a-icon a-icon-alert"></i>
                                            <span id="cityAlert" class="a-alert-content">
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <div class="grid-row">
                                    <label id="stateLabel" class="grid-label" for="offlineState">
                                            State:
                                    </label>
                                    <span class="a-button-inner a-dropdown-container grid-input"
                                          id="stateValue" style="font-size: 11px">
                                                        <select id="offlineState" name="offlineState" autocomplete="off"
                                                                aria-required="false"
                                                                data-a-native-class="a-native-dropdown"
                                                                class="a-native-dropdown a-button-span10 a-native-dropdown">
                                                            <option id="stateDefaultOption" class="a-prompt">
                                                                    Please select province </option>
                                                        </select>
                                                        <span id="offlineStateMain"
                                                              class="a-button a-button-dropdown a-button-span10"
                                                              aria-hidden="true">
                                                            <span class="a-button-inner">
                                                                <span class="a-button-text a-declarative"
                                                                      data-action="a-dropdown-button" role="button"
                                                                      aria-hidden="true">
                                                                    <span id="stateDefaultPrompt"
                                                                          class="a-dropdown-prompt">Please select province </span>
                                                                </span>
                                                                <i class="a-icon a-icon-dropdown"></i>
                                                            </span>
                                                        </span>
                                                    </span>
                                </div>
                                <div class="grid-row">
                                    <label for="offlinePriceRaw" class="grid-label"
                                           id="offlinePriceRawLabel">Price
                                        ($)
                                        <span class="asterisk">*</span>:
                                    </label>
                                    <div class="a-fixed-left-grid-col a-col-right grid-input">
                                        <input type="number" size="20" maxlength="10"
                                               name="offlinePriceRaw" id="offlinePriceRaw"
                                               aria-required="true" class="grid-input"
                                               placeholder="Enter the price of the product">
                                        <div id="offlinePriceRaw-missing-alert" class="a-box a-alert-inline a-alert-inline-error auth-inlined-error-message
                                             a-spacing-top-mini widgetAlerts" role="alert">
                                            <div class="a-box-inner a-alert-container">
                                                <i class="a-icon a-icon-alert"></i>
                                                <span id="priceAlertOffline" class="a-alert-content" >
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid-row" role="group" aria-labelledby="offlineCalendarLabel">

                                    <label for="offlineCalendar" class="grid-label"
                                           id="offlineCalendarLabel">Date of the price
                                        (MM/DD/YYYY):</label>
                                    <div class="a-fixed-left-grid-col a-col-right grid-input">
                                        <div>
                                            <div id="offlineCalendar">
                                                <div class="monthSection"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                                    <span class="a-dropdown-container" role="combobox"
                                                                          aria-haspopup="listbox" aria-expanded="false"
                                                                          title="month">
                                                                        <select id="offlineMonth" name="offlineMonth"
                                                                                autocomplete="off"
                                                                                data-a-native-class="a-native-dropdown"
                                                                                class="month-select a-native-dropdown a-native-dropdown"
                                                                                aria-hidden="false" aria-label="Select Month">
                                                                            <option id="offlineMonthOptionDefault"
                                                                                    class="a-prompt" value=""></option>
                                                                            <option value="1">01</option>
                                                                            <option value="2">02</option>
                                                                            <option value="3">03</option>
                                                                            <option value="4">04</option>
                                                                            <option value="5">05</option>
                                                                            <option value="6">06</option>
                                                                            <option value="7">07</option>
                                                                            <option value="8">08</option>
                                                                            <option value="9">09</option>
                                                                            <option value="10">10</option>
                                                                            <option value="11">11</option>
                                                                            <option value="12">12</option>
                                                                        </select>
                                                                        <span
                                                                                class="a-button a-button-dropdown a-button-small a-button-width-normal"
                                                                                aria-hidden="true">
                                                                            <span class="a-button-inner">
                                                                                <span
                                                                                        class="a-button-text a-declarative"
                                                                                        data-action="a-dropdown-button"
                                                                                        role="button" aria-hidden="true">
                                                                                    <span id="offlineMonthPrompt"
                                                                                          class="a-dropdown-prompt"></span>
                                                                                </span>
                                                                                <i class="a-icon a-icon-dropdown"></i>
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                </div>
                                                <div class="firstDelimiter"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    /
                                                </div>
                                                <div class="daySection"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    <div>
                                                                        <span class="a-dropdown-container"
                                                                              role="combobox" aria-haspopup="listbox"
                                                                              aria-expanded="false" title="day">
                                                                            <select id="offlineDay" name="offlineDay"
                                                                                    autocomplete="off"
                                                                                    data-a-native-class="a-native-dropdown"
                                                                                    class="day-select a-native-dropdown a-native-dropdown"
                                                                                    aria-hidden="false" aria-label="Select day">
                                                                                <option id="offlineDateOptionDefault"
                                                                                        class="a-prompt" value=""></option>
                                                                                <option value="1">01</option>
                                                                                <option value="2">02</option>
                                                                                <option value="3">03</option>
                                                                                <option value="4">04</option>
                                                                                <option value="5">05</option>
                                                                                <option value="6">06</option>
                                                                                <option value="7">07</option>
                                                                                <option value="8">08</option>
                                                                                <option value="9">09</option>
                                                                                <option value="10">10</option>
                                                                                <option value="11">11</option>
                                                                                <option value="12">12</option>
                                                                                <option value="13">13</option>
                                                                                <option value="14">14</option>
                                                                                <option value="15">15</option>
                                                                                <option value="16">16</option>
                                                                                <option value="17">17</option>
                                                                                <option value="18">18</option>
                                                                                <option value="19">19</option>
                                                                                <option value="20">20</option>
                                                                                <option value="21">21</option>
                                                                                <option value="22">22</option>
                                                                                <option value="23">23</option>
                                                                                <option value="24">24</option>
                                                                                <option value="25">25</option>
                                                                                <option value="26">26</option>
                                                                                <option value="27">27</option>
                                                                                <option value="28">28</option>
                                                                                <option value="29">29</option>
                                                                                <option value="30">30</option>
                                                                                <option value="31">31</option>
                                                                            </select>
                                                                            <span
                                                                                    class="a-button a-button-dropdown a-button-small a-button-width-normal"
                                                                                    aria-hidden="true">
                                                                                <span class="a-button-inner">
                                                                                    <span
                                                                                            class="a-button-text a-declarative"
                                                                                            data-action="a-dropdown-button"
                                                                                            role="button"
                                                                                            aria-hidden="false">
                                                                                        <span id="offlineDatePrompt"
                                                                                              class="a-dropdown-prompt"></span>
                                                                                    </span>
                                                                                    <i
                                                                                            class="a-icon a-icon-dropdown"></i>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="secondDelimiter"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    /
                                                </div>
                                                <div class="yearSection"
                                                     style="flex: 1; float: left; display: inline-block;">
                                                    <div>
                                                                        <span class="a-dropdown-container"
                                                                              role="combobox" aria-haspopup="listbox"
                                                                              aria-expanded="false" title="year">
                                                                            <select id="offlineYear" name="offlineYear"
                                                                                    autocomplete="off"
                                                                                    data-a-native-class="a-native-dropdown"
                                                                                    class="a-native-dropdown a-native-dropdown"
                                                                                    aria-hidden="false"
                                                                                    aria-label="Select year">
                                                                                <option id="offlineYearOptionDefault"
                                                                                        selected="selected" value="">
                                                                                </option>
                                                                            </select>
                                                                            <span
                                                                                    class="a-button a-button-dropdown a-button-small a-button-width-normal"
                                                                                    aria-hidden="true">
                                                                                <span class="a-button-inner">
                                                                                    <span
                                                                                            class="a-button-text a-declarative"
                                                                                            data-action="a-dropdown-button"
                                                                                            role="button"
                                                                                            aria-hidden="true">
                                                                                        <span id="offlineYearPrompt"
                                                                                              class="a-dropdown-prompt"></span>
                                                                                    </span>
                                                                                    <i
                                                                                            class="a-icon a-icon-dropdown"></i>
                                                                                </span>
                                                                            </span>
                                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </fieldset>
                        </fieldset>
                        <div id="feedbackFormFinalState">
                            <div id="pricingFeedback_error"></div>

                            <div id="pricingFeedback_submit" style="padding: 0 15px 15px !important;margin-top: 15px">
                                <div id="loading" style="float: left;"></div>
                                <div style="float:left;">
                                                    <span id="pfw_submit" class="a-button a-button-primary">
                                                        <span class="a-button-inner">
                                                            <input name="pfw_submit" title="PFWSubmit"
                                                                   class="a-button-input" type="submit" value="submit"
                                                                   aria-labelledby="pfw_submit-announce">
                                                            <span id="pfw_submit-announce" class="a-button-text"
                                                                  aria-hidden="true">Submit Feedback</span>
                                                        </span>
                                                    </span>
                                </div>
                            </div>

                            <div id="pricingFeedback_thank">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="a-popover-content" id="signUpForm">
                        Please <a href="${sign-in-url}">sign in</a> to provide feedback. </div>
            </div>
        </div> </div>
 <script type="text/javascript">
    P.when("A", "a-modal", "ready").execute(function (A, modal) {
        var $ = A.$;

        var instance;
        var title = $("#modalHeader").val();
        function getModalWidth() {
            if (window.matchMedia("(max-width: 420px)").matches) {
                return "320px"; // Width for very small screens
            } else if (window.matchMedia("(max-width: 550px)").matches) {
                return "420px"; // Width for small screens
            } else {
                return "550px"; // Default width
            }
        }

        A.declarative("pricingFeedback-modal-button", "click", function (event) {
            if (!instance) {
                var options = {
                    name: "pricingFeedback-modal-content",
                    dataStrategy: "preload",
                };
                instance = modal.create(event.$target, options);
            }
            instance.update({
                header: title,
                width: getModalWidth()
            }).lock().show();
        });
        $(window).resize(function() {
            if (instance) {
                instance.update({
                    width: getModalWidth()
                });
            }
        });
    });


    P.when('A', 'ready').execute(function (A) {
        var $ = A.$;

        var csrf = $("#aapiCsrfToken").val();
        var productPrice = $("#priceValue").val();
        var hostname = $("#absoluteUrlPrefix").val();
        var customerId = $("#customerId").val();
        var isCustomerRecognized = ($("#isCustomerLoggedIn").val() === 'true');
        var isCurrentGlOnlineOnly = ($("#isCurrentGlOnlineOnly").val() === 'true');
        var asin = $("#asin").val();
        var marketplaceId = $("#marketplaceId").val();
        var country = $("#countryCode").val();
        var offlineStoresList = $("#offlineStoresList").val();
        var statesList = $("#statesList").val();

        var errorMessages = {
            errorNoRetailerType: $("#errorNoType").val(),
            errorBadPrice: $("#errorBadPrice").val(),
            errorBadPriceShipping: $("#errorBadPriceShipping").val(),
            errorInvalidUrl: $("#errorInvalidUrl").val(),
            errorSubmission: $("#errorSubmission").val(),
            errorEmptyFields: $("#errorEmptyFields").val(),
            errorMissingCity: $("#errorMissingCity").val(),
            errorEmptyUrl:$("#errorEmptyUrl").val(),
            thankFeedback: $("#thankFeedback").val()
        };

        var feedbackFormContent = document.querySelector('#feedbackForm');
        var signUpContainer = document.querySelector('#signUpForm');
        var feedbackFormFinalStateContainer = document.querySelector('#feedbackFormFinalState');

        var states = JSON.parse(statesList);
        var offlineStores = JSON.parse(offlineStoresList);

        var offlineStoresEnabled = !isCurrentGlOnlineOnly;
        var currentDate = getCurrentDay();
        var currentMonth = getCurrentMonth();
        var currentYear = getCurrentYear();

        if (isCustomerRecognized) {
            feedbackFormContent.style['display'] = 'block';
            signUpContainer.style['display'] = 'none';

            var enableOnlineStoreRadio = document.querySelector('#pricingFeedback_onlineRadio');
            var enableOfflineStoreRadio = document.querySelector('#pricingFeedback_offlineRadio');
            var onlineStoreInputForm = document.querySelector('#pricingFeedback_onlineInput');
            var offlineStoreInputForm = document.querySelector('#pricingFeedback_offlineInput');
            var offlineStateSelect = document.querySelector('#offlineState');
            var offlineStoreSelect = document.querySelector('#offlineStoreName');
            var submitButton = document.querySelector('#pricingFeedback_submit');
            var onlineUrl = document.querySelector('#onlineUrl');
            var onlinePriceRaw = document.querySelector('#onlinePriceRaw');
            var onlineShippingRaw = document.querySelector('#onlineShippingRaw');
            var onlineDay = document.querySelector('#onlineDay');
            var onlineMonth = document.querySelector('#onlineMonth');
            var onlineYear = document.querySelector('#onlineYear');
            var onlineCalendar = document.querySelector('#onlineCalendar');
            var note1 = document.querySelector('#note1');

            var offlineRadioContainer = document.querySelector('#offlineRadioContainer');
            var offlineStoreName = document.querySelector('#offlineStoreName');
            var offlineCity = document.querySelector('#offlineCity');
            var offlineState = document.querySelector('#offlineState');
            var offlinePriceRaw = document.querySelector('#offlinePriceRaw');
            var offlineDay = document.querySelector('#offlineDay');
            var offlineMonth = document.querySelector('#offlineMonth');
            var offlineYear = document.querySelector('#offlineYear');
            var offlineCalendar = document.querySelector('#offlineCalendar');

            var thankYouDiv = document.querySelector('#pricingFeedback_thank');
            var errorDiv = document.querySelector('#pricingFeedback_error');
            var loadingGifDiv = document.querySelector('#loading');
            var offlineStateMain = document.querySelector('#offlineStateMain');
            note1 = document.querySelector('#note1');
            setCalenderOrderBasedOnCountry(country);

            setInitialStates(
                onlineMonth,
                currentMonth,
                offlineMonth,
                onlineDay,
                currentDate,
                offlineDay,
                onlineYear,
                currentYear,
                offlineYear,
                onlineStoreInputForm,
                offlineStoreInputForm,
                enableOfflineStoreRadio,
                enableOnlineStoreRadio,
                onlineCalendar,
                offlineCalendar,
                offlineStateMain,
                offlineState,
                note1
            );

            createPermalinkContainer(asin, hostname);

            for (let state of states) {
                var option = document.createElement('option');
                option.setAttribute('value', state['value']);
                option.innerText = state['name'];
                offlineStateSelect.appendChild(option);
            }

            offlineStores.forEach(function(store) {
                var option = document.createElement('option');
                option.value = store;
                option.textContent = store;
                offlineStoreSelect.appendChild(option);
            });

            function setCSSForFeedbackForm() {
                const labels = document.querySelectorAll('.grid-label');
                let maxWidth = 0;

                labels.forEach(label => {
                    maxWidth = Math.max(maxWidth, label.clientWidth);
                });

                labels.forEach(label => {
                    label.style.minWidth = maxWidth + 'px';
                });
            }

            $("#pricingFeedback_onlineRadio").click(function () {
                onlineStoreInputForm.style['display'] = 'block';
                offlineStoreInputForm.style['display'] = 'none';
                note1.style['display'] = 'block';
                setCSSForFeedbackForm();
            });

            function handleInput(element, alert) {
                if (element.hasClass('a-form-error')) {
                    alert.style['display'] = 'none';
                    element.removeClass('a-form-error').addClass('a-form-normal');
                    element.removeAttr("aria-invalid");
                    element.removeAttr("aria-describedby");
                }
            }

            $('#onlineUrl').change(function () {
                var urlAlert = document.querySelector('#onlineUrl-missing-alert');
                handleInput($(this), urlAlert);
            });

            $('#onlinePriceRaw').change(function () {
                var priceAlertOnline = document.querySelector('#onlinePrice-missing-alert');
                handleInput($(this), priceAlertOnline);
            });
            $('#onlineShippingRaw').change(function () {
                var priceShippingAlertOnline = document.querySelector('#onlineShippingPrice-missing-alert');
                handleInput($(this), priceShippingAlertOnline);
            });
            $('#offlineCity').change(function () {
                var cityAlert = document.querySelector('#offlineCity-missing-alert');
                handleInput($(this), cityAlert);
            });

            $('#offlineStoreName').change(function () {
                var storeAlert = document.querySelector('#offlineStoreName-missing-alert');
                handleInput($(this), storeAlert);
            });

            $('#offlinePriceRaw').change(function () {
                var priceAlertOffline = document.querySelector('#offlinePriceRaw-missing-alert');
                handleInput($(this), priceAlertOffline);
            });

            $("#pricingFeedback_offlineRadio").click(function () {
                onlineStoreInputForm.style['display'] = 'none';
                offlineStoreInputForm.style['display'] = 'block';
                note1.style['display'] = 'block';
                setCSSForFeedbackForm();
            });

            if (!offlineStoresEnabled) {
                offlineRadioContainer.style['display'] = 'none';
                offlineStoreInputForm.style['display'] = 'none';
            }

            $("#pfw_submit").click(function () {
                var feedbackSubmitted = submitFeedback(
                    customerId,
                    marketplaceId,
                    asin,
                    productPrice,
                    onlineStoreInputForm,
                    offlineStoreInputForm,
                    onlineUrl.value,
                    onlinePriceRaw.value,
                    onlineShippingRaw.value,
                    onlineDay.value,
                    onlineMonth.value,
                    offlineStoreName.value,
                    offlineCity.value,
                    offlineState.value,
                    offlinePriceRaw.value,
                    offlineDay.value,
                    offlineMonth.value,
                    thankYouDiv,
                    errorDiv,
                    submitButton,
                    loadingGifDiv,
                    errorMessages
                );
                if (feedbackSubmitted !== null && !feedbackSubmitted) {
                    errorDiv.innerHTML = getErrorDiv(errorMessages.errorSubmission);
                }
            });

            A.on("a:popover:beforeHide:pricingFeedback-modal-content", function (data) {
                resetModalToInitialState(currentMonth, currentDate, currentYear);
            });

        } else {
            feedbackFormContent.style['display'] = 'none';
            signUpContainer.style['display'] = 'block';

            var authPortalLink = getAuthenticationPageURL(asin, hostname);
            $("#signUpForm").one("click", function () {
                window.location = encodeURI(authPortalLink);
            });
        }

        function setCalenderOrderBasedOnCountry(country) {
            var monthSections = document.getElementsByClassName('monthSection');
            var daySections = document.getElementsByClassName('daySection');
            var yearSections = document.getElementsByClassName('yearSection');

            var firstDelimiters = document.getElementsByClassName('firstDelimiter');
            var secondDelimiters = document.getElementsByClassName('secondDelimiter');

            if (country === 'US') {
                for (let i = 0; i < 2; i++) {
                    (monthSections[i]).style['order'] = '0';
                    (firstDelimiters[i]).style['order'] = '1';
                    (daySections[i]).style['order'] = '2';
                    (secondDelimiters[i]).style['order'] = '3';
                    (yearSections[i]).style['order'] = '4';
                }
            } else if (country === 'JP') {
                for (let i = 0; i < 2; i++) {
                    (yearSections[i]).style['order'] = '-1';
                    (secondDelimiters[i]).style['order'] = '0';
                    (monthSections[i]).style['order'] = '1';
                    (firstDelimiters[i]).style['order'] = '2';
                    (daySections[i]).style['order'] = '3';
                }
            } else {
                for (let i = 0; i < 2; i++) {
                    (daySections[i]).style['order'] = '-1';
                    (firstDelimiters[i]).style['order'] = '0';
                    (monthSections[i]).style['order'] = '1';
                    (secondDelimiters[i]).style['order'] = '2';
                    (yearSections[i]).style['order'] = '3';
                }
            }
        }

        function createPermalinkContainer(asin, hostname) {
            var permalinkHref = getPermalink(hostname, asin);
            var permalinkContainer = document.querySelector('#permalink');
            var permalink = document.createElement('a');
            permalink.setAttribute('href', permalinkHref);
            permalink.innerText = permalinkHref;
            permalinkContainer.append(permalink);
        }

        function getPermalink(server, asin) {
            return server + '/dp/' + asin;
        }

        function triggerPricingFeedback(
            customerId,
            marketplaceId,
            asin,
            price,
            retailerType,
            retailerUrl,
            retailerName,
            retailerCity,
            retailerState,
            retailerPrice,
            retailerShipping,
            sampleDate
        ) {
            var dataCart = {
                ourPrice: parseInt(price),
                retailer: {
                    type: retailerType,
                    name: retailerName,
                    city: retailerCity,
                    state: retailerState,
                    price: parseInt(retailerPrice),
                    shippingCost: parseInt(retailerShipping),
                    url: retailerUrl
                },
                date: sampleDate + "T00:00:00.102Z"
            };
            return new Promise((resolve, reject) => {
                A.$.ajax($("#aapiEndpoint").val() + "/api/marketplaces/" + marketplaceId + "/products/" + asin + "/feedback/pricing",
                    {
                        type: 'POST',
                        headers: {
                            'Accept-Language': 'en-US',
                            'Accept': 'application/vnd.com.amazon.api+json; type="product.feedback.pricing/v1"',
                            'x-amzn-encrypted-slate-token': document.querySelector('meta[name="encrypted-slate-token"]')?.content,
                            'Content-Type': 'application/vnd.com.amazon.api+json; type="product.feedback.pricing.request/v1"',
                            'x-api-csrf-token': csrf
                        },
                        data: JSON.stringify(dataCart),
                        xhrFields: {
                            withCredentials: true
                        },

                        success: function (responseContent) {
                            $("#pricingFeedback_thankcontent").innerText = "Success! " + responseContent.toString();
                            resolve();
                        },

                        error: function (err) {
                            $("#pricingFeedback_thankcontent").innerText = "Error! " + err.toString();
                            reject();
                        }
                    })
            })
        }

        function getAuthenticationPageURL(asin, hostname) {
            return hostname + '/ap/signin?_encoding=UTF8&openid.assoc_handle=usflex&openid.claimed_id=http://specs.openid.net/auth/2.0/identifier_select&openid.identity=http://specs.openid.net/auth/2.0/identifier_select&openid.mode=checkid_setup&openid.ns=http://specs.openid.net/auth/2.0&openid.ns.pape=http://specs.openid.net/extensions/pape/1.0&openid.pape.max_auth_age=0&openid.return_to=https://www.amazon.com/dp//';
        }

        function getCurrentDay() {
            var date = new Date();
            return date.getDate().toString();
        }

        function getCurrentMonth() {
            var date = new Date();
            return (date.getMonth() + 1).toString();
        }

        function getCurrentYear() {
            var date = new Date();
            return date.getFullYear().toString();
        }

        function resetAlerts() {
            const elements = [
                { id: "#onlineUrl", alertId: "#onlineUrl-missing-alert" },
                { id: "#onlinePriceRaw", alertId: "#onlinePrice-missing-alert" },
                { id: "#onlineShippingRaw", alertId: "#onlineShippingPrice-missing-alert" },
                { id: "#offlineStoreName", alertId: "#offlineStoreName-missing-alert" },
                { id: "#offlineCity", alertId: "#offlineCity-missing-alert" },
                { id: "#offlinePriceRaw", alertId: "#offlinePriceRaw-missing-alert" }
            ];

            for (const { id, alertId } of elements) {
                const element = document.querySelector(id);
                const alertElement = document.querySelector(alertId);

                if (element && alertElement) {
                    element.classList.remove('a-form-error', 'a-form-normal');
                    alertElement.style.display = 'none';
                }
            }
        }

        function setInitialStates(onlineMonth, currentMonth, offlineMonth, onlineDay, currentDate, offlineDay,
                                  onlineYear, currentYear, offlineYear, onlineStoreInputForm, offlineStoreInputForm, enableOfflineStoreRadio,
                                  enableOnlineStoreRadio, onlineCalendar, offlineCalendar, offlineStateMain, offlineState, note1) {
            onlineMonth.defaultValue = currentMonth;
            offlineMonth.defaultValue = currentMonth;
            onlineDay.defaultValue = currentDate;
            offlineDay.defaultValue = currentDate;
            onlineYear.defaultValue = currentYear;
            offlineYear.defaultValue = currentYear;

            var isStateRequired = document.querySelector('#isStateRequired');

            var stateLabel = document.querySelector('#stateLabel')
            var stateValue = document.querySelector('#stateValue')
            var isStoreRequired = document.querySelector('#isStoreRequired');

            var storeLabel = document.querySelector('#storeLabel')
            var storeValue = document.querySelector('#storeValue')

            if (isStateRequired.value === 'false') {
                stateLabel.style['display'] = 'none';
                stateValue.style['display'] = 'none';
            }
            if (isStoreRequired.value === 'false') {
                storeLabel.style['display'] = 'none';
                storeValue.style['display'] = 'none';
            }

            note1.style['display'] = 'none';

            resetAlerts();

            var onlineMonthOption = document.querySelector('#onlineMonthOptionDefault');
            onlineMonthOption.innerText = currentMonth;

            var onlineMonthPrompt = document.querySelector('#onlineMonthPrompt');
            onlineMonthPrompt.innerText = currentMonth;

            var offlineMonthOption = document.querySelector('#offlineMonthOptionDefault');
            offlineMonthOption.innerText = currentMonth;

            var offlineMonthPrompt = document.querySelector('#offlineMonthPrompt');
            offlineMonthPrompt.innerText = currentMonth;

            var onlineDateOption = document.querySelector('#onlineDateOptionDefault');
            onlineDateOption.innerText = currentDate;

            var onlineDayPrompt = document.querySelector('#onlineDatePrompt');
            onlineDayPrompt.innerText = currentDate;

            var offlineDateOption = document.querySelector('#offlineDateOptionDefault');
            offlineDateOption.innerText = currentDate;

            var offlineDayPrompt = document.querySelector('#offlineDatePrompt');
            offlineDayPrompt.innerText = currentDate;

            var onlineYearOption = document.querySelector('#onlineYearOptionDefault');
            onlineYearOption.setAttribute('href', currentYear);
            onlineYearOption.innerText = currentYear;

            var onlineYearPrompt = document.querySelector('#onlineYearPrompt');
            onlineYearPrompt.innerText = currentYear;

            var offlineYearOption = document.querySelector('#offlineYearOptionDefault');
            offlineYearOption.setAttribute('href', currentYear);
            offlineYearOption.innerText = currentYear;

            var offlineYearPrompt = document.querySelector('#offlineYearPrompt');
            offlineYearPrompt.innerText = currentYear;

            if (onlineMonth.children && offlineMonth.children && onlineDay.children && offlineDay.children) {
                onlineMonth.children[currentMonth].setAttribute('selected', currentMonth);
                offlineMonth.children[currentMonth].setAttribute('selected', currentMonth);
                onlineDay.children[currentDate].setAttribute('selected', currentDate);
                offlineDay.children[currentDate].setAttribute('selected', currentDate);
            }

            onlineStoreInputForm.style['display'] = 'none';
            offlineStoreInputForm.style['display'] = 'none';

            enableOfflineStoreRadio.checked = false;
            enableOnlineStoreRadio.checked = false;

            if (onlineCalendar.style && offlineCalendar.style) {
                onlineCalendar.style['display'] = 'block';
                offlineCalendar.style['display'] = 'block';
            }
        }

        function submitFeedback(
            customerId,
            marketplaceId,
            asin,
            price,
            onlineStoreInputForm,
            offlineStoreInputForm,
            onlineUrl,
            onlinePriceRaw,
            onlineShippingRaw,
            onlineDay,
            onlineMonth,
            offlineStoreName,
            offlineCity,
            offlineState,
            offlinePriceRaw,
            offlineDay,
            offlineMonth,
            thankYouDiv,
            errorDiv,
            submitButton,
            loadingGifDiv,
            errorMessages
        ) {
            errorDiv.innerHTML = '';

            let cleanRetailerType,
                cleanRetailerUrl,
                cleanRetailerName,
                cleanRetailerCity,
                cleanRetailerState,
                cleanRetailerPrice,
                cleanRetailerShipping,
                cleanSampleDate;
            var currentYear = getCurrentYear();
            if (onlineStoreInputForm.style['display'] === 'block') {
                var onlineValidity = validateOnlineInputs(onlineUrl, onlinePriceRaw, onlineShippingRaw, errorMessages);
                if (onlineValidity.valid) {
                    cleanRetailerType = 'ONLINE';
                    cleanRetailerUrl = truncate(trim(onlineUrl), 300);
                    cleanRetailerPrice = trim(onlinePriceRaw);
                    cleanRetailerShipping = trim(onlineShippingRaw);
                    if (!cleanRetailerShipping) {
                        cleanRetailerShipping = '0';
                    }
                    cleanSampleDate = formatDate(
                        currentYear,
                        onlineDay ? onlineDay : getCurrentDay(),
                        onlineMonth ? onlineMonth : getCurrentMonth()
                    );
                } else {
                    if (onlineValidity.error) {
                        errorDiv.innerHTML = getErrorDiv(onlineValidity.error);
                    }
                    return null;
                }
            } else if (offlineStoreInputForm.style['display'] === 'block') {
                var offlineValidity = validateOfflineInputs(
                    offlineStoreName,
                    offlineCity,
                    offlineState,
                    offlinePriceRaw,
                    errorMessages,
                    marketplaceId
                );
                if (offlineValidity.valid) {
                    cleanRetailerType = 'OFFLINE';
                    cleanRetailerName = truncate(trim(offlineStoreName), 100);
                    cleanRetailerCity = truncate(trim(offlineCity), 100);
                    cleanRetailerState = truncate(trim(offlineState), 100);
                    cleanRetailerPrice = trim(offlinePriceRaw);
                    cleanRetailerShipping = '0';
                    cleanSampleDate = formatDate(
                        currentYear,
                        offlineDay ? offlineDay : getCurrentDay(),
                        offlineMonth ? offlineMonth : getCurrentMonth()
                    );
                } else {
                    if (offlineValidity.error) {
                        errorDiv.innerHTML = getErrorDiv(offlineValidity.error);
                    }
                    return null;
                }
            } else {
                errorDiv.innerHTML = getErrorDiv(errorMessages.errorNoRetailerType);
                return null;
            }

            loadingGifDiv.innerHTML = getLoadingGifDiv();

            if (price) price = parseFloat(price);
            return triggerPricingFeedback(
                customerId,
                marketplaceId,
                asin,
                price,
                cleanRetailerType,
                cleanRetailerUrl,
                cleanRetailerName,
                cleanRetailerCity,
                cleanRetailerState,
                parseFloat(cleanRetailerPrice),
                parseFloat(cleanRetailerShipping),
                cleanSampleDate
            )
                .then(response => {
                    errorDiv.innerHTML = '';
                    thankYouDiv.innerHTML = getThankYouDiv(errorMessages.thankFeedback);

                    submitButton.style.display = 'none';
                    return response;
                })
                .catch(err => {
                    errorDiv.innerHTML = getErrorDiv(errorMessages.errorSubmission);
                    return null;
                });
        }

        function showError(element, elementAlert) {
            elementAlert.style['display'] = 'block';
            element.classList.add('a-form-error');
        }

        function isUrlPresentAndValid(url) {
            const onlineUrlElement = document.querySelector('#onlineUrl');
            const onlineUrlAlertDiv = document.querySelector('#onlineUrl-missing-alert');
            const urlAlert = document.querySelector('#urlAlert');

            if (isEmptyValue(url)) {
                showError(onlineUrlElement, onlineUrlAlertDiv);
                $('#onlineUrl').attr("aria-invalid", "true");
                $('#onlineUrl').attr("aria-describedby", "onlineUrl-missing-alert");
                urlAlert.innerHTML = "Enter url";$('#onlineUrl').attr("aria-invalid", "true");

                return false;
            }
            if (!isValidUrl(url)) {
                showError(onlineUrlElement, onlineUrlAlertDiv);
                $('#onlineUrl').attr("aria-invalid", "true");
                $('#onlineUrl').attr("aria-describedby", "onlineUrl-missing-alert");
                urlAlert.innerHTML = "Please enter a valid URL.";
                return false;
            }

            return true;
        }

        function isOnlinePriceThere(price) {
            const onlinePriceElement = document.querySelector('#onlinePriceRaw');
            const onlinePriceElementAlert = document.querySelector('#onlinePrice-missing-alert');
            const priceAlertOnline = document.querySelector('#priceAlertOnline');
            if (isEmptyValue(price) || !isNumericPrice(price)) {
                $('#onlinePriceRaw').attr("aria-invalid", "true");
                showError(onlinePriceElement, onlinePriceElementAlert);
                $('#onlinePriceRaw').attr("aria-describedby", "onlinePrice-missing-alert");
                priceAlertOnline.innerHTML="Please only use numbers in the Price field.";
                return false;
            }
            return true;
        }

        function isOnlineShippingPriceValid(shippingPrice) {
            const onlineShippingPriceElement = document.querySelector('#onlineShippingRaw');
            const onlineShippingPriceElementAlert = document.querySelector('#onlineShippingPrice-missing-alert');
            const priceShippingAlertOnline=document.querySelector('#priceShippingAlertOnline');
            if (!isEmptyValue(shippingPrice) && !isNumericPrice(shippingPrice)) {
                $('#onlineShippingRaw').attr("aria-invalid", "true");
                showError(onlineShippingPriceElement, onlineShippingPriceElementAlert);
                $('#onlineShippingRaw').attr("aria-describedby", "onlineShippingPrice-missing-alert");
                priceShippingAlertOnline.innerHTML = "Please only use numbers in the Price and Shipping fields.";
                return false;
            }

            return true;
        }

        function validateOnlineInputs(url, onlinePrice, onlineShipping, errorMessages) {
            const isValidUrl = isUrlPresentAndValid(url);
            const isPriceValid = isOnlinePriceThere(onlinePrice);
            const isShippingValid = isOnlineShippingPriceValid(onlineShipping);

            if (!isValidUrl || !isPriceValid || !isShippingValid) {
                return { valid: false };
            }

            return { valid: true };
        }

        function isOfflineStoreNameValid(offlineStoreName) {
            const offlineStoreElement = document.querySelector('#offlineStoreName');
            const offlineStoreElementAlert = document.querySelector('#offlineStoreName-missing-alert');
            const storeAlert=document.querySelector('#storeAlert');
            if (isEmptyValue(offlineStoreName)) {
                $('#offlineStoreName').attr("aria-invalid", "true");
                $('#offlineStoreName').attr("aria-describedby", "offlineStoreName-missing-alert");
                showError(offlineStoreElement, offlineStoreElementAlert);
                storeAlert.innerHTML="Please select where the product was sold.";
                return false;
            }

            return true;
        }

        function isOfflineCityNameValid(offlineCity) {
            const offlineCityElement = document.querySelector('#offlineCity');
            const offlineCityElementAlert = document.querySelector('#offlineCity-missing-alert');
            const cityAlert=document.querySelector('#cityAlert');
            if (isEmptyValue(offlineCity)) {
                $('#offlineCity').attr("aria-invalid", "true");
                $('#offlineCity').attr("aria-describedby", "offlineCity-missing-alert");
                showError(offlineCityElement, offlineCityElementAlert);
                cityAlert.innerHTML="Please specify the city"

                return false;
            }

            return true;
        }

        function isOfflinePriceValid(offlinePrice) {
            const offlinePriceElement = document.querySelector('#offlinePriceRaw');
            const offlinePriceElementAlert = document.querySelector('#offlinePriceRaw-missing-alert');
            const priceAlertOffline = document.querySelector('#priceAlertOffline');

            if (isEmptyValue(offlinePrice) || !isNumericPrice(offlinePrice)) {
                $('#offlinePriceRaw').attr("aria-invalid", "true");
                $('#offlinePriceRaw').attr("aria-describedby", "offlinePriceRaw-missing-alert");
                showError(offlinePriceElement, offlinePriceElementAlert);
                priceAlertOffline.innerHTML="Please only use numbers in the Price field.";
                return false;
            }
            return true;
        }

        function validateOfflineInputs(offlineStoreName, offlineCity, offlineState, offlinePrice, errorMessages, marketPlaceId) {

            const isStoreNameValid = isOfflineStoreNameValid(offlineStoreName);
            const isOfflineCityValid = isOfflineCityNameValid(offlineCity);
            const isPriceValid = isOfflinePriceValid(offlinePrice);
            if (!isStoreNameValid || !isOfflineCityValid || !isPriceValid) {
                return { valid: false };
            }

            return { valid: true };
        }

        function getErrorDiv(errorMsg) {
            return (
                '<div class="a-box a-alert a-alert-error a-spacing-mini" aria-live="assertive" role="alert">n' +
                '              <div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content">' +
                errorMsg +
                '</div></div>n' +
                '          </div>'
            );
        }

        function getThankYouDiv(thankMsg) {
            return (
                '<div class="a-box a-alert a-alert-success a-spacing-mini">' +
                '<div class="a-box-inner a-alert-container"><i class="a-icon a-icon-alert"></i><div class="a-alert-content">' +
                thankMsg +
                '</div></div></div>n' +
                '<p></p><hr/><p></p>'
            );
        }

        function getLoadingGifDiv() {
            return '<img src="https://images-na.ssl-images-amazon.com/images/G/01/x-locale/communities/tags/snake._CB485935600_.gif" class="loadingSymbolImage" width="16" height="16" border="0"/>';
        }

        function isValidUrl(url) {
            if (!url) {
                return false;
            }
            var encodedUrl = encodeURI(url);
            return encodedUrl.match(
                /^(https?://)?(([a-z0-9-]|%[A-F0-9]{2})+.)+(([a-z]|%[A-F0-9]{2})([a-z0-9]|%[A-F0-9]{2})*)(:[0-9]+)?(/[a-z0-9;:,~!+#@&=%/$.?_-]+)?$/
            );
        }

        function isNumericPrice(price) {
            if (!price) {
                return false;
            }
            return price.match(/^([0-9]+.?[0-9]*)$|^([0-9]*.[0-9]+)$/);
        }

        function isEmptyValue(input) {
            return !input || input.length === 0 || input.match(/^s*$/);
        }

        function truncate(input, length) {
            if (!input) {
                return '';
            } else {
                return input.substr(0, length);
            }
        }

        function formatDate(year, date, month) {
            return year + '-' + month + '-' + date;
        }

        function trim(input) {
            if (!input) {
                return '';
            } else {
                return input.trim();
            }
        }

        function resetModalToInitialState(currentMonth, currentDate, currentYear) {
            var enableOnlineStoreRadio = document.querySelector('#pricingFeedback_onlineRadio');
            var enableOfflineStoreRadio = document.querySelector('#pricingFeedback_offlineRadio');
            var onlineStoreInputForm = document.querySelector('#pricingFeedback_onlineInput');
            var offlineStoreInputForm = document.querySelector('#pricingFeedback_offlineInput');
            var onlineUrl = document.querySelector('#onlineUrl');
            var onlinePriceRaw = document.querySelector('#onlinePriceRaw');
            var onlineShippingRaw = document.querySelector('#onlineShippingRaw');
            var onlineDay = document.querySelector('#onlineDay');
            var onlineMonth = document.querySelector('#onlineMonth');
            var onlineYear = document.querySelector('#onlineYear');
            var onlineCalendar = document.querySelector('#onlineCalendar');
            var note1 = document.querySelector('#note1');

            var offlineStoreName = document.querySelector('#offlineStoreName');
            var offlineCity = document.querySelector('#offlineCity');
            var offlineState = document.querySelector('#offlineState');
            var offlinePriceRaw = document.querySelector('#offlinePriceRaw');
            var offlineDay = document.querySelector('#offlineDay');
            var offlineMonth = document.querySelector('#offlineMonth');
            var offlineYear = document.querySelector('#offlineYear');
            var offlineCalendar = document.querySelector('#offlineCalendar');

            var thankYouDiv = document.querySelector('#pricingFeedback_thank');
            var errorDiv = document.querySelector('#pricingFeedback_error');
            var submitButton = document.querySelector('#pricingFeedback_submit');
            var loadingGifDiv = document.querySelector('#loading');

            var stateDefaultOption = document.querySelector('#stateDefaultOption');
            var stateDefaultPrompt = document.querySelector('#stateDefaultPrompt');
            var offlineStateMain = document.querySelector('#offlineStateMain');
            var storeDefaultOption = document.querySelector('#storeDefaultOption');
            var storeDefaultPrompt = document.querySelector('#storeDefaultPrompt');
            if (thankYouDiv) {
                thankYouDiv.innerHTML = '';
            }
            if (errorDiv) {
                errorDiv.innerHTML = '';
            }
            if (loadingGifDiv) {
                loadingGifDiv.innerHTML = '';
            }
            if (submitButton) {
                submitButton.style.display = 'block';
            }
            onlineUrl.value = '';
            onlinePriceRaw.value = '';
            onlineShippingRaw.value = '';
            offlineStoreName.value = '';
            offlineCity.value = '';
            offlineState.value = '';
            offlinePriceRaw.value = '';

            stateDefaultOption.innerHTML = $("#selectProvince").val();
            stateDefaultPrompt.innerHTML = $("#selectProvince").val();

            storeDefaultOption.innerHTML = "Enter the store name where you found this product";
            storeDefaultPrompt.innerHTML = "Enter the store name where you found this product";

            setInitialStates(
                onlineMonth,
                currentMonth,
                offlineMonth,
                onlineDay,
                currentDate,
                offlineDay,
                onlineYear,
                currentYear,
                offlineYear,
                onlineStoreInputForm,
                offlineStoreInputForm,
                enableOfflineStoreRadio,
                enableOnlineStoreRadio,
                onlineCalendar,
                offlineCalendar,
                offlineStateMain,
                offlineState,
                note1
            );
        }

    });
</script> </div> </table>    </div> </div>   </div> </div> </div>     </div> </div>  </div> </div>
                               </div>
                                    <div id="postPurchaseSideSheet_feature_div" class="celwidget" data-feature-name="postPurchaseSideSheet"
                 data-csa-c-type="widget" data-csa-c-content-id="postPurchaseSideSheet"
                 data-csa-c-slot-id="postPurchaseSideSheet_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                              </div>
                                    <div id="productDocuments_feature_div" class="celwidget" data-feature-name="productDocuments"
                 data-csa-c-type="widget" data-csa-c-content-id="productDocuments"
                 data-csa-c-slot-id="productDocuments_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                             <style>
    .ask-product-docs-expander-content {
      padding-left: 0;
      margin-top: 0;
    }
  </style>

                                    </div>
                                    <div id="postPurchaseWhatsInTheBox_feature_div" class="celwidget" data-feature-name="postPurchaseWhatsInTheBox"
                 data-csa-c-type="widget" data-csa-c-content-id="postPurchaseWhatsInTheBox"
                 data-csa-c-slot-id="postPurchaseWhatsInTheBox_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                             <style>

    .postpurchase-included-components-list-item {
        word-wrap: break-word;
    }
    .postpurchase-included-components-list-group {
        margin: 0 0 1px 18px;
    }

</style>

                              </div>
                                    <div id="legal_feature_div" class="celwidget" data-feature-name="legal"
                 data-csa-c-type="widget" data-csa-c-content-id="legal"
                 data-csa-c-slot-id="legal_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                       <br/> <div class="a-box"><div class="a-box-inner"> <span class="a-declarative" data-action="a-modal" data-a-modal="{&quot;hideHeader&quot;:&quot;true&quot;,&quot;width&quot;:&quot;800&quot;,&quot;inlineContent&quot;:&quot;u003cdiv style=&quot;max-height: 500px;&quot;&gt;n        u003ch3&gt;Proposition 65 Warning for California Consumersu003c/h3&gt; u003cbr/&gt; u003ctable class=&quot;a-normal&quot;&gt;  u003ctr class=&quot;a-spacing-base&quot;&gt; u003ctd&gt;  u003ci class=&quot;a-icon a-icon-warning&quot; role=&quot;presentation&quot;&gt;u003c/i&gt;  u003c/td&gt; u003ctd&gt; u003cspan&gt;  u003cp&gt;u003cb&gt;WARNING: u003c/b&gt;Labels on and packing slips in this package can expose you to chemicals including Bisphenol S (BPS) which is known to the State of California to cause reproductive harm. For more information go to u003ca target=&quot;_blank&quot; href=&quot;https://www.P65Warnings.ca.gov&quot;&gt;www.P65Warnings.ca.govu003c/a&gt;u003c/p&gt; u003c/span&gt; u003c/td&gt; u003c/tr&gt;  u003c/table&gt; u003c/div&gt;&quot;}">  <span class="a-text-bold"> <a class="a-link-normal" href="#">WARNING</a>:
        </span> </span> California’s Proposition 65 </div></div>                                      </div>
                                    <div id="productDescription_feature_div" class="celwidget" data-feature-name="productDescription"
                 data-csa-c-type="widget" data-csa-c-content-id="productDescription"
                 data-csa-c-slot-id="productDescription_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              <div>
      <div data-feature-name="productDescription" data-template-name="productDescription" id="productDescription_feature_div" class="a-row feature">    <div class="a-divider a-divider-section"><div class="a-divider-inner"></div></div>   <h2 class="default"> Product Description  </h2>                <div id="productDescription" class="a-section a-spacing-small">          <!-- show up to 2 reviews by default -->
                       <p><?= htmlspecialchars($desc, ENT_QUOTES, 'UTF-8') ?></p>            </div>  <style type="text/css">
#productDescription {
    color: #333333;
    word-wrap: break-word;
    font-size: small;
    line-height: initial;
    margin: 0.5em 0px 0em 25px;
}

#productDescription_feature_div > h2.default {
    font-size: medium;
    margin: 0 0 0.25em;
}

#productDescription_feature_div > h2.books {
    color:#333 !important;
    font-size:21px !important;
    line-height: 1.3;
    padding-bottom: 4px;
    font-weight: normal;
    margin: 0px;
}

#productDescription_feature_div > h2.softlines {
    color:#333 !important; 
    font-size:21px !important;
    line-height: 1.3;
    padding-bottom: 4px;
    font-weight: bold;
    margin: 0px;
}
#productDescription > p, #productDescription > div, #productDescription > table {
    margin: 0 0 1em 0;
}

#productDescription p {
    margin: 0em 0 1em 1em;
}

#productDescription h3 {
    font-weight: normal;
    color: #333333;
    font-size: 1.23em;
    clear: left;
    margin: 0.75em 0px 0.375em -15px;
}

#productDescription table {
    border-collapse: inherit !important;
    margin-bottom: 0;
}

#productDescription table img {
    max-width: inherit !important;
}

#productDescription table td {
    font-size: small;
    vertical-align: inherit !important;
}

#productDescription ul li {
    margin: 0 0 0 20px;
}

#productDescription ul li ul {
    list-style-type: disc !important;
    margin-left: 20px !important;
}

#productDescription ul ul li {
    list-style-type: disc !important;
    margin-left: 20px !important;
}

#productDescription > ul ul li {
    list-style-type: disc !important;
}   


#productDescription ul li ul li {
    margin: 0 0 0 20px;
}

#productDescription .aplus p {
    margin: 0 0 1em 0;
}

#productDescription small {
    font-size: smaller;
}

#productDescription.prodDescWidth {
    max-width: 1000px
}

</style>

<!-- Used to set table width because AUI is overriding the width attribute of the tables coming in description -->
<script type="text/javascript">
P.when('jQuery').execute(function($){
    $("#productDescription table").each(function() {
        var width = $(this).attr('width');
        if (width) width += 'px';
        else width = 'auto';
        $(this).css('width', width);

        var padding = $(this).attr('cellpadding');
        if (padding) padding += 'px';
        else padding = '0px';
        $(this).css('padding', padding);
    });
});
</script>
 <style>
        #productDescription h3 {
            margin: 0.75em 0px 0.375em -1px;
        }
        </style>
             </div>  </div>

<script type="text/javascript">
    P.when('A', 'ready').execute(function(A) {
        A.on('a:expander:mobileProductDescription_expander_m:toggle:expand', function() {
            if (window && window.ue && window.ue.count) {
                window.ue.count("productDescriptionPercolateSize:desktop:m:open", 1);
            }
        });

        A.on('a:expander:mobileProductDescription_expander_m:toggle:collapse', function() {
            if (window && window.ue && window.ue.count) {
                window.ue.count("productDescriptionPercolateSize:desktop:m:close", 1);
            }
        });
    });
</script>                              </div>
                                    <div id="sponsoredProducts2_feature_div" class="celwidget" data-feature-name="sponsoredProducts2"
                 data-csa-c-type="widget" data-csa-c-content-id="sponsoredProducts2"
                 data-csa-c-slot-id="sponsoredProducts2_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                       </div>
                                    <div id="sims-themis-sponsored-products-2_feature_div" class="celwidget" data-feature-name="sims-themis-sponsored-products-2"
                 data-csa-c-type="widget" data-csa-c-content-id="sims-themis-sponsored-products-2"
                 data-csa-c-slot-id="sims-themis-sponsored-products-2_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              





                      </div>
                                    <div id="cpsiaProductSafetyWarning_feature_div" class="celwidget" data-feature-name="cpsiaProductSafetyWarning"
                 data-csa-c-type="widget" data-csa-c-content-id="cpsiaProductSafetyWarning"
                 data-csa-c-slot-id="cpsiaProductSafetyWarning_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                               <div class="celwidget c-f" cel_widget_id="dp-cpsia-product-safety-warning_DetailPage_1" data-csa-op-log-render="" data-csa-c-content-id="DsUnknown" data-csa-c-slot-id="DsUnknown-2" data-csa-c-type="widget" data-csa-c-painter="dp-cpsia-product-safety-warning-cards"><!--CardsClient--><div id="CardInstanceCZ0lJuK78srA932Tny62JA" data-card-metrics-id="dp-cpsia-product-safety-warning_DetailPage_1"></div></div>                      </div>
                                    <div id="climatePledgeFriendlyBTF_feature_div" class="celwidget" data-feature-name="climatePledgeFriendlyBTF"
                 data-csa-c-type="widget" data-csa-c-content-id="climatePledgeFriendlyBTF"
                 data-csa-c-slot-id="climatePledgeFriendlyBTF_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                    <div id="aplus_feature_div" class="celwidget" data-feature-name="aplus"
                 data-csa-c-type="widget" data-csa-c-content-id="aplus"
                 data-csa-c-slot-id="aplus_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                            </div>
                                    <div id="aplusBrandStory_feature_div" class="celwidget" data-feature-name="aplusBrandStory"
                 data-csa-c-type="widget" data-csa-c-content-id="aplusBrandStory"
                 data-csa-c-slot-id="aplusBrandStory_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="aplusSustainabilityStory_feature_div" class="celwidget" data-feature-name="aplusSustainabilityStory"
                 data-csa-c-type="widget" data-csa-c-content-id="aplusSustainabilityStory"
                 data-csa-c-slot-id="aplusSustainabilityStory_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                           </div>
                                    <div id="renewedProgramDescriptionBtf_feature_div" class="celwidget" data-feature-name="renewedProgramDescriptionBtf"
                 data-csa-c-type="widget" data-csa-c-content-id="renewedProgramDescriptionBtf"
                 data-csa-c-slot-id="renewedProgramDescriptionBtf_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                                                                 </div>
                                    <div id="similarities_feature_div" class="celwidget" data-feature-name="similarities"
                 data-csa-c-type="widget" data-csa-c-content-id="similarities"
                 data-csa-c-slot-id="similarities_feature_div" data-csa-c-asin=""
                 data-csa-c-is-in-initial-active-row="false">
                              <div cel_widget_id='sims-consolidated-5_csm_instrumentation_wrapper' class='celwidget'>
<div id='DPSims_sims-container_desktop-dp-sims_2_container' data-region-info='us-east-1'><script>(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('A', 'dram-lazy-load-widget', 'ready').execute(function(A) {A.trigger('dram:register-lazy-load-widget', '#DPSims_sims-container_desktop-dp-sims_2_container',2500, 'DPSims_desktop', true);});</script><script class='json-content' type='application/json'>{"encryptedLazyLoadRenderRequest":"AAAAAAAAAADtQioixEuT4YZUFCnXJ1gT9BMAAAAAAABFDQCoTD6a2XQ0l8TUEhMWy7T7TXE2hoMOdLqTUKjPb+7PCfgtx8vRzT6QOp0cR2qVzk/ZFi6VDsiX0qBIMOCzxp4EUkfL4dALyIr6Fro9VQu50oh5qvtI2Pe3PbwhQLww7wHOEUe90ZlbsGyXtq6GfZeV5Xnp44koooJwmmGaHnkPkA2ewpleqmhlsEndcP8lLqGIIwwG3kXoWoIIggn8ntQUfJduwRnISrmnTk2RMngnxU9bNsTr8T+F4t73jEoBHtBMRWkpxqHvU6E+N9ZGFNu5H8j+gNShKPk/Hl42UW6ewCfUjizYE+3/3VIWQbVJLFUQ30+TOMZ+5g/UEk50/DeRsDJTLVXasVN+Puedloo+TTBwEo/u2+nr6hJcXWuaYLNZye+DgNaX+DHdrHJpn3fyiRMTkvnDSDptMqJwN8PHxwqyRmX72POBlc3sVptQEvE1spOp5lXXOSUsVAO+gIqypC7ccSUuilhC4bA0BPI3noovn/HxC/4IFfobAaavdS2rpNCKbX2HtVLZE0t/DusLRSOb6pGL0tE2SXX3Cahv+8Ga3z00HmpGx2KgNSwjti3lugTO5LX9CKAvqGHLJeTNLv3XFR7YVuqFIvy+YnyF+/7eRE/02s7Zwn6ysWQSaEBeezynddDxC0l9z9rfyvrMenqYGW9lbzl3kmYl0r0JZOHnFmd0vUiW+k7BMP7HUjrYrSkdMh5G2h9PfZl3tE2KPHhl55hNIbyY+woduwWjBFyrYWnBSf3nkSh5+i4qt9ZzVNSwx6Wb8V5lpCtiYCPbRHk3qXnpLv7ggrn4UjWUsnCVOC6SZyJkBEvcxY+t0akbinWMXcuGUGnGNBcCyzLk84zBhvBLr09QRugqm8Yj0+dlEGjM4l1HqdVPQppseOCZBhTEBudJFeUFs4tUFU3P+KD7scCOKckGrnvhNFhfp1fZXNTvLfic4ANRju2mNDbRcVp2KBK3ac2nRYQX/Pn0gbFdaMj+e/7NDT3foUVvMO5x3ktp0+EYSiMwhqa2NO8zQFKceQVgYiQs6oKL34DEI5g4MmLcA+6Zj0nSarFLuZ6MAi5rk9LN1wkZp3M/JAJTw88ok8+hURC+GxiuT39OaiIE3kvK05u5XGCOpoq7Opc39QjzDVKPf5flVn0a+ZX7/DLYI9hXrU7G/FJ1iJM3Bf7hc4/t9YzVLBaBMnTfnUAUMly7LFrkw1MrE0rBAbw36Wv35lI4HAYPXOAuUhPzA+nUJfC79ADQQJfxhc0e1c/7erEElwgp/bWWKCkS4ZlbVef9TWnPxzGVeCB3a9IOYnyvmbZjcsURdqxTk7SHVZ1PHxKWvaC8XA/cdkgaPxIgJGXxX1onOJ+nQHsVzhHo3+Lb8sSnPK+QygH5MjQcSDGAK0ssigf0nmqC8fsDSc8oNv/IP+y6jxMXITERIOHvbqvWzPAxh9g1iSyyvvf4nsmGy6lrDq1b140NIRN4//PEnpz+pJDgvgzuvN+RyMnTmZfI4bbqtbuPmzefL09R0h4tjmK6yx8Ysyift/SWsWdmiCiaYMzeqkOry7Q0cxUkXiAqIg1bMeGqUNPnWTqTiNXBDdVb2J2LjbDWs3O3fqfhrFlXcd4kjNVvwbg4XFtssTQVG55OwmvtxpqVxypTzjqjqEm+I6dB/hAJxv1Ai+gw8bKOfTEyjAl00ohOvLZ5MU150FYvNMxW5j0G8XraIEuzYrogWjUArR2FlifmHjk0vTK1yqIU/K4Ypn1gPHwW+f358tIZnDVN+61OProT1LekA12l7bwFfrxvFoVz4T7NUybUBivXgsDGT1iDv92F/+K8YG7zDdIUXDE3zM020zlL+ejH/H7Vp8IN/u0pCIt6+1G/uYFmPzMZX/RFCOs7fuwMVkxHAURulVQMQf42W4pzbXhNBqmEy+6YCIBZhJ7oBd9ydLTHWXVVogVmZsIdU5BLl2+tKDDtFP5zgwYczLQUTNiKfxdgwWg246BczphEnrGGQ+DSX/bJZxk02AKCpAzuOBcnYVdiyYesWJWrRMAe+lwWGMEQjq+2C+hP6UW16VhwCOGh85kBpkovNFbKY9eRnBgLbdliPL4mlRuyV6YTRTBE0mOiHAUvvu29Cg6Xv0mG2yJNjpKei+S50hQG2EuJdDBAD8dJMjMA1grxrHf6cAti2FZq/GiVaA6XME9vHfMAPlXuHn/gJ0B0XhTuW83E3QV/tkGqbuAZ+LhcuKDEE7f54lhsXvsE2T3GGAnYG7n718pdqy3s+3UH6VH1638ENSHX0dRVucgOZG/BVX/20hYaUaxCyLy9mGdqBvlqyPVFLpEe3xRCFscDJHqQ8T5KDUBX1Rx+x1oNIsg83S2kYkm4axHHeO0U4Ap/99sg8EP0imQ/wNZRk66Tuljhwugo6F/l2cWSClIE2qZXIRp93PXBIXO6p3tdWqbUxbYD1rfQIkt/gRiJspriPFo3ng+V3pia9LnxBKyne/Or+4iBjZF4JPPsswQebqVPztGK586mIonF6volFS0+X9h1CtaW7wO4pz9WIflvzJY5dOWY5LpRX0/ljtBE7tqg4Tc//JTH+h/tt6Ba37/n29frvZxyHo8aIwlHdxguldBrz/DKcsmxO5T0qO8SnL1TckmwJUV1/eW8f8oEjoo7dQyn7uQVORz4yeDeF8PbeoewDsnh/KalChhGpLjcMmMnOPj/N+dzcMbr3hmPampl70yCil3TUohqWRgmPxABAxSgzbEuUV421aRS1CJt0fFdhCxfM369kpynBrObEKhvusymA8FMokV0l+Wr2/oCTGT1GoZ7niHd0va4r8LjcmW+bBOoQRh4W5/6n3rB0I9VZJkgmhbHA917ttwXXQV3iDelHz4B3W8P9idonHBTPJLa0mAwdQsbzQZ532E0wxAUP8OhQEDvLf+TOHc3qA5U0bcCqsdEY1O7iH76ZEU3wRSrp2Zbz83XT0IbE4zEBqqz7G6PwGlyGbsqP/TpJYiY0Sus/CgfD79xf9SgWeAgs8dWL15ny0Vh2xfM+JjyGg9YNRhKhX2pMbqeq5yx34vnYVGU5L8VMuA9n97xdo/70+PVkpiobeSXS1pFpstIegMgoycTXBVrfgMtaL0DeY4Q08KCSkW+lURr0tbLmNdrejPHZKsXQ4y/IqDNeWdsWZoaxuVGM2TischvaRpb79KkSzatK4TpXyAIlbOthFWILLtp8DjRCDh/bHRDMdElQUbIqjYAh4jKQYQA8UwDybjBEDYU78slL7bvkNLhEqZ5PfYW3TaFnxNFLsS35e4gW66Mjv4QCb/Xh2Xc7EFnQWy/O4wyP8zRPhLFVl8Jhmsl+f3/55wB693txeX3ntyBX06lc1EM7ERGmwuHkFjv+a1ShWYEkknQtdM5NR2Rkip9DZJr/Bd1z0sWcSZPP8VTWP0YmxnSt96/IaLW09kMXnSY6By+y2VanPAderP7V4EKQWDDRZROrYhHdvesyexMb0gUs8rcFU+4+h+AkhF4evVU3spqADcSN8ghaep04nkeFLoG1dnsb+1FImXZ4zl6M9zHNnPx11GyFW08iUBfPczubaq+rdQA9y7WLh7Q9BHHguJDqvYc4rdPF/Z+BVDlHn485xdw/dZd3VpMErjum20Vrhldu5nonKJl20L2RtHYt4ykop0QTDMYibHovA8P8SUPzyNeuGP7yYIeXMtCxILLCYgQl4Hcp2/3gfqQhoNT8XWHbolgdhMiVyQ0xQ3hYyKl7iQIErfRxSxG27N7eeFEgrGKwM8SykPGRdlDwcbk8WlBOWl0Pr9E/4Fq/VfEHC6asvFxkJhnuErODKyPzCi7RKOuO59CBRS08GMIrFza7YJiKah20GDhwCvbcPgVxnsOIEsxuXHvQ2mqQg9LOX75iYFKH8IvMbtTPptwoTW+MKSfKVFjCEIIcxRDGX/nots/vQxHa1BVsYiJ5vBGc8vMz2uOLhgemo8mBr1zNgoETYpd7CvU8PXaTdM/N/ZRddclWp5PLBtc96uH60EUjeSVE3N87VNvZ+5qKaeBLoOlh2td8c1k1zOMdSezi0giKi3ICBMg91nG7jSX3IWWZj+MfpHZdsQ+A79LzTwu8TqJR4tGGHXOWhvOyh5WPjE5HXZhCsgS8HYTCMhWXBtf18tXJHOPUu0mVjWGUtyI9ED+1w9Xpa/gH5bGE0mOEZ39tMRWzmXWRm7kDd0FXiJcZ/WAMtEtiiwpTOFGMofsxv25qDeBm9A1BPkCXIN0LFQ5HCP2Emsh+opFsYyOv4yOqNYYRfPv8dAOaG03B8ucU/o5n4RXMsfua+MVvKalVCmBVfPwZ0+H7xssIMBCKnW551mAksehR2TSbz0VU3w4YmV3SD9t2GxbgurexdECZ6dVl/BpSDnMAmIz4XSHI8KLQpNsaN16KtLIyFDWc6LLf8CaLLYzY+Ymx80R/VttTja7HAzGslfdNgjOlw9riYFEp/zmoTwFVEBtHZQDxM/WbJYxFj7i95EaoY8YRjhdZRZ6WMim/QXRWHyOk9+ntCPWedFbVSLKQUD07KhVqIPlJjlU/v5/s/4oOC8uV2ZQTGny1M/rUI292iUZM3/7dkJkmNhAHTFyy8C9h2c+Rq6y/aTgf68zYn0SEucUKKmLKOC2ItlLkopvEyX4zzM6iE5vn431j5h3zIe3WxJQpIJ2eWQbN5m/TPjXV8AndpE5EFStoF2x4TdbJAfBT8lALZ7/+cV+QAhK18McD2uu/Nj5AoBzXnxsnIoHS2mIt8yyFKMYTOZNywBvQ6EsfKYJIaXXrXL3YA8PTLXxvsIV97qIcRZL+c+nhLfo8MhsCvlccYXP/ViGQPAmIdwrIfaIEbXUsp3KWjSKG9wKxMSPREEfGrYsOyMArzMEneF49wPksuWpE7DJVgvCjrdUjHOAuGDqHx8HSOWgar1MLbPR5AYSg3xIJCUvcyulMVHQANE4UlAHDe2qPTxxQRFsDwAv0WuU55CCEw1iqQh7Q6SzkgtLeqRO4MIy/Ib03RxvVsNVIwNPDFzrjmI0LGwMk5vcRyAO6yU8clhVttIkh2eVb3nMnATXdXEgMkaXjnwxmNlm2S5u/gp/CHOyBcaU9aZ3fKKzcAHUWc+FT+Nb+kxnEVibRiCwdcA7h9tQcUjTQlBbQas8rZfHmkrt1K9ztRB2EjpB8GJoAUd13buczAxuiVFZhK2zNayLh5i7BBrVaJwTsgcXNTvaG43fht/sjEkoKf+OBFuz6JZSzjltQxarcZSw906klqkVRTRTC6gobV3GKGCJmhzhcQDazF/r/GIYX3hKfmFfyHLRg4C406FIa/3rfvXnM/hAg3YOc72FFmyC1yTTK+nXyrwE314+5Be7RwNWE/BN8QUR0lqYK/W8NxborOXn0MKrweklAuMfbqXc/DxxOEOlTVUx2D0FwLXws9dqetf1u/oolXUmsuBKrtCCZPqiIXBb7DxVwmyXiuNxJ1NDCSthlifkjhLxhHyZgmrObS7t50Pxfx/BBnILKRgTNbTVj+xXz2P9so/9L2UAD0DaWHib4otLceBd8r8sUazlaJUyUcmT8QD4l8/y7vRuRXMTsyHGL1KFscmPSmFPBXG7K3fPAEA9xzOsD86xJB3zDAQVOXea3AjA5U26B54G+YhkG6CfGVGMm4Gnu4mcXVJ8D07mWV7LVYQLdqzUbmGEl8N1E9dnIiU5wJJcT/qZDJjCmqMB7xKeqLJvqXg7GgN4CbAMaDq8PhVuRTrY/ust2XuQt725O9JYJ86lEQxInCy8IDd7za3GPxIkeJzaeik2joN42NX9zKlCH52ZW2zSCFcGpYQbMBx575HCdFbD62OHlBw8ARtmLw14QQjoihx5vAxk6Q5c8ak8hh/F5WYM9XrjhFz5D3/mXJ1Qc7T0kVcAijFe+HWYl+MxMlJMROH/VNcee/GBJjvRn6FKANokgR0WErNW4P7AJWIt5ABf+8WLbn5OfsDECsOoZ8quf7DxMadbbZANMhZk0hrgHexXEDE89aOUNtOHp8d9x1i69pp85jNoWeNt44iL/MWc96ppypdlI4+rSFFb7Rh6xoav6w2vGQbm7b3R+JbZkC9oaNaFwWumNm1pC3i49n+tiJxFwOrx2ZKpPkBH3p8oO5KazOKYawOeGhj2Gx3WQB/pqefqpvpr9G9miqjaM/Mc2tKUXnWLX8GOXfEu12sKGxnVKmvL5pccy1D72FCCHFL9V7efoUW05QqcoY1xBaw4xsTIwT5L3rCJzh/VolQaJJqWNYf0TfMRFtLNKbWLPl8BwUKQPzGf7gyn1rDkVdGhgtq43XWdjuatzFvcvXJ/JD8R0wqPY0tJ0PhlW9EksTo5/c0oHzxYkOPSPzEIdY1sGLE8WsQ1/EDgzHsaFYleCKwQRBpaq8lr0x1XKIC9NUoKysiz7ag+kWHsJhX3lT9V3kAq2NvFa6aeJrIfd/9Bk0tmsoQibCOwxFz6Jb4hVXyVx1i+a/K6g50WfCCyj7FAFAE+oDXDN7CxHaq/YCbqfJETQ4rZocpQukwIneJSa5mw+Fccw/wO//rD6M0Ncr6hl4yui/vrmpOnXJTMleJEajCioSK0ofLNCyZGA4cdxucakFowm9kpTImapdKtCDgUZZXtVubErNM03iDR/L3O1ZEgObeEQzKSkqM8izyfu/ywNGagXePaKaYRyNSAa2dAlKmFNw1fyBAgj5sk/1pmhgCYFpTcepgGC0k6WkAGtjaF4Wk9BnagxotVbIbMHy91xmAleWV54WAqNdKeaTGL6BIAo/j+///UJSaAYmLI7EqJrM1iGYSVocFOccrr1P0Tn3uiBwPy7wkB7g=="}</script><div class='widget-html-container'><div style='height: 350px;'><span class='lazy-load-spinner'></span></div></div></div><link rel="stylesheet" href="https://images-na.ssl-images-amazon.com/images/I/01FvA6+tfcL.css?AUIClients/DramAssets" />
<script>
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://images-na.ssl-images-amazon.com/images/I/01A+UY71QeL.js?AUIClients/DramAssets');
</script>



</div>

                      </div>
                                    

  </div>
    </div>

<!-- htmlEndMarker -->














<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/21ce4PfVwbL.js?AUIClients/" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('dpJsAssetsLoadMarker').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/21ce4PfVwbL.js?AUIClients/');
});
</script>
<!-- sp:end-feature:host-btf -->
<!-- sp:feature:aui-preload -->
<!-- sp:end-feature:aui-preload -->
<!-- sp:feature:nav-footer -->

  <!-- NAVYAAN FOOTER START -->
  <!-- WITH MOZART -->

<div id='rhf' class='copilot-secure-display' style='clear: both;' role='complementary' aria-label='Your recently viewed items and featured recommendations'> <div class='rhf-frame' style='display: none;'> <br> <div id='rhf-container'> <div class='rhf-loading-outer'> <table class='rhf-loading-middle'> <tr> <td class='rhf-loading-inner'> <img src='https://m.media-amazon.com/images/G/01/personalization/ybh/loading-4x-gray._CB485916920_.gif'> </td> </tr> </table> </div> <div id='rhf-context'> <script type='application/json'> { "rhfHandlerParams":{"currentPageType":"Detail","currentSubPageType":"Glance","excludeAsin":"B034368592","fieldKeywords":"","k":"","keywords":"ps4","search":"","auditEnabled":"","previewCampaigns":"","forceWidgets":"","searchAlias":""} } </script> </div> </div> <noscript> <div class='rhf-border'> <div class='rhf-header'> Your recently viewed items and featured recommendations </div> <div class='rhf-footer'> <div class='rvi-container'> <div class='ybh-edit'> <div class='ybh-edit-arrow'> &#8250; </div> <div class='ybh-edit-link'> <a href='/gp/history'> View or edit your browsing history </a> </div> </div> <span class='no-rvi-message'> After viewing product detail pages, look here to find an easy way to navigate back to pages you are interested in. </span> </div> </div> </div> </noscript> <div id='rhf-error' style='display: none;'> <div class='rhf-border'> <div class='rhf-header'> Your recently viewed items and featured recommendations </div> <div class='rhf-footer'> <div class='rvi-container'> <div class='ybh-edit'> <div class='ybh-edit-arrow'> &#8250; </div> <div class='ybh-edit-link'> <a href='/gp/history'> View or edit your browsing history </a> </div> </div> <span class='no-rvi-message'> After viewing product detail pages, look here to find an easy way to navigate back to pages you are interested in. </span> </div> </div> </div> </div> <br> </div> </div>   <section class="content-detail" style="padding: 20px; border: 1px solid #e1e1e1; border-radius: 5px; max-width: 800px; margin: 20px auto;"></a></section>
<div class="navLeftFooter nav-sprite-v1" id="navFooter">

<a id="navBackToTop" aria-label="Back to top" role="button">
  <div class="navFooterBackToTop">
  <span class="navFooterBackToTopText">
    Back to top
  </span>
  </div>
</a>

  
<div class="navFooterVerticalColumn navAccessibility" role="presentation">
  <div class="navFooterVerticalRow navAccessibility">
        <div class="navFooterLinkCol navAccessibility">
          <div class="navFooterColHead" role="heading" aria-level="6">Get to Know Us</div>
        <ul>
            <li class="nav_first">
              <a href="https://www.amazon.jobs" class="nav_a">Careers</a>
            </li>
            <li >
              <a href="https://blog.aboutamazon.com/?utm_source=gateway&utm_medium=footer" class="nav_a">Blog</a>
            </li>
            <li >
              <a href="https://www.aboutamazon.com/?utm_source=gateway&utm_medium=footer" class="nav_a">About Amazon</a>
            </li>
            <li >
              <a href="https://www.amazon.com/ir" class="nav_a">Investor Relations</a>
            </li>
            <li >
              <a href="/gp/browse.html?node=2102313011&ref_=footer_devices" class="nav_a">Amazon Devices</a>
            </li>
            <li class="nav_last ">
              <a href="https://www.amazon.science" class="nav_a">Amazon Science</a>
            </li>
        </ul>
      </div>
        <div class="navFooterColSpacerInner navAccessibility"></div>
        <div class="navFooterLinkCol navAccessibility">
          <div class="navFooterColHead" role="heading" aria-level="6">Make Money with Us</div>
        <ul>
            <li class="nav_first">
              <a href="https://services.amazon.com/sell.html?ld=AZFSSOA&ref_=footer_soa" class="nav_a">Sell products on Amazon</a>
            </li>
            <li >
              <a href="https://services.amazon.com/amazon-business.html?ld=usb2bunifooter&ref_=footer_b2b" class="nav_a">Sell on Amazon Business</a>
            </li>
            <li >
              <a href="https://developer.amazon.com" class="nav_a">Sell apps on Amazon</a>
            </li>
            <li >
              <a href="https://affiliate-program.amazon.com/" class="nav_a">Become an Affiliate</a>
            </li>
            <li >
              <a href="https://advertising.amazon.com/?ref=ext_amzn_ftr" class="nav_a">Advertise Your Products</a>
            </li>
            <li >
              <a href="/gp/seller-account/mm-summary-page.html?ld=AZFooterSelfPublish&topic=200260520&ref_=footer_publishing" class="nav_a">Self-Publish with Us</a>
            </li>
            <li >
              <a href="https://go.thehub-amazon.com/amazon-hub-locker" class="nav_a">Host an Amazon Hub</a>
            </li>
            <li class="nav_last nav_a_carat">
              <span class="nav_a_carat" aria-hidden="true">›</span><a href="/b/?node=18190131011&ld=AZUSSOA-seemore&ref_=footer_seemore" class="nav_a">See More Make Money with Us</a>
            </li>
        </ul>
      </div>
        <div class="navFooterColSpacerInner navAccessibility"></div>
        <div class="navFooterLinkCol navAccessibility">
          <div class="navFooterColHead" role="heading" aria-level="6">Amazon Payment Products</div>
        <ul>
            <li class="nav_first">
              <a href="/dp/B07984JN3L?plattr=ACOMFO&ie=UTF-8" class="nav_a">Amazon Business Card</a>
            </li>
            <li >
              <a href="/gp/browse.html?node=16218619011&ref_=footer_swp" class="nav_a">Shop with Points</a>
            </li>
            <li >
              <a href="/dp/B0CHTVMXZJ?th=1?ref_=footer_reload_us" class="nav_a">Reload Your Balance</a>
            </li>
            <li class="nav_last ">
              <a href="/gp/browse.html?node=388305011&ref_=footer_tfx" class="nav_a">Amazon Currency Converter</a>
            </li>
        </ul>
      </div>
        <div class="navFooterColSpacerInner navAccessibility"></div>
        <div class="navFooterLinkCol navAccessibility">
          <div class="navFooterColHead" role="heading" aria-level="6">Let Us Help You</div>
        <ul>
            <li class="nav_first">
              <a href="/gp/help/customer/display.html?nodeId=GDFU3JS5AL6SYHRD&ref_=footer_covid" class="nav_a">Amazon and COVID-19</a>
            </li>
            <li >
              <a href="https://www.amazon.com/gp/css/homepage.html?ref_=footer_ya" class="nav_a">Your Account</a>
            </li>
            <li >
              <a href="https://www.amazon.com/gp/css/order-history?ref_=footer_yo" class="nav_a">Your Orders</a>
            </li>
            <li >
              <a href="/gp/help/customer/display.html?nodeId=468520&ref_=footer_shiprates" class="nav_a">Shipping Rates & Policies</a>
            </li>
            <li >
              <a href="/gp/css/returns/homepage.html?ref_=footer_hy_f_4" class="nav_a">Returns & Replacements</a>
            </li>
            <li >
              <a href="/gp/digital/fiona/manage?ref_=footer_myk" class="nav_a">Manage Your Content and Devices</a>
            </li>
            <li class="nav_last ">
              <a href="/gp/help/customer/display.html?nodeId=508510&ref_=footer_gw_m_b_he" class="nav_a">Help</a>
            </li>
        </ul>
      </div>
  </div>
</div>
<div class="nav-footer-line"></div>

  <div class="navFooterLine navFooterLinkLine navFooterPadItemLine">
    <span>
      <div class="navFooterLine navFooterLogoLine">
        <a  aria-label="Amazon US Home"   lang="en"  href="/?ref_=footer_logo">
        <div class="nav-logo-base nav-sprite"></div>
        </a>
      </div>
</span>
    
      <span class="icp-container-desktop"><div
          class="navFooterLine">
  <style type="text/css">
    #icp-touch-link-language { display: none; }
  </style>
  
  
  <a href="/customer-preferences/edit?ie=UTF8&preferencesReturnUrl=%2F&ref_=footer_lang" aria-label="Choose a language for shopping. Current selection is English. " aria-owns="nav-flyout-icp-footer-flyout" class="icp-button" id="icp-touch-link-language">
    <div class="icp-nav-globe-img-2 icp-button-globe-2"></div><span class="icp-color-base">English</span><button class="nav-arrow icp-up-down-arrow" aria-controls="nav-flyout-icp-footer-flyout" aria-label="Expand to Change Language or Country"></button>
  </a>
  
  
  
<style type="text/css">
  #icp-touch-link-cop { display: none; }
</style>

<a href="/customer-preferences/edit?ie=UTF8&ref_=footer_cop&preferencesReturnUrl=%2FPlayStation-Pro-1TB-Limited-Console-4%2Fdp%2FB030252457%2Fref%3Dsr_1_16" class="icp-button" id="icp-touch-link-cop">
  <span class="icp-currency-symbol">$</span><span class="icp-color-base">USD - U.S. Dollar</span>
</a>

<style type="text/css">
#icp-touch-link-country { display: none; }
</style>
<a href="/customer-preferences/country?ie=UTF8&preferencesReturnUrl=%2F&ref_=footer_icp_cp" role="button" aria-label="Choose a country/region for shopping. The current selection is United States." class="icp-button" id="icp-touch-link-country">
  <span class="icp-flag-3 icp-flag-3-us"></span><span class="icp-color-base">United States</span>
</a>
</div></span>
    
  </div>
  
  
  <div class="navFooterLine navFooterLinkLine navFooterDescLine" role="navigation" aria-label="More on Amazon">
    <div class="navFooterMoreOnAmazon navFooterMoreOnAmazonWrapper" aria-label="More on Amazon">
      <ul>
<li class="navFooterDescItem"><a href=https://music.amazon.com?ref=dm_aff_amz_com class="nav_a"><h5 class="navFooterDescItem_heading">Amazon Music</h5><span class="navFooterDescText">Stream millions<br>of songs</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://advertising.amazon.com/?ref=footer_advtsing_amzn_com class="nav_a"><h5 class="navFooterDescItem_heading">Amazon Ads</h5><span class="navFooterDescText">Reach customers<br>wherever they<br>spend their time</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.6pm.com class="nav_a"><h5 class="navFooterDescItem_heading">6pm</h5><span class="navFooterDescText">Score deals<br>on fashion brands</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.abebooks.com class="nav_a"><h5 class="navFooterDescItem_heading">AbeBooks</h5><span class="navFooterDescText">Books, art<br>& collectibles</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.acx.com/ class="nav_a"><h5 class="navFooterDescItem_heading">ACX </h5><span class="navFooterDescText">Audiobook Publishing<br>Made Easy</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://sell.amazon.com/?ld=AZUSSOA-footer-aff&ref_=footer_sell class="nav_a"><h5 class="navFooterDescItem_heading">Sell on Amazon</h5><span class="navFooterDescText">Start a Selling Account</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.veeqo.com/?utm_source=amazon&utm_medium=website&utm_campaign=footer class="nav_a"><h5 class="navFooterDescItem_heading">Veeqo</h5><span class="navFooterDescText">Shipping Software<br>Inventory Management</span></a></li></ul>

<ul>
<li class="navFooterDescItem"><a href=/business?ref_=footer_retail_b2b class="nav_a"><h5 class="navFooterDescItem_heading">Amazon Business</h5><span class="navFooterDescText">Everything For<br>Your Business</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=/gp/browse.html?node=230659011&ref_=footer_amazonglobal class="nav_a"><h5 class="navFooterDescItem_heading">AmazonGlobal</h5><span class="navFooterDescText">Ship Orders<br>Internationally</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://aws.amazon.com/what-is-cloud-computing/?sc_channel=EL&sc_campaign=amazonfooter class="nav_a"><h5 class="navFooterDescItem_heading">Amazon Web Services</h5><span class="navFooterDescText">Scalable Cloud<br>Computing Services</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.audible.com class="nav_a"><h5 class="navFooterDescItem_heading">Audible</h5><span class="navFooterDescText">Listen to Books & Original<br>Audio Performances</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.boxofficemojo.com/?ref_=amzn_nav_ftr class="nav_a"><h5 class="navFooterDescItem_heading">Box Office Mojo</h5><span class="navFooterDescText">Find Movie<br>Box Office Data</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.goodreads.com class="nav_a"><h5 class="navFooterDescItem_heading">Goodreads</h5><span class="navFooterDescText">Book reviews<br>& recommendations</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.imdb.com class="nav_a"><h5 class="navFooterDescItem_heading">IMDb</h5><span class="navFooterDescText">Movies, TV<br>& Celebrities</span></a></li></ul>

<ul>
<li class="navFooterDescItem"><a href=https://pro.imdb.com?ref_=amzn_nav_ftr class="nav_a"><h5 class="navFooterDescItem_heading">IMDbPro</h5><span class="navFooterDescText">Get Info Entertainment<br>Professionals Need</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://kdp.amazon.com class="nav_a"><h5 class="navFooterDescItem_heading">Kindle Direct Publishing</h5><span class="navFooterDescText">Indie Digital & Print Publishing<br>Made Easy
</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://videodirect.amazon.com/home/landing class="nav_a"><h5 class="navFooterDescItem_heading">Prime Video Direct</h5><span class="navFooterDescText">Video Distribution<br>Made Easy</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.shopbop.com class="nav_a"><h5 class="navFooterDescItem_heading">Shopbop</h5><span class="navFooterDescText">Designer<br>Fashion Brands</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.woot.com/ class="nav_a"><h5 class="navFooterDescItem_heading">Woot!</h5><span class="navFooterDescText">Deals and <br>Shenanigans</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.zappos.com class="nav_a"><h5 class="navFooterDescItem_heading">Zappos</h5><span class="navFooterDescText">Shoes &<br>Clothing</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://ring.com class="nav_a"><h5 class="navFooterDescItem_heading">Ring</h5><span class="navFooterDescText">Smart Home<br>Security Systems
</span></a></li></ul>

<ul>
<li class="navFooterDescItem" aria-hidden="true">&nbsp;</li>
<li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://eero.com/ class="nav_a"><h5 class="navFooterDescItem_heading">eero WiFi</h5><span class="navFooterDescText">Stream 4K Video<br>in Every Room</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://blinkforhome.com/?ref=nav_footer class="nav_a"><h5 class="navFooterDescItem_heading">Blink</h5><span class="navFooterDescText">Smart Security<br>for Every Home
</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://shop.ring.com/pages/neighbors-app class="nav_a"><h5 class="navFooterDescItem_heading">Neighbors App </h5><span class="navFooterDescText"> Real-Time Crime<br>& Safety Alerts
</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=/gp/browse.html?node=14498690011&ref_=amzn_nav_ftr_swa class="nav_a"><h5 class="navFooterDescItem_heading">Amazon Subscription Boxes</h5><span class="navFooterDescText">Top subscription boxes – right to your door</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem"><a href=https://www.pillpack.com class="nav_a"><h5 class="navFooterDescItem_heading">PillPack</h5><span class="navFooterDescText">Pharmacy Simplified</span></a></li><li class="navFooterDescSpacer" aria-hidden="true" style="width: 3%"></li>
<li class="navFooterDescItem" aria-hidden="true">&nbsp;</li>
</ul>

    </div>
  </div>

  
<div class="navFooterLine navFooterLinkLine navFooterPadItemLine navFooterCopyright">
  <ul><li class="nav_first"><a href="/gp/help/customer/display.html?nodeId=508088&ref_=footer_cou" id="" class="nav_a">Conditions of Use</a> </li><li ><a href="/gp/help/customer/display.html?nodeId=468496&ref_=footer_privacy" id="" class="nav_a">Privacy Notice</a> </li><li ><a href="/gp/help/customer/display.html?ie=UTF8&nodeId=TnACMrGVghHocjL8KB&ref_=footer_consumer_health_data_privacy" id="" class="nav_a">Consumer Health Data Privacy Disclosure</a> </li><li class="nav_last"><a href="/privacyprefs?ref_=footer_iba" id="" class="nav_a">Your Ads Privacy Choices</a> </li></ul><span>© 1996-2025, Amazon.com, Inc. or its affiliates</span>
</div>

  
</div>
<div id="sis_pixel_r2" aria-hidden="true" style="height:1px; position: absolute; left: -1000000px; top: -1000000px;"></div><script>(function(a,b){a.attachEvent?a.attachEvent("onload",b):a.addEventListener&&a.addEventListener("load",b,!1)})(window,function(){setTimeout(function(){var el=document.getElementById("sis_pixel_r2");el&&(el.innerHTML='<iframe id="DAsis" src="//s.amazon-adsystem.com/iu3?d=amazon.com&slot=navFooter&a2=0101595a8e7038aea280f1019a328bd58c6ef2944f0f4b440424a266667f4e7b6a99&old_oo=0&ts=1743452479663&s=AbQyAjkL3ajAVfWrhQSkGqrOwco-4thUSyG2XW_19PZW&gdpr_consent=&gdpr_consent_avl=&cb=1743452479663" width="1" height="1" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" tabindex="-1" sandbox></iframe>');var event=new Event("SISPixelCardLoaded");document.dispatchEvent(event);},300)});</script>

  <!-- NAVYAAN FOOTER END -->

<!-- sp:end-feature:nav-footer -->
<!-- sp:feature:configured-sitewide-assets -->
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('afterLoad').execute(function() {
(function(e,d,f){f=function(){};var k=e.ue||{},m=function(c){return function(){try{return c.apply(this,arguments)}catch(b){l(b,"FATAL")}}},l=function(c){return function(b,a){a||(a="ERROR");b=b&&b.stack&&b.message?b:JSON.stringify(b);c({logLevel:a,attribution:"EdgeRECONAssets",message:b})}}(e.ueLogError||f);(function(c){return function(b,a){c("EdgeRECONAssets:"+b,a)}})(k.count||f)("registered",1);var g=function(){try{var c=d.createElement("link").relList.supports("preload")}catch(b){c=!1}return function(b){var a=
c?d.createElement("link"):new Image;a.onerror=a.onload=m(function(){a&&a.parentElement&&a.parentElement.removeChild(a)});c?(a.rel="preload",a.as="image",a.referrerPolicy="strict-origin-when-cross-origin",a.href=b,d.head.appendChild(a)):(a.style.display="none",a.referrerPolicy="strict-origin-when-cross-origin",a.src=b,d.documentElement.appendChild(a))}}(),h="https://redirect.prod.experiment.routing.cloudfront.aws.a2z.com/x.png?timestampx3d"+(new Date).getTime().toString();"loading"!==d.readyState?
setTimeout(g,1E3,h):e.addEventListener&&e.addEventListener("DOMContentLoaded",function(){setTimeout(g,1E3,h)})})(window,document);
});
</script>
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/718qtaGVEXL._RC|11YzfZWkQgL.js,01wcltxKR5L.js,41FbfgEBSXL.js_.js?AUIClients/QTipsMobileWebAssets#us.672498-T1" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('afterLoad').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/718qtaGVEXL._RC|11YzfZWkQgL.js,01wcltxKR5L.js,41FbfgEBSXL.js_.js?AUIClients/QTipsMobileWebAssets#us.672498-T1');
});
</script>
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/212uzsmnppL.js?AUIClients/StarlingInterestGroupAssignment" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('afterLoad').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/212uzsmnppL.js?AUIClients/StarlingInterestGroupAssignment');
});
</script>
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/41TOmhTuK7L.js?AUIClients/AmazonLightsaberPageAssets" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('afterLoad').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/41TOmhTuK7L.js?AUIClients/AmazonLightsaberPageAssets');
});
</script>
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/11RhjigBo3L.js?AUIClients/WebFlowIngressJs" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('afterLoad').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/11RhjigBo3L.js?AUIClients/WebFlowIngressJs');
});
</script>
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/21vARlfe4pL._RC|11WTF6kPMoL.js_.js?AUIClients/ARARegisterTriggerSubAssets-dpv" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('afterLoad').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/21vARlfe4pL._RC|11WTF6kPMoL.js_.js?AUIClients/ARARegisterTriggerSubAssets-dpv');
});
</script>
<!-- sp:end-feature:configured-sitewide-assets -->
<!-- sp:feature:customer-behavior-js -->
<script type="text/javascript">if (window.ue && ue.tag) { ue.tag('FWCIMEnabled'); }</script>
<link rel="preload" as="script" crossorigin="anonymous" href="https://m.media-amazon.com/images/I/71EOqyQDjOL.js?AUIClients/FWCIMAssets" />
<script>
(window.AmazonUIPageJS ? AmazonUIPageJS : P).when('afterLoad').execute(function() {
  (window.AmazonUIPageJS ? AmazonUIPageJS : P).load.js('https://m.media-amazon.com/images/I/71EOqyQDjOL.js?AUIClients/FWCIMAssets');
});
</script>
<!-- sp:end-feature:customer-behavior-js -->
<!-- sp:feature:csm:body-close -->
<div id='be' style="display:none;visibility:hidden;"><form name='ue_backdetect' action="get"><input type="hidden" name='ue_back' value='1' /></form>


<script type="text/javascript">
window.ue_ibe = (window.ue_ibe || 0) + 1;
if (window.ue_ibe === 1) {
(function(e,c){function h(b,a){f.push([b,a])}function g(b,a){if(b){var c=e.head||e.getElementsByTagName("head")[0]||e.documentElement,d=e.createElement("script");d.async="async";d.src=b;d.setAttribute("crossorigin","anonymous");a&&a.onerror&&(d.onerror=a.onerror);a&&a.onload&&(d.onload=a.onload);c.insertBefore(d,c.firstChild)}}function k(){ue.uels=g;for(var b=0;b<f.length;b++){var a=f[b];g(a[0],a[1])}ue.deffered=1}var f=[];c.ue&&(ue.uels=h,c.ue.attach&&c.ue.attach("load",k))})(document,window);


if (window.ue && window.ue.uels) {
        var cel_widgets = [ { "c":"celwidget" },{ "s":"#nav-swmslot > div", "id_gen":function(elem, index){ return 'nav_sitewide_msg'; } },{ "c":"feature" },{ "id":"detail-ilm_div" } ];

                ue.uels("https://images-na.ssl-images-amazon.com/images/I/216YVwoRFDL.js");
}
var ue_mbl=ue_csm.ue.exec(function(h,a){function s(c){b=c||{};a.AMZNPerformance=b;b.transition=b.transition||{};b.timing=b.timing||{};if(a.csa){var d;b.timing.transitionStart&&(d=b.timing.transitionStart);b.timing.processStart&&(d=b.timing.processStart);d&&(csa("PageTiming")("mark","nativeTransitionStart",d),csa("PageTiming")("mark","transitionStart",d))}h.ue.exec(t,"csm-android-check")()&&b.tags instanceof Array&&(c=-1!=b.tags.indexOf("usesAppStartTime")||b.transition.type?!b.transition.type&&-1<
b.tags.indexOf("usesAppStartTime")?"warm-start":void 0:"view-transition",c&&(b.transition.type=c));n=null;"reload"===e._nt&&h.ue_orct||"intrapage-transition"===e._nt?u(b):"undefined"===typeof e._nt&&f&&f.timing&&f.timing.navigationStart&&a.history&&"function"===typeof a.History&&"object"===typeof a.history&&a.history.length&&1!=a.history.length&&(b.timing.transitionStart=f.timing.navigationStart);p&&e.ssw(q,""+(b.timing.transitionStart||n||""));c=b.transition;d=e._nt?e._nt:void 0;c.subType=d;a.ue&&
a.ue.tag&&a.ue.tag("has-AMZNPerformance");e.isl&&a.uex&&a.uex("at","csm-timing");v()}function w(c){a.ue&&a.ue.count&&a.ue.count("csm-cordova-plugin-failed",1)}function t(){return a.cordova&&a.cordova.platformId&&"android"==a.cordova.platformId}function u(){if(p){var c=e.ssw(q),a=function(){},x=e.count||a,a=e.tag||a,k=b.timing.transitionStart,g=c&&!c.e&&c.val;n=c=g?+c.val:null;k&&g&&k>c?(x("csm.jumpStart.mtsDiff",k-c||0),a("csm-rld-mts-gt")):k&&g?a("csm-rld-mts-leq"):g?k||a("csm-rld-mts-no-new"):a("csm-rld-mts-no-old")}f&&
f.timing&&f.timing.navigationStart?b.timing.transitionStart=f.timing.navigationStart:delete b.timing.transitionStart}function v(){try{a.P.register("AMZNPerformance",function(){return b})}catch(c){}}function r(){if(!b)return"";ue_mbl.cnt=null;var c=b.timing,d=b.transition,d=["mts",l(c.transitionStart),"mps",l(c.processStart),"mtt",d.type,"mtst",d.subType,"mtlt",d.launchType];a.ue&&a.ue.tag&&(c.fr_ovr&&a.ue.tag("fr_ovr"),c.fcp_ovr&&a.ue.tag("fcp_ovr"),d.push("fr_ovr",l(c.fr_ovr),"fcp_ovr",l(c.fcp_ovr)));
for(var c="",e=0;e<d.length;e+=2){var f=d[e],g=d[e+1];"undefined"!==typeof g&&(c+="&"+f+"="+g)}return c}function l(a){if("undefined"!==typeof a&&"undefined"!==typeof m)return a-m}function y(a,d){b&&(m=d,b.timing.transitionStart=a,b.transition.type="view-transition",b.transition.subType="ajax-transition",b.transition.launchType="normal",ue_mbl.cnt=r)}var e=h.ue||{},m=h.ue_t0,q="csm-last-mts",p=1===h.ue_sswmts,n,f=a.performance,b;if(a.P&&a.P.when&&a.P.register)return 1===a.ue_fnt&&(m=a.aPageStart||
h.ue_t0),a.P.when("CSMPlugin").execute(function(a){a.buildAMZNPerformance&&a.buildAMZNPerformance({successCallback:s,failCallback:w})}),{cnt:r,ajax:y}},"mobile-timing")(ue_csm,ue_csm.window);

(function(d){d._uess=function(){var a="";screen&&screen.width&&screen.height&&(a+="&sw="+screen.width+"&sh="+screen.height);var b=function(a){var b=document.documentElement["client"+a];return"CSS1Compat"===document.compatMode&&b||document.body["client"+a]||b},c=b("Width"),b=b("Height");c&&b&&(a+="&vw="+c+"&vh="+b);return a}})(ue_csm);

(function(a){function d(a){c&&c("log",a)}var b=document.ue_backdetect,c=a.csa&&a.csa("Errors",{producerId:"csa",logOptions:{ent:"all"}});a.ue_err.buffer&&c&&(a.ue_err.buffer.forEach(d),a.ue_err.buffer.push=d);b&&b.ue_back&&a.ue&&(a.ue.bfini=b.ue_back.value);a.uet&&a.uet("be");a.onLdEnd&&(window.addEventListener?window.addEventListener("load",a.onLdEnd,!1):window.attachEvent&&window.attachEvent("onload",a.onLdEnd));a.ueh&&a.ueh(0,window,"load",a.onLd,1);a.ue&&a.ue.tag&&(a.ue_furl?(b=a.ue_furl.replace(/./g,
"-"),a.ue.tag(b)):a.ue.tag("nofls"))})(ue_csm);

(function(g,h){function d(a,d){var b={};if(!e||!f)try{var c=h.sessionStorage;c?a&&("undefined"!==typeof d?c.setItem(a,d):b.val=c.getItem(a)):f=1}catch(g){e=1}e&&(b.e=1);return b}var b=g.ue||{},a="",f,e,c,a=d("csmtid");f?a="NA":a.e?a="ET":(a=a.val,a||(a=b.oid||"NI",d("csmtid",a)),c=d(b.oid),c.e||(c.val=c.val||0,d(b.oid,c.val+1)),b.ssw=d);b.tabid=a})(ue_csm,ue_csm.window);

(function(a){var e={rc:1,hob:1,hoe:1,ntd:1,rd_:1,_rd:1};"function"===typeof window.addEventListener&&window.addEventListener("pageshow",function(b){if(b&&b.persisted&&(b=+new Date,b={clickTime:b-1,pageVisible:b},"object"===typeof b&&"object"===typeof a.ue.markers&&"object"===typeof a.ue&&"function"===typeof a.uex)){if("function"===typeof a.uet){for(var c in a.ue.markers)!a.ue.markers.hasOwnProperty(c)||c in e||a.uet(c,void 0,void 0,b.pageVisible);a.uet("tc",void 0,void 0,b.clickTime);a.uet("ty",void 0,
void 0,b.clickTime+2)}(c=document.ue_backdetect)&&c.ue_back&&(a.ue.bfini=+c.ue_back.value+1);a.ue.isBFonMshop=!0;a.ue.isBFCache=!0;a.ue.t0=b.clickTime;a.ue.viz=["visible:0"];"function"===typeof a.ue.tag&&(a.ue.tag("cacheSourceMemory"),a.ue.tag("history-navigation-page-cache"));c=ue_csm.csa&&ue_csm.csa("SPA");var d=ue_csm.csa&&ue_csm.csa("PageTiming");c&&d&&(c("newPage",{transitionType:"history-navigation-page-cache"},{keepPageAttributes:!0}),d("mark","transitionStart",b.clickTime));"function"===typeof a.uex&&
a.uex("ld",void 0,void 0,a.ue.t.ld);delete a.ue.isBFonMshop;delete a.ue.isBFCache}})})(ue_csm);

ue_csm.ue.exec(function(e,f){var a=e.ue||{},b=a._wlo,d;if(a.ssw){d=a.ssw("CSM_previousURL").val;var c=f.location,b=b?b:c&&c.href?c.href.split("#")[0]:void 0;c=(b||"")===a.ssw("CSM_previousURL").val;!c&&b&&a.ssw("CSM_previousURL",b);d=c?"reload":d?"intrapage-transition":"first-view"}else d="unknown";a._nt=d},"NavTypeModule")(ue_csm,window);
ue_csm.ue.exec(function(c,a){function g(a){a.run(function(e){d.tag("csm-feature-"+a.name+":"+e);d.isl&&c.uex("at")})}if(a.addEventListener)for(var d=c.ue||{},f=[{name:"touch-enabled",run:function(b){var e=function(){a.removeEventListener("touchstart",c,!0);a.removeEventListener("mousemove",d,!0)},c=function(){b("true");e()},d=function(){b("false");e()};a.addEventListener("touchstart",c,!0);a.addEventListener("mousemove",d,!0)}}],b=0;b<f.length;b++)g(f[b])},"csm-features")(ue_csm,window);


(function(a,e){function d(a){b&&b("recordCounter",a.c,a.v)}var c=e.images,b=a.csa&&a.csa("Metrics",{producerId:"csa"});c&&c.length&&a.ue.count("totalImages",c.length);a.ue.cv.buffer&&b&&(a.ue.cv.buffer.forEach(d),a.ue.cv.buffer.push=d)})(ue_csm,document);
(function(b){function c(){var d=[];a.log&&a.log.isStub&&a.log.replay(function(a){e(d,a)});a.clog&&a.clog.isStub&&a.clog.replay(function(a){e(d,a)});d.length&&(a._flhs+=1,n(d),p(d))}function g(){a.log&&a.log.isStub&&(a.onflush&&a.onflush.replay&&a.onflush.replay(function(a){a[0]()}),a.onunload&&a.onunload.replay&&a.onunload.replay(function(a){a[0]()}),c())}function e(d,b){var c=b[1],f=b[0],e={};a._lpn[c]=(a._lpn[c]||0)+1;e[c]=f;d.push(e)}function n(b){q&&(a._lpn.csm=(a._lpn.csm||0)+1,b.push({csm:{k:"chk",
f:a._flhs,l:a._lpn,s:"inln"}}))}function p(a){if(h)a=k(a),b.navigator.sendBeacon(l,a);else{a=k(a);var c=new b[f];c.open("POST",l,!0);c.setRequestHeader&&c.setRequestHeader("Content-type","text/plain");c.send(a)}}function k(a){return JSON.stringify({rid:b.ue_id,sid:b.ue_sid,mid:b.ue_mid,mkt:b.ue_mkt,sn:b.ue_sn,reqs:a})}var f="XMLHttpRequest",q=1===b.ue_ddq,a=b.ue,r=b[f]&&"withCredentials"in new b[f],h=b.navigator&&b.navigator.sendBeacon,l="//"+b.ue_furl+"/1/batch/1/OE/",m=b.ue_fci_ft||5E3;a&&(r||h)&&
(a._flhs=a._flhs||0,a._lpn=a._lpn||{},a.attach&&(a.attach("beforeunload",a.exec(g,"fcli-bfu")),a.attach("pagehide",a.exec(g,"fcli-ph"))),m&&b.setTimeout(a.exec(c,"fcli-t"),m),a._ffci=a.exec(c))})(window);


(function(k,c){function l(a,b){return a.filter(function(a){return a.initiatorType==b})}function f(a,c){if(b.t[a]){var g=b.t[a]-b._t0,e=c.filter(function(a){return 0!==a.responseEnd&&m(a)<g}),f=l(e,"script"),h=l(e,"link"),k=l(e,"img"),n=e.map(function(a){return a.name.split("/")[2]}).filter(function(a,b,c){return a&&c.lastIndexOf(a)==b}),q=e.filter(function(a){return a.duration<p}),s=g-Math.max.apply(null,e.map(m))<r|0;"af"==a&&(b._afjs=f.length);return a+":"+[e[d],f[d],h[d],k[d],n[d],q[d],s].join("-")}}
function m(a){return a.responseEnd-(b._t0-c.timing.navigationStart)}function n(){var a=c[h]("resource"),d=f("cf",a),g=f("af",a),a=f("ld",a);delete b._rt;b._ld=b.t.ld-b._t0;b._art&&b._art();return[d,g,a].join("_")}var p=20,r=50,d="length",b=k.ue,h="getEntriesByType";b._rre=m;b._rt=c&&c.timing&&c[h]&&n})(ue_csm,window.performance);


(function(c,d){var b=c.ue,a=d.navigator;b&&b.tag&&a&&(a=a.connection||a.mozConnection||a.webkitConnection)&&a.type&&b.tag("netInfo:"+a.type)})(ue_csm,window);


(function(c,d){function h(a,b){for(var c=[],d=0;d<a.length;d++){var e=a[d],f=b.encode(e);if(e[k]){var g=b.metaSep,e=e[k],l=b.metaPairSep,h=[],m=void 0;for(m in e)e.hasOwnProperty(m)&&h.push(m+"="+e[m]);e=h.join(l);f+=g+e}c.push(f)}return c.join(b.resourceSep)}function s(a){var b=a[k]=a[k]||{};b[t]||(b[t]=c.ue_mid);b[u]||(b[u]=c.ue_sid);b[f]||(b[f]=c.ue_id);b.csm=1;a="//"+c.ue_furl+"/1/"+a[v]+"/1/OP/"+a[w]+"/"+a[x]+"/"+h([a],y);if(n)try{n.call(d[p],a)}catch(g){c.ue.sbf=1,(new Image).src=a}else(new Image).src=
a}function q(){g&&g.isStub&&g.replay(function(a,b,c){a=a[0];b=a[k]=a[k]||{};b[f]=b[f]||c;s(a)});l.impression=s;g=null}if(!(1<c.ueinit)){var k="metadata",x="impressionType",v="foresterChannel",w="programGroup",t="marketplaceId",u="session",f="requestId",p="navigator",l=c.ue||{},n=d[p]&&d[p].sendBeacon,r=function(a,b,c,d){return{encode:d,resourceSep:a,metaSep:b,metaPairSep:c}},y=r("","?","&",function(a){return h(a.impressionData,z)}),z=r("/",":",",",function(a){return a.featureName+":"+h(a.resources,
A)}),A=r(",","@","|",function(a){return a.id}),g=l.impression;n?q():(l.attach("load",q),l.attach("beforeunload",q));try{d.P&&d.P.register&&d.P.register("impression-client",function(){})}catch(B){c.ueLogError(B,{logLevel:"WARN"})}}})(ue_csm,window);



var ue_pty = "Detail";

var ue_spty = "Glance";

var ue_pti = "B052510949";


var ue_adb = 4;
var ue_adb_rtla = 1;
ue_csm.ue.exec(function(y,a){function t(){if(d&&f){var a;a:{try{a=d.getItem(g);break a}catch(c){}a=void 0}if(a)return b=a,!0}return!1}function u(){if(a.fetch)fetch(m).then(function(a){if(!a.ok)throw Error(a.statusText);return a.text?a.text():null}).then(function(b){b?(-1<b.indexOf("window.ue_adb_chk = 1")&&(a.ue_adb_chk=1),n()):h()})["catch"](h);else e.uels(m,{onerror:h,onload:n})}function h(){b=k;l();if(f)try{d.setItem(g,b)}catch(a){}}function n(){b=1===a.ue_adb_chk?p:k;l();if(f)try{d.setItem(g,
b)}catch(c){}}function q(){a.ue_adb_rtla&&c&&0<c.ec&&!1===r&&(c.elh=null,ueLogError({m:"Hit Info",fromOnError:1},{logLevel:"INFO",adb:b}),r=!0)}function l(){e.tag(b);e.isl&&a.uex&&uex("at",b);s&&s.updateCsmHit("adb",b);c&&0<c.ec?q():a.ue_adb_rtla&&c&&(c.elh=q)}function v(){return b}if(a.ue_adb){a.ue_fadb=a.ue_fadb||10;var e=a.ue,k="adblk_yes",p="adblk_no",m="https://m.media-amazon.com/images/G/01/csm/showads.v2.js?bannerid=-ad-sidebar.",b="adblk_unk",d;a:{try{d=a.localStorage;break a}catch(z){}d=
void 0}var g="csm:adb",c=a.ue_err,s=e.cookie,f=void 0!==a.localStorage,w=Math.random()>1-1/a.ue_fadb,r=!1,x=t();w||!x?u():l();a.ue_isAdb=v;a.ue_isAdb.unk="adblk_unk";a.ue_isAdb.no=p;a.ue_isAdb.yes=k}},"adb")(document,window);




(function(c,l,m){function h(a){if(a)try{if(a.id)return"//*[@id='"+a.id+"']";var b,d=1,e;for(e=a.previousSibling;e;e=e.previousSibling)e.nodeName===a.nodeName&&(d+=1);b=d;var c=a.nodeName;1!==b&&(c+="["+b+"]");a.parentNode&&(c=h(a.parentNode)+"/"+c);return c}catch(f){return"DETACHED"}}function f(a){if(a&&a.getAttribute)return a.getAttribute(k)?a.getAttribute(k):f(a.parentElement)}var k="data-cel-widget",g=!1,d=[];(c.ue||{}).isBF=function(){try{var a=JSON.parse(localStorage["csm-bf"]||"[]"),b=0<=a.indexOf(c.ue_id);
a.unshift(c.ue_id);a=a.slice(0,20);localStorage["csm-bf"]=JSON.stringify(a);return b}catch(d){return!1}}();c.ue_utils={getXPath:h,getFirstAscendingWidget:function(a,b){c.ue_cel&&c.ue_fem?!0===g?b(f(a)):d.push({element:a,callback:b}):b()},notifyWidgetsLabeled:function(){if(!1===g){g=!0;for(var a=f,b=0;b<d.length;b++)if(d[b].hasOwnProperty("callback")&&d[b].hasOwnProperty("element")){var c=d[b].callback,e=d[b].element;"function"===typeof c&&"function"===typeof a&&c(a(e))}d=null}},extractStringValue:function(a){if("string"===
typeof a)return a}}})(ue_csm,window,document);


(function(a){a.ue_cel||(a.ue_cel=function(){function m(a,r){r?r.r=u:r={r:u,c:1};D||(!ue_csm.ue_sclog&&r.clog&&b.clog?b.clog(a,r.ns||s,r):r.glog&&b.glog?b.glog(a,r.ns||s,r):b.log(a,r.ns||s,r))}function n(a,b){"function"===typeof p&&p("log",{schemaId:t+".RdCSI.1",eventType:a,clientData:b},{ent:{page:["requestId"]}})}function c(){var a=q.length;if(0<a){for(var r=[],c=0;c<a;c++){var d=q[c].api;d.ready()?(d.on({ts:b.d,ns:s}),g.push(q[c]),m({k:"mso",n:q[c].name,t:b.d()})):r.push(q[c])}q=r}}function f(){if(!f.executed){for(var a=
0;a<g.length;a++)g[a].api.off&&g[a].api.off({ts:b.d,ns:s});B();m({k:"eod",t0:b.t0,t:b.d()},{c:1,il:1});f.executed=1;for(a=0;a<g.length;a++)q.push(g[a]);g=[];d(v);d(A)}}function B(a){m({k:"hrt",t:b.d()},{c:1,il:1,n:a});y=Math.min(w,e*y);z()}function z(){d(A);A=k(function(){B(!0)},y)}function x(){f.executed||B()}var l=a.window,k=l.setTimeout,d=l.clearTimeout,e=1.5,w=l.ue_cel_max_hrt||3E4,t="robotdetection",q=[],g=[],s=a.ue_cel_ns||"cel",v,A,b=a.ue,F=a.uet,C=a.uex,u=b.rid,D=a.ue_dsbl_cel,h=l.csa,p,y=
l.ue_cel_hrt_int||3E3,E=l.requestAnimationFrame||function(a){a()};h&&(p=h("Events",{producerId:t}));if(b.isBF)m({k:"bft",t:b.d()});else{"function"==typeof F&&F("bb","csmCELLSframework",{wb:1});k(c,0);b.onunload(f);if(b.onflush)b.onflush(x);v=k(f,6E5);z();"function"==typeof C&&C("ld","csmCELLSframework",{wb:1});return{registerModule:function(a,r){q.push({name:a,api:r});m({k:"mrg",n:a,t:b.d()});c()},reset:function(a){m({k:"rst",t0:b.t0,t:b.d()});q=q.concat(g);g=[];for(var r=q.length,e=0;e<r;e++)q[e].api.off(),
q[e].api.reset();u=a||b.rid;c();d(v);v=k(f,6E5);f.executed=0},timeout:function(a,b){return k(function(){E(function(){f.executed||a()})},b)},log:m,csaEventLog:n,off:f}}}())})(ue_csm);
(function(a){a.ue_pdm||!a.ue_cel||a.ue.isBF||(a.ue_pdm=function(){function m(){try{var b=d.screen;if(b){var c={w:b.width,aw:b.availWidth,h:b.height,ah:b.availHeight,cd:b.colorDepth,pd:b.pixelDepth};g&&g.w===c.w&&g.h===c.h&&g.aw===c.aw&&g.ah===c.ah&&g.pd===c.pd&&g.cd===c.cd||(g=c,g.t=t(),g.k="sci",F(g),D&&h("sci",{h:(g.h||"0")+""}))}var k=e.body||{},f=e.documentElement||{},n={w:Math.max(k.scrollWidth||0,k.offsetWidth||0,f.clientWidth||0,f.scrollWidth||0,f.offsetWidth||0),h:Math.max(k.scrollHeight||
0,k.offsetHeight||0,f.clientHeight||0,f.scrollHeight||0,f.offsetHeight||0)};s&&s.w===n.w&&s.h===n.h||(s=n,s.t=t(),s.k="doi",F(s));w=a.ue_cel.timeout(m,q);A+=1}catch(p){d.ueLogError&&ueLogError(p,{attribution:"csm-cel-page-module",logLevel:"WARN"})}}function n(){x("ebl","default",!1)}function c(){x("efo","default",!0)}function f(){x("ebl","app",!1)}function B(){x("efo","app",!0)}function z(){d.setTimeout(function(){e[E]?x("ebl","pageviz",!1):x("efo","pageviz",!0)},0)}function x(a,b,c){v!==c&&(F({k:a,
t:t(),s:b},{ff:!0===c?0:1}),D&&h(a,{t:(t()||"0")+"",s:b}));v=c}function l(){b.attach&&(p&&b.attach(y,z,e),G&&P.when("mash").execute(function(a){a&&a.addEventListener&&(a.addEventListener("appPause",f),a.addEventListener("appResume",B))}),b.attach("blur",n,d),b.attach("focus",c,d))}function k(){b.detach&&(p&&b.detach(y,z,e),G&&P.when("mash").execute(function(a){a&&a.removeEventListener&&(a.removeEventListener("appPause",f),a.removeEventListener("appResume",B))}),b.detach("blur",n,d),b.detach("focus",
c,d))}var d=a.window,e=a.document,w,t,q,g,s,v=null,A=0,b=a.ue,F=a.ue_cel.log,C=a.uet,u=a.uex,D=d.csa,h=a.ue_cel.csaEventLog,p=!!b.pageViz,y=p&&b.pageViz.event,E=p&&b.pageViz.propHid,G=d.P&&d.P.when;"function"==typeof C&&C("bb","csmCELLSpdm",{wb:1});return{on:function(a){q=a.timespan||500;t=a.ts;l();a=d.location;F({k:"pmd",o:a.origin,p:a.pathname,t:t()});m();"function"==typeof u&&u("ld","csmCELLSpdm",{wb:1})},off:function(a){clearTimeout(w);k();b.count&&b.count("cel.PDM.TotalExecutions",A)},ready:function(){return e.body&&
a.ue_cel&&a.ue_cel.log},reset:function(){g=s=null}}}(),a.ue_cel&&a.ue_cel.registerModule("page module",a.ue_pdm))})(ue_csm);
(function(a){a.ue_vpm||!a.ue_cel||a.ue.isBF||(a.ue_vpm=function(){function m(){var a=z(),b={w:k.innerWidth,h:k.innerHeight,x:k.pageXOffset,y:k.pageYOffset};c&&c.w==b.w&&c.h==b.h&&c.x==b.x&&c.y==b.y||(b.t=a,b.k="vpi",c=b,e(c,{clog:1}),s&&v("vpi",{t:(c.t||"0")+"",h:(c.h||"0")+"",y:(c.y||"0")+"",w:(c.w||"0")+"",x:(c.x||"0")+""}));f=0;x=z()-a;l+=1}function n(){f||(f=a.ue_cel.timeout(m,B))}var c,f,B,z,x=0,l=0,k=a.window,d=a.ue,e=a.ue_cel.log,w=a.uet,t=a.uex,q=d.attach,g=d.detach,s=k.csa,v=a.ue_cel.csaEventLog;
"function"==typeof w&&w("bb","csmCELLSvpm",{wb:1});return{on:function(a){z=a.ts;B=a.timespan||100;m();q&&(q("scroll",n),q("resize",n));"function"==typeof t&&t("ld","csmCELLSvpm",{wb:1})},off:function(a){clearTimeout(f);g&&(g("scroll",n),g("resize",n));d.count&&(d.count("cel.VPI.TotalExecutions",l),d.count("cel.VPI.TotalExecutionTime",x),d.count("cel.VPI.AverageExecutionTime",x/l))},ready:function(){return a.ue_cel&&a.ue_cel.log},reset:function(){c=void 0},getVpi:function(){return c}}}(),a.ue_cel&&
a.ue_cel.registerModule("viewport module",a.ue_vpm))})(ue_csm);
(function(a){if(!a.ue_fem&&a.ue_cel&&a.ue_utils){var m=a.ue||{},n=a.window,c=n.document;!m.isBF&&!a.ue_fem&&c.querySelector&&n.getComputedStyle&&[].forEach&&(a.ue_fem=function(){function f(a,b){return a>b?3>a-b:3>b-a}function B(a,b){var c=n.pageXOffset,d=n.pageYOffset,k;a:{try{if(a){var e=a.getBoundingClientRect(),g,m=0===a.offsetWidth&&0===a.offsetHeight;c:{for(var h=a.parentNode,p=e.left||0,w=e.top||0,q=e.width||0,s=e.height||0;h&&h!==document.body;){var l;d:{try{var r=void 0;if(h)var t=h.getBoundingClientRect(),
r={x:t.left||0,y:t.top||0,w:t.width||0,h:t.height||0};else r=void 0;l=r;break d}catch(I){}l=void 0}var u=window.getComputedStyle(h),v="hidden"===u.overflow,x=v||"hidden"===u.overflowX,y=v||"hidden"===u.overflowY,z=w+s-1<l.y+1||w+1>l.y+l.h-1;if((p+q-1<l.x+1||p+1>l.x+l.w-1)&&x||z&&y){g=!0;break c}h=h.parentNode}g=!1}k={x:e.left+c||0,y:e.top+d||0,w:e.width||0,h:e.height||0,d:(m||g)|0}}else k=void 0;break a}catch(J){}k=void 0}if(k&&!a.cel_b)a.cel_b=k,D({n:a.getAttribute(A),w:a.cel_b.w,h:a.cel_b.h,d:a.cel_b.d,
x:a.cel_b.x,y:a.cel_b.y,t:b,k:"ewi",cl:a.className},{clog:1});else{if(c=k)c=a.cel_b,d=k,c=d.d===c.d&&1===d.d?!1:!(f(c.x,d.x)&&f(c.y,d.y)&&f(c.w,d.w)&&f(c.h,d.h)&&c.d===d.d);c&&(a.cel_b=k,D({n:a.getAttribute(A),w:a.cel_b.w,h:a.cel_b.h,d:a.cel_b.d,x:a.cel_b.x,y:a.cel_b.y,t:b,k:"ewi"},{clog:1}))}}function z(d,e){var f;f=d.c?c.getElementsByClassName(d.c):d.id?[c.getElementById(d.id)]:c.querySelectorAll(d.s);d.w=[];for(var g=0;g<f.length;g++){var h=f[g];if(h){if(!h.getAttribute(A)){var l=h.getAttribute("cel_widget_id")||
(d.id_gen||u)(h,g)||h.id;h.setAttribute(A,l)}d.w.push(h);k(Q,h,e)}}!1===C&&(F++,F===b.length&&(C=!0,a.ue_utils.notifyWidgetsLabeled()))}function x(a,b){h.contains(a)||D({n:a.getAttribute(A),t:b,k:"ewd"},{clog:1})}function l(a){K.length&&ue_cel.timeout(function(){if(s){for(var b=R(),c=!1;R()-b<g&&!c;){for(c=S;0<c--&&0<K.length;){var d=K.shift();T[d.type](d.elem,d.time)}c=0===K.length}U++;l(a)}},0)}function k(a,b,c){K.push({type:a,elem:b,time:c})}function d(a,c){for(var d=0;d<b.length;d++)for(var e=
b[d].w||[],h=0;h<e.length;h++)k(a,e[h],c)}function e(){M||(M=a.ue_cel.timeout(function(){M=null;var c=v();d(W,c);for(var e=0;e<b.length;e++)k(X,b[e],c);0===b.length&&!1===C&&(C=!0,a.ue_utils.notifyWidgetsLabeled());l(c)},q))}function w(){M||N||(N=a.ue_cel.timeout(function(){N=null;var a=v();d(Q,a);l(a)},q))}function t(){return y&&E&&h&&h.contains&&h.getBoundingClientRect&&v}var q=50,g=4.5,s=!1,v,A="data-cel-widget",b=[],F=0,C=!1,u=function(){},D=a.ue_cel.log,h,p,y,E,G=n.MutationObserver||n.WebKitMutationObserver||
n.MozMutationObserver,r=!!G,H,I,O="DOMAttrModified",L="DOMNodeInserted",J="DOMNodeRemoved",N,M,K=[],U=0,S=null,W="removedWidget",X="updateWidgets",Q="processWidget",T,V=n.performance||{},R=V.now&&function(){return V.now()}||function(){return Date.now()};"function"==typeof uet&&uet("bb","csmCELLSfem",{wb:1});return{on:function(d){function k(){if(t()){T={removedWidget:x,updateWidgets:z,processWidget:B};if(r){var a={attributes:!0,subtree:!0};H=new G(w);I=new G(e);H.observe(h,a);I.observe(h,{childList:!0,
subtree:!0});I.observe(p,a)}else y.call(h,O,w),y.call(h,L,e),y.call(h,J,e),y.call(p,L,w),y.call(p,J,w);e()}}h=c.body;p=c.head;y=h.addEventListener;E=h.removeEventListener;v=d.ts;b=a.cel_widgets||[];S=d.bs||5;m.deffered?k():m.attach&&m.attach("load",k);"function"==typeof uex&&uex("ld","csmCELLSfem",{wb:1});s=!0},off:function(){t()&&(I&&(I.disconnect(),I=null),H&&(H.disconnect(),H=null),E.call(h,O,w),E.call(h,L,e),E.call(h,J,e),E.call(p,L,w),E.call(p,J,w));m.count&&m.count("cel.widgets.batchesProcessed",
U);s=!1},ready:function(){return a.ue_cel&&a.ue_cel.log},reset:function(){b=a.cel_widgets||[]}}}(),a.ue_cel&&a.ue_fem&&a.ue_cel.registerModule("features module",a.ue_fem))}})(ue_csm);
(function(a){!a.ue_mcm&&a.ue_cel&&a.ue_utils&&!a.ue.isBF&&(a.ue_mcm=function(){function m(a,d){var e=a.srcElement||a.target||{},f={k:n,w:(d||{}).ow||(B.body||{}).scrollWidth,h:(d||{}).oh||(B.body||{}).scrollHeight,t:(d||{}).ots||c(),x:a.pageX,y:a.pageY,p:l.getXPath(e),n:e.nodeName};z&&"function"===typeof z.now&&a.timeStamp&&(f.dt=(d||{}).odt||z.now()-a.timeStamp,f.dt=parseFloat(f.dt.toFixed(2)));a.button&&(f.b=a.button);e.href&&(f.r=l.extractStringValue(e.href));e.id&&(f.i=e.id);e.className&&e.className.split&&
(f.c=e.className.split(/s+/));x(f,{c:1})}var n="mcm",c,f=a.window,B=f.document,z=f.performance,x=a.ue_cel.log,l=a.ue_utils;return{on:function(k){c=k.ts;a.ue_cel_stub&&a.ue_cel_stub.replayModule(n,m);f.addEventListener&&f.addEventListener("mousedown",m,!0)},off:function(a){f.addEventListener&&f.removeEventListener("mousedown",m,!0)},ready:function(){return a.ue_cel&&a.ue_cel.log},reset:function(){}}}(),a.ue_cel&&a.ue_cel.registerModule("mouse click module",a.ue_mcm))})(ue_csm);
(function(a){a.ue_mmm||!a.ue_cel||a.ue.isBF||(a.ue_mmm=function(m){function n(a,b){var c={x:a.pageX||a.x||0,y:a.pageY||a.y||0,t:l()};!b&&p&&(c.t-p.t<B||c.x==p.x&&c.y==p.y)||(p=c,u.push(c))}function c(){if(u.length){F=H.now();for(var a=0;a<u.length;a++){var c=u[a],d=a;y=u[h];E=c;var e=void 0;if(!(e=2>d)){e=void 0;a:if(u[d].t-u[d-1].t>f)e=0;else{for(e=h+1;e<d;e++){var g=y,k=E,l=u[e];G=(k.x-g.x)*(g.y-l.y)-(g.x-l.x)*(k.y-g.y);if(G*G/((k.x-g.x)*(k.x-g.x)+(k.y-g.y)*(k.y-g.y))>z){e=0;break a}}e=1}e=!e}(r=
e)?h=d-1:D.pop();D.push(c)}C=H.now()-F;s=Math.min(s,C);v=Math.max(v,C);A=(A*b+C)/(b+1);b+=1;q({k:x,e:D,min:Math.floor(1E3*s),max:Math.floor(1E3*v),avg:Math.floor(1E3*A)},{c:1});u=[];D=[];h=0}}var f=100,B=20,z=25,x="mmm1",l,k,d=a.window,e=d.document,w=d.setInterval,t=a.ue,q=a.ue_cel.log,g,s=1E3,v=0,A=0,b=0,F,C,u=[],D=[],h=0,p,y,E,G,r,H=m&&m.now&&m||Date.now&&Date||{now:function(){return(new Date).getTime()}};return{on:function(a){l=a.ts;k=a.ns;t.attach&&t.attach("mousemove",n,e);g=w(c,3E3)},off:function(a){k&&
(p&&n(p,!0),c());clearInterval(g);t.detach&&t.detach("mousemove",n,e)},ready:function(){return a.ue_cel&&a.ue_cel.log},reset:function(){u=[];D=[];h=0;p=null}}}(window.performance),a.ue_cel&&a.ue_cel.registerModule("mouse move module",a.ue_mmm))})(ue_csm);



ue_csm.ue.exec(function(b,c){var e=function(){},f=function(){return{send:function(b,d){if(d&&b){var a;if(c.XDomainRequest)a=new XDomainRequest,a.onerror=e,a.ontimeout=e,a.onprogress=e,a.onload=e,a.timeout=0;else if(c.XMLHttpRequest){if(a=new XMLHttpRequest,!("withCredentials"in a))throw"";}else a=void 0;if(!a)throw"";a.open("POST",b,!0);a.setRequestHeader&&a.setRequestHeader("Content-type","text/plain");a.send(d)}},isSupported:!0}}(),g=function(){return{send:function(c,d){if(c&&d)if(navigator.sendBeacon(c,
d))b.ue_sbuimp&&b.ue&&b.ue.ssw&&b.ue.ssw("eelsts","scs");else throw"";},isSupported:!!navigator.sendBeacon&&!(c.cordova&&c.cordova.platformId&&"ios"==c.cordova.platformId)}}();b.ue._ajx=f;b.ue._sBcn=g},"Transportation-clients")(ue_csm,window);
ue_csm.ue.exec(function(b,k){function B(){for(var a=0;a<arguments.length;a++){var c=arguments[a];try{var g;if(c.isSupported){var f=u.buildPayload(l,e);g=c.send(K,f)}else throw dummyException;return g}catch(d){}}a={m:"All supported clients failed",attribution:"CSMSushiClient_TRANSPORTATION_FAIL",f:"sushi-client.js",logLevel:"ERROR"};C(a,k.ue_err_chan||"jserr");b.ue_err.buffer&&b.ue_err.buffer.push(a)}function m(){if(e.length){for(var a=0;a<n.length;a++)n[a]();B(d._sBcn||{},d._ajx||{});e=[];h={};l=
{};v=w=r=x=0}}function L(){var a=new Date,c=function(a){return 10>a?"0"+a:a};return Date.prototype.toISOString?a.toISOString():a.getUTCFullYear()+"-"+c(a.getUTCMonth()+1)+"-"+c(a.getUTCDate())+"T"+c(a.getUTCHours())+":"+c(a.getUTCMinutes())+":"+c(a.getUTCSeconds())+"."+String((a.getUTCMilliseconds()/1E3).toFixed(3)).slice(2,5)+"Z"}function y(a){try{return JSON.stringify(a)}catch(c){}return null}function D(a,c,g,f){var q=!1;f=f||{};s++;if(s==E){var p={m:"Max number of Sushi Logs exceeded",f:"sushi-client.js",
logLevel:"ERROR",attribution:"CSMSushiClient_MAX_CALLS"};C(p,k.ue_err_chan||"jserr");b.ue_err.buffer&&b.ue_err.buffer.push(p)}if(p=!(s>=E))(p=a&&-1<a.constructor.toString().indexOf("Object")&&c&&-1<c.constructor.toString().indexOf("String")&&g&&-1<g.constructor.toString().indexOf("String"))||M++;p&&(d.count&&d.count("Event:"+g,1),a.producerId=a.producerId||c,a.schemaId=a.schemaId||g,a.timestamp=L(),c=Date.now?Date.now():+new Date,g=Math.random().toString().substring(2,12),a.messageId=b.ue_id+"-"+
c+"-"+g,f&&!f.ssd&&(a.sessionId=a.sessionId||b.ue_sid,a.requestId=a.requestId||b.ue_id,a.obfuscatedMarketplaceId=a.obfuscatedMarketplaceId||b.ue_mid),(c=y(a))?(c=c.length,(e.length==N||r+c>O)&&m(),r+=c,a={data:u.compressEvent(a)},e.push(a),(f||{}).n?0===F?m():v||(v=k.setTimeout(m,F)):w||(w=k.setTimeout(m,P)),q=!0):q=!1);!q&&b.ue_int&&console.error("Invalid JS Nexus API call");return q}function G(){if(!H){for(var a=0;a<z.length;a++)z[a]();for(a=0;a<n.length;a++)n[a]();e.length&&(b.ue_sbuimp&&b.ue&&
b.ue.ssw&&(a=y({dct:l,evt:e}),b.ue.ssw("eeldata",a),b.ue.ssw("eelsts","unk")),B(d._sBcn||{}));H=!0}}function I(a){z.push(a)}function J(a){n.push(a)}var E=1E3,N=499,O=524288,t=function(){},d=b.ue||{},C=d.log||t,Q=b.uex||t;(b.uet||t)("bb","ue_sushi_v1",{wb:1});var K=b.ue_surl||"https://unagi-na.amazon.com/1/events/com.amazon.csm.nexusclient.gamma",R=["messageId","timestamp"],A="#",e=[],h={},l={},r=0,x=0,M=0,s=0,z=[],n=[],H=!1,v,w,F=void 0===b.ue_hpsi?1E3:b.ue_hpsi,P=void 0===b.ue_lpsi?1E4:b.ue_lpsi,
u=function(){function a(a){h[a]=A+x++;l[h[a]]=a;return h[a]}function c(b){if(!(b instanceof Function)){if(b instanceof Array){for(var f=[],d=b.length,e=0;e<d;e++)f[e]=c(b[e]);return f}if(b instanceof Object){f={};for(d in b)b.hasOwnProperty(d)&&(f[h[d]?h[d]:a(d)]=-1===R.indexOf(d)?c(b[d]):b[d]);return f}return"string"===typeof b&&(b.length>(A+x).length||b.charAt(0)===A)?h[b]?h[b]:a(b):b}}return{compressEvent:c,buildPayload:function(){return y({cs:{dct:l},events:e})}}}();(function(){if(d.event&&d.event.isStub){if(b.ue_sbuimp&&
b.ue&&b.ue.ssw){var a=b.ue.ssw("eelsts").val;if(a&&"unk"===a&&(a=b.ue.ssw("eeldata").val)){var c;a:{try{c=JSON.parse(a);break a}catch(g){}c=null}c&&c.evt instanceof Array&&c.dct instanceof Object&&(e=c.evt,l=c.dct,e&&l&&(m(),b.ue.ssw("eeldata","{}"),b.ue.ssw("eelsts","scs")))}}d.event.replay(function(a){a[3]=a[3]||{};a[3].n=1;D.apply(this,a)});d.onSushiUnload.replay(function(a){I(a[0])});d.onSushiFlush.replay(function(a){J(a[0])})}})();d.attach("beforeunload",G);d.attach("pagehide",G);d._cmps=u;d.event=
D;d.event.reset=function(){s=0};d.onSushiUnload=I;d.onSushiFlush=J;try{k.P&&k.P.register&&k.P.register("sushi-client",t)}catch(S){b.ueLogError(S,{logLevel:"WARN"})}Q("ld","ue_sushi_v1",{wb:1})},"Nxs-JS-Client")(ue_csm,window);


ue_csm.ue_unrt = 1500;
(function(d,b,t){function u(a,g){var c=a.srcElement||a.target||{},b={k:v,t:g.t,dt:g.dt,x:a.pageX,y:a.pageY,p:e.getXPath(c),n:c.nodeName};a.button&&(b.b=a.button);c.type&&(b.ty=c.type);c.href&&(b.r=e.extractStringValue(c.href));c.id&&(b.i=c.id);c.className&&c.className.split&&(b.c=c.className.split(/s+/));h+=1;e.getFirstAscendingWidget(c,function(a){b.wd=a;d.ue.log(b,r)})}function w(a){if(!x(a.srcElement||a.target)){m+=1;n=!0;var g=f=d.ue.d(),c;p&&"function"===typeof p.now&&a.timeStamp&&(c=p.now()-
a.timeStamp,c=parseFloat(c.toFixed(2)));s=b.setTimeout(function(){u(a,{t:g,dt:c})},y)}}function z(a){if(a){var b=a.filter(A);a.length!==b.length&&(q=!0,k=d.ue.d(),n&&q&&(k&&f&&d.ue.log({k:B,t:f,m:Math.abs(k-f)},r),l(),q=!1,k=0))}}function A(a){if(!a)return!1;var b="characterData"===a.type?a.target.parentElement:a.target;if(!b||!b.hasAttributes||!b.attributes)return!1;var c={"class":"gw-clock gw-clock-aria s-item-container-height-auto feed-carousel using-mouse kfs-inner-container".split(" "),id:["dealClock",
"deal_expiry_timer","timer"],role:["timer"]},d=!1;Object.keys(c).forEach(function(a){var e=b.attributes[a]?b.attributes[a].value:"";(c[a]||"").forEach(function(a){-1!==e.indexOf(a)&&(d=!0)})});return d}function x(a){if(!a)return!1;var b=(e.extractStringValue(a.nodeName)||"").toLowerCase(),c=(e.extractStringValue(a.type)||"").toLowerCase(),d=(e.extractStringValue(a.href)||"").toLowerCase();a=(e.extractStringValue(a.id)||"").toLowerCase();var f="checkbox color date datetime-local email file month number password radio range reset search tel text time url week".split(" ");
if(-1!==["select","textarea","html"].indexOf(b)||"input"===b&&-1!==f.indexOf(c)||"a"===b&&-1!==d.indexOf("http")||-1!==["sitbreaderrightpageturner","sitbreaderleftpageturner","sitbreaderpagecontainer"].indexOf(a))return!0}function l(){n=!1;f=0;b.clearTimeout(s)}function C(){b.ue.onunload(function(){ue.count("armored-cxguardrails.unresponsive-clicks.violations",h);ue.count("armored-cxguardrails.unresponsive-clicks.violationRate",h/m*100||0)})}if(b.MutationObserver&&b.addEventListener&&Object.keys&&
d&&d.ue&&d.ue.log&&d.ue_unrt&&d.ue_utils){var y=d.ue_unrt,r="cel",v="unr_mcm",B="res_mcm",p=b.performance,e=d.ue_utils,n=!1,f=0,s=0,q=!1,k=0,h=0,m=0;b.addEventListener&&(b.addEventListener("mousedown",w,!0),b.addEventListener("beforeunload",l,!0),b.addEventListener("visibilitychange",l,!0),b.addEventListener("pagehide",l,!0));b.ue&&b.ue.event&&b.ue.onSushiUnload&&b.ue.onunload&&C();(new MutationObserver(z)).observe(t,{childList:!0,attributes:!0,characterData:!0,subtree:!0})}})(ue_csm,window,document);


ue_csm.ue.exec(function(g,e){if(e.ue_err){var f="";e.ue_err.errorHandlers||(e.ue_err.errorHandlers=[]);e.ue_err.errorHandlers.push({name:"fctx",handler:function(a){if(!a.logLevel||"FATAL"===a.logLevel)if(f=g.getElementsByTagName("html")[0].innerHTML){var b=f.indexOf("var ue_t0=ue_t0||+new Date();");if(-1!==b){var b=f.substr(0,b).split(String.fromCharCode(10)),d=Math.max(b.length-10-1,0),b=b.slice(d,b.length-1);a.fcsmln=d+b.length+1;a.cinfo=a.cinfo||{};for(var c=0;c<b.length;c++)a.cinfo[d+c+1+""]=
b[c]}b=f.split(String.fromCharCode(10));a.cinfo=a.cinfo||{};if(!(a.f||void 0===a.l||a.l in a.cinfo))for(c=+a.l-1,d=Math.max(c-5,0),c=Math.min(c+5,b.length-1);d<=c;d++)a.cinfo[d+1+""]=b[d]}}})}},"fatals-context")(document,window);


(function(m,b){function c(k){function f(a){a&&"string"===typeof a&&(a=(a=a.match(/^(?:https?:)?//(.*?)(/|$)/i))&&1<a.length?a[1]:null,a&&a&&("number"===typeof e[a]?e[a]++:e[a]=1))}function d(a){var e=10,d=+new Date;a&&a.timeRemaining?e=a.timeRemaining():a={timeRemaining:function(){return Math.max(0,e-(+new Date-d))}};for(var c=b.performance.getEntries(),k=e;g<c.length&&k>n;)c[g].name&&f(c[g].name),g++,k=a.timeRemaining();g>=c.length?h(!0):l()}function h(a){if(!a){a=m.scripts;var c;if(a)for(var d=
0;d<a.length;d++)(c=a[d].getAttribute("src"))&&"undefined"!==c&&f(c)}0<Object.keys(e).length&&(p&&ue_csm.ue&&ue_csm.ue.event&&(a={domains:e,pageType:b.ue_pty||null,subPageType:b.ue_spty||null,pageTypeId:b.ue_pti||null},ue_csm.ue_sjslob&&(a.lob=ue_csm.ue_lob||"0"),ue_csm.ue.event(a,"csm","csm.CrossOriginDomains.2")),b.ue_ext=e)}function l(){!0===k?d():b.requestIdleCallback?b.requestIdleCallback(d):b.requestAnimationFrame?b.requestAnimationFrame(d):b.setTimeout(d,100)}function c(){if(b.performance&&
b.performance.getEntries){var a=b.performance.getEntries();!a||0>=a.length?h(!1):l()}else h(!1)}var e=b.ue_ext||{};b.ue_ext||c();return e}function q(){setTimeout(c,r)}var s=b.ue_dserr||!1,p=!0,n=1,r=2E3,g=0;b.ue_err&&s&&(b.ue_err.errorHandlers||(b.ue_err.errorHandlers=[]),b.ue_err.errorHandlers.push({name:"ext",handler:function(b){if(!b.logLevel||"FATAL"===b.logLevel){var f=c(!0),d=[],h;for(h in f){var f=h,g=f.match(/amazon(.com?)?.w{2,3}$/i);g&&1<g.length||-1!==f.indexOf("amazon-adsystem.com")||
-1!==f.indexOf("amazonpay.com")||-1!==f.indexOf("cloudfront-labs.amazonaws.com")||d.push(h)}b.ext=d}}}));b.ue&&b.ue.isl?c():b.ue&&ue.attach&&ue.attach("load",q)})(document,window);





var ue_wtc_c = 3;
ue_csm.ue.exec(function(b,e){function l(){for(var a=0;a<f.length;a++)a:for(var d=s.replace(A,f[a])+g[f[a]]+t,c=arguments,b=0;b<c.length;b++)try{c[b].send(d);break a}catch(e){}g={};f=[];n=0;k=p}function u(){B?l(q):l(C,q)}function v(a,m,c){r++;if(r>w)d.count&&1==r-w&&(d.count("WeblabTriggerThresholdReached",1),b.ue_int&&console.error("Number of max call reached. Data will no longer be send"));else{var h=c||{};h&&-1<h.constructor.toString().indexOf(D)&&a&&-1<a.constructor.toString().indexOf(x)&&m&&-1<
m.constructor.toString().indexOf(x)?(h=b.ue_id,c&&c.rid&&(h=c.rid),c=h,a=encodeURIComponent(",wl="+a+"/"+m),2E3>a.length+p?(2E3<k+a.length&&u(),void 0===g[c]&&(g[c]="",f.push(c)),g[c]+=a,k+=a.length,n||(n=e.setTimeout(u,E))):b.ue_int&&console.error("Invalid API call. The input provided is over 2000 chars.")):d.count&&(d.count("WeblabTriggerImproperAPICall",1),b.ue_int&&console.error("Invalid API call. The input provided does not match the API protocol i.e ue.trigger(String, String, Object)."))}}function F(){d.trigger&&
d.trigger.isStub&&d.trigger.replay(function(a){v.apply(this,a)})}function y(){z||(f.length&&l(q),z=!0)}var t=":1234",s="//"+b.ue_furl+"/1/remote-weblab-triggers/1/OE/"+b.ue_mid+":"+b.ue_sid+":PLCHLDR_RID$s:wl-client-id%3DCSMTriger",A="PLCHLDR_RID",E=b.wtt||1E4,p=s.length+t.length,w=b.mwtc||2E3,G=1===e.ue_wtc_c,B=3===e.ue_wtc_c,H=e.XMLHttpRequest&&"withCredentials"in new e.XMLHttpRequest,x="String",D="Object",d=b.ue,g={},f=[],k=p,n,z=!1,r=0,C=function(){return{send:function(a){if(H){var b=new e.XMLHttpRequest;
b.open("GET",a,!0);G&&(b.withCredentials=!0);b.send()}else throw"";}}}(),q=function(){return{send:function(a){(new Image).src=a}}}();e.encodeURIComponent&&(d.attach&&(d.attach("beforeunload",y),d.attach("pagehide",y)),F(),d.trigger=v)},"client-wbl-trg")(ue_csm,window);


(function(k,d,h){function f(a,c,b){a&&a.indexOf&&0===a.indexOf("http")&&0!==a.indexOf("https")&&l(s,c,a,b)}function g(a,c,b){a&&a.indexOf&&(location.href.split("#")[0]!=a&&null!==a&&"undefined"!==typeof a||l(t,c,a,b))}function l(a,c,b,e){m[b]||(e=u&&e?n(e):"N/A",d.ueLogError&&d.ueLogError({message:a+c+" : "+b,logLevel:v,stack:"N/A"},{attribution:e}),m[b]=1,p++)}function e(a,c){if(a&&c)for(var b=0;b<a.length;b++)try{c(a[b])}catch(d){}}function q(){return d.performance&&d.performance.getEntriesByType?
d.performance.getEntriesByType("resource"):[]}function n(a){if(a.id)return"//*[@id='"+a.id+"']";var c;c=1;var b;for(b=a.previousSibling;b;b=b.previousSibling)b.nodeName==a.nodeName&&(c+=1);b=a.nodeName;1!=c&&(b+="["+c+"]");a.parentNode&&(b=n(a.parentNode)+"/"+b);return b}function w(){var a=h.images;a&&a.length&&e(a,function(a){var b=a.getAttribute("src");f(b,"img",a);g(b,"img",a)})}function x(){var a=h.scripts;a&&a.length&&e(a,function(a){var b=a.getAttribute("src");f(b,"script",a);g(b,"script",a)})}
function y(){var a=h.styleSheets;a&&a.length&&e(a,function(a){if(a=a.ownerNode){var b=a.getAttribute("href");f(b,"style",a);g(b,"style",a)}})}function z(){if(A){var a=q();e(a,function(a){f(a.name,a.initiatorType)})}}function B(){e(q(),function(a){g(a.name,a.initiatorType)})}function r(){var a;a=d.location&&d.location.protocol?d.location.protocol:void 0;"https:"==a&&(z(),w(),x(),y(),B(),p<C&&setTimeout(r,D))}var s="[CSM] Insecure content detected ",t="[CSM] Ajax request to same page detected ",v="WARN",
m={},p=0,D=k.ue_nsip||1E3,C=5,A=1==k.ue_urt,u=!0;ue_csm.ue_disableNonSecure||(d.performance&&d.performance.setResourceTimingBufferSize&&d.performance.setResourceTimingBufferSize(300),r())})(ue_csm,window,document);


var ue_aa_a = "T1";
if (ue.trigger && (ue_aa_a === "C" || ue_aa_a === "T1")) {
    ue.trigger("UEDATA_AA_SERVERSIDE_ASSIGNMENT_CLIENTSIDE_TRIGGER_190249", ue_aa_a);
}
(function(f,b){function g(){try{b.PerformanceObserver&&"function"===typeof b.PerformanceObserver&&(a=new b.PerformanceObserver(function(b){c(b.getEntries())}),a.observe(d))}catch(h){k()}}function m(){for(var h=d.entryTypes,a=0;a<h.length;a++)c(b.performance.getEntriesByType(h[a]))}function c(a){if(a&&Array.isArray(a)){for(var c=0,e=0;e<a.length;e++){var d=l.indexOf(a[e].name);if(-1!==d){var g=Math.round(b.performance.timing.navigationStart+a[e].startTime);f.uet(n[d],void 0,void 0,g);c++}}l.length===
c&&k()}}function k(){a&&a.disconnect&&"function"===typeof a.disconnect&&a.disconnect()}if("function"===typeof f.uet&&b.performance&&"object"===typeof b.performance&&b.performance.getEntriesByType&&"function"===typeof b.performance.getEntriesByType&&b.performance.timing&&"object"===typeof b.performance.timing&&"number"===typeof b.performance.timing.navigationStart){var d={entryTypes:["paint"]},l=["first-paint","first-contentful-paint"],n=["fp","fcp"],a;try{m(),g()}catch(p){f.ueLogError(p,{logLevel:"ERROR",
attribution:"performanceMetrics"})}}})(ue_csm,window);


if (window.csa) {
    csa("Events")("setEntity", {
        page:{pageType: "Detail", subPageType: "Glance", pageTypeId: "B010777768"}
    });
}
csa.plugin(function(c){var m="transitionStart",n="pageVisible",e="PageTiming",t="visibilitychange",s="$latency.visible",i=c.global,r=(i.performance||{}).timing,a=["navigationStart","unloadEventStart","unloadEventEnd","redirectStart","redirectEnd","fetchStart","domainLookupStart","domainLookupEnd","connectStart","connectEnd","secureConnectionStart","requestStart","responseStart","responseEnd","domLoading","domInteractive","domContentLoadedEventStart","domContentLoadedEventEnd","domComplete","loadEventStart","loadEventEnd"],u=c.config,o=i.Math,l=o.max,g=o.floor,d=i.document||{},f=(r||{}).navigationStart,v=f,p=0,S=null;if(i.Object.keys&&[].forEach&&!u["KillSwitch."+e]){if(!r||null===f||f<=0||void 0===f)return c.error("Invalid navigation timing data: "+f);S=new E({schemaId:"<ns>.PageLatency.6",producerId:"csa"}),"boolean"!=typeof d.hidden&&"string"!=typeof d.visibilityState||!d.removeEventListener?c.emit(s):b()?(c.emit(s),I(n,f)):c.on(d,t,function e(){b()&&(v=c.time(),d.removeEventListener(t,e),I(m,v),I(n,v),c.emit(s))}),c.once("$unload",h),c.once("$load",h),c.on("$pageTransition",function(){v=c.time()}),c.register(e,{mark:I,instance:function(e){return new E(e)}})}function E(e){var i,r=null,a=e.ent||{page:["pageType","subPageType","requestId"]},o=e.logger||c("Events",{producerId:e.producerId,lob:u.lob||"0"});if(!e||!e.producerId||!e.schemaId)return c.error("The producer id and schema Id must be defined for PageLatencyInstance.");function d(){return i||v}function n(){r=c.UUID()}this.mark=function(n,t){if(null!=n)return t=t||c.time(),n===m&&(i=t),c.once(s,function(){o("log",{messageId:r,__merge:function(e){e.markers[n]=function(e,n){return l(0,n-(e||v))}(d(),t),e.markerTimestamps[n]=g(t)},markers:{},markerTimestamps:{},navigationStartTimestamp:d()?new Date(d()).toISOString():null,schemaId:e.schemaId},{ent:a})}),t},n(),c.on("$beforePageTransition",n)}function I(e,n){e===m&&(v=n);var t=S.mark(e,n);c.emit("$timing:"+e,t)}function h(){if(!p){for(var e=0;e<a.length;e++)r[a[e]]&&I(a[e],r[a[e]]);p=1}}function b(){return!d.hidden||"visible"===d.visibilityState}});csa.plugin(function(c){var f,u,l="length",a="parentElement",t="target",i="getEntriesByName",e=null,r="_csa_flt",o="_csa_llt",s="previousSibling",d="visuallyLoaded",n="client",g="offset",h="scroll",m="Width",p="Height",v=n+m,y=n+p,E=g+m,S=g+p,x=h+m,O=h+p,b="_osrc",w="_elt",I="_eid",T=10,_=5,L=15,N=100,k=c.global,B=c.timeout,H=k.Math,W=H.max,C=H.floor,F=H.ceil,M=k.document||{},R=M.body||{},Y=M.documentElement||{},P=k.performance||{},X=(P.timing||{}).navigationStart,$=Date.now,D=Object.values||(c.types||{}).ovl,J=c("PageTiming"),V=c("SpeedIndexBuffers"),j=[],q=[],z=[],A=[],G=[],K=[],Q=.1,U=.1,Z=0,ee=0,ne=!0,te=0,ie=0,re=1==c.config["SpeedIndex.ForceReplay"],oe=0,ae=1,fe=0,ce={},ue=[],le=0;function se(){for(var e=$(),n=0;f;){if(0!==f[l]){if(!1!==f.h(f[0])&&f.shift(),n++,!re&&n%T==0&&$()-e>_)break}else f=f.n}Z=0,f&&(Z||(!0===M.hidden?(re=1,se()):c.timeout(se,0)))}function de(e,n,t,i,r){fe=C(e),j=n,q=t,z=i,K=r;var o=M.createTreeWalker(M.body,NodeFilter.SHOW_TEXT,null,null),a={w:k.innerWidth,h:k.innerHeight,x:k.pageXOffset,y:k.pageYOffset};M.body[w]=e,A.push({w:o,vp:a}),G.push({img:M.images,iter:0}),j.h=ge,(j.n=q).h=he,(q.n=z).h=me,(z.n=A).h=pe,(A.n=G).h=ve,(G.n=K).h=ye,f=j,se()}function ge(e){e.m.forEach(function(e){for(var n=e;n&&(e===n||!n[r]||!n[o]);)n[r]||(n[r]=e[r]),n[o]||(n[o]=e[o]),n[w]=n[r]-X,n=n[s]})}function he(e){e.m.forEach(function(e){var n=e[t];b in n||(n[b]=e.oldValue)})}function me(n){n.m.forEach(function(e){e[t][w]=n.t-X})}function pe(e){for(var n,t=e.vp,i=e.w,r=T;(n=i.nextNode())&&0<r;){r-=1;var o=(n[a]||{}).nodeName;"SCRIPT"!==o&&"STYLE"!==o&&"NOSCRIPT"!==o&&"BODY"!==o&&0!==(n.nodeValue||"").trim()[l]&&be(n[a],Ee(n),t)}return!n}function ve(e){for(var n={w:k.innerWidth,h:k.innerHeight,x:k.pageXOffset,y:k.pageYOffset},t=T;e.iter<e.img[l]&&0<t;){var i,r=e.img[e.iter],o=Oe(r),a=o&&Ee(o)||Ee(r);o?(o[w]=a,i=xe(o.querySelector('[aria-posinset="1"] img')||r)||a,r=o):i=xe(r)||a,ie&&u<i&&(i=a),be(r,i,n),e.iter+=1,t-=1}return e.img[l]<=e.iter}function ye(e){var n=[],i=0,r=0,o=ee,t=k.innerHeight||W(R[O]||0,R[S]||0,Y[y]||0,Y[O]||0,Y[S]||0),a=C(e.y/N),f=F((e.y+t)/N);ue.slice(a,f).forEach(function(e){(e.elems||[]).forEach(function(e){e.lt in n||(n[e.lt]={}),e.id in n[e.lt]||(i+=(n[e.lt][e.id]=e).a)})}),D(n).forEach(function(e){D(e).forEach(function(e){var n=1-r/i,t=W(e.lt,o);le+=n*(t-o),o=t,function(e,n){var t;for(;Q<=1&&Q-.01<=e;)we(d+(t=(100*Q).toFixed(0)),n.lt),"50"!==t&&"90"!==t||c("Content",{target:n.e})("mark",d+t,X+F(n.lt||0)),Q+=U}((r+=e.a)/i,e)})}),ee=e.t-X,K[l]<=1&&(we("speedIndex",le),we(d+"0",fe)),ne&&(ne=!1,we("atfSpeedIndex",le))}function Ee(e){for(var n=e[a],t=L;n&&0<t;){if(n[w]||0===n[w])return W(n[w],fe);n=n.parentElement,t-=1}}function Se(e,n){if(e){if(!e.indexOf("data:"))return Ee(n);var t=P[i](e)||[];if(0<t[l])return W(F(t[0].responseEnd||0),fe)}}function xe(e){return Se(e[b],e)||Se(e.currentSrc,e)||Se(e.src,e)}function Oe(e){for(var n=10,t=e.parentElement;t&&0<n;){if(t.classList&&t.classList.contains("a-carousel-viewport"))return t;t=t.parentElement,n-=1}return null}function be(e,n,t){if((n||0===n)&&!e[I]){var i=e.getBoundingClientRect(),r=i.width*i.height,o=t.w||W(R[x]||0,R[E]||0,Y[v]||0,Y[x]||0,Y[E]||0)||i.right,a=i.width/2,f=ae++;if(0!=r&&!(a<i.right-o||i.right<a)){for(var c={e:e,lt:n,a:r,id:f},u=C((i.top+t.y)/N),l=F((i.top+t.y+i.height)/N),s=u;s<=l;s++)s in ue||(ue[s]={elems:[],lt:0}),ue[s].elems.push(c);e[I]=f}}}function we(e,n){J("mark",e,X+F((ce[e]=n)||0))}function Ie(e){oe||(V("getBuffers",de),oe=1)}X&&D&&P[i]&&(V("registerListener",function(){ie&&(clearTimeout(te),te=B(Ie.bind(e,"Mut"),2500))}),c.once("$unload",function(){re=1,Ie()}),c.once("$load",function(){ie=1,u=$()-X,te=B(Ie.bind(e,"Ld"),2500)}),c.once("$timing:functional",Ie.bind(e,"Fn")),V("replayModuleIsLive"),c.register("SpeedIndex",{getMarkers:function(e){e&&e(JSON.parse(JSON.stringify(ce)))}}))});csa.plugin(function(e){var m=!!e.config["LCP.elementDedup"],t=!1,n=e("PageTiming"),r=e.global.PerformanceObserver,a=e.global.performance;function i(){return a.timing.navigationStart}function o(){t||function(o){var l=new r(function(e){var t=e.getEntries();if(0!==t.length){var n=t[t.length-1];if(m&&""!==n.id&&n.element&&"IMG"===n.element.tagName){for(var r={},a=t[0],i=0;i<t.length;i++)t[i].id in r||(""!==t[i].id&&(r[t[i].id]=!0),a.startTime<t[i].startTime&&(a=t[i]));n=a}l.disconnect(),o({startTime:n.startTime,renderTime:n.renderTime,loadTime:n.loadTime})}});try{l.observe({type:"largest-contentful-paint",buffered:!0})}catch(e){}}(function(e){e&&(t=!0,n("mark","largestContentfulPaint",Math.floor(e.startTime+i())),e.renderTime&&n("mark","largestContentfulPaint.render",Math.floor(e.renderTime+i())),e.loadTime&&n("mark","largestContentfulPaint.load",Math.floor(e.loadTime+i())))})}r&&a&&a.timing&&(e.once("$unload",o),e.once("$load",o),e.register("LargestContentfulPaint",{}))});csa.plugin(function(r){var e=r("Metrics",{producerId:"csa"}),n=r.global.PerformanceObserver;n&&(n=new n(function(r){var t=r.getEntries();if(0===t.length||!t[0].processingStart||!t[0].startTime)return;!function(r){r=r||0,n.disconnect(),0<=r?e("recordMetric","firstInputDelay",r):e("recordMetric","firstInputDelay.invalid",1)}(t[0].processingStart-t[0].startTime)}),function(){try{n.observe({type:"first-input",buffered:!0})}catch(r){}}())});csa.plugin(function(d){var e="Metrics",g=d.config,f=0;function r(i){var c,t,e=i.producerId,r=i.logger,o=r||d("Events",{producerId:e,lob:g.lob||"0"}),s=(i||{}).dimensions||{},u={},n=-1;if(!e&&!r)return d.error("Either a producer id or custom logger must be defined");function a(){n!==f&&(c=d.UUID(),t=d.UUID(),u={},n=f)}this.recordMetric=function(r,n){var e=i.logOptions||{ent:{page:["pageType","subPageType","requestId"]}};e.debugMetric=i.debugMetric,a(),o("log",{messageId:c,schemaId:i.schemaId||"<ns>.Metric.4",metrics:{},dimensions:s,__merge:function(e){e.metrics[r]=n}},e)},this.recordCounter=function(r,e){var n=i.logOptions||{ent:{page:["pageType","subPageType","requestId"]}};if("string"!=typeof r||"number"!=typeof e||!isFinite(e))return d.error("Invalid type given for counter name or counter value: "+r+"/"+e);a(),r in u||(u[r]={});var c=u[r];"f"in c||(c.f=e),c.c=(c.c||0)+1,c.s=(c.s||0)+e,c.l=e,o("log",{messageId:t,schemaId:i.schemaId||"<ns>.InternalCounters.3",c:{},__merge:function(e){r in e.c||(e.c[r]={}),c.fs||(c.fs=1,e.c[r].f=c.f),1<c.c&&(e.c[r].s=c.s,e.c[r].l=c.l,e.c[r].c=c.c)}},n)}}g["KillSwitch."+e]||(new r({producerId:"csa"}).recordMetric("baselineMetricEvent",1),d.on("$beforePageTransition",function(){f++}),d.register(e,{instance:function(e){return new r(e||{})}}))});csa.plugin(function(s){var n=s.config,r=(s.global.performance||{}).timing,c=(r||{}).navigationStart||s.time(),g=0;function e(){g+=1}function i(i){i=i||{};var o=s.UUID(),t=g,r=i.producerId,e=i.logger,a=e||s("Events",{producerId:r,lob:n.lob||"0"});if(!r&&!e)return s.error("Either a producer id or custom logger must be defined");this.mark=function(e,r){var n=(void 0===r?s.time():r)-c;t!==g&&(t=g,o=s.UUID()),a("log",{messageId:o,schemaId:i.schemaId||"<ns>.Timer.1",markers:{},__merge:function(r){r.markers[e]=n}},i.logOptions)}}r&&(e(),s.on("$beforePageTransition",e),s.register("Timers",{instance:function(r){return new i(r||{})}}))});csa.plugin(function(t){var e="takeRecords",i="disconnect",n="function",o=t("Metrics",{producerId:"csa"}),c=t("PageTiming"),a=t.global,u=t.timeout,r=t.on,f=a.PerformanceObserver,m=0,l=!1,s=0,d=a.performance,h=a.document,v=null,y=!1,g=t.blank;function p(){l||(l=!0,clearTimeout(v),typeof f[e]===n&&f[e](),typeof f[i]===n&&f[i](),o("recordMetric","documentCumulativeLayoutShift",m),c("mark","cumulativeLayoutShiftLastTimestamp",Math.floor(s+d.timing.navigationStart)))}f&&d&&d.timing&&h&&(f=new f(function(t){v&&clearTimeout(v);t.getEntries().forEach(function(t){t.hadRecentInput||(m+=t.value,s<t.startTime&&(s=t.startTime))}),v=u(p,5e3)}),function(){try{f.observe({type:"layout-shift",buffered:!0}),v=u(p,5e3)}catch(t){}}(),g=r(h,"click",function(t){y||(y=!0,o("recordMetric","documentCumulativeLayoutShiftToFirstInput",m),g())}),r(h,"visibilitychange",function(){"hidden"===h.visibilityState&&p()}),t.once("$unload",p))});csa.plugin(function(e){var t,n=e.global,r=n.PerformanceObserver,c=e("Metrics",{producerId:"csa"}),o=0,i=0,a=-1,l=n.Math,f=l.max,u=l.ceil;if(r){t=new r(function(e){e.getEntries().forEach(function(e){var t=e.duration;o+=t,i+=t,a=f(t,a)})});try{t.observe({type:"longtask",buffered:!0})}catch(e){}t=new r(function(e){0<e.getEntries().length&&(i=0,a=-1)});try{t.observe({type:"largest-contentful-paint",buffered:!0})}catch(e){}e.on("$unload",g),e.on("$beforePageTransition",g)}function g(){c("recordMetric","totalBlockingTime",u(i||0)),c("recordMetric","totalBlockingTimeInclLCP",u(o||0)),c("recordMetric","maxBlockingTime",u(a||0)),i=o=0,a=-1}});csa.plugin(function(o){var e="CacheDetection",r="csa-ctoken-",c=o.store,t=o.deleteStored,n=o.config,i=n[e+".RequestID"],a=n[e+".Callback"],s=o.global,u=s.document||{},d=s.Date,l=o("Events"),f=o("Events",{producerId:"csa",lob:n.lob||"0"});function p(e){try{var c=u.cookie.match(RegExp("(^| )"+e+"=([^;]+)"));return c&&c[2].trim()}catch(e){}}n["KillSwitch."+e]||(function(){var e=function(){var e=p("cdn-rid");if(e)return{r:e,s:"cdn"}}()||function(){if(o.store(r+i))return{r:o.UUID().toUpperCase().replace(/-/g,"").slice(0,20),s:"device"}}()||{},c=e.r,n=e.s;if(!!c){var t=p("session-id");!function(e,c,n,t){l("setEntity",{page:{pageSource:"cache",requestId:e,cacheRequestId:i,cacheSource:t},session:{id:n}})}(c,0,t,n),"device"===n&&f("log",{schemaId:"<ns>.CacheImpression.2"},{ent:"all"}),a&&a(c,t,n)}}(),c(r+i,d.now()+36e5),o.once("$load",function(){var n=d.now();t(function(e,c){return 0==e.indexOf(r)&&parseInt(c)<n})}))});csa.plugin(function(u){var i,t="Content",e="MutationObserver",n="addedNodes",a="querySelectorAll",f="matches",r="getAttributeNames",o="getAttribute",s="dataset",c="widget",l="producerId",d="slotId",h="iSlotId",g={ent:{element:1,page:["pageType","subPageType","requestId"]}},p=5,m=u.config[t+".BubbleUp.SearchDepth"]||35,y=u.config[t+".SearchPage"]||0,v="csaC",b=v+"Id",E="logRender",w={},I=u.config,O=I[t+".Selectors"]||[],C=I[t+".WhitelistedAttributes"]||{href:1,class:1},N=I[t+".EnableContentEntities"],S=I["KillSwitch.ContentRendered"],k=u.global,A=k.document||{},U=A.documentElement,L=k.HTMLElement,R={},_=[],j=function(t,e,n,i){var o=this,r=u("Events",{producerId:t||"csa",lob:I.lob||"0"});e.type=e.type||c,o.id=e.id,o.l=r,o.e=e,o.el=n,o.rt=i,o.dlo=g,o.op=W(n,"csaOp"),o.log=function(t,e){r("log",t,e||g)},o.entities=function(t){t(e)},e.id&&r("setEntity",{element:e})},x=j.prototype;function D(t){var e=(t=t||{}).element,n=t.target;return e?function(t,e){var n;n=t instanceof L?K(t)||Y(e[l],t,z,u.time()):R[t.id]||H(e[l],0,t,u.time());return n}(e,t):n?M(n):u.error("No element or target argument provided.")}function M(t){var e=function(t){var e=null,n=0;for(;t&&n<m;){if(n++,P(t,b)){e=t;break}t=t.parentElement}return e}(t);return e?K(e):new j("csa",{id:null},null,u.time())}function P(t,e){if(t&&t.dataset)return t.dataset[e]}function T(t,e,n){_.push({n:n,e:t,t:e}),B()}function q(){for(var t=u.time(),e=0;0<_.length;){var n=_.shift();if(w[n.n](n.e,n.t),++e%10==0&&u.time()-t>p)break}i=0,_.length&&B()}function B(){i=i||u.raf(q)}function X(t,e,n){return{n:t,e:e,t:n}}function Y(t,e,n,i){var o=u.UUID(),r={id:o},c=M(e);return e[s][b]=o,n(r,e),c&&c.id&&(r.parentId=c.id),H(t,e,r,i)}function $(t){return isNaN(t)?null:Math.round(t)}function H(t,e,n,i){N&&(n.schemaId="<ns>.ContentEntity.2"),n.id=n.id||u.UUID();var o=new j(t,n,e,i);return function(t){return!S&&((t.op||{}).hasOwnProperty(E)||y)}(o)&&function(t,e){var n={},i=u.exec($);t.el&&(n=t.el.getBoundingClientRect()),t.log({schemaId:"<ns>.ContentRender.3",timestamp:e,width:i(n.width),height:i(n.height),positionX:i(n.left+k.pageXOffset),positionY:i(n.top+k.pageYOffset)})}(o,i),u.emit("$content.register",o),R[n.id]=o}function K(t){return R[(t[s]||{})[b]]}function W(n,i){var o={};return r in(n=n||{})&&Object.keys(n[s]).forEach(function(t){if(!t.indexOf(i)&&i.length<t.length){var e=function(t){return(t[0]||"").toLowerCase()+t.slice(1)}(t.slice(i.length));o[e]=n[s][t]}}),o}function z(t,e){r in e&&(function(t,e){var n=W(t,v);Object.keys(n).forEach(function(t){e[t]=n[t]})}(e,t),d in t&&(t[h]=t[d]),function(e,n){(e[r]()||[]).forEach(function(t){t in C&&(n[t]=e[o](t))})}(e,t))}U&&A[a]&&k[e]&&(O.push({selector:"*[data-csa-c-type]",entity:z}),O.push({selector:".celwidget",entity:function(t,e){z(t,e),t[d]=t[d]||e[o]("cel_widget_id")||e.id,t.legacyId=e[o]("cel_widget_id")||e.id,t.type=t.type||c}}),w[1]=function(t,e){t.forEach(function(t){t[n]&&t[n].constructor&&"NodeList"===t[n].constructor.name&&Array.prototype.forEach.call(t[n],function(t){_.unshift(X(2,t,e))})})},w[2]=function(r,c){a in r&&f in r&&O.forEach(function(t){for(var e=t.selector,n=r[f](e),i=r[a](e),o=i.length-1;0<=o;o--)_.unshift(X(3,{e:i[o],s:t},c));n&&_.unshift(X(3,{e:r,s:t},c))})},w[3]=function(t,e){var n=t.e;K(n)||Y("csa",n,t.s.entity,e)},w[4]=function(){u.register(t,{instance:D})},new k[e](function(t){T(t,u.time(),1)}).observe(U,{childList:!0,subtree:!0}),T(U,u.time(),2),T(null,u.time(),4),u.on("$content.export",function(e){Object.keys(e).forEach(function(t){x[t]=e[t]})}))});csa.plugin(function(o){var i,t="ContentImpressions",e="KillSwitch.",n="IntersectionObserver",r="getAttribute",s="dataset",c="intersectionRatio",a="csaCId",m=1e3,l=o.global,f=o.config,u=f[e+t],v=f[e+t+".ContentViews"],g=((l.performance||{}).timing||{}).navigationStart||o.time(),d={};function h(t){t&&(t.v=1,function(t){t.vt=o.time(),t.el.log({schemaId:"<ns>.ContentView.4",timeToViewed:t.vt-t.el.rt,pageFirstPaintToElementViewed:t.vt-g})}(t))}function I(t){t&&!t.it&&(t.i=o.time()-t.is>m,function(t){t.it=o.time(),t.el.log({schemaId:"<ns>.ContentImpressed.3",timeToImpressed:t.it-t.el.rt,pageFirstPaintToElementImpressed:t.it-g})}(t))}!u&&l[n]&&(i=new l[n](function(t){var n=o.time();t.forEach(function(t){var e=function(t){if(t&&t[r])return d[t[s][a]]}(t.target);if(e){o.emit("$content.intersection",{meta:e.el,t:n,e:t});var i=t.intersectionRect;t.isIntersecting&&0<i.width&&0<i.height&&(v||e.v||h(e),.5<=t[c]&&!e.is&&(e.is=n,e.timer=o.timeout(function(){I(e)},m))),t[c]<.5&&!e.it&&e.timer&&(l.clearTimeout(e.timer),e.is=0,e.timer=0)}})},{threshold:[0,.5,.99]}),o.on("$content.register",function(t){var e=t.el;e&&(d[t.id]={el:t,v:0,i:0,is:0,vt:0,it:0},i.observe(e))}))});csa.plugin(function(e){e.config["KillSwitch.ContentLatency"]||e.emit("$content.export",{mark:function(t,n){var o=this;o.t||(o.t=e("Timers",{logger:o.l,schemaId:"<ns>.ContentLatency.4",logOptions:o.dlo})),o.t("mark",t,n)}})});csa.plugin(function(t){function n(i,e,o){var c={};function r(t,n,e){t in c&&o<=n-c[t].s&&(function(n,e,i){if(!p)return;E(function(t){T(n,t),t.w[n][e]=a((t.w[n][e]||0)+i)})}(t,i,n-c[t].d),c[t].d=n),e||delete c[t]}this.update=function(t,n){n.isIntersecting&&e<=n.intersectionRatio?function(t,n){t in c||(c[t]={s:n,d:n})}(t,u()):r(t,u())},this.stopAll=function(t){var n=u();for(var e in c)r(e,n,t)},this.reset=function(){var t=u();for(var n in c)c[n].s=t,c[n].d=t}}var e=t.config,u=t.time,i="ContentInteractionsSummary",o=e[i+".FlushInterval"]||5e3,c=e[i+".FlushBackoff"]||1.5,r=t.global,s=t.on,a=Math.floor,f=(r.document||{}).documentElement||{},l=((r.performance||{}).timing||{}).responseStart||t.time(),d=o,m=0,p=!0,v=t.UUID(),g=t("Events",{producerId:"csa",lob:e.lob||"0"}),w=new n("it0",0,0),I=new n("it50",.5,1e3),h=new n("it100",.99,0),b={},A={};function $(){w.stopAll(!0),I.stopAll(!0),h.stopAll(!0),S()}function C(){w.reset(),I.reset(),h.reset(),S()}function S(){d&&(clearTimeout(m),m=t.timeout($,d),d*=c)}function U(n){E(function(t){T(n,t),t.w[n].mc=(t.w[n].mc||0)+1})}function E(t){g("log",{messageId:v,schemaId:"<ns>.ContentInteractionsSummary.2",w:{},__merge:t},{ent:{page:["requestId"]}})}function T(t,n){t in n.w||(n.w[t]={})}e["KillSwitch."+i]||(s("$content.intersection",function(t){if(t&&t.meta&&t.e){var n=t.meta.id;if(n in b){var e=t.e.boundingClientRect||{};e.width<5||e.height<5||(w.update(n,t.e),I.update(n,t.e),h.update(n,t.e),!t.e.isIntersecting||n in A||(A[n]=1,function(n,e){E(function(t){T(n,t),t.w[n].ttfv=a(e)})}(n,u()-l)))}}}),s("$content.register",function(t){(t.e||{}).slotId&&(b[t.id]={},function(e){E(function(t){var n=e.id;T(n,t),t.w[n].sid=(e.e||{}).slotId,t.w[n].cid=(e.e||{}).contentId})}(t))}),s("$beforePageTransition",function(){$(),C(),v=t.UUID(),S()}),s("$beforeunload",function(){w.stopAll(),I.stopAll(),h.stopAll(),d=null}),s("$visible",function(t){t?C():($(),clearTimeout(m)),p=t},{buffered:1}),s(f,"click",function(t){for(var n=t.target,e=25;n&&0<e;){var i=(n.dataset||{}).csaCId;i&&U(i),n=n.parentElement,e-=1}},{capture:!0,passive:!0}),S())});csa.plugin(function(d){var t,o,e="normal",c="reload",i="history",s="new-tab",n="ajax",r=1,a=2,u="lastActive",l="lastInteraction",f="used",p="csa-tabbed-browsing",y="visibilityState",g="page",v="experience",b="request",I="initialized",m={"back-memory-cache":1,"tab-switch":1,"history-navigation-page-cache":1},h="TabbedBrowsing",T="<ns>."+h+".4",S="visible",w=d.global,x=d.config,P=d("Events",{producerId:"csa",lob:x.lob||"0"}),q=w.location||{},z=w.document,A=w.JSON,C=((w.performance||{}).navigation||{}).type,E=d.store,O=d.on,$=d.storageSupport(),k=!1,R={},j={},B={},J={},K={},M=!1,N=!1,D=!1,F=0,G=x["CSA.isRunningInsideMShop"];function H(e){try{return A.parse(E(p,void 0,{session:e})||"{}")||{}}catch(e){d.error('Could not parse storage value for key "'+p+'": '+e)}return{}}function L(e,i){E(p,A.stringify(i||{}),{session:e})}function Q(e){var i=j.tid||e.id,t={},n=R[u]||{};for(var r in n)n.hasOwnProperty(r)&&(t[r]=n[r]);!G&&t.tid!==i||(t.tid=i,t.pid=e.id,t.ent=K),J={pid:e.id,tid:i,ent:K,lastInteraction:j[l]||{},initialized:!0},B={lastActive:t,lastInteraction:R[l]||{},time:d.time(),initialized:!0}}function U(e){var i=e===s,t=z.referrer,n=!(t&&t.length)||!~t.indexOf(q.origin||""),r=i&&!G&&n,a={type:e,toTabId:J.tid,toPageId:J.pid,transitTime:d.time()-R.time||null};r||function(e,i,t){var n=e===c,r=i||G&&!(j[I]&&j.ent)?R[u]||{}:j,a=R[l]||{},d=j[l]||{},o=i||G&&!(d.id&&!d[f])?a:d;t.fromTabId=r.tid,t.fromPageId=r.pid;var s=r.ent||{};s.rid&&(t.fromRequestId=s.rid||null),s.ety&&(t.fromExperienceType=s.ety||null),s.esty&&(t.fromExperienceSubType=s.esty||null),n||!o.id||o[f]||(t.interactionId=o.id||null,o.sid&&(t.interactionSlotId=o.sid||null),a.id===o.id&&(a[f]=!0),d.id===o.id&&(d[f]=!0))}(e,i,a),P("log",{navigation:a,schemaId:T},{ent:{page:["pageType","subPageType","requestId"]}})}function V(e){D=function(e){return e&&e in m}(e.transitionType),function(){R=H(!1),j=H(!0);var e=R[l],i=j[l],t=!1,n=!1;e&&i&&e.id===i.id&&e[f]!==i[f]&&(t=!e[f],n=!i[f],i[f]=e[f]=!0,t&&L(!1,R),n&&L(!0,j))}(),Q(e),M=!0,function(e){var i,t;i=X(),t=Z(!0),(i||t)&&Q(e)}(e),F=1}function W(){k&&!D?U(n):(k=!0,function(){if(C===a||D)U(i);else if(C===r)U(j[I]?c:s);else{U(j[I]||G&&R[I]?e:s)}}())}function X(){var e=t,i={};return!!(M&&e&&e.e&&e.w)&&(e.w("entities",function(e){i=e||{}}),j[l]={id:e.e.messageId,sid:i.slotId,used:!(R[l]={id:e.e.messageId,sid:i.slotId,used:!1})},!(t=null))}function Y(e,i,t,n){var r=!1,a=e[u];return N?(!a||a.tid!==J.tid||!a[S]||a.pid!==t||!a.ent&&n||n&&function(e,i){var t=e||{},n=i||{};return t.rid!==n.rid||t.ety!==n.ety||t.esty!==n.esty}(a.ent,n))&&(e[u]={visible:!0,pid:t,tid:i,ent:n},r=!0):!G&&a&&a.tid===J.tid&&a[S]&&(r=!(a[S]=!1)),r}function Z(e){var i=!1;if(N=G&&e||z[y]===S,M){var t=R[u]||{};i=Y(R,j.tid||t.tid||J.tid,j.pid||t.pid||J.pid,j.ent||t.ent||J.ent)}return i}x["KillSwitch."+h]||$.local&&$.session&&A&&z&&y in z&&(o=function(){try{return w.self!==w.top}catch(e){return!0}}(),O("$entities.set",function(e){if(!o&&e){var i=(e[b]||{}).id||(e[g]||{}).requestId,t=(e[v]||{}).experienceType||(e[g]||{}).pageType,n=(e[v]||{}).experienceSubType||(e[g]||{}).subPageType,r=!K.rid&&i||!K.ety&&t||!K.esty&&n;if(K.rid=K.rid||i,K.ety=K.ety||t,K.esty=K.esty||n,r&&F){var a=R[u]||{};a.tid===j.tid&&(a.ent=K,L(!1,R)),j.ent=K,L(!0,j)}}},{buffered:1}),O("$pageChange",function(e){o||(V(e),W(),L(!1,B),L(!0,J),j=J,R=B)},{buffered:1}),O("$content.interaction",function(e){t=e,X()&&(L(!1,R),L(!0,j))}),O(z,"visibilitychange",function(){!o&&Z()&&L(!1,R)},{capture:!1,passive:!0}))});csa.plugin(function(c){var e=c("Metrics",{producerId:"csa"});c.on(c.global,"pageshow",function(c){c&&c.persisted&&e("recordMetric","bfCache",1)})});csa.plugin(function(n){var e,t,i,o,r,a,c,u,f,s,l,d,p,g,m,v,h,b,y="hasFocus",S="$app.",T="avail",$="client",w="document",I="inner",P="offset",D="screen",C="scroll",E="Width",F="Height",O=T+E,q=T+F,x=$+E,z=$+F,H=I+E,K=I+F,M=P+E,W=P+F,X=C+E,Y=C+F,j="up",k="down",A="none",B=20,G=n.config,J=G["KillSwitch.PageInteractionsSummary"],L=n("Events",{producerId:"csa",lob:G.lob||"0"}),N=1,Q=n.global||{},R=n.time,U=n.on,V=n.once,Z=Q[w]||{},_=Q[D]||{},nn=Q.Math||{},en=nn.abs,tn=nn.max,on=nn.ceil,rn=((Q.performance||{}).timing||{}).responseStart,an=function(){return Z[y]()},cn=1,un=100,fn={},sn=1,ln=0,dn=0,pn=k,gn=A;function mn(){c=t=o=r=e,i=d=0,a=u=f=s=l=0,pn=k,gn=A,dn=ln=0,yn(),bn()}function vn(){rn&&!o&&(c=on((o=p)-rn),sn=1)}function hn(){var n=m-i;(!t||t&&t<=p)&&(n&&(++a,sn=dn=1),i=m,n),function(){if(gn=d<m?k:j,pn!==gn){var n=en(m-d);B<n&&(++l,ln&&!dn&&++a,pn=gn,sn=ln=1,d=m,dn=0)}else dn=0,d=m}(),t=p+un}function bn(){u=on(tn(u,m+b)),g&&(f=on(tn(f,g+h))),sn=1}function yn(){p=R(),g=en(Q.pageXOffset||0),m=tn(Q.pageYOffset||0,0),v=0<g||0<m,h=Q[H]||0,b=Q[K]||0}function Sn(){yn(),vn(),hn(),bn()}function Tn(){if(r){var n=on(R()-r);s+=n,r=e,sn=0<n}}function $n(){r=r||R()}function wn(n,e,t,i){e[n+E]=on(t||0),e[n+F]=on(i||0)}function In(n){var e=n===fn,t=an();if(t||sn){if(!e){if(!N)return;N=0,t&&Tn()}var i=function(){var n={},e=Z.documentElement||{},t=Z.body||{};return wn("availableScreen",n,_[O],_[q]),wn(w,n,tn(t[X]||0,t[M]||0,e[x]||0,e[X]||0,e[M]||0),tn(t[Y]||0,t[W]||0,e[z]||0,e[Y]||0,e[W]||0)),wn(D,n,_.width,_.height),wn("viewport",n,Q[H],Q[K]),n}(),o=function(){var n={scrollCounts:a,reachedDepth:u,horizontalScrollDistance:f,dwellTime:s,vScrollDirChanges:l};return"number"==typeof c&&(n.clientTimeToFirstScroll=c),n}();e?sn=0:(mn(),rn=R(),t&&(r=rn)),L("log",{activity:o,dimensions:i,schemaId:"<ns>.PageInteractionsSummary.3"},{ent:{page:["pageType","subPageType","requestId"]}})}}function Pn(){Tn(),In(fn)}function Dn(n,e){return function(){cn=e,n()}}function Cn(){an=function(){return cn},cn&&!r&&(r=R())}"function"!=typeof Z[y]||J||(mn(),v&&vn(),U(Q,C,Sn,{passive:!0}),U(Q,"blur",Pn),U(Q,"focus",Dn($n,1)),V(S+"android",Cn),V(S+"ios",Cn),U(S+"pause",Dn(Pn,0)),U(S+"resume",Dn($n,1)),U(S+"resign",Dn(Pn,0)),U(S+"active",Dn($n,1)),an()&&(r=rn||R()),V("$beforeunload",In),U("$beforeunload",In),U("$document.hidden",Pn),U("$beforePageTransition",In),U("$afterPageTransition",function(){sn=N=1}))});csa.plugin(function(e){var o,n,r="Navigator",a="<ns>."+r+".5",i=e.global,c=e.config,d=i.navigator||{},t=d.connection||{},l=i.Math.round,u=e("Events",{producerId:"csa",lob:c.lob||"0"});function v(){o={network:{downlink:void 0,downlinkMax:void 0,rtt:void 0,type:void 0,effectiveType:void 0,saveData:void 0},language:void 0,doNotTrack:void 0,hardwareConcurrency:void 0,deviceMemory:void 0,cookieEnabled:void 0,webdriver:void 0},w(),o.language=d.language||null,o.doNotTrack=function(){switch(d.doNotTrack){case"1":return"enabled";case"0":return"disabled";case"unspecified":return d.doNotTrack;default:return null}}(),o.hardwareConcurrency="hardwareConcurrency"in d?l(d.hardwareConcurrency||0):null,o.deviceMemory="deviceMemory"in d?l(d.deviceMemory||0):null,o.cookieEnabled="cookieEnabled"in d?d.cookieEnabled:null,o.webdriver="webdriver"in d?d.webdriver:null}function k(){u("log",{network:(n={},Object.keys(o.network).forEach(function(e){n[e]=o.network[e]+""}),n),language:o.language,doNotTrack:o.doNotTrack,hardwareConcurrency:o.hardwareConcurrency,deviceMemory:o.deviceMemory,cookieEnabled:o.cookieEnabled,webdriver:o.webdriver,schemaId:a},{ent:{page:["pageType","subPageType","requestId"]}})}function w(){!function(n){Object.keys(o.network).forEach(function(e){o.network[e]=n[e]})}({downlink:"downlink"in t?l(t.downlink||0):null,downlinkMax:"downlinkMax"in t?l(t.downlinkMax||0):null,rtt:"rtt"in t?(t.rtt||0).toFixed():null,type:t.type||null,effectiveType:t.effectiveType||null,saveData:"saveData"in t?t.saveData:null})}function f(){w(),k()}function y(){v(),k()}c["KillSwitch."+r]||(v(),k(),e.on("$afterPageTransition",y),e.on(t,"change",f))});
if (window.ue && window.ue.uels) {
    ue.uels("https://c.amazon-adsystem.com/bao-csm/forensics/a9-tq-forensics-incremental.min.js");
}


ue.exec(function(d,c){function g(e,c){e&&ue.tag(e+c);return!!e}function n(){for(var e=RegExp("^https://(.*.(images|ssl-images|media)-amazon.com|"+c.location.hostname+")/images/","i"),d={},h=0,k=c.performance.getEntriesByType("resource"),l=!1,b,a,m,f=0;f<k.length;f++)if(a=k[f],0<a.transferSize&&a.transferSize>=a.encodedBodySize&&(b=e.exec(String(a.name)))&&3===b.length){a:{b=a.serverTiming||[];for(a=0;a<b.length;a++)if("provider"===b[a].name){b=b[a].description;break a}b=void 0}b&&(l||(l=g(b,"_cdn_fr")),
a=d[b]=(d[b]||0)+1,a>h&&(m=b,h=a))}g(m,"_cdn_mp")}d.ue&&"function"===typeof d.ue.tag&&c.performance&&c.location&&n()},"cdnTagging")(ue_csm,window);


}
(n=>{var M,A=1e6,E=(n.Symbol||{}).iterator;n.RXVM=function(r){(r=r||{}).mi&&(A=r.mi);var i=n([1,function(n){n.u.t[m(n)]=h(n)},2,function(n){n.i[0].t[m(n)]=h(n)},3,h,4,function(n){var r=h(n),t=h(n),n=h(n);w(n)&&(n[t]=r)},5,function(n){var r=h(n),t=m(n);w(r)&&"function"==typeof r[E]&&(n.u.t[t]=r[E]())},6,function(n){var r=n.u.t[m(n)],r=r&&r.next?r.next():M,t=m(n),u=x(n);w(r)&&!1===r.done?n.u.t[t]=r.value:d(n,u)},10,function(n){n.u.o.push(h(n))},11,function(n){n.u.o.push(n.v)},12,function(n){for(var r=F(n);0<r--;)n.l.push(S(n))},30,function(n){return!h(n)},42,function(){},43,function(n){for(var r=F(n);0<r--;)n.u.t.push(n._.pop())},45,a(!0),44,a(!1),48,v(0,y),49,v(1,y),50,v(2,y),51,v(-1,y),52,v(0,_),53,v(1,_),54,v(2,_),55,v(-1,_),58,function(n){d(n,x(n))},59,s(!0),60,s(!1),64,function(n){var r=x(n),t=p(n,n.u.h);return d(n,r),t},65,function(n){var r=F(n),t=x(n),u=p(n,n.u.h);n.u.t[r]=u,d(n,t)}]),o={40:function(n,r){return"__rx_cls"in n?n.__rx_cls===r.__rx_ref:n instanceof r}},t=(o[20]=Math.pow,l(16,"+"),l(17,"-"),l(18,"*"),l(19,"/"),l(21,"%"),l(22,"&"),l(23,"|"),l(24,"^"),l(25,"<<"),l(26,">>"),l(27,">>>"),l(28,"&&"),l(29,"||"),l(31,">"),l(33,">="),l(32,"<"),l(34,"<="),l(35,"=="),l(36,"==="),l(37,"!="),l(38,"!=="),l(39," in "),n([10,M,11,null,14,!0,15,!1])),u=n([1,function(n){return n.v},17,F,18,function(n){n=m(n)|m(n)<<8|m(n)<<16|m(n)<<24;return n=2147483647<n?-4294967295+n-1:n},19,function(n){for(var r=[],t=0;t<4;t++)r.push(m(n));return new Float32Array(new Uint8Array(r).buffer)[0]},12,S,13,function(n){return n.l[F(n)]},20,function(){return[]},21,function(n){for(var r=F(n),t=[];0<r--;)t.unshift(h(n));return t},24,function(n){for(var r,t,u,i=F(n),o=[];0<i--;)o.unshift((u=t=void 0,r=m(r=n)|m(r)<<8,t=32768&r?-1:1,u=r>>10&31,r&=1023,31!=u?0==u?r/1024*t*6103515625e-14:t*(1+r/1024)*Math.pow(2,u-15):NaN));return o},22,function(){return{}},23,function(n){for(var r=F(n)/2,t={};0<r--;){var u=h(n);t[h(n)]=u}return t},32,function(n){return n.u.t[F(n)]},33,function(n){return n.i[0].t[F(n)]},48,function(n){var r=h(n),n=h(n);return w(n)?("function"==typeof(r=n[r])&&(r.__rx_this=n),r):n},50,function(n){return n.u.o.pop()},52,function(n){return typeof h(n)}]);function f(n){for(;0<n.p--&&(r=n).u&&r.u.h<r.m.length;){r=m(n);n.v=e(r,n)}var r}function e(n,r){var t,u;return n in o?(t=h(r),u=h(r),o[n](u,t)):n in i?i[n](r):void k("e2:"+n+":"+r.u.h)}function c(n,r){return{F:n,h:n,t:[],o:[],S:r}}function n(n){for(var r={},t=0;t<n.length;t+=2)r[n[t]]=n[t+1];return r}function a(i){return function(n){var r=i?h(n):M,t=n.i.pop(),u=M,u=t.S?t.t[0]:r;return n._=[],n.u=n.i[n.i.length-1],b(n,n.u.F),u}}function v(u,i){return function(n){var r=h(n),t=u;for(-1===u&&(t=F(n));0<t--;)n._.push(h(n));if(n.v=M,r)return i(r,n)}}function s(u){return function(n){var r=h(n),t=x(n);(u&&r||!r&&!u)&&d(n,t)}}function l(u,i){o[u]=function(n,r){var t=Function("a","b","return a"+i+"b");return(o[u]=t)(n,r)}}function _(n,r){var t;if(n.__rx_ref&&n.g===r){var u=c(n.__rx_ref,!0);u.t.push({__rx_cls:n.__rx_ref}),r.i.push(u),r.u=u,b(r,u.F)}else if("function"==typeof n){u=r._.reverse().splice(0),u=Function.prototype.bind.apply(n,[null].concat(u));try{t=new u,r._=[]}catch(n){}}else k("e5:"+n+":"+r.u.h);return t}function y(n,r){var t;if(n.__rx_ref&&n.g===r){var u=c(n.__rx_ref);u.t.push(n.__rx_this||this),r.i.push(u),r.u=u,b(r,u.F)}else if("function"==typeof n){u=r._.reverse().splice(0);try{t=n.apply(n.__rx_this||this,u),r._=[]}catch(n){}}else k("e4:"+n);return t}function h(n){var r=m(n);return 0<(128&r)?e(127&r,n):r in t?t[r]:r in u?u[r](n):void k("e3:"+r)}function p(t,u){var n=g(function(){var n=c(u),r=n.t;return r.push(this),r.push.apply(r,arguments),t.i.push(n),t.u=n,t.p=A,b(t,n.F),f(t),t.v});return n.__rx_ref=u,n.g=t,n}function w(n){if(n!==M&&null!==n)return 1;r.unsafe&&k("e10"+n)}function b(n,r){n.k=r%127+37}function d(n,r){n.u.h+=r}function m(n){return n.m[n.u.h++]^n.k}function x(n){n=m(n)|m(n)<<8;return n=32767<n?-65535+n-1:n}function F(n){for(var r,t=0,u=0,i=n.u.h;t+=(127&(r=n.m[i+u]^n.k))*Math.pow(2,7*u),u+=1,0<(128&r););return d(n,u),t}function S(n){for(var r=F(n),t="";0<r--;)t+=String.fromCharCode(m(n));return t}function g(n){return function(){try{return n.apply(this,arguments)}catch(n){k(n)}}}function k(n){if(r.unsafe)throw Error(n)}this.execute=g(function(n,r){var t,u;return 82!==n[0]&&88!==n[1]?k("e1"):(n=n,t=3,(u=c(0)).t[0]=(r=r)||{},u.h=t,b(r={m:n,p:A,v:0,i:[u],u:u,_:[],l:[],k:0},0),f(t=r),t)})}})("undefined"==typeof window?global:window);
(n=>{for(var t="undefined"==typeof window?n:window,i=0,n="addEventListener",e="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/".split(""),u=[],r=t.rx||{},o=r.c||{},f=o.rxp||"/rd/uedata",c=o.fi||1e3,a=1.5,d=1e4,x={},w={},m={},v={},h=0,l=0;l<e.length;l++)u[e[l]]=l;function p(n,r){return function(){try{return n.apply(this,arguments)}catch(n){s(n.message||n,n)}}}function s(n,r){if(m[i]=[(n=(""+(n||"")).substring(0,100)).length].concat((new TextEncoder).encode(n)),o.DEBUG)throw r||n;b()}function y(n,r){r=p(r),n in w||(w[n]=[]),w[n].push(r),n in x&&r()}function g(n,r){n in x||(x[n]=r,(w[n]||[]).forEach(function(n){n(r)}))}function A(n){for(var r=0,t=0,i="",o=0;o<n.length;o+=1)for(t+=8,r=r<<8|n[o];6<=t;)i+=e[r>>t-6],r&=255>>8-(t-=6);return 0<t&&(i+=e[r<<6-t]),i}function U(n){for(var r=0,t=0,i=[],o=0;o<n.length&&"="!==n[o];o+=1)for(t+=6,r=r<<6|u[n[o]];8<=t;)i.push(r>>t-8),r&=255>>8-(t-=8);return new Uint8Array(i)}function b(){!h&&0<c&&(setTimeout(p(I),c),c=Math.min(d,c*a),h=1)}function E(r){let t=[];return Object.keys(r).forEach(n=>{t.push(parseInt(n)),t=t.concat(r[n])}),t}function I(){h=0;var n=E(m);0<n.length&&rx.ep(n,T),m={}}function T(n){n=A(new Uint8Array(n));n=f+"?rid="+rx.rid+"&sid="+rx.sid+"&rx="+n;(new Image).src=n}function j(n){g("load",n)}function L(n){j(n),g("unload",n),I()}(t.rx=r).err=s,r.r=p(y),r.e=p(g),r.exec=p,r.p=p(function(n,r){g("rxm:"+n,r),m[255&n]=r,b()}),r.pc=p(function(n,r){v[255&n]=r,n=E(v),r=rx.ep4(n,rx.fnpb),n=A([rx.fnpv].concat(rx.fnpb,r)),document.cookie="rxc="+n+"; max-age=86400; path=/"}),r.ex64=p(function(r,n){y(n||"init",function(){var n;t.RXVM&&(n=U(r),t.$RX||(t.$RX=new t.RXVM({mi:o.mi})),$RX.execute(n,t))})}),r.e64=p(A),r.d64=p(U),r.erc4=p(function(){var n=rx.fnpb,r=rx.fnpv,t=rx.ep4(E(m),n);return A(new Uint8Array([r].concat(n,t)))}),g("init",{}),"complete"===document.readyState?j({}):n in t&&(t[n]("load",p(j)),t[n]("beforeunload",p(L)),t[n]("pagehide",p(L)))})(window);
rx.ex64("UlgBKT4nV10haERRTSFMSFBJIUFKS0AgU0RJUEAjSUBLQlFNIVFNQEsvSktGSkhVSUBRQC1GRElJR0RGTidCUSBDSUpKVyFhRFFAJktKUi9wTEtRHWRXV0RcJlZAUS5wTEtRFhdkV1dEXCNHUENDQFcjVlBHUUlAIkBLRldcVVEhS0RIQCJkYHYIZmdmI0FMQkBWUSJ2bWQIFxATIGFgZ3BiIUBdQEYmV0xBJlZMQSQkFSglBSUkJ7gzFSkkRgUkJCa4FSkjRldcVVFKBSUVKS1IVmZXXFVRSgUlZCIBJa6EsbWJjtHg/fHA6+bq4eD3pIWGtYmD4Ovm6uHghLSEpYSohGQtoiUFLy8sP8HTmNsjHw8pDi8rLy0oLSo0LhweIyweIy8PLj+f3fPfJ7YOKg4sLywvFM/RLyy2HiMrDi8OLC8strU/Pg4sDiwcHiMsHiMvDy4/xbqBgSYOLC8sLy8strU/Iw4sDiwcHiMsHiMvDy4/m/LkuyIOLC8sLy8strU/Pg4sDiwDtT8uDixkLD4lETk7PgoaOBo7PgoaORo7GjgaOz4aPho5GjsWZC+bJXJbWFpNWF1NWFxIWVhfSFlYXkhZWFFIWWX5SNlbeVFIWV15UXlReVpYUclIWHlRY7+mWFFIWWX5SNlbeVF3WVhczEjZW8lpzGlUXHlbeVF5W8lpeVF5WnlcanhQWnlceVF5WlhRyUhYeVFjkKZceVhQX1BTHFlYXsxI2VvJSFh5XlhfzEjZW8lpeV55WnlfanhQWnlfeV55WmhpVV0pLCoxeV3BacxI2VvJaXlfeVppeV55WnlaeVNj76Z0eV1kLmIlt56gO7ydkZqRnK2skZq8nbyesZ2ms5ygO7ydkZu7nJi8npGUvJ3cj5xsd3ZLTmZGdkpANCM1MyoyZkZql5iukZu8nbG8nbBkKbElQ2pU9fZJbPZJbmloRFhYZWRYZWNJaHt5gG9pY1lYZWJYZWlJaFp1aVhlYVhlaEloaWtpXVhlZUlo+FhlbUhpeWxpbGldWGVnSWh9aUhra1hleGljXVhlZUloWmNZWGVmSGxaWlhlZkhseWxIaVtYZXpYZXlJa2tIbElsf2556GllbUluZGoBHmV8ZXtjWkljSGpaRGQoXCWqg4CDHKCEoYO9H6GDgIGtsbGMjbGMiqCBkpBphoCKsLGMi7GMgKCBs5yAsYyIsYyBoIGAgoC0sYyMoIERsYyEoYCQhYCFgLSxjI6ggZSAoYKCsYyRgIq0sYyMoIGzirCxjI+hhbOzsYyPoYWQhaGAs6CLoYOhhayAZCsiJFR9Tl54X35+fn5OXnhffX59fk1PcmpPcm5efF9+cml0PxZ/iaOXkq+vg6KCo6Cno5GSrqvLz9LN0Nbpx9uSr7ODoae3oK6lxsfB0NvS1q+wrbWmsyKjr6evtq+xgqOuodDD1aniv6JMZmVjR2ZbV2pwRmVrZ2NGY2tiODgCFQxGZkpGY6mQg6mQkI+jdE1edE1Nfnx+TU9yak9ybl58X31yaXQ/VH8MJhUXKyJUS05EQgcmNjc2JyUhJhsXKjAGJSsnIwYhKyJ4eEJVTgYmCgYhdE1edE1Nfnt+Q09yaF59W39OT3N8HhMTT3N4Lw0QEhYMGl5/an1fe198dHtNc3sgIBoNXn5TFBUoPQUkBSkuIRcpJ0BVBSQUFSg9BSQFKC4hFykmQFURBSQUFSg9BSQFLy4hFyknQBEFJBQVKD0FJAUtLiEXKSRNBSQZuRUoPwUkFSg8BSQxJRQVKD0FJAUrFyQVKD8FJBUoPAUk","load");
rx.ex64("UlgBKSInV10hQUpLQCBTRElQQCNJQEtCUU0mVUpSIENJSkpXIFdKUEtBJCQVKSFAXUBGFSglBSUkJxUpIWhEUU0FJSQmFSkja1BIR0BXBSVkITklUnh4e2h5fFl4en96fXN5eHvpWX1Ze0OIhlRZe2QgNSWymKi4nbmYiqmUmrmYmLSYZCNnJQUvHw8rDi8vLC8vLT8uKw4vKigqKzkuHB4jKg8sPyy/DiwOKz4vDi0vLS8UytEfHiIqXV9cWg8svR4jLQ4vDi0DL2QiayVfdXV2RHl3VHVFVXFUdXV3dUVVclR1dXB1RUR5cVV2VHZiZYuLd3V/RUR5cVV2VHdiZYuLd3V/RUR5cVV2VHBiZYuLd3V/d2F3RkZGWXVkLWUlbEZ2ZkBnRkZFRmpSQdFWuEZ3VkVnRd1WT3dWRWdF0Va4RndWRmdF3VZPd1ZGZ0XRVrhGd1ZHZ0XdVk93VkdnRWQs1SWgirq7h4Pi+M3i5eL/7qqIq4qVipaKLYeN5f7m6e75v6uKgLq7h47i+MXqxaqIq4qAlrm5t4qDi6aeiZp3ipqLiomai7crmourioaLiomaCwuJiooaq4qai7cvmourioyLpp6Jmouai7q7h4/n5Oy5qomrioC6u4aOqom5ioiKubuGj6qJq4iaiZiKq4qamoqKmZoLg4qAuruGjaqJuYqPioqIG5qEq4i3KZqLq4iui7m7ho+qiZl5dHR0momYiquKmZoLg4qAuruGjaqJuYqPioqImouKjhyrjxwSmoGriKuJpp6JEZqDq44dmnSKq45kL6glqoCAgxaxkIGhgBiQibGQgKGAgIKQgL0XkAEBg6GDhoGAgpN+fn5+gIUXkJ4bkIuhg4CEF5B+hqGDvSWQnqGFiIGssY2Cz+DPoIK9JZCBoYWcgbOxjIWgg5Nzfn5+kIOTgBMSkAGJoYShgqyAu5yBs7GMhaCDEJCOoYWQg5OAExESkAGJoYSQgKGCrICtFAUkBSIuIRcpJ1ZEFSglBSUUBSQFLS4hFykmVkRHFSglBSUUBSQFLC4hFykhQEMUExUoJQUlFAUkBS8uIRcpIUFDFBMVKCUFJRQFJAUhLiEXKSFEVlBIFSglBSUUBSQFIC4hFykhRERTQhUoJQUlFAUkBSMuIRcpIURWUUEVKCUFJQ==","load");
rx.ex64("UlgBKS8sUkBHQVdMU0BXI2pHT0BGUSFOQFxWIkxLQUBdakMhQUpLQCBTRElQQCBkV1dEXCN2XEhHSkkgdVdKXVwnV10kJDQ1JCc0JCQmuDMVKSxLRFNMQkRRSlcFJSQhuDMVKS1BSkZQSEBLUQUlZCA2JbK1BgaolJLo9Pnh7+rx//DsuZhkIyglGh2tlxEwPTAAPTARM2QiCiVrcHFMQ3FMQGBBYEFEQEBHQENYQXBxTEJhQ01FIiUiHmVQQUB9QENBbE97o75sTmQtuyVeRUR5dkR5dVV0VXRxdXVydXb8dEVEeXdUdnhyKzUGBhUNVWV0dWh10nlyVHZo0ER5clV0RFR2VXR1SHV2dFl6RUR5d1R2eHMrJw0ZFhsYVWV0dWh10nlzVHZo0ER5c1V0RFR2VXR1SHV2dFl6RUR5d1R2eHIrJAYbDA1VZXR1aHXSeXxUdmjQRHl8VXREVHZVdHVIdXZ0WXpOB4tZe2QsBSW9ugowtpebnPT2+/vH//b54/j6MLaXm5/I5//2+eP4+mQv5iUWDQwwMV9OWV1IWXlQWVFZUkgdODA6X11SSl1PPT09DQwwNltZSH9TUkhZREgcPTA5S1leW1A9Pj0Aohw+PjwRMg0MMDBbWUh5REhZUk9VU1IcPjAla3l+e3BjWFleSVtjTllSWFlOWU5jVVJaUz8MMCtpcnF9b3d5eGNueXJ4eW55bmNreX57cD03DQwwMFtZSGxdTl1RWUhZThw+Dj0/PQCYNhw/PjwRMg0MMT8cPzA3b0tVWkhvVF1YWU4dLTw9ET1kLgYlrqkgtIiP7erq4fbM4e3j7PClhLSIj+vx8OH2zOHt4+zwpYRkKQ4lBgGIHCAmRUJCSV57RUhYRA0sHCAnT0BFSUJYe0VIWESxOhwgKE5DSFUNKCQoMC0FKQUuBS8FLAUtBSIFIwUgZCt5JUVubn5vbm1+b2pOYmxpbGtYb15fY2sKFwoMX2JmTm9Pa19ubmpuU8tlT2psb25qYVNPamVvbm749k9tfm5Pbm5t/35uT21Vq5BdX2NuH19iZk5vem1Pbk5tTm5DFxUpJFcVKCwFJQUrKSFJSkRB","load");
rx.ex64("UlgBKS8mVlVBNURBQWBTQEtRaUxWUUBLQFcsSEpQVkBBSlJLIkhKUFZAUFUhQF1ARjZXQEhKU0BgU0BLUWlMVlFAS0BXLFFMSEB2UURIVS5VQFdDSldIREtGQCZLSlIkVyQkNAUkJzQqJCYyISspIkZEVVFQV0ArKSJVRFZWTFNAJCE0zSIkILgzFSktQUpGUEhAS1EFJSQjFSkhaERRTQUlJCIVKSdXXQUlJC0VKS5WQFFsS1FAV1NESQUlJCwVKShGSUBEV2xLUUBXU0RJBSUkLyskLiokKjQlJDQxZDcBJaK0FRapgxapgomIpIqDh7m4hIr76amPqZmDuriFiKmPuqmJpGQ2EyUbAgE8MBA0MhAyED08MwIBPDAQNDIQMhA8PDINATwxEDYjMQABPDUQNhAjOgMQORA1AzM/MB1kMQElQWlhZFhbZm5KbmhKaEpnZmlYW2ZuSm5oSmhKZmZoWkpiSmVHZDAAJbmvDbKZkpO/kZmcoqOfkODy8bKUsoKSkpKho5+S47KUs5Kykr9kMzMlFjwNDTA1DTA6HD0gPA0wOx08Py08EWQyYSV8VmdnWl9nWlB2V0pWZ1pRd1ZWVVZWVMZ2R3dVVVjHRlZ2WFVcWWZnW1MnIiQ/dkZ3VGv2dlV2WF5XZ3ZCZ3ZFZ3ZDexQVKCEFIgUzJCkkFBUoIQUiBTIkKCQXFSgsBSIFNikhSUpEQRcVKCwFIgUwKSNQS0lKREE=","load");
rx.ex64("UlgBKS8mVlVBJ1ZEI0ZKS0ZEUSxISlBWQEhKU0AhQF1ARiZWREchRkBMSSFVUFZNJkRHViRXJCQ0BCQnNO0kJCY02iQkITIhKykiRkRVUVBXQCspIlVEVlZMU0AkIDTNIiQjuDMVKS1BSkZQSEBLUQUlJCIVKSFoRFFNBSUkLRUpJ1ddBSUkLBUpLlZAUWxLUUBXU0RJBSUkLxUpKEZJQERXbEtRQFdTREkFJSQoKyQrKiQ2NCUkMTEkMDFkMxYlTFr7+Edo+EdrZ2ZKZGhpV1ZrZ0duR3NtV1ZrZ0duR3JlVmtkZ1dnVG1UVmtmR25UR2dKZDIcJbeurZGN/Pn52Ov48+nR9O7p+PP477ybnryZvJaQnqGtkJ28lY+drK2QmbyVvIuWr7yUvJivn5GcsWQ9DyVxWVZUaGtXSCk+NjQtPh4tPjUvFzIoLz41Pil6XVh6X3pQVlhqelF6V3dkPBAlo7UXqISIiaWLhIa4uYSMqIGonYiIiLi5hIyogaicgri5hIupiLuIiIi7uYWI+aiBqYioiKVkP3okaEJzc09ALSw0c09IMyYxJSwxLiItICZiQ15Cc09KNyouJhA3Ii4zY0JCQUJCQN5SQ3NPRjMiJCYbY0JCR95SQ3NPRjMiJCYaY0J/3+diUmNH52JTY0BCQ29/39xiQdJiTGNBYkxPQ0FMSUFTSUFSSUFRSX/lSWJMN0Nxc09GIjciLXFiRNJiU2NA0mJSY0dCRkJyc09HMDIxN2JE09dSQdJjQGJT11JB0mNHYlJIcnNORWJEcUJFQn/e52JMY0HnUkNjRUhDcnNORGJXUkN5XkNyc05FYkTRUqtE0NJiTGNBY0VCREJyc05EYldjRH/lSWJRfUNyc05LYkTSYlFjRlJC0XNPQRMKYkRSQUhyc05LYkTSYlFjRkhxc09ALiotYkRxcUJLQnJzTkRiVtFSq0RjS0FQ01JCYlBBTGNBQVNjQEFSY0dBUWNGQU1Nf9xiQGJQSkNzYlpzYlVzYltvFBUoIQUtBT8kLiQXFSgsBS0FMikhSUpEQRcVKCwFLQU8KSNQS0lKREE=","load");
rx.ex64("UlgBKSAnV10mVlVBI1ZGV0pJSSFAXUBGJFckJDQHJCc07SQkJjTaJCQhMiErKSJGRFVRUFdAKykiVURWVkxTQCQgNM0iJCMVKSFoRFFNBSUkIhUoJQUlJC0VKS5WQFFsS1FAV1NESQUlJCwVKShGSUBEV2xLUUBXU0RJBSUkLyskKCokNDQlJDcxZDYCJR4IqaoVOaoVPjU0GDY5OwUEODZHVQQ5NBU0FSY/BgQ5NRUzBhU1GGQxHCV1bG9TTz47OxopOjErEzYsKzoxOi1+X1x+W35UUl1jb1JeflhNX25vUlx+WH5MVG1+V35abV1TXnNkMA8ltp6Wk6+skI/u+fHz6vnZ6vny6ND17+j58vnuvZyfvZi9l5Gerb2VvZCwZDMOJWF31WpBSktnSUFEentHSDgqKXtGS2pLallKSkp5e0dKO3tGS2pLa0pqSmdkMpAlUXtKSnZ5FBUNSnZxCh8IHBUIFxsUGR9bemd7SnZzDhMXHykOGxcKWnt7eHt7eedrekp2fQkZCBUWFiNbekbm5Vt461t0WnhbdHN6eHRweHVweGpwRtxwW3RMektKdnkbGAlbfOtbdVp5e357S0p2fhkfExZbfOhrkn3p61t0Wnhafnt/e0tKdn4KDwkSW2haf3hr6mt7W2t4dFp4eHVaeXh3dEblW3lba3N6SltsSltpSltvVhQVKCYVKCUFJQUyJC4kFxUoIRUoJQUlBTEpIUlKREEXFSghFSglBSUFMykjUEtJSkRB","load");
rx.ex64("UlgBKSghaERRTTZXQEhKU0BgU0BLUWlMVlFAS0BXLEhKUFZASEpTQCBGSUxGTiNWRldKSUkmUURCJ1ddIEZKUEtRIkZJTEBLUX0iRklMQEtRfCJWRldKSUl8IUBdQEY1REFBYFNAS1FpTFZRQEtAVyQkuDMVKS1BSkZQSEBLUQUlJCe4MxUpJ1BABSUkJhUpJlBAXQUlJCEVKSFWVFdRFSglBSUkIBUpJlVKUhUoJQUlJCMVKSZER1YVKCUFJSQiMiErKSJVRFZWTFNAKykiRkRVUVBXQCQtNEEkLDRBJC8uJC4uJCkuJCguJCsuJCouJDU0JSQ0NCVkNwwliJGSr6ODoqGDpYOor6CRkq+jg6Khg6WDqa+hkZKvo4OioYOlg66vpo5kNkAlemxgXVVxUmVQYWBdVXFSXEY4MSN9IyQiPz43fTk+JDUiMTMkOT8+bMxxU2BcUzkjPHFSWVBicVNdVlxSMSRsYF1XcVJLUGJgXVdxUkFRXEEDJCI/PjcZPiQ1IjEzJDk/PmBxQnxkMT8lETsGpqUrOgo3Mxo7pSs6CjcyGjs5OgobKRZkMHMlc1lkxP5TeVb+U3lVdlhqeV1JWsl5VWhVUHhZU2p5XUlayXlWaFVReFlTSGpqU2l5XGpZWllaSch4WnlJZPl5UHlJW1hoeUtaVWhVUHhZWlZoVVF4WXRkMwslGDIPlTgSPCEzAhI1ohI8Az45EjMjMhIjMSMyD5ISOhIjMDMDEiAxPAM+ORIzH2QydiVPVFVoblVoY0RlRHBnb2RUVWhuVWhjRGVEcWduZFRVaG5VaGNEZURzZ2lkVlVoaURlZkRiRG9oZ1ZVaGlEZWZEYkRuaGZWVWhpRGVmRGJEaWhhSRcVKSRXFSgjBSUFMikhSUpEQQ==","load");
rx.ex64("UlgBKScmUURCJ1ddJCS4MxUpLUFKRlBIQEtRBSUkJ7gzFSknUEAFJSQmFSkmUEBdBSVkIWolcFpua1ddCT48HiMrelvLV1NmcwAFYAZwcst7WldecwUne3JQamtXXjY6Lzgza1ddODQ0MDI+elppWllaa2tXXy8pMjZrSll7WUdae1l2WmQgGiUELhMfIi8OLRsvHh8iLw4tvw8uIz1dVwJHRkhHSlxbAk5MW0ZAQRUTsw4sHyMsRlxDDi0mLx0OLCIuIy1OWwNkI3clWENTdn9zc3NzQ0J+dwECHhsGUnN+czJxQmNzc25zUnNzcHNOUnBbckNCfnYTBh0QU3JScHNxc0NCfngRGhMAMR0WFzMGUnFjcnN2c0NTd1J2XhcVKSRXFSgkBSUFIykhSUpEQQ==","load");
/* ◬ */
</script>

</div>

<noscript>
    <img height="1" width="1" style='display:none;visibility:hidden;' src='//fls-na.amazon.com/1/batch/1/OP/ATVPDKIKX0DER:140-0199542-9827343:RBW56TXBT3VK1W4DNTET$uedata=s:%2Frd%2Fuedata%3Fnoscript%26id%3DRBW56TXBT3VK1W4DNTET:0' alt=""/>
</noscript>

<script>window.ue && ue.count && ue.count('CSMLibrarySize', 80900)</script>
<!-- sp:end-feature:csm:body-close -->
</div></body></html>
