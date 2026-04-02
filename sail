# Criado para facilitar a execução dos comandos do sail
#!/usr/bin/env sh
ROOT="$(cd "$(dirname "$0")" && pwd)"
exec "$ROOT/vendor/bin/sail" "$@"
