<?php
$file = '/var/www/html/atgps/protected/controllers/ReportsController.php';
$content = file_get_contents($file);

$replacement = <<<'EOD'
			$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
			$dateFromStr = trim($dateRange[0]);
			if (strpos($dateFromStr, '/') !== false) {
				$fromParts = explode("/", $dateFromStr);
				$from = trim($fromParts[2]).str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT).str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT)."000000";
			} else {
				$from = str_replace("-", "", $dateFromStr)."000000";
			}
			
			$dateToStr = trim($dateRange[1]);
			if (strpos($dateToStr, '/') !== false) {
				$toParts = explode("/", $dateToStr);
				$toRaw = trim($toParts[2]).'-'.str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT).'-'.str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
			} else {
				$toRaw = $dateToStr;
			}
			$toDate = new DateTime($toRaw);
			$toDate->modify('+1 day');
			$to = $toDate->format('Ymd')."235959";
EOD;

// Using regex to match the target blocks, ignoring whitespace differences
$pattern = '/\t+\$dateRange = explode\("-",\$_POST\[\'Vehicle\'\]\[\'dateRange\'\]\);\s+\$fromParts = explode\("\/",trim\(\$dateRange\[0\]\)\);\s+\$from = trim\(\$fromParts\[2\]\)\.str_pad\(trim\(\$fromParts\[1\]\), 2, \'0\', STR_PAD_LEFT\)\.str_pad\(trim\(\$fromParts\[0\]\), 2, \'0\', STR_PAD_LEFT\)\."000000";\s+\$toParts = explode\("\/",trim\(\$dateRange\[1\]\)\);\s+\$toRaw = trim\(\$toParts\[2\]\)\.\'-\'\.trim\(\$toParts\[1\]\)\.\'-\'\.trim\(\$toParts\[0\]\);\s+\$toDate = new DateTime\(\$toRaw\);\s+\$toDate->modify\(\'\+1 day\'\);\s+\$to = \$toDate->format\(\'Ymd\'\)\."235959";/';

$newContent = preg_replace($pattern, $replacement, $content);

file_put_contents($file, $newContent);
?>
