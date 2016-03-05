BEGIN { push @INC, "lib" }

use strict;
use warnings;

use Devel::Size qw(size total_size);

# rotate left
sub __ROL {
	my ($value, $count) = @_;
	my $nbits = size($value);

	if ($count > 0) {
		$count %= $nbits;
		my $high = $value >> ($nbits - $count);
	}
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
	my ($pos, $cfgseed, $systemTime) = @_;

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

}

# LockyDGA(1,2,3);
__ROL('0xB11924E1', 2);