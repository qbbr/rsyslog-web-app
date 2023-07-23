# rsyslog-web-app

[![Stand With Ukraine](https://raw.githubusercontent.com/vshymanskyy/StandWithUkraine/main/badges/StandWithUkraine.svg)](https://github.com/vshymanskyy/StandWithUkraine/blob/main/docs/README.md)

Web Application for Rsyslog on Symfony + Vue.js.

## Stack

 * [PHP 8.2](https://www.php.net/)
 * [Symfony 6.3](https://symfony.com/)
 * [MariaDB 10.2](https://mariadb.org/)
 * [Vue.js 3](https://vuejs.org/)
 * [Bootstrap 5.3](https://getbootstrap.com/)
 * under [Docker](https://www.docker.com/)

## Screenshots

[![qbbr-rsyslog-web-app-1](https://i.imgur.com/eYncLZbb.png)](https://i.imgur.com/eYncLZb.png)
[![qbbr-rsyslog-web-app-2](https://i.imgur.com/cCORhjnb.png)](https://i.imgur.com/cCORhjn.png)
[![qbbr-rsyslog-web-app-2](https://i.imgur.com/WxQxL9tb.png)](https://i.imgur.com/WxQxL9t.png)

## Install

### Docker

```bash
curl -sSL https://get.docker.com | sudo sh
sudo usermod -aG docker $USER
```

### on prod

```bash
make build@prod
make up
make install@prod
```

see [rsyslog mysql server](https://qbbr.io/blog/2023/07/09/rsyslog-mysql-server.html)

```bash
sudo apt install rsyslog-mysql default-mysql-client --no-install-recommends
# and configure via `dbconfig-common` on installation dialog
```

### on dev

```bash
cp docker-compose.override.yml.dist docker-compose.override.yml
make build@dev
make up
make install@dev
```

## Usage

```bash
x-www-browser 'http://127.0.0.1/'
```

### Search

Default search by message and you can apply filters.

Available filters (supports multiple):

 * `host` (alias `h`)
 * `facility` (alias `f`)
 * `tag` (alias `t`)
 * `priority` (alias `p`)

Examples:

 * `tag = "kernel:"`
 * `host != "SRV-1", p = "info"`
 * `host="SRV-2, DNSSEC"` (can be multiple)
 * `h="QQ", f!="auth",p="error"`

### Hotkeys

 * <kbd>/</kbd>, <kbd>s</kbd> - focus the search bar
 * <kbd>Ctrl + ArrowRight</kbd> - goto the next page
 * <kbd>Ctrl + ArrowLeft</kbd> - goto the previous page
 * <kbd>Ctrl + Shift + ArrowRight</kbd> - goto the last page
 * <kbd>Ctrl + Shift + ArrowLeft</kbd> - goto the first page
 * <kbd>Click(filter link)</kbd> - filter `=`
 * <kbd>RightClick(filter link)</kbd> - exclude filter `!=`
 * <kbd>Ctrl + Click(filter link)</kbd> - multiple select/toggle filter `=`
 * <kbd>Ctrl + RightClick(filter link)</kbd> - multiple select/toggle exclude filter `!=`

## Tests

```bash
make install@test
make test
```
