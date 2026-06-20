<?php

declare(strict_types=1);

final class XegoNexSpecConfig
{
    public const BASE = '../';
    public const PAGE_TITLE = 'XegoNexSpec — режим духа после смерти';
    public const DESCRIPTION = 'XegoNexSpec превращает смерть в полноценную игровую механику: игрок становится духом и остаётся вовлечённым на сервере.';
    public const PLUGIN_NAME = 'XegoNexSpec';
    public const LOGO = 'plugins/XegoNexSpec (1).png';
    public const DOWNLOAD_URL = 'https://drive.google.com/file/d/17h43HU-1JmUSoKXlTbJYf0L5nBKn1Yvb/view?usp=sharing';
    public const HOME_URL = '../';
    public const YEAR = 2026;

    public static function asset(string $path): string
    {
        return self::BASE . ltrim($path, '/');
    }

    public static function gallery(): array
    {
        $shots = [];
        for ($index = 1; $index <= 9; $index++) {
            $shots[] = self::asset('plugins/XegoNexSpec (' . $index . ').png');
        }
        return $shots;
    }

    public static function navigation(): array
    {
        return [
            ['id' => 'home', 'label' => 'Главная', 'href' => '../#home'],
            ['id' => 'services', 'label' => 'Услуги', 'href' => '../#services'],
            ['id' => 'projects', 'label' => 'Проекты', 'href' => '../#projects'],
            ['id' => 'process', 'label' => 'Процесс', 'href' => '../#process'],
            ['id' => 'contact', 'label' => 'Контакты', 'href' => '../#contact'],
        ];
    }

    public static function spiritAbilities(): array
    {
        return [
            'Летать по карте и наблюдать за происходящим',
            'Следить за своим убийцей',
            'Настраивать скорость полёта прямо во время игры',
            'Дать убийце символическую пощёчину',
            'Возродиться в любой удобный момент',
        ];
    }

    public static function hotbarItems(): array
    {
        return [
            ['emoji' => '✒️', 'label' => 'Перо', 'text' => 'изменение скорости полёта'],
            ['emoji' => '🏏', 'label' => 'Палка', 'text' => 'пощёчина убийце'],
            ['emoji' => '🧶', 'label' => 'Шерсть', 'text' => 'возрождение'],
        ];
    }

    public static function visualFeatures(): array
    {
        return [
            'Красивое появление после смерти',
            'Проработанные звуковые эффекты',
            'Приятные анимации и визуальные детали',
        ];
    }

    public static function serverBenefits(): array
    {
        return [
            'Меньше ливов после смерти',
            'Больше удержание игроков',
            'Больше активности и интереса к игре',
        ];
    }
}
