<?php
/**
 * Local dev-only fake data seeder for the tpgFront database.
 *
 * Populates realistic, entirely fictional applicants + reference data so
 * the app's screens (login, upload, check status, reply slip, payment,
 * mark sheet) have something to show while developing locally.
 *
 * Nothing here is derived from real production records — names, emails,
 * universities and messages are all made up. Reference tables (currInfo,
 * streamInfo, mediaMap) use fake codes in the 9000/9T0xx range so they
 * can never collide with real codes if production data is ever imported
 * into this database.
 *
 * Safe to re-run: it deletes only the rows it created (matched by the
 * fake appNo range 1106900001-1106900999 and the 9xxx reference codes)
 * before re-inserting, so running it twice does not duplicate data and
 * does not touch anything else already in the database.
 *
 * Usage:
 *   /Applications/AMPPS/apps/php82/bin/php db/seed_fake_data.php
 */

$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = 'mysql';
$dbName = 'tpgFront';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($mysqli->connect_errno) {
    fwrite(STDERR, "DB connection failed: " . $mysqli->connect_error . "\n");
    exit(1);
}
$mysqli->set_charset('utf8mb4');

function q($mysqli, $sql) {
    if (!$mysqli->query($sql)) {
        fwrite(STDERR, "Query failed: " . $mysqli->error . "\nSQL: $sql\n");
        exit(1);
    }
}

function esc($mysqli, $v) {
    if ($v === null) return 'NULL';
    return "'" . $mysqli->real_escape_string($v) . "'";
}

$FAKE_APPNO_MIN = 1106900001;
$FAKE_APPNO_MAX = 1106900999;

echo "Clearing any previously seeded fake rows...\n";
q($mysqli, "DELETE FROM application       WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM supportDoc        WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM supportDocReview  WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM supportDocHistory WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM offerReply        WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM rsUpload          WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM appRequest        WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM avgMark           WHERE appNo BETWEEN $FAKE_APPNO_MIN AND $FAKE_APPNO_MAX");
q($mysqli, "DELETE FROM multiApp          WHERE multiID BETWEEN 90000 AND 90099");
q($mysqli, "DELETE FROM currInfo          WHERE currCode BETWEEN 9000 AND 9099");
q($mysqli, "DELETE FROM streamInfo        WHERE acadPlanCode LIKE '9T0%'");
q($mysqli, "DELETE FROM mediaMap          WHERE id BETWEEN 900 AND 999");
q($mysqli, "DELETE FROM enggStaff         WHERE portalID IN ('demostf1','demostf2')");

// -------------------------------------------------------------------------
// Reference data: fictional programmes, streams, media channels, staff
// -------------------------------------------------------------------------

echo "Seeding currInfo (fictional programmes)...\n";
$currInfoRows = [
    // code, currTitle, titleDisplay, fee, totalCredit, feeL, feeNL, instaL2FT, instaL4PT, instaNL2FT, instaNL4PT, dept
    [9001, 'MSc(SoftEng)',  'MSc in Software Engineering',            0, '72', 220000, 330000, 110000, 55000, 165000, 82500, 'CS'],
    [9002, 'MSc(AI)',       'MSc in Artificial Intelligence',         0, '72', 240000, 360000, 120000, 60000, 180000, 90000, 'CS'],
    [9003, 'MSc(DataSc)',   'MSc in Data Science',                    0, '72', 230000, 345000, 115000, 57500, 172500, 86250, 'CS'],
    [9004, 'MSc(Robotics)', 'MSc in Robotics and Automation',         0, '72', 235000, 352500, 117500, 58750, 176250, 88125, 'ME'],
    [9005, 'MEng(Civil)',   'MEng in Civil Engineering',              0, '72', 210000, 315000, 105000, 52500, 157500, 78750, 'CIVIL'],
    [9006, 'MSc(Env)',      'MSc in Environmental Engineering',       0, '72', 205000, 307500, 102500, 51250, 153750, 76875, 'CIVIL'],
];
foreach ($currInfoRows as $r) {
    [$code, $title, $display, $fee, $credit, $feeL, $feeNL, $iL2, $iL4, $iNL2, $iNL4, $dept] = $r;
    $sql = "INSERT INTO currInfo
        (currCode, currTitle, titleDisplay, fee, totalCredit, RSfooterLFT, RSfooterLPT,
         feeL, feeNL, instaL2FT, instaL4PT, instaNL2FT, instaNL4PT, RSfooterNLFT, RSfooterNLPT, dept, chatBox)
        VALUES ($code, " . esc($mysqli, $title) . ", " . esc($mysqli, $display) . ", $fee, " . esc($mysqli, $credit) . ",
        " . esc($mysqli, "Composition fee of $title programme is HK\$" . number_format($feeL) . "* and to be paid in two equal instalments for full-time mode.") . ",
        " . esc($mysqli, "Composition fee of $title programme is HK\$" . number_format($feeL) . "* and to be paid in four equal instalments for part-time mode.") . ",
        $feeL, $feeNL, $iL2, $iL4, $iNL2, $iNL4,
        " . esc($mysqli, "Composition fee of $title programme is HK\$" . number_format($feeNL) . "* and to be paid in two equal instalments for full-time mode.") . ",
        " . esc($mysqli, "Composition fee of $title programme is HK\$" . number_format($feeNL) . "* and to be paid in four equal instalments for part-time mode.") . ",
        " . esc($mysqli, $dept) . ", 'N')";
    q($mysqli, $sql);
}

