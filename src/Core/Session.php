<?php

declare(strict_types=1);

namespace Altair\Core;

final class Session
{
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    public static function destroy(): void
    {
        self::start();
        session_destroy();
        $_SESSION = [];
    }

    public static function flash(string $key, mixed $value): void
    {
        self::set("flash_{$key}", $value);
    }

    public static function getFlash(string $key, mixed $default = null): mixed
    {
        $value = self::get("flash_{$key}", $default);
        self::remove("flash_{$key}");
        return $value;
    }

    public static function hasFlash(string $key): bool
    {
        return self::has("flash_{$key}");
    }
}
