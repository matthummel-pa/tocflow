#!/usr/bin/env bash
# ──────────────────────────────────────────────────────────────────────────────
# TOCflow local WordPress preview environment
#
# Usage: bash dev/start-local.sh
#
# Access:
#   Site:     http://localhost:8080
#   Demo post: http://localhost:8080/?p=4
#   Admin:    http://localhost:8080/wp-admin/  (admin / password)
#
# WordPress is at /opt/wordpress
# Plugin is symlinked: /opt/wordpress/wp-content/plugins/tocflow -> /workspace
# ──────────────────────────────────────────────────────────────────────────────
set -e

WP_DIR=/opt/wordpress
PORT=8080

echo "▶ Starting MariaDB..."
if ! sudo mysqladmin -u root status &>/dev/null; then
    sudo bash -c "nohup mariadbd --user=mysql --datadir=/var/lib/mysql \
        --skip-log-error \
        --pid-file=/run/mysqld/mysqld.pid \
        --socket=/run/mysqld/mysqld.sock \
        > /tmp/mariadb.log 2>&1 &"
    sleep 3
fi

echo "▶ Starting WordPress PHP server on http://localhost:${PORT} ..."
php8.2 -S "0.0.0.0:${PORT}" "${WP_DIR}/router.php" &
SERVER_PID=$!
echo "  PID: ${SERVER_PID}"
sleep 2

echo ""
echo "✓ Local environment ready"
echo "  Site:      http://localhost:${PORT}"
echo "  Demo post: http://localhost:${PORT}/?p=4"
echo "  Admin:     http://localhost:${PORT}/wp-admin/"
echo "  Login:     admin / password"
echo ""
echo "Press Ctrl+C to stop the server."
wait ${SERVER_PID}
