use strict;
use warnings;

use Devel::Size qw(size total_size);

# convert from decimal to binary
sub dec2bin {
	my $str = unpack('B32', pack('N', shift));
	$str =~ s/^0+(?=\d)//;
	return $str;
}

# convert from binary to decimal
sub bin2dec {
	return unpack( 'N', pack('B32', substr("0" x 32 . shift, -32)) );
}

# rotate left
sub __ROL4 {
	my $number = shift;
	my $count = shift;
	my $binaryStr = dec2bin($number);

	for (1..$count) {
		$binaryStr = substr($binaryStr, 1) . substr($binaryStr, 0, 1);
	}
	return bin2dec($binaryStr);
}

# rotate right
sub __ROR4 {
	my $number = shift;
	my $count = shift;
	my $binaryStr = dec2bin($number);

	for (1..$count) {
		$binaryStr = substr($binaryStr, -1) . substr($binaryStr, 0, -1);
	}
	return bin2dec($binaryStr);	
}

=start
%systemTime = (
	'wYear' => 1900,
	'wMonth' => 1,
	'wDayOfWeek' => 0,
	'wDay' => 1,
	'wHour' => 0,
	'wMinute' => 0,
	'wSecond' => 0,
	'wMilliseconds' => 0
);
must be compatible with C++ SYSTEMTIME structure
https://msdn.microsoft.com/en-us/library/windows/desktop/ms724950%28v=vs.85%29.aspx
=cut
sub LockyDGA {
	my ($pos, $cfgseed, $ref_systemTime) = @_;

	my $domain;
	my $modConst1 = 0xB11924E1;
	my $modConst2 = 0x27100001;
	my $modConst3 = 0x2709A354;
	my ($modYear, $modMonth, $modDay);
	my $modBase = 0;
	my $genLength = 0;
	my $i = 0;
	my $x = 0;
	my $y = 0;
	my $z = 0;
	my $modFinal = 0;
	my $seed = $cfgseed;
	my $tldchars = "rupweuinytpmusfrdeitbeuknltf";

	# Perform some funky shifts (now modified with the seed in the base config)
	$modYear = __ROR4($modConst1 * ($ref_systemTime -> {'wYear'} + 0x1BF5), 7);
	$modYear = __ROR4($modConst1 * ($modYear + $seed + $modConst2), 7);
	$modDay = __ROR4($modConst1 * ($modYear + ($ref_systemTime -> {'wDay'} >> 1) + $modConst2), 7);
	$modMonth = __ROR4($modConst1 * ($modDay + $ref_systemTime -> {'wMonth'} + $modConst3), 7);

	# shift the seed
	$seed =  __ROL4($seed, 17);

	# finalize the modifier
	$modBase = __ROL4($pos & 7, 21);
	$modFinal = __ROR4($modConst1 * ($modMonth + $modBase + $seed + $modConst2), 7);
	$modFinal += 0x27100001;

	# length without TLD (SLD length)
	$genLength = $modFinal % 11 + 5;

	if ($genLength) {
		# allocate full length including TLD and null terminator
		$domain = "";
		do {
			$x = __ROL4($modFinal, $i);
			$y = __ROR4($modConst1 * $x, 7);
			$z = $y + $modConst2;
			$modFinal = $z;
			$domain .= chr($z % 25 + 97);
			$i++;
		} while ($i < $genLength);

		# add a '.' before the TLD
		$domain .= ".";

		# generate the TLD from a hard-coded key-string of characters
		$x = __ROR4($modConst1 * $modFinal, 7);
		$y = ($x + $modConst2) % ( (length($tldchars)) / 2 );

		# $domain .= $tldchars[2 * $y];
		# $domain .= $tldchars[2 * $y + 1];
		# $domain .= 0;
		$domain .= substr($tldchars, 2 * $y, 2) . '0';
	}
	return $domain;
}


# test zone
my $pos = 0;
my $cfgseed = 7;
my %systemTime = (
	'wYear' => 2016,
	'wMonth' => 2,
	'wDayOfWeek' => 6,
	'wDay' => 24,
	'wHour' => 15,
	'wMinute' => 40,
	'wSecond' => 32,
	'wMilliseconds' => 567
);


print LockyDGA($pos, $cfgseed,\%systemTime) . "\n";
