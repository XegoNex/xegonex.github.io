<?php

declare(strict_types=1);

final class XegoSpecialConfig
{
    public const BASE = '../';
    public const PAGE_TITLE = 'XegoSpecial — уникальные PvP-предметы';
    public const DESCRIPTION = 'XegoSpecial добавляет на сервер десятки специальных предметов с уникальными способностями, превращая обычное PvP в настоящее безумие.';
    public const PLUGIN_NAME = 'XegoSpecial';
    public const LOGO = 'plugins/XegoSpecial (1).png';
    public const PHOTOS_URL = 'https://xegonex.github.io/xegospecial/';
    public const VK_URL = 'https://vk.me/xegonexstudio';
    public const TG_URL = 'https://t.me/xegonexstudio?direct';
    public const HOME_URL = '../';
    public const YEAR = 2026;
    public const GALLERY_COUNT = 15;

    public static function asset(string $path): string
    {
        return self::BASE . ltrim($path, '/');
    }

    public static function gallery(): array
    {
        $shots = [];
        for ($index = 1; $index <= self::GALLERY_COUNT; $index++) {
            $shots[] = self::asset('plugins/XegoSpecial (' . $index . ').png');
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

    public static function pluginItems(): array
    {
        return [
            [
                'emoji' => '🧠',
                'title' => 'Сломи голову',
                'intro' => 'Дезориентируй всех противников вокруг себя и заставь их потерять контроль над ситуацией.',
                'bullets' => [
                    'Тошнота на 2 секунды',
                    'Замедление на 30 секунд',
                    'Слепота на 5 секунд',
                    'Радиус действия — 5 блоков',
                ],
                'outro' => 'Идеально подходит для начала атаки или побега из опасной ситуации.',
            ],
            [
                'emoji' => '🌫',
                'title' => 'Сухой туман',
                'intro' => 'Создаёт вокруг себя загадочную сферу из красных частиц.',
                'lead' => 'Враги внутри сферы получают:',
                'bullets' => [
                    'Свечение на 10 секунд',
                    'Блокировку выхода из сферы',
                    'Возможность выбраться только при помощи эндер-жемчуга',
                ],
                'outro' => 'Отличный инструмент для ловушек, контроля территории и командных сражений.',
            ],
            [
                'emoji' => '🌀',
                'title' => 'Искажение',
                'intro' => 'Полный хаос в радиусе действия.',
                'lead' => 'После активации игроки вокруг случайным образом меняются местами.',
                'bullets' => [
                    'Радиус — 5 блоков',
                    'Мгновенная перестановка позиций',
                    'Идеально ломает построение противников',
                ],
                'outro' => 'Никто не знает, где окажется через секунду.',
            ],
            [
                'emoji' => '✨',
                'title' => 'Мерцание',
                'intro' => 'Стань практически неуловимым.',
                'bullets' => [
                    'Телепорт вперёд на 10 блоков',
                    'Создание фантомной копии',
                    'Копия существует 3 секунды',
                ],
                'outro' => 'Противник часто атакует призрака вместо настоящего игрока.',
            ],
            [
                'emoji' => '💨',
                'title' => 'Рваный пар',
                'intro' => 'Позволяет быстро изменить позицию во время боя.',
                'bullets' => [
                    'Подбрасывает игрока вверх',
                    'Даёт плавное падение на 5 секунд',
                    'Помогает уйти из комбо или занять выгодную позицию',
                ],
            ],
            [
                'emoji' => '🔥',
                'title' => 'И многое другое',
                'paragraphs' => [
                    'Плагин содержит множество уникальных предметов и постоянно открывает новые возможности для тактики.',
                    'Каждый бой становится непредсказуемым.',
                    'Каждый предмет способен полностью изменить ход сражения.',
                ],
            ],
        ];
    }

    public static function visualFeatures(): array
    {
        return [
            'Уникальными частицами',
            'Атмосферными звуками',
            'Красивыми анимациями',
            'Эффектными появлениями способностей',
        ];
    }

    public static function configOptions(): array
    {
        return [
            'Кулдауны',
            'Радиусы',
            'Длительность эффектов',
            'Материалы предметов',
            'Сообщения',
            'Частицы и звуки',
        ];
    }

    public static function serverBenefits(): array
    {
        return [
            'Более динамичные PvP-сражения',
            'Уникальный игровой опыт',
            'Новые тактики и стратегии',
            'Больше интереса к сражениям',
            'Игрокам хочется экспериментировать с предметами',
            'Больше фана и эпичных моментов',
        ];
    }
}
