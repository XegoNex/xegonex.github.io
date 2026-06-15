<?php

declare(strict_types=1);

final class Config
{
    public const SITE_NAME = 'XegoNexStudio';
    public const TAGLINE = 'Разработка в сфере Minecraft с точностью до детали';
    public const DESCRIPTION = 'Проектируем и создаём плагины, серверные сборки, веб-системы, локализацию конфигов и игровую механику — от идеи до стабильного релиза.';
    public const YEAR = 2026;
    public const LOGO = 'assets/img/xegonex.png';
    public const PAGE_TITLE = 'XegoNexStudio — Студия разработки в сфере Minecraft';
    public const COMPLETED_WORKS = 48;
    public const SITE_URL = 'https://xegonexstudio.github.io';

    public static function absoluteUrl(string $path): string
    {
        if (self::SITE_URL === '') {
            return $path;
        }

        return rtrim(self::SITE_URL, '/') . '/' . ltrim($path, '/');
    }

    public static function navigation(): array
    {
        return [
            ['id' => 'home', 'label' => 'Главная'],
            ['id' => 'services', 'label' => 'Услуги'],
            ['id' => 'projects', 'label' => 'Проекты'],
            ['id' => 'process', 'label' => 'Процесс'],
            ['id' => 'contact', 'label' => 'Контакты'],
        ];
    }

    public static function serviceCategories(): array
    {
        return [
            [
                'id' => 'plugins',
                'label' => 'Плагины',
                'items' => [
                    [
                        'icon' => 'plugin',
                        'title' => 'Кастомные плагины',
                        'text' => 'Индивидуальные решения для Bukkit, Spigot, Paper и Velocity под задачи вашего сервера.',
                    ],
                    [
                        'icon' => 'economy',
                        'title' => 'Экономические системы',
                        'text' => 'Сбалансированные магазины, аукционы, валюты и прогрессия, удерживающие игроков.',
                    ],
                    [
                        'icon' => 'pvp',
                        'title' => 'PvP и мини-игры',
                        'text' => 'Арены, киты, матчмейкинг, интеграция с античитом и отточенный соревновательный опыт.',
                    ],
                    [
                        'icon' => 'api',
                        'title' => 'API-интеграции',
                        'text' => 'Связка с Discord, веб-панели, базы данных и сторонние сервисы.',
                    ],
                    [
                        'icon' => 'optimize',
                        'title' => 'Оптимизация',
                        'text' => 'Профилирование, асинхронные пайплайны и безопасная по памяти архитектура для крупных сетей.',
                    ],
                    [
                        'icon' => 'support',
                        'title' => 'Долгосрочная поддержка',
                        'text' => 'Миграции версий, исправления и развитие функционала после релиза.',
                    ],
                ],
            ],
            [
                'id' => 'packs',
                'label' => 'Сборки',
                'items' => [
                    [
                        'icon' => 'pack',
                        'title' => 'Серверные сборки',
                        'text' => 'Готовые конфигурации Paper и Spigot с пресетами режимов, прав и стартовым балансом.',
                    ],
                    [
                        'icon' => 'mod',
                        'title' => 'Модовые сборки',
                        'text' => 'Forge и Fabric с подбором модов, совместимостью и тестированием под вашу аудиторию.',
                    ],
                    [
                        'icon' => 'config',
                        'title' => 'Конфиги и локализация',
                        'text' => 'Настройка yml, lang-файлов, перевод строк и структурирование конфигураций без хаоса.',
                    ],
                    [
                        'icon' => 'network',
                        'title' => 'Прокси и сеть',
                        'text' => 'Velocity и BungeeCord, синхронизация данных между хабами и стабильная маршрутизация игроков.',
                    ],
                    [
                        'icon' => 'deploy',
                        'title' => 'Деплой и запуск',
                        'text' => 'Развёртывание на хостинге, автозапуск, резервные копии и базовый мониторинг.',
                    ],
                    [
                        'icon' => 'tune',
                        'title' => 'Тонкая настройка',
                        'text' => 'TPS, память, профили миров, анти-лаг пайплайны и оптимизация под онлайн.',
                    ],
                ],
            ],
            [
                'id' => 'websites',
                'label' => 'Сайты',
                'items' => [
                    [
                        'icon' => 'web',
                        'title' => 'Веб-панели сервера',
                        'text' => 'Личный кабинет, статистика игроков, управление аккаунтами и донатом в одном интерфейсе.',
                    ],
                    [
                        'icon' => 'rcon',
                        'title' => 'API и RCON',
                        'text' => 'REST и WebSocket, удалённое управление сервером, очереди команд и связь с игровым ядром.',
                    ],
                    [
                        'icon' => 'portal',
                        'title' => 'Лендинги и порталы',
                        'text' => 'Промо-сайты, правила, магазины, OAuth через Discord и VK для вашего проекта.',
                    ],
                ],
            ],
        ];
    }

    public static function trustFeatures(): array
    {
        return [
            ['icon' => 'shield', 'text' => 'Максимальная безопасность'],
            ['icon' => 'deal', 'text' => 'Прозрачные сделки'],
            ['icon' => 'funpay', 'text' => 'Оплата через FunPay'],
        ];
    }

