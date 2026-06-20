{
  description = "Laravel dev shell (php85)";

  # Per-project nixpkgs pin. `nix flake update` bumps THIS project only.
  inputs.nixpkgs.url = "github:NixOS/nixpkgs/nixos-unstable";

  outputs = { self, nixpkgs }:
    let
      system = "x86_64-linux";
      pkgs = nixpkgs.legacyPackages.${system};

      # ── The two per-project knobs ────────────────────────────────────────
      # 1) PHP version: pkgs.php85 / php85 / php85 / php85 / php85
      # 2) Extensions: `enabled` is nixpkgs' default, Laravel-ready set
      #    (mbstring, openssl, tokenizer, curl, xml, pdo_sqlite, …). Uncomment
      #    to add project extras; composer below is built against this php.
      php = pkgs.php85.buildEnv {
        extensions = { enabled, all }: enabled ++ (with all; [
          # gd          # image processing
          # intl        # i18n, number/date formatting
          # imagick     # ImageMagick bindings
          # xdebug      # step debugging / coverage (dev only)
        ]);
        extraConfig = ''
          memory_limit = 512M
          upload_max_filesize = 64M
          post_max_size = 64M
        '';
      };
      # ─────────────────────────────────────────────────────────────────────
    in {
      devShells.${system}.default = pkgs.mkShell {
        packages = [
          php
          php.packages.composer   # Composer built against THIS php — no version skew
          pkgs.nodejs             # Vite / frontend build
        ];

        shellHook = ''
          echo "→ $(php --version | head -n1)"
        '';
      };
    };
}
