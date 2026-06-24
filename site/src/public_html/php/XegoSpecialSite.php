<?php

declare(strict_types=1);

final class XegoSpecialSite
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
        $head->tag('meta', ['name' => 'description', 'content' => XegoSpecialConfig::DESCRIPTION]);
        $head->tag('meta', ['name' => 'theme-color', 'content' => '#0b0f14']);
        $head->tag('meta', ['property' => 'og:title', 'content' => XegoSpecialConfig::PLUGIN_NAME]);
        $head->tag('meta', ['property' => 'og:description', 'content' => XegoSpecialConfig::DESCRIPTION]);
        $head->tag('meta', ['property' => 'og:image', 'content' => XegoSpecialConfig::asset(XegoSpecialConfig::LOGO)]);
        $head->tag('meta', ['property' => 'og:type', 'content' => 'website']);
        $head->tag('title', [], XegoSpecialConfig::PAGE_TITLE);
        $head->tag('link', ['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
        $head->tag('link', ['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => true]);
        $head->tag('link', [
            'rel' => 'stylesheet',
            'href' => 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=Syne:wght@500;600;700;800&display=swap',
        ]);
        $head->tag('link', ['rel' => 'stylesheet', 'href' => XegoSpecialConfig::asset('assets/css/main.css')]);
        $head->tag('link', ['rel' => 'icon', 'type' => 'image/png', 'href' => XegoSpecialConfig::asset(Config::LOGO)]);
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
        $body->tag('script', ['src' => XegoSpecialConfig::asset('assets/js/app.js'), 'defer' => true]);
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
        foreach (XegoSpecialConfig::navigation() as $item) {
            $navLinks .= (new HtmlBuilder())->tag('a', [
                'href' => $item['href'],
                'class' => 'nav__link',
                'data-nav' => $item['id'],
            ], $item['label'])->render();
        }

        $header->tag('header', ['class' => 'header'], (new HtmlBuilder())->tag('div', ['class' => 'header__inner container'], implode('', [
            (new HtmlBuilder())->tag('a', ['href' => XegoSpecialConfig::HOME_URL, 'class' => 'brand'], implode('', [
                (new HtmlBuilder())->tag('img', [
                    'src' => XegoSpecialConfig::asset(Config::LOGO),
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
        foreach (XegoSpecialConfig::navigation() as $item) {
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
        $studioLogo = XegoSpecialConfig::asset(Config::LOGO);
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
            (new HtmlBuilder())->tag('div', ['class' => 'spec-hero__aside'], implode('', [
                (new HtmlBuilder())->tag('a', [
                    'href' => XegoSpecialConfig::HOME_URL,
                    'class' => 'spec-home-btn',
                ], implode('', [
                    (new HtmlBuilder())->tag('span', ['class' => 'spec-home-btn__icon', 'aria-hidden' => 'true'])->render(),
                    (new HtmlBuilder())->tag('span', ['class' => 'spec-home-btn__text'], 'Вернуться в главное меню сайта')->render(),
                ]))->render(),
                (new HtmlBuilder())->tag('a', [
                    'href' => '#spec-content',
                    'class' => 'spec-scroll-hint',
                ], implode('', [
                    (new HtmlBuilder())->tag('span', ['class' => 'spec-scroll-hint__text'], 'Листай вниз')->render(),
                    (new HtmlBuilder())->tag('span', ['class' => 'spec-scroll-hint__arrow', 'aria-hidden' => 'true'])->render(),
                ]))->render(),
            ]))->render(),
        ]))->render())->render());
        return $hero->render();
    }

    private function buildContent(): string
    {
        $visualList = $this->buildList(XegoSpecialConfig::visualFeatures());
        $configList = $this->buildList(XegoSpecialConfig::configOptions());
        $benefits = $this->buildChecklist(XegoSpecialConfig::serverBenefits());

        $pluginBlocks = '';
        $delay = 760;
        foreach (XegoSpecialConfig::pluginItems() as $item) {
            $pluginBlocks .= $this->buildPluginItem($item, $delay);
            $delay += 320;
        }

        $frame = (new HtmlBuilder())->tag('div', ['class' => 'spec-frame reveal'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'spec-frame__glow', 'aria-hidden' => 'true'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-frame__inner'], implode('', [
                $this->buildTextBlock('spec-line spec-line--hook', 'Наскучили одинаковые PvP-сражения?', 0),
                $this->buildTextBlock('spec-line', 'Каждый бой проходит по одному сценарию: удар, тотем, эндер-перл, победа или поражение. Никаких неожиданных ситуаций, никаких уникальных механик.', 80),
                $this->buildTextBlock('spec-line spec-line--accent', 'Тогда тебе нужен XegoSpecial.', 160),
                $this->buildTextBlock('spec-line spec-line--title', 'XegoSpecial — специальные предметы для настоящего PvP-хаоса', 240),
                $this->buildTextBlock('spec-line', 'XegoSpecial — это плагин от студии XegoNexStudio, который добавляет на сервер десятки специальных предметов с уникальными способностями, превращая обычное PvP в настоящее безумие.', 320),
                $this->buildMeta(),
                $this->buildTextBlock('spec-line', 'Каждый предмет обладает собственной способностью, визуальными эффектами, звуками и системой кулдаунов.', 560),
                $this->buildTextBlock('spec-line', 'Теперь победа зависит не только от брони и меча, но и от того, насколько грамотно игрок использует свои специальные предметы.', 640),
                (new HtmlBuilder())->tag('h2', ['class' => 'spec-heading reveal', 'style' => '--reveal-delay:720ms'], '⚔️ Что есть в плагине?')->render(),
                $pluginBlocks,
                (new HtmlBuilder())->tag('h2', ['class' => 'spec-heading reveal', 'style' => '--reveal-delay:' . ($delay + 40) . 'ms'], '🎨 Красивые эффекты и звуки')->render(),
                $this->buildTextBlock('spec-line spec-line--muted', 'Каждая способность сопровождается:', $delay + 100),
                (new HtmlBuilder())->tag('ul', ['class' => 'spec-list'], $visualList)->render(),
                $this->buildTextBlock('spec-line', 'Игроки сразу понимают, что произошло, и ощущают силу каждого предмета.', $delay + 180),
                (new HtmlBuilder())->tag('h2', ['class' => 'spec-heading reveal', 'style' => '--reveal-delay:' . ($delay + 240) . 'ms'], '⚙️ Простая настройка')->render(),
                $this->buildTextBlock('spec-line spec-line--muted', 'Все предметы настраиваются через конфиг.', $delay + 300),
                $this->buildTextBlock('spec-line spec-line--muted', 'Можно изменять:', $delay + 360),
                (new HtmlBuilder())->tag('ul', ['class' => 'spec-list'], $configList)->render(),
                $this->buildTextBlock('spec-line', 'Плагин легко адаптируется под любой режим сервера.', $delay + 440),
                (new HtmlBuilder())->tag('h2', ['class' => 'spec-heading reveal', 'style' => '--reveal-delay:' . ($delay + 500) . 'ms'], 'Почему это полезно для сервера?')->render(),
                $this->buildTextBlock('spec-line', 'На многих серверах PvP быстро становится однообразным.', $delay + 560),
                $this->buildTextBlock('spec-line', 'С XegoSpecial каждый бой превращается в отдельную историю, где исход зависит не только от экипировки, но и от правильного использования способностей.', $delay + 620),
                (new HtmlBuilder())->tag('ul', ['class' => 'spec-checklist'], $benefits)->render(),
            ]))->render(),
        ]))->render();

        return (new HtmlBuilder())->tag('section', ['class' => 'spec-content section', 'id' => 'spec-content'], (new HtmlBuilder())->tag('div', ['class' => 'container'], $frame))->render();
    }

    private function buildPluginItem(array $item, int $baseDelay): string
    {
        $heading = $item['emoji'] . ' ' . $item['title'];
        $blocks = (new HtmlBuilder())->tag('h3', [
            'class' => 'spec-subheading reveal',
            'style' => '--reveal-delay:' . $baseDelay . 'ms',
        ], $heading)->render();

        if (isset($item['intro'])) {
            $blocks .= $this->buildTextBlock('spec-line spec-line--muted', $item['intro'], $baseDelay + 40);
        }

        if (isset($item['lead'])) {
            $blocks .= $this->buildTextBlock('spec-line spec-line--muted', $item['lead'], $baseDelay + 80);
        }

        if (isset($item['bullets'])) {
            $blocks .= (new HtmlBuilder())->tag('ul', ['class' => 'spec-list'], $this->buildList($item['bullets']))->render();
        }

        if (isset($item['outro'])) {
            $blocks .= $this->buildTextBlock('spec-line', $item['outro'], $baseDelay + 160);
        }

        if (isset($item['paragraphs'])) {
            $offset = 40;
            foreach ($item['paragraphs'] as $paragraph) {
                $blocks .= $this->buildTextBlock('spec-line', $paragraph, $baseDelay + $offset);
                $offset += 60;
            }
        }

        return $blocks;
    }

    private function buildMeta(): string
    {
        $price = (new HtmlBuilder())->tag('div', [
            'class' => 'spec-meta__item reveal',
            'style' => '--reveal-delay:0ms',
        ], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__head'], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__emoji'], '💰')->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__label'], 'ЦЕНА')->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__body'], (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__value'], '49₽')->render())->render(),
        ]))->render();

        $photos = (new HtmlBuilder())->tag('div', [
            'class' => 'spec-meta__item reveal',
            'style' => '--reveal-delay:90ms',
        ], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__head'], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__emoji'], '📎')->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__label'], 'Фото плагина')->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__body'], (new HtmlBuilder())->tag('a', [
                'href' => XegoSpecialConfig::PHOTOS_URL,
                'class' => 'spec-meta__value spec-meta__link',
                'target' => '_blank',
                'rel' => 'noopener noreferrer',
            ], 'xegonex.github.io/xegospecial/')->render())->render(),
        ]))->render();

        $version = (new HtmlBuilder())->tag('div', [
            'class' => 'spec-meta__item reveal',
            'style' => '--reveal-delay:180ms',
        ], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__head'], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__emoji'], '💠')->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__label'], 'Версия')->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__body'], (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__value'], '1.16.5 - 1.21.1 Paper / Spigot')->render())->render(),
        ]))->render();

        $buy = (new HtmlBuilder())->tag('div', [
            'class' => 'spec-meta__item spec-meta__item--download reveal',
            'style' => '--reveal-delay:270ms',
        ], (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__download'], implode('', [
            (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__download-emoji'], '🍕')->render(),
            (new HtmlBuilder())->tag('span', ['class' => 'spec-meta__label'], 'Купить')->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-meta__buy-row'], implode('', [
                (new HtmlBuilder())->tag('a', [
                    'href' => XegoSpecialConfig::VK_URL,
                    'class' => 'spec-meta__download-btn',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer',
                ], 'ВК')->render(),
                (new HtmlBuilder())->tag('a', [
                    'href' => XegoSpecialConfig::TG_URL,
                    'class' => 'spec-meta__download-btn',
                    'target' => '_blank',
                    'rel' => 'noopener noreferrer',
                ], 'ТГ')->render(),
            ]))->render(),
        ]))->render())->render();

        return (new HtmlBuilder())->tag('div', ['class' => 'spec-meta'], $price . $photos . $version . $buy)->render();
    }

    private function buildGallery(): string
    {
        $gallery = XegoSpecialConfig::gallery();
        $json = json_encode($gallery, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        $items = '';

        foreach ($gallery as $index => $src) {
            $items .= (new HtmlBuilder())->tag('figure', [
                'class' => 'spec-gallery__item reveal project-card--gallery',
                'style' => '--reveal-delay:' . ($index * 60) . 'ms',
                'data-project-gallery' => $json,
                'data-project-title' => XegoSpecialConfig::PLUGIN_NAME,
                'tabindex' => '0',
                'role' => 'button',
            ], (new HtmlBuilder())->tag('img', [
                'src' => $src,
                'alt' => XegoSpecialConfig::PLUGIN_NAME . ' — скриншот ' . ($index + 1),
                'class' => 'spec-gallery__img',
                'loading' => $index < 4 ? 'eager' : 'lazy',
            ], null, true)->render())->render();
        }

        return (new HtmlBuilder())->tag('section', ['class' => 'spec-gallery section'], (new HtmlBuilder())->tag('div', ['class' => 'container'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'section-head reveal'], implode('', [
                (new HtmlBuilder())->tag('p', ['class' => 'eyebrow'], 'Скриншоты')->render(),
                (new HtmlBuilder())->tag('h2', ['class' => 'section-head__title'], 'XegoSpecial в игре')->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'spec-gallery__grid'], $items)->render(),
        ]))->render());
    }

    private function buildFooter(): string
    {
        return (new HtmlBuilder())->tag('footer', ['class' => 'footer'], (new HtmlBuilder())->tag('div', ['class' => 'container footer__inner'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'footer__brand'], implode('', [
                (new HtmlBuilder())->tag('img', [
                    'src' => XegoSpecialConfig::asset(Config::LOGO),
                    'alt' => '',
                    'class' => 'footer__logo',
                    'width' => '32',
                    'height' => '32',
                    'aria-hidden' => 'true',
                ], null, true)->render(),
                (new HtmlBuilder())->tag('span', [], Config::SITE_NAME)->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('p', ['class' => 'footer__copy'], '© ' . XegoSpecialConfig::YEAR . ' ' . Config::SITE_NAME . '. Все права защищены.')->render(),
            (new HtmlBuilder())->tag('a', ['href' => XegoSpecialConfig::HOME_URL, 'class' => 'footer__top'], 'На главную')->render(),
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
