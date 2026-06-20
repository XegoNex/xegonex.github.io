<?php

declare(strict_types=1);

final class XegoNexSpecSite
{
    private HtmlBuilder $html;

    public function __construct()
    {
        $this->html = new HtmlBuilder();
    }

    public function render(): string
    {
        $this->html->raw('<!DOCTYPE html>');
        $this->html->tag('html', ['lang' => 'ru'], $this->buildDocument());
        return $this->html->render();
    }

    private function buildDocument(): string
    {
        $inner = new HtmlBuilder();
        $inner->raw($this->buildHead());
        $inner->tag('body', [], $this->buildBody());
        return $inner->render();
    }

    private function buildHead(): string
    {
        $head = new HtmlBuilder();
        $head->tag('meta', ['charset' => 'UTF-8']);
        $head->tag('meta', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
        $head->tag('meta', ['name' => 'description', 'content' => XegoNexSpecConfig::DESCRIPTION]);
        $head->tag('meta', ['name' => 'theme-color', 'content' => '#0b0f14']);
        $head->tag('meta', ['property' => 'og:title', 'content' => XegoNexSpecConfig::PLUGIN_NAME]);
        $head->tag('meta', ['property' => 'og:description', 'content' => XegoNexSpecConfig::DESCRIPTION]);
        $head->tag('meta', ['property' => 'og:image', 'content' => XegoNexSpecConfig::asset(XegoNexSpecConfig::LOGO)]);
        $head->tag('meta', ['property' => 'og:type', 'content' => 'website']);
        $head->tag('title', [], XegoNexSpecConfig::PAGE_TITLE);
        $head->tag('link', ['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
        $head->tag('link', ['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => true]);
        $head->tag('link', [
            'rel' => 'stylesheet',
            'href' => 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=Syne:wght@500;600;700;800&display=swap',
        ]);
        $head->tag('link', ['rel' => 'stylesheet', 'href' => XegoNexSpecConfig::asset('assets/css/main.css')]);
        $head->tag('link', ['rel' => 'icon', 'type' => 'image/png', 'href' => XegoNexSpecConfig::asset(Config::LOGO)]);
        return $head->render();
    }

    private function buildBody(): string
    {
        $body = new HtmlBuilder();
        $body->raw($this->buildAmbient());
        $body->raw($this->buildHeader());
        $body->tag('main', ['class' => 'spec-page', 'data-spec-page' => 'true'], implode('', [
            $this->buildHero(),
            $this->buildContent(),
            $this->buildGallery(),
        ]));
        $body->raw($this->buildFooter());
        $body->raw(ProjectGallery::modalMarkup());
        $body->tag('script', ['src' => XegoNexSpecConfig::asset('assets/js/app.js'), 'defer' => true]);
        return $body->render();
    }

    private function buildAmbient(): string
    {
        $ambient = new HtmlBuilder();
        $ambient->tag('div', ['class' => 'ambient', 'aria-hidden' => 'true'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__orb ambient__orb--one'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__orb ambient__orb--two'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__grid'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__noise'])->render(),
        ]));
        $ambient->tag('div', ['class' => 'cursor-glow', 'aria-hidden' => 'true']);
        return $ambient->render();
    }

    private function buildHeader(): string
    {
        $header = new HtmlBuilder();
        $navLinks = '';
        foreach (XegoNexSpecConfig::navigation() as $item) {
            $navLinks .= (new HtmlBuilder())->tag('a', [
                'href' => $item['href'],
                'class' => 'nav__link',
                'data-nav' => $item['id'],
            ], $item['label'])->render();
        }

        $header->tag('header', ['class' => 'header'], (new HtmlBuilder())->tag('div', ['class' => 'header__inner container'], implode('', [
            (new HtmlBuilder())->tag('a', ['href' => XegoNexSpecConfig::HOME_URL, 'class' => 'brand'], implode('', [
                (new HtmlBuilder())->tag('img', [
                    'src' => XegoNexSpecConfig::asset(Config::LOGO),
                    'alt' => Config::SITE_NAME,
                    'class' => 'brand__logo',
                    'width' => '48',
                    'height' => '48',
                ], null, true)->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'brand__text'], Config::SITE_NAME)->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('nav', ['class' => 'nav', 'aria-label' => 'Основная навигация'], $navLinks)->render(),
            (new HtmlBuilder())->tag('a', ['href' => '../#contact', 'class' => 'btn btn--primary btn--sm header__cta'], 'Начать проект')->render(),
            (new HtmlBuilder())->tag('button', [
                'class' => 'burger',
                'type' => 'button',
                'aria-label' => 'Открыть меню',
                'aria-expanded' => 'false',
                'data-burger' => 'true',
            ], implode('', [
                (new HtmlBuilder())->tag('span')->render(),
                (new HtmlBuilder())->tag('span')->render(),
                (new HtmlBuilder())->tag('span')->render(),
            ]))->render(),
        ]))->render());

        $mobileLinks = '';
        foreach (XegoNexSpecConfig::navigation() as $item) {
            $mobileLinks .= (new HtmlBuilder())->tag('a', [
                'href' => $item['href'],
                'class' => 'mobile-nav__link',
            ], $item['label'])->render();
        }
        $header->tag('div', ['class' => 'mobile-nav', 'data-mobile-nav' => 'true', 'hidden' => true], implode('', [
            (new HtmlBuilder())->tag('nav', ['class' => 'mobile-nav__panel'], $mobileLinks)->render(),
        ]));

        return $header->render();
    }

    private function buildHero(): string
    {
        $studioLogo = XegoNexSpecConfig::asset(Config::LOGO);
        $hero = new HtmlBuilder();
        $hero->tag('section', ['class' => 'spec-hero section'], (new HtmlBuilder())->tag('div', ['class' => 'container'], (new HtmlBuilder())->tag('div', ['class' => 'spec-hero__bar reveal'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'hero__logo-wrap spec-hero__logo-wrap'], implode('', [
                (new HtmlBuilder())->tag('div', ['class' => 'hero__ring hero__ring--outer'])->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'hero__ring hero__ring--inner'])->render(),
                (new HtmlBuilder())->tag('img', [
                    'src' => $studioLogo,
                    'alt' => Config::SITE_NAME,
                    'class' => 'hero__logo',
                    'width' => '320',
                    'height' => '320',
                ], null, true)->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('a', [
                'href' => XegoNexSpecConfig::HOME_URL,
                'class' => 'spec-home-btn',
            ], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'spec-home-btn__icon', 'aria-hidden' => 'true'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'spec-home-btn__text'], 'Вернуться в главное меню сайта')->render(),
            ]))->render(),
        ]))->render())->render());
        return $hero->render();
    }

    private function buildContent(): string
    {
        $spiritList = $this->buildList(XegoNexSpecConfig::spiritAbilities());
        $visualList = $this->buildList(XegoNexSpecConfig::visualFeatures());
        $benefits = $this->buildChecklist(XegoNexSpecConfig::serverBenefits());

        $hotbar = '';
        foreach (XegoNexSpecConfig::hotbarItems() as $index => $item) {
            $hotbar .= (new HtmlBuilder())->tag('li', [
                'class' => 'spec-hotbar__item reveal',
                'style' => '--reveal-delay:' . ($index * 70) . 'ms',
            ], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'spec-hotbar__emoji'], $item['emoji'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'spec-hotbar__label'], $item['label'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'spec-hotbar__text'], ' — ' . $item['text'])->render(),
            ]))->render();
        }

        $frame = (new HtmlBuilder())->tag('div', ['class' => 'spec-frame reveal'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'spec-frame__glow', 'aria-hidden' => 'true'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-frame__inner'], implode('', [
                $this->buildTextBlock('spec-line spec-line--hook', 'Игроки ливают после смерти?', 0),
                $this->buildTextBlock('spec-line', 'Игрока убили...', 80),
                $this->buildTextBlock('spec-line', 'Он увидел скучный экран смерти, немного посидел и просто закрыл Minecraft.', 160),
                $this->buildTextBlock('spec-line spec-line--accent', 'Знакомо? Тогда у нас есть решение.', 240),
                $this->buildTextBlock('spec-line spec-line--title', 'XegoNexSpec — смерть, после которой хочется остаться на сервере', 320),
                $this->buildTextBlock('spec-line', 'XegoNexSpec — это плагин от студии XegoNexStudio, который превращает обычную смерть в полноценную игровую механику.', 400),
                $this->buildMeta(),
                $this->buildTextBlock('spec-line', 'Вместо скучного ожидания респауна игрок становится духом и может продолжать взаимодействовать с миром.', 480),
                (new HtmlBuilder())->tag('h2', ['class' => 'spec-heading reveal', 'style' => '--reveal-delay:540ms'], 'Что он может делать после смерти?')->render(),
                (new HtmlBuilder())->tag('ul', ['class' => 'spec-list'], $spiritList)->render(),
                $this->buildTextBlock('spec-line', 'Игрок не выпадает из игрового процесса и остаётся вовлечённым даже после смерти.', 620),
                (new HtmlBuilder())->tag('h2', ['class' => 'spec-heading reveal', 'style' => '--reveal-delay:680ms'], 'Что есть в плагине?')->render(),
                (new HtmlBuilder())->tag('h3', ['class' => 'spec-subheading reveal', 'style' => '--reveal-delay:720ms'], 'Удобное управление через предметы')->render(),
                $this->buildTextBlock('spec-line spec-line--muted', 'Никаких сложных меню и лишних команд.', 760),
                (new HtmlBuilder())->tag('ul', ['class' => 'spec-hotbar'], $hotbar)->render(),
                $this->buildTextBlock('spec-line spec-line--muted', 'Всё управление находится прямо в хотбаре и интуитивно понятно любому игроку.', 840),
                (new HtmlBuilder())->tag('h3', ['class' => 'spec-subheading reveal', 'style' => '--reveal-delay:880ms'], 'Качественные звуки и визуальные эффекты')->render(),
                $this->buildTextBlock('spec-line spec-line--muted', 'Каждое действие сопровождается приятными звуками и визуалами, которые делают режим духа действительно атмосферным.', 920),
                (new HtmlBuilder())->tag('ul', ['class' => 'spec-list'], $visualList)->render(),
                (new HtmlBuilder())->tag('h2', ['class' => 'spec-heading reveal', 'style' => '--reveal-delay:1020ms'], 'Почему это полезно для сервера?')->render(),
                $this->buildTextBlock('spec-line', 'На большинстве серверов смерть означает потерю интереса и выход из игры.', 1080),
                $this->buildTextBlock('spec-line', 'С XegoNexSpec игрок продолжает наблюдать за событиями, взаимодействовать с миром и остаётся на сервере дольше.', 1140),
                (new HtmlBuilder())->tag('ul', ['class' => 'spec-checklist'], $benefits)->render(),
            ]))->render(),
        ]))->render();

        return (new HtmlBuilder())->tag('section', ['class' => 'spec-content section'], (new HtmlBuilder())->tag('div', ['class' => 'container'], $frame))->render();
    }

    private function buildMeta(): string
    {
        $items = [
            ['emoji' => '💰', 'label' => 'ЦЕНА', 'value' => 'БЕСПЛАТНО'],
            ['emoji' => '💠', 'label' => 'Версия', 'value' => '1.16.5 - 1.21.1 paper/spigot'],
            ['emoji' => '🍕', 'label' => 'Скачать', 'value' => XegoNexSpecConfig::DOWNLOAD_URL, 'href' => XegoNexSpecConfig::DOWNLOAD_URL],
        ];

        $markup = '';
        foreach ($items as $index => $item) {
            $value = isset($item['href'])
                ? (new HtmlBuilder())->tag('a', [
                    'href' => $item['href'],
                    'class' => 'spec-meta__value spec-meta__link',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer',
                ], $item['value'])->render()
                : (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__value'], $item['value'])->render();

            $inner = implode('', [
                (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__head'], implode('', [
                    (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__emoji'], $item['emoji'])->render(),
                    (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__label'], $item['label'])->render(),
                ]))->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__body'], $value)->render(),
            ]);

            $markup .= (new HtmlBuilder())->tag('div', [
                'class' => 'spec-meta__item reveal',
                'style' => '--reveal-delay:' . ($index * 90) . 'ms',
            ], $inner)->render();
        }

        return (new HtmlBuilder())->tag('div', ['class' => 'spec-meta'], $markup)->render();
    }

    private function buildGallery(): string
    {
        $gallery = XegoNexSpecConfig::gallery();
        $json = json_encode($gallery, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $items = '';

        foreach ($gallery as $index => $src) {
            $items .= (new HtmlBuilder())->tag('figure', [
                'class' => 'spec-gallery__item reveal project-card--gallery',
                'style' => '--reveal-delay:' . ($index * 60) . 'ms',
                'data-project-gallery' => $json,
                'data-project-title' => XegoNexSpecConfig::PLUGIN_NAME,
                'tabindex' => '0',
                'role' => 'button',
            ], (new HtmlBuilder())->tag('img', [
                'src' => $src,
                'alt' => XegoNexSpecConfig::PLUGIN_NAME . ' — скриншот ' . ($index + 1),
                'class' => 'spec-gallery__img',
                'loading' => $index < 4 ? 'eager' : 'lazy',
            ], null, true)->render())->render();
        }

        return (new HtmlBuilder())->tag('section', ['class' => 'spec-gallery section'], (new HtmlBuilder())->tag('div', ['class' => 'container'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'section-head reveal'], implode('', [
                (new HtmlBuilder())->tag('p', ['class' => 'eyebrow'], 'Скриншоты')->render(),
                (new HtmlBuilder())->tag('h2', ['class' => 'section-head__title'], 'XegoNexSpec в игре')->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-gallery__grid'], $items)->render(),
        ]))->render());
    }

    private function buildFooter(): string
    {
        return (new HtmlBuilder())->tag('footer', ['class' => 'footer'], (new HtmlBuilder())->tag('div', ['class' => 'container footer__inner'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'footer__brand'], implode('', [
                (new HtmlBuilder())->tag('img', [
                    'src' => XegoNexSpecConfig::asset(Config::LOGO),
                    'alt' => '',
                    'class' => 'footer__logo',
                    'width' => '32',
                    'height' => '32',
                    'aria-hidden' => 'true',
                ], null, true)->render(),
                (new HtmlBuilder())->tag('span', [], Config::SITE_NAME)->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('p', ['class' => 'footer__copy'], '© ' . XegoNexSpecConfig::YEAR . ' ' . Config::SITE_NAME . '. Все права защищены.')->render(),
            (new HtmlBuilder())->tag('a', ['href' => XegoNexSpecConfig::HOME_URL, 'class' => 'footer__top'], 'На главную')->render(),
        ]))->render();
    }

    private function buildTextBlock(string $class, string $text, int $delay): string
    {
        return (new HtmlBuilder())->tag('p', [
            'class' => $class . ' reveal',
            'style' => '--reveal-delay:' . $delay . 'ms',
        ], $text)->render();
    }

    private function buildList(array $items): string
    {
        $markup = '';
        foreach ($items as $index => $item) {
            $markup .= (new HtmlBuilder())->tag('li', [
                'class' => 'spec-list__item reveal',
                'style' => '--reveal-delay:' . ($index * 55) . 'ms',
            ], $item)->render();
        }
        return $markup;
    }

    private function buildChecklist(array $items): string
    {
        $markup = '';
        foreach ($items as $index => $item) {
            $markup .= (new HtmlBuilder())->tag('li', [
                'class' => 'spec-checklist__item reveal',
                'style' => '--reveal-delay:' . ($index * 70) . 'ms',
            ], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'spec-checklist__mark', 'aria-hidden' => 'true'], '✅')->render(),
                (new HtmlBuilder())->tag('span', [], $item)->render(),
            ]))->render();
        }
        return $markup;
    }
}