    public static function projects(): array
    {
        return [
            [
                'title' => 'BedWars',
                'category' => 'Мини-игры',
                'description' => 'Классический режим BedWars с продуманной логикой магазинов, генераторов, улучшений и кастомных предметов.',
                'tags' => ['Paper 1.8 - 1.21+'],
                'image' => 'plugins/BedWarsPlugin (1).png',
                'gallery' => [
                    'plugins/BedWarsPlugin (3).png',
                    'plugins/BedWarsPlugin (4).png',
                    'plugins/BedWarsPlugin (5).png',
                    'plugins/BedWarsPlugin (6).png',
                    'plugins/BedWarsPlugin (7).png',
                    'plugins/BedWarsPlugin (8).png',
                    'plugins/BedWarsPlugin (9).png',
                    'plugins/BedWarsPlugin (10).png',
                    'plugins/BedWarsPlugin (11).png',
                ],
            ],
            [
                'title' => 'Система дуэлей',
                'category' => 'PvP',
                'description' => 'Удобный вызов на дуэли, арены, учёт побед, аналогия FunTime.',
                'tags' => ['Paper'],
                'image' => 'plugins/DuelPlugin (4).PNG',
                'gallery' => [
                    'plugins/DuelPlugin (1).PNG',
                    'plugins/DuelPlugin (2).PNG',
                    'plugins/DuelPlugin (3).PNG',
                    'plugins/DuelPlugin (4).PNG',
                    'plugins/DuelPlugin (5).PNG',
                    'plugins/DuelPlugin (6).PNG',
                    'plugins/DuelPlugin (7).PNG',
                    'plugins/DuelPlugin (8).PNG',
                ],
            ],
            [
                'title' => 'Счётчик наигранного времени',
                'category' => 'Статистика',
                'description' => 'Учёт времени онлайн игрока с возможностью наград, фильтров и защиты от афк.',
                'tags' => ['Paper'],
                'image' => 'plugins/PluginTime (10).PNG',
                'gallery' => [
                    'plugins/PluginTime (8).PNG',
                    'plugins/PluginTime (9).PNG',
                    'plugins/PluginTime (10).PNG',
                    'plugins/PluginTime (11).PNG',
                    'plugins/PluginTime (12).PNG',
                ],
            ],
            [
                'title' => 'Ресурсная система',
                'category' => 'Экономика',
                'description' => 'Генераторы ресурсов с апгрейдами и лимитами.',
                'tags' => ['Paper'],
                'image' => 'plugins/GeneratorPlugin (3).PNG',
                'gallery' => [
                    'plugins/GeneratorPlugin (1).PNG',
                    'plugins/GeneratorPlugin (2).PNG',
                    'plugins/GeneratorPlugin (3).PNG',
                ],
            ],
        ];
    }

    public static function process(): array
    {
        return [
            ['step' => '01', 'title' => 'Анализ', 'text' => 'Определяем цели, технический стек и сроки.'],
            ['step' => '02', 'title' => 'Архитектура', 'text' => 'На старте фиксируем модели данных, поток событий и контракты API.'],
            ['step' => '03', 'title' => 'Разработка', 'text' => 'Итеративные сборки с выкладкой на тестовый сервер каждый спринт.'],
            ['step' => '04', 'title' => 'Передача', 'text' => 'Документация, сдача проекта и сопровождение после запуска.'],
        ];
    }

    public static function stack(): array
    {
        return ['Java', 'Paper', 'Spigot', 'Velocity', 'MySQL', 'Redis', 'Gradle', 'Maven'];
    }

    public static function contacts(): array
    {
        return [
            ['type' => 'vk', 'label' => 'ВКонтакте', 'value' => 'xegonexstudio', 'href' => 'https://vk.com/xegonexstudio'],
            ['type' => 'telegram', 'label' => 'Telegram', 'value' => '@xegonexstudio', 'href' => 'https://t.me/xegonexstudio'],
        ];
    }

    public static function ui(): array
    {
        return [
            'nav_aria' => 'Основная навигация',
            'cta_header' => 'Начать проект',
            'menu_open' => 'Открыть меню',
            'hero_eyebrow' => 'Студия разработки в сфере Minecraft',
            'hero_title_prefix' => 'Создаём проекты, которые ',
            'hero_title_highlight' => 'растут вместе с вашим сервером',
            'hero_btn_work' => 'Смотреть работы',
            'hero_btn_contact' => 'Связаться',
            'hero_badge' => 'Открыты для новых проектов',
            'services_eyebrow' => 'Чем занимаемся',
            'services_title' => 'Комплексная разработка под ключ',
            'services_text' => 'Плагины, сборки, сайты и конфиги — от идеи до релиза, стабильно и готово к нагрузке.',
            'projects_eyebrow' => 'Избранные работы',
            'projects_title' => 'Работы одного из наших сотрудников',
            'projects_text' => 'Автор: manlixlol',
            'works_label' => 'выполнено работ:',
            'projects_more' => 'И многие другие...',
            'stack_label' => 'Технологии',
            'process_eyebrow' => 'Как мы работаем',
            'process_title' => 'Прозрачная разработка',
            'contact_eyebrow' => 'Контакты',
            'contact_title' => 'Реализуем вашу следующую техническую идею',
            'contact_text' => 'Расскажите о задаче, механиках и сроках. Ответим максимально быстро.',
            'footer_rights' => 'Все права защищены.',
            'footer_top' => 'Наверх',
        ];
    }
}
