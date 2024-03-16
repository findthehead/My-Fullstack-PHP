{ pkgs }: {
	deps = [
   pkgs.nano
		pkgs.php74
    pkgs.php74Extensions.pdo
    pkgs.sqlite
	];
}