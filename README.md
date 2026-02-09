# mogitate(フリマサイト)

## 環境構築

**Dockerビルド**

1. `git clone git@github.com:shiro03shiro/test_mogitate.git`
2. DockerDesktopアプリを立ち上げる
3. `docker-compose up -d --build`

**Laravel環境構築**

1. `docker-compose exec php bash`
2. `composer install`
3. `WSLユーザー所有に変更`

```text
sudo chown -R $(whoami):$(whoami) src/
chmod -R 755 src/
chmod 644 src/.env*
```

4. `cp .env.example .env`
5. .envに以下の環境変数を追加

```text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

6. アプリケーションキーの作成

```bash
php artisan key:generate
```

7. マイグレーションの実行

```bash
php artisan migrate
```

8. シーディングの実行

```bash
php artisan db:seed
```

## 使用技術(実行環境)

- PHP 8.2
- Laravel 8.83.8
- jquery 3.7.1.min.js
- MySQL 8.0.26
- nginx 1.21.1

## ER図

![ER図](index.png)

## URL

- 開発環境：http://localhost/
- phpMyAdmin:：http://localhost:8080/