echo "Seeding streamInfo (fictional streams)...\n";
$streamRows = [
    ['9T001M', 'General Stream'],
    ['9T002M', 'AI &amp; Machine Learning Stream'],
    ['9T003M', 'Cyber Security Stream'],
    ['9T004M', 'Structural Engineering Stream'],
];
foreach ($streamRows as [$code, $title]) {
    q($mysqli, "INSERT INTO streamInfo (acadPlanCode, acadPlanTitle) VALUES (" . esc($mysqli, $code) . ", " . esc($mysqli, $title) . ")");
}

echo "Seeding mediaMap (fictional survey channels)...\n";
$mediaRows = [
    [901, 'Google', 1],
    [902, 'Facebook', 2],
    [903, 'Instagram', 3],
    [904, 'LinkedIn', 4],
    [905, 'Others', 5],
];
foreach ($mediaRows as [$id, $name, $order]) {
    q($mysqli, "INSERT INTO mediaMap (id, mediaName, `order`) VALUES ($id, " . esc($mysqli, $name) . ", $order)");
}

echo "Seeding enggStaff (fake reviewer accounts)...\n";
foreach (['demostf1', 'demostf2'] as $portalId) {
    $hash = password_hash($portalId . '@hku.hk', PASSWORD_DEFAULT);
    q($mysqli, "INSERT INTO enggStaff (portalID, email, status) VALUES (" . esc($mysqli, $portalId) . ", " . esc($mysqli, $hash) . ", 'A')");
}

// -------------------------------------------------------------------------
// Helper: build a 41-char fileStatus string (see FILE_FIELD_MAP, 41 fields)
// -------------------------------------------------------------------------

function buildFileStatus($pNo, $isChina, $uploadedCount, $verifiedIdx = []) {
    $status = str_repeat('N', 41);
    $status = str_split($status);

    $filled = 0;
    for ($inst = 0; $inst < $pNo; $inst++) {
        $blockStart = $inst * 12;
        $blockLen = $isChina[$inst] ? 12 : 7;
        for ($j = 0; $j < $blockLen && $filled < $uploadedCount; $j++) {
            $status[$blockStart + $j] = 'U';
            $filled++;
        }
    }
    foreach ($verifiedIdx as $idx) {
        // verified items are also uploaded
        if (isset($status[$idx])) $status[$idx] = 'U';
    }
    return [implode('', $status), $verifiedIdx];
}

function buildReviewStatus($verifiedIdx) {
    $status = array_fill(0, 41, 'N');
    foreach ($verifiedIdx as $idx) {
        $status[$idx] = 'C';
    }
    return implode('', $status);
}

$now = date('Y-m-d H:i:s');
$today = date('Y-m-d');
function daysFromNow($n) { return date('Y-m-d', strtotime("$n days")); }

// -------------------------------------------------------------------------
// Fake applicants — a spread of realistic scenarios
// -------------------------------------------------------------------------

$applicants = [];

