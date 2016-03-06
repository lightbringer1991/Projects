// pos should be between 0 and 7, cfgseed is the DGA seed which we have seen as both 7 and 9 to date
char *LockyDGA(int pos, int cfgseed, SYSTEMTIME SystemTime)
{
	char *domain;
	int modConst1 = 0xB11924E1;
	int modConst2 = 0x27100001;
	int modConst3 = 0x2709A354;
	int modYear, modMonth, modDay;
	int modBase = 0, i = 0, genLength = 0;
	unsigned int x = 0, y = 0, z = 0;
	unsigned int modFinal = 0;
	unsigned int seed = cfgseed;
	char tldchars[29] = "rupweuinytpmusfrdeitbeuknltf";
  
	// Perform some funky shifts (now modified with the seed in the base config)
	modYear = __ROR4__(modConst1 * (SystemTime.wYear + 0x1BF5), 7);
	modYear = __ROR4__(modConst1 * (modYear + seed + modConst2), 7);
	modDay = __ROR4__(modConst1 * (modYear + ((unsigned int)SystemTime.wDay >> 1) + modConst2), 7);
	modMonth = __ROR4__(modConst1 * (modDay + SystemTime.wMonth + modConst3), 7);
 
	// Shift the seed
	seed = __ROL4__(seed, 17);
 
	// Finalize the modifier
	modBase = __ROL4__(pos & 7, 21);
	modFinal = __ROR4__(modConst1 * (modMonth + modBase + seed + modConst2), 7);
	modFinal += 0x27100001;
 
	// Length without TLD (SLD length)
	genLength = modFinal % 11 + 5;
  
	if (genLength)
	{
		// Allocate full length including TLD and null terminator
		domain = (char *)malloc(genLength + 4);
  
		// Generate domain string before TLD
		do
		{
			x = __ROL4__(modFinal, i);
			y = __ROR4__(modConst1 * x, 7);
			z = y + modConst2;
			modFinal = z;
			domain[i++] = z % 25 + 97; // Keep within lowercase a-z range
		}
		while (i < genLength);
 
		// Add a '.' before the TLD
		domain[i] = '.';
 
		// Generate the TLD from a hard-coded key-string of characters
		x = __ROR4__(modConst1 * modFinal, 7);
		y = (x + modConst2) % ( (sizeof(tldchars) - 1) / 2 );
 
		domain[i + 1] = tldchars[2 * y];
		domain[i + 2] = tldchars[2 * y + 1];
		domain[i + 3] = 0; // Null-terminate
	}
	return domain;
}