// 1) Fresh applicant, single non-China university, nothing uploaded yet
$applicants[] = [
    'appNo' => 1106900001, 'email' => 'chan.taiman@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'N',
    'uni' => ['University of Toronto', '', ''], 'degree' => ['BASc Computer Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9002,
    'statusMsg' => 'Your application is being processed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>No supporting documents received yet.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 0, 'verifiedIdx' => [],
    'englishTest' => null, 'others' => [null, null, null],
];

// 2) Mid-upload, single China university, partial progress
$applicants[] = [
    'appNo' => 1106900002, 'email' => 'zhou.yifan@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['Zhejiang University', '', ''], 'degree' => ['BEng Software Engineering', '', ''],
    'isChina' => ['Y', 'N', 'N'], 'currCode' => 9001,
    'statusMsg' => 'Your application is being processed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>Supporting document last uploaded by applicant: ' . daysFromNow(-3) . ' 15:20:00<br/><li>Official transcript</li><li>Grading system</li><br/>--- BENG_ZJU ---<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 5, 'verifiedIdx' => [],
    'englishTest' => 'IELTS', 'others' => ['ID card', null, null],
];

// 3) Institution #1 complete, two items verified by department
$applicants[] = [
    'appNo' => 1106900003, 'email' => 'lee.kaming@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['National University of Singapore', '', ''], 'degree' => ['BEng Electrical Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9004,
    'statusMsg' => 'Your application is being processed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>Supporting document last uploaded by applicant: ' . daysFromNow(-1) . ' 10:05:00<br/>All documents for Institution #1 received.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 7, 'verifiedIdx' => [2, 5],
    'englishTest' => 'TOEFL', 'others' => [null, null, null],
];

// 4) Two institutions — the "hero" demo account matching the redesigned
//    upload-page previews (Nanjing University + HKUST)
$applicants[] = [
    'appNo' => 1106900004, 'email' => 'wong.hiuying@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['Nanjing University', 'The Hong Kong University of Science and Technology', ''],
    'degree' => ['BEng Computer Science', 'MSc Data Science', ''],
    'isChina' => ['Y', 'N', 'N'], 'currCode' => 9003,
    'statusMsg' => 'Your application is being processed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>Supporting document last uploaded by applicant: ' . daysFromNow(-2) . ' 09:15:00<br/><li>Official transcript</li><li>English translation of the transcript</li><li>Mark sheet</li><br/>--- BENG_NJU ---<br/>',
    'pNo' => 2, 'currStud' => 'N', 'uploadedCount' => 6, 'verifiedIdx' => [2],
    'englishTest' => 'IELTS', 'others' => [null, null, null],
];

// 5) Three institutions, all China universities — max-complexity case
$applicants[] = [
    'appNo' => 1106900005, 'email' => 'chen.zixuan@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 1, 'mediaSurvey' => 'Y',
    'uni' => ['Fudan University', 'Shanghai Jiao Tong University', 'Tsinghua University'],
    'degree' => ['BSc Applied Mathematics', 'MSc Statistics', 'MEng Systems Engineering'],
    'isChina' => ['Y', 'Y', 'Y'], 'currCode' => 9002,
    'statusMsg' => 'Your application is being processed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>Supporting document last uploaded by applicant: ' . daysFromNow(-5) . ' 14:40:00<br/>',
    'pNo' => 3, 'currStud' => 'Y', 'uploadedCount' => 14, 'verifiedIdx' => [0, 1],
    'englishTest' => 'IELTS', 'others' => ['CV', 'Passport', null],
];

// 6) Offer issued, awaiting reply
$applicants[] = [
    'appNo' => 1106900006, 'email' => 'lam.tszching@example.test',
    'status' => 'A', 'appStatus' => 'O', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['University of Manchester', '', ''], 'degree' => ['BEng Mechanical Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9004,
    'statusMsg' => 'Congratulations! An offer of admission has been issued.<br/><br/>As of ' . $now . ',<br/>Please log in to review and reply to your offer before the deadline.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 7, 'verifiedIdx' => [0, 1, 2, 3, 4, 5, 6],
    'englishTest' => 'IELTS', 'others' => [null, null, null],
    'offer' => [
        'replyStatus' => 'X', 'acadPlanCode' => '9T001M', 'studyMode' => 'F',
        'issueDate' => daysFromNow(-6), 'deadline' => daysFromNow(8), 'replyDate' => null,
        'provisional' => 'N', 'recommendation' => 'CF', 'signature' => null, 'isLocal' => 'N',
    ],
];

// 7) Offer accepted, awaiting payment
$applicants[] = [
    'appNo' => 1106900007, 'email' => 'ng.waihong@example.test',
    'status' => 'A', 'appStatus' => 'S', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['University of Melbourne', '', ''], 'degree' => ['BSc Computer Science', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9002,
    'statusMsg' => 'You have accepted your offer. Update is shown below:<br/><br/>As of ' . $now . ',<br/>Please upload your payment slip to confirm your place.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 7, 'verifiedIdx' => [0, 1, 2, 3, 4, 5, 6],
    'englishTest' => 'TOEFL', 'others' => [null, null, null],
    'offer' => [
        'replyStatus' => 'P', 'acadPlanCode' => '9T002M', 'studyMode' => 'F',
        'issueDate' => daysFromNow(-14), 'deadline' => daysFromNow(-2), 'replyDate' => daysFromNow(-3),
        'provisional' => 'N', 'recommendation' => 'C', 'signature' => 'NG WAI HONG', 'isLocal' => 'Y',
    ],
];

// 8) Offer accepted and payment confirmed — full lifecycle, with rsUpload log
$applicants[] = [
    'appNo' => 1106900008, 'email' => 'ip.chunyin@example.test',
    'status' => 'A', 'appStatus' => 'P', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['University of Edinburgh', '', ''], 'degree' => ['MSc Robotics', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9004,
    'statusMsg' => 'Your place has been confirmed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>You have submitted the reply slip and proof of payment of the deposit, which have been confirmed.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 7, 'verifiedIdx' => [0, 1, 2, 3, 4, 5, 6],
    'englishTest' => 'IELTS', 'others' => [null, null, null],
    'offer' => [
        'replyStatus' => 'Y', 'acadPlanCode' => '9T004M', 'studyMode' => 'F',
        'issueDate' => daysFromNow(-30), 'deadline' => daysFromNow(-16), 'replyDate' => daysFromNow(-18),
        'provisional' => 'N', 'recommendation' => 'C', 'signature' => 'IP CHUN YIN', 'isLocal' => 'Y',
    ],
    'rsUpload' => ['recommendation' => 'C', 'replyStatus' => 'Y', 'uploadTime' => daysFromNow(-18) . ' 11:32:00'],
];

// 9) Offer declined — closed application
$applicants[] = [
    'appNo' => 1106900009, 'email' => 'yeung.pokman@example.test',
    'status' => 'A', 'appStatus' => 'J', 'studStatus' => 0, 'mediaSurvey' => 'N',
    'uni' => ['University of Bristol', '', ''], 'degree' => ['MSc Environmental Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9006,
    'statusMsg' => 'Your application has been closed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>You have declined the offer of admission.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 7, 'verifiedIdx' => [0, 1, 2, 3, 4, 5, 6],
    'englishTest' => 'IELTS', 'others' => [null, null, null],
    'offer' => [
        'replyStatus' => 'N', 'acadPlanCode' => '', 'studyMode' => 'F',
        'issueDate' => daysFromNow(-20), 'deadline' => daysFromNow(-6), 'replyDate' => daysFromNow(-10),
        'provisional' => 'N', 'recommendation' => 'C', 'signature' => 'YEUNG POK MAN', 'isLocal' => 'Y',
    ],
];

// 10) "Other documents" tab exercised
$applicants[] = [
    'appNo' => 1106900010, 'email' => 'ho.sumyu@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['King\'s College London', '', ''], 'degree' => ['BEng Civil Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9005,
    'statusMsg' => 'Your application is being processed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>Additional documents received and under review.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 4, 'verifiedIdx' => [],
    'englishTest' => null, 'others' => ['ID card', 'CV', 'Ref letter'],
];

// 11) Account inactive after too many failed login attempts (edge case)
$applicants[] = [
    'appNo' => 1106900011, 'email' => 'so.yuetting@example.test',
    'status' => 'I', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'N',
    'uni' => ['University of Birmingham', '', ''], 'degree' => ['BSc Data Science', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9003,
    'statusMsg' => 'Your application is being processed.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 0, 'verifiedIdx' => [],
    'englishTest' => null, 'others' => [null, null, null],
];

// 12 & 13) Linked multi-application pair (same person, two programmes)
$applicants[] = [
    'appNo' => 1106900012, 'email' => 'fung.longtin@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['University of Waterloo', '', ''], 'degree' => ['BASc Software Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9001,
    'statusMsg' => 'Your application is being processed.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 3, 'verifiedIdx' => [],
    'englishTest' => 'IELTS', 'others' => [null, null, null],
    'multiApp' => 'Y', 'multiID' => 90001,
];
$applicants[] = [
    'appNo' => 1106900013, 'email' => 'fung.longtin@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'Y',
    'uni' => ['University of Waterloo', '', ''], 'degree' => ['BASc Software Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9002,
    'statusMsg' => 'Your application is being processed.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 3, 'verifiedIdx' => [],
    'englishTest' => 'IELTS', 'others' => [null, null, null],
    'multiApp' => 'Y', 'multiID' => 90001,
];

// 14) Current student needing average-mark route (no CGPA on transcript)
$applicants[] = [
    'appNo' => 1106900014, 'email' => 'tsang.mankit@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 1, 'mediaSurvey' => 'Y',
    'uni' => ['City University of Hong Kong', '', ''], 'degree' => ['BEng Computer Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9001,
    'statusMsg' => 'Your application is being processed. Update is shown below:<br/><br/>As of ' . $now . ',<br/>Average mark statement received in lieu of CGPA.<br/>',
    'pNo' => 1, 'currStud' => 'Y', 'uploadedCount' => 6, 'verifiedIdx' => [],
    'englishTest' => 'IELTS', 'others' => [null, null, null],
    'avgMark' => ['avgMarkC1' => 78.5, 'avgMarkByStud1' => 'BENG_CITYU'],
];

// 15) Fresh applicant, minimal data, no media survey answered — padding/variety
$applicants[] = [
    'appNo' => 1106900015, 'email' => 'yip.hoiling@example.test',
    'status' => 'A', 'appStatus' => 'C', 'studStatus' => 0, 'mediaSurvey' => 'N',
    'uni' => ['University of Leeds', '', ''], 'degree' => ['BEng Chemical Engineering', '', ''],
    'isChina' => ['N', 'N', 'N'], 'currCode' => 9006,
    'statusMsg' => 'Your application is being processed.<br/>',
    'pNo' => 1, 'currStud' => 'N', 'uploadedCount' => 1, 'verifiedIdx' => [],
    'englishTest' => null, 'others' => [null, null, null],
];

echo "Seeding " . count($applicants) . " fake applications...\n";

$credentials = [];

foreach ($applicants as $a) {
    $appNo = $a['appNo'];
    $emailHash = password_hash(strtolower($a['email']), PASSWORD_DEFAULT);
    $credentials[] = [$appNo, $a['email']];

    $createDate = daysFromNow(-random_int(10, 90)) . ' ' . sprintf('%02d:%02d:00', random_int(8, 18), random_int(0, 59));

    q($mysqli, "INSERT INTO application
        (appNo, email, createDate, status, appStatus, studStatus, mediaSurvey,
         uni1, uni2, uni3, degree1, degree2, degree3, isChina1, isChina2, isChina3,
         statusMsg, multiApp, multiID, currCode)
        VALUES (
            $appNo, " . esc($mysqli, $emailHash) . ", " . esc($mysqli, $createDate) . ",
            " . esc($mysqli, $a['status']) . ", " . esc($mysqli, $a['appStatus']) . ", {$a['studStatus']},
            " . esc($mysqli, $a['mediaSurvey']) . ",
            " . esc($mysqli, $a['uni'][0]) . ", " . esc($mysqli, $a['uni'][1]) . ", " . esc($mysqli, $a['uni'][2]) . ",
            " . esc($mysqli, $a['degree'][0]) . ", " . esc($mysqli, $a['degree'][1]) . ", " . esc($mysqli, $a['degree'][2]) . ",
            " . esc($mysqli, $a['isChina'][0]) . ", " . esc($mysqli, $a['isChina'][1]) . ", " . esc($mysqli, $a['isChina'][2]) . ",
            " . esc($mysqli, $a['statusMsg']) . ",
            " . esc($mysqli, $a['multiApp'] ?? 'N') . ", " . ($a['multiID'] ?? 0) . ", {$a['currCode']}
        )");

    $isChinaBool = [$a['isChina'][0] === 'Y', $a['isChina'][1] === 'Y', $a['isChina'][2] === 'Y'];
    [$fileStatus, $verifiedIdx] = buildFileStatus($a['pNo'], $isChinaBool, $a['uploadedCount'], $a['verifiedIdx']);

    $titleC1 = $a['pNo'] >= 1 ? 'REF_' . substr(preg_replace('/[^A-Za-z]/', '', $a['uni'][0]), 0, 8) : null;
    $titleP1 = $titleC1;
    $titleP2 = $a['pNo'] >= 2 ? 'REF_' . substr(preg_replace('/[^A-Za-z]/', '', $a['uni'][1]), 0, 8) : null;
    $titleP3 = $a['pNo'] >= 3 ? 'REF_' . substr(preg_replace('/[^A-Za-z]/', '', $a['uni'][2]), 0, 8) : null;

    q($mysqli, "INSERT INTO supportDoc
        (appNo, createDate, fileStatus, englishTest, other1, other2, other3, pNo, currStud, titleC1, titleP1, titleP2, titleP3)
        VALUES (
            $appNo, " . esc($mysqli, $createDate) . ", " . esc($mysqli, $fileStatus) . ",
            " . esc($mysqli, $a['englishTest']) . ",
            " . esc($mysqli, $a['others'][0]) . ", " . esc($mysqli, $a['others'][1]) . ", " . esc($mysqli, $a['others'][2]) . ",
            {$a['pNo']}, " . esc($mysqli, $a['currStud']) . ",
            " . esc($mysqli, $titleC1) . ", " . esc($mysqli, $titleP1) . ", " . esc($mysqli, $titleP2) . ", " . esc($mysqli, $titleP3) . "
        )");

    if (!empty($a['verifiedIdx'])) {
        $reviewStatus = buildReviewStatus($a['verifiedIdx']);
        q($mysqli, "INSERT INTO supportDocReview (appNo, fileStatus) VALUES ($appNo, " . esc($mysqli, $reviewStatus) . ")");
    }

    if (isset($a['offer'])) {
        $o = $a['offer'];
        $namePart = explode('@', $a['email'])[0];
        $nameBits = explode('.', $namePart);
        $appName = strtoupper($nameBits[0]) . ' ' . ucfirst($nameBits[1] ?? '');
        q($mysqli, "INSERT INTO offerReply
            (appNo, replyStatus, currCode, appName, studyMode, acadPlanCode, issueDate, deadline, replyDate,
             provisional, recommendation, signature, admYear, isLocal)
            VALUES (
                $appNo, " . esc($mysqli, $o['replyStatus']) . ", {$a['currCode']}, " . esc($mysqli, $appName) . ",
                " . esc($mysqli, $o['studyMode']) . ", " . esc($mysqli, $o['acadPlanCode']) . ",
                " . esc($mysqli, $o['issueDate']) . ", " . esc($mysqli, $o['deadline']) . ", " . esc($mysqli, $o['replyDate']) . ",
                " . esc($mysqli, $o['provisional']) . ", " . esc($mysqli, $o['recommendation']) . ", " . esc($mysqli, $o['signature']) . ",
                2026, " . esc($mysqli, $o['isLocal']) . "
            )");
    }

    if (isset($a['rsUpload'])) {
        $r = $a['rsUpload'];
        q($mysqli, "INSERT INTO rsUpload (appNo, recommendation, uploadTime, replyStatus)
            VALUES ($appNo, " . esc($mysqli, $r['recommendation']) . ", " . esc($mysqli, $r['uploadTime']) . ", " . esc($mysqli, $r['replyStatus']) . ")");
    }

    if (isset($a['avgMark'])) {
        $m = $a['avgMark'];
        q($mysqli, "INSERT INTO avgMark (appNo, createDate, avgMarkC1, avgMarkByStud1)
            VALUES ($appNo, " . esc($mysqli, $createDate) . ", {$m['avgMarkC1']}, " . esc($mysqli, $m['avgMarkByStud1']) . ")");
    }

    q($mysqli, "INSERT INTO appRequest (appNo, request, requestTime) VALUES ($appNo, 'S', " . esc($mysqli, $now) . ")");
}

// One shared multiApp lookup row for the linked pair (#12/#13)
q($mysqli, "INSERT INTO multiApp (multiID, appNo, appNoList, isNew) VALUES (90001, 1106900012, '1106900012,1106900013', 'N')");

$mysqli->close();

echo "\nDone. Seeded:\n";
echo "  - " . count($currInfoRows) . " currInfo programmes (codes 9001-9006)\n";
echo "  - " . count($streamRows) . " streamInfo streams (9T00xM)\n";
echo "  - " . count($mediaRows) . " mediaMap channels (900s)\n";
echo "  - 2 enggStaff demo reviewers (demostf1, demostf2)\n";
echo "  - " . count($applicants) . " application + supportDoc rows (appNo 1106900001-1106900015)\n";

echo "\nTest login credentials (application number / email):\n";
foreach ($credentials as [$appNo, $email]) {
    echo "  $appNo / $email\n";
}
echo "\nNote: normal login still requires passing the captcha + emailed OTP\n";
echo "step, which needs a working local mail transport. The known 'back\n";
echo "door' test login (2200123123 / mmchoy) is unrelated to this seed data\n";
echo "and unaffected by it.\n";
